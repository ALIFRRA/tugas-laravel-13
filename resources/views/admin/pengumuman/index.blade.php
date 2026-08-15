@extends('layouts.admin')

@section('title', 'Pengumuman Sekolah — SMK Shuka')
@section('heading', 'Pengumuman & Informasi Sekolah')

@section('content')
<div class="space-y-6" x-data="{ addModalOpen: false, editModalOpen: false, currentPengumuman: {} }">

    <!-- Header Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">Pengumuman & Notifikasi Resmi</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola pemberitahuan resmi SMK Shuka yang otomatis tampil sebagai banner notifikasi di dasbor.</p>
        </div>
        <div class="flex items-center gap-2">
            <button 
                type="button" 
                @click="addModalOpen = true" 
                class="px-3.5 py-2 text-xs font-semibold text-white bg-pink-500 hover:bg-pink-600 rounded flex items-center gap-1.5 transition-colors shadow-sm"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Buat Pengumuman Baru</span>
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-4 border border-slate-200 rounded-lg shadow-sm">
        <form method="GET" action="{{ route('admin.pengumuman.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-3">
            <div class="flex-1 relative">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari judul pengumuman, isi pesan, atau penulis..." 
                    class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 pl-9 pr-3"
                >
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <div class="flex items-center gap-2">
                <select name="tipe" class="text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                    <option value="all">Semua Tipe</option>
                    <option value="info" {{ request('tipe') === 'info' ? 'selected' : '' }}>Info Standar</option>
                    <option value="penting" {{ request('tipe') === 'penting' ? 'selected' : '' }}>Penting</option>
                    <option value="mendesak" {{ request('tipe') === 'mendesak' ? 'selected' : '' }}>Mendesak</option>
                    <option value="agenda" {{ request('tipe') === 'agenda' ? 'selected' : '' }}>Agenda Khusus</option>
                </select>

                <select name="status" class="text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                    <option value="all">Semua Status</option>
                    <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif (Tampil)</option>
                    <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Non-Aktif (Draft/Arsip)</option>
                </select>

                <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-slate-800 hover:bg-slate-900 rounded transition-colors">
                    Filter
                </button>

                @if(request('search') || request('tipe') || request('status'))
                    <a href="{{ route('admin.pengumuman.index') }}" class="px-3 py-2 text-xs font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Pengumuman -->
    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-900">Daftar Pengumuman Sekolah ({{ $pengumumans->total() }} Data)</h2>
            <span class="text-xs text-slate-500">Pengumuman aktif akan otomatis muncul sebagai notifikasi alert di header aplikasi</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase tracking-wider">
                        <th class="py-3 px-4">Judul & Isi Pengumuman</th>
                        <th class="py-3 px-4 text-center">Tipe / Urgensi</th>
                        <th class="py-3 px-4 text-center">Target</th>
                        <th class="py-3 px-4">Penulis & Tanggal</th>
                        <th class="py-3 px-4 text-center">Status Tayang</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($pengumumans as $p)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3.5 px-4 max-w-md">
                                <div class="font-bold text-slate-900 text-sm">{{ $p->judul }}</div>
                                <p class="text-xs text-slate-600 mt-1 line-clamp-2 leading-relaxed">{{ $p->isi }}</p>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($p->tipe === 'mendesak')
                                    <span class="inline-block px-2.5 py-0.5 text-[11px] font-bold rounded bg-rose-50 text-rose-700 border border-rose-200">Mendesak</span>
                                @elseif($p->tipe === 'penting')
                                    <span class="inline-block px-2.5 py-0.5 text-[11px] font-bold rounded bg-amber-50 text-amber-700 border border-amber-200">Penting</span>
                                @elseif($p->tipe === 'agenda')
                                    <span class="inline-block px-2.5 py-0.5 text-[11px] font-bold rounded bg-pink-50 text-pink-700 border border-pink-200">Agenda</span>
                                @else
                                    <span class="inline-block px-2.5 py-0.5 text-[11px] font-bold rounded bg-sky-50 text-sky-700 border border-sky-200">Info</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center font-semibold text-slate-700 uppercase text-[11px]">
                                {{ $p->target }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                <div class="font-medium text-slate-800">{{ $p->penulis ?? 'Admin' }}</div>
                                <div class="text-[11px] text-slate-400">{{ $p->created_at->format('d M Y, H:i') }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <form action="{{ route('admin.pengumuman.toggle', $p->id) }}" method="POST">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="inline-flex items-center px-2.5 py-1 text-[11px] font-semibold rounded cursor-pointer transition-colors {{ $p->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-300 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border border-slate-300 hover:bg-slate-200' }}"
                                        title="Klik untuk ubah status aktif/nonaktif"
                                    >
                                        {{ $p->is_active ? '● Aktif' : '○ Non-Aktif' }}
                                    </button>
                                </form>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button 
                                        type="button" 
                                        @click="currentPengumuman = {{ json_encode($p) }}; editModalOpen = true"
                                        class="px-2.5 py-1 text-[11px] font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-300 rounded"
                                    >
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.pengumuman.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus pengumuman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 text-[11px] font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Belum ada pengumuman yang tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pengumumans->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $pengumumans->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL TAMBAH PENGUMUMAN -->
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
                <h3 class="text-sm font-bold text-slate-900">Buat Pengumuman Sekolah Baru</h3>
                <button type="button" @click="addModalOpen = false" class="text-slate-400 hover:text-slate-700 text-sm font-bold">&times;</button>
            </div>

            <form method="POST" action="{{ route('admin.pengumuman.store') }}" class="space-y-3.5 text-xs">
                @csrf

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Judul Pengumuman *</label>
                    <input type="text" name="judul" required placeholder="Contoh: Pengambilan Kartu Peserta Ujian UKK Musik 2026" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Tipe / Urgensi *</label>
                        <select name="tipe" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                            <option value="info">Info Standar</option>
                            <option value="penting">Penting</option>
                            <option value="mendesak">Mendesak</option>
                            <option value="agenda">Agenda Khusus</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Target Audiens *</label>
                        <select name="target" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                            <option value="semua">Semua (Umum)</option>
                            <option value="guru">Khusus Guru</option>
                            <option value="murid">Khusus Siswa</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Isi Lengkap Pengumuman *</label>
                    <textarea name="isi" rows="4" required placeholder="Tuliskan isi pengumuman secara rinci..." class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3"></textarea>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" name="is_active" id="is_active_new" value="1" checked class="rounded border-slate-300 text-pink-600 focus:ring-pink-500">
                    <label for="is_active_new" class="font-semibold text-slate-800">Tayangkan langsung sebagai banner notifikasi aktif</label>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-200">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded shadow-sm">
                        Publikasikan Pengumuman
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT PENGUMUMAN -->
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
                <h3 class="text-sm font-bold text-slate-900">Sunting Pengumuman Sekolah</h3>
                <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-700 text-sm font-bold">&times;</button>
            </div>

            <form :action="'{{ url('admin/pengumuman') }}/' + currentPengumuman.id" method="POST" class="space-y-3.5 text-xs">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Judul Pengumuman *</label>
                    <input type="text" name="judul" x-model="currentPengumuman.judul" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Tipe / Urgensi *</label>
                        <select name="tipe" x-model="currentPengumuman.tipe" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                            <option value="info">Info Standar</option>
                            <option value="penting">Penting</option>
                            <option value="mendesak">Mendesak</option>
                            <option value="agenda">Agenda Khusus</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Target Audiens *</label>
                        <select name="target" x-model="currentPengumuman.target" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                            <option value="semua">Semua (Umum)</option>
                            <option value="guru">Khusus Guru</option>
                            <option value="murid">Khusus Siswa</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Isi Lengkap Pengumuman *</label>
                    <textarea name="isi" x-model="currentPengumuman.isi" rows="4" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3"></textarea>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" name="is_active" id="is_active_edit" value="1" :checked="currentPengumuman.is_active" class="rounded border-slate-300 text-pink-600 focus:ring-pink-500">
                    <label for="is_active_edit" class="font-semibold text-slate-800">Tayangkan sebagai banner notifikasi aktif</label>
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
