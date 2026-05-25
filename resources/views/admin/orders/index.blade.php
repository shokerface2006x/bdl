<x-guest-layout>
    <div class="max-w-7xl mx-auto py-20 px-6">

        {{-- Уведомления --}}
        @if(session('success'))
            <div class="mb-10 p-4 border border-green-500 bg-green-500/10 text-green-500 text-[10px] uppercase font-bold tracking-[0.2em]">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-10">
            <h1 class="text-4xl font-black uppercase italic text-white">СПИСОК ЗАКАЗОВ</h1>

            {{-- Та самая кнопка НАЗАД --}}
            <a href="{{ route('admin.products.index') }}" class="border border-white/20 text-white px-6 py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-white hover:text-black transition">
                ← НАЗАД К ТОВАРАМ
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                <tr class="border-b border-white/10 text-[10px] uppercase tracking-[0.3em] text-white/40">
                    <th class="py-4">ID</th>
                    <th class="py-4">ЗАКАЗЧИК</th>
                    <th class="py-4">СТАТУС</th>
                    <th class="py-4">СУММА</th>
                    <th class="py-4">ДАТА</th>
                    <th class="py-4 text-right">ДЕЙСТВИЯ</th>
                </tr>
                </thead>
                <tbody class="text-white text-sm">
                @foreach($orders as $order)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition">
                        <td class="py-6 font-mono text-white/50">#{{ $order->id }}</td>
                        <td class="py-6">
                            <div class="font-bold uppercase tracking-tight">{{ $order->full_name }}</div>
                            <div class="text-[10px] text-white/40">{{ $order->email }}</div>
                        </td>
                        <td class="py-6">
    <span class="px-3 py-1 text-[9px] uppercase font-bold tracking-widest border
        {{ $order->status == 'new' ? 'border-white text-white animate-pulse' : '' }}
        {{ $order->status == 'processing' ? 'border-yellow-500 text-yellow-500' : '' }}
        {{ $order->status == 'sent' ? 'border-blue-500 text-blue-500' : '' }}
        {{ $order->status == 'completed' ? 'border-green-500 text-green-500' : '' }}
        {{ $order->status == 'cancelled' ? 'border-red-500 text-white/20' : '' }}">

        {{-- Перевод статуса для вывода на экран --}}
        @switch($order->status)
            @case('new') новый @break
            @case('processing') в обработке @break
            @case('sent') отправлен @break
            @case('completed') выполнен @break
            @case('cancelled') отменен @break
            @default {{ $order->status }}
        @endswitch
    </span>
                        </td>

                        <td class="py-6 font-mono text-lg italic">{{ number_format($order->total_price, 0, '.', ' ') }} Р</td>
                        <td class="py-6 text-white/40 text-[11px]">{{ $order->created_at->format('d.m.Y H:i') }}</td>

                        <td class="py-6 text-right flex justify-end gap-6 items-center">
                            {{-- ДЕТАЛИ --}}
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-[10px] uppercase font-bold tracking-widest hover:underline decoration-red-500 decoration-2 underline-offset-4">
                                ДЕТАЛИ
                            </a>

                            {{-- УДАЛЕНИЕ --}}
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('УДАЛИТЬ ЗАКАЗ НАВСЕГДА?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[10px] uppercase font-bold text-red-500/40 hover:text-red-500 transition duration-300">
                                    УДАЛИТЬ
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @if($orders->isEmpty())
            <div class="py-20 text-center border border-white/5 bg-white/[0.02]">
                <p class="text-white/20 uppercase tracking-[0.5em] text-xs font-bold">Заказов пока нет</p>
            </div>
        @endif
    </div>
</x-guest-layout>
