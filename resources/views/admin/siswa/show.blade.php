@extends('layouts.admin')

@section('title', 'Detail Data Murid — Shuka Highschool')
@section('heading', 'Detail Data Murid')
@section('subheading', $siswa->nama)

@section('content')
    <div class="rounded-2xl border border-pink-100 bg-white p-6 shadow-sm max-w-xl space-y-4">
        <div class="flex items-center gap-4 pb-4 border-b border-slate-100">
            @if($siswa->user)
                <x-avatar :user="$siswa->user" size="md" />
            @else
                <div class="h-12 w-12 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center font-bold text-base">
                    {{ strtoupper(substr($siswa->nama, 0, 2)) }}
                </div>
            @endif
            <div>
                <h3 class="font-extrabold text-slate-800 text-lg">{{ $siswa->nama }}</h3>
                <p class="text-xs text-pink-600 font-semibold">Kelas {{ $siswa->kelas }}</p>
            </div>
        </div>

        <div class="space-y-3 text-sm">
            <div class="flex justify-between border-b border-slate-100 pb-2">
                <span class="text-slate-500">NIS</span>
                <span class="font-semibold text-slate-800">{{ $siswa->nis }}</span>
            </div>
            <div class="flex justify-between border-b border-slate-100 pb-2">
                <span class="text-slate-500">Jenis Kelamin</span>
                <span class="font-semibold text-slate-800">{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
            </div>
            <div class="flex justify-between border-b border-slate-100 pb-2">
                <span class="text-slate-500">Tanggal Lahir</span>
                <span class="font-semibold text-slate-800">{{ $siswa->tanggal_lahir?->format('d F Y') ?? '—' }}</span>
            </div>
            <div class="border-b border-slate-100 pb-2">
                <span class="text-slate-500 block mb-1">Alamat Tempat Tinggal</span>
                <p class="text-slate-700 font-medium bg-slate-50 p-2.5 rounded-lg border border-slate-100">{{ $siswa->alamat }}</p>
            </div>
            <div class="flex justify-between border-b border-slate-100 pb-2">
                <span class="text-slate-500">Status Akun Login</span>
                @if($siswa->user)
                    <span class="font-semibold text-emerald-600">Aktif ({{ $siswa->user->email }})</span>
                @else
                    <span class="font-semibold text-slate-400">Belum Tertaut Akun</span>
                @endif
            </div>
        </div>

        <div class="flex gap-2 pt-3">
            <x-button class="bg-pink-500 hover:bg-pink-600 text-white font-semibold" href="{{ route('admin.siswa.edit', $siswa) }}">Edit Data Murid</x-button>
            <x-button variant="secondary" href="{{ route('admin.siswa.index') }}">Kembali</x-button>
        </div>
    </div>
@endsection
