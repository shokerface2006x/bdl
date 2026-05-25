<div style="background-color: #000; color: #fff; padding: 30px; font-family: sans-serif; max-width: 600px; margin: 0 auto;">
    <h1 style="text-align: center; color: #fff; text-transform: uppercase; letter-spacing: 2px;">
        BLUEDAY'SLIPS
    </h1>

    <div style="border: 1px solid #333; padding: 20px; margin-top: 20px;">
        <h2 style="font-size: 18px;">СПАСИБО ЗА ЗАКАЗ!</h2>
        <p>Номер заказа: <span style="color: #ccc;">#{{ $order->id }}</span></p>
        <p>Мы получили ваш заказ и уже начали его обрабатывать. Скоро мы свяжемся с вами по номеру телефона.</p>

        <hr style="border: 0; border-top: 1px solid #333; margin: 20px 0;">

        <p style="font-size: 14px; color: #888;">Итоговая сумма:
            <span style="color: #fff; font-size: 18px; font-weight: bold;">
                {{ number_format($order->total_price, 0, '.', ' ') }} ₽
            </span>
        </p>
    </div>

    <p style="text-align: center; font-size: 12px; color: #555; margin-top: 30px;">
        © 2026 BLUEDAY'SLIPS. Все права защищены.
    </p>
</div>
