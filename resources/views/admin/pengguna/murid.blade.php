@extends('layouts.admin')

@section('title', 'Pengguna Murid — Shuka Highschool')
@section('heading', 'Pengguna Murid')
@section('subheading', 'Akun murid yang terdaftar di sistem.')

@section('content')
    <div class="mb-5 flex flex-wrap gap-2 border-b border-shuka-line pb-3">
        <a href="{{ route('admin.pengguna.guru') }}" class="border border-shuka-line px-3 py-1.5 text-sm text-slate-600 hover:border-shuka-pink hover:text-shuka-pink">Guru</a>
        <a href="{{ route('admin.pengguna.murid') }}" class="border border-shuka-pink bg-shuka-soft px-3 py-1.5 text-sm text-shuka-pink">Murid</a>
    </div>

    <p class="mb-4 text-sm text-slate-500">{{ $users->total() }} akun murid</p>

    <x-table :headers="['Avatar', 'Nama', 'Email', 'NIS', 'Kelas', 'Nilai', 'Aksi']">
        @forelse ($users as $user)
            <tr>
                <td class="px-4 py-3"><x-avatar :user="$user" size="sm" /></td>
                <td class="px-4 py-3 font-medium text-slate-800">{{ $user->name }}</td>
                <td class="px-4 py-3 text-sm text-slate-600">{{ $user->email }}</td>
                <td class="px-4 py-3">{{ $user->siswa?->nis ?? '—' }}</td>
                <td class="px-4 py-3">{{ $user->siswa?->kelas ?? '—' }}</td>
                <td class="px-4 py-3">{{ $user->siswa?->nilais?->count() ?? 0 }}</td>
                <td class="px-4 py-3">
                    <a href="{{ route('profile.show', $user->id) }}" class="text-sm text-shuka-pink hover:underline">Lihat profil</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-4 py-8 text-center text-slate-400">Belum ada akun murid.</td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">{{ $users->links() }}</div>
@endsection
