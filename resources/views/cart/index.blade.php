<x-guest-layout>
    <div class="cart-page-container w-full min-h-screen px-4 md:px-12 lg:px-20">

        {{-- БЛОК ОШИБОК --}}
        @if(session('error'))
            <div class="mb-8 md:mb-16 p-4 md:p-8">
                <div class="flex items-center">
                    <span class="w-2 h-2 bg-red-500 rounded-full flex-none"></span>
                    <p class="text-red-500 text-xs uppercase font-black tracking-[0.4em] ml-2">
                        Ошибка: {{ session('error') }}
                    </p>
                </div>
            </div>
        @endif

        <div class="mb-10 md:mb-16">
            <h1 class="text-5xl md:text-7xl font-black uppercase tracking-tighter italic text-center custom-logo-font">Корзина</h1>
        </div>

        @if(collect($cart ?? [])->isNotEmpty())
            <div class="flex flex-col lg:flex-row gap-0 border-t border-white/10">
                <div class="w-full lg:w-1/2 border-r border-white/10">
                    @foreach($cart as $key => $details)
                        <div class="flex flex-col sm:flex-row gap-8 py-6 md:py-12 border-b border-white/10 md:pr-8 group">
                            <div class="w-full sm:w-40 md:w-56 aspect-[3/4] flex-none bg-zinc-900/50">
                                @if(isset($details['image']))
                                    <img src="{{ asset('storage/' . $details['image']) }}" class="w-full h-full object-cover">
                                @endif
                            </div>

                            <div class="flex flex-col justify-between py-2 w-full gap-4 sm:gap-0">
                                <div class="space-y-4">
                                    <div class="flex justify-between items-start gap-4">
                                        <h2 class="text-2xl md:text-3xl font-black uppercase tracking-tighter italic leading-none custom-logo-font">
                                            {{ $details['title'] ?? 'Без названия' }}
                                        </h2>

                                        {{-- УДАЛЕНИЕ --}}
                                        <form action="{{ route('cart.remove', $details['db_id'] ?? $key) }}" method="POST" class="flex-none">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[12px] uppercase tracking-widest text-white/60 hover:text-white transition custom-logo-font">Удалить</button>
                                        </form>
                                    </div>
                                    <div class="space-y-2 text-[11px] uppercase tracking-[0.2em] text-white/60 font-bold">
                                        <p class="custom-logo-font">Размер: <span class="text-white custom-logo-font">{{ $details['size'] ?? '-' }}</span></p>
                                        <p class="custom-logo-font">Кол-во: <span class="text-white custom-logo-font">{{ $details['quantity'] ?? 1 }}</span></p>
                                    </div>
                                </div>
                                <div class="text-3xl font-light tracking-tighter italic text-white/90 custom-logo-font">
                                    {{ number_format($details['price'] ?? 0, 0, '.', ' ') }} р
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="w-full lg:w-1/2 pt-12 lg:pt-0 lg:pl-12 py-12 flex flex-col justify-end min-h-[250px] md:min-h-[400px]">
                    <div class="space-y-8 md:space-y-10">
                        <div class="space-y-2">
                            <span class="text-[10px] uppercase tracking-[0.5em] text-white/40 custom-logo-font">Итого к оплате</span>
                            <div class="text-5xl md:text-7xl font-black italic tracking-tighter leading-none custom-logo-font">
                                {{ number_format(collect($cart ?? [])->sum(fn($item) => ($item['price'] ?? 0) * ($item['quantity'] ?? 1)), 0, '.', ' ') }} р
                            </div>
                        </div>

                        <a href="{{ route('cart.checkout') }}"
                           class="custom-logo-font block text-center w-full py-6 md:py-8 bg-white text-black font-black uppercase tracking-[0.6em] text-sm hover:bg-zinc-200 transition-all duration-300">
                            Оформить заказ
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="py-16 md:py-20 border-t border-white/10 text-center sm:text-left">
                <p class="text-white/20 uppercase tracking-[0.5em] text-xs">Ваша корзина пуста</p>
                <a href="/" class="inline-block mt-8 md:mt-10 text-[10px] uppercase tracking-[0.4em] border-b border-white/20 hover:border-white transition">Вернуться в каталог</a>
            </div>
        @endif
    </div>

    <style>
        /* На мобилках небольшой отступ */
        .cart-page-container {
            margin-top: 100px !important;
        }

        /* На компах и планшетах (от 768px) двигаем конкретно вниз */
        @media (min-width: 768px) {
            .cart-page-container {
                margin-top: 180px !important;
            }
        }
    </style>
</x-guest-layout>
