@extends('layouts.admin')

@section('title', 'Tambah Ekstrakurikuler — SMK Shuka')
@section('heading', 'Tambah Klub Ekstrakurikuler Baru')
@section('subheading', 'Isi data klub dan informasi kegiatan')

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.ekskul.store') }}" class="bg-white border border-slate-200 rounded-lg p-6 shadow-sm space-y-5">
        @csrf

        <div class="border-b border-slate-100 pb-3">
            <h3 class="font-bold text-slate-800 text-base">Informasi Dasar Klub</h3>
            <p class="text-xs text-slate-500">Data identitas klub ekstrakurikuler.</p>
        </div>

        <x-input name="nama" label="Nama Klub (Indonesia)" :value="old('nama')" required placeholder="Contoh: Kessoku Band (軽音楽部)" />
        <x-input name="nama_en" label="Nama Klub (English)" :value="old('nama_en')" placeholder="Contoh: Kessoku Band (Light Music Club)" />
        
        <x-input type="select" name="kategori" label="Kategori" :value="old('kategori')" required>
            <option value="">-- Pilih Kategori --</option>
            <option value="Seni Musik Populer" @selected(old('kategori') === 'Seni Musik Populer')>Seni Musik Populer</option>
            <option value="Teknologi Audio & PA" @selected(old('kategori') === 'Teknologi Audio & PA')>Teknologi Audio & PA</option>
            <option value="Desain Visual & Merchandise" @selected(old('kategori') === 'Desain Visual & Merchandise')>Desain Visual & Merchandise</option>
            <option value="Media & Penyiaran" @selected(old('kategori') === 'Media & Penyiaran')>Media & Penyiaran</option>
            <option value="Hospitality & Kuliner" @selected(old('kategori') === 'Hospitality & Kuliner')>Hospitality & Kuliner</option>
            <option value="Teknologi Informasi" @selected(old('kategori') === 'Teknologi Informasi')>Teknologi Informasi</option>
            <option value="Jurnalistik Foto" @selected(old('kategori') === 'Jurnalistik Foto')>Jurnalistik Foto</option>
            <option value="Teknik Panggung" @selected(old('kategori') === 'Teknik Panggung')>Teknik Panggung</option>
            <option value="Seni Vokal" @selected(old('kategori') === 'Seni Vokal')>Seni Vokal</option>
            <option value="Seni Peran & Karakter" @selected(old('kategori') === 'Seni Peran & Karakter')>Seni Peran & Karakter</option>
            <option value="Olahraga & Kebugaran" @selected(old('kategori') === 'Olahraga & Kebugaran')>Olahraga & Kebugaran</option>
            <option value="Bahasa & Budaya" @selected(old('kategori') === 'Bahasa & Budaya')>Bahasa & Budaya</option>
        </x-input>

        <x-input name="pembina" label="Pembina" :value="old('pembina')" required placeholder="Contoh: Seika Ijichi (Manager STARRY) & Gin Sasaki, S.Pd." />
        <x-input name="ketua" label="Ketua Klub (Opsional)" :value="old('ketua')" placeholder="Contoh: Nijika Ijichi (X-SMP-2)" />
        <x-input type="number" name="anggota" label="Jumlah Anggota (Estimasi)" :value="old('anggota', 0)" min="0" />
        <x-input name="jadwal" label="Jadwal Kegiatan" :value="old('jadwal')" placeholder="Contoh: Rabu & Sabtu, 16:30" />
        <x-input name="lokasi" label="Lokasi Kegiatan" :value="old('lokasi')" placeholder="Contoh: Livehouse STARRY Basement & Studio 1" />

        <div class="border-t border-slate-100 pt-3">
            <h3 class="font-bold text-slate-800 text-base mb-3">Deskripsi & Kegiatan</h3>
        </div>

        <x-input type="textarea" name="deskripsi" label="Deskripsi Klub" :value="old('deskripsi')" rows="3" placeholder="Deskripsi singkat tentang tujuan dan fokus klub..." />
        <x-input type="textarea" name="kegiatan_utama" label="Kegiatan Utama" :value="old('kegiatan_utama')" rows="3" placeholder="Contoh: Latihan rutin band, panggung Shuka-sai, live show showcase..." />
        <x-input type="textarea" name="prestasi" label="Prestasi Klub (Opsional)" :value="old('prestasi')" rows="2" placeholder="Contoh: Juara 1 Festival Band SMK Se-Jabodetabek 2026..." />

        <div class="flex items-center gap-2 pt-3 border-t border-slate-100">
            <x-input type="checkbox" name="is_active" label="Status Aktif" :checked="old('is_active', true)" value="1" />
        </div>

        <div class="flex flex-wrap gap-3 pt-4 border-t border-slate-100">
            <x-button class="bg-pink-500 hover:bg-pink-600 text-white font-semibold">Simpan Klub</x-button>
            <x-button variant="secondary" href="{{ route('admin.ekskul.index') }}" type="button">Batal</x-button>
        </div>
    </form>
</div>
@endsection