@extends('layouts.admin')

@section('title', 'Dashboard — Shuka Highschool')
@section('heading', 'Halo, '.Auth::user()->name)
@section('subheading', 'Catatan kecil untuk hari ini.')

@section('content')
    <div class="mb-6 notebook-edge flex flex-col gap-4 p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5">
        <div class="flex items-center gap-3">
            <x-avatar :user="Auth::user()" size="md" />
            <div>
                <p class="text-sm text-shuka-muted">Sedang login sebagai</p>
                <p class="font-medium text-slate-800">{{ Auth::user()->name }}</p>
            </div>
        </div>
        <a href="{{ route('profile.show', Auth::id()) }}" class="text-sm text-shuka-pink hover:underline">Edit profil →</a>
    </div>

    <div class="mb-6 flex flex-wrap gap-3">
        <x-button variant="secondary" href="{{ route('admin.pengguna.guru') }}">Lihat pengguna guru</x-button>
        <x-button variant="secondary" href="{{ route('admin.pengguna.murid') }}">Lihat pengguna murid</x-button>
    </div>

    <div class="grid gap-6 lg:grid-cols-[1fr_1.15fr]">
        <section class="soft-panel p-5 sm:p-6">
            <h2 class="font-display text-2xl text-slate-700">ringkasan</h2>
            <dl class="mt-5 space-y-4">
                <div class="flex items-baseline justify-between guitar-rule pb-3">
                    <dt class="text-sm text-shuka-muted">Akun guru & murid</dt>
                    <dd class="font-display text-3xl text-shuka-pink">{{ $userCount }}</dd>
                </div>
                <div class="flex items-baseline justify-between guitar-rule pb-3">
                    <dt class="text-sm text-shuka-muted">Siswa</dt>
                    <dd class="font-display text-3xl text-shuka-pink">{{ $siswaCount }}</dd>
                </div>
                <div class="flex items-baseline justify-between guitar-rule pb-3">
                    <dt class="text-sm text-shuka-muted">Guru</dt>
                    <dd class="font-display text-3xl text-shuka-pink">{{ $guruCount }}</dd>
                </div>
                <div class="flex items-baseline justify-between guitar-rule pb-3">
                    <dt class="text-sm text-shuka-muted">Mapel</dt>
                    <dd class="font-display text-3xl text-shuka-pink">{{ $mapelCount }}</dd>
                </div>
                <div class="flex items-baseline justify-between">
                    <dt class="text-sm text-shuka-muted">Nilai tercatat</dt>
                    <dd class="font-display text-3xl text-shuka-pink">{{ $nilaiCount }}</dd>
                </div>
            </dl>
        </section>

        <section class="soft-panel p-5 sm:p-6">
            <div class="flex items-center justify-between gap-3">
                <h2 class="font-display text-2xl text-slate-700">jadwal hari ini</h2>
                <a href="{{ route('admin.jadwal.index') }}" class="text-sm text-shuka-pink hover:underline">Semua</a>
            </div>
            <ul class="mt-4 divide-y divide-shuka-line">
                @forelse ($jadwalHariIni as $jadwal)
                    <li class="flex flex-col gap-1 py-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-medium text-slate-800">{{ $jadwal->mapel->nama }}</p>
                            <p class="text-sm text-shuka-muted">Kelas {{ $jadwal->kelas }}</p>
                        </div>
                        <p class="text-sm text-slate-600">{{ substr($jadwal->jam_mulai, 0, 5) }} – {{ substr($jadwal->jam_selesai, 0, 5) }}</p>
                    </li>
                @empty
                    <li class="py-8 text-sm text-slate-400">Tidak ada jadwal untuk hari ini. Santai dulu.</li>
                @endforelse
            </ul>
        </section>
    </div>

    <section class="mt-6 soft-panel p-5 sm:p-6">
        <div class="flex items-center justify-between gap-3">
            <h2 class="font-display text-2xl text-slate-700">nilai terbaru</h2>
            <a href="{{ route('admin.nilai.index') }}" class="text-sm text-shuka-pink hover:underline">Kelola</a>
        </div>
        <div class="mt-4">
            <x-table :headers="['Siswa', 'Mapel', 'Jenis', 'Nilai']">
                @forelse ($nilaiTerbaru as $nilai)
                    <tr>
                        <td class="px-4 py-3">{{ $nilai->siswa->nama }}</td>
                        <td class="px-4 py-3">{{ $nilai->mapel->nama }}</td>
                        <td class="px-4 py-3">{{ $nilai->jenis_nilai }}</td>
                        <td class="px-4 py-3 font-medium text-shuka-pink">{{ $nilai->nilai }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-slate-400">Belum ada nilai.</td>
                    </tr>
                @endforelse
            </x-table>
        </div>
    </section>
@endsection
