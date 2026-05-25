<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Кастомизация письма сброса пароля
        ResetPassword::toMailUsing(function ($notifiable, $token) {
            return (new MailMessage)
                ->subject('Сброс пароля — ' . config('app.name'))
                ->greeting('Привет!')
                ->line('Вы получили это письмо, потому что мы получили запрос на сброс пароля для вашей учетной записи.')
                ->action('Сбросить пароль', url(config('app.url').route('password.reset', [
                        'token' => $token,
                        'email' => $notifiable->getEmailForPasswordReset(),
                    ], false)))
                ->line('Эта ссылка на сброс пароля истечет через 60 минут.')
                ->line('Если вы не запрашивали сброс пароля, просто проигнорируйте это письмо.')
                ->salutation('С уважением, ' . config('app.name'));
        });
    }
}
