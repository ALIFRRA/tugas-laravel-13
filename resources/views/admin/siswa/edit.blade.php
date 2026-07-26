@extends('layouts.admin')

@section('title', 'Edit Siswa — Shuka Highschool')
@section('heading', 'Edit siswa')
@section('subheading', $siswa->nama)

@section('content')
    <form method="POST" action="{{ route('admin.siswa.update', $siswa) }}" class="soft-panel max-w-2xl space-y-5 p-5 sm:p-6">
        @csrf
        @method('PUT')
        <x-input name="nama" label="Nama" :value="old('nama', $siswa->nama)" required />
        <div class="grid gap-5 sm:grid-cols-2">
            <x-input name="nis" label="NIS" :value="old('nis', $siswa->nis)" required />
            <x-input name="kelas" label="Kelas" :value="old('kelas', $siswa->kelas)" required />
        </div>
        <x-input type="select" name="jenis_kelamin" label="Jenis kelamin" required>
            <option value="L" @selected(old('jenis_kelamin', $siswa->jenis_kelamin) === 'L')>Laki-laki</option>
            <option value="P" @selected(old('jenis_kelamin', $siswa->jenis_kelamin) === 'P')>Perempuan</option>
        </x-input>
        <x-input type="date" name="tanggal_lahir" label="Tanggal lahir" :value="old('tanggal_lahir', $siswa->tanggal_lahir?->format('Y-m-d'))" required />
        <x-input type="textarea" name="alamat" label="Alamat" :value="old('alamat', $siswa->alamat)" required rows="3" />
        <div class="flex flex-wrap gap-3 pt-2">
            <x-button>Perbarui</x-button>
            <x-button variant="secondary" href="{{ route('admin.siswa.index') }}" type="button">Batal</x-button>
        </div>
    </form>
@endsection
