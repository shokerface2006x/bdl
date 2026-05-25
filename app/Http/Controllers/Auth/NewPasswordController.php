<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    public function store(Request $request): RedirectResponse
    {
        // Строгая валидация токена и пароля
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'], // оставляем для корректной работы брокера
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'max:255',
                Rules\Password::defaults()->mixedCase()->numbers() // Большие/маленькие буквы + цифры
            ],
        ], [
            // Кастомные сообщения об ошибках
            'password.required'  => 'ПРИДУМАЙТЕ ПАРОЛЬ.',
            'password.min'       => 'ПАРОЛЬ ДОЛЖЕН БЫТЬ МИНИМУМ 8 СИМВОЛОВ.',
            'password.max'       => 'ПАРОЛЬ СЛИШКОМ ДЛИННЫЙ (МАКСИМУМ 255 СИМВОЛОВ).',
            'password.confirmed' => 'ПАРОЛИ НЕ СОВПАДАЮТ.',
            'password.mixed'     => 'ПАРОЛЬ ДОЛЖЕН СОДЕРЖАТЬ МИНИМУМ ОДНУ ЗАГЛАВНУЮ И ОДНУ СТРОЧНУЮ БУКВУ.',
            'password.numbers'   => 'ПАРОЛЬ ДОЛЖЕН СОДЕРЖАТЬ ХОТЯ БЫ ОДНУ ЦИФРУ.',
        ]);

        // Сброс пароля через встроенный брокер Laravel
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // Если всё ок — кидаем на логин, если ошибка брокера — возвращаем назад
        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'ПАРОЛЬ УСПЕШНО ИЗМЕНЕН. ВОЙДИТЕ.')
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => 'ОШИБКА СБРОСА ПАРОЛЯ. ССЫЛКА УСТАРЕЛА ИЛИ НЕВЕРНА.']);
    }
}
