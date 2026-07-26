@php
    $layout = match (true) {
        Auth::user()->isGuru() => 'layouts.guru',
        Auth::user()->isMurid() => 'layouts.murid',
        default => 'layouts.admin',
    };
@endphp
@extends($layout)

@section('title', 'Profil — Shuka Highschool')
@section('heading', $isOwner ? 'Profil kamu' : 'Profil pengguna')
@section('subheading', $canEdit ? 'Ganti nama dan pilih avatar Bocchi. Pelan saja.' : 'Rincian akun dan data akademik.')

@section('content')
    @php
        $backUrl = match (true) {
            Auth::user()->isGuru() => route('guru.dashboard'),
            Auth::user()->isMurid() => route('murid.dashboard'),
            default => route('dashboard'),
        };
        $avatarLabels = [
            'bocchi' => 'Biasa',
            'bocchi-shy' => 'Shy',
            'bocchi-maid' => 'Maid',
        ];
    @endphp

    <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
        <section class="notebook-edge p-5 sm:p-6">
            <div class="flex flex-col items-start gap-4 sm:flex-row sm:items-center">
                <x-avatar :user="$user" size="lg" />
                <div>
                    <p class="font-display text-3xl text-shuka-pink">{{ $user->name }}</p>
                    <p class="mt-1 text-sm text-shuka-muted">{{ $user->email }}</p>
                    <p class="mt-2 inline-block border border-shuka-line bg-shuka-soft/50 px-2 py-0.5 text-xs uppercase tracking-wide text-slate-600">{{ $user->role }}</p>
                    <p class="mt-3 text-xs text-slate-400">ID profil: {{ $user->id }}</p>
                </div>
            </div>

            @if ($user->guru)
                <div class="mt-6 space-y-2 border-t border-shuka-line pt-4 text-sm">
                    <p><span class="text-shuka-muted">NIP:</span> <span class="font-medium text-slate-800">{{ $user->guru->nip }}</span></p>
                    <p><span class="text-shuka-muted">Mapel utama:</span> <span class="font-medium text-slate-800">{{ $user->guru->mata_pelajaran }}</span></p>
                    <p><span class="text-shuka-muted">Telepon:</span> <span class="font-medium text-slate-800">{{ $user->guru->no_telepon }}</span></p>
                    @if ($user->guru->mataPelajarans->isNotEmpty())
                        <p class="pt-1 text-shuka-muted">Mapel diampu:</p>
                        <ul class="list-inside list-disc text-slate-700">
                            @foreach ($user->guru->mataPelajarans as $mapel)
                                <li>{{ $mapel->nama }} ({{ $mapel->kode }})</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif

            @if ($user->siswa)
                <div class="mt-6 space-y-2 border-t border-shuka-line pt-4 text-sm">
                    <p><span class="text-shuka-muted">NIS:</span> <span class="font-medium text-slate-800">{{ $user->siswa->nis }}</span></p>
                    <p><span class="text-shuka-muted">Kelas:</span> <span class="font-medium text-slate-800">{{ $user->siswa->kelas }}</span></p>
                    <p><span class="text-shuka-muted">JK:</span> <span class="font-medium text-slate-800">{{ $user->siswa->jenis_kelamin }}</span></p>
                    <p><span class="text-shuka-muted">Alamat:</span> <span class="font-medium text-slate-800">{{ $user->siswa->alamat }}</span></p>
                    <p><span class="text-shuka-muted">Jumlah nilai:</span> <span class="font-medium text-slate-800">{{ $user->siswa->nilais->count() }}</span></p>
                </div>
            @endif

            <div class="mt-6 flex items-end gap-3 border-t border-shuka-line pt-4">
                <img src="{{ asset('images/bocchi-shy.png') }}" alt="Hitori Gotou" class="bocchi-mascot h-16 w-12 object-contain">
                <p class="pb-1 text-xs text-shuka-muted">{{ $canEdit ? 'Pilih Bocchi favoritmu — shy, biasa, atau maid.' : 'Profil pengguna sekolah.' }}</p>
            </div>
        </section>

        <section class="soft-panel p-5 sm:p-6">
            @if ($canEdit)
                <h2 class="font-display text-2xl text-slate-800">Edit profil</h2>
                <form method="POST" action="{{ route('profile.update.user', $user->id) }}" class="mt-5 space-y-5">
                    @csrf
                    @method('PUT')

                    <x-input name="name" label="Nama" :value="old('name', $user->name)" required />

                    <div>
                        <p class="mb-2 text-sm font-medium text-slate-700">Avatar Bocchi</p>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach ($avatarPresets as $key => $path)
                                @php $selected = old('avatar', $user->avatarKey()) === $key; @endphp
                                <label class="group cursor-pointer">
                                    <input type="radio" name="avatar" value="{{ $key }}" class="peer sr-only" @checked($selected) required>
                                    <span class="flex flex-col items-center gap-2 border border-shuka-line bg-shuka-soft/40 p-2 transition peer-checked:border-shuka-pink peer-checked:bg-shuka-soft peer-checked:ring-1 peer-checked:ring-shuka-pink group-hover:border-shuka-pink/60">
                                        <span class="flex h-24 w-full items-end justify-center overflow-hidden">
                                            <img src="{{ asset($path) }}" alt="{{ $avatarLabels[$key] ?? $key }}" class="bocchi-mascot h-24 w-auto object-contain object-bottom">
                                        </span>
                                        <span class="text-xs font-medium text-slate-600">{{ $avatarLabels[$key] ?? $key }}</span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('avatar')
                            <p class="mt-1.5 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap gap-3 pt-1">
                        <x-button>Simpan perubahan</x-button>
                        <x-button variant="secondary" href="{{ $backUrl }}" type="button">Kembali</x-button>
                    </div>
                </form>
            @else
                <h2 class="font-display text-2xl text-slate-800">Detail akademik</h2>
                @if ($user->siswa && $user->siswa->nilais->isNotEmpty())
                    <div class="mt-4">
                        <x-table :headers="['Mapel', 'Jenis', 'Nilai']">
                            @foreach ($user->siswa->nilais->take(10) as $nilai)
                                <tr>
                                    <td class="px-4 py-3">{{ $nilai->mapel?->nama ?? '—' }}</td>
                                    <td class="px-4 py-3">{{ $nilai->jenis_nilai }}</td>
                                    <td class="px-4 py-3 font-medium text-shuka-pink">{{ $nilai->nilai }}</td>
                                </tr>
                            @endforeach
                        </x-table>
                    </div>
                @elseif ($user->isGuru())
                    <p class="mt-4 text-sm text-shuka-muted">Akun guru dengan data mengajar di panel kiri.</p>
                @else
                    <p class="mt-4 text-sm text-shuka-muted">Belum ada data akademik tambahan.</p>
                @endif

                <div class="mt-6 flex flex-wrap gap-3">
                    @if ($user->isGuru())
                        <x-button variant="secondary" href="{{ route('admin.pengguna.guru') }}" type="button">Kembali ke daftar guru</x-button>
                    @elseif ($user->isMurid())
                        <x-button variant="secondary" href="{{ route('admin.pengguna.murid') }}" type="button">Kembali ke daftar murid</x-button>
                    @else
                        <x-button variant="secondary" href="{{ $backUrl }}" type="button">Kembali</x-button>
                    @endif
                </div>
            @endif
        </section>
    </div>
@endsection
