@extends('layouts.murid')

@section('title', 'Dashboard Siswa — SMK Shuka (秀華高等専門学校)')
@section('heading', 'Halo, ' . $user->name)
@section('subheading', 'Ringkasan biodata akademik dan hasil evaluasi belajar siswa.')

@section('content')
<div class="space-y-6">

    @unless ($siswa)
        <div class="bg-white border border-amber-200 rounded-lg p-6 shadow-sm space-y-3 border-l-4 border-l-amber-500">
            <h2 class="text-sm font-bold text-amber-900">Profil Akademik Belum Ditautkan</h2>
            <p class="text-xs text-slate-600 leading-relaxed">
                Akunmu sudah aktif, namun data siswa (NIS & Kelas Rombel) belum ditautkan oleh Administrator. Kamu tetap dapat menyunting profil dan foto akunmu.
            </p>
            <div class="pt-2">
                <a href="{{ route('profile.show', $user->id) }}" class="px-3.5 py-1.5 bg-pink-500 hover:bg-pink-600 text-white font-semibold text-xs rounded transition-colors shadow-sm inline-block">
                    Sunting Profil & Foto Siswa →
                </a>
            </div>
        </div>
    @else
        <!-- 1. KARTU PROFIL BIODATA SISWA -->
        <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <x-avatar :user="$user" size="lg" />
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-base font-bold text-slate-900">{{ $siswa->nama }}</h2>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-pink-50 text-pink-700 border border-pink-200">
                            Siswa Reguler
                        </span>
                    </div>
                    <p class="text-xs text-slate-600 mt-0.5">
                        NIS: <span class="font-mono font-bold text-slate-800">{{ $siswa->nis }}</span> • Kelas Rombel: <span class="font-bold text-pink-600 font-mono">{{ $siswa->kelas }}</span>
                    </p>
                    <p class="text-[11px] text-slate-500 mt-0.5">
                        Jurusan: <strong>{{ Str::after($siswa->kelas, '-') ? Str::before(Str::after($siswa->kelas, '-'), '-') : 'Seni Musik Kejuruan' }}</strong> • Kelamin: {{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2 self-start sm:self-auto">
                <a href="{{ route('profile.show', $user->id) }}" class="px-3.5 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold text-xs rounded transition-colors shadow-sm inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    <span>Ganti Foto & Edit Profil</span>
                </a>
            </div>
        </div>

        <!-- 2. METRIC REKAP NILAI AKADEMIK -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm border-l-4 border-l-pink-500 flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 block">Rata-rata Rapor</span>
                    <span class="text-2xl font-extrabold text-slate-900 mt-1 block">
                        {{ $rataRata !== null ? number_format($rataRata, 1) : '—' }}
                    </span>
                    <span class="text-[11px] text-pink-600 font-semibold mt-0.5 block">Indeks Prestasi</span>
                </div>
                <div class="w-10 h-10 rounded bg-pink-50 text-pink-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm border-l-4 border-l-emerald-600 flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 block">Nilai Tertinggi</span>
                    <span class="text-2xl font-extrabold text-slate-900 mt-1 block">
                        {{ $tertinggi ?? '—' }}
                    </span>
                    <span class="text-[11px] text-emerald-600 font-semibold mt-0.5 block">Pencapaian Terbaik</span>
                </div>
                <div class="w-10 h-10 rounded bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm border-l-4 border-l-amber-500 flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 block">Nilai Terendah</span>
                    <span class="text-2xl font-extrabold text-slate-900 mt-1 block">
                        {{ $terendah ?? '—' }}
                    </span>
                    <span class="text-[11px] text-amber-600 font-semibold mt-0.5 block">Evaluasi Perbaikan</span>
                </div>
                <div class="w-10 h-10 rounded bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm border-l-4 border-l-sky-600 flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 block">Mapel Dinilai</span>
                    <span class="text-2xl font-extrabold text-slate-900 mt-1 block">{{ $mapelCount }}</span>
                    <span class="text-[11px] text-sky-600 font-semibold mt-0.5 block">Mata Pelajaran Tuntas</span>
                </div>
                <div class="w-10 h-10 rounded bg-sky-50 text-sky-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>

        </div>

        <!-- 3. TABEL REKAP NILAI RAPOR SISWA -->
        <div class="bg-white border border-slate-200 rounded-lg shadow-sm space-y-4 p-5">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-pink-500 rounded-full"></span>
                    <h3 class="text-sm font-bold text-slate-900">Transkrip Nilai Akademik Siswa</h3>
                </div>
                <span class="text-xs text-slate-500">T.A. 2026/2027 Semester Ganjil</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="bg-slate-50 text-slate-700 uppercase font-bold text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4">Mata Pelajaran Kejuruan</th>
                            <th class="py-3 px-4">Jenis Penilaian</th>
                            <th class="py-3 px-4 text-center">Skor Angka</th>
                            <th class="py-3 px-4 text-center">Predikat</th>
                            <th class="py-3 px-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-800">
                        @forelse ($nilais as $nilai)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 font-bold text-slate-900">
                                    {{ $nilai->mapel?->nama ?? '—' }}
                                    <span class="block text-[10px] font-normal text-slate-500">{{ $nilai->mapel?->kode }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $nilai->jenis_nilai }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center font-bold font-mono text-sm text-pink-600">
                                    {{ $nilai->nilai }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @php
                                        $predikat = $nilai->nilai >= 85 ? 'A (Sangat Baik)' : ($nilai->nilai >= 75 ? 'B (Baik)' : ($nilai->nilai >= 65 ? 'C (Cukup)' : 'D (Kurang)'));
                                    @endphp
                                    <span class="font-bold text-xs text-slate-700">{{ $predikat }}</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $nilai->nilai >= 70 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                        {{ $nilai->nilai >= 70 ? 'Tuntas' : 'Remedial' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-xs text-slate-400">
                                    Belum ada nilai yang diinput oleh bapak/ibu guru pengampu.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    @endunless

</div>
@endsection
