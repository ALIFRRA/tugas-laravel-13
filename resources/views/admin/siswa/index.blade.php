@extends('layouts.admin')

@section('title', 'Siswa — Shuka Highschool')
@section('heading', 'Siswa')
@section('subheading', 'Data peserta didik.')

@section('content')
    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-slate-500">{{ $siswas->total() }} siswa terdaftar</p>
        <x-button href="{{ route('admin.siswa.create') }}">Tambah siswa</x-button>
    </div>

    <x-table :headers="['NIS', 'Nama', 'Kelas', 'JK', 'Aksi']">
        @forelse ($siswas as $siswa)
            <tr>
                <td class="px-4 py-3 whitespace-nowrap">{{ $siswa->nis }}</td>
                <td class="px-4 py-3">{{ $siswa->nama }}</td>
                <td class="px-4 py-3">{{ $siswa->kelas }}</td>
                <td class="px-4 py-3">{{ $siswa->jenis_kelamin }}</td>
                <td class="px-4 py-3">
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.siswa.edit', $siswa) }}" class="text-sm text-shuka-pink hover:underline">Edit</a>
                        <form action="{{ route('admin.siswa.destroy', $siswa) }}" method="POST" onsubmit="return confirm('Hapus data siswa ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-rose-500 hover:underline">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-slate-400">Belum ada data siswa.</td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">{{ $siswas->links() }}</div>
@endsection
