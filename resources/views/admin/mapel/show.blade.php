@extends('layouts.admin')

@section('title', 'Detail Mapel — Shuka Highschool')
@section('heading', 'Detail mapel')
@section('subheading', $mapel->nama)

@section('content')
    <div class="soft-panel max-w-xl space-y-3 p-5 text-sm sm:p-6">
        <div class="flex justify-between border-b border-shuka-line pb-2"><span class="text-slate-500">Kode</span><span>{{ $mapel->kode }}</span></div>
        <div class="flex justify-between border-b border-shuka-line pb-2"><span class="text-slate-500">Guru</span><span>{{ $mapel->guru->nama }}</span></div>
        <div class="pt-3"><x-button variant="secondary" href="{{ route('admin.mapel.edit', $mapel) }}">Edit</x-button></div>
    </div>
@endsection
