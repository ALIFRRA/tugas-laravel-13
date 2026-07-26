@extends('layouts.admin')

@section('title', 'Guru — Shuka Highschool')
@section('heading', 'Guru')
@section('subheading', 'Data tenaga pendidik.')

@section('content')
    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-slate-500">{{ $gurus->total() }} guru terdaftar</p>
        <x-button href="{{ route('admin.guru.create') }}">Tambah guru</x-button>
    </div>

    <x-table :headers="['NIP', 'Nama', 'Mapel', 'Telepon', 'Aksi']">
        @forelse ($gurus as $guru)
            <tr>
                <td class="px-4 py-3 whitespace-nowrap">{{ $guru->nip }}</td>
                <td class="px-4 py-3">{{ $guru->nama }}</td>
                <td class="px-4 py-3">{{ $guru->mata_pelajaran }}</td>
                <td class="px-4 py-3">{{ $guru->no_telepon }}</td>
                <td class="px-4 py-3">
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.guru.edit', $guru) }}" class="text-sm text-shuka-pink hover:underline">Edit</a>
                        <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" onsubmit="return confirm('Hapus data guru ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-rose-500 hover:underline">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-slate-400">Belum ada data guru.</td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">{{ $gurus->links() }}</div>
@endsection
