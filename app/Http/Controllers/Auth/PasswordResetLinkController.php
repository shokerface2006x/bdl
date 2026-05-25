<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Строгая валидация: обязательное поле, формат email и проверка наличия в таблице users
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'ПОЛЕ ПОЧТЫ НЕ МОЖЕТ БЫТЬ ПУСТЫМ',
            'email.email' => 'ВВЕДИТЕ КОРРЕКТНЫЙ АДРЕС ЭЛЕКТРОННОЙ ПОЧТЫ',
            'email.exists' => 'ПОЛЬЗОВАТЕЛЬ С ТАКОЙ ПОЧТОЙ НЕ ЗАРЕГИСТРИРОВАН',
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }
}
