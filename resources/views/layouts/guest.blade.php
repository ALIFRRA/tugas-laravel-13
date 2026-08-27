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
<body class="bg-slate-100 min-h-screen flex flex-col justify-center items-center py-10 px-4 sm:px-6 text-slate-800 antialiased">

    <div class="w-full max-w-md space-y-6">

        <!-- Logo & Header Brand -->
        <div class="text-center space-y-2">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                <div class="w-12 h-12 bg-pink-500 text-white flex items-center justify-center font-bold text-xl rounded shadow-sm group-hover:bg-pink-600 transition-colors shrink-0">
                    秀
                </div>
                <div class="text-left">
                    <span class="block text-lg font-bold tracking-tight text-slate-900 leading-tight">SMK SHUKA</span>
                    <span class="block text-xs font-semibold text-pink-600">Portal Siswa & Guru</span>
                </div>
            </a>
            <p class="text-xs text-slate-500">Sistem Informasi Akademik & Portal Siswa-Guru</p>
        </div>

        <!-- Main Card Container -->
        <div class="bg-white border border-slate-200 rounded-lg p-6 sm:p-8 shadow-sm">
            {{ $slot }}
        </div>

        <!-- Back to Home Link -->
        <div class="text-center text-xs text-slate-500">
            <a href="{{ route('home') }}" class="text-slate-600 hover:text-pink-600 hover:underline">
                ← Kembali ke Beranda Sekolah
            </a>
        </div>

    </div>

</body>
</html>