<x-guest-layout>
    <style>
        [x-cloak] { display: none !important; }

        input:-webkit-autofill,
        textarea:-webkit-autofill {
            transition: background-color 5000s ease-in-out 0s;
            -webkit-text-fill-color: white !important;
            -webkit-box-shadow: 0 0 0px 1000px rgba(0, 0, 0, 0) inset !important;
        }

        input:focus, textarea:focus {
            outline: none !important;
            box-shadow: none !important;
            background-color: transparent !important;
            border-color: white !important;
        }

        .is-invalid {
            border-color: #ef4444 !important;
            border-width: 1px !important;
            box-shadow: 0 0 5px rgba(239, 68, 68, 0.3) !important;
        }

        .error-text {
            color: #ef4444 !important;
            font-family: 'LC Chalk', sans-serif !important;
        }
    </style>

    <div class="w-full min-h-screen pt-32 px-6 md:px-12 lg:px-20">
        <div class="mb-16">
            <h1 class="text-5xl md:text-7xl font-black uppercase tracking-tighter italic custom-logo-font text-center">ОФОРМЛЕНИЕ ЗАКАЗА</h1>
        </div>

        <form id="order-form" action="{{ route('cart.order.store') }}" method="POST"
              class="flex flex-col lg:flex-row gap-0 border-t border-white/10" novalidate>
            @csrf

            <div class="w-full lg:w-1/2 border-r border-white/10 py-12 pr-0 lg:pr-20 space-y-12">
                <div class="space-y-8">
                    <h2 class="text-[14px] uppercase tracking-[0.5em] text-white/100 custom-logo-font">Контактные данные</h2>
                    <div class="space-y-6">
                        <div>
                            <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="ИМЯ И ФАМИЛИЯ" required
                                   class="w-full bg-transparent border px-4 py-4 outline-none transition tracking-widest text-sm {{ $errors->has('full_name') ? 'is-invalid border-red-600' : 'border-white/10' }}">
                            @error('full_name')
                            <p class="mt-2 error-text text-[10px] font-bold tracking-tighter">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="EMAIL" required
                                   class="w-full bg-transparent border px-4 py-4 outline-none transition tracking-widest text-sm {{ $errors->has('email') ? 'is-invalid border-red-600' : 'border-white/10' }}">
                            @error('email')
                            <p class="mt-2 error-text text-[10px] font-bold tracking-tighter">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <input type="tel" id="phone-mask" name="phone" value="{{ old('phone') }}" placeholder="ТЕЛЕФОН" required
                                       class="w-full bg-transparent border px-4 py-4 outline-none transition tracking-widest text-sm {{ $errors->has('phone') ? 'is-invalid border-red-600' : 'border-white/10' }}">
                                @error('phone')
                                <p class="mt-2 error-text text-[10px] font-bold tracking-tighter">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <input type="text" name="postcode" value="{{ old('postcode') }}" placeholder="ИНДЕКС" required
                                       class="w-full bg-transparent border px-4 py-4 outline-none transition tracking-widest text-sm {{ $errors->has('postcode') ? 'is-invalid border-red-600' : 'border-white/10' }}">
                                @error('postcode')
                                <p class="mt-2 error-text text-[10px] uppercase font-bold tracking-tighter">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    <h2 class="text-[14px] tracking-[0.5em] text-white/100 uppercase custom-logo-font">Адрес доставки</h2>
                    <div>
                        <textarea name="address" placeholder="ГОРОД, УЛИЦА, ДОМ, КВАРТИРА" required rows="3"
                                  class="w-full bg-transparent border px-4 py-4 outline-none transition tracking-widest text-sm resize-none {{ $errors->has('address') ? 'is-invalid border-red-600' : 'border-white/10' }}">{{ old('address') }}</textarea>
                        @error('address')
                        <p class="mt-2 error-text text-[10px] uppercase font-bold tracking-tighter">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-10">
                    <p class="text-[9px] text-white/30 uppercase tracking-widest leading-relaxed">
                        Нажимая кнопку "Подтвердить", вы соглашаетесь с условиями оферты и политикой конфиденциальности.
                    </p>
                </div>
            </div>

            <div class="w-full lg:w-1/2 lg:pl-20 py-12 flex flex-col justify-between">
                <div class="hidden lg:block space-y-6">
                    <h2 class="text-[14px] uppercase tracking-[0.5em] text-white/100 mb-10 custom-logo-font">Ваш заказ</h2>
                    @foreach($cart as $item)
                        <div class="flex justify-between items-center text-sm uppercase tracking-widest border-b border-white/5 pb-4 custom-logo-font">
                            <span class="text-white/60">{{ $item['title'] }} ({{ $item['size'] }}) x{{ $item['quantity'] }}</span>
                            <span>{{ number_format($item['price'] * $item['quantity'], 0, '.', ' ') }} ₽</span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-20 lg:mt-0 space-y-10">
                    <div class="space-y-2">
                        <div class="custom-logo-font text-6xl md:text-8xl font-black italic tracking-tighter leading-none">
                            {{ number_format(collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']), 0, '.', ' ') }} ₽
                        </div>
                    </div>

                    <div class="relative min-h-[80px]">
                        <button type="submit" id="submit-btn"
                                class="custom-logo-font w-full py-8 bg-white text-black font-black uppercase tracking-[0.6em] text-sm hover:bg-zinc-200 transition-all duration-300 shadow-2xl">
                            Подтвердить заказ
                        </button>

                        <div id="loader" style="display: none;"
                             class="w-full py-8 border border-white/20 flex items-center justify-center space-x-3 text-white uppercase tracking-[0.4em] text-sm italic">
                            <span class="animate-pulse">ОФОРМЛЯЕМ ЗАКАЗ...</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://unpkg.com/imask"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Маска телефона
            const phoneInput = document.getElementById('phone-mask');
            if (phoneInput) {
                IMask(phoneInput, { mask: '+{7} (000) 000-00-00' });
            }

            // ЖЕСТКАЯ БЛОКИРОВКА КНОПКИ
            const form = document.getElementById('order-form');
            const btn = document.getElementById('submit-btn');
            const loader = document.getElementById('loader');

            form.addEventListener('submit', function() {
                // Прячем кнопку мгновенно
                btn.style.display = 'none';
                // Показываем лоадер
                loader.style.display = 'flex';

                // Если вдруг есть ошибки валидации (форма не отправится реально),
                // вернем кнопку через 3 секунды, чтобы можно было исправить
                setTimeout(() => {
                    if (document.querySelectorAll('.is-invalid').length > 0) {
                        btn.style.display = 'block';
                        loader.style.display = 'none';
                    }
                }, 3000);
            });
        });
    </script>
</x-guest-layout>
