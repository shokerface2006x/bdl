<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use App\Models\CartItem; // Не забудь импортировать модель!

class AuthenticatedSessionController extends Controller
{
    /**
     * Вывод страницы входа
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Обработка запроса на вход
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Валидация входных данных
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Неверная почта или пароль.',
            'email.email' => 'Неверная почта или пароль.',
            'password.required' => 'Неверная почта или пароль.',
        ]);

        // 2. Попытка входа
        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Неверная почта или пароль.',
            ]);
        }

        // --- ЛОГИКА ПЕРЕНОСА КОРЗИНЫ ---
        // Проверяем, есть ли товары в сессии у гостя
        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');

            foreach ($cart as $productId => $details) {
                // Ищем, есть ли уже такой товар в базе у этого юзера
                $cartItem = CartItem::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->first();

                if ($cartItem) {
                    // Если есть — обновляем количество
                    $cartItem->update([
                        'quantity' => $cartItem->quantity + $details['quantity']
                    ]);
                } else {
                    // Если нет — создаем новую запись
                    CartItem::create([
                        'user_id' => Auth::id(),
                        'product_id' => $productId,
                        'quantity' => $details['quantity']
                    ]);
                }
            }

            // Очищаем временную корзину из сессии, так как она теперь в БД
            $request->session()->forget('cart');
        }
        // ------------------------------

        // 3. Регенерация сессии для защиты от атак
        $request->session()->regenerate();

        // 4. Редирект
        return redirect()->intended('/');
    }

    /**
     * Выход из системы
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
