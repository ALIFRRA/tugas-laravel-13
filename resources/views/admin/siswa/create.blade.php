@extends('layouts.admin')

@section('title', 'Tambah Data Murid — Shuka Highschool')
@section('heading', 'Tambah Data Murid')
@section('subheading', 'Isi data profil murid dan informasi akun login.')

@section('content')
    <form method="POST" action="{{ route('admin.siswa.store') }}" class="rounded-2xl border border-pink-100 bg-white p-6 shadow-sm max-w-2xl space-y-5">
        @csrf

        <div class="border-b border-slate-100 pb-3">
            <h3 class="font-bold text-slate-800 text-base">Profil Utama Murid</h3>
            <p class="text-xs text-slate-500">Informasi biodata dan kelas murid.</p>
        </div>

        <x-input name="nama" label="Nama Lengkap" :value="old('nama')" required />
        
        <div class="grid gap-5 sm:grid-cols-2">
            <x-input name="nis" label="NIS (Nomor Induk Siswa)" :value="old('nis')" required />
            <x-input name="kelas" label="Kelas" :value="old('kelas')" required />
        </div>

        <x-input type="select" name="jenis_kelamin" label="Jenis Kelamin" required>
            <option value="">Pilih Jenis Kelamin</option>
            <option value="L" @selected(old('jenis_kelamin') === 'L')>Laki-laki</option>
            <option value="P" @selected(old('jenis_kelamin') === 'P')>Perempuan</option>
        </x-input>

        <x-input type="date" name="tanggal_lahir" label="Tanggal Lahir" :value="old('tanggal_lahir')" required />
        <x-input type="textarea" name="alamat" label="Alamat Tempat Tinggal" :value="old('alamat')" required rows="3" />

        <div class="border-b border-slate-100 pt-4 pb-3">
            <h3 class="font-bold text-slate-800 text-base">Akun Login Pengguna (Opsional)</h3>
            <p class="text-xs text-slate-500">Isi email & password jika murid ini membutuhkan akun login sistem.</p>
        </div>

        <x-input name="email" type="email" label="Email Login" :value="old('email')" placeholder="contoh: murid@shuka.sch.id" />
        <x-input name="password" type="password" label="Password (Default: password123)" placeholder="Minimal 8 karakter" />

        <div class="flex flex-wrap gap-3 pt-4 border-t border-slate-100">
            <x-button class="bg-pink-500 hover:bg-pink-600 text-white font-semibold">Simpan Data Murid</x-button>
            <x-button variant="secondary" href="{{ route('admin.siswa.index') }}" type="button">Batal</x-button>
        </div>
    </form>
@endsection
