<x-guest-layout :hide-auth-nav="true">
    <style>
        /* Полностью прозрачное автозаполнение */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            transition: background-color 9999999s ease-in-out 0s;
            -webkit-text-fill-color: white !important;
            caret-color: white;
        }

        input:focus {
            outline: none !important;
            box-shadow: none !important;
            border-color: white !important;
        }
    </style>

    <div class="min-h-screen flex items-start justify-center pt-32 pb-20 px-10">
        <div class="max-w-xl w-full border-white/10 p-12">

            <h1 class="text-6xl font-black uppercase tracking-tighter mb-4 text-center custom-logo-font">Забыли?</h1>
            <p class="text-[12px] uppercase tracking-widest text-white/40 mb-10 text-center custom-logo-font">
                Введите свой адрес электронной почты, и мы вышлем ссылку для сброса
            </p>

            @if (session('status'))
                <div class="mb-8 text-[12px] uppercase font-bold custom-logo-font text-green-500 tracking-widest animate-pulse text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-8" novalidate>
                @csrf

                <div>
                    <label for="email" class="text-[11px] text-white/50 tracking-[0.3em] mb-3 block custom-logo-font ">ПОЧТА</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full bg-transparent border border-white/20 text-white p-5 focus:border-white transition outline-none font-bold tracking-widest text-base">

                    @error('email')
                    <span class="text-[12px] text-red-500 uppercase mt-3 block italic">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="custom-logo-font w-full py-5 bg-white text-black text-[12px] font-black uppercase tracking-[0.3em] hover:bg-zinc-200 transition duration-300">
                    СБРОСИТЬ ПАРОЛЬ
                </button>
            </form>

        </div>
    </div>
</x-guest-layout>
