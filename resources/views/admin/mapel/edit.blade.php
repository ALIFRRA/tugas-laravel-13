<?php
@extends('layouts.admin')

@section('title', 'Edit Mapel — Shuka Highschool')
@section('heading', 'Edit mapel')
@section('subheading', $mapel->nama)

@section('content')
    <form method="POST" action="{{ route('admin.mapel.update', $mapel) }}" class="soft-panel max-w-2xl space-y-5 p-5 sm:p-6">
        @csrf
        @method('PUT')
        <x-input name="nama" label="Nama mapel" :value="old('nama', $mapel->nama)" required />
        <x-input name="kode" label="Kode" :value="old('kode', $mapel->kode)" required />
        <x-input type="select" name="guru_id" label="Guru pengampu" required>
            @foreach ($gurus as $guru)
                <option value="{{ $guru->id }}" @selected(old('guru_id', $mapel->guru_id) == $guru->id)>{{ $guru->nama }}</option>
            @endforeach
        </x-input>
        <div class="flex flex-wrap gap-3 pt-2">
            <x-button>Perbarui</x-button>
            <x-button variant="secondary" href="{{ route('admin.mapel.index') }}" type="button">Batal</x-button>
        </div>
    </form>
@endsection
