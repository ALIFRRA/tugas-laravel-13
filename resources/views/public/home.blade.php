@extends('layouts.public')

@section('title', 'SMK Shuka — Portal Resmi Sekolah Menengah Kejuruan Musik & Media')

@section('content')
<div class="space-y-10 pb-10">

    <!-- bilah warta dan pengumuman dengan animasi berjalan dari kiri ke kanan -->
    @if(isset($pengumumans) && count($pengumumans) > 0)
        <div class="bg-slate-900 text-white py-2.5 px-4 border-b border-slate-800 overflow-hidden">
            <div class="max-w-6xl mx-auto flex items-center gap-3">
                <div class="flex items-center gap-2 shrink-0 z-10 bg-slate-900 pr-2">
                    <span class="px-2 py-0.5 rounded font-bold text-[10px] uppercase bg-pink-500 text-white flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                        Warta
                    </span>
                    <span class="hidden sm:inline font-semibold text-slate-300 text-xs">Pengumuman:</span>
                </div>
                <div class="min-w-0 flex-1 overflow-hidden relative">
                    <div class="warta-running-track flex w-max items-center gap-10 hover:[animation-play-state:paused] text-xs">
                        @foreach($pengumumans as $p)
                            <span class="flex items-center gap-2 shrink-0">
                                <span class="px-1.5 py-0.5 text-[10px] font-bold rounded uppercase {{ $p->tipe === 'mendesak' ? 'bg-rose-500 text-white' : ($p->tipe === 'penting' ? 'bg-amber-500 text-white' : 'bg-sky-500 text-white') }}">
                                    {{ $p->tipe }}
                                </span>
                                <span class="font-bold text-pink-300">[{{ $p->judul }}]</span>
                                <span class="text-slate-300">{{ Str::limit($p->isi, 95) }}</span>
                                <span class="text-slate-500 font-mono">•</span>
                            </span>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('public.agenda') }}" class="text-pink-400 font-bold hover:underline shrink-0 text-[11px] z-10 bg-slate-900 pl-2">
                    Semua Warta →
                </a>
            </div>
        </div>

        <style>
            @keyframes warta-left-to-right {
                from { transform: translateX(-100%); }
                to { transform: translateX(100%); }
            }
            .warta-running-track {
                animation: warta-left-to-right 22s linear infinite;
            }
            @media (prefers-reduced-motion: reduce) {
                .warta-running-track { animation: none; transform: none; }
            }
        </style>
    @endif

    <!-- banner utama identitas sekolah kejuruan jepang dengan latar gambar transparan -->
    <section class="relative overflow-hidden bg-slate-100 py-10 sm:py-14 border-b border-slate-200">
        <!-- background gambar festival dengan lapisan transparan -->
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/shuka-festival.jpg') }}');"></div>
        <div class="absolute inset-0 bg-white/80 backdrop-blur-[1px]"></div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-8 space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-pink-50 border border-pink-200 text-pink-700 text-xs font-semibold">
                        <span class="w-2 h-2 rounded-full bg-pink-500 animate-pulse"></span>
                        <span>Sekolah Menengah Kejuruan Seni Musik & Teknologi Media</span>
                    </div>

                    <div class="space-y-1">
                        <span class="text-xs font-mono tracking-widest text-slate-500 block">秀華高等専門学校 • SHUKA VOCATIONAL ACADEMY</span>
                        <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-slate-900 leading-tight">
                            Mencetak Generasi Kreatif, Tangguh & Berdaya Saing Industri
                        </h1>
                    </div>

                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-2xl">
                        Pendidikan vokasi terpadu berbasis kurikulum industri modern dengan 5 program keahlian unggulan di bidang seni musik populer, tata suara panggung, desain visual, rekayasa perangkat lunak, dan manajemen bisnis pertunjukan.
                    </p>

                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <a href="{{ route('public.jurusan') }}" class="px-4 py-2.5 rounded bg-pink-500 hover:bg-pink-600 text-white font-bold text-xs transition-colors shadow-2xs flex items-center gap-2">
                            <span>Jelajahi 5 Program Keahlian</span>
                            <span>→</span>
                        </a>
                        <a href="{{ route('login') }}" class="px-4 py-2.5 rounded bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 font-semibold text-xs transition-colors shadow-2xs">
                            Akses Portal SIA Siswa & Guru
                        </a>
                    </div>
                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- sorotan 5 program keahlian kejuruan -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2 border-b border-slate-200 pb-3">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-pink-600 block">Kurikulum Vokasi</span>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-900">5 Program Kejuruan Unggulan</h2>
            </div>
            <a href="{{ route('public.jurusan') }}" class="text-xs font-semibold text-pink-600 hover:underline">
                Lihat Detail Kurikulum & Guru Pengampu →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- 1. SMP -->
            <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-2xs space-y-2.5 hover:border-pink-300 transition-all">
                <div class="flex items-center justify-between">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-pink-50 text-pink-700 border border-pink-200">Kode: SMP</span>
                    <span class="text-[11px] text-slate-400 font-mono">3 Tahun</span>
                </div>
                <h3 class="text-sm font-bold text-slate-900">Seni Musik Populer & Ensembel</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Penguasaan instrumen gitar, bass, drum, vokal, dan aransemen harmonisasi band panggung standar konser.
                </p>
            </div>

            <!-- 2. AET -->
            <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-2xs space-y-2.5 hover:border-sky-300 transition-all">
                <div class="flex items-center justify-between">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-200">Kode: AET</span>
                    <span class="text-[11px] text-slate-400 font-mono">3 Tahun</span>
                </div>
                <h3 class="text-sm font-bold text-slate-900">Audio Engineering & Tata Suara</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Teknik live sound mixing konsol panggung, mastering audio digital studio, dan instalasi akustik ruang.
                </p>
            </div>

            <!-- 3. DKV -->
            <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-2xs space-y-2.5 hover:border-purple-300 transition-all">
                <div class="flex items-center justify-between">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200">Kode: DKV</span>
                    <span class="text-[11px] text-slate-400 font-mono">3 Tahun</span>
                </div>
                <h3 class="text-sm font-bold text-slate-900">Desain Komunikasi Visual & Merchandise</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Ilustrasi karakter, desain sampul album musik, tipografi digital, dan perancangan merchandise band.
                </p>
            </div>

            <!-- 4. RPL -->
            <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-2xs space-y-2.5 hover:border-emerald-300 transition-all">
                <div class="flex items-center justify-between">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Kode: RPL</span>
                    <span class="text-[11px] text-slate-400 font-mono">3 Tahun</span>
                </div>
                <h3 class="text-sm font-bold text-slate-900">Rekayasa Perangkat Lunak & Multimedia</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Pemrograman web, basis data, aplikasi mobile akademik, dan integrasi perangkat lunak audio modern.
                </p>
            </div>

            <!-- 5. MBE -->
            <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-2xs space-y-2.5 hover:border-amber-300 transition-all">
                <div class="flex items-center justify-between">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">Kode: MBE</span>
                    <span class="text-[11px] text-slate-400 font-mono">3 Tahun</span>
                </div>
                <h3 class="text-sm font-bold text-slate-900">Manajemen Bisnis Pertunjukan</h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Manajemen panggung konser, tata kelola venue livehouse, promosi media festival, dan relasi artis.
                </p>
            </div>

            <!-- Kartu Info Fasilitas Studio -->
            <div class="bg-slate-900 text-white rounded-lg p-5 shadow-2xs flex flex-col justify-between space-y-3">
                <div class="space-y-1">
                    <span class="text-[10px] font-mono tracking-wider text-pink-400 uppercase">Mitra Industri</span>
                    <h3 class="text-sm font-bold">Livehouse STARRY & Studio Rekaman</h3>
                    <p class="text-xs text-slate-300">Praktik kerja industri langsung di venue musik profesional.</p>
                </div>
                <a href="{{ route('public.profil') }}" class="text-xs font-bold text-pink-400 hover:text-pink-300 flex items-center gap-1">
                    <span>Lihat Profil Fasilitas</span>
                    <span>→</span>
                </a>
            </div>
        </div>
    </section>

    <!-- sambutan kepala sekolah & komitmen mutu -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="bg-white border border-slate-200 rounded-xl p-6 sm:p-8 shadow-2xs grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
            <div class="md:col-span-4 flex flex-col items-center text-center p-4 bg-slate-50 rounded-lg border border-slate-200">
                <div class="w-20 h-20 rounded-full bg-pink-100 border-2 border-pink-300 flex items-center justify-center font-bold text-xl text-pink-700 mb-3 shadow-2xs">
                    星歌
                </div>
                <h4 class="text-sm font-bold text-slate-900">Seika Ijichi, S.Sn., M.Pd.</h4>
                <span class="text-[11px] text-pink-600 font-semibold mt-0.5">Kepala Sekolah SMK Shuka</span>
                <span class="text-[10px] text-slate-400 mt-1 font-mono">NIP: 198504122008012001</span>
            </div>

            <div class="md:col-span-8 space-y-3">
                <div class="inline-block px-2.5 py-0.5 rounded bg-pink-50 text-pink-700 border border-pink-200 text-[11px] font-bold">
                    Sambutan Pimpinan Institusi
                </div>
                <h3 class="text-lg font-bold text-slate-900">
                    "Panggung Nyata Adalah Ruang Belajar Terbaik Siswa"
                </h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    SMK Shuka berkomitmen menggabungkan disiplin kejuruan standar Jepang dengan kebebasan berekspresi dalam karya seni dan teknologi. Kami membina setiap talenta peserta didik agar siap berkarier di industri kreatif profesional.
                </p>
                <div class="pt-2">
                    <a href="{{ route('public.profil') }}" class="text-xs font-bold text-pink-600 hover:underline">
                        Baca Selengkapnya Tentang Visi Misi Sekolah →
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- warta agenda dan pengumuman -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- pengumuman resmi -->
        <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-2xs space-y-3">
            <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">Pengumuman Sekolah</h3>
                <a href="{{ route('public.agenda') }}" class="text-[11px] text-pink-600 font-semibold hover:underline">Semua →</a>
            </div>

            <div class="space-y-2">
                @forelse ($pengumumans as $peng)
                    <div class="p-3 bg-slate-50 rounded border border-slate-200 text-xs">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-bold text-slate-900">{{ $peng->judul }}</span>
                            <span class="text-[10px] text-slate-500">{{ $peng->created_at->format('d M Y') }}</span>
                        </div>
                        <p class="text-[11px] text-slate-600 line-clamp-2 leading-relaxed">{{ $peng->isi }}</p>
                    </div>
                @empty
                    <div class="p-4 text-center text-xs text-slate-400">Belum ada pengumuman terbit.</div>
                @endforelse
            </div>
        </div>

        <!-- kalender agenda kegiatan -->
        <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-2xs space-y-3">
            <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">Agenda Kegiatan Sekolah</h3>
                <a href="{{ route('public.agenda') }}" class="text-[11px] text-pink-600 font-semibold hover:underline">Semua →</a>
            </div>

            <div class="space-y-2">
                @forelse ($agendas as $ag)
                    <div class="p-3 bg-slate-50 rounded border border-slate-200 text-xs flex items-center justify-between gap-3">
                        <div>
                            <span class="font-bold text-slate-900 block">{{ $ag->judul }}</span>
                            <span class="text-[11px] text-slate-500">Lokasi: {{ $ag->lokasi ?? 'SMK Shuka' }}</span>
                        </div>
                        <span class="px-2 py-1 rounded bg-white border border-slate-300 text-pink-600 font-bold text-[11px] shrink-0">
                            {{ $ag->tanggal ?? 'Jadwal Rutin' }}
                        </span>
                    </div>
                @empty
                    <div class="p-4 text-center text-xs text-slate-400">Belum ada agenda terdaftar.</div>
                @endforelse
            </div>
        </div>
    </section>

</div>
@endsection
