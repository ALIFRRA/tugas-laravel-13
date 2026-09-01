<?php
@extends('layouts.admin')

@section('title', 'Daftar Ekstrakurikuler — SMK Shuka')
@section('heading', 'Manajemen Ekstrakurikuler')
@section('subheading', 'Kelola data klub ekstrakurikuler, anggauta, dan prestasi')

@section('content')
<div class="space-y-6">

    <!-- Header & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">Direktori Ekstrakurikuler</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola 12 klub ekstrakurikuler: musik, audio, desain, broadcasting, teknologi, dan kebugaran.</p>
        </div>
        @if(Auth::user()->isAdministratorLevel())
        <a href="{{ route('admin.ekskul.create') }}" class="px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold text-xs rounded transition-colors shadow-sm inline-flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Klub Baru</span>
        </a>
        @endif
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-4 border border-slate-200 rounded-lg shadow-sm">
        <form method="GET" action="{{ route('admin.ekskul.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama klub, kategori, pembina..."
                    class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 pl-9 pr-3"
                >
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <select name="kategori" class="text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3 bg-white">
                <option value="all">Semua Kategori</option>
                @foreach($kategoriList as $k)
                    <option value="{{ $k }}" {{ request('kategori') === $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>

            <select name="status" class="text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3 bg-white">
                <option value="all">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
            </select>

            <div class="flex items-center gap-2">
                <button type="submit" class="px-3 py-2 text-xs font-semibold text-white bg-slate-800 hover:bg-slate-900 rounded transition-colors">
                    Filter
                </button>

                @if(request('search') || request('kategori') !== 'all' || request('status') !== 'all')
                    <a href="{{ route('admin.ekskul.index') }}" class="px-3 py-2 text-xs font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Ekskul Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse ($ekskuls as $ekskul)
            <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm hover:border-pink-300 hover:shadow-md transition-all duration-200 flex flex-col">
                <div class="flex items-start justify-between gap-2 mb-2">
                    <div class="min-w-0">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-0.5">{{ $ekskul->kategori }}</span>
                        <h3 class="text-sm font-bold text-slate-900 leading-snug truncate">{{ $ekskul->nama }}</h3>
                        @if($ekskul->nama_en)
                            <span class="text-[10px] text-slate-500 block">{{ $ekskul->nama_en }}</span>
                        @endif
                    </div>
                    <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded {{ $ekskul->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-200' }} shrink-0">
                        {{ $ekskul->is_active ? 'Aktif' : 'Non-Aktif' }}
                    </span>
                </div>

                <p class="text-xs text-slate-600 leading-relaxed line-clamp-2 mb-3 flex-1">{{ $ekskul->deskripsi }}</p>

                <div class="pt-3 border-t border-slate-100 space-y-1.5 text-xs text-slate-600">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Pembina:</span>
                        <strong class="text-slate-800 text-right truncate block max-w-[60%]">{{ $ekskul->pembina }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Ketua:</span>
                        <span class="font-semibold text-slate-800 truncate block max-w-[60%] text-right">{{ $ekskul->ketua ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Anggota:</span>
                        <span class="font-bold text-pink-600">{{ $ekskul->siswas_count ?? 0 }} Siswa</span>
                    </div>
                    <div class="flex items-center justify-between pt-1 border-t border-slate-50">
                        <span class="text-slate-500">Jadwal: <strong class="text-slate-700">{{ $ekskul->jadwal ?? '—' }}</strong></span>
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-3 border-t border-slate-100">
                    <a href="{{ route('admin.ekskul.show', $ekskul) }}" class="flex-1 px-2 py-1.5 text-[11px] font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded text-center transition-colors">
                        Detail
                    </a>
                    @if(Auth::user()->isAdministratorLevel())
                    <a href="{{ route('admin.ekskul.edit', $ekskul) }}" class="px-2 py-1.5 text-[11px] font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded transition-colors">
                        Edit
                    </a>
                    <form action="{{ route('admin.ekskul.destroy', $ekskul) }}" method="POST" onsubmit="return confirm('Hapus klub ekstrakurikuler ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-2 py-1.5 text-[11px] font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded">Hapus</button>
                    </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full p-8 text-center text-xs text-slate-400 bg-white border border-slate-200 rounded-lg">
                Tidak ditemukan klub ekstrakurikuler.
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($ekskuls->hasPages())
        <div class="p-4 bg-white border border-slate-200 rounded-lg">
            {{ $ekskuls->links() }}
        </div>
    @endif

</div>
@endsection