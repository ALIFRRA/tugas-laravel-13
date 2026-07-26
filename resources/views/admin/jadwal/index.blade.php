@extends('layouts.admin')

@section('title', 'Jadwal — Shuka Highschool')
@section('heading', 'Jadwal')
@section('subheading', 'Jadwal pelajaran mingguan.')

@section('content')
    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-slate-500">{{ $jadwals->total() }} entri jadwal</p>
        <x-button href="{{ route('admin.jadwal.create') }}">Tambah jadwal</x-button>
    </div>

    <x-table :headers="['Hari', 'Kelas', 'Mapel', 'Jam', 'Aksi']">
        @forelse ($jadwals as $jadwal)
            <tr>
                <td class="px-4 py-3">{{ $jadwal->hari }}</td>
                <td class="px-4 py-3">{{ $jadwal->kelas }}</td>
                <td class="px-4 py-3">{{ $jadwal->mapel->nama }}</td>
                <td class="px-4 py-3 whitespace-nowrap">{{ substr($jadwal->jam_mulai, 0, 5) }} – {{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                <td class="px-4 py-3">
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.jadwal.edit', $jadwal) }}" class="text-sm text-shuka-pink hover:underline">Edit</a>
                        <form action="{{ route('admin.jadwal.destroy', $jadwal) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-rose-500 hover:underline">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-slate-400">Belum ada jadwal.</td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">{{ $jadwals->links() }}</div>
@endsection
