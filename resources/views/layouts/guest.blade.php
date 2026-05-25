<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'BLUEDAY\'SLIPS' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @font-face {
            font-family: 'LC Chalk';
            src: url("{{ asset('LC Chalk.ttf') }}") format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        .custom-logo-font {
            font-family: 'LC Chalk', sans-serif !important;
        }

        body {
            background-image: url("{{ asset('image/bg.png') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-color: black;
        }

        /* ЖЕЛЕЗНЫЙ ИНВЕРТ НА ЧИСТОМ CSS */
        .pure-white-icon {
            filter: invert(1) !important;
        }

        /* АДАПТИВ ДЛЯ ССЫЛКИ НА ЧИСТОМ CSS */
        .back-to-main {
            display: none !important; /* По умолчанию скрыто на мобилках */
        }

        @media (min-width: 768px) {
            .back-to-main {
                display: inline-block !important; /* Показывается на экранах от 768px и выше */
            }
        }
    </style>
</head>
<body class="font-sans text-white/90 antialiased">

<header class="top-0 left-0 w-full z-50 bg-transparent border-b border-white/10 backdrop-blur-sm">
    <div class="max-w-[1440px] mx-auto px-6 h-20 flex items-center justify-between">
        <div class="flex-1 flex items-center gap-6">
            <a href="/" class="back-to-main custom-logo-font text-[11px] uppercase tracking-[0.3em] font-bold hover:opacity-60 transition">
                ВЕРНУТЬСЯ НА ГЛАВНУЮ
            </a>
        </div>

        <div class="flex-none">
            <a href="/" class="custom-logo-font text-4xl uppercase tracking-tighter inline-block text-white transition-transform hover:scale-105">
                BDL
            </a>
        </div>

        <div class="flex-1 flex justify-end items-center text-white">
            @auth
                <a href="{{ route('profile.index') }}" title="Профиль" class="hover:opacity-60 transition p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </a>
            @else
                <a href="{{ route('login') }}" title="Войти" class="hover:opacity-60 transition p-1">
                    <img src="{{ asset('image/profile.png') }}" alt="Войти" class="w-9 h-9 object-contain pure-white-icon">
                </a>
            @endauth

            @if(!request()->is('admin*'))
                @php
                    $totalCount = auth()->check()
                        ? auth()->user()->cartItems()->sum('quantity')
                        : array_sum(array_column((array)session('cart'), 'quantity'));
                @endphp

                <a href="{{ route('cart.index') }}" title="Корзина" style="margin-left: 24px;" class="group relative p-1 hover:opacity-60 transition flex items-center justify-center">
                    <img src="{{ asset('image/cart.png') }}" alt="Корзина" class="w-9 h-9 object-contain pure-white-icon">

                    @if($totalCount > 0)
                        <span class="absolute -top-1 -right-1 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-white px-1 text-[9px] font-black text-black group-hover:scale-110 transition-transform">
                            {{ $totalCount }}
                        </span>
                    @endif
                </a>
            @endif
        </div>
    </div>
</header>

@php
    $isWidePage = request()->is('admin') ||
                  request()->is('admin/*') ||
                  request()->routeIs('product.show') ||
                  request()->routeIs('profile.index') ||
                  request()->routeIs('cart.index') ||
                  request()->routeIs('password.request') ||
                  request()->routeIs('password.reset') ||
                  request()->is('*checkout*');
@endphp

<div class="min-h-screen {{ $isWidePage ? '' : 'flex flex-col justify-center items-center' }}">
    @if(!$isWidePage)
        <div class="mb-8">
            <h1 class="text-4xl font-black uppercase tracking-tighter text-center custom-logo-font">
                @if(request()->routeIs('login'))
                    ВХОД
                @elseif(request()->routeIs('register'))
                    РЕГИСТРАЦИЯ
                @endif
            </h1>
        </div>
    @endif

    <div class="w-full {{ $isWidePage ? '' : 'sm:max-w-md px-6' }}">
        {{ $slot }}
    </div>
</div>

</body>
</html>
