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
<body class="font-sans antialiased">
    <div class="min-h-screen bg-shuka-blush">
        @include('layouts.navigation')

        @isset($header)
            <header class="border-b border-shuka-line bg-white">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-5 sm:px-6 lg:px-8">
                    <div>{{ $header }}</div>
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/bocchi-shy.png') }}" alt="Hitori Gotou" class="bocchi-mascot h-12 w-10 object-contain sm:h-14 sm:w-11">
                        @auth
                            <a href="{{ route('profile.show', Auth::id()) }}" class="flex items-center gap-2">
                                <x-avatar :user="Auth::user()" size="sm" />
                                <span class="hidden text-sm text-slate-700 sm:inline">{{ Auth::user()->name }}</span>
                            </a>
                        @endauth
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
