@extends('layouts.admin')

@section('title', 'Dashboard — SMK Shuka')
@section('heading', 'Dashboard Administrator')

@section('content')
<div class="space-y-6">

    <!-- BARIS AKSI UTAMA & SUMMARY HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">Dasbor Akademik SMK Shuka</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Pusat data informasi terpadu kejuruan seni musik populer, audio engineering, DKV, RPL, dan manajemen event.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.pengumuman.index') }}" class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded hover:bg-slate-50 flex items-center gap-1.5 transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                <span>Kelola Pengumuman</span>
            </a>
            <a href="{{ route('admin.siswa.create') }}" class="px-3.5 py-1.5 text-xs font-semibold text-white bg-pink-500 hover:bg-pink-600 rounded flex items-center gap-1.5 transition-colors shadow-sm">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Siswa Baru</span>
            </a>
        </div>
    </div>

    <!-- PANEL RINGKASAN SISTEM (Flat Metric Cards, Solid Pink & Slate, Minimalist) -->
    <section aria-labelledby="ringkasan-title">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between mb-3">
            <h2 id="ringkasan-title" class="text-xs font-bold uppercase tracking-wider text-slate-700 flex items-center gap-2">
                <span class="w-2 h-2 bg-pink-500 inline-block rounded-full"></span>
                Ringkasan Sistem Kejuruan SMK Shuka
            </h2>
            <span class="text-xs text-slate-500 font-medium">Tercatat: {{ number_format($siswaCount) }} Siswa • {{ $guruCount }} Guru • {{ $mapelCount }} Mapel</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">

            <!-- 1. Total Murid -->
            <div class="bg-white p-4 border border-slate-200 rounded-lg border-l-4 border-l-pink-500 shadow-sm">
                <span class="text-xs font-semibold text-slate-500 block">Total Siswa</span>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($siswaCount ?? 600) }}</p>
                <div class="mt-1 text-[11px] text-pink-700 font-semibold">
                    <span>{{ number_format($siswaCount) }} Siswa SMK</span>
                </div>
            </div>

            <!-- 2. Tenaga Pendidik -->
            <div class="bg-white p-4 border border-slate-200 rounded-lg border-l-4 border-l-slate-700 shadow-sm">
                <span class="text-xs font-semibold text-slate-500 block">Tenaga Pendidik</span>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ $guruCount ?? 45 }}</p>
                <div class="mt-1 text-[11px] text-slate-600 font-medium">
                    <span>Guru Kejuruan & Staf</span>
                </div>
            </div>

            <!-- 3. Mata Pelajaran -->
            <div class="bg-white p-4 border border-slate-200 rounded-lg border-l-4 border-l-sky-600 shadow-sm">
                <span class="text-xs font-semibold text-slate-500 block">Mata Pelajaran</span>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ $mapelCount ?? 28 }}</p>
                <div class="mt-1 text-[11px] text-sky-700 font-semibold">
                    <span>{{ $programCount }} Program Keahlian</span>
                </div>
            </div>

            <!-- 4. Agenda Sekolah -->
            <div class="bg-white p-4 border border-slate-200 rounded-lg border-l-4 border-l-indigo-600 shadow-sm">
                <span class="text-xs font-semibold text-slate-500 block">Agenda Sekolah</span>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ $agendaCount ?? 5 }}</p>
                <div class="mt-1 text-[11px] text-indigo-700 font-medium">
                    <span>Kalender Kegiatan</span>
                </div>
            </div>

            <!-- 5. Pengumuman Aktif -->
            <div class="bg-white p-4 border border-slate-200 rounded-lg border-l-4 border-l-amber-500 shadow-sm">
                <span class="text-xs font-semibold text-slate-500 block">Pengumuman</span>
                <p class="text-2xl font-bold text-slate-900 mt-1">{{ $pengumumanCount ?? 0 }}</p>
                <div class="mt-1 text-[11px] text-amber-700 font-semibold">
                    <span>Informasi Sekolah</span>
                </div>
            </div>

            <!-- 6. Catatan Kedisiplinan -->
            <div class="bg-white p-4 border border-slate-200 rounded-lg border-l-4 border-l-rose-600 shadow-sm">
                <span class="text-xs font-semibold text-slate-500 block">Kedisiplinan</span>
                <p class="text-2xl font-bold text-rose-700 mt-1">{{ $pelanggaranCount ?? 0 }}</p>
                <div class="mt-1 text-[11px] text-slate-600 font-medium">
                    <span>Kasus Pembinaan</span>
                </div>
            </div>

        </div>
    </section>

    <!-- TATA LETAK DUA KOLOM: JADWAL & AGENDA (KIRI) vs DAFTAR MURID (KANAN) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- TABEL JADWAL HARI INI, AGENDA SEKOLAH & PENGUMUMAN (4 SPAN KIRI) -->
        <div class="lg:col-span-4 space-y-4">

            @if ($canManageAcademic)
            <!-- PANEL JADWAL HARI INI (Scrollable like Murid Dashboard) -->
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
                <div class="p-4 border-b border-slate-200 flex items-center justify-between sticky top-0 bg-white z-10">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-pink-500 rounded-full"></span>
                        <h3 class="text-sm font-bold text-slate-900">Jadwal Pelajaran Hari Ini</h3>
                    </div>
                    <span class="inline-block px-2 py-0.5 text-[11px] font-semibold rounded bg-pink-50 text-pink-700 border border-pink-200">
                        Aktif
                    </span>
                </div>

                <div class="divide-y divide-slate-100 max-h-96 overflow-y-auto">
                    @forelse ($jadwalHariIni as $j)
                        <div class="p-3.5 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center justify-between mb-1">
                                <span class="min-w-0 truncate text-xs font-bold text-slate-900">{{ $j->mapel?->nama ?? 'Mata pelajaran belum ditautkan' }}</span>
                                <span class="inline-block px-1.5 py-0.2 text-[10px] font-semibold rounded bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Berlangsung
                                </span>
                            </div>
                            <div class="text-[11px] text-pink-600 font-semibold mb-1">Kelas {{ $j->kelas ?? $j['kelas'] }} • {{ substr($j->jam_mulai ?? $j['jam'], 0, 5) }} - {{ substr($j->jam_selesai ?? '', 0, 5) }}</div>
                            <div class="text-[11px] text-slate-500">
                                Guru Pengampu: <strong class="text-slate-700">{{ $j->mapel->guru->nama ?? 'Guru Shuka' }}</strong>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-xs text-slate-400">Tidak ada jadwal pelajaran tercatat untuk hari ini.</div>
                    @endforelse
                </div>

                <div class="p-3 bg-slate-50 border-t border-slate-200 text-center">
                    <a href="{{ route('admin.jadwal.index') }}" class="text-xs font-semibold text-pink-600 hover:text-pink-700">Lihat Seluruh Jadwal SMK →</a>
                </div>
            </div>

            @endif

            <!-- PANEL AGENDA SEKOLAH TERKINI -->
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-4 space-y-3">
                <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-indigo-500 rounded-full"></span>
                        <h4 class="text-xs font-bold uppercase text-slate-700">Agenda Sekolah Terkini</h4>
                    </div>
                    <a href="{{ route('admin.agenda.index') }}" class="text-[11px] font-semibold text-pink-600 hover:underline">Kelola Agenda →</a>
                </div>

                <div class="text-xs space-y-2.5">
                    @forelse ($agendaTerbaru ?? [] as $ag)
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded">
                            <div class="flex items-center justify-between text-xs font-semibold text-slate-500 mb-0.5">
                                <span class="font-bold text-slate-900 leading-snug">{{ $ag->judul }}</span>
                                <span class="text-pink-600 font-bold shrink-0 ml-2">{{ $ag->jam ?? $ag->tanggal }}</span>
                            </div>
                            <p class="text-[11px] text-slate-600">{{ $ag->kategori }} • Lokasi: {{ $ag->lokasi ?? 'SMK Shuka' }}</p>
                        </div>
                    @empty
                        <div class="p-3 text-center text-xs text-slate-400">Belum ada agenda kegiatan.</div>
                    @endforelse
                </div>
            </div>

            <!-- PANEL PENGUMUMAN SEKOLAH TERKINI -->
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-4 space-y-3">
                <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                        <h4 class="text-xs font-bold uppercase text-slate-700">Pengumuman & Notifikasi</h4>
                    </div>
                    <a href="{{ route('admin.pengumuman.index') }}" class="text-[11px] font-semibold text-pink-600 hover:underline">Kelola Pengumuman →</a>
                </div>

                <div class="text-xs space-y-2">
                    @forelse ($pengumumanTerbaru ?? [] as $peng)
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded flex flex-col justify-between gap-1">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-slate-900 text-xs">{{ $peng->judul }}</span>
                                <span class="text-[10px] px-1.5 py-0.2 rounded font-semibold {{ $peng->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                                    {{ $peng->is_active ? 'Aktif' : 'Draft' }}
                                </span>
                            </div>
                            <p class="text-[11px] text-slate-600 line-clamp-1">{{ $peng->isi }}</p>
                        </div>
                    @empty
                        <div class="p-3 text-center text-xs text-slate-400">Belum ada pengumuman.</div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- TABEL DAFTAR MURID (8 SPAN KANAN - RENDER DATA SEEDER 600 MURID SMK) -->
        <div class="lg:col-span-8 space-y-4">
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">

                <!-- Header Tabel & Filter Kelas -->
                <div class="p-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 bg-pink-500 rounded-full"></span>
                            <h3 class="text-sm font-bold text-slate-900">Daftar Siswa Terdaftar ({{ number_format($siswaCount) }} Siswa)</h3>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Jurusan Seni Musik Populer (SMP), Audio Engineering (AET), DKV, RPL, dan MBE.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.siswa.index') }}" class="text-xs text-pink-600 font-bold hover:underline">Lihat Semua Siswa →</a>
                    </div>
                </div>

                <!-- Table Content (Minimalist School Table, Equal Representation) -->
                <div class="overflow-x-auto max-h-[580px] overflow-y-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase tracking-wider sticky top-0 bg-slate-50 z-10">
                                <th class="py-2.5 px-4 border-r border-slate-200">NIS</th>
                                <th class="py-2.5 px-4 border-r border-slate-200">Nama Siswa</th>
                                <th class="py-2.5 px-4 border-r border-slate-200">Kelas / Jurusan</th>
                                <th class="py-2.5 px-4 border-r border-slate-200 text-center">L/P</th>
                                <th class="py-2.5 px-4 border-r border-slate-200">Alamat / Wilayah</th>
                                <th class="py-2.5 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse ($siswaTerbaru as $m)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="py-2.5 px-4 font-mono font-semibold text-slate-600 border-r border-slate-100">{{ $m->nis }}</td>
                                    <td class="py-2.5 px-4 border-r border-slate-100 font-bold text-slate-900">
                                        {{ $m->nama }}
                                    </td>
                                    <td class="py-2.5 px-4 font-semibold text-slate-700 border-r border-slate-100">
                                        <span class="inline-block px-1.5 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200 text-[11px]">
                                            {{ $m->kelas }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-4 text-center border-r border-slate-100">
                                        <span class="inline-block px-1.5 py-0.5 text-[10px] font-semibold rounded {{ $m->jenis_kelamin === 'P' ? 'bg-pink-50 text-pink-700 border border-pink-200' : 'bg-sky-50 text-sky-700 border border-sky-200' }}">
                                            {{ $m->jenis_kelamin }}
                                        </span>
                                    </td>
                                    <td class="py-2.5 px-4 text-slate-600 border-r border-slate-100 font-medium">{{ $m->alamat }}</td>
                                    <td class="py-2.5 px-4 text-center">
                                        <a href="{{ route('admin.siswa.show', $m->id) }}" class="px-2.5 py-1 text-[11px] font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-300 rounded transition-colors">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-400">Belum ada data siswa terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Status & Action -->
                <div class="p-3 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs text-slate-600">
                    <div>
                        Menampilkan sampel <strong>{{ count($siswaTerbaru) }}</strong> data siswa terbaru dari total <strong>{{ number_format($siswaCount) }}</strong> siswa terdaftar di SMK Shuka.
                    </div>
                    <a href="{{ route('admin.siswa.index') }}" class="px-3 py-1.5 bg-pink-500 text-white font-semibold rounded text-xs hover:bg-pink-600 transition-colors shadow-sm">
                        Buka Master Data Siswa →
                    </a>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection
