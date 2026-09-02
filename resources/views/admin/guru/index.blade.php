@extends('layouts.admin')

@section('title', 'Data Guru — SMK Shuka')
@section('heading', 'Data Tenaga Pendidik (45 Guru)')

@section('content')
<div class="space-y-5">

    <!-- Header Action & Filter Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-3 border-b border-slate-200">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">Database Guru SMK Shuka</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Kelola data 45 tenaga pendidik kejuruan, mata pelajaran yang diampu, dan nomor induk pegawai.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-3 py-1.5 rounded text-xs font-semibold bg-pink-50 text-pink-700 border border-pink-200">
                Total: {{ $gurus->total() }} Guru
            </span>
            <a href="{{ route('admin.guru.create') }}" class="px-3.5 py-1.5 text-xs font-semibold text-white bg-pink-500 hover:bg-pink-600 rounded flex items-center gap-1.5 transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Guru</span>
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="bg-white p-4 border border-slate-200 rounded-lg shadow-sm">
        <form method="GET" action="{{ route('admin.guru.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-3">
            <div class="flex-1 relative">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari berdasarkan nama guru, NIP, atau mata pelajaran..." 
                    class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 pl-9 pr-3"
                >
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-slate-800 hover:bg-slate-900 rounded transition-colors">
                    Cari Guru
                </button>

                @if(request('search'))
                    <a href="{{ route('admin.guru.index') }}" class="px-3 py-2 text-xs font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Guru (Minimalist & Equal Presentation) -->
    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase tracking-wider">
                        <th class="py-3 px-4">Nama Guru & Gelar</th>
                        <th class="py-3 px-4">NIP</th>
                        <th class="py-3 px-4">Mata Pelajaran Diampu</th>
                        <th class="py-3 px-4">Email Akun</th>
                        <th class="py-3 px-4">No. Telepon</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($gurus as $guru)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <x-avatar :user="$guru->user" :name="$guru->nama" size="sm" class="shrink-0" />
                                    <div>
                                        <p class="font-bold text-slate-900">
                                            {{ $guru->nama }}
                                        </p>
                                        <p class="text-[11px] text-slate-500">{{ $guru->user?->roleLabel() ?? 'Tenaga Pendidik' }}</p>
                                        @if($guru->user?->jabatan)
                                            <p class="text-[10px] text-pink-600 truncate max-w-[180px]">{{ $guru->user->jabatan }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 font-mono font-semibold text-slate-600 whitespace-nowrap">{{ $guru->nip }}</td>
                            <td class="py-3 px-4">
                                @if($guru->mataPelajarans->count())
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($guru->mataPelajarans as $mapel)
                                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold bg-pink-50 text-pink-700 border border-pink-200">
                                                {{ $mapel->kode }} - {{ $mapel->nama }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-slate-400 text-xs italic">Belum ada mapel</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-slate-600">
                                {{ $guru->user?->email ?? '—' }}
                            </td>
                            <td class="py-3 px-4 text-slate-600 font-mono">{{ $guru->no_telepon }}</td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.guru.show', $guru) }}" class="px-2 py-1 text-[11px] font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded">Detail</a>
                                    <a href="{{ route('admin.guru.edit', $guru) }}" class="px-2 py-1 text-[11px] font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded">Edit</a>
                                    <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" onsubmit="return confirm('Hapus data guru ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 text-[11px] font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Tidak ditemukan data guru yang cocok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-200 bg-slate-50">
            {{ $gurus->links() }}
        </div>
    </div>

</div>
@endsection
