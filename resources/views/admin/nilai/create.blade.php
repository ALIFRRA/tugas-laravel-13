@extends('layouts.admin')

@section('title', 'Tambah Nilai — SMK Shuka')
@section('heading', 'Tambah Nilai Siswa')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white border border-slate-200 rounded-lg p-6 shadow-2xs space-y-5">
        <div class="border-b border-slate-200 pb-3">
            <h3 class="text-sm font-bold text-slate-900">Formulir Penilaian Siswa</h3>
            <p class="text-xs text-slate-500">Cari siswa berdasarkan nama atau NIS, pilih mata pelajaran, dan tentukan skor perolehan.</p>
        </div>

        <form method="POST" action="{{ route('admin.nilai.store') }}" class="space-y-4">
            @csrf

            <!-- komponen pencarian siswa -->
            <x-siswa-picker :siswas="$siswas" label="Pilih Siswa" :selected="old('siswa_id', request('siswa_id'))" />

            <!-- pilihan mapel -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Mata Pelajaran <span class="text-rose-500">*</span></label>
                <select name="mapel_id" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3 bg-white text-slate-900">
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach ($mapels as $mapel)
                        <option value="{{ $mapel->id }}" @selected((string) old('mapel_id', request('mapel_id')) === (string) $mapel->id)>
                            {{ $mapel->nama }} ({{ $mapel->kode }})
                        </option>
                    @endforeach
                </select>
                @error('mapel_id')
                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- jenis nilai & skor -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis Penilaian <span class="text-rose-500">*</span></label>
                    <select name="jenis_nilai" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3 bg-white text-slate-900">
                        <option value="Tugas" @selected(old('jenis_nilai') === 'Tugas')>Tugas Praktik / Studio</option>
                        <option value="UH" @selected(old('jenis_nilai') === 'UH')>Ulangan Harian (UH)</option>
                        <option value="UTS" @selected(old('jenis_nilai') === 'UTS')>Ujian Tengah Semester (UTS)</option>
                        <option value="UAS" @selected(old('jenis_nilai') === 'UAS')>Ujian Akhir Semester (UAS)</option>
                        <option value="UKK" @selected(old('jenis_nilai') === 'UKK')>Uji Kompetensi Kejuruan (UKK)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Skor Nilai (0 - 100) <span class="text-rose-500">*</span></label>
                    <input type="number" name="nilai" value="{{ old('nilai') }}" required step="0.01" min="0" max="100" placeholder="Contoh: 88.5" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                    @error('nilai')
                        <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 pt-3 border-t border-slate-100">
                <button type="submit" class="px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold text-xs rounded transition-colors shadow-2xs">
                    Simpan Nilai
                </button>
                <a href="{{ route('admin.nilai.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded transition-colors border border-slate-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
