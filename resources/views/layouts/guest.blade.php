<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Shuka Highschool') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=caveat:500,600,700|nunito:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-shuka-ink antialiased">
    <div class="relative min-h-screen overflow-hidden bg-shuka-blush">
        <div class="pointer-events-none absolute inset-0 bg-strings opacity-60"></div>
        <div class="pointer-events-none absolute -right-20 top-16 h-72 w-72 rounded-full bg-shuka-pink/10 blur-3xl"></div>

        <div class="relative mx-auto flex min-h-screen max-w-5xl flex-col justify-center px-4 py-10 sm:px-6">
            <div class="mb-8 flex items-end justify-between gap-4">
                <div>
                    <a href="{{ route('home') }}" class="font-display text-4xl text-shuka-pink sm:text-5xl">Shuka Highschool</a>
                    <p class="mt-2 max-w-sm text-sm text-shuka-muted">Masuk pelan-pelan. Bocchi juga dulu gugup di depan pintu.</p>
                </div>
                <img src="{{ asset('images/bocchi-shy.png') }}" alt="Hitori Gotou" class="bocchi-mascot h-24 w-20 object-contain object-bottom sm:h-28 sm:w-24">
            </div>

            <div class="notebook-edge w-full max-w-md p-6 sm:p-8">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
