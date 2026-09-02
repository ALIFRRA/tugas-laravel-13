@extends('layouts.admin')

@section('title', 'Tambah Jadwal — Shuka Highschool')
@section('heading', 'Tambah jadwal')
@section('subheading', 'Atur slot pelajaran.')

@section('content')
    <form method="POST" action="{{ route('admin.jadwal.store') }}" class="soft-panel max-w-2xl space-y-5 p-5 sm:p-6">
        @csrf
        <x-input type="select" name="mapel_id" label="Mata pelajaran" required>
            <option value="">Pilih mapel</option>
            @foreach ($mapels as $mapel)
                <option value="{{ $mapel->id }}" @selected(old('mapel_id') == $mapel->id)>{{ $mapel->nama }} ({{ $mapel->kode }})</option>
            @endforeach
        </x-input>
        <div class="grid gap-5 sm:grid-cols-2">
            <x-input name="kelas" label="Kelas" :value="old('kelas')" required />
            <x-input type="select" name="hari" label="Hari" required>
                <option value="">Pilih hari</option>
                @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                    <option value="{{ $hari }}" @selected(old('hari') === $hari)>{{ $hari }}</option>
                @endforeach
            </x-input>
        </div>
        <div class="grid gap-5 sm:grid-cols-2">
            <x-input type="time" name="jam_mulai" label="Jam mulai" :value="old('jam_mulai')" required />
            <x-input type="time" name="jam_selesai" label="Jam selesai" :value="old('jam_selesai')" required />
        </div>
        <div class="flex flex-wrap gap-3 pt-2">
            <x-button>Simpan</x-button>
            <x-button variant="secondary" href="{{ route('admin.jadwal.index') }}" type="button">Batal</x-button>
        </div>
    </form>
@endsection
