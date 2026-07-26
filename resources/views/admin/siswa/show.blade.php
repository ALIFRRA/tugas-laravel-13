@extends('layouts.admin')

@section('title', 'Detail Siswa — Shuka Highschool')
@section('heading', 'Detail siswa')
@section('subheading', $siswa->nama)

@section('content')
    <div class="soft-panel max-w-xl space-y-3 p-5 text-sm sm:p-6">
        <div class="flex justify-between border-b border-shuka-line pb-2"><span class="text-slate-500">NIS</span><span>{{ $siswa->nis }}</span></div>
        <div class="flex justify-between border-b border-shuka-line pb-2"><span class="text-slate-500">Kelas</span><span>{{ $siswa->kelas }}</span></div>
        <div class="flex justify-between border-b border-shuka-line pb-2"><span class="text-slate-500">Jenis kelamin</span><span>{{ $siswa->jenis_kelamin }}</span></div>
        <div class="flex justify-between border-b border-shuka-line pb-2"><span class="text-slate-500">Tanggal lahir</span><span>{{ $siswa->tanggal_lahir?->format('d/m/Y') }}</span></div>
        <div><span class="text-slate-500">Alamat</span><p class="mt-1">{{ $siswa->alamat }}</p></div>
        <div class="pt-3"><x-button variant="secondary" href="{{ route('admin.siswa.edit', $siswa) }}">Edit</x-button></div>
    </div>
@endsection
