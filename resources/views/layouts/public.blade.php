<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ec4899">
    <meta name="description" content="@yield('meta_description', 'SMK Shuka - Sekolah Menengah Kejuruan Musik & Media Kreatif di Shimokitazawa, Tokyo')">
    <title>@yield('title', 'SMK Shuka — Portal Informasi Akademik Kejuruan')</title>
    
    <!-- Performance: DNS Prefetch & Preconnect -->
    <link rel="dns-prefetch" href="https://cdn.tailwindcss.com">
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://api.dicebear.com" crossorigin>
    
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
                            500: '#ec4899', /* Solid Bocchi Pink */
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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; border-color: #e2e8f0; }
        body { font-family: 'Plus Jakarta Sans', Inter, system-ui, sans-serif; background-color: #f8fafc; color: #1e293b; -webkit-font-smoothing: antialiased; }
        /* Progressive image loading */
        img[loading="lazy"] { opacity: 0; transition: opacity 0.3s ease; }
        img[loading="lazy"].loaded { opacity: 1; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen flex flex-col text-slate-800 antialiased" x-data="{ mobileMenuOpen: false }">

    <!-- 1. TOP UTILITY BAR -->
    <div class="bg-slate-900 text-slate-300 text-xs py-1.5 px-4 border-b border-slate-800">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 text-[11px]">
            <div class="flex items-center gap-3">
                <span class="font-bold text-white tracking-wide">秀華高等専門学校</span>
                <span class="text-slate-600">|</span>
                <span class="text-slate-400">SMK Shuka Tokyo (Shimokitazawa Campus)</span>
            </div>
            <div class="flex items-center gap-4 text-slate-400">
                <span class="text-pink-400 font-semibold">T.A. 2026/2027 Semester 1</span>
                <a href="{{ route('public.kontak') }}" class="hover:text-white transition-colors">Akses & Transportasi</a>
                <span class="text-slate-700">•</span>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-pink-400 font-bold hover:underline">Dashboard SIA →</a>
                @else
                    <a href="{{ route('login') }}" class="text-pink-400 font-bold hover:underline">Masuk Portal SIA →</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- 2. HEADER RESMI SEKOLAH DENGAN LOGO KANJI -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="h-20 flex items-center justify-between">
                
                <!-- Logo & Identitas Institusi -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 bg-pink-500 text-white flex items-center justify-center font-bold text-xl rounded shadow-sm group-hover:bg-pink-600 transition-colors shrink-0">
                        秀
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-baseline gap-2">
                            <span class="text-lg font-bold tracking-tight text-slate-900 leading-none">SMK SHUKA</span>
                        </div>
                        <span class="text-[10px] text-slate-500 mt-1 uppercase tracking-wider font-medium">Shuka Vocational High School of Creative Industries & Music</span>
                    </div>
                </a>

                <!-- Navigasi Utama -->
                <nav class="hidden lg:flex items-center gap-1 text-xs font-semibold">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded flex flex-col items-center leading-tight transition-colors {{ request()->routeIs('home') ? 'text-pink-600 font-bold bg-pink-50 border-b-2 border-pink-500' : 'text-slate-700 hover:text-pink-600 hover:bg-slate-50' }}">
                        <span>Beranda</span>
                    </a>

                    <a href="{{ route('public.profil') }}" class="px-3 py-2 rounded flex flex-col items-center leading-tight transition-colors {{ request()->routeIs('public.profil') ? 'text-pink-600 font-bold bg-pink-50 border-b-2 border-pink-500' : 'text-slate-700 hover:text-pink-600 hover:bg-slate-50' }}">
                        <span>Profil</span>
                    </a>

                    <a href="{{ route('public.jurusan') }}" class="px-3 py-2 rounded flex flex-col items-center leading-tight transition-colors {{ request()->routeIs('public.jurusan') ? 'text-pink-600 font-bold bg-pink-50 border-b-2 border-pink-500' : 'text-slate-700 hover:text-pink-600 hover:bg-slate-50' }}">
                        <span>Program Keahlian</span>
                    </a>

                    <a href="{{ route('public.guru') }}" class="px-3 py-2 rounded flex flex-col items-center leading-tight transition-colors {{ request()->routeIs('public.guru') ? 'text-pink-600 font-bold bg-pink-50 border-b-2 border-pink-500' : 'text-slate-700 hover:text-pink-600 hover:bg-slate-50' }}">
                        <span>Tenaga Pendidik</span>
                    </a>

                    <a href="{{ route('public.ekskul') }}" class="px-3 py-2 rounded flex flex-col items-center leading-tight transition-colors {{ request()->routeIs('public.ekskul') ? 'text-pink-600 font-bold bg-pink-50 border-b-2 border-pink-500' : 'text-slate-700 hover:text-pink-600 hover:bg-slate-50' }}">
                        <span>Ekstrakurikuler</span>
                    </a>

                    <a href="{{ route('public.agenda') }}" class="px-3 py-2 rounded flex flex-col items-center leading-tight transition-colors {{ request()->routeIs('public.agenda') ? 'text-pink-600 font-bold bg-pink-50 border-b-2 border-pink-500' : 'text-slate-700 hover:text-pink-600 hover:bg-slate-50' }}">
                        <span>Agenda & Notif</span>
                    </a>

                    <a href="{{ route('public.kontak') }}" class="px-3 py-2 rounded flex flex-col items-center leading-tight transition-colors {{ request()->routeIs('public.kontak') ? 'text-pink-600 font-bold bg-pink-50 border-b-2 border-pink-500' : 'text-slate-700 hover:text-pink-600 hover:bg-slate-50' }}">
                        <span>Kontak & Akses</span>
                    </a>
                </nav>

                <!-- Tombol Masuk SIA & Mobile Menu -->
                <div class="flex items-center gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="hidden sm:inline-flex items-center px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold text-xs rounded transition-colors shadow-sm">
                            Dashboard SIA →
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold text-xs rounded transition-colors shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            <span>Masuk Portal SIA</span>
                        </a>
                    @endauth

                    <button 
                        type="button" 
                        @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="lg:hidden p-2 text-slate-600 hover:text-slate-900 border border-slate-200 rounded"
                        aria-label="Toggle Menu"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileMenuOpen" x-cloak class="lg:hidden bg-white border-b border-slate-200 px-4 py-3 space-y-1 text-xs font-semibold text-slate-700">
            <a href="{{ route('home') }}" @click="mobileMenuOpen = false" class="block py-2 px-2 rounded hover:bg-pink-50 hover:text-pink-600 {{ request()->routeIs('home') ? 'bg-pink-50 text-pink-600 font-bold' : '' }}">Beranda</a>
            <a href="{{ route('public.profil') }}" @click="mobileMenuOpen = false" class="block py-2 px-2 rounded hover:bg-pink-50 hover:text-pink-600 {{ request()->routeIs('public.profil') ? 'bg-pink-50 text-pink-600 font-bold' : '' }}">Profil Sekolah</a>
            <a href="{{ route('public.jurusan') }}" @click="mobileMenuOpen = false" class="block py-2 px-2 rounded hover:bg-pink-50 hover:text-pink-600 {{ request()->routeIs('public.jurusan') ? 'bg-pink-50 text-pink-600 font-bold' : '' }}">Program Keahlian</a>
            <a href="{{ route('public.guru') }}" @click="mobileMenuOpen = false" class="block py-2 px-2 rounded hover:bg-pink-50 hover:text-pink-600 {{ request()->routeIs('public.guru') ? 'bg-pink-50 text-pink-600 font-bold' : '' }}">Tenaga Pendidik</a>
            <a href="{{ route('public.ekskul') }}" @click="mobileMenuOpen = false" class="block py-2 px-2 rounded hover:bg-pink-50 hover:text-pink-600 {{ request()->routeIs('public.ekskul') ? 'bg-pink-50 text-pink-600 font-bold' : '' }}">Ekstrakurikuler</a>
            <a href="{{ route('public.agenda') }}" @click="mobileMenuOpen = false" class="block py-2 px-2 rounded hover:bg-pink-50 hover:text-pink-600 {{ request()->routeIs('public.agenda') ? 'bg-pink-50 text-pink-600 font-bold' : '' }}">Agenda & Pengumuman</a>
            <a href="{{ route('public.kontak') }}" @click="mobileMenuOpen = false" class="block py-2 px-2 rounded hover:bg-pink-50 hover:text-pink-600 {{ request()->routeIs('public.kontak') ? 'bg-pink-50 text-pink-600 font-bold' : '' }}">Kontak & Akses</a>
            <div class="pt-2 border-t border-slate-100">
                <a href="{{ route('login') }}" class="block text-center py-2 bg-pink-500 text-white rounded font-bold">Masuk Portal SIA</a>
            </div>
        </div>
    </header>

    <!-- 3. PAGE HEADER BANNER (Jika bukan di Home) -->
    @hasSection('page_header')
        <div class="bg-slate-900 text-white py-8 sm:py-10 border-b border-slate-800">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-pink-400">@yield('page_subheading', '秀華高等専門学校')</span>
                        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mt-1 text-white">@yield('page_heading')</h1>
                        <p class="text-xs text-slate-300 mt-1 max-w-2xl">@yield('page_description')</p>
                    </div>
                    <div class="text-[11px] text-slate-400 sm:text-right">
                        <a href="{{ route('home') }}" class="hover:text-white">Home</a> / <span class="text-pink-400">@yield('page_heading')</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- 4. KONTEN UTAMA -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- 5. FOOTER RESMI SEKOLAH -->
    <footer class="bg-slate-900 text-slate-300 border-t border-slate-800 pt-10 pb-6 text-xs mt-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 grid grid-cols-1 md:grid-cols-12 gap-8">
            
            <!-- Profil Institusi -->
            <div class="md:col-span-5 space-y-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 bg-pink-500 text-white flex items-center justify-center font-bold text-sm rounded shrink-0">
                        秀
                    </div>
                    <div>
                        <span class="text-sm font-bold text-white block leading-tight">SMK SHUKA (秀華高等専門学校)</span>
                        <span class="text-[10px] text-slate-400">Shuka Technical High School of Music & Media</span>
                    </div>
                </div>
                <p class="text-slate-400 text-[11px] leading-relaxed">
                    Sekolah Menengah Kejuruan kejuruan seni musik modern, audio engineering, desain visual, rekayasa perangkat lunak, dan manajemen live event yang terintegrasi dengan industri livehouse di Shimokitazawa, Tokyo.
                </p>
                <div class="text-[11px] text-slate-400 space-y-0.5">
                    <div>Shimokitazawa, Setagaya, Tokyo 155-0031</div>
                    <div>Telp: (03) 3468-SHUKA • Email: info@smk-shuka.sch.id</div>
                </div>
            </div>

            <!-- Jurusan Kejuruan -->
            <div class="md:col-span-4 space-y-2 text-[11px]">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider mb-2">Program Keahlian</h3>
                <ul class="space-y-1.5 text-slate-400">
                    <li><a href="{{ route('public.jurusan') }}#smp" class="hover:text-pink-400 transition-colors">• Seni Musik Populer (SMP)</a></li>
                    <li><a href="{{ route('public.jurusan') }}#aet" class="hover:text-pink-400 transition-colors">• Audio Engineering & PA (AET)</a></li>
                    <li><a href="{{ route('public.jurusan') }}#dkv" class="hover:text-pink-400 transition-colors">• Desain Visual & Merchandise (DKV)</a></li>
                    <li><a href="{{ route('public.jurusan') }}#rpl" class="hover:text-pink-400 transition-colors">• Rekayasa Software & Multimedia (RPL)</a></li>
                    <li><a href="{{ route('public.jurusan') }}#mbe" class="hover:text-pink-400 transition-colors">• Manajemen Bisnis Pertunjukan (MBE)</a></li>
                </ul>
            </div>

            <!-- Navigasi Cepat -->
            <div class="md:col-span-3 space-y-2 text-[11px]">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider mb-2">Navigasi Halaman</h3>
                <ul class="space-y-1.5 text-slate-400">
                    <li><a href="{{ route('public.profil') }}" class="hover:text-white">• Profil Sekolah</a></li>
                    <li><a href="{{ route('public.guru') }}" class="hover:text-white">• Tenaga Pendidik</a></li>
                    <li><a href="{{ route('public.ekskul') }}" class="hover:text-white">• Klub Ekstrakurikuler</a></li>
                    <li><a href="{{ route('public.agenda') }}" class="hover:text-white">• Agenda & Pengumuman</a></li>
                    <li><a href="{{ route('public.kontak') }}" class="hover:text-white">• Akses Kampus</a></li>
                    <li><a href="{{ route('login') }}" class="text-pink-400 font-semibold hover:underline">• Portal SIA</a></li>
                </ul>
            </div>

        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 pt-6 mt-6 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-500 gap-2">
            <div>&copy; 2026 秀華高等専門学校 (SMK Shuka). All Rights Reserved.</div>
            <div class="text-slate-400">Livehouse STARRY Partnership Campus</div>
        </div>
    </footer>

</body>
</html>