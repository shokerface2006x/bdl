<x-guest-layout>
    <style>
        /* Отключаем браузерный стиль автозаполнения */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: white !important;
            -webkit-box-shadow: 0 0 0px 1000px transparent inset !important;
            transition: background-color 5000s ease-in-out 0s;
            caret-color: white;
        }

        /* Убираем синюю браузерную обводку */
        input:focus {
            outline: none !important;
            box-shadow: none !important;
            border-color: white !important;
        }

        /* ЖЕСТКИЙ СТИЛЬ ДЛЯ ОШИБОК */
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

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        <!-- EMAIL -->
        <div class="space-y-2">
            <label for="email" class="text-white text-[10px] tracking-widest block mb-2 custom-logo-font">ПОЧТА</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="block w-full bg-transparent border p-4 text-white outline-none transition-all tracking-widest text-sm
                   {{ $errors->has('email') || $errors->has('password') ? 'is-invalid' : 'border-white/20' }}">

            @error('email')
            <p class="mt-2 error-text text-[10px] uppercase font-bold tracking-tighter">
                {{ $message }}
            </p>
            @enderror
        </div>

        <!-- PASSWORD -->
        <div class="mt-6 space-y-2" x-data="{ show: false }">
            <label for="password" class="text-white text-[10px] tracking-widest block mb-2 custom-logo-font">ПАРОЛЬ</label>

            <div class="relative flex items-center w-full">
                <input id="password"
                       :type="show ? 'text' : 'password'"
                       name="password"
                       required
                       class="block w-full bg-transparent border p-4 pr-12 text-white outline-none transition-all tracking-widest text-sm
                       {{ $errors->has('password') || $errors->has('email') ? 'is-invalid' : 'border-white/20' }}">

                <button type="button"
                        @click="show = !show"
                        class="absolute right-0 top-0 bottom-0 px-4 flex items-center justify-center text-white/40 hover:text-white transition-colors focus:outline-none z-20">

                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.414 9.006 7.225 5 12 5c4.775 0 8.586 4.006 9.964 6.678a1.012 1.012 0 010 .644C20.586 14.994 16.775 19 12 19c-4.775 0-8.586-4.006-9.964-6.678z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>

                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>

            @error('password')
            <p class="mt-2 error-text text-[10px] uppercase font-bold tracking-tighter">
                {{ $message }}
            </p>
            @enderror

            {{-- Если ошибка общая (неверный логин/пароль), показываем под паролем --}}
            @if($errors->has('email') && !$errors->has('password'))
                <p class="mt-2 error-text text-[10px] uppercase font-bold tracking-tighter">
                    НЕВЕРНЫЙ ЛОГИН ИЛИ ПАРОЛЬ
                </p>
            @endif
        </div>

        <div class="flex justify-between items-center mt-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                       class="bg-transparent border-white/20 text-white focus:ring-0 focus:ring-offset-0 rounded-none w-4 h-4">
                <span class="custom-logo-font ms-2 text-[10px] text-white/70 tracking-widest hover:text-white transition-colors">
                    ЗАПОМНИТЬ МЕНЯ
                </span>
            </label>

            @if (Route::has('password.request'))
                <a class="custom-logo-font text-[11px] tracking-[0.2em] text-white/50 hover:text-white transition" href="{{ route('password.request') }}">
                    ЗАБЫЛИ ПАРОЛЬ?
                </a>
            @endif
        </div>

        <div class="flex flex-col items-center mt-10 space-y-6">
            <button type="submit" class="custom-logo-font w-full py-4 bg-white text-black font-black tracking-[0.3em] text-sm hover:bg-zinc-200 transition-all duration-300 shadow-2xl">
                ВОЙТИ
            </button>

            <a class="custom-logo-font text-[11px] uppercase tracking-[0.2em] text-white/50 hover:text-white transition" href="{{ route('register') }}">
                Нет аккаунта? Создать аккаунт
            </a>
        </div>
    </form>
</x-guest-layout>
