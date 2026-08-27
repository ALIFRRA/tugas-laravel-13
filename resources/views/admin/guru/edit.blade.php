@extends('layouts.admin')

@section('title', 'Edit Data Guru — Shuka Highschool')
@section('heading', 'Edit Data Guru')
@section('subheading', $guru->nama)

@section('content')
    <x-card class="max-w-2xl space-y-5 border-pink-100 p-6 rounded-2xl">
    <form method="POST" action="{{ route('admin.guru.update', $guru) }}" class="space-y-5">
        @csrf
        @method('PUT')

        <div class="border-b border-slate-100 pb-3">
            <h3 class="font-bold text-slate-800 text-base">Profil Utama Guru</h3>
            <p class="text-xs text-slate-500">Perbarui identitas dan informasi mengajar.</p>
        </div>

        <x-input name="nama" label="Nama Lengkap & Gelar" :value="old('nama', $guru->nama)" required />
        <x-input name="nip" label="NIP (Nomor Induk Pegawai)" :value="old('nip', $guru->nip)" required />
        <x-input name="no_telepon" label="No. Telepon / WhatsApp" :value="old('no_telepon', $guru->no_telepon)" required />
        <p class="text-xs text-slate-500 italic">Mata pelajaran diatur di modul <a href="{{ route('admin.mapel.index') }}" class="underline text-pink-600 hover:text-pink-700">Data Mata Pelajaran</a>.</p>

        <div class="border-b border-slate-100 pt-4 pb-3">
            <h3 class="font-bold text-slate-800 text-base">Akun Login Pengguna</h3>
            <p class="text-xs text-slate-500">Kelola email & password akun login terkait.</p>
        </div>

        <x-input name="email" type="email" label="Email Login" :value="old('email', $guru->user?->email)" placeholder="contoh: guru@shuka.sch.id" />
        <x-input name="password" type="password" label="Password Baru (Kosongkan jika tidak ingin mengubah)" placeholder="Minimal 8 karakter" />

        <div class="flex flex-wrap gap-3 pt-4 border-t border-slate-100">
            <x-button class="bg-pink-500 hover:bg-pink-600 text-white font-semibold">Simpan Perubahan</x-button>
            <x-button variant="secondary" href="{{ route('admin.guru.index') }}" type="button">Batal</x-button>
        </div>
    </form>
    </x-card>
@endsection
