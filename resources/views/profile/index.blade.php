<x-guest-layout>
    <div class="max-w-7xl mx-auto py-20 px-6">
        <div class="mb-12">
            <h1 class="text-4xl font-black uppercase italic text-white custom-logo-font">ЛИЧНЫЙ КАБИНЕТ</h1>
            <p class="text-white/40 uppercase text-[10px] tracking-widest mt-2">Пользователь: {{ auth()->user()->name }} / {{ auth()->user()->email }}</p>
        </div>

        <h2 class="text-xl font-bold uppercase italic text-white mb-6 custom-logo-font">ИСТОРИЯ ЗАКАЗОВ</h2>

        @if($orders->isEmpty())
            <div class="border border-white/10 p-10 text-center">
                <p class="text-white/20 uppercase tracking-widest text-sm custom-logo-font">У вас пока нет заказов</p>
                <a href="/" class="inline-block mt-4 text-white border-b border-white hover:text-white/60 transition text-[10px] uppercase font-bold ">Перейти к покупкам</a>
            </div>
        @else
            <div class="grid gap-6">
                @foreach($orders as $order)
                    <div class="border border-white/10 p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 hover:bg-white/[0.02] transition">
                        <div>
                            <div class="flex items-center gap-4 mb-2">
                                <span class="text-lg font-mono font-bold text-white">#{{ $order->id }}</span>

                                {{-- ТУТ ЗАМЕНИЛИ status НА status_text --}}
                                <span class="px-3 py-1 text-[9px] uppercase font-bold tracking-widest border
                                    {{ $order->status == 'new' ? 'border-white text-white animate-pulse' : '' }}
                                    {{ $order->status == 'processing' ? 'border-yellow-500 text-yellow-500' : '' }}
                                    {{ $order->status == 'sent' ? 'border-blue-500 text-blue-500' : '' }}
                                    {{ $order->status == 'completed' ? 'border-green-500 text-green-500' : '' }}
                                    {{ $order->status == 'cancelled' ? 'border-red-500 text-white/20' : '' }}">
                                    {{ $order->status_text }}
                                </span>
                            </div>
                            <p class="text-[12px] text-white/40 uppercase tracking-widest ">Дата: {{ $order->created_at->format('d.m.Y H:i') }}</p>
                        </div>

                        <div class="text-left md:text-right">
                            <p class="custom-logo-font text-lg font-mono text-white mb-1">{{ number_format($order->total_price, 0, '.', ' ') }} руб</p>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('logout') }}" class="mt-12">
            @csrf
            <button type="submit" class="custom-logo-font text-[15px] uppercase font-bold text-red-500/60 hover:text-red-500 transition tracking-widest">
                ВЫЙТИ ИЗ АККАУНТА
            </button>
        </form>
    </div>
</x-guest-layout>
