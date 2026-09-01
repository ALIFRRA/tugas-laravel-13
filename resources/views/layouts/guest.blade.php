<?php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Masuk Portal — SMK Shuka')</title>
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
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-shell bg-slate-50 min-h-screen text-slate-800 antialiased">

    <div class="min-h-screen flex flex-col lg:flex-row">
        
        <!-- SISI KIRI: BRANDING & ROLE CREDENTIALS (SPLIT PANEL) -->
        <div class="lg:w-5/12 bg-slate-900 text-white p-6 sm:p-10 lg:p-12 flex flex-col justify-between border-r border-slate-800">
            <!-- Header Brand -->
            <div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                    <div class="w-11 h-11 bg-pink-500 text-white flex items-center justify-center font-bold text-xl rounded shadow-md group-hover:bg-pink-600 transition-colors shrink-0">
                        秀
                    </div>
                    <div>
                        <span class="block text-lg font-bold tracking-tight text-white leading-tight">SMK SHUKA</span>
                        <span class="block text-xs font-semibold text-pink-400">秀華高等専門 SIA Portal</span>
                    </div>
                </a>

                <div class="mt-8 space-y-2">
                    <h2 class="text-xl sm:text-2xl font-bold tracking-tight text-white">Sistem Informasi Akademik</h2>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed">
                        Portal layanan digital sekolah kejuruan musik populer, audio engineering, DKV, RPL, dan manajemen pertunjukan.
                    </p>
                </div>
            </div>

            <!-- Role Selector & Quick Account Hints -->
            <div class="my-6 pt-5 border-t border-slate-800">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-2.5">Pilih Akun Demo Cepat (1-Click)</span>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-2">
                    <button type="button" onclick="fillLogin('admin@shuka.test', 'password')" class="w-full text-left p-2.5 rounded bg-slate-800/80 hover:bg-slate-800 border border-slate-700 hover:border-pink-500/50 transition-all flex items-center justify-between group">
                        <div>
                            <span class="block text-xs font-bold text-white group-hover:text-pink-400">Super Administrator</span>
                            <span class="block text-[11px] text-slate-400 font-mono">admin@shuka.test</span>
                        </div>
                        <span class="text-[10px] bg-pink-500/20 text-pink-300 px-2 py-0.5 rounded font-semibold">Admin</span>
                    </button>

                    <button type="button" onclick="fillLogin('seika@shuka.test', 'password')" class="w-full text-left p-2.5 rounded bg-slate-800/80 hover:bg-slate-800 border border-slate-700 hover:border-pink-500/50 transition-all flex items-center justify-between group">
                        <div>
                            <span class="block text-xs font-bold text-white group-hover:text-pink-400">Kepala Sekolah (Seika)</span>
                            <span class="block text-[11px] text-slate-400 font-mono">seika@shuka.test</span>
                        </div>
                        <span class="text-[10px] bg-purple-500/20 text-purple-300 px-2 py-0.5 rounded font-semibold">Pimpinan</span>
                    </button>

                    <button type="button" onclick="fillLogin('pasan@shuka.test', 'password')" class="w-full text-left p-2.5 rounded bg-slate-800/80 hover:bg-slate-800 border border-slate-700 hover:border-pink-500/50 transition-all flex items-center justify-between group">
                        <div>
                            <span class="block text-xs font-bold text-white group-hover:text-pink-400">Wakepsek IT (PA-san)</span>
                            <span class="block text-[11px] text-slate-400 font-mono">pasan@shuka.test</span>
                        </div>
                        <span class="text-[10px] bg-sky-500/20 text-sky-300 px-2 py-0.5 rounded font-semibold">Kurikulum</span>
                    </button>

                    <button type="button" onclick="fillLogin('guru10@shuka.test', 'password')" class="w-full text-left p-2.5 rounded bg-slate-800/80 hover:bg-slate-800 border border-slate-700 hover:border-pink-500/50 transition-all flex items-center justify-between group">
                        <div>
                            <span class="block text-xs font-bold text-white group-hover:text-pink-400">Guru (Yoshida Emi, S.Pd.)</span>
                            <span class="block text-[11px] text-slate-400 font-mono">guru10@shuka.test</span>
                        </div>
                        <span class="text-[10px] bg-amber-500/20 text-amber-300 px-2 py-0.5 rounded font-semibold">Guru</span>
                    </button>

                    <button type="button" onclick="fillLogin('student1@murid.shuka.test', 'password')" class="w-full text-left p-2.5 rounded bg-slate-800/80 hover:bg-slate-800 border border-slate-700 hover:border-pink-500/50 transition-all flex items-center justify-between group">
                        <div>
                            <span class="block text-xs font-bold text-white group-hover:text-pink-400">Siswa (Hitori Gotoh)</span>
                            <span class="block text-[11px] text-slate-400 font-mono">student1@murid.shuka.test</span>
                        </div>
                        <span class="text-[10px] bg-emerald-500/20 text-emerald-300 px-2 py-0.5 rounded font-semibold">Siswa</span>
                    </button>
                </div>
                <span class="block text-[10px] text-slate-400 mt-2">Password default: <span class="font-mono text-slate-200">password</span> (klik untuk mengisi otomatis)</span>
            </div>

            <!-- Footer Sisi Kiri -->
            <div class="pt-4 border-t border-slate-800/60 flex items-center justify-between text-xs text-slate-400">
                <a href="{{ route('home') }}" class="text-slate-400 hover:text-pink-400 transition-colors">
                    ← Beranda Sekolah
                </a>
                <span>&copy; 2026 SMK Shuka</span>
            </div>
        </div>

        <!-- SISI KANAN: FORM CONTAINER -->
        <div class="lg:w-7/12 bg-white flex flex-col justify-center items-center p-6 sm:p-10 lg:p-14">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </div>

    </div>

    <script>
        function fillLogin(email, password) {
            const emailInput = document.getElementById('email');
            const passInput = document.getElementById('password');
            if (emailInput) {
                emailInput.value = email;
                emailInput.focus();
            }
            if (passInput) {
                passInput.value = password;
            }
        }
    </script>
</body>
</html>