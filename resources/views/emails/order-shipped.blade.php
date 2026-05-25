<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; }
        .track-box { background: #f9f9f9; padding: 15px; border-left: 4px solid #000; margin: 20px 0; }
        .btn { display: inline-block; padding: 10px 20px; background: #000; color: #fff; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <h2>Привет, {{ $order->full_name }}!</h2>
    <p>Хорошие новости: твой заказ **#{{ $order->id }}** отправлен!</p>

    <div class="track-box">
        <p style="margin: 0; font-size: 12px; text-transform: uppercase;">Трек-номер для отслеживания:</p>
        <p style="margin: 5px 0 0 0; font-size: 20px; font-weight: bold; letter-spacing: 1px;">
            {{ $order->tracking_number }}
        </p>
    </div>

    <p>Теперь ты можешь отслеживать посылку на сайте почтовой службы.</p>

    <p>Спасибо, что заглянул к нам!</p>
</div>
</body>
</html>
