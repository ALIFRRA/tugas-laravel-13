@extends('layouts.admin')

@section('title', 'Detail Ekstrakurikuler — SMK Shuka')
@section('heading', 'Detail Klub Ekstrakurikuler')
@section('subheading', '{{ $ekskul->nama }}')

@section('content')
<div class="max-w-4xl space-y-6">

    <!-- Header Info -->
    <div class="bg-white border border-slate-200 rounded-lg p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-16 h-16 bg-pink-100 text-pink-600 rounded-xl flex items-center justify-center font-bold text-2xl border border-pink-200 shrink-0">
                    {{ strtoupper(substr($ekskul->nama, 0, 2)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="font-extrabold text-slate-800 text-lg">{{ $ekskul->nama }}</h3>
                        @if($ekskul->nama_en)
                            <span class="text-xs text-slate-500 font-medium">({{ $ekskul->nama_en }})</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="inline-block px-2 py-0.5 rounded text-xs font-bold {{ $ekskul->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                            {{ $ekskul->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                        <span class="inline-block px-2 py-0.5 rounded text-xs font-bold bg-pink-50 text-pink-700 border border-pink-200">
                            {{ $ekskul->kategori }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">{{ $ekskul->nama_en ?? 'Tidak ada nama English' }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4 pt-4 border-t border-slate-100">
            <div>
                <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Anggota</span>
                <span class="text-2xl font-bold text-slate-900">{{ $ekskul->siswas_count ?? 0 }} Siswa</span>
            </div>
            <div>
                <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Kategori</span>
                <span class="text-sm font-bold text-pink-600">{{ $ekskul->kategori }}</span>
            </div>
            <div>
                <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Status</span>
                <span class="inline-block px-2 py-0.5 rounded text-xs font-bold {{ $ekskul->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                    {{ $ekskul->is_active ? 'Aktif' : 'Non-Aktif' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm space-y-3">
            <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider text-pink-600">Informasi Dasar</h4>
            <div class="space-y-2 text-xs text-slate-600">
                <div class="flex justify-between">
                    <span class="text-slate-400">Pembina</span>
                    <span class="font-semibold text-slate-800 text-right">{{ $ekskul->pembina }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Ketua Klub</span>
                    <span class="font-semibold text-slate-800 text-right">{{ $ekskul->ketua ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Jadwal</span>
                    <span class="font-semibold text-slate-800 text-right">{{ $ekskul->jadwal ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Lokasi</span>
                    <span class="font-semibold text-slate-800 text-right">{{ $ekskul->lokasi ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400">Total Anggota</span>
                    <span class="font-bold text-pink-600 text-right">{{ $ekskul->siswas_count ?? 0 }} Siswa</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm space-y-3">
            <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider text-sky-600">Jadwal & Lokasi</h4>
            <div class="space-y-2 text-xs text-slate-600">
                <div class="flex items-center gap-2 p-2 bg-slate-50 rounded">
                    <svg class="w-4 h-4 text-sky-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <div>
                        <span class="text-slate-400 block">Jadwal</span>
                        <span class="font-semibold text-slate-800">{{ $ekskul->jadwal ?? 'Belum diatur' }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-2 p-2 bg-slate-50 rounded">
                    <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <div>
                        <span class="text-slate-400 block">Lokasi</span>
                        <span class="font-semibold text-slate-800">{{ $ekskul->lokasi ?? 'Belum diatur' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Description & Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm space-y-3">
            <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider text-pink-600">Deskripsi Klub</h4>
            <p class="text-xs text-slate-600 leading-relaxed">{{ $ekskul->deskripsi ?? 'Belum ada deskripsi.' }}</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm space-y-3">
            <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider text-sky-600">Kegiatan Utama</h4>
            <p class="text-xs text-slate-600 leading-relaxed">{{ $ekskul->kegiatan_utama ?? 'Belum ada kegiatan utama.' }}</p>
        </div>
    </div>

    <!-- Prestasi -->
    @if($ekskul->prestasi)
    <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm">
        <h4 class="font-bold text-slate-800 text-xs uppercase tracking-wider text-amber-600 mb-3">Prestasi Klub</h4>
        <p class="text-xs text-slate-600 leading-relaxed">{{ $ekskul->prestasi }}</p>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.ekskul.members', $ekskul) }}" class="px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold text-xs rounded transition-colors shadow-sm inline-flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span>Kelola Anggota</span>
        </a>
        <a href="{{ route('admin.ekskul.edit', $ekskul) }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded transition-colors border border-slate-200">Edit Data</a>
        <a href="{{ route('admin.ekskul.index') }}" class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs rounded transition-colors border border-slate-300">Kembali</a>
    </div>

</div>
@endsection