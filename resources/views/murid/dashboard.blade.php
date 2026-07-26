@extends('layouts.murid')

@section('title', 'Dashboard Murid — Shuka Highschool')
@section('heading', 'Halo, '.$user->name)
@section('subheading', 'Ringkasan profil dan progres belajarmu.')

@section('content')
    @unless ($siswa)
        <section class="notebook-edge p-5 sm:p-6">
            <p class="font-display text-2xl text-shuka-pink">Profil akademik belum dihubungkan</p>
            <p class="mt-2 text-sm text-shuka-muted">Akunmu sudah aktif, tapi data siswa (NIS/kelas) belum ditautkan Admin. Kamu tetap bisa mengedit profil.</p>
            <div class="mt-4">
                <x-button href="{{ route('profile.show', $user->id) }}">Edit profil</x-button>
            </div>
        </section>
    @else
        <div class="mb-6 notebook-edge flex flex-col gap-4 p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5">
            <div class="flex items-center gap-3">
                <x-avatar :user="$user" size="md" />
                <div>
                    <p class="font-medium text-slate-800">{{ $siswa->nama }}</p>
                    <p class="text-sm text-shuka-muted">NIS {{ $siswa->nis }} · Kelas {{ $siswa->kelas }}</p>
                </div>
            </div>
            <a href="{{ route('profile.show', $user->id) }}" class="text-sm text-shuka-pink hover:underline">Edit profil →</a>
        </div>

        <div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="soft-panel p-4">
                <p class="text-sm text-shuka-muted">Rata-rata</p>
                <p class="font-display text-3xl text-shuka-pink">{{ $rataRata !== null ? number_format($rataRata, 1) : '—' }}</p>
            </div>
            <div class="soft-panel p-4">
                <p class="text-sm text-shuka-muted">Tertinggi</p>
                <p class="font-display text-3xl text-shuka-pink">{{ $tertinggi ?? '—' }}</p>
            </div>
            <div class="soft-panel p-4">
                <p class="text-sm text-shuka-muted">Terendah</p>
                <p class="font-display text-3xl text-shuka-pink">{{ $terendah ?? '—' }}</p>
            </div>
            <div class="soft-panel p-4">
                <p class="text-sm text-shuka-muted">Mapel dinilai</p>
                <p class="font-display text-3xl text-shuka-pink">{{ $mapelCount }}</p>
            </div>
        </div>

        <section class="soft-panel p-5 sm:p-6">
            <h2 class="font-display text-2xl text-slate-700">daftar nilai</h2>
            <div class="mt-4">
                <x-table :headers="['Mapel', 'Jenis', 'Nilai']">
                    @forelse ($nilais as $nilai)
                        <tr>
                            <td class="px-4 py-3">{{ $nilai->mapel?->nama ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $nilai->jenis_nilai }}</td>
                            <td class="px-4 py-3 font-medium text-shuka-pink">{{ $nilai->nilai }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-slate-400">Belum ada nilai tercatat.</td>
                        </tr>
                    @endforelse
                </x-table>
            </div>
        </section>
    @endunless
@endsection
