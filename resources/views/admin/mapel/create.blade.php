<?php
@extends('layouts.admin')

@section('title', 'Tambah Mapel — Shuka Highschool')
@section('heading', 'Tambah mapel')
@section('subheading', 'Hubungkan mapel ke guru pengampu.')

@section('content')
    <form method="POST" action="{{ route('admin.mapel.store') }}" class="soft-panel max-w-2xl space-y-5 p-5 sm:p-6">
        @csrf
        <x-input name="nama" label="Nama mapel" :value="old('nama')" required />
        <x-input name="kode" label="Kode" :value="old('kode')" required />
        <x-input type="select" name="guru_id" label="Guru pengampu" required>
            <option value="">Pilih guru</option>
            @foreach ($gurus as $guru)
                <option value="{{ $guru->id }}" @selected(old('guru_id') == $guru->id)>{{ $guru->nama }}</option>
            @endforeach
        </x-input>
        <div class="flex flex-wrap gap-3 pt-2">
            <x-button>Simpan</x-button>
            <x-button variant="secondary" href="{{ route('admin.mapel.index') }}" type="button">Batal</x-button>
        </div>
    </form>
@endsection
