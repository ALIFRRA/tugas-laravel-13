<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SMK Shuka — Sistem Informasi Akademik Kejuruan')</title>

    <!-- tailwind css cdn & font styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', '-apple-system', 'BlinkMacSystemFont', 'sans-serif'],
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
        body { font-family: 'Plus Jakarta Sans', Inter, sans-serif; background-color: #f8fafc; color: #1e293b; -webkit-font-smoothing: antialiased; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-shell bg-slate-100 min-h-screen text-slate-800 antialiased" x-data="{ sidebarOpen: false }">

    <!-- overlay mobile -->
    <div
        id="sidebar-overlay"
        @click="sidebarOpen = false"
        x-show="sidebarOpen"
        x-transition.opacity
        class="fixed inset-0 bg-slate-900/40 z-30 lg:hidden"
        style="display: none;"
    ></div>

    <!-- sidebar navigasi portal sekolah -->
    <aside
        id="main-sidebar"
        class="fixed top-0 bottom-0 left-0 w-64 h-full bg-white border-r border-slate-200 z-40 flex flex-col justify-between transition-transform duration-200 ease-in-out -translate-x-full lg:translate-x-0 shadow-sm"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    >
        <div class="flex flex-col h-full overflow-hidden">
            <!-- header logo sekolah -->
            <div class="h-16 flex items-center justify-between px-5 border-b border-slate-200 bg-white shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-pink-500 text-white flex items-center justify-center font-bold text-base rounded shadow-sm">
                        秀
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-bold tracking-tight text-slate-900 leading-tight">SMK Shuka</span>
                        <span class="text-[11px] font-semibold text-pink-600">秀華高等専門 SIA Portal</span>
                    </div>
                </a>
                <button type="button" @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-slate-700 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            @include('partials.sidebar')

            <!-- navigasi menu sidebar terstruktur -->
            <nav class="p-3 space-y-1 overflow-y-auto flex-1 text-xs">
                <!-- grup utama -->
                <div class="px-3 pt-2 pb-1 text-[10px] font-bold tracking-wider text-slate-400 uppercase">Utama</div>

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded text-xs font-semibold {{ request()->routeIs('dashboard') ? 'text-white bg-pink-500 shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Dashboard Utama</span>
                </a>

                <!-- grup data akademik -->
                <div class="px-3 pt-4 pb-1 text-[10px] font-bold tracking-wider text-slate-400 uppercase">Data Akademik</div>

                @if(Auth::user()?->isAdministratorLevel())
                    <a href="{{ route('admin.guru.index') }}" class="flex items-center justify-between px-3 py-2 rounded text-xs font-medium {{ request()->routeIs('admin.guru.*') ? 'text-white bg-pink-500 font-semibold shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.guru.*') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>Data Tenaga Guru</span>
                        </div>
                        <span class="text-[10px] {{ request()->routeIs('admin.guru.*') ? 'bg-pink-600 text-white' : 'bg-slate-100 text-slate-600' }} px-1.5 py-0.5 rounded font-semibold">{{ $guruCount ?? \App\Models\Guru::count() }}</span>
                    </a>
                @endif

                <a href="{{ route('admin.siswa.index') }}" class="flex items-center justify-between px-3 py-2 rounded text-xs font-medium {{ request()->routeIs('admin.siswa.*') ? 'text-white bg-pink-500 font-semibold shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.siswa.*') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Data Siswa (600 Siswa)</span>
                    </div>
                    <span class="text-[10px] {{ request()->routeIs('admin.siswa.*') ? 'bg-pink-600 text-white' : 'bg-pink-50 text-pink-700 border border-pink-200' }} px-1.5 py-0.5 rounded font-bold">600</span>
                </a>

                <a href="{{ route('admin.mapel.index') }}" class="flex items-center justify-between px-3 py-2 rounded text-xs font-medium {{ request()->routeIs('admin.mapel.*') ? 'text-white bg-pink-500 font-semibold shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.mapel.*') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>Mata Pelajaran</span>
                    </div>
                    <span class="text-[10px] text-slate-500">Read-only</span>
                </a>

                <a href="{{ route('admin.jadwal.index') }}" class="flex items-center justify-between px-3 py-2 rounded text-xs font-medium {{ request()->routeIs('admin.jadwal.*') ? 'text-white bg-pink-500 font-semibold shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.jadwal.*') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Jadwal Pelajaran</span>
                    </div>
                    <span class="text-[10px] text-slate-500">Read-only</span>
                </a>

                <!-- modul penilaian & rekap -->
                @if(Auth::user()?->isGuru())
                    <a href="{{ route('guru.nilai.index') }}" class="flex items-center justify-between px-3 py-2 rounded text-xs font-medium {{ request()->routeIs('guru.nilai.*') ? 'text-white bg-pink-500 font-semibold shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 {{ request()->routeIs('guru.nilai.*') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            <span>Input Nilai Siswa</span>
                        </div>
                        <span class="text-[10px] {{ request()->routeIs('guru.nilai.*') ? 'bg-pink-600 text-white' : 'bg-emerald-50 text-emerald-700 border border-emerald-200' }} px-1.5 py-0.5 rounded font-semibold">Input</span>
                    </a>

                    @if(Auth::user()?->isWaliKelas())
                        <a href="{{ route('admin.walikelas.index') }}" class="flex items-center justify-between px-3 py-2 rounded text-xs font-medium {{ request()->routeIs('admin.walikelas.*') ? 'text-white bg-pink-500 font-semibold shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 {{ request()->routeIs('admin.walikelas.*') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                <span>Wali Kelas ({{ Auth::user()->waliKelas() }})</span>
                            </div>
                            <span class="text-[10px] {{ request()->routeIs('admin.walikelas.*') ? 'bg-pink-600 text-white' : 'bg-pink-50 text-pink-700 border border-pink-200' }} px-1.5 py-0.5 rounded font-semibold">Wali</span>
                        </a>
                    @endif
                @endif

                @if(Auth::user()?->isAdministratorLevel() || Auth::user()?->isStaff())
                    <a href="{{ route('admin.nilai.index') }}" class="flex items-center gap-3 px-3 py-2 rounded text-xs font-medium {{ request()->routeIs('admin.nilai.index') || request()->routeIs('admin.nilai.create') || request()->routeIs('admin.nilai.edit') ? 'text-white bg-pink-500 font-semibold shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.nilai.index') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <span>Rekap & Input Nilai</span>
                    </a>

                    <a href="{{ route('admin.nilai.analisis') }}" class="flex items-center justify-between px-3 py-2 rounded text-xs font-medium {{ request()->routeIs('admin.nilai.analisis') ? 'text-white bg-pink-500 font-semibold shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.nilai.analisis') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Analisis & Ranking</span>
                        </div>
                        <span class="text-[10px] {{ request()->routeIs('admin.nilai.analisis') ? 'bg-pink-600 text-white' : 'bg-emerald-50 text-emerald-700 border border-emerald-200' }} px-1.5 py-0.5 rounded font-semibold">Rapor</span>
                    </a>

                    <a href="{{ route('admin.walikelas.index') }}" class="flex items-center justify-between px-3 py-2 rounded text-xs font-medium {{ request()->routeIs('admin.walikelas.*') ? 'text-white bg-pink-500 font-semibold shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.walikelas.*') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span>Rapor & Wali Kelas</span>
                        </div>
                        <span class="text-[10px] {{ request()->routeIs('admin.walikelas.*') ? 'bg-pink-600 text-white' : 'bg-pink-50 text-pink-700 border border-pink-200' }} px-1.5 py-0.5 rounded font-semibold">Wali</span>
                    </a>
                @endif

                <!-- grup kesiswaan & ekskul -->
                <div class="px-3 pt-4 pb-1 text-[10px] font-bold tracking-wider text-slate-400 uppercase">Kesiswaan & Ekskul</div>

                <a href="{{ route('admin.agenda.index') }}" class="flex items-center justify-between px-3 py-2 rounded text-xs font-medium {{ request()->routeIs('admin.agenda.*') ? 'text-white bg-pink-500 font-semibold shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.agenda.*') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Agenda Sekolah</span>
                    </div>
                    <span class="text-[10px] {{ request()->routeIs('admin.agenda.*') ? 'bg-pink-600 text-white' : 'bg-pink-50 text-pink-700 border border-pink-200' }} px-1.5 py-0.5 rounded font-semibold">Kalender</span>
                </a>

                <a href="{{ route('admin.ekskul.index') }}" class="flex items-center justify-between px-3 py-2 rounded text-xs font-medium {{ request()->routeIs('admin.ekskul.*') ? 'text-white bg-pink-500 font-semibold shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.ekskul.*') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                        <span>Ekstrakurikuler (12 Klub)</span>
                    </div>
                    <span class="text-[10px] {{ request()->routeIs('admin.ekskul.*') ? 'bg-pink-600 text-white' : 'bg-slate-100 text-slate-600' }} px-1.5 py-0.5 rounded font-semibold">12</span>
                </a>

                <a href="{{ route('admin.pelanggaran.index') }}" class="flex items-center justify-between px-3 py-2 rounded text-xs font-medium {{ request()->routeIs('admin.pelanggaran.*') ? 'text-white bg-pink-500 font-semibold shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.pelanggaran.*') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>Kedisiplinan & Sanksi</span>
                    </div>
                    <span class="text-[10px] {{ request()->routeIs('admin.pelanggaran.*') ? 'bg-pink-600 text-white' : 'bg-rose-50 text-rose-700 border border-rose-200' }} px-1.5 py-0.5 rounded font-semibold">BK</span>
                </a>

                <!-- grup sistem & pengumuman -->
                <div class="px-3 pt-4 pb-1 text-[10px] font-bold tracking-wider text-slate-400 uppercase">Sistem & Pengumuman</div>

                <a href="{{ route('admin.pengumuman.index') }}" class="flex items-center justify-between px-3 py-2 rounded text-xs font-medium {{ request()->routeIs('admin.pengumuman.*') ? 'text-white bg-pink-500 font-semibold shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.pengumuman.*') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                        <span>Pengumuman Sekolah</span>
                    </div>
                    <span class="text-[10px] {{ request()->routeIs('admin.pengumuman.*') ? 'bg-pink-600 text-white' : 'bg-amber-50 text-amber-700 border border-amber-200' }} px-1.5 py-0.5 rounded font-semibold">Notif</span>
                </a>

                @if(Auth::user()?->isAdministratorLevel())
                    <a href="{{ route('admin.pengguna.guru') }}" class="flex items-center justify-between px-3 py-2 rounded text-xs font-medium {{ request()->routeIs('admin.pengguna.*') ? 'text-white bg-pink-500 font-semibold shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.pengguna.*') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <span>Direktori Akun</span>
                        </div>
                        <span class="text-[10px] {{ request()->routeIs('admin.pengguna.*') ? 'bg-pink-600 text-white' : 'bg-slate-100 text-slate-600' }} px-1.5 py-0.5 rounded font-semibold">User</span>
                    </a>
                @endif

                <a href="{{ route('profile.show', Auth::id() ?? 1) }}" class="flex items-center gap-3 px-3 py-2 rounded text-xs font-medium {{ request()->routeIs('profile.*') ? 'text-white bg-pink-500 font-semibold shadow-sm' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-4 h-4 {{ request()->routeIs('profile.*') ? 'text-white' : 'text-slate-400' }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Profil Akun Saya</span>
                </a>
            </nav>

            <!-- footer status sesi & logout -->
            <div class="p-3 border-t border-slate-200 bg-slate-50 shrink-0 space-y-2">
                <div class="flex items-center justify-between text-[11px] text-slate-500">
                    <span>SMK Shuka Portal</span>
                    <span class="inline-flex items-center gap-1 font-semibold text-emerald-700">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Online
                    </span>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-1.5 px-3 text-xs font-semibold text-slate-600 bg-white border border-slate-300 hover:bg-slate-100 hover:text-slate-900 rounded transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>Keluar Sistem</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- pembungkus konten utama -->
    <div class="lg:pl-64 flex flex-col min-h-screen">

        <!-- top bar header -->
        <header class="sticky top-0 z-30 h-16 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <button type="button" @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-600 hover:text-slate-900 border border-slate-200 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="flex items-center gap-2 text-xs sm:text-sm">
                    <span class="font-semibold text-slate-500">SMK Shuka</span>
                    <span class="text-slate-300">/</span>
                    <span class="font-bold text-slate-900">@yield('heading', 'Dashboard')</span>
                </div>
            </div>

            @include('partials.navbar')
        </header>

        <!-- area konten utama -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 space-y-5">

            <!-- notifikasi pengumuman aktif -->
            @php
                $activeAnnouncements = \App\Models\Pengumuman::active()->latest()->take(2)->get();
            @endphp
            @if($activeAnnouncements->isNotEmpty())
                <div class="space-y-2.5">
                    @foreach($activeAnnouncements as $ann)
                        <div class="p-3.5 rounded-lg border flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 shadow-sm {{ $ann->tipe === 'mendesak' ? 'bg-rose-50 border-rose-300 text-rose-950' : ($ann->tipe === 'penting' ? 'bg-amber-50 border-amber-300 text-amber-950' : ($ann->tipe === 'agenda' ? 'bg-pink-50 border-pink-300 text-pink-950' : 'bg-sky-50 border-sky-300 text-sky-950')) }}">
                            <div class="flex items-start gap-3">
                                <span class="mt-0.5 shrink-0 inline-block px-2 py-0.5 text-[10px] font-extrabold rounded uppercase tracking-wider {{ $ann->tipe === 'mendesak' ? 'bg-rose-200 text-rose-900 border border-rose-300' : ($ann->tipe === 'penting' ? 'bg-amber-200 text-amber-900 border border-amber-300' : ($ann->tipe === 'agenda' ? 'bg-pink-200 text-pink-900 border border-pink-300' : 'bg-sky-200 text-sky-900 border border-sky-300')) }}">
                                    {{ $ann->tipe }}
                                </span>
                                <div>
                                    <h4 class="text-xs font-bold">{{ $ann->judul }}</h4>
                                    <p class="text-xs mt-0.5 leading-relaxed opacity-90">{{ $ann->isi }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 shrink-0 self-end sm:self-center">
                                <span class="text-[11px] text-slate-500">{{ $ann->created_at->diffForHumans() }}</span>
                                <a href="{{ route('admin.pengumuman.index') }}" class="text-[11px] font-bold text-pink-600 hover:underline">Kelola →</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- flash alerts feedback -->
            @if(session('success'))
                <div class="p-3 rounded bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-2xs">
                    <span>{{ session('success') }}</span>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 font-bold ml-3">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="p-3 rounded bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center justify-between shadow-2xs">
                    <span>{{ session('error') }}</span>
                    <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800 font-bold ml-3">&times;</button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- footer portal -->
        <footer class="bg-white border-t border-slate-200 py-3.5 px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2">
            <span>SMK Shuka — Sistem Informasi Akademik & Administrasi Kejuruan Terpadu</span>
            <span>T.A. 2026/2027 Ganjil</span>
        </footer>
    </div>
</body>
</html>
