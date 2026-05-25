<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $oldStatus = $order->status;

        $request->validate([
            'status' => 'required|in:new,processing,sent,completed,cancelled',
            'tracking_number' => 'nullable|string|max:255'
        ]);

        $order->update([
            'status' => $request->status,
            'tracking_number' => $request->tracking_number
        ]);

        // Если статус реально изменился, отправляем уведомления
        if ($oldStatus !== $order->status) {
            try {
                if ($order->status === 'sent' && $order->tracking_number) {
                    // Твоё готовое письмо для отправки с треком
                    Mail::to($order->email)->send(new OrderShipped($order));
                }
                elseif (in_array($order->status, ['processing', 'completed', 'cancelled'])) {
                    // Универсальное письмо для остальных статусов (без создания новых классов)
                    $this->sendUniversalStatusMail($order);
                }
            } catch (\Exception $e) {
                Log::error("Ошибка отправки почты для заказа #{$order->id}: " . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'ДАННЫЕ ЗАКАЗА ОБНОВЛЕНЫ!');
    }

    /**
     * Быстрая отправка уведомления без создания лишних классов Mail
     */
    private function sendUniversalStatusMail($order)
    {
        $subjects = [
            'processing' => 'Ваш заказ в работе! — ' . config('app.name'),
            'completed'  => 'Заказ выполнен! — ' . config('app.name'),
            'cancelled'  => 'Обновление по вашему заказу — ' . config('app.name'),
        ];

        $messages = [
            'processing' => "Привет! Мы начали собирать ваш заказ #{$order->id}. Скоро отправим!",
            'completed'  => "Ваш заказ #{$order->id} успешно доставлен. Спасибо, что выбрали нас!",
            'cancelled'  => "К сожалению, ваш заказ #{$order->id} был отменен. Если возникли вопросы — напишите нам.",
        ];

        $status = $order->status;

        Mail::send([], [], function ($message) use ($order, $subjects, $messages, $status) {
            $message->to($order->email)
                ->subject($subjects[$status] ?? 'Обновление статуса заказа')
                ->html("<h2>Привет, {$order->full_name}!</h2><p>{$messages[$status]}</p><br><p>С уважением, " . config('app.name') . "</p>");
        });
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->back()->with('success', 'Заказ удален из системы');
    }
}
