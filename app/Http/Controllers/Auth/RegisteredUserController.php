<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Вывод страницы регистрации
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Обработка запроса на регистрацию
     */
    public function store(Request $request): RedirectResponse
    {
        // Валидация только тех полей, которые реально есть в форме
        $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'min:8',  'max:255', Rules\Password::defaults()->mixedCase()->numbers()],
        ], [
            // Понятные ошибки на русском
            'name.max' => 'Имя не может быть длиннее 255 символов.',
            'email.email' => 'Введите корректный адрес почты.',
            'email.required' => 'Почта необходима для регистрации.',
            'email.unique' => 'Эта почта уже занята.',
            'password.required' => 'Придумайте пароль.',
            'password.min' => 'Пароль должен быть минимум 8 символов.',
            'password.max' => 'Пароль слишком длинный (максимум 255 символов).',
            'password.confirmed' => 'Пароли не совпадают.',
        ]);

        // Создание пользователя без телефона
        $user = User::create([
            // Если имя не введено, запишется null
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Редирект на главную после успешного входа
        return redirect('/');
    }
}
