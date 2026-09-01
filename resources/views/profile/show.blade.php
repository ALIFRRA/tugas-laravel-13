<?php
@php
    $layout = match (true) {
        Auth::user()->isGuru() => 'layouts.guru',
        Auth::user()->isMurid() => 'layouts.murid',
        default => 'layouts.admin',
    };
@endphp
@extends($layout)

@section('title', 'Profil Pengguna — Shuka Highschool')
@section('heading', $isOwner ? 'Profil Akun Saya' : 'Profil Pengguna')

@section('content')
    @php
        $backUrl = match (true) {
            Auth::user()->isGuru() => route('guru.dashboard'),
            Auth::user()->isMurid() => route('murid.dashboard'),
            default => route('dashboard'),
        };
        $avatarLabels = [
            'bocchi' => 'Bocchi Casual',
            'bocchi-shy' => 'Bocchi Shy',
            'bocchi-maid' => 'Bocchi Maid',
        ];
    @endphp

    <div class="grid gap-6 lg:grid-cols-12">
        <!-- Panel Kiri: Informasi Akun (5 Cols) -->
        <section class="lg:col-span-5 bg-white border border-slate-200 rounded-lg p-5 sm:p-6 shadow-sm space-y-6">
            <div class="flex flex-col items-center text-center pb-4 border-b border-slate-200">
                <div class="relative w-24 h-24 rounded-full overflow-hidden border-2 border-pink-500 bg-pink-50 shadow-sm mb-3">
                    <img
                        id="current-avatar-preview"
                        src="{{ $user->avatarUrl() }}"
                        alt="{{ $user->name }}"
                        class="w-full h-full object-cover"
                    >
                </div>
                <h2 class="text-lg font-bold text-slate-900 leading-tight">{{ $user->name }}</h2>
                <p class="text-xs text-slate-500 mt-0.5">{{ $user->email }}</p>
                <div class="mt-2">
                    <span class="inline-block px-2.5 py-0.5 rounded text-xs font-semibold {{ $user->isAdmin() ? 'bg-pink-100 text-pink-700 border border-pink-300' : ($user->isGuru() ? 'bg-slate-100 text-slate-700 border border-slate-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200') }}">
                        Peran: {{ strtoupper($user->role) }}
                    </span>
                </div>
            </div>

            @if ($user->guru)
                <div class="space-y-2 text-xs border-b border-slate-200 pb-4">
                    <h3 class="font-bold text-slate-900 uppercase tracking-wider text-[11px] mb-2 text-pink-600">Data Tenaga Pengajar</h3>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">NIP:</span>
                        <span class="font-mono font-semibold text-slate-800">{{ $user->guru->nip }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Mapel Utama:</span>
                        <span class="font-semibold text-slate-800 text-right">{{ $user->guru->mataPelajarans->pluck('nama')->implode(', ') ?: '—' }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-slate-500">No. Telepon:</span>
                        <span class="font-mono text-slate-800">{{ $user->guru->no_telepon }}</span>
                    </div>
                </div>
            @endif

            @if ($user->siswa)
                <div class="space-y-2 text-xs border-b border-slate-200 pb-4">
                    <h3 class="font-bold text-slate-900 uppercase tracking-wider text-[11px] mb-2 text-pink-600">Data Akademik Siswa</h3>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">NIS Siswa:</span>
                        <span class="font-mono font-semibold text-slate-800">{{ $user->siswa->nis }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Kelas / Jurusan:</span>
                        <span class="font-semibold text-slate-800">{{ $user->siswa->kelas }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Jenis Kelamin:</span>
                        <span class="font-semibold text-slate-800">{{ $user->siswa->jenis_kelamin === 'P' ? 'Perempuan' : 'Laki-laki' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Domisili:</span>
                        <span class="text-slate-800">{{ $user->siswa->alamat }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-slate-500">Total Penilaian:</span>
                        <span class="font-bold text-pink-600">{{ $user->siswa->nilais->count() }} Record</span>
                    </div>
                </div>
            @endif

            <div class="text-xs text-slate-500">
                <span class="font-semibold text-slate-700">Status Akun:</span> Terverifikasi • SIA SMK Shuka T.A. 2026/2027
            </div>
        </section>

        <!-- Panel Kanan: Form Edit Profil & Unggah Foto (7 Cols) -->
        <section class="lg:col-span-7 bg-white border border-slate-200 rounded-lg p-5 sm:p-6 shadow-sm">
            @if ($canEdit)
                <div class="border-b border-slate-200 pb-3 mb-5">
                    <h2 class="text-base font-bold text-slate-900">Pengaturan Profil & Foto Akun</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Ubah nama pengguna, pilih avatar karakter, atau unggah foto profil kustom.</p>
                </div>

                <form method="POST" action="{{ route('profile.update.user', $user->id) }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <!-- Input Nama -->
                    <div>
                        <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            required
                            class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3 text-slate-900"
                        >
                        @error('name')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Foto Profil Kustom -->
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-lg space-y-3">
                        <label class="block text-xs font-bold text-slate-800">
                            Unggah Foto Profil Kustom (Bebas Foto Sendiri)
                        </label>
                        <p class="text-[11px] text-slate-500">
                            Unggah foto dari perangkat Anda (format: JPG, PNG, WEBP, maks 2MB). Foto yang diunggah akan otomatis menggantikan avatar preset.
                        </p>

                        <div class="flex items-center gap-3">
                            <input
                                type="file"
                                name="avatar_file"
                                id="avatar_file_input"
                                accept="image/jpeg,image/png,image/webp,image/gif"
                                class="text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100"
                                onchange="previewUploadImage(this)"
                            >
                        </div>
                        @error('avatar_file')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pilihan Avatar Preset Bocchi the Rock! -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Atau Pilih Avatar Preset Karakter:</label>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach ($avatarPresets as $key => $path)
                                @php $selected = old('avatar', $user->avatarKey()) === $key; @endphp
                                <label class="cursor-pointer">
                                    <input
                                        type="radio"
                                        name="avatar"
                                        value="{{ $key }}"
                                        class="peer sr-only"
                                        @checked($selected)
                                        onchange="previewPresetImage('{{ filter_var($path, FILTER_VALIDATE_URL) ? $path : asset($path) }}')"
                                    >
                                    <div class="flex flex-col items-center gap-2 border border-slate-200 bg-slate-50 rounded-lg p-2.5 transition peer-checked:border-pink-500 peer-checked:bg-pink-50 peer-checked:ring-2 peer-checked:ring-pink-500 hover:border-pink-300">
                                        <div class="h-20 w-full flex items-center justify-center overflow-hidden">
                                            <img src="{{ filter_var($path, FILTER_VALIDATE_URL) ? $path : asset($path) }}" alt="{{ $avatarLabels[$key] ?? $key }}" class="h-20 w-auto object-contain">
                                        </div>
                                        <span class="text-[11px] font-semibold text-slate-700">{{ $avatarLabels[$key] ?? $key }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('avatar')
                            <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex items-center gap-3 pt-2 border-t border-slate-200">
                        <button type="submit" class="px-5 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold text-xs rounded transition-colors shadow-sm">
                            Simpan Perubahan Profil
                        </button>
                        <a href="{{ $backUrl }}" class="px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs rounded border border-slate-300 transition-colors">
                            Kembali
                        </a>
                    </div>
                </form>

                <script>
                    function previewUploadImage(input) {
                        if (input.files && input.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                document.getElementById('current-avatar-preview').src = e.target.result;
                            };
                            reader.readAsDataURL(input.files[0]);
                        }
                    }

                    function previewPresetImage(url) {
                        document.getElementById('current-avatar-preview').src = url;
                    }
                </script>
            @else
                <div class="border-b border-slate-200 pb-3 mb-4">
                    <h2 class="text-base font-bold text-slate-900">Rincian Akademik</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Informasi akun pengguna.</p>
                </div>

                @if ($user->siswa && $user->siswa->nilais->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase">
                                    <th class="py-2.5 px-3">Mata Pelajaran</th>
                                    <th class="py-2.5 px-3">Evaluasi</th>
                                    <th class="py-2.5 px-3 text-right">Nilai Angka</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($user->siswa->nilais->take(10) as $nilai)
                                    <tr>
                                        <td class="py-2.5 px-3 font-medium text-slate-900">{{ $nilai->mapel?->nama ?? '—' }}</td>
                                        <td class="py-2.5 px-3 text-slate-600">{{ $nilai->jenis_nilai }}</td>
                                        <td class="py-2.5 px-3 text-right font-mono font-bold text-pink-600">{{ $nilai->nilai }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-xs text-slate-500 py-6 text-center">Tidak ada catatan nilai tambahan.</p>
                @endif

                <div class="mt-6 pt-4 border-t border-slate-200">
                    <a href="{{ $backUrl }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded border border-slate-300 inline-block">
                        Kembali
                    </a>
                </div>
            @endif
        </section>
    </div>
@endsection
