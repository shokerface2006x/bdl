<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmed;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->has_sizes) {
            $request->validate([
                'size' => 'required'
            ], [
                'size.required' => 'ВЫБЕРИТЕ РАЗМЕР'
            ]);
        }

        $selectedSize = $request->input('size', 'ONESIZE');

        if (Auth::check()) {
            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('product_id', $id)
                ->where('size', $selectedSize)
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity');
            } else {
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $id,
                    'size' => $selectedSize,
                    'quantity' => 1
                ]);
            }
        } else {
            $cart = session()->get('cart', []);
            $cartKey = $id . '_' . $selectedSize;

            if(isset($cart[$cartKey])) {
                $cart[$cartKey]['quantity']++;
            } else {
                $cart[$cartKey] = [
                    "id" => $product->id,
                    "title" => $product->title,
                    "quantity" => 1,
                    "price" => $product->price,
                    "size" => $selectedSize,
                    "image" => $product->image
                ];
            }
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'ТОВАР ДОБАВЛЕН!');
    }

    public function index()
    {
        if (Auth::check()) {
            $dbItems = CartItem::where('user_id', Auth::id())->with('product')->get();
            $cart = [];
            foreach ($dbItems as $item) {
                $cart[$item->id] = [
                    "id" => $item->product_id,
                    "db_id" => $item->id,
                    "title" => $item->product->title,
                    "quantity" => $item->quantity,
                    "price" => $item->product->price,
                    "size" => $item->size,
                    "image" => $item->product->image
                ];
            }
        } else {
            $cart = session()->get('cart', []);
        }

        return view('cart.index', compact('cart'));
    }

    public function remove($id)
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())
                ->where('id', $id)
                ->orWhere(function($q) use ($id) {
                    $q->where('user_id', Auth::id())->where('product_id', $id);
                })->delete();
        }

        $cart = session()->get('cart');
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'УДАЛЕНО');
    }

    public function checkout()
    {
        $cart = $this->getCurrentCart();

        if (empty($cart)) {
            if (session()->has('last_order_id')) {
                return redirect()->route('cart.success');
            }
            return redirect()->route('cart.index')->with('error', 'КОРЗИНА ПУСТА');
        }

        return view('cart.checkout', compact('cart'));
    }

    public function storeOrder(Request $request)
    {
        $lockKey = 'order_lock_' . (Auth::id() ?? session()->getId());

        if (Cache::has($lockKey)) {
            return redirect()->route('cart.success');
        }

        Cache::put($lockKey, true, 15);

        $cart = $this->getCurrentCart();

        if (empty($cart)) {
            Cache::forget($lockKey);
            return redirect()->route('cart.index')->with('error', 'КОРЗИНА ПУСТА');
        }

        $request->validate([
            'full_name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^(?:\+7|8)\s\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/'],
            'postcode'  => ['required', 'string', 'min:5', 'max:10'],
            'address'   => ['required', 'string', 'min:10', 'max:500'],
        ], [
            'full_name.required' => 'УКАЖИТЕ ИМЯ И ФАМИЛИЮ',
            'email.required'     => 'УКАЖИТЕ EMAIL',
            'phone.required'     => 'УКАЖИТЕ ТЕЛЕФОН',
            'phone.regex'        => 'НЕВЕРНЫЙ ФОРМАТ НОМЕРА',
            'postcode.required'  => 'УКАЖИТЕ ИНДЕКС',
            'address.required'   => 'УКАЖИТЕ АДРЕС ДОСТАВКИ',
        ]);

        try {
            DB::transaction(function () use ($request, $cart, &$newOrder) {
                $order = Order::create([
                    'user_id'     => Auth::id(),
                    'full_name'   => $request->full_name,
                    'email'       => $request->email,
                    'phone'       => $request->phone,
                    'address'     => "({$request->postcode}) {$request->address}",
                    'total_price' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
                    'status'      => 'new',
                ]);

                foreach ($cart as $details) {
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $details['id'],
                        'size'       => $details['size'],
                        'quantity'   => $details['quantity'],
                        'price'      => $details['price'],
                    ]);

                    // СПИСЫВАЕМ ТОВАР СО СКЛАДА
                    Product::where('id', $details['id'])->decrement('stock', $details['quantity']);
                }

                if (Auth::check()) {
                    CartItem::where('user_id', Auth::id())->delete();
                }
                session()->forget('cart');
                session()->put('last_order_id', $order->id);

                $newOrder = $order->load('items.product');
            });

            if ($newOrder) {
                $this->sendTelegramNotification($newOrder);
                try {
                    Mail::to($newOrder->email)->send(new OrderConfirmed($newOrder));
                } catch (\Exception $e) {
                    Log::error("Mail Sending Error: " . $e->getMessage());
                }
            }

        } catch (\Exception $e) {
            Cache::forget($lockKey);
            Log::error("Order Store Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'ЧТО-ТО ПОШЛО НЕ ТАК');
        }

        return redirect()->route('cart.success');
    }

    private function getCurrentCart()
    {
        if (Auth::check()) {
            $dbItems = CartItem::where('user_id', Auth::id())->with('product')->get();
            return $dbItems->mapWithKeys(function ($item) {
                return [$item->id => [
                    "id" => $item->product_id,
                    "title" => $item->product->title,
                    "quantity" => $item->quantity,
                    "price" => $item->product->price,
                    "size" => $item->size,
                    "image" => $item->product->image
                ]];
            })->toArray();
        }
        return session()->get('cart', []);
    }

    public function success()
    {
        session()->forget('last_order_id');
        return view('cart.success');
    }

    private function sendTelegramNotification($order)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');
        if (!$token || !$chatId) return;

        $text = "🚀 **НОВЫЙ ЗАКАЗ #{$order->id}**\n\n";
        $text .= "👤 Клиент: {$order->full_name}\n";
        $text .= "💰 Сумма: " . number_format($order->total_price, 0, '.', ' ') . " ₽\n";
        $text .= "📍 Адрес: {$order->address}\n";

        try {
            Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'Markdown',
            ]);
        } catch (\Exception $e) {
            Log::error("Telegram Notification Error: " . $e->getMessage());
        }
    }
}
