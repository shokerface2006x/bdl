<x-guest-layout>
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

        /* Стиль для кнопки переключения (иконка) */
        .toggle-password {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: color 0.3s, transform 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .toggle-password:hover {
            color: white;
            transform: translateY(-50%) scale(1.1);
        }
        .toggle-password svg {
            width: 20px;
            height: 20px;
        }
    </style>

    <div class="min-h-screen flex items-start justify-center pt-16 pb-20 px-10">
        <div class="max-w-xl w-full border-white/10 p-12">

            <h1 class="text-6xl font-black uppercase tracking-tighter mb-4 text-center custom-logo-font">Новый пароль</h1>
            <p class="text-[12px] uppercase tracking-widest text-white/40 mb-10 text-center custom-logo-font">
                Создайте свой новый надежный пароль ниже.
            </p>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-8" novalidate>
                @csrf

                {{-- МАКСИМАЛЬНО НАДЕЖНЫЙ ЗАХВАТ ТОКЕНА --}}
                @php
                    $token = $request->route('token') ?: $request->query('token') ?: $request->token;
                @endphp
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="text-[11px] text-white/50 tracking-[0.3em] mb-3 block custom-logo-font">ПОЧТА</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required readonly
                           class="w-full bg-transparent border border-white/10 text-white/40 p-5 outline-none font-bold tracking-widest text-base cursor-not-allowed">
                    @error('email')
                    <span class="text-[12px] text-red-500 uppercase mt-3 block italic">{{ $message }}</span>
                    @enderror
                </div>

                <div class="relative">
                    <label for="password" class="text-[11px] text-white/50 tracking-[0.3em] mb-3 block custom-logo-font">НОВЫЙ ПАРОЛЬ</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required autofocus
                               class="w-full bg-transparent border border-white/20 text-white p-5 focus:border-white transition outline-none font-bold tracking-widest text-base">
                        <span class="toggle-password" onclick="toggleVisibility('password', this)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.399 8.049 7.21 5 12 5c4.791 0 8.601 3.049 9.964 6.678a1.012 1.012 0 010 .644C20.601 15.951 16.79 19 12 19c-4.791 0-8.601-3.049-9.964-6.678z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                    </div>
                    @error('password')
                    <span class="text-[12px] text-red-500 uppercase mt-3 block italic">{{ $message }}</span>
                    @enderror
                </div>

                <div class="relative">
                    <label for="password_confirmation" class="text-[11px] text-white/50 tracking-[0.3em] mb-3 block custom-logo-font">ПОДТВЕРДИТЕ ПАРОЛЬ</label>
                    <div class="relative">
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               class="w-full bg-transparent border border-white/20 text-white p-5 focus:border-white transition outline-none font-bold tracking-widest text-base">
                        <span class="toggle-password" onclick="toggleVisibility('password_confirmation', this)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.399 8.049 7.21 5 12 5c4.791 0 8.601 3.049 9.964 6.678a1.012 1.012 0 010 .644C20.601 15.951 16.79 19 12 19c-4.791 0-8.601-3.049-9.964-6.678z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                    </div>
                </div>

                <button type="submit" class="custom-logo-font w-full py-5 bg-white text-black text-[12px] font-black uppercase tracking-[0.3em] hover:bg-zinc-200 transition duration-300">
                    СБРОСИТЬ ПАРОЛЬ
                </button>
            </form>

        </div>
    </div>

    <script>
        function toggleVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const svg = btn.querySelector('svg');

            if (input.type === 'password') {
                input.type = 'text';
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />';
            } else {
                input.type = 'password';
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644C3.399 8.049 7.21 5 12 5c4.791 0 8.601 3.049 9.964 6.678a1.012 1.012 0 010 .644C20.601 15.951 16.79 19 12 19c-4.791 0-8.601-3.049-9.964-6.678z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />';
            }
        }
    </script>
</x-guest-layout>
