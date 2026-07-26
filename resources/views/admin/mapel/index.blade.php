@extends('layouts.admin')

@section('title', 'Mapel — Shuka Highschool')
@section('heading', 'Mata pelajaran')
@section('subheading', 'Daftar mapel dan pengampu.')

@section('content')
    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-slate-500">{{ $mapels->total() }} mapel</p>
        <x-button href="{{ route('admin.mapel.create') }}">Tambah mapel</x-button>
    </div>

    <x-table :headers="['Kode', 'Nama', 'Guru', 'Aksi']">
        @forelse ($mapels as $mapel)
            <tr>
                <td class="px-4 py-3 whitespace-nowrap">{{ $mapel->kode }}</td>
                <td class="px-4 py-3">{{ $mapel->nama }}</td>
                <td class="px-4 py-3">{{ $mapel->guru->nama }}</td>
                <td class="px-4 py-3">
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.mapel.edit', $mapel) }}" class="text-sm text-shuka-pink hover:underline">Edit</a>
                        <form action="{{ route('admin.mapel.destroy', $mapel) }}" method="POST" onsubmit="return confirm('Hapus mapel ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-rose-500 hover:underline">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="px-4 py-8 text-center text-slate-400">Belum ada mapel.</td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">{{ $mapels->links() }}</div>
@endsection
