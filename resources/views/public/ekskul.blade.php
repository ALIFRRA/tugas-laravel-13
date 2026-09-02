@extends('layouts.public')

@section('title', 'Ekstrakurikuler & Klub — SMK Shuka')
@section('page_header', true)
@section('page_heading', 'Ekstrakurikuler & Klub Siswa')
@section('page_subheading', '秀華高等専門学校 • 12 Klub Seni, Media, Desain, Teknologi & Olahraga')
@section('page_description', 'Direktori 12 klub peminatan kejuruan seni musik pertunjukan, tata suara, desain merchandise, teknologi multimedia, dan kebugaran.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 space-y-8">

    <!-- Ringkasan Statistik Ekskul -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="p-4 bg-white border border-slate-200 rounded-lg shadow-sm border-l-4 border-l-pink-500">
            <span class="text-xs font-semibold text-slate-500 block">Total Klub Terdaftar</span>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $ekskuls->count() }} Klub Aktif</p>
            <div class="text-[11px] text-pink-700 font-semibold mt-1">Seni Musik, Media, Desain & Olahraga</div>
        </div>

        <div class="p-4 bg-white border border-slate-200 rounded-lg shadow-sm border-l-4 border-l-sky-600">
            <span class="text-xs font-semibold text-slate-500 block">Peserta Didik Terlibat</span>
            <p class="text-2xl font-bold text-sky-700 mt-1">{{ number_format($ekskuls->sum('siswas_count')) }} Siswa</p>
            <div class="text-[11px] text-slate-500 mt-1">Partisipasi Aktif 5 Rombel Kejuruan</div>
        </div>

        <div class="p-4 bg-white border border-slate-200 rounded-lg shadow-sm border-l-4 border-l-emerald-600">
            <span class="text-xs font-semibold text-slate-500 block">Studio Mitra Praktik</span>
            <p class="text-2xl font-bold text-emerald-700 mt-1">STARRY Basement</p>
            <div class="text-[11px] text-slate-500 mt-1">Shimokitazawa Live Stage</div>
        </div>
    </div>

    <!-- Grid 12 Klub Ekstrakurikuler -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($ekskuls as $ek)
            <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm hover:border-pink-300 transition-colors flex flex-col justify-between space-y-4">
                <div class="space-y-2">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">{{ $ek->kategori }}</span>
                            <h3 class="text-sm font-bold text-slate-900 leading-snug mt-0.5">{{ $ek->nama }}</h3>
                        </div>
                        <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded bg-pink-50 text-pink-700 border border-pink-200 shrink-0">
                            {{ $ek->siswas_count }} Siswa
                        </span>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed">{{ $ek->deskripsi ?: 'Deskripsi klub belum tersedia.' }}</p>
                </div>

                <div class="pt-3 border-t border-slate-100 space-y-1.5 text-xs text-slate-600">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Pembina:</span>
                        <strong class="text-slate-800 text-right text-[11px]">{{ $ek->pembina }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Ketua:</span>
                        <span class="font-semibold text-slate-800 text-[11px]">{{ $ek->ketua ?: 'Belum ditetapkan' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Lokasi:</span>
                        <span class="text-slate-700 text-[11px]">{{ $ek->lokasi ?: 'Menyusul' }}</span>
                    </div>
                    <div class="flex items-center justify-between pt-1 border-t border-slate-50 text-[11px]">
                        <span class="text-slate-500">Jadwal: <strong class="text-slate-700">{{ $ek->jadwal ?: 'Menyusul' }}</strong></span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
