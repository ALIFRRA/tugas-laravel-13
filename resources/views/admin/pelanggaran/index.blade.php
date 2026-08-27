@extends('layouts.admin')

@section('title', 'Kedisiplinan & Pelanggaran Siswa — SMK Shuka')
@section('heading', 'Kesiswaan: Kedisiplinan & Sanksi Siswa')

@section('content')
<div class="space-y-6" x-data="{ addModalOpen: @js(request()->filled('siswa_id')), editModalOpen: false, currentPelanggaran: {} }">

    <!-- Header & Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">Catatan Pelanggaran & Sanksi Kesiswaan</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Pencatatan poin kedisiplinan, sanksi pembinaan, dan tindak lanjut bimbingan konseling (BK) siswa SMK Shuka.</p>
        </div>
        <div class="flex items-center gap-2">
            <button 
                type="button" 
                @click="addModalOpen = true" 
                class="px-3.5 py-2 text-xs font-semibold text-white bg-pink-500 hover:bg-pink-600 rounded flex items-center gap-1.5 transition-colors shadow-sm"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Catat Pelanggaran Siswa</span>
            </button>
        </div>
    </div>

    <!-- Ringkasan Statistik Kedisiplinan -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-3">
        <div class="bg-white p-4 border border-slate-200 rounded-lg border-l-4 border-l-slate-800 shadow-sm">
            <span class="text-xs font-semibold text-slate-500 block">Total Pelanggaran</span>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $totalPelanggaran }} Kasus</p>
            <div class="mt-1 text-[11px] text-slate-500 font-medium">T.A. 2026/2027 Ganjil</div>
        </div>

        <div class="bg-white p-4 border border-slate-200 rounded-lg border-l-4 border-l-sky-600 shadow-sm">
            <span class="text-xs font-semibold text-slate-500 block">Kategori Ringan (1-10 Poin)</span>
            <p class="text-2xl font-bold text-sky-700 mt-1">{{ $ringanCount }}</p>
            <div class="mt-1 text-[11px] text-slate-500 font-medium">Peringatan Lisan/Teguran</div>
        </div>

        <div class="bg-white p-4 border border-slate-200 rounded-lg border-l-4 border-l-amber-500 shadow-sm">
            <span class="text-xs font-semibold text-slate-500 block">Kategori Sedang (11-25 Poin)</span>
            <p class="text-2xl font-bold text-amber-700 mt-1">{{ $sedangCount }}</p>
            <div class="mt-1 text-[11px] text-slate-500 font-medium">Sanksi Tugas & Kebersihan</div>
        </div>

        <div class="bg-white p-4 border border-slate-200 rounded-lg border-l-4 border-l-rose-600 shadow-sm">
            <span class="text-xs font-semibold text-slate-500 block">Kategori Berat (>25 Poin)</span>
            <p class="text-2xl font-bold text-rose-700 mt-1">{{ $beratCount }}</p>
            <div class="mt-1 text-[11px] text-rose-600 font-medium">Panggilan Orang Tua / BK</div>
        </div>

        <div class="bg-white p-4 border border-slate-200 rounded-lg border-l-4 border-l-pink-500 shadow-sm">
            <span class="text-xs font-semibold text-slate-500 block">Dalam Pembinaan</span>
            <p class="text-2xl font-bold text-pink-600 mt-1">{{ $dalamPembinaanCount }} Siswa</p>
            <div class="mt-1 text-[11px] text-slate-500 font-medium">Bimbingan Konseling</div>
        </div>
    </div>

    <!-- Filter & Pencarian Pelanggaran -->
    <div class="bg-white p-4 border border-slate-200 rounded-lg shadow-sm">
        <form method="GET" action="{{ route('admin.pelanggaran.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-3">
            <div class="flex-1 relative">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari nama siswa, NIS, jenis pelanggaran, atau sanksi..." 
                    class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 pl-9 pr-3"
                >
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <div class="flex items-center gap-2">
                <select name="kategori" class="text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                    <option value="all">Semua Kategori</option>
                    <option value="Ringan" {{ request('kategori') === 'Ringan' ? 'selected' : '' }}>Ringan</option>
                    <option value="Sedang" {{ request('kategori') === 'Sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="Berat" {{ request('kategori') === 'Berat' ? 'selected' : '' }}>Berat</option>
                </select>

                <select name="status" class="text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                    <option value="all">Semua Status</option>
                    <option value="Dalam Pembinaan" {{ request('status') === 'Dalam Pembinaan' ? 'selected' : '' }}>Dalam Pembinaan</option>
                    <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Ditindaklanjuti" {{ request('status') === 'Ditindaklanjuti' ? 'selected' : '' }}>Ditindaklanjuti</option>
                </select>

                <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-slate-800 hover:bg-slate-900 rounded transition-colors">
                    Filter
                </button>

                @if(request('search') || request('kategori') || request('status'))
                    <a href="{{ route('admin.pelanggaran.index') }}" class="px-3 py-2 text-xs font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Catatan Pelanggaran -->
    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-900">Rekapitulasi Pelanggaran & Sanksi ({{ $pelanggarans->total() }} Data)</h2>
            <span class="text-xs text-slate-500">Poin sanksi otomatis mengurangi indeks ketertiban siswa</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase tracking-wider">
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3 px-4">Kelas</th>
                        <th class="py-3 px-4">Bentuk Pelanggaran</th>
                        <th class="py-3 px-4 text-center">Kategori & Poin</th>
                        <th class="py-3 px-4">Bentuk Sanksi / Hukuman</th>
                        <th class="py-3 px-4">Tanggal & Pencatat</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($pelanggarans as $pel)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                {{ $pel->siswa->nama ?? '—' }}
                                <div class="font-mono text-[11px] text-slate-500 font-normal">{{ $pel->siswa->nis ?? '' }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-700">
                                <span class="inline-block px-2 py-0.5 rounded bg-slate-100 border border-slate-200">
                                    {{ $pel->siswa->kelas ?? '—' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-800 font-medium">
                                {{ $pel->jenis_pelanggaran }}
                                @if($pel->catatan)
                                    <div class="text-[11px] text-slate-500 mt-0.5">{{ $pel->catatan }}</div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-block px-2 py-0.5 text-[11px] font-bold rounded {{ $pel->kategori === 'Berat' ? 'bg-rose-50 text-rose-700 border border-rose-200' : ($pel->kategori === 'Sedang' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-sky-50 text-sky-700 border border-sky-200') }}">
                                    {{ $pel->kategori }} ({{ $pel->poin }} Pts)
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-slate-900">
                                {{ $pel->sanksi }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                <div>{{ $pel->tanggal }}</div>
                                <div class="text-[11px] text-slate-500">{{ $pel->guru_pencatat ?? 'Kesiswaan' }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-block px-2 py-0.5 text-[11px] font-semibold rounded {{ $pel->status === 'Selesai' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($pel->status === 'Ditindaklanjuti' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-pink-50 text-pink-700 border border-pink-200') }}">
                                    {{ $pel->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button 
                                        type="button" 
                                        @click="currentPelanggaran = {{ json_encode($pel) }}; editModalOpen = true"
                                        class="px-2 py-1 text-[11px] font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-300 rounded"
                                    >
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.pelanggaran.destroy', $pel->id) }}" method="POST" onsubmit="return confirm('Hapus catatan pelanggaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 text-[11px] font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-400">Belum ada catatan pelanggaran siswa. Seluruh siswa tertib.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pelanggarans->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $pelanggarans->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL CATAT PELANGGARAN BARU -->
    <div 
        x-show="addModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm"
        style="display: none;"
    >
        <div 
            @click.away="addModalOpen = false" 
            class="bg-white rounded-lg border border-slate-200 shadow-xl w-full max-w-lg overflow-hidden p-6 space-y-4 max-h-[90vh] overflow-y-auto"
        >
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <h3 class="text-sm font-bold text-slate-900">Catat Pelanggaran & Sanksi Siswa</h3>
                <button type="button" @click="addModalOpen = false" class="text-slate-400 hover:text-slate-700 text-sm font-bold">&times;</button>
            </div>

            <form method="POST" action="{{ route('admin.pelanggaran.store') }}" class="space-y-3.5 text-xs">
                @csrf

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Pilih Siswa *</label>
                    <select name="siswa_id" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                        <option value="">-- Pilih Siswa (600 Siswa) --</option>
                        @foreach ($siswas as $s)
                            <option value="{{ $s->id }}" @selected((string) old('siswa_id', request('siswa_id')) === (string) $s->id)>{{ $s->nama }} (NIS: {{ $s->nis }} - Kelas: {{ $s->kelas }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Jenis / Bentuk Pelanggaran *</label>
                    <input type="text" name="jenis_pelanggaran" required placeholder="Contoh: Terlambat Masuk Jam Pertama / Merusak Kabel Studio Musik" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Kategori Keparahan *</label>
                        <select name="kategori" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                            <option value="Ringan">Ringan (Teguran Lisan)</option>
                            <option value="Sedang">Sedang (Tugas Disiplin)</option>
                            <option value="Berat">Berat (Panggilan Orang Tua/BK)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Poin Pelanggaran (1 - 100) *</label>
                        <input type="number" name="poin" value="5" min="1" max="100" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Bentuk Sanksi / Hukuman Diberikan *</label>
                    <input type="text" name="sanksi" required placeholder="Contoh: Membersihkan Ruang Studio Latihan Drum / Membuat Resume Materi" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Tanggal Pelanggaran *</label>
                        <input type="text" name="tanggal" value="{{ date('d M Y') }}" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Status Penanganan *</label>
                        <select name="status" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                            <option value="Dalam Pembinaan">Dalam Pembinaan</option>
                            <option value="Ditindaklanjuti">Ditindaklanjuti</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Guru / Petugas Pencatat</label>
                    <input type="text" name="guru_pencatat" placeholder="Contoh: Seika Ijichi / Tim Kesiswaan" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Catatan Tambahan</label>
                    <textarea name="catatan" rows="2" placeholder="Tuliskan kronologi singkat..." class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-200">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded shadow-sm">
                        Simpan Catatan Pelanggaran
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT PELANGGARAN -->
    <div 
        x-show="editModalOpen" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm"
        style="display: none;"
    >
        <div 
            @click.away="editModalOpen = false" 
            class="bg-white rounded-lg border border-slate-200 shadow-xl w-full max-w-lg overflow-hidden p-6 space-y-4 max-h-[90vh] overflow-y-auto"
        >
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <h3 class="text-sm font-bold text-slate-900">Sunting Catatan Kedisiplinan</h3>
                <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-700 text-sm font-bold">&times;</button>
            </div>

            <form :action="'{{ url('admin/pelanggaran') }}/' + currentPelanggaran.id" method="POST" class="space-y-3.5 text-xs">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Pilih Siswa *</label>
                    <select name="siswa_id" x-model="currentPelanggaran.siswa_id" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                        @foreach ($siswas as $s)
                            <option value="{{ $s->id }}">{{ $s->nama }} (NIS: {{ $s->nis }} - Kelas: {{ $s->kelas }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Jenis / Bentuk Pelanggaran *</label>
                    <input type="text" name="jenis_pelanggaran" x-model="currentPelanggaran.jenis_pelanggaran" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Kategori Keparahan *</label>
                        <select name="kategori" x-model="currentPelanggaran.kategori" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                            <option value="Ringan">Ringan (Teguran Lisan)</option>
                            <option value="Sedang">Sedang (Tugas Disiplin)</option>
                            <option value="Berat">Berat (Panggilan Orang Tua/BK)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Poin Pelanggaran (1 - 100) *</label>
                        <input type="number" name="poin" x-model="currentPelanggaran.poin" min="1" max="100" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Bentuk Sanksi / Hukuman *</label>
                    <input type="text" name="sanksi" x-model="currentPelanggaran.sanksi" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Tanggal Pelanggaran *</label>
                        <input type="text" name="tanggal" x-model="currentPelanggaran.tanggal" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Status Penanganan *</label>
                        <select name="status" x-model="currentPelanggaran.status" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                            <option value="Dalam Pembinaan">Dalam Pembinaan</option>
                            <option value="Ditindaklanjuti">Ditindaklanjuti</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Guru / Petugas Pencatat</label>
                    <input type="text" name="guru_pencatat" x-model="currentPelanggaran.guru_pencatat" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Catatan Tambahan</label>
                    <textarea name="catatan" x-model="currentPelanggaran.catatan" rows="2" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-200">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
