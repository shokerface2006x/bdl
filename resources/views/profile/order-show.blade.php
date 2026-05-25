<x-guest-layout>
    <div class="max-w-7xl mx-auto py-20 px-6">
        <a href="{{ route('profile.index') }}" class="text-white/40 uppercase text-[10px] font-bold">← Назад в профиль</a>
        <h1 class="text-4xl font-black uppercase italic text-white mt-4">ЗАКАЗ #{{ $order->id }}</h1>
        <p class="text-white mt-4">Статус: {{ $order->status }}</p>
        <p class="text-white">Сумма: {{ number_format($order->total_price, 0, '.', ' ') }} RUB</p>
    </div>
</x-guest-layout>
