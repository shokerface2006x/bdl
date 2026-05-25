<x-guest-layout>
    <div class="w-full min-h-screen py-20 px-10 text-white font-sans">

        <div class="mb-16">
            <a href="{{ route('admin.orders.index') }}" class="text-[10px] uppercase tracking-[0.4em] text-white/40 hover:text-white transition">
                ← ВЕРНУТЬСЯ К ЗАКАЗАМ
            </a>
            <h1 class="text-6xl font-black uppercase italic mt-6 tracking-tighter">
                Order #{{ $order->id }}
            </h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-20">

            <div class="lg:col-span-2">
                <h2 class="text-[10px] uppercase tracking-[0.5em] text-white/30 mb-10 font-bold">ТОВАРЫ:</h2>

                @foreach($order->items as $item)
                    <div class="flex items-center justify-between border-b border-white/10 py-8 group">
                        <div class="flex items-center gap-8">
                            <div class="w-24 h-32 bg-zinc-900 overflow-hidden">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                                @endif
                            </div>

                            <div>
                                <div class="text-xl font-black uppercase italic">{{ $item->product->title }}</div>
                                <div class="text-[10px] uppercase tracking-widest text-white/40 mt-2">
                                    Size: <span class="text-white font-bold">{{ $item->size }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <div class="text-lg font-mono">{{ $item->quantity }} x {{ number_format($item->price, 0, '.', ' ') }}</div>
                            <div class="text-[10px] uppercase tracking-widest text-white/40">КОЛИЧЕСТВО И ЦЕНА</div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-10 text-right">
                    <div class="text-[10px] uppercase tracking-[0.5em] text-white/30">ИТОГО ЗА ТОВАР</div>
                    <div class="text-5xl font-black italic mt-2">{{ number_format($order->total_price, 0, '.', ' ') }} RUB</div>
                </div>
            </div>

            {{-- ПРАВАЯ КОЛОНКА --}}
            <div class="p-10 border border-white/5 h-fit bg-white/[0.02] backdrop-blur-sm">
                <h2 class="text-[10px] uppercase tracking-[0.5em] text-white/30 mb-8 font-bold">ИНФОРМАЦИЯ О ЗАКАЗЧИКЕ</h2>

                <div class="space-y-8">
                    <div>
                        <div class="text-[9px] uppercase text-white/20 tracking-widest mb-1">ИМЯ</div>
                        <div class="text-lg font-bold uppercase tracking-wider">{{ $order->full_name }}</div>
                    </div>

                    <div>
                        <div class="text-[9px] uppercase text-white/20 tracking-widest mb-1">ПОЧТА</div>
                        <div class="text-lg font-mono">{{ $order->email }}</div>
                    </div>

                    <div>
                        <div class="text-[9px] uppercase text-white/20 tracking-widest mb-1">ЗАКАЗ РАЗМЕЩЁН</div>
                        <div class="text-lg">{{ $order->created_at->format('d F Y') }}</div>
                        <div class="text-xs text-white/30 font-mono">{{ $order->created_at->format('H:i:s') }}</div>
                    </div>
                </div>

                {{-- УПРАВЛЕНИЕ ЗАКАЗОМ --}}
                <div class="mt-12 pt-10 border-t border-white/10">
                    <h2 class="text-[10px] uppercase tracking-[0.5em] text-white/30 mb-6 font-bold">УПРАВЛЕНИЕ ЗАКАЗОМ</h2>

                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        {{-- Выбор статуса --}}
                        <div class="space-y-2">
                            <div class="text-[9px] uppercase text-white/20 tracking-widest">СТАТУС</div>
                            <div class="relative">
                                <select name="status"
                                        class="w-full bg-black border border-white/20 text-white text-[11px] uppercase font-bold p-4 focus:border-white transition outline-none appearance-none cursor-pointer tracking-widest">
                                    <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>● New Order</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>● Processing</option>
                                    <option value="sent" {{ $order->status == 'sent' ? 'selected' : '' }}>● Sent / In Delivery</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>● Completed</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>● Cancelled</option>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-white/40 text-[8px]">▼</div>
                            </div>
                        </div>

                        {{-- Поле для трек-номера --}}
                        <div class="space-y-2">
                            <div class="text-[9px] uppercase text-white/20 tracking-widest">ТРЕК-НОМЕР</div>
                            <input type="text" name="tracking_number" value="{{ $order->tracking_number }}"
                                   placeholder="ВВЕДИТЕ ТРЕК-НОМЕР"
                                   class="w-full bg-transparent border border-white/20 text-white text-[11px] font-bold p-4 focus:border-white transition outline-none tracking-widest">
                        </div>

                        <button type="submit" class="w-full py-4 bg-white text-black text-[10px] font-black uppercase tracking-[0.3em] hover:bg-zinc-200 transition duration-300">
                            ОБНОВИТЬ СТАТУС ЗАКАЗА
                        </button>
                    </form>

                    @if(session('success'))
                        <div class="mt-4 text-[10px] uppercase font-bold text-green-500 tracking-widest animate-pulse">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>
