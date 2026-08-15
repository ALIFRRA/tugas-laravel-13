@extends('layouts.admin')

@section('title', 'Mata Pelajaran — Shuka Highschool')
@section('heading', 'Mata Pelajaran (28 Mapel)')

@section('content')
<div class="space-y-5">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-3 border-b border-slate-200">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">Kurikulum & Mata Pelajaran</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Daftar 28 mata pelajaran kurikulum musik & akademik umum serta guru pengampu.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-3 py-1.5 rounded text-xs font-semibold bg-pink-50 text-pink-700 border border-pink-200">
                Total: {{ $mapels->total() }} Mapel
            </span>
            <a href="{{ route('admin.mapel.create') }}" class="px-3.5 py-1.5 text-xs font-semibold text-white bg-pink-500 hover:bg-pink-600 rounded flex items-center gap-1.5 transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Mapel</span>
            </a>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase tracking-wider">
                        <th class="py-3 px-4">Kode Mapel</th>
                        <th class="py-3 px-4">Nama Mata Pelajaran</th>
                        <th class="py-3 px-4">Guru Pengampu</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($mapels as $mapel)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-pink-600">{{ $mapel->kode }}</td>
                            <td class="py-3 px-4 font-bold text-slate-900">{{ $mapel->nama }}</td>
                            <td class="py-3 px-4 text-slate-700 font-medium">{{ $mapel->guru->nama ?? '—' }}</td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.mapel.edit', $mapel) }}" class="px-2 py-1 text-[11px] font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded">Edit</a>
                                    <form action="{{ route('admin.mapel.destroy', $mapel) }}" method="POST" onsubmit="return confirm('Hapus mata pelajaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 text-[11px] font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400">Belum ada data mata pelajaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-200 bg-slate-50">
            {{ $mapels->links() }}
        </div>
    </div>

</div>
@endsection
