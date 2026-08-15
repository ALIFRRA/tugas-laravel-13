@extends('layouts.guru')

@section('title', 'Tambah Nilai Siswa — SMK Shuka (秀華高等専門学校)')
@section('heading', 'Input Nilai Siswa Baru')
@section('subheading', 'Catat hasil evaluasi dan penilaian mata pelajaran kejuruan.')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white border border-slate-200 rounded-lg p-6 shadow-sm space-y-5">
        <div class="border-b border-slate-200 pb-3">
            <h3 class="text-sm font-bold text-slate-900">Formulir Penilaian Siswa</h3>
            <p class="text-xs text-slate-500">Lengkapi data siswa, mata pelajaran, dan skor perolehan.</p>
        </div>

        <form method="POST" action="{{ route('guru.nilai.store') }}" class="space-y-4">
            @csrf

            <!-- Pilihan Siswa -->
            <x-input type="select" name="siswa_id" label="Pilih Siswa" required>
                <option value="">-- Pilih Siswa Berdasarkan Nama & NIS --</option>
                @foreach ($siswas as $siswa)
                    <option value="{{ $siswa->id }}" @selected(old('siswa_id') == $siswa->id)>
                        {{ $siswa->nama }} (NIS: {{ $siswa->nis }} - Kelas: {{ $siswa->kelas }})
                    </option>
                @endforeach
            </x-input>

            <!-- Pilihan Mapel -->
            <x-input type="select" name="mapel_id" label="Mata Pelajaran" required>
                <option value="">-- Pilih Mata Pelajaran --</option>
                @foreach ($mapels as $mapel)
                    <option value="{{ $mapel->id }}" @selected(old('mapel_id', request('mapel_id')) == $mapel->id)>
                        {{ $mapel->nama }} ({{ $mapel->kode }})
                    </option>
                @endforeach
            </x-input>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis Penilaian <span class="text-rose-500">*</span></label>
                    <select name="jenis_nilai" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3 bg-white text-slate-900">
                        <option value="Tugas Praktik" @selected(old('jenis_nilai') == 'Tugas Praktik')>Tugas Praktik / Studio</option>
                        <option value="Ulangan Harian" @selected(old('jenis_nilai') == 'Ulangan Harian')>Ulangan Harian (UH)</option>
                        <option value="Ujian Tengah Semester" @selected(old('jenis_nilai') == 'Ujian Tengah Semester')>Ujian Tengah Semester (UTS)</option>
                        <option value="Ujian Akhir Semester" @selected(old('jenis_nilai') == 'Ujian Akhir Semester')>Ujian Akhir Semester (UAS)</option>
                        <option value="Uji Kompetensi Kejuruan" @selected(old('jenis_nilai') == 'Uji Kompetensi Kejuruan')>Uji Kompetensi Kejuruan (UKK)</option>
                    </select>
                </div>

                <x-input type="number" name="nilai" label="Skor Nilai (0 - 100)" :value="old('nilai')" required step="0.01" min="0" max="100" placeholder="Contoh: 88.5" />
            </div>

            <div class="flex items-center gap-3 pt-3 border-t border-slate-100">
                <button type="submit" class="px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold text-xs rounded transition-colors shadow-sm">
                    Simpan Nilai
                </button>
                <a href="{{ route('guru.nilai.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded transition-colors border border-slate-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
