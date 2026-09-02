@extends('layouts.admin')

@section('title', 'Dashboard — SMK Shuka')
@section('heading', 'Dashboard Utama')

@section('content')
<div class="space-y-6" x-data="{ activeDirectoryTab: 'guru' }">

    <!-- header dasbor dan aksi cepat -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">Dasbor Akademik</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Sistem Informasi Akademik & Portal Terpadu SMK Shuka (秀華高等専門学校).</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.guru.index') }}" class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded hover:bg-slate-50 flex items-center gap-1.5 transition-colors shadow-2xs">
                <span>Daftar Guru</span>
            </a>
            <a href="{{ route('admin.siswa.index') }}" class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded hover:bg-slate-50 flex items-center gap-1.5 transition-colors shadow-2xs">
                <span>Daftar Siswa</span>
            </a>
            <a href="{{ route('admin.siswa.create') }}" class="px-3.5 py-1.5 text-xs font-semibold text-white bg-pink-500 hover:bg-pink-600 rounded flex items-center gap-1.5 transition-colors shadow-2xs">
                <span>+ Tambah Siswa</span>
            </a>
        </div>
    </div>

    <!-- grid metrik ringkasan -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        <!-- guru -->
        <div class="bg-white p-4 border border-slate-200 rounded-lg shadow-2xs">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Tenaga Guru</span>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $guruCount ?? 45 }}</p>
            <span class="text-[11px] text-pink-600 font-medium mt-0.5 block">Pendidik Aktif</span>
        </div>

        <!-- siswa -->
        <div class="bg-white p-4 border border-slate-200 rounded-lg shadow-2xs">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Peserta Didik</span>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($siswaCount ?? 600) }}</p>
            <span class="text-[11px] text-slate-500 font-medium mt-0.5 block">18 Rombel Kelas</span>
        </div>

        <!-- mata pelajaran -->
        <div class="bg-white p-4 border border-slate-200 rounded-lg shadow-2xs">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Mata Pelajaran</span>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $mapelCount ?? 28 }}</p>
            <span class="text-[11px] text-slate-500 font-medium mt-0.5 block">{{ $programCount ?? 5 }} Program Kejuruan</span>
        </div>

        <!-- agenda -->
        <div class="bg-white p-4 border border-slate-200 rounded-lg shadow-2xs">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Agenda Sekolah</span>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $agendaCount ?? 0 }}</p>
            <span class="text-[11px] text-slate-500 font-medium mt-0.5 block">Kalender Kegiatan</span>
        </div>

        <!-- pengumuman -->
        <div class="bg-white p-4 border border-slate-200 rounded-lg shadow-2xs">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Pengumuman</span>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $pengumumanCount ?? 0 }}</p>
            <span class="text-[11px] text-slate-500 font-medium mt-0.5 block">Informasi Terbit</span>
        </div>

        <!-- kedisiplinan dan bk -->
        <div class="bg-white p-4 border border-slate-200 rounded-lg shadow-2xs">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider block">Kedisiplinan</span>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $pelanggaranCount ?? 0 }}</p>
            <span class="text-[11px] text-slate-500 font-medium mt-0.5 block">Catatan Sanksi BK</span>
        </div>
    </div>

    <!-- direktori akun dan kolom jadwal/agenda -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- panel direktori guru dan siswa -->
        <div class="lg:col-span-8 space-y-4">
            <div class="bg-white border border-slate-200 rounded-lg shadow-2xs overflow-hidden">

                <!-- tab header navigasi akun -->
                <div class="p-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-slate-50/50">
                    <div class="flex items-center gap-1.5 p-1 bg-slate-200/70 rounded-lg">
                        <button
                            type="button"
                            @click="activeDirectoryTab = 'guru'"
                            :class="activeDirectoryTab === 'guru' ? 'bg-white text-slate-900 font-bold shadow-2xs' : 'text-slate-600 font-medium hover:text-slate-900'"
                            class="px-3 py-1.5 text-xs rounded-md transition-all"
                        >
                            Tenaga Guru ({{ $guruCount }})
                        </button>
                        <button
                            type="button"
                            @click="activeDirectoryTab = 'siswa'"
                            :class="activeDirectoryTab === 'siswa' ? 'bg-white text-slate-900 font-bold shadow-2xs' : 'text-slate-600 font-medium hover:text-slate-900'"
                            class="px-3 py-1.5 text-xs rounded-md transition-all"
                        >
                            Peserta Didik ({{ number_format($siswaCount) }})
                        </button>
                    </div>

                    <div>
                        <a
                            x-show="activeDirectoryTab === 'guru'"
                            href="{{ route('admin.guru.index') }}"
                            class="text-xs text-pink-600 font-semibold hover:underline"
                        >
                            Buka Modul Guru →
                        </a>
                        <a
                            x-show="activeDirectoryTab === 'siswa'"
                            href="{{ route('admin.siswa.index') }}"
                            class="text-xs text-pink-600 font-semibold hover:underline"
                            style="display: none;"
                        >
                            Buka Modul Siswa →
                        </a>
                    </div>
                </div>

                <!-- tab daftar tenaga guru -->
                <div x-show="activeDirectoryTab === 'guru'" class="overflow-x-auto max-h-[520px] overflow-y-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase tracking-wider sticky top-0 z-10">
                                <th class="py-2.5 px-4 border-r border-slate-200">Nama Tenaga Guru</th>
                                <th class="py-2.5 px-4 border-r border-slate-200">NIP</th>
                                <th class="py-2.5 px-4 border-r border-slate-200">Mata Pelajaran</th>
                                <th class="py-2.5 px-4 border-r border-slate-200">Kontak Telepon</th>
                                <th class="py-2.5 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($guruTerbaru as $g)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-2.5 px-4 font-bold text-slate-900 border-r border-slate-100">
                                        <div class="flex items-center gap-2.5">
                                            @if($g->user)
                                                <x-avatar :user="$g->user" size="sm" class="shrink-0" />
                                            @endif
                                            <div>
                                                <span>{{ $g->nama }}</span>
                                                <span class="block text-[11px] text-slate-500 font-normal">{{ $g->user?->email ?? '—' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2.5 px-4 font-mono text-slate-600 border-r border-slate-100">{{ $g->nip }}</td>
                                    <td class="py-2.5 px-4 border-r border-slate-100">
                                        <span class="text-slate-700 font-medium">
                                            {{ $g->mata_pelajaran ?? 'Belum ada mapel' }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-4 text-slate-600 font-mono border-r border-slate-100">{{ $g->no_telepon }}</td>
                                    <td class="py-2.5 px-4 text-center">
                                        <a href="{{ route('admin.guru.show', $g->id) }}" class="px-2.5 py-1 text-[11px] font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded transition-colors">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400">Belum ada data guru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- tab daftar peserta didik -->
                <div x-show="activeDirectoryTab === 'siswa'" class="overflow-x-auto max-h-[520px] overflow-y-auto" style="display: none;">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase tracking-wider sticky top-0 z-10">
                                <th class="py-2.5 px-4 border-r border-slate-200">NIS</th>
                                <th class="py-2.5 px-4 border-r border-slate-200">Nama Siswa</th>
                                <th class="py-2.5 px-4 border-r border-slate-200">Kelas</th>
                                <th class="py-2.5 px-4 border-r border-slate-200 text-center">L/P</th>
                                <th class="py-2.5 px-4 border-r border-slate-200">Alamat</th>
                                <th class="py-2.5 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($siswaTerbaru as $m)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-2.5 px-4 font-mono font-semibold text-slate-600 border-r border-slate-100">{{ $m->nis }}</td>
                                    <td class="py-2.5 px-4 border-r border-slate-100 font-bold text-slate-900">
                                        {{ $m->nama }}
                                    </td>
                                    <td class="py-2.5 px-4 border-r border-slate-100">
                                        <span class="inline-block px-2 py-0.5 rounded bg-slate-100 text-slate-700 text-[11px] font-semibold">
                                            {{ $m->kelas }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-4 text-center border-r border-slate-100">
                                        <span class="inline-block px-1.5 py-0.5 text-[10px] font-bold rounded {{ $m->jenis_kelamin === 'P' ? 'bg-pink-50 text-pink-700 border border-pink-200' : 'bg-sky-50 text-sky-700 border border-sky-200' }}">
                                            {{ $m->jenis_kelamin }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-4 text-slate-600 border-r border-slate-100">{{ $m->alamat }}</td>
                                    <td class="py-2.5 px-4 text-center">
                                        <a href="{{ route('admin.siswa.show', $m->id) }}" class="px-2.5 py-1 text-[11px] font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded transition-colors">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-400">Belum ada data siswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- footer direktori -->
                <div class="p-3 bg-slate-50 border-t border-slate-200 flex items-center justify-between text-xs text-slate-500">
                    <span>SMK Shuka SIA Portal — Database Tenaga Pendidik & Peserta Didik</span>
                    <span class="font-medium text-slate-600">Total Akun: {{ $userCount }}</span>
                </div>

            </div>
        </div>

        <!-- kolom jadwal pelajaran dan agenda kegiatan -->
        <div class="lg:col-span-4 space-y-5">

            <!-- jadwal pelajaran hari ini -->
            <div class="bg-white border border-slate-200 rounded-lg shadow-2xs overflow-hidden">
                <div class="p-3.5 border-b border-slate-200 flex items-center justify-between bg-slate-50/60">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Jadwal Pelajaran Hari Ini</h3>
                    <a href="{{ route('admin.jadwal.index') }}" class="text-[11px] text-pink-600 font-semibold hover:underline">Semua Jadwal →</a>
                </div>

                <div class="divide-y divide-slate-100 max-h-72 overflow-y-auto">
                    @forelse ($jadwalHariIni as $j)
                        <div class="p-3 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs font-bold text-slate-900 truncate">{{ $j->mapel?->nama ?? 'Mata Pelajaran' }}</span>
                                <span class="text-[10px] font-semibold px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    {{ substr($j->jam_mulai ?? '', 0, 5) }} - {{ substr($j->jam_selesai ?? '', 0, 5) }}
                                </span>
                            </div>
                            <div class="text-[11px] text-slate-500">
                                Kelas <strong class="text-slate-700">{{ $j->kelas }}</strong> • Guru: {{ $j->mapel?->guru?->nama ?? 'Guru Shuka' }}
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-xs text-slate-400">Tidak ada sesi pelajaran aktif saat ini.</div>
                    @endforelse
                </div>
            </div>

            <!-- pengumuman terkini -->
            <div class="bg-white border border-slate-200 rounded-lg shadow-2xs p-4 space-y-3">
                <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                    <h4 class="text-xs font-bold uppercase text-slate-800 tracking-wider">Pengumuman Terkini</h4>
                    <a href="{{ route('admin.pengumuman.index') }}" class="text-[11px] text-pink-600 font-semibold hover:underline">Kelola →</a>
                </div>

                <div class="space-y-2">
                    @forelse ($pengumumanTerbaru as $peng)
                        <div class="p-2.5 bg-slate-50 rounded border border-slate-200 text-xs">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-bold text-slate-900 text-xs truncate">{{ $peng->judul }}</span>
                                <span class="text-[10px] px-1.5 py-0.5 rounded font-semibold {{ $peng->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                                    {{ $peng->is_active ? 'Aktif' : 'Draft' }}
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-600 line-clamp-2 leading-relaxed">{{ $peng->isi }}</p>
                        </div>
                    @empty
                        <div class="p-2 text-center text-xs text-slate-400">Belum ada pengumuman terbit.</div>
                    @endforelse
                </div>
            </div>

            <!-- agenda terdekat -->
            <div class="bg-white border border-slate-200 rounded-lg shadow-2xs p-4 space-y-3">
                <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                    <h4 class="text-xs font-bold uppercase text-slate-800 tracking-wider">Agenda Kegiatan</h4>
                    <a href="{{ route('admin.agenda.index') }}" class="text-[11px] text-pink-600 font-semibold hover:underline">Kalender →</a>
                </div>

                <div class="space-y-2">
                    @forelse ($agendaTerbaru as $ag)
                        <div class="p-2.5 bg-slate-50 rounded border border-slate-200 text-xs">
                            <div class="flex items-center justify-between mb-0.5">
                                <span class="font-bold text-slate-900">{{ $ag->judul }}</span>
                                <span class="text-pink-600 font-bold text-[11px]">{{ $ag->jam ?? $ag->tanggal }}</span>
                            </div>
                            <span class="text-[11px] text-slate-500">Lokasi: {{ $ag->lokasi ?? 'SMK Shuka' }}</span>
                        </div>
                    @empty
                        <div class="p-2 text-center text-xs text-slate-400">Belum ada agenda terdaftar.</div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
