<x-guest-layout>
    <div class="max-w-3xl mx-auto py-20 px-6">
        <div class="mb-12">
            <a href="{{ route('admin.products.index') }}" class="text-[10px] uppercase tracking-widest text-white/40 hover:text-white transition">← ВЕРНУТЬСЯ НА СТРАНИЦУ РЕДАКТИРОВАНИЯ</a>
            <h1 class="text-5xl font-black uppercase italic text-white mt-4">НОВЫЙ ТОВАР</h1>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            {{-- Название --}}
            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-[0.3em] text-white/40 font-bold">НАЗВАНИЕ ТОВАРА</label>
                <input type="text" name="title" required
                       class="w-full bg-transparent border border-white/10 py-4 px-4 text-white focus:border-white transition outline-none uppercase font-bold italic">
                @error('title') <p class="text-red-500 text-[10px] uppercase mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Цена --}}
                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-[0.3em] text-white/40 font-bold">ЦЕНА</label>
                    <input type="number" name="price" required
                           class="w-full bg-transparent border border-white/10 py-4 px-4 text-white focus:border-white transition outline-none font-mono">
                    @error('price') <p class="text-red-500 text-[10px] uppercase mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Изображение --}}
                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-[0.3em] text-white/40 font-bold">ДОБАВИТЬ ИЗОБРАЖЕНИЕ</label>
                    <input type="file" name="image" required
                           class="w-full bg-transparent border border-white/10 py-3.5 px-4 text-white/40 text-[10px] uppercase font-bold cursor-pointer file:hidden">
                    @error('image') <p class="text-red-500 text-[10px] uppercase mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Описание --}}
            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-[0.3em] text-white/40 font-bold">ОПИСАНИЕ</label>
                <textarea name="description" rows="5"
                          class="w-full bg-transparent border border-white/10 py-4 px-4 text-white focus:border-white transition outline-none"></textarea>
            </div>

            <button type="submit" class="w-full bg-white text-black py-6 text-xs font-black uppercase tracking-[0.5em] hover:bg-zinc-200 transition-all duration-300 shadow-[0_0_30px_rgba(255,255,255,0.1)]">
                ВЫЛОЖИТЬ ТОВАР
            </button>
        </form>
    </div>
</x-guest-layout>
