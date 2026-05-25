<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $order; // Сюда мы передадим данные заказа

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Ваш заказ в BLUEDAY\'SLIPS оформлен!')
            ->view('emails.order-confirmed');
    }
}
