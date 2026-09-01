<?php
@extends('layouts.admin')

@section('title', 'Manajemen Kelas Binaan Wali Kelas — SMK Shuka')
@section('heading', 'Kelas Binaan & Rapor Wali Kelas')

@section('content')
<div class="space-y-6">

    <!-- header & pemilih rombel kelas -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">
                Kelas Binaan {{ $selectedKelas }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                Pengelolaan rapor, pemantauan prestasi akademik, dan pembinaan peserta didik rombel.
            </p>
        </div>

        <!-- pemilih kelas dropdown untuk admin dan tata usaha -->
        <div class="flex items-center gap-2">
            @if($canSelectKelas)
                <div class="flex items-center gap-2 bg-white px-3 py-1.5 border border-slate-300 rounded shadow-2xs">
                    <label for="pilih-kelas" class="text-xs font-semibold text-slate-600 whitespace-nowrap">Pilih Rombel:</label>
                    <select
                        id="pilih-kelas"
                        onchange="window.location.href='{{ route('admin.walikelas.index') }}?kelas=' + this.value"
                        class="text-xs font-bold text-slate-800 bg-transparent border-0 focus:ring-0 py-0 pl-1 pr-6 cursor-pointer"
                    >
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas }}" {{ $selectedKelas === $kelas ? 'selected' : '' }}>
                                {{ $kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @else
                <span class="inline-flex items-center px-3 py-1.5 rounded bg-pink-50 text-pink-700 border border-pink-200 text-xs font-bold">
                    Rombel Binaan: {{ $selectedKelas }}
                </span>
            @endif
        </div>
    </div>

    <!-- kartu metrik statistik kelas binaan -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <!-- wali kelas -->
        <div class="bg-white p-4 border border-slate-200 rounded-lg shadow-2xs">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Wali Kelas</span>
            <p class="text-base font-bold text-slate-900 mt-1 truncate">{{ $waliGuru?->nama ?? 'Belum Ditugaskan' }}</p>
            <span class="text-[11px] text-pink-600 font-mono mt-0.5 block">NIP: {{ $waliGuru?->nip ?? '—' }}</span>
        </div>

        <!-- total siswa -->
        <div class="bg-white p-4 border border-slate-200 rounded-lg shadow-2xs">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Jumlah Peserta Didik</span>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $siswas->count() }}</p>
            <span class="text-[11px] text-slate-500 font-medium mt-0.5 block">Terdaftar Aktif</span>
        </div>

        <!-- rata-rata nilai kelas -->
        <div class="bg-white p-4 border border-slate-200 rounded-lg shadow-2xs">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Rata-rata Kelas</span>
            <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $rataRataKelas }}</p>
            <span class="text-[11px] text-slate-500 font-medium mt-0.5 block">Skala Penilaian 100</span>
        </div>

        <!-- kedisiplinan & catatan bk -->
        <div class="bg-white p-4 border border-slate-200 rounded-lg shadow-2xs">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Catatan Kedisiplinan</span>
            <p class="text-2xl font-bold {{ $totalPelanggaran > 0 ? 'text-amber-600' : 'text-slate-900' }} mt-1">{{ $totalPelanggaran }}</p>
            <span class="text-[11px] text-slate-500 font-medium mt-0.5 block">Kasus Pelanggaran</span>
        </div>
    </div>

    <!-- tabel daftar peserta didik kelas binaan -->
    <div class="bg-white border border-slate-200 rounded-lg shadow-2xs overflow-hidden">
        <div class="p-3.5 bg-slate-50/70 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">
                Daftar Peserta Didik Rombel {{ $selectedKelas }} ({{ $siswas->count() }} Siswa)
            </h3>
            <span class="text-[11px] text-slate-500">Tahun Ajaran 2026/2027 Ganjil</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase tracking-wider">
                        <th class="py-2.5 px-4 border-r border-slate-200">NIS</th>
                        <th class="py-2.5 px-4 border-r border-slate-200">Nama Peserta Didik</th>
                        <th class="py-2.5 px-4 border-r border-slate-200 text-center">L/P</th>
                        <th class="py-2.5 px-4 border-r border-slate-200">Rata-rata Nilai</th>
                        <th class="py-2.5 px-4 border-r border-slate-200">Catatan BK</th>
                        <th class="py-2.5 px-4 border-r border-slate-200">Alamat</th>
                        <th class="py-2.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($siswas as $siswa)
                        @php
                            $avg = $siswa->nilais->avg('nilai');
                            $avgFormatted = $avg ? number_format($avg, 1) : '—';
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-2.5 px-4 font-mono font-semibold text-slate-600 border-r border-slate-100">{{ $siswa->nis }}</td>
                            <td class="py-2.5 px-4 font-bold text-slate-900 border-r border-slate-100">{{ $siswa->nama }}</td>
                            <td class="py-2.5 px-4 text-center border-r border-slate-100">
                                <span class="px-1.5 py-0.5 text-[10px] font-bold rounded {{ $siswa->jenis_kelamin === 'P' ? 'bg-pink-50 text-pink-700 border border-pink-200' : 'bg-sky-50 text-sky-700 border border-sky-200' }}">
                                    {{ $siswa->jenis_kelamin }}
                                </span>
                            </td>
                            <td class="py-2.5 px-4 font-mono font-bold border-r border-slate-100 {{ $avg >= 75 ? 'text-emerald-700' : 'text-amber-700' }}">
                                {{ $avgFormatted }}
                            </td>
                            <td class="py-2.5 px-4 border-r border-slate-100">
                                @if($siswa->pelanggarans->count() > 0)
                                    <span class="px-1.5 py-0.5 rounded bg-rose-50 text-rose-700 text-[10px] font-semibold">
                                        {{ $siswa->pelanggarans->count() }} Peringatan
                                    </span>
                                @else
                                    <span class="text-slate-400 text-[11px]">Bersih</span>
                                @endif
                            </td>
                            <td class="py-2.5 px-4 text-slate-600 border-r border-slate-100 truncate max-w-xs">{{ $siswa->alamat }}</td>
                            <td class="py-2.5 px-4 text-center">
                                <a href="{{ route('admin.siswa.show', $siswa->id) }}" class="px-2.5 py-1 text-[11px] font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded transition-colors">
                                    Profil
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">Belum ada data peserta didik di kelas ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
