@extends('layouts.admin')

@section('title', 'Detail Data Guru — Shuka Highschool')
@section('heading', 'Detail Data Guru')
@section('subheading', $guru->nama)

@section('content')
    <div class="rounded-2xl border border-pink-100 bg-white p-6 shadow-sm max-w-xl space-y-4">
        <div class="flex items-center gap-4 pb-4 border-b border-slate-100">
            @if($guru->user)
                <x-avatar :user="$guru->user" size="md" />
            @else
                <div class="h-12 w-12 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold text-base">
                    {{ strtoupper(substr($guru->nama, 0, 2)) }}
                </div>
            @endif
            <div>
                <h3 class="font-extrabold text-slate-800 text-lg">{{ $guru->nama }}</h3>
                <p class="text-xs text-pink-600 font-semibold">{{ $guru->mata_pelajaran }}</p>
            </div>
        </div>

        <div class="space-y-3 text-sm">
            <div class="flex justify-between border-b border-slate-100 pb-2">
                <span class="text-slate-500">NIP</span>
                <span class="font-semibold text-slate-800">{{ $guru->nip }}</span>
            </div>
            <div class="flex justify-between border-b border-slate-100 pb-2">
                <span class="text-slate-500">Mata Pelajaran</span>
                <span class="font-semibold text-pink-600">{{ $guru->mata_pelajaran }}</span>
            </div>
            <div class="flex justify-between border-b border-slate-100 pb-2">
                <span class="text-slate-500">No. Telepon</span>
                <span class="font-semibold text-slate-800">{{ $guru->no_telepon }}</span>
            </div>
            <div class="flex justify-between border-b border-slate-100 pb-2">
                <span class="text-slate-500">Status Akun Login</span>
                @if($guru->user)
                    <span class="font-semibold text-emerald-600">Aktif ({{ $guru->user->email }})</span>
                @else
                    <span class="font-semibold text-slate-400">Belum Tertaut Akun</span>
                @endif
            </div>
        </div>

        <div class="flex gap-2 pt-3">
            <x-button class="bg-pink-500 hover:bg-pink-600 text-white font-semibold" href="{{ route('admin.guru.edit', $guru) }}">Edit Data Guru</x-button>
            <x-button variant="secondary" href="{{ route('admin.guru.index') }}">Kembali</x-button>
        </div>
    </div>
@endsection
