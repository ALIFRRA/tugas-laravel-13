<?php
@extends('layouts.admin')

@section('title', 'Edit Ekstrakurikuler — SMK Shuka')
@section('heading', 'Edit Data Klub')
@section('subheading', '{{ $ekskul->nama }}')

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.ekskul.update', $ekskul) }}" class="bg-white border border-slate-200 rounded-lg p-6 shadow-sm space-y-5">
        @csrf
        @method('PUT')

        <div class="border-b border-slate-100 pb-3">
            <h3 class="font-bold text-slate-800 text-base">Informasi Dasar Klub</h3>
            <p class="text-xs text-slate-500">Perbarui data identitas klub ekstrakurikuler.</p>
        </div>

        <x-input name="nama" label="Nama Klub (Indonesia)" :value="old('nama', $ekskul->nama)" required />
        <x-input name="nama_en" label="Nama Klub (English)" :value="old('nama_en', $ekskul->nama_en)" />
        
        <x-input type="select" name="kategori" label="Kategori" :value="old('kategori', $ekskul->kategori)" required>
            <option value="Seni Musik Populer" @selected(old('kategori', $ekskul->kategori) === 'Seni Musik Populer')>Seni Musik Populer</option>
            <option value="Teknologi Audio & PA" @selected(old('kategori', $ekskul->kategori) === 'Teknologi Audio & PA')>Teknologi Audio & PA</option>
            <option value="Desain Visual & Merchandise" @selected(old('kategori', $ekskul->kategori) === 'Desain Visual & Merchandise')>Desain Visual & Merchandise</option>
            <option value="Media & Penyiaran" @selected(old('kategori', $ekskul->kategori) === 'Media & Penyiaran')>Media & Penyiaran</option>
            <option value="Hospitality & Kuliner" @selected(old('kategori', $ekskul->kategori) === 'Hospitality & Kuliner')>Hospitality & Kuliner</option>
            <option value="Teknologi Informasi" @selected(old('kategori', $ekskul->kategori) === 'Teknologi Informasi')>Teknologi Informasi</option>
            <option value="Jurnalistik Foto" @selected(old('kategori', $ekskul->kategori) === 'Jurnalistik Foto')>Jurnalistik Foto</option>
            <option value="Teknik Panggung" @selected(old('kategori', $ekskul->kategori) === 'Teknik Panggung')>Teknik Panggung</option>
            <option value="Seni Vokal" @selected(old('kategori', $ekskul->kategori) === 'Seni Vokal')>Seni Vokal</option>
            <option value="Seni Peran & Karakter" @selected(old('kategori', $ekskul->kategori) === 'Seni Peran & Karakter')>Seni Peran & Karakter</option>
            <option value="Olahraga & Kebugaran" @selected(old('kategori', $ekskul->kategori) === 'Olahraga & Kebugaran')>Olahraga & Kebugaran</option>
            <option value="Bahasa & Budaya" @selected(old('kategori', $ekskul->kategori) === 'Bahasa & Budaya')>Bahasa & Budaya</option>
        </x-input>

        <x-input name="pembina" label="Pembina" :value="old('pembina', $ekskul->pembina)" required />
        <x-input name="ketua" label="Ketua Klub (Opsional)" :value="old('ketua', $ekskul->ketua)" />
        <x-input type="number" name="anggota" label="Jumlah Anggota (Estimasi)" :value="old('anggota', $ekskul->anggota)" min="0" />
        <x-input name="jadwal" label="Jadwal Kegiatan" :value="old('jadwal', $ekskul->jadwal)" />
        <x-input name="lokasi" label="Lokasi Kegiatan" :value="old('lokasi', $ekskul->lokasi)" />

        <div class="border-t border-slate-100 pt-3">
            <h3 class="font-bold text-slate-800 text-base mb-3">Deskripsi & Kegiatan</h3>
        </div>

        <x-input type="textarea" name="deskripsi" label="Deskripsi Klub" :value="old('deskripsi', $ekskul->deskripsi)" rows="3" />
        <x-input type="textarea" name="kegiatan_utama" label="Kegiatan Utama" :value="old('kegiatan_utama', $ekskul->kegiatan_utama)" rows="3" />
        <x-input type="textarea" name="prestasi" label="Prestasi Klub (Opsional)" :value="old('prestasi', $ekskul->prestasi)" rows="2" />

        <div class="flex items-center gap-2 pt-3 border-t border-slate-100">
            <x-input type="checkbox" name="is_active" label="Status Aktif" :checked="old('is_active', $ekskul->is_active)" value="1" />
        </div>

        <div class="flex flex-wrap gap-3 pt-4 border-t border-slate-100">
            <x-button class="bg-pink-500 hover:bg-pink-600 text-white font-semibold">Simpan Perubahan</x-button>
            <x-button variant="secondary" href="{{ route('admin.ekskul.index') }}" type="button">Batal</x-button>
        </div>
    </form>
</div>
@endsection