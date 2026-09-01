<?php
@extends('layouts.admin')

@section('title', 'Rekap Nilai — Shuka Highschool')
@section('heading', 'Rekap Nilai Siswa')

@section('content')
<div class="space-y-5">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-3 border-b border-slate-200">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">Rekapitulasi & Input Nilai</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Daftar entri penilaian harian, tugas, UTS, dan UAS siswa.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.nilai.analisis') }}" class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded hover:bg-slate-50 flex items-center gap-1.5 transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span>Analisis & Ranking</span>
            </a>
            <a href="{{ route('admin.nilai.export') }}" class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded hover:bg-slate-50 flex items-center gap-1.5 transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Ekspor CSV</span>
            </a>
            <a href="{{ route('admin.nilai.create') }}" class="px-3.5 py-1.5 text-xs font-semibold text-white bg-pink-500 hover:bg-pink-600 rounded flex items-center gap-1.5 transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Input Nilai</span>
            </a>
        </div>
    </div>

    <!-- Filter & Sort Bar -->
    <div class="bg-white p-4 border border-slate-200 rounded-lg shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <span class="text-xs text-slate-600 font-medium">Total: <strong>{{ $nilais->total() }}</strong> entri catatan nilai</span>

        <form method="GET" action="{{ route('admin.nilai.index') }}" class="flex items-center gap-2">
            <label for="sort" class="text-xs text-slate-600 font-semibold">Urutkan:</label>
            <select id="sort" name="sort" class="text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-1.5 px-3" onchange="this.form.submit()">
                <option value="">Terbaru</option>
                @foreach ($sortOptions as $value => $label)
                    <option value="{{ $value }}" @selected($sort === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase tracking-wider">
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3 px-4">Mata Pelajaran</th>
                        <th class="py-3 px-4">Jenis Evaluasi</th>
                        <th class="py-3 px-4 text-center">Nilai Angka</th>
                        <th class="py-3 px-4 text-center">Predikat</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($nilais as $nilai)
                        @php
                            $nVal = $nilai->nilai;
                            $predikat = 'D';
                            if ($nVal >= 90) $predikat = 'A';
                            elseif ($nVal >= 80) $predikat = 'B';
                            elseif ($nVal >= 70) $predikat = 'C';
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4 font-bold text-slate-900">{{ $nilai->siswa->nama ?? '—' }}</td>
                            <td class="py-3 px-4 font-medium text-slate-700">{{ $nilai->mapel->nama ?? '—' }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-block px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-semibold border border-slate-200 text-[11px]">
                                    {{ $nilai->jenis_nilai }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center font-mono font-bold {{ $nVal >= 90 ? 'text-emerald-700' : ($nVal >= 80 ? 'text-slate-900' : 'text-amber-700') }}">
                                {{ $nVal }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-block px-2 py-0.5 text-[11px] font-bold rounded {{ $predikat === 'A' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($predikat === 'B' ? 'bg-sky-50 text-sky-700 border border-sky-200' : ($predikat === 'C' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-slate-100 text-slate-600')) }}">
                                    {{ $predikat }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.nilai.edit', $nilai) }}" class="px-2 py-1 text-[11px] font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded">Edit</a>
                                    <form action="{{ route('admin.nilai.destroy', $nilai) }}" method="POST" onsubmit="return confirm('Hapus nilai ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 text-[11px] font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Belum ada catatan nilai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-200 bg-slate-50">
            {{ $nilais->links() }}
        </div>
    </div>

</div>
@endsection
