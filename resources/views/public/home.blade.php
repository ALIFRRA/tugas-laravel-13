@extends('layouts.public')

@section('title', 'SMK Shuka — Portal Resmi Sekolah Menengah Kejuruan Musik & Media')

@section('content')
<div class="space-y-8 overflow-x-hidden pb-8 sm:space-y-10">

    <!-- 1. ANIMATED ANNOUNCEMENT BANNER -->
    @if(isset($pengumumans) && count($pengumumans) > 0)
        <div class="bg-slate-950 text-white py-3 px-4">
            <div class="max-w-6xl mx-auto">
                <div class="flex items-center gap-3 overflow-hidden">
                    <span class="px-2 py-0.5 rounded font-bold text-[10px] uppercase bg-pink-500 text-white shrink-0">
                        <svg class="w-3 h-3 inline-block mr-1 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        Info Terkini
                    </span>
                    <div class="min-w-0 flex-1 overflow-hidden">
                        <div class="announcement-track flex w-max items-center gap-8 hover:[animation-play-state:paused]">
                            @foreach($pengumumans as $p)
                                <span class="flex items-center gap-2 shrink-0">
                            <span class="px-1.5 py-0.5 text-[10px] font-bold rounded uppercase {{ $p->tipe === 'mendesak' ? 'bg-rose-500 text-white' : ($p->tipe === 'penting' ? 'bg-amber-500 text-white' : 'bg-sky-500 text-white') }}">
                                {{ $p->tipe }}
                            </span>
                            <span>{{ $p->judul }}</span>
                            <span class="text-slate-400">—</span>
                            <span class="truncate max-w-xs">{{ Str::limit($p->isi, 100) }}</span>
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        @keyframes announcement-left-to-right {
            from { transform: translateX(-100%); }
            to { transform: translateX(100%); }
        }

        .announcement-track {
            animation: announcement-left-to-right 24s linear infinite;
        }

        @media (prefers-reduced-motion: reduce) {
            .announcement-track { animation: none; transform: none; }
        }
    </style>

    <!-- 2. HERO BANNER with Japanese School Background -->
    <section class="relative overflow-hidden bg-slate-100 py-10 sm:py-14">
        <div class="absolute inset-0 opacity-70" style="background-image: linear-gradient(135deg, rgba(236,72,153,.08) 25%, transparent 25%), linear-gradient(315deg, rgba(14,165,233,.07) 25%, transparent 25%); background-size: 42px 42px; background-position: 0 0, 21px 21px;"></div>
        <!-- School Building Silhouette Decoration -->
        <div class="hidden absolute top-0 left-0 right-0 h-64 bg-transparent border-2 border-pink-200 overflow-hidden">
            <svg class="absolute inset-0 w-full h-full fill-none stroke-pink-200 stroke-width-2" viewBox="0 0 100 100">
                <path d="M10 80 Q 40 10 70 80 Q 90 10 90 80 Q 90 90 70 90 Q 40 90 10 80 Z M20 50 Q 30 30 50 50 Q 70 50 80 50 Q 90 50 90 30 Q 90 20 70 20 Q 50 20 20 20 Q 10 20 10 50 Z M40 60 Q 50 40 60 60 Q 70 60 70 40 Q 70 20 50 20 Q 30 20 20 20 Z M60 70 Q 70 50 70 30 Q 70 10 50 10 Q 30 10 30 30 Q 30 50 60 50 Z M80 60 Q 70 50 60 50 Q 50 50 50 30 Q 50 10 30 10 Q 20 10 20 30 Q 20 50 30 50 Z"/>
            </svg>
        </div>
        <div class="hidden absolute inset-0" x-data="{
            particles: Array.from({length: 12}, () => ({
                x: Math.random() * 100,
                y: Math.random() * 100,
                size: Math.random() * 3 + 1,
                speed: Math.random() * 0.2 + 0.1,
                opacity: Math.random() * 0.4 + 0.1
            }))
        }">
            <template x-for="p in particles" :key="p.x">
                <div class="absolute rounded-full bg-pink-500"
                     :style="{
                         left: p.x + '%',
                         top: p.y + '%',
                         width: p.size + 'px',
                         height: p.size + 'px',
                         opacity: p.opacity,
                         animation: `float ${25/p.speed}s infinite ease-in-out`
                     }"></div>
            </template>
        </div>
        <style>
            @keyframes float {
                0%,100% { transform: translateY(0) translateX(0) scale(1); }
                25% { transform: translateY(-30px) translateX(15px) scale(1.2); }
                50% { transform: translateY(15px) translateX(-10px) scale(0.8); }
                75% { transform: translateY(-20px) translateX(20px) scale(1.1); }
            }
            @keyframes sakura-fall {
                0% { transform: translateY(-100px) rotate(0deg); opacity: 0; }
                10% { opacity: 1; }
                90% { opacity: 1; }
                100% { transform: translateY(100vh) rotate(360deg); opacity: 0; }
            }
        </style>

        <!-- Floating Sakura Petals -->
        <div class="hidden absolute inset-0 overflow-hidden pointer-events-none" x-data="{
            petals: Array.from({length: 8}, () => ({
                x: Math.random() * 100,
                y: -Math.random() * 100,
                size: Math.random() * 6 + 3,
                speed: Math.random() * 10 + 8,
                delay: Math.random() * 4,
                rotation: Math.random() * 360,
                drift: (Math.random() - 0.5) * 15
            }))
        }">
            <template x-for="p in petals" :key="p.x">
                <div class="absolute bg-pink-300 opacity-50 rounded-full"
                     :style="{
                         left: p.x + '%',
                         top: p.y + '%',
                         width: p.size + 'px',
                         height: p.size + 'px',
                         animation: `sakura-fall ${p.speed}s ${p.delay}s infinite linear`,
                         transform: `rotate(${p.rotation}deg) translateX(${p.drift}px)`
                     }"></div>
            </template>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">

            <div class="lg:col-span-7 space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-slate-100 text-slate-700 border border-slate-200 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-pink-500 animate-pulse"></span>
                    <span>秀華高等専門学校 (SMK Shuka Tokyo)</span>
                </div>

                <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Harmoni Musik & Teknologi Kreatif
                </h1>

                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed text-justify sm:text-left">
                    SMK Shuka menyelenggarakan pendidikan kejuruan tingkat menengah berstandar industri seni pertunjukan musik populer, rekayasa tata suara (audio engineering), desain visual merchandise, pemrograman web, dan manajemen live event yang bermitra langsung dengan Livehouse STARRY di Shimokitazawa.
                </p>

                <!-- STATISTIK RINGKAS -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-2">
                    <div class="p-3 bg-white/80 backdrop-blur-sm border border-slate-200 rounded hover:border-pink-300 hover:shadow-lg transition-all duration-300">
                        <span class="text-xl font-bold text-slate-900 block">{{ number_format($siswaCount) }}</span>
                        <span class="text-[10px] text-slate-500 font-medium">Total Siswa</span>
                    </div>
                    <div class="p-3 bg-white/80 backdrop-blur-sm border border-slate-200 rounded hover:border-pink-300 hover:shadow-lg transition-all duration-300">
                        <span class="text-xl font-bold text-slate-900 block">{{ $tenagaCount }}</span>
                            <span class="text-[10px] text-slate-500 font-medium">Tenaga Kependidikan</span>
                    </div>
                    <div class="p-3 bg-white/80 backdrop-blur-sm border border-slate-200 rounded hover:border-pink-300 hover:shadow-lg transition-all duration-300">
                        <span class="text-xl font-bold text-slate-900 block">{{ $mapelCount }}</span>
                        <span class="text-[10px] text-slate-500 font-medium">Mata Pelajaran</span>
                    </div>
                    <div class="p-3 bg-white/80 backdrop-blur-sm border border-slate-200 rounded hover:border-pink-300 hover:shadow-lg transition-all duration-300">
                        <span class="text-xl font-bold text-pink-600 block">{{ $programCount }}</span>
                        <span class="text-[10px] text-slate-500 font-medium">Program Keahlian</span>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <a href="{{ route('public.profil') }}" class="px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold text-xs rounded transition-colors shadow-sm">
                        Profil Lengkap Sekolah →
                    </a>
                    <a href="{{ route('public.jurusan') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs rounded border border-slate-300 transition-colors">
                        {{ $programCount }} Program Keahlian →
                    </a>
                </div>
            </div>

            <!-- CARD SAMBUTAN KEPALA SEKOLAH & VISI -->
            <div class="lg:col-span-5 space-y-3">
                <div class="bg-white/80 backdrop-blur-sm border border-slate-200 rounded-lg p-5 shadow-sm space-y-3 hover:shadow-md hover:border-pink-200 transition-all duration-300">
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-200">
                        <div class="w-10 h-10 bg-pink-100 text-pink-700 rounded-full flex items-center justify-center font-bold text-base border border-pink-300 shrink-0 relative overflow-hidden">
                            <x-avatar name="Seika Ijichi" size="md" class="w-full h-full object-cover" />
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-slate-900">Sambutan & Visi Pendidikan</h3>
                            <p class="text-[10px] text-slate-500">Mencetak Talenta Panggung & Praktisi Berintegritas</p>
                        </div>
                    </div>

                    <blockquote class="text-xs text-slate-600 leading-relaxed italic">
                        "Di SMK Shuka, siswa tidak hanya dilatih keterampilan memainkan instrumen teknis atau software audio, melainkan dibentuk mental panggung konser yang tangguh, kedisiplinan kerja tim ensembel, dan etika profesi nyata."
                    </blockquote>

                    <div class="pt-2 border-t border-slate-200 flex items-center justify-between text-xs">
                        <div>
                            <span class="font-bold text-slate-900 block text-xs">Seika Ijichi, S.Sn., M.Pd.</span>
                            <span class="text-[10px] text-slate-500">Kepala Program Industri & Pembina Musik</span>
                        </div>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-pink-50 text-pink-700 border border-pink-200">
                            STARRY Hub
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 3. HIGHLIGHT 5 PROGRAM KEAHLIAN -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
            <div>
                <span class="text-[10px] font-bold text-pink-600 uppercase tracking-wider">Course Curriculum</span>
                <h2 class="text-lg font-bold text-slate-900">5 Program Keahlian SMK Shuka</h2>
            </div>
            <a href="{{ route('public.jurusan') }}" class="text-xs font-semibold text-pink-600 hover:underline">
                Lihat Detail Jurusan & Kurikulum →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div class="p-3.5 bg-white border border-slate-200 rounded-lg shadow-sm border-t-2 border-t-pink-500 flex flex-col justify-between hover:border-pink-300 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div>
                    <span class="text-[10px] font-bold text-pink-600 uppercase">SMP</span>
                    <h3 class="text-xs font-bold text-slate-900 mt-0.5">Seni Musik Populer</h3>
                    <p class="text-[11px] text-slate-600 mt-1 leading-relaxed">Gitar, bass, drum, vokal, dan aransemen band konser festival.</p>
                </div>
                <a href="{{ route('public.jurusan') }}#smp" class="mt-2 text-[10px] font-bold text-pink-600 hover:underline">Selengkapnya →</a>
            </div>

            <div class="p-3.5 bg-white border border-slate-200 rounded-lg shadow-sm border-t-2 border-t-sky-600 flex flex-col justify-between hover:border-sky-300 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div>
                    <span class="text-[10px] font-bold text-sky-700 uppercase">AET</span>
                    <h3 class="text-xs font-bold text-slate-900 mt-0.5">Audio Engineering</h3>
                    <p class="text-[11px] text-slate-600 mt-1 leading-relaxed">Sound reinforcement, live console mixing, dan DAW studio.</p>
                </div>
                <a href="{{ route('public.jurusan') }}#aet" class="mt-2 text-[10px] font-bold text-sky-700 hover:underline">Selengkapnya →</a>
            </div>

            <div class="p-3.5 bg-white border border-slate-200 rounded-lg shadow-sm border-t-2 border-t-amber-500 flex flex-col justify-between hover:border-amber-300 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div>
                    <span class="text-[10px] font-bold text-amber-700 uppercase">DKV</span>
                    <h3 class="text-xs font-bold text-slate-900 mt-0.5">Desain Visual</h3>
                    <p class="text-[11px] text-slate-600 mt-1 leading-relaxed">Merchandise band, cover album vinyl, dan fotografi panggung.</p>
                </div>
                <a href="{{ route('public.jurusan') }}#dkv" class="mt-2 text-[10px] font-bold text-amber-700 hover:underline">Selengkapnya →</a>
            </div>

            <div class="p-3.5 bg-white border border-slate-200 rounded-lg shadow-sm border-t-2 border-t-indigo-600 flex flex-col justify-between hover:border-indigo-300 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div>
                    <span class="text-[10px] font-bold text-indigo-700 uppercase">RPL</span>
                    <h3 class="text-xs font-bold text-slate-900 mt-0.5">Rekayasa Software</h3>
                    <p class="text-[11px] text-slate-600 mt-1 leading-relaxed">Web portal SIA, basis data multimedia, dan audio synthesizer.</p>
                </div>
                <a href="{{ route('public.jurusan') }}#rpl" class="mt-2 text-[10px] font-bold text-indigo-700 hover:underline">Selengkapnya →</a>
            </div>

            <div class="p-3.5 bg-white border border-slate-200 rounded-lg shadow-sm border-t-2 border-t-emerald-600 flex flex-col justify-between hover:border-emerald-300 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div>
                    <span class="text-[10px] font-bold text-emerald-700 uppercase">MBE</span>
                    <h3 class="text-xs font-bold text-slate-900 mt-0.5">Bisnis Event</h3>
                    <p class="text-[11px] text-slate-600 mt-1 leading-relaxed">Manajemen konser musik, promosi livehouse, dan hospitality cafe.</p>
                </div>
                <a href="{{ route('public.jurusan') }}#mbe" class="mt-2 text-[10px] font-bold text-emerald-700 hover:underline">Selengkapnya →</a>
            </div>
        </div>
    </section>

<!-- 4. ROTATING TEACHER QUOTES / SPOTLIGHT -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
            <div>
                <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Teacher's Voice</span>
                <h2 class="text-lg font-bold text-slate-900">Kata-Kata Tenaga Pendidik</h2>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-lg p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <x-avatar name="{{ $teacherQuotes[0]['avatar'] }}" size="lg" class="shrink-0" />
                <div>
                    <blockquote class="text-sm text-slate-700 leading-relaxed italic">{{ $teacherQuotes[0]['text'] }}</blockquote>
                    <div class="mt-3 flex items-center gap-2">
                        <span class="font-semibold text-slate-900">{{ $teacherQuotes[0]['author'] }}</span>
                        <span class="text-slate-400">•</span>
                        <span class="text-xs text-slate-500">{{ $teacherQuotes[0]['role'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. SISWA BERPRESTASI / TOP ACHIEVERS -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
            <div>
                <span class="text-[10px] font-bold text-amber-600 uppercase tracking-wider">Hall of Fame</span>
                <h2 class="text-lg font-bold text-slate-900">Siswa Berprestasi (Saat Ini)</h2>
                <p class="text-xs text-slate-500 mt-0.5">Siswa dengan nilai rata-rata tertinggi & berprestasi akademik</p>
            </div>
            <a href="{{ route('public.agenda') }}" class="text-xs font-semibold text-pink-600 hover:underline">
                Lihat Semua Prestasi →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            @forelse ($highAchievers as $item)
                @php
                    $siswa = $item['siswa'];
                    $avgNilai = $item['avg_nilai'];
                    // Extract jurusan from kelas (e.g., X-SMP-1 -> SMP)
                    $jurusan = explode('-', $siswa->kelas)[1] ?? 'SMP';
                @endphp
                <div class="p-3.5 bg-white border border-slate-200 rounded-lg shadow-sm hover:border-amber-300 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                    <div class="text-center mb-3">
                        <x-avatar :user="$siswa->user ?? null" :name="$siswa->nama" size="lg" class="mx-auto mb-2 border-2 border-amber-200 group-hover:border-amber-400 transition-colors" />
                        <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                            {{ $jurusan }}
                        </div>
                    </div>
                    <h4 class="text-xs font-bold text-slate-900 text-center truncate mb-1">{{ $siswa->nama }}</h4>
                    <div class="flex items-center justify-center gap-1 mb-2">
                        <svg class="w-3 h-3 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.858-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <span class="text-[10px] font-bold text-amber-600">{{ $avgNilai }}</span>
                    </div>
                    <p class="text-[10px] text-slate-600 text-center leading-snug">Rata-rata Nilai: {{ $avgNilai }}</p>
                    <p class="text-[9px] text-amber-700 text-center mt-1 truncate">Kelas: {{ $siswa->kelas }}</p>
                </div>
            @empty
                <div class="col-span-full text-center py-8 text-slate-400 text-xs">
                    Belum ada data siswa berprestasi.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 6. ALUMNI TERBAIK / LULUSAN TERBAIK -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
            <div>
                <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Hall of Fame</span>
                <h2 class="text-lg font-bold text-slate-900">Lulusan Terbaik & Alumni Berprestasi</h2>
                <p class="text-xs text-slate-500 mt-0.5">Alumni dengan nilai tertinggi yang sukses di industri kreatif & musik</p>
            </div>
            <a href="{{ route('public.agenda') }}" class="text-xs font-semibold text-pink-600 hover:underline">
                Lihat Semua Prestasi →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            @foreach ($topAlumni as $alumni)
                <div class="p-3.5 bg-white border border-slate-200 rounded-lg shadow-sm hover:border-emerald-300 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
                    <div class="text-center mb-3">
                        <x-avatar :name="$alumni['nama']" :avatar="$alumni['avatar']" size="lg" class="mx-auto mb-2 border-2 border-emerald-200 group-hover:border-emerald-400 transition-colors" />
                        <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            {{ $alumni['jurusan'] }}
                        </div>
                    </div>
                    <h4 class="text-xs font-bold text-slate-900 text-center truncate mb-1">{{ $alumni['nama'] }}</h4>
                    <div class="flex items-center justify-center gap-1 mb-2">
                        <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.858-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <span class="text-[10px] font-bold text-emerald-600">Alumni Pilihan</span>
                    </div>
                    <p class="text-[10px] text-slate-600 text-center leading-snug">{{ $alumni['pencapaian'] }}</p>
                    <p class="text-[9px] text-emerald-700 text-center mt-1 truncate">Program {{ $alumni['jurusan'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 7. BERITA & AGENDA SEKOLAH -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Kolom Kiri: Papan Pengumuman -->
            <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-2.5 border-b border-slate-200">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-pink-500 rounded-full animate-pulse"></span>
                        <h3 class="text-sm font-bold text-slate-900">Pengumuman Resmi Sekolah</h3>
                    </div>
                    <a href="{{ route('public.agenda') }}" class="text-[11px] font-semibold text-pink-600 hover:underline">Semua Pengumuman →</a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse ($pengumumans as $p)
                        <div class="py-2.5 hover:bg-slate-50 transition-colors group">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[10px] px-1.5 py-0.2 font-bold rounded uppercase {{ $p->tipe === 'mendesak' ? 'bg-rose-50 text-rose-700 border border-rose-200' : ($p->tipe === 'penting' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-sky-50 text-sky-700 border border-sky-200') }}">
                                    {{ $p->tipe }}
                                </span>
                                <span class="text-[10px] text-slate-400 font-mono">{{ $p->created_at->format('Y.m.d') }}</span>
                            </div>
                            <h4 class="text-xs font-bold text-slate-900 leading-snug group-hover:text-pink-600 transition-colors">{{ $p->judul }}</h4>
                            <p class="text-[11px] text-slate-600 line-clamp-2 mt-0.5">{{ $p->isi }}</p>
                        </div>
                    @empty
                        <div class="py-4 text-center text-xs text-slate-400">Belum ada pengumuman baru.</div>
                    @endforelse
                </div>
            </div>

            <!-- Kolom Kanan: Kalender Agenda Kegiatan -->
            <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-2.5 border-b border-slate-200">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-sky-600 rounded-full"></span>
                        <h3 class="text-sm font-bold text-slate-900">Agenda Kegiatan Terdekat</h3>
                    </div>
                    <a href="{{ route('public.agenda') }}" class="text-[11px] font-semibold text-pink-600 hover:underline">Semua Agenda →</a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse ($agendas as $a)
                        <div class="py-2.5 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-1.5 py-0.2 rounded border border-slate-200">
                                    {{ $a->kategori }}
                                </span>
                                <span class="text-[10px] font-bold text-pink-600">{{ $a->status }}</span>
                            </div>
                            <h4 class="text-xs font-bold text-slate-900 leading-snug">{{ $a->judul }}</h4>
                            <div class="text-[11px] text-slate-500 mt-0.5">
                                <strong>{{ $a->tanggal }}</strong> • Lokasi: {{ $a->lokasi ?? 'SMK Shuka' }}
                            </div>
                        </div>
                    @empty
                        <div class="py-4 text-center text-xs text-slate-400">Belum ada agenda terdekat.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </section>

    <!-- 8. KILAS TENAGA PENDIDIK & KLUB EKSTRAKURIKULER -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Tenaga Pendidik -->
            <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Guru Pengajar</h3>
                    <a href="{{ route('public.guru') }}" class="text-[11px] font-semibold text-pink-600 hover:underline">Daftar {{ number_format($guruCount) }} Guru →</a>
                </div>

                <div class="grid grid-cols-2 gap-2.5">
                    @foreach ($gurus->take(4) as $guru)
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded flex items-center gap-2 group">
                            <x-avatar :user="$guru->user" size="sm" class="group-hover:ring-2 group-hover:ring-pink-300 transition-all" />
                            <div class="min-w-0">
                                <span class="font-bold text-slate-900 block truncate text-[11px]">{{ $guru->nama }}</span>
                                <span class="text-[10px] text-slate-500 truncate block">
                                    {{ $guru->mataPelajarans->first()->nama ?? ($guru->user?->jabatan ?? 'Guru') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Ekstrakurikuler -->
            <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Klub Ekstrakurikuler</h3>
                    <a href="{{ route('public.ekskul') }}" class="text-[11px] font-semibold text-pink-600 hover:underline">Lihat {{ number_format($ekskulCount) }} Klub →</a>
                </div>

                <div class="grid grid-cols-2 gap-2.5">
                    @foreach ($ekskuls as $ek)
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded hover:border-pink-300 transition-colors">
                            <span class="font-bold text-slate-900 block truncate text-[11px]">{{ $ek->nama }}</span>
                            <span class="text-[10px] text-pink-600 font-medium">{{ $ek->jadwal ?? 'Jadwal menyusul' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <div class="mt-6 rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">Staf TU & Tenaga Pendukung</h3>
                    <p class="mt-0.5 text-[11px] text-slate-500">Administrasi, IT, kesiswaan, sarana, dan operasional studio.</p>
                </div>
                <span class="text-[11px] font-semibold text-slate-500">{{ $staffCount }} orang</span>
            </div>
            <div class="mt-3 grid grid-cols-1 gap-2.5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($staff->take(4) as $staffMember)
                    <div class="flex items-center gap-2 rounded border border-slate-200 bg-slate-50 p-2.5">
                        <x-avatar :user="$staffMember" size="sm" />
                        <div class="min-w-0">
                            <span class="block truncate text-[11px] font-bold text-slate-900">{{ $staffMember->name }}</span>
                            <span class="block truncate text-[10px] text-slate-500">{{ $staffMember->jabatan ?? 'Staf Tata Usaha' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 9. KESSOKU BAND FEATURED MEMBERS -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 gap-4 rounded-xl border border-pink-100 bg-pink-50/50 p-4 sm:grid-cols-2 lg:grid-cols-3 sm:p-5">
            <div class="bg-white rounded-xl p-4 shadow-sm border border-pink-200">
                <div class="w-12 h-12 bg-pink-100 text-pink-600 rounded-full flex items-center justify-center font-bold text-xs mb-2">
                    <img src="/images/bocchi.png" alt="Hitori Gotoh" class="w-6 h-6">
                </div>
                <h4 class="text-sm font-bold text-slate-900">Hitori Gotoh</h4>
                <p class="text-xs text-slate-500">Gitari & Vokal</p>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-pink-200">
                <div class="w-12 h-12 bg-pink-100 text-pink-600 rounded-full flex items-center justify-center font-bold text-xs mb-2">
                    <img src="/images/bocchi-shy.png" alt="Ikuyo Kita" class="w-6 h-6">
                </div>
                <h4 class="text-sm font-bold text-slate-900">Ikuyo Kita</h4>
                <p class="text-xs text-slate-500">Audio Engineering</p>
            </div>
            <div class="bg-pink-50 rounded-xl p-4 shadow-sm border border-pink-200">
                <div class="w-12 h-12 bg-pink-200 text-pink-600 rounded-full flex items-center justify-center font-bold text-xs mb-2">
                    <img src="/images/bocchi-maid.png" alt="Futari Gotoh" class="w-6 h-6">
                </div>
                <h4 class="text-sm font-bold text-slate-900">Futari Gotoh</h4>
                <p class="text-xs text-slate-500">StARRY Cafe & Hospitality</p>
            </div>
        </div>
    </section>
</div>

@endsection
