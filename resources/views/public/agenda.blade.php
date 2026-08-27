@extends('layouts.public')

@section('title', 'Agenda & Pengumuman — SMK Shuka')
@section('page_header', true)
@section('page_heading', 'Agenda & Pengumuman Sekolah')
@section('page_subheading', '秀華高等専門学校 • Kalender Kegiatan & Pengumuman Resmi')
@section('page_description', 'Kalender kegiatan festival Shuka-sai, jadwal latihan rutin panggung konser, workshop industri, dan pengumuman resmi.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 space-y-10">

    <!-- 1. PAPAN PENGUMUMAN RESMI SEKOLAH -->
    <section class="bg-white border border-slate-200 rounded-lg p-6 shadow-sm space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-6 bg-pink-500 rounded-sm"></span>
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-slate-900">Pengumuman & Notifikasi Resmi</h2>
                    <p class="text-xs text-slate-500">Pemberitahuan akademik, kesiswaan, dan persiapan konser.</p>
                </div>
            </div>
            <span class="text-xs text-slate-400">T.A. 2026/2027</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse ($pengumumans as $p)
                <div class="p-4 bg-slate-50 border border-slate-200 rounded-lg hover:border-pink-300 transition-colors flex flex-col justify-between space-y-2">
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-[10px]">
                            <span class="px-2 py-0.5 font-bold rounded uppercase {{ $p->tipe === 'mendesak' ? 'bg-rose-100 text-rose-800' : ($p->tipe === 'penting' ? 'bg-amber-100 text-amber-800' : 'bg-sky-100 text-sky-800') }}">
                                {{ $p->tipe }}
                            </span>
                            <span class="text-slate-400 font-mono">{{ $p->created_at->format('Y.m.d') }}</span>
                        </div>
                        <h3 class="text-xs sm:text-sm font-bold text-slate-900 leading-snug">{{ $p->judul }}</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">{{ $p->isi }}</p>
                    </div>
                    <div class="pt-2 border-t border-slate-200 text-[10px] text-slate-500">
                        Penulis: <strong class="text-slate-800">{{ $p->penulis ?? 'Tim Kesiswaan SMK Shuka' }}</strong>
                    </div>
                </div>
            @empty
                <div class="col-span-2 p-6 text-center text-xs text-slate-400">Belum ada pengumuman resmi.</div>
            @endforelse
        </div>
    </section>

    <!-- 2. KALENDER AGENDA KEGIATAN TAHUNAN -->
    <section class="bg-white border border-slate-200 rounded-lg p-6 shadow-sm space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-3 border-b border-slate-200">
            <div>
                <h2 class="text-base sm:text-lg font-bold text-slate-900">Jadwal Kalender Kegiatan</h2>
                <p class="text-xs text-slate-500">Rangkaian agenda panggung, workshop kejuruan, dan evaluasi akademik.</p>
            </div>

            <!-- Filter Kategori Agenda -->
            <form method="GET" action="{{ route('public.agenda') }}" class="flex items-center gap-2">
                <select name="kategori" class="text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-1.5 px-2.5">
                    <option value="all">Semua Kategori</option>
                    <option value="Latihan Band" {{ request('kategori') === 'Latihan Band' ? 'selected' : '' }}>Latihan Band</option>
                    <option value="Festival Sekolah" {{ request('kategori') === 'Festival Sekolah' ? 'selected' : '' }}>Festival Budaya</option>
                    <option value="Workshop" {{ request('kategori') === 'Workshop' ? 'selected' : '' }}>Workshop</option>
                    <option value="Uji Kompetensi Kejuruan (UKK)" {{ request('kategori') === 'Uji Kompetensi Kejuruan (UKK)' ? 'selected' : '' }}>UKK Kejuruan</option>
                    <option value="Konseling" {{ request('kategori') === 'Konseling' ? 'selected' : '' }}>Konseling</option>
                </select>
                <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-white bg-slate-800 hover:bg-slate-900 rounded">
                    Filter
                </button>
            </form>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse ($agendas as $a)
                <div class="py-4 hover:bg-slate-50 transition-colors">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 mb-1.5">
                        <div class="space-y-1">
                            <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded bg-slate-100 text-slate-700 border border-slate-200">
                                {{ $a->kategori }}
                            </span>
                            <h3 class="text-sm font-bold text-slate-900">{{ $a->judul }}</h3>
                        </div>
                        <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded {{ $a->status === 'Aktif' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-pink-50 text-pink-700 border border-pink-200' }} self-start">
                            {{ $a->status }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-xs text-slate-600 mb-2">
                        <div><strong class="text-slate-700">Waktu:</strong> {{ $a->tanggal }} @if($a->jam) ({{ $a->jam }}) @endif</div>
                        <div><strong class="text-slate-700">Lokasi:</strong> {{ $a->lokasi ?? 'SMK Shuka' }}</div>
                        <div><strong class="text-slate-700">Penanggung Jawab:</strong> {{ $a->penanggung_jawab ?? 'Sekolah' }}</div>
                    </div>

                    @if($a->catatan)
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded text-xs text-slate-600">
                            {{ $a->catatan }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="py-8 text-center text-xs text-slate-400">Belum ada agenda yang cocok dengan filter yang dipilih.</div>
            @endforelse
        </div>

        @if($agendas->hasPages())
            <div class="pt-4 border-t border-slate-100">
                {{ $agendas->links() }}
            </div>
        @endif
    </section>

</div>
@endsection