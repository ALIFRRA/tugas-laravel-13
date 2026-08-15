@extends('layouts.admin')

@section('title', 'Ekstrakurikuler Kejuruan — SMK Shuka')
@section('heading', 'Ekstrakurikuler Kejuruan & Seni Musik')

@section('content')
<div class="space-y-6">

    <!-- Header Summary -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">Direktori Ekstrakurikuler SMK Shuka (12 Klub)</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Wadah pengembangan bakat, klub seni musik panggung, audio lab, broadcasting, multimedia, dan kebugaran.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-3 py-1.5 rounded text-xs font-semibold bg-pink-50 text-pink-700 border border-pink-200">
                12 Klub Aktif Terdaftar
            </span>
        </div>
    </div>

    <!-- Ringkasan Status Widget -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 border border-slate-200 rounded-lg border-l-4 border-l-pink-500 shadow-sm">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Klub Utama Musik</span>
            <div class="text-2xl font-bold text-slate-900 mt-1">Kessoku Band</div>
            <div class="text-xs text-pink-600 font-medium mt-1">28 Anggota • Studio STARRY</div>
        </div>

        <div class="bg-white p-4 border border-slate-200 rounded-lg border-l-4 border-l-sky-600 shadow-sm">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Peserta Ekskul</span>
            <div class="text-2xl font-bold text-slate-900 mt-1">329 Siswa</div>
            <div class="text-xs text-sky-700 font-medium mt-1">Partisipasi Aktif SMK Shuka</div>
        </div>

        <div class="bg-white p-4 border border-slate-200 rounded-lg border-l-4 border-l-amber-500 shadow-sm">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Fasilitas & Alat Musik</span>
            <div class="text-2xl font-bold text-slate-900 mt-1">{{ count($inventarisAlat) }} Unit Utama</div>
            <div class="text-xs text-amber-700 font-medium mt-1">Gitar, Bass, Drum, Mixer</div>
        </div>

        <div class="bg-white p-4 border border-slate-200 rounded-lg border-l-4 border-l-emerald-600 shadow-sm">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Studio Mitra Resmi</span>
            <div class="text-2xl font-bold text-emerald-700 mt-1">Livehouse STARRY</div>
            <div class="text-xs text-slate-500 font-medium mt-1">Shimokitazawa Basement</div>
        </div>
    </div>

    <!-- GRID 12 KLUB EKSTRAKURIKULER -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($ekskulList as $ekskul)
            <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm hover:border-pink-300 transition-colors flex flex-col justify-between space-y-4">
                <div>
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-0.5">{{ $ekskul['kategori'] }}</span>
                            <h3 class="text-sm font-bold text-slate-900 leading-snug">{{ $ekskul['nama'] }}</h3>
                        </div>
                        <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded bg-pink-50 text-pink-700 border border-pink-200 shrink-0">
                            {{ $ekskul['badge'] }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed">{{ $ekskul['deskripsi'] }}</p>
                </div>

                <div class="pt-3 border-t border-slate-100 space-y-1.5 text-xs text-slate-600">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Pembina:</span>
                        <strong class="text-slate-800 text-right">{{ $ekskul['pembina'] }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Ketua Klub:</span>
                        <span class="font-semibold text-slate-800">{{ $ekskul['ketua'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Lokasi:</span>
                        <span class="text-slate-700">{{ $ekskul['lokasi'] }}</span>
                    </div>
                    <div class="flex items-center justify-between pt-1 border-t border-slate-50 text-[11px]">
                        <span class="text-slate-500 font-medium">Jadwal: <strong class="text-slate-700">{{ $ekskul['jadwal'] }}</strong></span>
                        <span class="font-bold text-pink-600 bg-pink-50 px-2 py-0.5 rounded">{{ $ekskul['anggota'] }} Siswa</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- INVENTARIS FASILITAS & ALAT MUSIK -->
    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-slate-900">Inventaris Fasilitas Panggung & Alat Musik SMK Shuka</h2>
                <p class="text-xs text-slate-500 mt-0.5">Daftar peralatan instrumen dan sound system yang dikelola untuk kegiatan ekstrakurikuler.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase tracking-wider">
                        <th class="py-2.5 px-4">Nama Instrumen / Alat</th>
                        <th class="py-2.5 px-4">Kategori Alat</th>
                        <th class="py-2.5 px-4">Pemilik / Lokasi Penempatan</th>
                        <th class="py-2.5 px-4 text-center">Kondisi</th>
                        <th class="py-2.5 px-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($inventarisAlat as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="py-3 px-4 font-bold text-slate-900">
                                {{ $item['nama'] }}
                            </td>
                            <td class="py-3 px-4 text-slate-700 font-medium">{{ $item['kategori'] }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $item['pemilik'] }}</td>
                            <td class="py-3 px-4 text-center font-medium text-slate-700">{{ $item['kondisi'] }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-block px-2 py-0.5 text-[11px] font-semibold rounded {{ $item['status'] === 'Tersedia' || $item['status'] === 'Tersedia di Studio' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                    {{ $item['status'] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
