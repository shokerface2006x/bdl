<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    // Сюда мы передадим заказ
    public $order;

    /**
     * Создаем новый экземпляр письма
     */
    public function __construct($order)
    {
        // Присваиваем полученный заказ переменной класса
        $this->order = $order;
    }

    /**
     * Собираем само письмо
     */
    public function build()
    {
        return $this->subject('Твой заказ отправлен! 📦') // Тема письма
        ->view('emails.order-shipped');     // Какой шаблон оформления использовать
    }
}
