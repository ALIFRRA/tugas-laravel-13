@extends('layouts.admin')

@section('title', 'Detail Jadwal — Shuka Highschool')
@section('heading', 'Detail jadwal')
@section('subheading', $jadwal->hari)

@section('content')
    <div class="soft-panel max-w-xl space-y-3 p-5 text-sm sm:p-6">
        <div class="flex justify-between border-b border-shuka-line pb-2"><span class="text-slate-500">Mapel</span><span>{{ $jadwal->mapel->nama }}</span></div>
        <div class="flex justify-between border-b border-shuka-line pb-2"><span class="text-slate-500">Kelas</span><span>{{ $jadwal->kelas }}</span></div>
        <div class="flex justify-between border-b border-shuka-line pb-2"><span class="text-slate-500">Jam</span><span>{{ substr($jadwal->jam_mulai, 0, 5) }} – {{ substr($jadwal->jam_selesai, 0, 5) }}</span></div>
        <div class="pt-3"><x-button variant="secondary" href="{{ route('admin.jadwal.edit', $jadwal) }}">Edit</x-button></div>
    </div>
@endsection
