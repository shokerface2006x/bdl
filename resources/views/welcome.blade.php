<!DOCTYPE html>
<html lang="ru" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDL | Официальный сайт</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            font-weight: normal !important;
            font-style: normal !important;
        }

        body {
            background-image: url("{{ asset('image/bg.png') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-color: black;
            overflow-x: hidden;
            max-width: 100vw;
        }

        @keyframes marquee {
        0 { transform: translateX(0%); }
        100% { transform: translateX(-100%); }
        }
        .animate-marquee {
            display: flex;
            animation: marquee 20s linear infinite;
        }
    </style>
</head>
<body class="text-white antialiased">

<nav class="w-full z-50 flex flex-col items-center relative py-6">
    <div class="max-w-[1440px] w-full grid grid-cols-3 items-center px-6 md:px-12">

        <div class="hidden md:flex space-x-6 items-center">
            <a href="#" target="_blank" class="hover:opacity-100 hover:-translate-y-1 transition-all duration-300 opacity-80">
                <img src="{{ asset('image/instagram.svg') }}" alt="Social" class="w-8 h-8 object-contain">
            </a>
            <a href="#" target="_blank" class="hover:opacity-100 hover:-translate-y-1 transition-all duration-300 opacity-80">
                <img src="{{ asset('image/tiktok.svg') }}" alt="Social" class="w-8 h-8 object-contain">
            </a>
            <a href="#" target="_blank" class="hover:opacity-100 hover:-translate-y-1 transition-all duration-300 opacity-80">
                <img src="{{ asset('image/yotube.svg') }}" alt="Social" class="w-9 h-9 object-contain">
            </a>
            <a href="#" target="_blank" class="hover:opacity-100 hover:-translate-y-1 transition-all duration-300 opacity-80">
                <img src="{{ asset('image/telega.svg') }}" alt="Social" class="w-8 h-8 object-contain">
            </a>
            <a href="#" target="_blank" class="hover:opacity-100 hover:-translate-y-1 transition-all duration-300 opacity-80">
                <img src="{{ asset('image/twitter.svg') }}" alt="Social" class="w-9 h-9 object-contain">
            </a>
        </div>

        <div class="flex md:hidden justify-start items-center space-x-4 text-white">
            @auth
                <a href="{{ route('profile.index') }}" title="Профиль" class="hover:opacity-60 transition p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </a>
            @else
                <a href="{{ route('login') }}" title="Войти" class="hover:opacity-60 transition p-1">
                    <img src="{{ asset('image/profile.png') }}" alt="Войти" class="w-7 h-7 object-contain invert">
                </a>
            @endauth

            <a href="{{ route('cart.index') }}" title="Корзина" class="invert group relative p-1 hover:opacity-60 transition flex items-center justify-center">
                <img src="{{ asset('image/cart.png') }}" alt="Корзина" class="w-7 h-7 object-contain">
                @php
                    $totalCount = auth()->check()
                        ? auth()->user()->cartItems()->sum('quantity')
                        : array_sum(array_column((array)session('cart'), 'quantity'));
                @endphp
                @if($totalCount > 0)
                    <span class="absolute -top-1 -right-1 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-white px-1 text-[9px] font-black text-black group-hover:scale-110 transition-transform">
                        {{ $totalCount }}
                    </span>
                @endif
            </a>
        </div>

        <div class="text-center">
            <a href="#home" class="custom-logo-font text-4xl uppercase inline-block text-white transition-transform hover:scale-105">
                BDL
            </a>
        </div>

        <div class="hidden md:flex justify-end items-center space-x-5 text-white">
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.products.index') }}"
                       title="Админка"
                       class="text-[10px] uppercase tracking-[0.2em] text-red-500 font-black border border-red-500/20 px-2.5 py-1 hover:bg-red-500 hover:text-white transition duration-300 mr-1">
                        Admin
                    </a>
                @endif
            @endauth

            @auth
                <a href="{{ route('profile.index') }}" title="Профиль" class="hover:opacity-60 transition p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </a>
            @else
                <a href="{{ route('login') }}" title="Войти" class="hover:opacity-60 transition p-1">
                    <img src="{{ asset('image/profile.png') }}" alt="Войти" class="w-9 h-9 object-contain invert">
                </a>
            @endauth

            <a href="{{ route('cart.index') }}" title="Корзина" class="invert group relative p-1 hover:opacity-60 transition flex items-center justify-center">
                <img src="{{ asset('image/cart.png') }}" alt="Корзина" class="w-9 h-9 object-contain">
                @if($totalCount > 0)
                    <span class="absolute -top-1 -right-1 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-white px-1 text-[9px] font-black text-black group-hover:scale-110 transition-transform">
                        {{ $totalCount }}
                    </span>
                @endif
            </a>
        </div>

        <div class="flex md:hidden justify-end items-center text-white">
            <button type="button" id="mobile-menu-btn" class="text-white focus:outline-none p-1 hover:opacity-70 transition z-50">
                <svg id="burger-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg id="close-icon" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

    </div>

    <div class="hidden md:flex mt-4 justify-center space-x-12 uppercase text-sm font-bold tracking-[0.2em] text-white">
        <a href="#releases" class="hover:text-gray-400 transition custom-logo-font">РЕЛИЗЫ</a>
        <a href="#gigs" class="hover:text-gray-400 transition custom-logo-font">КОНЦЕРТЫ</a>
        <a href="#merch" class="hover:text-gray-400 transition custom-logo-font">МЕРЧ</a>
        <a href="#about" class="hover:text-gray-400 transition custom-logo-font">О НАС</a>
    </div>

    <div id="mobile-menu"
         style="display: none;"
         class="absolute top-20 left-0 w-full px-12 py-12 flex flex-col space-y-8 z-40 md:hidden">

        <div class="flex flex-col space-y-6 text-center uppercase text-2xl font-bold tracking-[0.1em] text-white">
            <a href="#releases" class="hover:text-gray-400 transition custom-logo-font close-menu-link">Звук</a>
            <a href="#gigs" class="hover:text-gray-400 transition custom-logo-font close-menu-link">Гиги</a>
            <a href="#merch" class="hover:text-gray-400 transition custom-logo-font close-menu-link">Мерч</a>
            <a href="#about" class="hover:text-gray-400 transition custom-logo-font close-menu-link">Бэнд</a>

            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.products.index') }}" class="close-menu-link text-sm uppercase tracking-[0.2em] text-red-500 font-black border border-red-500/20 px-4 py-2 hover:bg-red-500 hover:text-white transition duration-300 inline-block text-center">
                        Admin
                    </a>
                @endif
                <a href="{{ route('profile.index') }}" class="hover:text-gray-400 transition custom-logo-font close-menu-link">Профиль</a>
            @else
                <a href="{{ route('login') }}" class="hover:text-gray-400 transition custom-logo-font close-menu-link">Вход</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const burgerIcon = document.getElementById('burger-icon');
        const closeIcon = document.getElementById('close-icon');
        const menuLinks = document.querySelectorAll('.close-menu-link');

        if (btn && menu) {
            btn.addEventListener('click', function () {
                if (menu.style.display === 'none' || menu.style.display === '') {
                    menu.style.display = 'flex';
                    burgerIcon.style.display = 'none';
                    closeIcon.style.display = 'block';
                } else {
                    menu.style.display = 'none';
                    burgerIcon.style.display = 'block';
                    closeIcon.style.display = 'none';
                }
            });

            menuLinks.forEach(link => {
                link.addEventListener('click', function () {
                    menu.style.display = 'none';
                    burgerIcon.style.display = 'block';
                    closeIcon.style.display = 'none';
                });
            });
        }
    });
</script>

<section id="home" class="relative h-[calc(100vh-80px)] w-full flex items-center justify-center overflow-hidden ">
    <div class="absolute inset-0 z-20 "></div>
    <div id="baba-zoom-container" class="relative z-10 flex items-center justify-center will-change-transform transition-transform duration-100 ease-out">
        <img src="{{ asset('image/baba.png') }}"
             alt="Featured Model"
             class="max-w-[80vw] max-h-[70vh] object-contain opacity-75 translate-y-12">
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const zoomContainer = document.getElementById('baba-zoom-container');

        if (zoomContainer) {
            const maxScale = 1.3;
            const scrollSpeed = 0.001;

            window.addEventListener('scroll', function () {
                let scrollOffset = window.pageYOffset || document.documentElement.scrollTop;
                let newScale = 1 + (scrollOffset * scrollSpeed);

                if (newScale > maxScale) {
                    newScale = maxScale;
                }

                if (scrollOffset <= 0) {
                    newScale = 1;
                }

                zoomContainer.style.transform = `scale(${newScale})`;
            });
        }
    });
</script>

<section id="merch" class="relative z-30 py-24 px-6 md:px-10 overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <h2 class="custom-logo-font text-6xl mb-16 uppercase tracking-tighter text-center">Мерч</h2>

        <div class="flex overflow-x-auto snap-x snap-mandatory scrollbar-none md:grid md:grid-cols-3 gap-6 md:gap-10 pb-6 md:pb-0">
            @foreach($products as $item)
                <div class="group p-4 transition-all duration-500 min-w-[80%] sm:min-w-[50%] md:min-w-0 snap-center">
                    <a href="{{ route('product.show', $item->id) }}" class="block aspect-square mb-6 flex items-center justify-center overflow-hidden">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}"
                                 alt="{{ $item->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        @else
                            <span class="text-zinc-700 uppercase font-bold tracking-widest group-hover:scale-110 transition text-[10px]">No Image</span>
                        @endif
                    </a>

                    <h3 class="custom-logo-font text-xl mb-4 text-center truncate px-2">
                        <a href="{{ route('product.show', $item->id) }}" class="hover:opacity-70 transition-opacity">
                            {{ $item->title }}
                        </a>
                    </h3>

                    <div class="flex justify-center">
                        <a href="{{ route('product.show', $item->id) }}" class="custom-logo-font inline-block px-4 py-1 text-2xl text-white/70 hover:text-white hover:scale-110 transition-all duration-300">
                            {{ number_format($item->price, 0, '.', ' ') }} руб
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="gigs" class="relative z-30 py-24 px-6 md:px-10 overflow-hidden">
    <div class="max-w-4xl mx-auto">

        <h2 class="custom-logo-font text-6xl mb-4 uppercase tracking-tighter text-center">Концерты</h2>
        <p class="text-[10px] uppercase tracking-[0.4em] text-white/40 text-center mb-16 italic font-bold">Локальный угар / Вход на входе</p>

        <div class="space-y-6">

            <div class="border border-white/10 p-6 bg-zinc-900/20 backdrop-blur-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4 hover:border-white/20 transition-all duration-300">
                <div>
                    <div class="text-xs uppercase tracking-widest text-white/40 mb-1 font-bold">29 МАЯ / 19:00</div>
                    <h3 class="custom-logo-font text-3xl uppercase tracking-wide text-white">БАР «ПОДВАЛ»</h3>
                    <p class="text-xs text-white/60 uppercase tracking-wider mt-1">ул. Ленина, 42 (наш город)</p>
                </div>
                <div class="flex flex-col md:items-end w-full md:w-auto">
                    <span class="custom-logo-font text-2xl text-white">500 РУБ</span>
                    <span class="text-[9px] uppercase tracking-[0.2em] text-yellow-500/80 font-bold mt-1">ВХОД НА ДВЕРИ / КЭШ ИЛИ СПБ</span>
                </div>
            </div>

            <div class="border border-white/10 p-6 bg-zinc-900/20 backdrop-blur-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4 hover:border-white/20 transition-all duration-300">
                <div>
                    <div class="text-xs uppercase tracking-widest text-white/40 mb-1 font-bold">12 ИЮНЯ / 20:00</div>
                    <h3 class="custom-logo-font text-3xl uppercase tracking-wide text-white">КЛУБ «ЦЕХ»</h3>
                    <p class="text-xs text-white/60 uppercase tracking-wider mt-1">Промзона, проезд Инженеров, д. 7</p>
                </div>
                <div class="flex flex-col md:items-end w-full md:w-auto">
                    <span class="custom-logo-font text-2xl text-white">ВХОД СВОБОДНЫЙ</span>
                    <span class="text-[9px] uppercase tracking-[0.2em] text-white/40 font-bold mt-1">ДОНЕЙШН НА СТРУНЫ ПРИВЕТСТВУЕТСЯ</span>
                </div>
            </div>

        </div>

        <div class="mt-12 text-center">
            <p class="text-xs uppercase tracking-[0.2em] text-white/30 italic">
                Хочешь позвать нас играть в свой гараж или бар? <br>
                <span class="text-white/60 not-italic font-bold select-all">bdl-band@mail.ru</span> или пиши в телегу
            </p>
        </div>

    </div>
</section>

<style>
    .scrollbar-none::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-none {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<section id="releases" class="relative z-30 py-24 px-6 md:px-10 overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <h2 class="custom-logo-font text-6xl mb-16 uppercase tracking-tighter text-center">Релизы</h2>

        <div class="flex overflow-x-auto snap-x snap-mandatory scrollbar-none md:grid md:grid-cols-3 gap-6 md:gap-12 pb-6 md:pb-0">

            <div class="flex flex-col items-center min-w-[80%] sm:min-w-[50%] md:min-w-0 snap-center">
                <div class="w-full aspect-square mb-6 overflow-hidden">
                    <img src="{{ asset('image/album.jpg') }}" alt="Release Title" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                </div>
                <h3 class="custom-logo-font text-2xl mb-3 text-center uppercase tracking-wide truncate w-full px-2">Название релиза 1</h3>
                <div class="flex space-x-4 custom-logo-font text-sm tracking-widest text-white/50">
                    <a href="#" target="_blank" class="hover:text-white transition">SPOTIFY</a>
                    <span>•</span>
                    <a href="#" target="_blank" class="hover:text-white transition">APPLE</a>
                    <span>•</span>
                    <a href="#" target="_blank" class="hover:text-white transition">VK</a>
                </div>
            </div>

            <div class="flex flex-col items-center min-w-[80%] sm:min-w-[50%] md:min-w-0 snap-center">
                <div class="w-full aspect-square mb-6 overflow-hidden">
                    <img src="{{ asset('image/album4.jpg') }}" alt="Release Title" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                </div>
                <h3 class="custom-logo-font text-2xl mb-3 text-center uppercase tracking-wide truncate w-full px-2">Название релиза 2</h3>
                <div class="flex space-x-4 custom-logo-font text-sm tracking-widest text-white/50">
                    <a href="#" target="_blank" class="hover:text-white transition">SPOTIFY</a>
                    <span>•</span>
                    <a href="#" target="_blank" class="hover:text-white transition">APPLE</a>
                    <span>•</span>
                    <a href="#" target="_blank" class="hover:text-white transition">VK</a>
                </div>
            </div>

            <div class="flex flex-col items-center min-w-[80%] sm:min-w-[50%] md:min-w-0 snap-center">
                <div class="w-full aspect-square mb-6 overflow-hidden">
                    <img src="{{ asset('image/album5.jpg') }}" alt="Release Title" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                </div>
                <h3 class="custom-logo-font text-2xl mb-3 text-center uppercase tracking-wide truncate w-full px-2">Название релиза 3</h3>
                <div class="flex space-x-4 custom-logo-font text-sm tracking-widest text-white/50">
                    <a href="#" target="_blank" class="hover:text-white transition">SPOTIFY</a>
                    <span>•</span>
                    <a href="#" target="_blank" class="hover:text-white transition">APPLE</a>
                    <span>•</span>
                    <a href="#" target="_blank" class="hover:text-white transition">VK</a>
                </div>
            </div>

        </div>
    </div>
</section>

<section id="about" class="w-full py-24 px-6 md:px-12 lg:px-20">
    <div class="mb-16 text-center">
        <h2 class="custom-logo-font text-6xl uppercase tracking-tighter leading-none text-white">О НАС</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12">
        <div class="flex flex-col group">
            <div class="aspect-[2/3] mb-6 relative overflow-hidden">
                <div class="absolute inset-0 p-3">
                    <img src="{{ asset('image/.png') }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 opacity-80 group-hover:opacity-100">
                </div>
                <img src="{{ asset('image/setka.png') }}" class="absolute inset-0 w-full h-full z-10 pointer-events-none object-stretch">
            </div>
            <h3 class="custom-logo-font text-2xl text-center italic tracking-tighter text-white">АРТЁМ</h3>
            <p class="text-[9px] text-center uppercase tracking-[0.3em] text-white/40 mt-1 font-bold">БАС</p>
        </div>

        <div class="flex flex-col group">
            <div class="aspect-[2/3] mb-6 relative overflow-hidden">
                <div class="absolute inset-0 p-3">
                    <img src="{{ asset('image/.png') }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 opacity-80 group-hover:opacity-100">
                </div>
                <img src="{{ asset('image/setka.png') }}" class="absolute inset-0 w-full h-full z-10 pointer-events-none">
            </div>
            <h3 class="custom-logo-font text-2xl text-center italic tracking-tighter text-white">ПАТАУ</h3>
            <p class="text-[9px] uppercase text-center tracking-[0.3em] text-white/40 mt-1 font-bold">СОЛО</p>
        </div>

        <div class="flex flex-col group">
            <div class="aspect-[2/3] mb-6 relative overflow-hidden">
                <div class="absolute inset-0 p-3">
                    <img src="{{ asset('image/.png') }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 opacity-80 group-hover:opacity-100">
                </div>
                <img src="{{ asset('image/setka.png') }}" class="absolute inset-0 w-full h-full z-10 pointer-events-none">
            </div>
            <h3 class="custom-logo-font text-2xl text-center italic tracking-tighter text-white">ТЕЛЕФОТО</h3>
            <p class="text-[9px] text-center uppercase tracking-[0.3em] text-white/40 mt-1 font-bold">РИТМ</p>
        </div>

        <div class="flex flex-col group">
            <div class="aspect-[2/3] mb-6 relative overflow-hidden">
                <div class="absolute inset-0 p-3">
                    <img src="{{ asset('image/.png') }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 opacity-80 group-hover:opacity-100">
                </div>
                <img src="{{ asset('image/setka.png') }}" class="absolute inset-0 w-full h-full z-10 pointer-events-none">
            </div>
            <h3 class="custom-logo-font text-2xl text-center italic tracking-tighter text-white">ШЕФ</h3>
            <p class="text-[9px] text-center uppercase tracking-[0.3em] text-white/40 mt-1 font-bold">УДАРНЫЕ</p>
        </div>
    </div>
</section>

<button id="toggle-draw" class="fixed bottom-8 right-8 z-[100] group flex flex-col items-center focus:outline-none">
    <span class="text-[9px] uppercase tracking-[0.3em] text-white/30 mb-2 opacity-0 group-hover:opacity-100 transition-all duration-500 italic">
        Начиркать
    </span>
    <div class="w-14 h-14 bg-white/5 border border-white/10 rounded-full flex items-center justify-center backdrop-blur-md transition-all duration-500 group-hover:scale-110 group-hover:border-white/40 active:scale-95">
        <svg id="pencil-icon" class="w-6 h-6 text-white opacity-20 group-hover:opacity-100 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
        </svg>
    </div>
</button>

<canvas id="doodle-canvas" class="fixed inset-0 z-[95] pointer-events-none"></canvas>

<script>
    const canvas = document.getElementById('doodle-canvas');
    const ctx = canvas.getContext('2d');
    const btn = document.getElementById('toggle-draw');
    const icon = document.getElementById('pencil-icon');

    let isDrawing = false;
    let active = false;

    function resize() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    window.addEventListener('resize', resize);
    resize();

    btn.addEventListener('click', () => {
        active = !active;
        canvas.classList.toggle('pointer-events-none');
        if (active) {
            icon.style.color = '#fbbf24';
            document.body.style.cursor = 'crosshair';
        } else {
            icon.style.color = '';
            document.body.style.cursor = 'default';
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }
    });

    function draw(e) {
        if (!isDrawing || !active) return;
        ctx.lineWidth = 3;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.strokeStyle = 'white';

        const jitterX = (Math.random() - 0.5) * 1.5;
        const jitterY = (Math.random() - 0.5) * 1.5;

        ctx.lineTo(e.clientX + jitterX, e.clientY + jitterY);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(e.clientX + jitterX, e.clientY + jitterY);
    }

    function fade() {
        if (active && !isDrawing) {
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const data = imageData.data;
            let hasPixels = false;
            for (let i = 3; i < data.length; i += 4) {
                if (data[i] > 0) {
                    data[i] -= 2;
                    hasPixels = true;
                }
            }
            if (hasPixels) {
                ctx.putImageData(imageData, 0, 0);
            }
        }
        requestAnimationFrame(fade);
    }
    fade();

    canvas.addEventListener('mousedown', (e) => {
        isDrawing = true;
        ctx.beginPath();
        ctx.moveTo(e.clientX, e.clientY);
    });
    canvas.addEventListener('mousemove', draw);
    window.addEventListener('mouseup', () => { isDrawing = false; });
</script>

<footer class="w-full pt-32 pb-16 px-12 mt-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent -z-10"></div>
    <div class="max-w-[1440px] mx-auto flex flex-col items-center">
        <div class="mb-16 text-center group">
            <a href="/" class="custom-logo-font text-6xl uppercase text-white transition-all duration-700 hover:tracking-[0.2em]">
                BDL
            </a>
            <p class="text-[10px] uppercase tracking-[0.5em] text-white/70 font-bold italic mt-4">
                © 2026 ВСЕ ПРАВА ИЗОГНУТЫ
            </p>
        </div>

        <div class="w-full flex flex-col md:flex-row justify-between items-center gap-10 pt-10">
            <div class="flex space-x-8 items-center order-2 md:order-1">
                <a href="#" target="_blank" class="hover:scale-110 transition-all opacity-40 hover:opacity-100">
                    <img src="{{ asset('image/instagram.svg') }}" alt="Social" class="w-6 h-6 object-contain grayscale hover:grayscale-0">
                </a>
                <a href="#" target="_blank" class="hover:scale-110 transition-all opacity-40 hover:opacity-100">
                    <img src="{{ asset('image/telega.svg') }}" alt="Social" class="w-6 h-6 object-contain grayscale hover:grayscale-0">
                </a>
                <a href="#" target="_blank" class="hover:scale-110 transition-all opacity-40 hover:opacity-100">
                    <img src="{{ asset('image/yotube.svg') }}" alt="Social" class="w-7 h-7 object-contain grayscale hover:grayscale-0">
                </a>
            </div>

            <div class="flex flex-col items-center order-1 md:order-2">
                <a href="https://yoomoney.ru/to/4100119531353714" target="_blank" class="custom-logo-font text-xl text-white hover:text-yellow-400 transition-all hover:scale-105">
                    ЗАКИНУТЬ НА ПИВО
                </a>
                <p class="text-[8px] uppercase tracking-[0.2em] text-white/10 mt-1 italic">на новые струны и угар</p>
            </div>

            <div class="flex flex-col items-center md:items-end opacity-20 order-3">
                <p class="text-[9px] uppercase tracking-[0.2em] text-white mb-1 font-light text-right">СДЕЛАНО НА КОЛЕНКЕ ЧЕРЕЗ</p>
                <span class="text-[10px] uppercase italic text-white/100">LARAVEL + TAILWIND</span>
            </div>
        </div>
        <div class="mt-16">
            <div class="w-1 h-1 bg-white/10 rounded-full"></div>
        </div>
    </div>
</footer>
</body>
</html>
