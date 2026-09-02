@extends('layouts.admin')

@section('title', 'Detail Data Murid — Shuka Highschool')
@section('heading', 'Detail Data Murid')
@section('subheading', $siswa->nama)

@section('content')
<div class="space-y-6">
    <!-- Header Card -->
    <div class="rounded-2xl border border-pink-100 bg-white p-6 shadow-sm max-w-4xl space-y-4">
        <div class="flex items-center gap-4 pb-4 border-b border-slate-100">
            <x-avatar :user="$siswa->user" :name="$siswa->nama" size="md" class="shrink-0" />
            <div>
                <h3 class="font-extrabold text-slate-800 text-lg">{{ $siswa->nama }}</h3>
                <p class="text-xs text-pink-600 font-semibold">Kelas {{ $siswa->kelas }}</p>
            </div>
        </div>

        <div class="space-y-3 text-sm">
            <div class="flex justify-between border-b border-slate-100 pb-2">
                <span class="text-slate-500">NIS</span>
                <span class="font-semibold text-slate-800">{{ $siswa->nis }}</span>
            </div>
            <div class="flex justify-between border-b border-slate-100 pb-2">
                <span class="text-slate-500">Jenis Kelamin</span>
                <span class="font-semibold text-slate-800">{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
            </div>
            <div class="flex justify-between border-b border-slate-100 pb-2">
                <span class="text-slate-500">Tanggal Lahir</span>
                <span class="font-semibold text-slate-800">{{ $siswa->tanggal_lahir?->format('d F Y') ?? '—' }}</span>
            </div>
            <div class="border-b border-slate-100 pb-2">
                <span class="text-slate-500 block mb-1">Alamat Tempat Tinggal</span>
                <p class="text-slate-700 font-medium bg-slate-50 p-2.5 rounded-lg border border-slate-100">{{ $siswa->alamat }}</p>
            </div>
            <div class="flex justify-between border-b border-slate-100 pb-2">
                <span class="text-slate-500">Status Akun Login</span>
                @if($siswa->user)
                    <span class="font-semibold text-emerald-600">Aktif ({{ $siswa->user->email }})</span>
                @else
                    <span class="font-semibold text-slate-400">Belum Tertaut Akun</span>
                @endif
            </div>
        </div>

        <div class="flex flex-wrap gap-2 pt-3">
            @if(Auth::user()->isAdministratorLevel())
            <x-button class="bg-pink-500 hover:bg-pink-600 text-white font-semibold" href="{{ route('admin.siswa.edit', $siswa) }}">Edit Data Murid</x-button>
            @endif
            <x-button variant="secondary" href="{{ route('admin.siswa.index') }}">Kembali</x-button>
        </div>
    </div>

    <!-- Quick Action Shortcuts -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Nilai Shortcut -->
        @if(Auth::user()->isAdministratorLevel())
        <a href="{{ route('admin.nilai.create') }}?siswa_id={{ $siswa->id }}" class="group bg-white border border-slate-200 rounded-xl p-5 shadow-sm hover:border-pink-300 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-pink-100 text-pink-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-slate-900 text-sm truncate">Kelola Nilai</h4>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $siswa->nilais->count() }} record nilai</p>
                </div>
            </div>
        </a>
        @endif

        <!-- Ekskul Shortcut -->
        <a href="{{ route('admin.ekskul.index') }}" class="group bg-white border border-slate-200 rounded-xl p-5 shadow-sm hover:border-sky-300 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-sky-100 text-sky-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-slate-900 text-sm truncate">Keanggotaan Ekskul</h4>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $siswa->ekskuls->count() }} klub aktif</p>
                </div>
            </div>
        </a>

        <!-- Pelanggaran Shortcut -->
        <a href="{{ route('admin.pelanggaran.index', ['siswa_id' => $siswa->id]) }}" class="group bg-white border border-slate-200 rounded-xl p-5 shadow-sm hover:border-rose-300 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-slate-900 text-sm truncate">Catatan Pelanggaran</h4>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $siswa->pelanggarans->count() }} catatan ({{ $siswa->totalPoinPelanggaran() }} poin)</p>
                </div>
            </div>
        </a>

        <!-- Jadwal Shortcut -->
        <a href="{{ route('admin.jadwal.index') }}" class="group bg-white border border-slate-200 rounded-xl p-5 shadow-sm hover:border-emerald-300 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-slate-900 text-sm truncate">Jadwal Pelajaran</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Lihat jadwal kelas {{ $siswa->kelas }}</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Ekskul Detail Section -->
    @if($siswa->ekskuls->count() > 0)
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h4 class="font-bold text-slate-900 text-sm">Keanggotaan Ekskul ({{ $siswa->ekskuls->count() }})</h4>
            <a href="{{ route('admin.ekskul.index') }}" class="text-xs font-semibold text-pink-600 hover:underline">Kelola Semua →</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($siswa->ekskuls as $ekskul)
                <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg hover:border-pink-300 transition-colors">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider shrink-0">{{ $ekskul->kategori }}</span>
                        <h5 class="text-xs font-bold text-slate-900 truncate">{{ $ekskul->nama }}</h5>
                    </div>
                    <div class="flex items-center justify-between text-[11px] text-slate-600">
                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ $ekskul->pivot->posisi === 'Ketua' ? 'bg-pink-50 text-pink-700 border border-pink-200' : ($ekskul->pivot->posisi === 'Wakil Ketua' ? 'bg-sky-50 text-sky-700 border border-sky-200' : 'bg-slate-50 text-slate-700 border border-slate-200') }}">
                            {{ $ekskul->pivot->posisi ?? 'Anggota' }}
                        </span>
                        <span class="text-slate-400">{{ $ekskul->pivot->tahun_bergabung ?? '—' }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Nilai Summary -->
    @if($siswa->nilais->count() > 0)
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h4 class="font-bold text-slate-900 text-sm">Ringkasan Nilai ({{ $siswa->nilais->count() }} record)</h4>
            <a href="{{ route('admin.nilai.index') }}?siswa={{ $siswa->id }}" class="text-xs font-semibold text-pink-600 hover:underline">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-500 uppercase tracking-wider">
                        <th class="py-2 px-3">Mata Pelajaran</th>
                        <th class="py-2 px-3 text-center">Jenis</th>
                        <th class="py-2 px-3 text-right">Nilai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($siswa->nilais->take(10) as $nilai)
                    <tr class="hover:bg-slate-50">
                        <td class="py-2 px-3 font-medium text-slate-900 truncate max-w-[200px]">{{ $nilai->mapel->nama ?? '—' }}</td>
                        <td class="py-2 px-3 text-center">
                            <span class="inline-block px-2 py-0.5 text-[10px] font-semibold rounded bg-slate-100 text-slate-700 border border-slate-200">{{ $nilai->jenis_nilai }}</span>
                        </td>
                        <td class="py-2 px-3 text-right font-bold text-pink-600">{{ $nilai->nilai }}</td>
                    </tr>
                    @endforeach
                    @if($siswa->nilais->count() > 10)
                    <tr>
                        <td colspan="3" class="py-2 px-3 text-center text-slate-400 text-xs">... dan {{ $siswa->nilais->count() - 10 }} nilai lainnya</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Pelanggaran Summary -->
    @if($siswa->pelanggarans->count() > 0)
    <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h4 class="font-bold text-slate-900 text-sm">Riwayat Pelanggaran ({{ $siswa->pelanggarans->count() }} catatan - {{ $siswa->totalPoinPelanggaran() }} poin)</h4>
            <a href="{{ route('admin.pelanggaran.index') }}?siswa={{ $siswa->id }}" class="text-xs font-semibold text-pink-600 hover:underline">Lihat Semua →</a>
        </div>
        <div class="divide-y divide-slate-100">
            @foreach($siswa->pelanggarans->take(5) as $pel)
            <div class="py-3">
                <div class="flex items-start justify-between gap-2">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded {{ $pel->kategori === 'Ringan' ? 'bg-green-50 text-green-700 border border-green-200' : ($pel->kategori === 'Sedang' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-rose-50 text-rose-700 border border-rose-200') }}">
                                {{ $pel->kategori }} ({{ $pel->poin }} poin)
                            </span>
                            <span class="text-[10px] text-slate-400 font-mono">{{ $pel->tanggal }}</span>
                        </div>
                        <p class="text-xs font-medium text-slate-900 truncate">{{ $pel->jenis_pelanggaran }}</p>
                        <p class="text-[10px] text-slate-500 mt-0.5">{{ $pel->sanksi }}</p>
                    </div>
                    <span class="inline-block px-2 py-0.5 text-[10px] font-semibold rounded {{ $pel->status === 'Selesai' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }} shrink-0">
                        {{ $pel->status }}
                    </span>
                </div>
            </div>
            @endforeach
            @if($siswa->pelanggarans->count() > 5)
            <div class="py-2 text-center text-xs text-slate-400">... dan {{ $siswa->pelanggarans->count() - 5 }} catatan lainnya</div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
