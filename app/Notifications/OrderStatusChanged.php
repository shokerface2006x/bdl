<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChanged extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Словарь заголовков и текстов
        $messages = [
            'processing' => [
                'subject' => 'Ваш заказ в работе!',
                'line' => 'Мы начали собирать ваш заказ. Скоро отправим!',
            ],
            'completed' => [
                'subject' => 'Заказ выполнен!',
                'line' => 'Ваш заказ успешно доставлен. Спасибо, что вы с нами!',
            ],
            'cancelled' => [
                'subject' => 'Обновление по заказу',
                'line' => 'К сожалению, ваш заказ был отменен.',
            ],
        ];

        $status = $this->order->status;
        $content = $messages[$status] ?? [
            'subject' => 'Обновление статуса заказа',
            'line' => 'Статус вашего заказа изменился на: ' . $status,
        ];

        return (new MailMessage)
            ->subject($content['subject'] . ' (#' . $this->order->id . ')')
            ->greeting('Привет, ' . $this->order->full_name . '!')
            ->line($content['line'])
            ->action('Посмотреть заказ', url('/orders/' . $this->order->id))
            ->line('Спасибо за доверие!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
