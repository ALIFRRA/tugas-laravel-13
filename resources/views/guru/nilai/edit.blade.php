@extends('layouts.guru')

@section('title', 'Edit Nilai — Shuka Highschool')
@section('heading', 'Edit nilai')
@section('subheading', 'Perbarui catatan nilai mapelmu.')

@section('content')
    <form method="POST" action="{{ route('guru.nilai.update', $nilai) }}" class="soft-panel max-w-2xl space-y-5 p-5 sm:p-6">
        @csrf
        @method('PUT')
        <x-input type="select" name="siswa_id" label="Siswa" required>
            @foreach ($siswas as $siswa)
                <option value="{{ $siswa->id }}" @selected(old('siswa_id', $nilai->siswa_id) == $siswa->id)>{{ $siswa->nama }} ({{ $siswa->nis }})</option>
            @endforeach
        </x-input>
        <x-input type="select" name="mapel_id" label="Mata pelajaran" required>
            @foreach ($mapels as $mapel)
                <option value="{{ $mapel->id }}" @selected(old('mapel_id', $nilai->mapel_id) == $mapel->id)>{{ $mapel->nama }}</option>
            @endforeach
        </x-input>
        <div class="grid gap-5 sm:grid-cols-2">
            <x-input name="jenis_nilai" label="Jenis nilai" :value="old('jenis_nilai', $nilai->jenis_nilai)" required />
            <x-input type="number" name="nilai" label="Nilai" :value="old('nilai', $nilai->nilai)" required step="0.01" min="0" max="100" />
        </div>
        <div class="flex flex-wrap gap-3 pt-2">
            <x-button>Perbarui</x-button>
            <x-button variant="secondary" href="{{ route('guru.nilai.index') }}" type="button">Batal</x-button>
        </div>
    </form>
@endsection
