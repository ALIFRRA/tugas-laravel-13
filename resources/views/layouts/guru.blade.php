<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal Guru — SMK Shuka')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'system-ui', '-apple-system', 'Segoe UI', 'Roboto', 'sans-serif'],
                    },
                    colors: {
                        pink: {
                            50: '#fdf2f8',
                            100: '#fce7f3',
                            200: '#fbcfe8',
                            300: '#f9a8d4',
                            400: '#f472b6',
                            500: '#ec4899',
                            600: '#db2777',
                            700: '#be185d',
                            800: '#9d174d',
                            900: '#831843',
                        },
                        slate: {
                            850: '#151f33',
                            900: '#0f172a',
                            950: '#020617',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; border-color: #e2e8f0; }
        body { font-family: 'Plus Jakarta Sans', Inter, system-ui, sans-serif; background-color: #f8fafc; color: #1e293b; -webkit-font-smoothing: antialiased; }
        [x-cloak] { display: none !important; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex text-slate-800 antialiased" x-data="{ sidebarOpen: false }">

    <!-- BACKDROP MOBILE -->
    <div 
        x-show="sidebarOpen" 
        x-cloak 
        @click="sidebarOpen = false" 
        class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden transition-opacity"
    ></div>

    <!-- SIDEBAR GURU (Flat, Solid Pink Theme, Rapi) -->
    <aside 
        class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 flex flex-col justify-between transition-transform duration-200 lg:static lg:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        <div class="flex flex-col flex-1 overflow-y-auto">
            
            <!-- Logo & Brand Header -->
            <div class="h-16 px-5 border-b border-slate-200 flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-pink-500 text-white flex items-center justify-center font-bold text-lg rounded shadow-sm shrink-0">
                        秀
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-slate-900 leading-tight">SMK SHUKA</span>
                        <span class="text-[10px] font-semibold text-pink-600">Portal Guru</span>
                    </div>
                </a>
                <button type="button" @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Menu Navigasi Guru -->
            <div class="p-3 space-y-6">
                
                <div>
                    <span class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Utama</span>
                    <div class="space-y-1 text-xs">
                        <a href="{{ route('guru.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded font-semibold transition-colors {{ request()->routeIs('guru.dashboard') ? 'bg-pink-500 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('guru.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Dashboard Guru</span>
                        </a>

                        <a href="{{ route('guru.nilai.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded font-semibold transition-colors {{ request()->routeIs('guru.nilai.*') ? 'bg-pink-500 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('guru.nilai.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Input & Nilai Siswa</span>
                        </a>
                    </div>
                </div>

                <div>
                    <span class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Kesiswaan & Kegiatan</span>
                    <div class="space-y-1 text-xs">
                        <a href="{{ route('admin.pelanggaran.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded font-semibold transition-colors {{ request()->routeIs('admin.pelanggaran.*') ? 'bg-pink-500 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.pelanggaran.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <span>Kedisiplinan & Hukuman</span>
                        </a>

                        <a href="{{ route('admin.agenda.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded font-semibold transition-colors {{ request()->routeIs('admin.agenda.*') ? 'bg-pink-500 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.agenda.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Agenda & Kalender</span>
                        </a>

                        <a href="{{ route('admin.ekskul.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded font-semibold transition-colors {{ request()->routeIs('admin.ekskul.*') ? 'bg-pink-500 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.ekskul.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                            <span>Ekstrakurikuler & Klub</span>
                        </a>

                        <a href="{{ route('admin.siswa.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded font-semibold transition-colors {{ request()->routeIs('admin.siswa.*') ? 'bg-pink-500 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.siswa.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <span>Direktori Siswa</span>
                        </a>
                    </div>
                </div>

                <div>
                    <span class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Akun</span>
                    <div class="space-y-1 text-xs">
                        <a href="{{ route('profile.show', Auth::id()) }}" class="flex items-center gap-2.5 px-3 py-2 rounded font-semibold transition-colors {{ request()->routeIs('profile.show') ? 'bg-pink-500 text-white shadow-sm' : 'text-slate-700 hover:bg-slate-100' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('profile.show') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>Profil Pendidik</span>
                        </a>

                        <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-3 py-2 rounded font-semibold text-slate-700 hover:bg-slate-100 transition-colors">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            <span>Lihat Web Sekolah</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>

        <!-- Footer Sidebar -->
        <div class="p-3 border-t border-slate-200 bg-slate-50 space-y-2">
            <div class="flex items-center gap-2.5 px-2 py-1.5">
                <x-avatar :user="Auth::user()" size="sm" />
                <div class="min-w-0">
                    <span class="text-xs font-bold text-slate-900 truncate block">{{ Auth::user()->name }}</span>
                    <span class="text-[10px] text-pink-600 font-semibold block">Guru Kejuruan</span>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-1.5 px-3 bg-white hover:bg-rose-50 text-rose-600 border border-slate-200 hover:border-rose-200 text-xs font-semibold rounded transition-colors text-center">
                    Keluar Sesi
                </button>
            </form>
        </div>
    </aside>

    <!-- WRAPPER UTAMA KONTEN -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen">
        
        <!-- HEADER ATAS -->
        <header class="h-16 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <button type="button" @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-600 hover:text-slate-900 border border-slate-200 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div>
                    <h1 class="text-sm sm:text-base font-bold text-slate-900 leading-none">@yield('heading', 'Dashboard Guru')</h1>
                    @hasSection('subheading')
                        <p class="text-[11px] text-slate-500 mt-0.5">@yield('subheading')</p>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('profile.show', Auth::id()) }}" class="flex items-center gap-2 px-2.5 py-1.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded text-xs">
                    <x-avatar :user="Auth::user()" size="sm" />
                    <span class="hidden sm:inline font-bold text-slate-800">{{ Auth::user()->name }}</span>
                </a>
            </div>
        </header>

        <!-- NOTIFIKASI PENGUMUMAN (JIKA ADA) -->
        @php
            $activeAnnouncement = \App\Models\Pengumuman::where('is_active', true)->latest()->first();
        @endphp
        @if($activeAnnouncement)
            <div class="bg-pink-50 border-b border-pink-200 px-4 sm:px-6 py-2 text-xs flex items-center justify-between gap-3">
                <div class="flex items-center gap-2 overflow-hidden">
                    <span class="px-1.5 py-0.2 rounded font-bold text-[10px] uppercase bg-pink-500 text-white shrink-0">
                        Info
                    </span>
                    <span class="font-bold text-slate-900 truncate">{{ $activeAnnouncement->judul }}:</span>
                    <span class="text-slate-600 truncate hidden md:inline">{{ $activeAnnouncement->isi }}</span>
                </div>
                <a href="{{ route('public.agenda') }}" class="text-[11px] font-bold text-pink-700 hover:underline shrink-0">
                    Lihat Pengumuman →
                </a>
            </div>
        @endif

        <!-- MAIN KONTEN -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 space-y-6">
            <x-alert />
            @yield('content')
        </main>

        <!-- FOOTER HALAMAN -->
        <footer class="mt-auto bg-white border-t border-slate-200 px-6 py-4 text-xs text-slate-500 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <strong class="text-slate-700">SMK Shuka — Portal Guru</strong> &copy; 2026.
            </div>
            <div class="flex items-center gap-2 text-[11px]">
                <span class="text-slate-500">Livehouse STARRY Partnership</span>
            </div>
        </footer>

    </div>

</body>
</html>