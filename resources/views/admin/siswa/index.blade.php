@extends('layouts.admin')

@section('title', 'Data Siswa — SMK Shuka')
@section('heading', 'Data Peserta Didik (600 Siswa)')

@section('content')
<div class="space-y-5">

    <!-- Header Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-3 border-b border-slate-200">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">Database Siswa SMK Shuka</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola data 600 peserta didik aktif kejuruan, nomor induk siswa (NIS), rombel kelas, dan riwayat akademik.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-3 py-1.5 rounded text-xs font-semibold bg-pink-50 text-pink-700 border border-pink-200">
                Total: {{ $siswas->total() }} Siswa Ditemukan
            </span>
            @if(Auth::user()->isAdministratorLevel())
            <a href="{{ route('admin.siswa.create') }}" class="px-3.5 py-1.5 text-xs font-semibold text-white bg-pink-500 hover:bg-pink-600 rounded flex items-center gap-1.5 transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Siswa</span>
            </a>
            @endif
        </div>
    </div>

    <!-- Multi-Criteria Dropdown Filter Panel (Clean, Professional & No Tabs) -->
    <div class="bg-white p-4 border border-slate-200 rounded-lg shadow-sm">
        <form method="GET" action="{{ route('admin.siswa.index') }}" class="space-y-3">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                
                <!-- 1. Search Box -->
                <div class="lg:col-span-2 relative">
                    <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Pencarian Siswa</label>
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Cari nama siswa, NIS, alamat..." 
                            class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 pl-8 pr-3"
                        >
                        <svg class="w-4 h-4 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                <!-- 2. Dropdown Filter Jurusan -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Filter Jurusan</label>
                    <select name="jurusan" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                        <option value="all">Semua Jurusan</option>
                        <option value="SMP" {{ request('jurusan') === 'SMP' ? 'selected' : '' }}>SMP (Seni Musik Populer)</option>
                        <option value="AET" {{ request('jurusan') === 'AET' ? 'selected' : '' }}>AET (Audio Engineering)</option>
                        <option value="DKV" {{ request('jurusan') === 'DKV' ? 'selected' : '' }}>DKV (Desain Visual)</option>
                        <option value="RPL" {{ request('jurusan') === 'RPL' ? 'selected' : '' }}>RPL (Rekayasa Perangkat Lunak)</option>
                        <option value="MBE" {{ request('jurusan') === 'MBE' ? 'selected' : '' }}>MBE (Bisnis Event)</option>
                    </select>
                </div>

                <!-- 3. Dropdown Filter Tingkat Kelas -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Tingkat Kelas</label>
                    <select name="tingkat" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                        <option value="all">Semua Tingkat</option>
                        <option value="X" {{ request('tingkat') === 'X' ? 'selected' : '' }}>Tingkat X (Kelas 10)</option>
                        <option value="XI" {{ request('tingkat') === 'XI' ? 'selected' : '' }}>Tingkat XI (Kelas 11)</option>
                        <option value="XII" {{ request('tingkat') === 'XII' ? 'selected' : '' }}>Tingkat XII (Kelas 12)</option>
                    </select>
                </div>

                <!-- 4. Dropdown Filter Rombel Spesifik -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Rombel Kelas</label>
                    <select name="kelas" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                        <option value="all">Semua Rombel (18 Kelas)</option>
                        @foreach ($kelasList as $k)
                            <option value="{{ $k }}" {{ request('kelas') === $k ? 'selected' : '' }}>Kelas {{ $k }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <!-- Baris Tambahan: Filter Gender & Tombol Aksi -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-2 border-t border-slate-100">
                <div class="flex items-center gap-3">
                    <label class="text-[11px] font-bold text-slate-600 uppercase">Jenis Kelamin:</label>
                    <select name="gender" class="text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-1.5 px-3">
                        <option value="all">Semua Gender (L/P)</option>
                        <option value="L" {{ request('gender') === 'L' ? 'selected' : '' }}>Laki-laki (L)</option>
                        <option value="P" {{ request('gender') === 'P' ? 'selected' : '' }}>Perempuan (P)</option>
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-slate-800 hover:bg-slate-900 rounded transition-colors">
                        Terapkan Filter
                    </button>

                    @if(request('search') || request('jurusan') || request('tingkat') || request('kelas') || request('gender'))
                        <a href="{{ route('admin.siswa.index') }}" class="px-3.5 py-2 text-xs font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded">
                            Reset Filter
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Table Siswa (Sama Rata, Bersih & Terstandarisasi) -->
    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase tracking-wider">
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3 px-4">NIS</th>
                        <th class="py-3 px-4">Kelas / Jurusan</th>
                        <th class="py-3 px-4 text-center">L/P</th>
                        <th class="py-3 px-4">Email Akun</th>
                        <th class="py-3 px-4 text-center">Nilai</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($siswas as $siswa)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <x-avatar :user="$siswa->user" :name="$siswa->nama" size="sm" class="shrink-0" />
                                    <div>
                                        <p class="font-bold text-slate-900">
                                            {{ $siswa->nama }}
                                        </p>
                                        <p class="text-[11px] text-slate-500">{{ $siswa->alamat }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 font-mono font-semibold text-slate-600 whitespace-nowrap">{{ $siswa->nis }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-700">
                                <span class="inline-block px-2 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $siswa->kelas }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-block px-1.5 py-0.5 text-[10px] font-semibold rounded {{ $siswa->jenis_kelamin === 'P' ? 'bg-pink-50 text-pink-700 border border-pink-200' : 'bg-sky-50 text-sky-700 border border-sky-200' }}">
                                    {{ $siswa->jenis_kelamin }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-600">
                                {{ $siswa->user?->email ?? '—' }}
                            </td>
                            <td class="py-3 px-4 text-center font-semibold text-slate-700">
                                <span class="text-pink-600 font-bold">{{ $siswa->nilais->count() }}</span> Record
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.siswa.show', $siswa) }}" class="px-2 py-1 text-[11px] font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded">Detail</a>
                                    @if(Auth::user()->isAdministratorLevel())
                                    <a href="{{ route('admin.siswa.edit', $siswa) }}" class="px-2 py-1 text-[11px] font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded">Edit</a>
                                    <form action="{{ route('admin.siswa.destroy', $siswa) }}" method="POST" onsubmit="return confirm('Hapus data murid ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 text-[11px] font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded">Hapus</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">Tidak ditemukan data siswa dengan kriteria filter yang dipilih.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-200 bg-slate-50">
            {{ $siswas->links() }}
        </div>
    </div>

</div>
@endsection
