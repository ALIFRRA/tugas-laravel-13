@extends('layouts.admin')

@section('title', 'Edit Guru — Shuka Highschool')
@section('heading', 'Edit guru')
@section('subheading', $guru->nama)

@section('content')
    <form method="POST" action="{{ route('admin.guru.update', $guru) }}" class="soft-panel max-w-2xl space-y-5 p-5 sm:p-6">
        @csrf
        @method('PUT')
        <x-input name="nama" label="Nama" :value="old('nama', $guru->nama)" required />
        <x-input name="nip" label="NIP" :value="old('nip', $guru->nip)" required />
        <x-input name="mata_pelajaran" label="Mata pelajaran" :value="old('mata_pelajaran', $guru->mata_pelajaran)" required />
        <x-input name="no_telepon" label="No. telepon" :value="old('no_telepon', $guru->no_telepon)" required />
        <div class="flex flex-wrap gap-3 pt-2">
            <x-button>Perbarui</x-button>
            <x-button variant="secondary" href="{{ route('admin.guru.index') }}" type="button">Batal</x-button>
        </div>
    </form>
@endsection
