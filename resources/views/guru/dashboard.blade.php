@extends('layouts.guru')

@section('title', 'Dashboard Guru — SMK Shuka (秀華高等専門学校)')
@section('heading', 'Halo, ' . $guru->nama)
@section('subheading', 'Selamat datang di panel pengajar kejuruan SMK Shuka.')

@section('content')
<div class="space-y-6">

    <!-- 1. PROFILE INFO CARD GURU -->
    <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <x-avatar :user="Auth::user()" size="lg" />
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-bold text-slate-900">{{ $guru->nama }}</h2>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-pink-50 text-pink-700 border border-pink-200">
                        Tenaga Pendidik
                    </span>
                </div>
                <p class="text-xs text-slate-600 mt-0.5">
                    NIP: <span class="font-mono font-bold text-slate-800">{{ $guru->nip }}</span> • Spesialisasi: <strong class="text-pink-600">{{ $guru->mata_pelajaran }}</strong>
                </p>
                <p class="text-[11px] text-slate-500 mt-0.5">
                    {{ $guru->kontak ? 'Kontak: ' . $guru->kontak : 'Shimokitazawa Faculty Department' }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2 self-start sm:self-auto">
            <a href="{{ route('guru.nilai.create') }}" class="px-3.5 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold text-xs rounded transition-colors shadow-sm inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Input Nilai Murid</span>
            </a>
            <a href="{{ route('profile.show', Auth::id()) }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded transition-colors border border-slate-200">
                Edit Profil
            </a>
        </div>
    </div>

    <!-- 2. METRIC STATISTIK GURU -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        
        <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm border-l-4 border-l-pink-500 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 block">Mapel Diampu</span>
                <span class="text-2xl font-extrabold text-slate-900 mt-1 block">{{ $mapelCount }}</span>
                <span class="text-[11px] text-pink-600 font-semibold mt-0.5 block">Mata Pelajaran Aktif</span>
            </div>
            <div class="w-10 h-10 rounded bg-pink-50 text-pink-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm border-l-4 border-l-sky-600 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 block">Nilai Tercatat</span>
                <span class="text-2xl font-extrabold text-slate-900 mt-1 block">{{ $nilaiCount }}</span>
                <span class="text-[11px] text-sky-600 font-semibold mt-0.5 block">Rekap Penilaian Siswa</span>
            </div>
            <div class="w-10 h-10 rounded bg-sky-50 text-sky-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm border-l-4 border-l-emerald-600 flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-500 block">Rata-rata Nilai</span>
                <span class="text-2xl font-extrabold text-slate-900 mt-1 block">{{ $rataRata ?: '—' }}</span>
                <span class="text-[11px] text-emerald-600 font-semibold mt-0.5 block">Indeks Prestasi Kelas</span>
            </div>
            <div class="w-10 h-10 rounded bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
        </div>

    </div>

    <!-- 3. KONTEN DUA KOLOM: MAPEL DIKEMBANGKAN & NILAI TERBARU -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Mapel & Kelas Terkait -->
        <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-pink-500 rounded-full"></span>
                    <h3 class="text-sm font-bold text-slate-900">Mata Pelajaran & Kelas Ampuan</h3>
                </div>
                <a href="{{ route('guru.nilai.index') }}" class="text-xs font-semibold text-pink-600 hover:underline">
                    Kelola Semua Nilai →
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse ($mapels as $mapel)
                    <div class="py-3 flex items-center justify-between gap-3">
                        <div>
                            <p class="font-bold text-xs text-slate-900">{{ $mapel->nama }}</p>
                            <p class="text-[11px] text-slate-500 font-mono mt-0.5">Kode: {{ $mapel->kode }} • Total Nilai: <strong class="text-pink-600">{{ $mapel->nilais_count }}</strong></p>
                        </div>
                        <a href="{{ route('guru.nilai.create') }}?mapel_id={{ $mapel->id }}" class="px-2.5 py-1 text-[11px] font-semibold text-pink-600 bg-pink-50 hover:bg-pink-100 rounded border border-pink-200">
                            + Nilai
                        </a>
                    </div>
                @empty
                    <div class="py-6 text-center text-xs text-slate-400">Belum ada mata pelajaran yang ditautkan ke akun guru ini.</div>
                @endforelse
            </div>

            @if ($kelasList->isNotEmpty())
                <div class="pt-3 border-t border-slate-100 text-xs">
                    <span class="text-slate-500 font-medium">Jadwal Kelas Terkait:</span>
                    <div class="flex flex-wrap gap-1.5 mt-1.5">
                        @foreach ($kelasList as $kelas)
                            <span class="px-2 py-0.5 rounded text-[11px] font-mono font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                {{ $kelas }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Nilai Siswa Terbaru -->
        <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-sky-600 rounded-full"></span>
                    <h3 class="text-sm font-bold text-slate-900">Penilaian Siswa Terbaru</h3>
                </div>
                <a href="{{ route('guru.nilai.create') }}" class="text-xs font-semibold text-pink-600 hover:underline">
                    + Input Nilai
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse ($nilaiTerbaru as $nilai)
                    <div class="py-2.5 flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <p class="font-bold text-xs text-slate-900 truncate">{{ $nilai->siswa->nama }}</p>
                            <p class="text-[11px] text-slate-500 truncate">
                                {{ $nilai->mapel->nama }} • <span class="text-slate-700 font-semibold">{{ $nilai->jenis_nilai }}</span>
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm font-extrabold text-pink-600 font-mono">{{ $nilai->nilai }}</span>
                            <a href="{{ route('guru.nilai.edit', $nilai->id) }}" class="text-[11px] font-semibold text-slate-500 hover:text-slate-800 underline">
                                Edit
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-6 text-center text-xs text-slate-400">Belum ada data nilai yang diinput. Klik "Input Nilai Murid" untuk mulai memasukkan nilai.</div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
