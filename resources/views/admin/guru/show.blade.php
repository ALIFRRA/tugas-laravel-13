@extends('layouts.admin')

@section('title', 'Detail Guru — Shuka Highschool')
@section('heading', 'Detail guru')
@section('subheading', $guru->nama)

@section('content')
    <div class="soft-panel max-w-xl space-y-3 p-5 text-sm sm:p-6">
        <div class="flex justify-between border-b border-shuka-line pb-2"><span class="text-slate-500">NIP</span><span>{{ $guru->nip }}</span></div>
        <div class="flex justify-between border-b border-shuka-line pb-2"><span class="text-slate-500">Mapel</span><span>{{ $guru->mata_pelajaran }}</span></div>
        <div class="flex justify-between border-b border-shuka-line pb-2"><span class="text-slate-500">Telepon</span><span>{{ $guru->no_telepon }}</span></div>
        <div class="pt-3"><x-button variant="secondary" href="{{ route('admin.guru.edit', $guru) }}">Edit</x-button></div>
    </div>
@endsection
