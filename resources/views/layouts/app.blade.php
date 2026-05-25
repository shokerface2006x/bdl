<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Личный кабинет | BLUEDAY'SLIPS</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            /* Используем ту же картинку, что и на главной */
            background-image: url("{{ asset('image/bg.png') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-color: black;
        }
    </style>
</head>
<body class="font-sans antialiased text-white">
<div class="min-h-screen bg-black/70 backdrop-blur-sm">
    @include('layouts.navigation')

    @isset($header)
        <header class="bg-white/5 border-b border-white/10 shadow-2xl">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="text-white uppercase tracking-widest font-bold">
                    {{ $header }}
                </div>
            </div>
        </header>
    @endisset

    <main>
        {{ $slot }}
    </main>
</div>
</body>
</html>
