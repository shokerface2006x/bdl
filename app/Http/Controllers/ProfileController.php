<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Order; // ВОТ ЭТОГО НЕ ХВАТАЛО

class ProfileController extends Controller
{
    /**
     * Отображение списка заказов пользователя (Главная страница профиля)
     */
    public function index(): View
    {
        // Берем заказы залогиненного пользователя, новые сверху
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.index', [
            'orders' => $orders
        ]);
    }

    /**
     * Отображение формы редактирования профиля
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Обновление данных профиля
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Удаление аккаунта
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


    public function showOrder($id)
    {
        // Ищем заказ, который принадлежит именно текущему юзеру
        $order = Order::where('user_id', auth()->id())->findOrFail($id);

        return view('profile.order-show', compact('order'));
    }


}
