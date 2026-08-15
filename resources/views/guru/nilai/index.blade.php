@extends('layouts.guru')

@section('title', 'Kelola Nilai — SMK Shuka (秀華高等専門学校)')
@section('heading', 'Input & Kelola Nilai Siswa')
@section('subheading', 'Daftar rekapitulasi penilaian mata pelajaran kejuruan.')

@section('content')
<div class="space-y-5">
    
    <!-- Top Filter & Action Bar -->
    <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-2">
            <span class="text-xs text-slate-500 font-medium">Total Catatan Nilai:</span>
            <span class="px-2 py-0.5 rounded font-bold text-xs bg-pink-50 text-pink-700 border border-pink-200">
                {{ $nilais->total() }} Nilai
            </span>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <form method="GET" action="{{ route('guru.nilai.index') }}" class="flex items-center gap-2">
                <label for="sort" class="text-xs font-semibold text-slate-600">Urutkan:</label>
                <select id="sort" name="sort" class="text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-1.5 px-2.5 bg-white" onchange="this.form.submit()">
                    <option value="">Terbaru (Default)</option>
                    @foreach ($sortOptions as $value => $label)
                        <option value="{{ $value }}" @selected($sort === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </form>

            <a href="{{ route('guru.nilai.create') }}" class="px-3.5 py-1.5 bg-pink-500 hover:bg-pink-600 text-white font-semibold text-xs rounded transition-colors shadow-sm inline-flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>+ Tambah Nilai</span>
            </a>
        </div>
    </div>

    <!-- Tabel Nilai -->
    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-slate-50 text-slate-700 uppercase font-bold text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3 px-4">Mata Pelajaran</th>
                        <th class="py-3 px-4">Jenis Penilaian</th>
                        <th class="py-3 px-4 text-center">Skor Nilai</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-800">
                    @forelse ($nilais as $nilai)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4">
                                <span class="font-bold text-slate-900 block">{{ $nilai->siswa->nama }}</span>
                                <span class="text-[10px] text-slate-500 font-mono">NIS: {{ $nilai->siswa->nis }} • Kelas: {{ $nilai->siswa->kelas }}</span>
                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-700">{{ $nilai->mapel->nama }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $nilai->jenis_nilai }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="font-bold font-mono text-sm {{ $nilai->nilai >= 80 ? 'text-pink-600' : ($nilai->nilai >= 70 ? 'text-slate-900' : 'text-rose-600') }}">
                                    {{ $nilai->nilai }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('guru.nilai.edit', $nilai) }}" class="px-2.5 py-1 text-[11px] font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-200 rounded">
                                        Edit
                                    </a>
                                    <form action="{{ route('guru.nilai.destroy', $nilai) }}" method="POST" onsubmit="return confirm('Hapus data nilai ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 text-[11px] font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-xs text-slate-400">
                                Belum ada nilai yang tercatat di mapelmu.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($nilais->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $nilais->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
