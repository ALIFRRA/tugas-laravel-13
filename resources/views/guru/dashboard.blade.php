@extends('layouts.guru')

@section('title', 'Dashboard Guru — Shuka Highschool')
@section('heading', 'Halo, '.$guru->nama)
@section('subheading', 'Kelola kelas dan nilai murid di mapelmu.')

@section('content')
    <div class="mb-6 grid gap-4 sm:grid-cols-3">
        <div class="soft-panel p-4">
            <p class="text-sm text-shuka-muted">Mapel diampu</p>
            <p class="font-display text-3xl text-shuka-pink">{{ $mapelCount }}</p>
        </div>
        <div class="soft-panel p-4">
            <p class="text-sm text-shuka-muted">Nilai tercatat</p>
            <p class="font-display text-3xl text-shuka-pink">{{ $nilaiCount }}</p>
        </div>
        <div class="soft-panel p-4">
            <p class="text-sm text-shuka-muted">Rata-rata nilai</p>
            <p class="font-display text-3xl text-shuka-pink">{{ $rataRata ?: '—' }}</p>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <section class="soft-panel p-5 sm:p-6">
            <div class="flex items-center justify-between gap-3">
                <h2 class="font-display text-2xl text-slate-700">mapel & kelas</h2>
                <a href="{{ route('guru.nilai.index') }}" class="text-sm text-shuka-pink hover:underline">Kelola nilai</a>
            </div>
            <ul class="mt-4 divide-y divide-shuka-line">
                @forelse ($mapels as $mapel)
                    <li class="flex items-center justify-between gap-3 py-3">
                        <div>
                            <p class="font-medium text-slate-800">{{ $mapel->nama }}</p>
                            <p class="text-sm text-shuka-muted">{{ $mapel->kode }} · {{ $mapel->nilais_count }} nilai</p>
                        </div>
                    </li>
                @empty
                    <li class="py-6 text-sm text-slate-400">Belum ada mapel terhubung.</li>
                @endforelse
            </ul>
            @if ($kelasList->isNotEmpty())
                <p class="mt-4 text-sm text-shuka-muted">Kelas terkait jadwal:</p>
                <p class="mt-1 text-sm font-medium text-slate-700">{{ $kelasList->implode(', ') }}</p>
            @endif
        </section>

        <section class="soft-panel p-5 sm:p-6">
            <h2 class="font-display text-2xl text-slate-700">nilai terbaru</h2>
            <ul class="mt-4 divide-y divide-shuka-line">
                @forelse ($nilaiTerbaru as $nilai)
                    <li class="flex items-center justify-between gap-3 py-3">
                        <div>
                            <p class="font-medium text-slate-800">{{ $nilai->siswa->nama }}</p>
                            <p class="text-sm text-shuka-muted">{{ $nilai->mapel->nama }} · {{ $nilai->jenis_nilai }}</p>
                        </div>
                        <p class="font-medium text-shuka-pink">{{ $nilai->nilai }}</p>
                    </li>
                @empty
                    <li class="py-6 text-sm text-slate-400">Belum ada nilai. Mulai input dari menu Nilai.</li>
                @endforelse
            </ul>
        </section>
    </div>
@endsection
