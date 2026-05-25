<x-guest-layout>
    <div class="flex flex-col lg:flex-row min-h-screen w-full">

        <div id="zoom-container"
             class="w-full lg:w-[60%] lg:h-screen lg:sticky lg:top-0 flex items-center justify-center p-4 lg:p-0 bg-[#0a0a0a] relative overflow-hidden cursor-zoom-in">

            {{-- ПЛАШКА ОБ ОГРАНИЧЕННОМ КОЛИЧЕСТВЕ --}}
            @if($product->stock > 0 && $product->stock <= 5)
                <div class="custom-logo-font absolute top-10 left-10 z-20 bg-red-600 text-white text-[10px] font-black uppercase px-4 py-2 tracking-[0.3em] italic animate-pulse">
                    ОСТАЛОСЬ: {{ $product->stock }} ШТ.
                </div>
            @endif

            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}"
                     alt="{{ $product->title }}"
                     id="zoom-image"
                     class="interactive-zoom max-w-full max-h-full lg:w-full lg:h-full object-contain {{ $product->stock <= 0 ? 'opacity-30 grayscale' : '' }}">
            @else
                <div class="text-zinc-800 font-black text-4xl uppercase italic">No Image</div>
            @endif

            {{-- ОВЕРЛЕЙ ЕСЛИ ТОВАРА НЕТ --}}
            @if($product->stock <= 0)
                <div class="absolute inset-0 z-30 flex items-center justify-center">
                    <div class="border-2 border-white px-12 py-6 bg-black/40 backdrop-blur-sm">
                        <span class="text-white font-black uppercase tracking-[1em] text-2xl italic">SOLD OUT</span>
                    </div>
                </div>
            @endif
        </div>

        <div class="w-full lg:w-[40%] flex flex-col justify-center px-6 py-20 md:px-12 lg:px-20 border-l border-white/10">

            <form action="{{ route('cart.add', $product->id) }}" method="POST" id="add-to-cart-form">
                @csrf
                <input type="hidden" name="size" id="selected-size" value="{{ $product->has_sizes ? '' : 'ONESIZE' }}" required>

                <div class="mb-12">
                    <h1 class="custom-logo-font text-4xl md:text-5xl lg:text-6xl font-black uppercase tracking-tighter leading-none mb-6 italic text-white">
                        {{ $product->title }}
                    </h1>
                    <div class="text-2xl font-light tracking-[0.2em] text-white/90 custom-logo-font">
                        {{ number_format($product->price, 0, '.', ' ') }} руб
                    </div>
                </div>

                @if($product->has_sizes)
                    <div class="mb-12">
                        <p class="text-[10px] uppercase tracking-[0.4em] text-white/80 font-bold mb-6 custom-logo-font">Выберите размер</p>
                        <div class="grid grid-cols-4 gap-2">
                            @foreach(['S', 'M', 'L', 'XL'] as $size)
                                <button type="button"
                                        onclick="selectSize('{{ $size }}', this)"
                                        {{ $product->stock <= 0 ? 'disabled' : '' }}
                                        class="size-btn border border-white/10 py-5 text-[11px] font-bold uppercase tracking-widest hover:border-white transition-all duration-300 text-white disabled:opacity-20 disabled:cursor-not-allowed">
                                    {{ $size }}
                                </button>
                            @endforeach
                        </div>
                        @error('size')
                        <p class="text-red-500 text-[10px] mt-4 uppercase tracking-[0.2em] font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                @else
                    <div class="mb-12">
                        <p class="text-[10px] uppercase tracking-[0.4em] text-white/40 font-bold italic custom-logo-font ">Размер: Universal / One Size</p>
                    </div>
                @endif

                <div class="mb-12 py-8 border-y border-white/5">
                    <p class="text-zinc-500 text-xs uppercase leading-relaxed tracking-[0.15em]">
                        {{ $product->description }}
                    </p>
                </div>

                <div class="space-y-6">
                    @if($product->stock > 0)
                        <button type="submit"
                                class="custom-logo-font w-full py-6 bg-white text-black font-black uppercase tracking-[0.5em] text-sm hover:bg-zinc-200 transition-all shadow-[0_0_30px_rgba(255,255,255,0.1)]">
                            ДОБАВИТЬ В КОРЗИНУ
                        </button>
                    @else
                        <button type="button" disabled
                                class="w-full py-6 bg-zinc-900 text-white/20 font-black uppercase tracking-[0.5em] text-sm cursor-not-allowed border border-white/5">
                            НЕТ В НАЛИЧИИ
                        </button>
                    @endif
                </div>
            </form>

        </div>
    </div>

    <style>
        .interactive-zoom {
            transform-origin: center center !important;
            transition: transform 0.3s ease-out !important; /* Небольшая плавность при входе/выходе */
            will-change: transform;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('zoom-container');
            const image = document.getElementById('zoom-image');

            if (!container || !image || image.classList.contains('opacity-30')) return;

            const zoomScale = 2.5; // Сила приближения

            function handleMouseMove(e) {
                const rect = container.getBoundingClientRect();

                // Вычисляем положение курсора относительно центра контейнера (от -0.5 до 0.5)
                const offsetX = (e.clientX - rect.left) / rect.width - 0.5;
                const offsetY = (e.clientY - rect.top) / rect.height - 0.5;

                // Сдвигаем картинку в противоположную сторону от курсора, чтобы рассмотреть нужную часть
                const translateX = -offsetX * rect.width * (zoomScale - 1);
                const translateY = -offsetY * rect.height * (zoomScale - 1);

                // Отключаем transition во время движения мыши, чтобы не было задержки
                image.style.transition = 'none';
                image.style.transform = `translate(${translateX}px, ${translateY}px) scale(${zoomScale})`;
            }

            function handleMouseLeave() {
                // Возвращаем плавный возврат в исходное положение при уходе мыши
                image.style.transition = 'transform 0.4s ease-out';
                image.style.transform = 'translate(0px, 0px) scale(1)';
            }

            container.addEventListener('mousemove', handleMouseMove);
            container.addEventListener('mouseleave', handleMouseLeave);
        });

        function selectSize(size, element) {
            document.getElementById('selected-size').value = size;

            document.querySelectorAll('.size-btn').forEach(btn => {
                btn.classList.remove('bg-white', 'text-black');
                btn.classList.add('text-white');
            });

            element.classList.add('bg-white', 'text-black');
            element.classList.remove('text-white');
        }
    </script>
</x-guest-layout>
