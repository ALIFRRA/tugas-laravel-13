@extends('layouts.public')

@section('title', 'SMK Shuka (秀華高等専門学校) — Portal Resmi Sekolah Menengah Kejuruan Musik & Media')

@section('content')
<div class="space-y-12 pb-6">

    <!-- 1. NOTIFIKASI PENGUMUMAN TERKINI (お知らせ) -->
    @if(isset($pengumumans) && count($pengumumans) > 0)
        <div class="bg-pink-50 border-b border-pink-200 py-2.5 px-4 text-xs">
            <div class="max-w-6xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div class="flex items-center gap-2 overflow-hidden">
                    <span class="px-2 py-0.5 rounded font-bold text-[10px] uppercase bg-pink-500 text-white shrink-0">
                        最新情報 (Info Baru)
                    </span>
                    <span class="font-bold text-slate-900 truncate">{{ $pengumumans[0]->judul }}</span>
                    <span class="hidden md:inline text-slate-600 truncate">— {{ Str::limit($pengumumans[0]->isi, 80) }}</span>
                </div>
                <a href="{{ route('public.agenda') }}" class="text-pink-700 font-bold hover:underline shrink-0 text-[11px]">
                    Daftar Pengumuman →
                </a>
            </div>
        </div>
    @endif

    <!-- 2. HERO BANNER KHAS SEKOLAH JEPANG (トップバナー) -->
    <section class="bg-white border-b border-slate-200 py-10 sm:py-14">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            
            <div class="lg:col-span-7 space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-slate-100 text-slate-700 border border-slate-200 text-xs font-semibold">
                    <span class="w-2 h-2 rounded-full bg-pink-500"></span>
                    <span>秀華高等専門学校 (SMK Shuka Tokyo)</span>
                </div>

                <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Harmoni Musik & Teknologi Kreatif<br>
                    <span class="text-pink-500">音楽とクリエイティブ技術の専門教育</span>
                </h1>

                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed text-justify sm:text-left">
                    SMK Shuka menyelenggarakan pendidikan kejuruan tingkat menengah berstandar industri seni pertunjukan musik populer, rekayasa tata suara (*audio engineering*), desain visual merchandise, pemrograman web, dan manajemen *live event* yang bermitra langsung dengan Livehouse STARRY di Shimokitazawa.
                </p>

                <!-- STATISTIK RINGKAS -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 pt-2">
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded">
                        <span class="text-xl font-bold text-slate-900 block">{{ number_format($siswaCount) }}</span>
                        <span class="text-[10px] text-slate-500 font-medium">生徒数 (600 Murid)</span>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded">
                        <span class="text-xl font-bold text-slate-900 block">{{ $guruCount }}</span>
                        <span class="text-[10px] text-slate-500 font-medium">教員数 (45 Guru)</span>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded">
                        <span class="text-xl font-bold text-slate-900 block">{{ $mapelCount }}</span>
                        <span class="text-[10px] text-slate-500 font-medium">開講科目 (28 Mapel)</span>
                    </div>
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded">
                        <span class="text-xl font-bold text-pink-600 block">5</span>
                        <span class="text-[10px] text-slate-500 font-medium">学科 (5 Jurusan)</span>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <a href="{{ route('public.profil') }}" class="px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold text-xs rounded transition-colors shadow-sm">
                        Profil Lengkap Sekolah (学校案内) →
                    </a>
                    <a href="{{ route('public.jurusan') }}" class="px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs rounded border border-slate-300 transition-colors">
                        5 Program Keahlian (学科紹介)
                    </a>
                </div>
            </div>

            <!-- CARD SAMBUTAN KEPALA SEKOLAH & VISI -->
            <div class="lg:col-span-5 space-y-3">
                <div class="bg-slate-50 border border-slate-200 rounded-lg p-5 shadow-sm space-y-3">
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-200">
                        <div class="w-10 h-10 bg-pink-100 text-pink-700 rounded-full flex items-center justify-center font-bold text-base border border-pink-300 shrink-0">
                            秀
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-slate-900">校長挨拶・教育理念 (Visi Pendidikan)</h3>
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

    <!-- 3. HIGHLIGHT 5 PROGRAM KEAHLIAN (学科紹介) -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
            <div>
                <span class="text-[10px] font-bold text-pink-600 uppercase tracking-wider">Course Curriculum</span>
                <h2 class="text-lg font-bold text-slate-900">5 Program Keahlian SMK Shuka (設置学科)</h2>
            </div>
            <a href="{{ route('public.jurusan') }}" class="text-xs font-semibold text-pink-600 hover:underline">
                Lihat Detail Jurusan & Kurikulum →
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div class="p-3.5 bg-white border border-slate-200 rounded-lg shadow-sm border-t-2 border-t-pink-500 flex flex-col justify-between">
                <div>
                    <span class="text-[10px] font-bold text-pink-600 uppercase">SMP (音楽科)</span>
                    <h3 class="text-xs font-bold text-slate-900 mt-0.5">Seni Musik Populer</h3>
                    <p class="text-[11px] text-slate-600 mt-1 leading-relaxed">Gitar, bass, drum, vokal, dan aransemen band konser festival.</p>
                </div>
                <a href="{{ route('public.jurusan') }}#smp" class="mt-2 text-[10px] font-bold text-pink-600 hover:underline">Selengkapnya →</a>
            </div>

            <div class="p-3.5 bg-white border border-slate-200 rounded-lg shadow-sm border-t-2 border-t-sky-600 flex flex-col justify-between">
                <div>
                    <span class="text-[10px] font-bold text-sky-700 uppercase">AET (音響工学科)</span>
                    <h3 class="text-xs font-bold text-slate-900 mt-0.5">Audio Engineering</h3>
                    <p class="text-[11px] text-slate-600 mt-1 leading-relaxed">Sound reinforcement, live console mixing, dan DAW studio.</p>
                </div>
                <a href="{{ route('public.jurusan') }}#aet" class="mt-2 text-[10px] font-bold text-sky-700 hover:underline">Selengkapnya →</a>
            </div>

            <div class="p-3.5 bg-white border border-slate-200 rounded-lg shadow-sm border-t-2 border-t-amber-500 flex flex-col justify-between">
                <div>
                    <span class="text-[10px] font-bold text-amber-700 uppercase">DKV (デザイン科)</span>
                    <h3 class="text-xs font-bold text-slate-900 mt-0.5">Desain Visual</h3>
                    <p class="text-[11px] text-slate-600 mt-1 leading-relaxed">Merchandise band, cover album vinyl, dan fotografi panggung.</p>
                </div>
                <a href="{{ route('public.jurusan') }}#dkv" class="mt-2 text-[10px] font-bold text-amber-700 hover:underline">Selengkapnya →</a>
            </div>

            <div class="p-3.5 bg-white border border-slate-200 rounded-lg shadow-sm border-t-2 border-t-indigo-600 flex flex-col justify-between">
                <div>
                    <span class="text-[10px] font-bold text-indigo-700 uppercase">RPL (情報処理科)</span>
                    <h3 class="text-xs font-bold text-slate-900 mt-0.5">Rekayasa Software</h3>
                    <p class="text-[11px] text-slate-600 mt-1 leading-relaxed">Web portal SIA, basis data multimedia, dan audio synthesizer.</p>
                </div>
                <a href="{{ route('public.jurusan') }}#rpl" class="mt-2 text-[10px] font-bold text-indigo-700 hover:underline">Selengkapnya →</a>
            </div>

            <div class="p-3.5 bg-white border border-slate-200 rounded-lg shadow-sm border-t-2 border-t-emerald-600 flex flex-col justify-between">
                <div>
                    <span class="text-[10px] font-bold text-emerald-700 uppercase">MBE (ビジネス科)</span>
                    <h3 class="text-xs font-bold text-slate-900 mt-0.5">Bisnis Event</h3>
                    <p class="text-[11px] text-slate-600 mt-1 leading-relaxed">Manajemen konser musik, promosi livehouse, dan hospitality cafe.</p>
                </div>
                <a href="{{ route('public.jurusan') }}#mbe" class="mt-2 text-[10px] font-bold text-emerald-700 hover:underline">Selengkapnya →</a>
            </div>
        </div>
    </section>

    <!-- 4. BERITA & AGENDA SEKOLAH (お知らせ・年間行事) -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Kolom Kiri: Papan Pengumuman (お知らせ) -->
            <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-2.5 border-b border-slate-200">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-pink-500 rounded-full"></span>
                        <h3 class="text-sm font-bold text-slate-900">Pengumuman Resmi Sekolah (お知らせ)</h3>
                    </div>
                    <a href="{{ route('public.agenda') }}" class="text-[11px] font-semibold text-pink-600 hover:underline">Semua Pengumuman →</a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse ($pengumumans as $p)
                        <div class="py-2.5 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[10px] px-1.5 py-0.2 font-bold rounded uppercase {{ $p->tipe === 'mendesak' ? 'bg-rose-50 text-rose-700 border border-rose-200' : ($p->tipe === 'penting' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-sky-50 text-sky-700 border border-sky-200') }}">
                                    {{ $p->tipe }}
                                </span>
                                <span class="text-[10px] text-slate-400 font-mono">{{ $p->created_at->format('Y.m.d') }}</span>
                            </div>
                            <h4 class="text-xs font-bold text-slate-900 leading-snug">{{ $p->judul }}</h4>
                            <p class="text-[11px] text-slate-600 line-clamp-2 mt-0.5">{{ $p->isi }}</p>
                        </div>
                    @empty
                        <div class="py-4 text-center text-xs text-slate-400">Belum ada pengumuman baru.</div>
                    @endforelse
                </div>
            </div>

            <!-- Kolom Kanan: Kalender Agenda Kegiatan (行事予定) -->
            <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-2.5 border-b border-slate-200">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-sky-600 rounded-full"></span>
                        <h3 class="text-sm font-bold text-slate-900">Agenda Kegiatan Terdekat (行事予定)</h3>
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

    <!-- 5. KILAS TENAGA PENDIDIK & KLUB EKSTRAKURIKULER (教職員・部活動) -->
    <section class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Tenaga Pendidik -->
            <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Tenaga Pendidik (教職員)</h3>
                    <a href="{{ route('public.guru') }}" class="text-[11px] font-semibold text-pink-600 hover:underline">Daftar 45 Guru →</a>
                </div>

                <div class="grid grid-cols-2 gap-2.5">
                    @foreach ($gurus->take(4) as $guru)
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded flex items-center gap-2">
                            <div class="w-7 h-7 rounded bg-slate-200 text-slate-700 flex items-center justify-center font-bold text-[10px] shrink-0">
                                {{ strtoupper(substr($guru->nama, 0, 2)) }}
                            </div>
                            <div class="min-w-0">
                                <span class="font-bold text-slate-900 block truncate text-[11px]">{{ $guru->nama }}</span>
                                <span class="text-[10px] text-slate-500 truncate block">{{ $guru->mata_pelajaran }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Ekstrakurikuler -->
            <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-slate-200">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Klub Ekstrakurikuler (部活動)</h3>
                    <a href="{{ route('public.ekskul') }}" class="text-[11px] font-semibold text-pink-600 hover:underline">Lihat 12 Klub →</a>
                </div>

                <div class="grid grid-cols-2 gap-2.5">
                    @foreach ($ekskuls as $ek)
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded">
                            <span class="font-bold text-slate-900 block truncate text-[11px]">{{ $ek['nama'] }}</span>
                            <span class="text-[10px] text-pink-600 font-medium">{{ $ek['jadwal'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

</div>
@endsection
