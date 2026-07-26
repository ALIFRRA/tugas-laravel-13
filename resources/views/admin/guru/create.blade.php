@extends('layouts.admin')

@section('title', 'Tambah Guru — Shuka Highschool')
@section('heading', 'Tambah guru')
@section('subheading', 'Isi data guru baru.')

@section('content')
    <form method="POST" action="{{ route('admin.guru.store') }}" class="soft-panel max-w-2xl space-y-5 p-5 sm:p-6">
        @csrf
        <x-input name="nama" label="Nama" :value="old('nama')" required />
        <x-input name="nip" label="NIP" :value="old('nip')" required />
        <x-input name="mata_pelajaran" label="Mata pelajaran" :value="old('mata_pelajaran')" required />
        <x-input name="no_telepon" label="No. telepon" :value="old('no_telepon')" required />
        <div class="flex flex-wrap gap-3 pt-2">
            <x-button>Simpan</x-button>
            <x-button variant="secondary" href="{{ route('admin.guru.index') }}" type="button">Batal</x-button>
        </div>
    </form>
@endsection
