@extends('layouts.admin')

@section('title', 'Detail Nilai — Shuka Highschool')
@section('heading', 'Detail nilai')
@section('subheading', $nilai->siswa->nama)

@section('content')
    <div class="soft-panel max-w-xl space-y-3 p-5 text-sm sm:p-6">
        <div class="flex justify-between border-b border-shuka-line pb-2"><span class="text-slate-500">Mapel</span><span>{{ $nilai->mapel->nama }}</span></div>
        <div class="flex justify-between border-b border-shuka-line pb-2"><span class="text-slate-500">Jenis</span><span>{{ $nilai->jenis_nilai }}</span></div>
        <div class="flex justify-between border-b border-shuka-line pb-2"><span class="text-slate-500">Nilai</span><span class="font-medium text-shuka-pink">{{ $nilai->nilai }}</span></div>
        <div class="pt-3"><x-button variant="secondary" href="{{ route('admin.nilai.edit', $nilai) }}">Edit</x-button></div>
    </div>
@endsection
