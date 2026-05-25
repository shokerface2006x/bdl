<x-guest-layout>
    <div class="max-w-7xl mx-auto py-20 px-6">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-4xl font-black uppercase italic text-white">УПРАВЛЕНИЕ ТОВАРАМИ</h1>

            <div class="flex gap-4">
                {{-- Кнопка для перехода к заказам --}}
                <a href="{{ route('admin.orders.index') }}" class="border border-white/20 text-white px-6 py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-white hover:text-black transition">
                    ПРОСМОТР ЗАКАЗОВ
                </a>

                <a href="{{ route('admin.products.create') }}" class="bg-white text-black px-6 py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-zinc-200 transition">
                    ВЫЛОЖИТЬ НОВЫЙ ТОВАР
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-10 p-4 border border-green-500 text-green-500 text-[10px] uppercase font-bold tracking-widest">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($products as $product)
                <div class="border border-white/10 p-6 flex flex-col justify-between group">
                    <div>
                        <div class="aspect-[3/4] mb-6 overflow-hidden">
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover transition duration-500">
                        </div>
                        <h2 class="text-xl font-bold uppercase italic text-white mb-2">{{ $product->title }}</h2>
                        <p class="text-zinc-500 font-mono mb-6">{{ number_format($product->price, 0, '.', ' ') }} РУБ</p>
                    </div>

                    <div class="flex gap-4">
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="w-full">
                            @csrf @method('DELETE')
                            <button class="w-full border border-red-500/30 text-red-500/50 py-3 text-[9px] uppercase font-bold hover:bg-red-500 hover:text-white transition">
                                УДАЛИТЬ
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-guest-layout>
