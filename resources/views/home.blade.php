<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shuka Highschool</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=caveat:500,600,700|nunito:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-shuka-ink antialiased">
    <div class="min-h-screen bg-shuka-blush">
        <header class="border-b border-shuka-line bg-white/90">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6">
                <span class="font-display text-2xl text-shuka-pink sm:text-3xl">Shuka Highschool</span>
                <nav class="flex items-center gap-4 text-sm">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-slate-600 hover:text-shuka-pink">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-shuka-pink">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="border border-shuka-pink px-3 py-1.5 text-shuka-pink hover:bg-shuka-soft">Daftar</a>
                        @endif
                    @endauth
                </nav>
            </div>
        </header>

        <main>
            <section class="relative overflow-hidden border-b border-shuka-line">
                <div class="pointer-events-none absolute inset-0 bg-strings opacity-50"></div>
                <div class="pointer-events-none absolute right-0 top-0 h-full w-1/2 bg-[radial-gradient(circle_at_70%_35%,rgba(244,114,182,0.2),transparent_55%)]"></div>

                <div class="relative mx-auto grid max-w-6xl items-end gap-8 px-4 py-14 sm:px-6 md:grid-cols-[1.15fr_0.85fr] md:gap-12 md:py-20">
                    <div class="max-w-xl">
                        <p class="font-display text-5xl leading-none text-shuka-pink sm:text-6xl md:text-7xl">Shuka Highschool</p>
                        <h1 class="mt-6 text-lg font-semibold text-slate-700 sm:text-xl">Ruang kecil yang hangat — seperti kamar latihan Bocchi.</h1>
                        <p class="mt-3 text-sm leading-relaxed text-shuka-muted sm:text-base">Pink lembut, garis tipis, dan data akademik yang rapi. Tanpa keramaian visual.</p>
                        <div class="mt-8 flex flex-wrap gap-3">
                            @auth
                                <a href="{{ route('dashboard') }}" class="border border-shuka-pink bg-shuka-pink px-5 py-2.5 text-sm font-medium text-white hover:bg-pink-400">Ke Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="border border-shuka-pink bg-shuka-pink px-5 py-2.5 text-sm font-medium text-white hover:bg-pink-400">Masuk</a>
                                <a href="{{ route('register') }}" class="border border-shuka-line bg-white px-5 py-2.5 text-sm font-medium text-slate-700 hover:border-shuka-pink hover:text-shuka-pink">Buat akun</a>
                            @endauth
                        </div>
                    </div>

                    <div class="flex justify-center md:justify-end">
                        <div class="relative">
                            <div class="absolute -inset-3 border border-dashed border-shuka-pink/40"></div>
                            <img src="{{ asset('images/bocchi.png') }}" alt="Hitori Gotou" class="bocchi-mascot relative h-56 w-44 object-contain object-bottom sm:h-64 sm:w-52 md:h-72 md:w-56">
                        </div>
                    </div>
                </div>
            </section>

            <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
                <div class="mb-8 flex items-end justify-between gap-4 guitar-rule pb-4">
                    <div>
                        <h2 class="font-display text-3xl text-slate-800">sekilas angka</h2>
                        <p class="mt-1 text-sm text-shuka-muted">Catatan kecil dari database sekolah.</p>
                    </div>
                    <img src="{{ asset('images/bocchi-shy.png') }}" alt="" class="bocchi-mascot h-12 w-10 object-contain opacity-90">
                </div>

                <div class="grid grid-cols-2 gap-x-6 gap-y-8 md:grid-cols-4 md:gap-x-10">
                    <div class="border-l-2 border-shuka-pink pl-4">
                        <p class="font-display text-4xl text-shuka-pink">{{ $siswaCount }}</p>
                        <p class="mt-1 text-sm text-shuka-muted">Siswa</p>
                    </div>
                    <div class="border-l-2 border-shuka-string pl-4">
                        <p class="font-display text-4xl text-shuka-pink">{{ $guruCount }}</p>
                        <p class="mt-1 text-sm text-shuka-muted">Guru</p>
                    </div>
                    <div class="border-l-2 border-shuka-string pl-4">
                        <p class="font-display text-4xl text-shuka-pink">{{ $mapelCount }}</p>
                        <p class="mt-1 text-sm text-shuka-muted">Mapel</p>
                    </div>
                    <div class="border-l-2 border-shuka-string pl-4">
                        <p class="font-display text-4xl text-shuka-pink">{{ $jadwalCount }}</p>
                        <p class="mt-1 text-sm text-shuka-muted">Jadwal</p>
                    </div>
                </div>
            </section>

            <section class="border-t border-shuka-line bg-white">
                <div class="mx-auto flex max-w-6xl flex-col gap-6 px-4 py-12 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                    <div class="max-w-lg">
                        <h2 class="font-display text-3xl text-slate-800">satu notebook untuk admin</h2>
                        <p class="mt-2 text-sm leading-relaxed text-shuka-muted">Siswa, guru, mapel, jadwal, nilai — ditata pelan seperti setlist band sekolah.</p>
                    </div>
                    <a href="{{ route('login') }}" class="shrink-0 self-start border border-shuka-line px-4 py-2 text-sm text-slate-700 hover:border-shuka-pink hover:text-shuka-pink sm:self-auto">Mulai kelola</a>
                </div>
            </section>
        </main>

        <footer class="border-t border-shuka-line bg-white/70">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-5 text-sm text-shuka-muted sm:px-6">
                <span class="font-display text-xl text-shuka-pink">Shuka Highschool</span>
                <img src="{{ asset('images/bocchi-maid.png') }}" alt="Hitori Gotou" class="bocchi-mascot h-10 w-8 object-contain">
            </div>
        </footer>
    </div>
</body>
</html>
