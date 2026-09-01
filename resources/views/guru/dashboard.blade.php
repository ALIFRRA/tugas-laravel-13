<?php
@extends('layouts.guru')

@section('title', 'Dashboard Guru — SMK Shuka')
@section('heading', 'Halo, ' . $guru->nama)

@section('content')
<div class="space-y-6">

    <!-- profil tenaga pendidik & status wali kelas -->
    <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-2xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <x-avatar :user="Auth::user()" size="lg" />
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-bold text-slate-900">{{ $guru->nama }}</h2>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-pink-50 text-pink-700 border border-pink-200">
                        Tenaga Pendidik
                    </span>
                    @if($guru->isWaliKelas())
                        <a href="{{ route('admin.walikelas.index') }}" class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100 transition-colors">
                            Wali Kelas {{ $guru->wali_kelas }} →
                        </a>
                    @endif
                </div>
                <p class="text-xs text-slate-600 mt-0.5">
                    NIP: <span class="font-mono font-bold text-slate-800">{{ $guru->nip }}</span> • Spesialisasi: <strong class="text-pink-600">{{ $guru->mata_pelajaran ?? 'Mata Pelajaran Kejuruan' }}</strong>
                </p>
                <p class="text-[11px] text-slate-500 mt-0.5">
                    {{ $guru->no_telepon ? 'Kontak: ' . $guru->no_telepon : 'Shimokitazawa Faculty Department' }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2 self-start sm:self-auto">
            <a href="{{ route('guru.nilai.create') }}" class="px-3.5 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold text-xs rounded transition-colors shadow-2xs inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Input Nilai Murid</span>
            </a>
            <a href="{{ route('profile.show', Auth::id()) }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded transition-colors border border-slate-200">
                Edit Profil
            </a>
        </div>
    </div>

    <!-- metrik statistik guru -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        
        <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-2xs border-l-4 border-l-pink-500 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 block">Mapel Diampu</span>
                <span class="text-2xl font-extrabold text-slate-900 mt-1 block">{{ $mapelCount }}</span>
                <span class="text-[11px] text-pink-600 font-semibold mt-0.5 block">Mata Pelajaran Aktif</span>
            </div>
            <div class="w-10 h-10 rounded bg-pink-50 text-pink-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-2xs border-l-4 border-l-sky-600 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 block">Nilai Tercatat</span>
                <span class="text-2xl font-extrabold text-slate-900 mt-1 block">{{ $nilaiCount }}</span>
                <span class="text-[11px] text-sky-600 font-semibold mt-0.5 block">Rekap Penilaian Siswa</span>
            </div>
            <div class="w-10 h-10 rounded bg-sky-50 text-sky-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-2xs border-l-4 border-l-emerald-500 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 block">Rata-rata Nilai</span>
                <span class="text-2xl font-extrabold text-slate-900 mt-1 block">{{ $rataRata ?? 0 }}</span>
                <span class="text-[11px] text-emerald-600 font-semibold mt-0.5 block">Indeks Prestasi Kelas</span>
            </div>
            <div class="w-10 h-10 rounded bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
        </div>

    </div>

    <!-- daftar mapel & ringkasan kelas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-2xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-pink-500 rounded-full"></span>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Mata Pelajaran & Kelas Ampuan</h3>
                </div>
                <a href="{{ route('guru.nilai.index') }}" class="text-xs text-pink-600 font-semibold hover:underline">
                    Kelola Semua Nilai →
                </a>
            </div>

            <div class="space-y-3">
                @forelse ($guru->mataPelajarans as $mapel)
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-900">{{ $mapel->nama }}</span>
                            <a href="{{ route('guru.nilai.create', ['mapel_id' => $mapel->id]) }}" class="px-2 py-0.5 bg-pink-50 hover:bg-pink-100 text-pink-600 border border-pink-200 text-[10px] font-bold rounded">
                                + Nilai
                            </a>
                        </div>
                        <div class="flex items-center gap-2 text-[11px] text-slate-500 font-mono">
                            <span>Kode: {{ $mapel->kode }}</span>
                            <span>•</span>
                            <span>Total Nilai: <strong class="text-slate-700">{{ $mapel->nilais_count ?? $mapel->nilais()->count() }}</strong></span>
                        </div>
                        @if($mapel->jadwals && $mapel->jadwals->count() > 0)
                            <div class="pt-1">
                                <span class="text-[10px] text-slate-400 block mb-1">Jadwal Kelas Terkait:</span>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($mapel->jadwals as $j)
                                        <span class="px-1.5 py-0.5 rounded bg-white border border-slate-200 text-slate-600 text-[10px] font-semibold">
                                            {{ $j->kelas }} ({{ $j->hari }})
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="p-4 text-center text-xs text-slate-400">Belum ada mata pelajaran yang ditugaskan.</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-2xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-sky-600 rounded-full"></span>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Ringkasan Nilai per Mata Pelajaran</h3>
                </div>
                <a href="{{ route('guru.nilai.create') }}" class="text-xs text-pink-600 font-semibold hover:underline">
                    + Input Nilai
                </a>
            </div>

            <div class="space-y-3">
                @forelse ($guru->mataPelajarans as $mapel)
                    @php
                        $avg = round($mapel->nilais()->avg('nilai') ?? 0, 2);
                        $count = $mapel->nilais()->count();
                    @endphp
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">{{ $mapel->nama }}</span>
                            <span class="text-[11px] text-slate-500">{{ $count }} catatan nilai</span>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-extrabold text-slate-900 block">{{ $avg }}</span>
                            <span class="text-[10px] font-semibold {{ $avg >= 75 ? 'text-emerald-600' : 'text-amber-600' }}">
                                {{ $avg >= 75 ? 'Tuntas' : 'Perlu Remedial' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-xs text-slate-400">Belum ada data nilai tercatat.</div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
