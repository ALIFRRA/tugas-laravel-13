@extends('layouts.admin')

@section('title', 'Edit Jadwal — Shuka Highschool')
@section('heading', 'Edit jadwal')
@section('subheading', $jadwal->hari.' · '.$jadwal->kelas)

@section('content')
    <form method="POST" action="{{ route('admin.jadwal.update', $jadwal) }}" class="soft-panel max-w-2xl space-y-5 p-5 sm:p-6">
        @csrf
        @method('PUT')
        <x-input type="select" name="mapel_id" label="Mata pelajaran" required>
            @foreach ($mapels as $mapel)
                <option value="{{ $mapel->id }}" @selected(old('mapel_id', $jadwal->mapel_id) == $mapel->id)>{{ $mapel->nama }} ({{ $mapel->kode }})</option>
            @endforeach
        </x-input>
        <div class="grid gap-5 sm:grid-cols-2">
            <x-input name="kelas" label="Kelas" :value="old('kelas', $jadwal->kelas)" required />
            <x-input type="select" name="hari" label="Hari" required>
                @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                    <option value="{{ $hari }}" @selected(old('hari', $jadwal->hari) === $hari)>{{ $hari }}</option>
                @endforeach
            </x-input>
        </div>
        <div class="grid gap-5 sm:grid-cols-2">
            <x-input type="time" name="jam_mulai" label="Jam mulai" :value="old('jam_mulai', $jadwal->jam_mulai)" required />
            <x-input type="time" name="jam_selesai" label="Jam selesai" :value="old('jam_selesai', $jadwal->jam_selesai)" required />
        </div>
        <div class="flex flex-wrap gap-3 pt-2">
            <x-button>Perbarui</x-button>
            <x-button variant="secondary" href="{{ route('admin.jadwal.index') }}" type="button">Batal</x-button>
        </div>
    </form>
@endsection
