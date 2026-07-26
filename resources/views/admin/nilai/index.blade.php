@extends('layouts.admin')

@section('title', 'Nilai — Shuka Highschool')
@section('heading', 'Nilai')
@section('subheading', 'Rekap nilai siswa. Urutkan sesuai kebutuhan.')

@section('content')
    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-slate-500">{{ $nilais->total() }} catatan nilai</p>
        <div class="flex flex-wrap items-center gap-3">
            <form method="GET" action="{{ route('admin.nilai.index') }}" class="flex items-center gap-2">
                <label for="sort" class="text-sm text-slate-600">Urutkan</label>
                <select id="sort" name="sort" class="border-shuka-line text-sm focus:border-shuka-pink focus:ring-shuka-pink" onchange="this.form.submit()">
                    <option value="">Terbaru</option>
                    @foreach ($sortOptions as $value => $label)
                        <option value="{{ $value }}" @selected($sort === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </form>
            <x-button href="{{ route('admin.nilai.create') }}">Tambah nilai</x-button>
        </div>
    </div>

    <x-table :headers="['Siswa', 'Mapel', 'Jenis', 'Nilai', 'Aksi']">
        @forelse ($nilais as $nilai)
            <tr>
                <td class="px-4 py-3">{{ $nilai->siswa->nama }}</td>
                <td class="px-4 py-3">{{ $nilai->mapel->nama }}</td>
                <td class="px-4 py-3">{{ $nilai->jenis_nilai }}</td>
                <td class="px-4 py-3 font-medium text-shuka-pink">{{ $nilai->nilai }}</td>
                <td class="px-4 py-3">
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.nilai.edit', $nilai) }}" class="text-sm text-shuka-pink hover:underline">Edit</a>
                        <form action="{{ route('admin.nilai.destroy', $nilai) }}" method="POST" onsubmit="return confirm('Hapus nilai ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-rose-500 hover:underline">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-slate-400">Belum ada nilai.</td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">{{ $nilais->links() }}</div>
@endsection
