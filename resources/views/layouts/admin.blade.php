<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=caveat:500,600,700|nunito:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans min-h-screen bg-shuka-blush">
    <div class="min-h-screen lg:flex" x-data="{ open: false }">
        <div class="lg:hidden flex items-center justify-between border-b border-shuka-line bg-white/90 px-4 py-3">
            <a href="{{ route('dashboard') }}" class="font-display text-2xl text-shuka-pink">Shuka Highschool</a>
            <button type="button" @click="open = !open" class="border border-shuka-line px-3 py-1.5 text-sm text-slate-600">
                Menu
            </button>
        </div>

        <aside
            class="fixed inset-y-0 left-0 z-40 w-60 transform border-r border-shuka-line bg-white transition-transform duration-200 lg:static lg:translate-x-0"
            :class="open ? 'translate-x-0' : '-translate-x-full'"
        >
            <div class="flex h-full flex-col bg-strings">
                <div class="border-b border-shuka-line px-5 py-5">
                    <a href="{{ route('home') }}" class="font-display text-2xl leading-none text-shuka-pink">Shuka Highschool</a>
                    <p class="mt-2 text-xs text-shuka-muted">kamar belajar yang agak pink</p>
                </div>

                <nav class="flex-1 space-y-0.5 overflow-y-auto px-3 py-4 text-sm">
                    @php
                        $links = [
                            ['route' => 'dashboard', 'label' => 'Dashboard', 'match' => 'dashboard'],
                            ['route' => 'admin.pengguna.guru', 'label' => 'Pengguna Guru', 'match' => 'admin.pengguna.guru'],
                            ['route' => 'admin.pengguna.murid', 'label' => 'Pengguna Murid', 'match' => 'admin.pengguna.murid'],
                            ['route' => 'admin.siswa.index', 'label' => 'Siswa', 'match' => 'admin.siswa.*'],
                            ['route' => 'admin.guru.index', 'label' => 'Guru', 'match' => 'admin.guru.*'],
                            ['route' => 'admin.mapel.index', 'label' => 'Mapel', 'match' => 'admin.mapel.*'],
                            ['route' => 'admin.jadwal.index', 'label' => 'Jadwal', 'match' => 'admin.jadwal.*'],
                            ['route' => 'admin.nilai.index', 'label' => 'Nilai', 'match' => 'admin.nilai.*'],
                        ];
                    @endphp
                    @foreach ($links as $link)
                        <a href="{{ route($link['route']) }}"
                           class="block border-l-2 px-3 py-2 {{ request()->routeIs($link['match']) ? 'border-shuka-pink bg-shuka-soft/70 text-shuka-pink' : 'border-transparent text-slate-600 hover:border-shuka-string hover:bg-slate-50' }}">
                            {{ $link['label'] }}
                        </a>
                    @endforeach
                    <a href="{{ route('profile.show', Auth::id()) }}"
                       class="block border-l-2 px-3 py-2 {{ request()->routeIs('profile.show') ? 'border-shuka-pink bg-shuka-soft/70 text-shuka-pink' : 'border-transparent text-slate-600 hover:border-shuka-string hover:bg-slate-50' }}">
                        Profil
                    </a>
                </nav>

                <div class="border-t border-shuka-line px-4 py-4">
                    <div class="mb-3 flex items-end gap-2">
                        <img src="{{ asset('images/bocchi-maid.png') }}" alt="Hitori Gotou" class="bocchi-mascot h-16 w-12 object-contain object-bottom">
                        <p class="pb-1 text-[11px] leading-snug text-shuka-muted">…masih latihan<br>hari ini juga.</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full border border-shuka-line px-3 py-2 text-left text-sm text-slate-600 hover:border-shuka-pink hover:text-shuka-pink">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div
            class="fixed inset-0 z-30 bg-slate-900/10 lg:hidden"
            x-show="open"
            x-transition.opacity
            @click="open = false"
            style="display: none;"
        ></div>

        <div class="flex min-h-screen flex-1 flex-col">
            <header class="border-b border-shuka-line bg-white/95 px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between gap-4">
                    <div class="min-w-0">
                        <h1 class="page-title truncate">@yield('heading')</h1>
                        @hasSection('subheading')
                            <p class="mt-0.5 text-sm text-shuka-muted">@yield('subheading')</p>
                        @endif
                    </div>

                    <div class="flex shrink-0 items-center gap-3 sm:gap-4">
                        <img src="{{ asset('images/bocchi-shy.png') }}" alt="Hitori Gotou" class="bocchi-mascot hidden h-12 w-10 object-contain sm:block md:h-14 md:w-11">

                        <a href="{{ route('profile.show', Auth::id()) }}" class="flex items-center gap-2 border border-shuka-line bg-shuka-blush px-2 py-1.5 hover:border-shuka-pink sm:px-3">
                            <x-avatar :user="Auth::user()" size="sm" />
                            <span class="hidden max-w-[9rem] truncate text-sm font-medium text-slate-700 sm:inline">
                                {{ Auth::user()->name }}
                            </span>
                        </a>
                    </div>
                </div>
            </header>

            <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                <x-alert />
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
