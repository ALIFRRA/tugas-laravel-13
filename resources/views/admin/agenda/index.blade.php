@extends('layouts.admin')

@section('title', 'Agenda Sekolah — SMK Shuka')
@section('heading', 'Agenda & Kalender Kegiatan Sekolah')

@section('content')
<div class="space-y-6" x-data="{ addModalOpen: false, editModalOpen: false, currentAgenda: {} }">

    <!-- Header Page Summary & Tombol Tambah Agenda -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900">Agenda & Kalender Kegiatan SMK Shuka</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola jadwal latihan band, persiapan festival Shuka-sai, ujian kompetensi kejuruan (UKK), dan workshop industri.</p>
        </div>
        @if(Auth::user()->canManageAgenda())
        <div class="flex items-center gap-2">
            <button 
                type="button" 
                @click="addModalOpen = true" 
                class="px-3.5 py-2 text-xs font-semibold text-white bg-pink-500 hover:bg-pink-600 rounded flex items-center gap-1.5 transition-colors shadow-sm"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Agenda Baru</span>
            </button>
        </div>
        @endif
    </div>

    <!-- Ringkasan Status Widget -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-4 border border-slate-200 rounded-lg border-l-4 border-l-pink-500 shadow-sm">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Agenda</span>
            <div class="text-2xl font-bold text-slate-900 mt-1">{{ $totalAgenda }} Agenda</div>
            <div class="text-xs text-pink-600 font-medium mt-1">T.A. 2026/2027 Ganjil</div>
        </div>

        <div class="bg-white p-4 border border-slate-200 rounded-lg border-l-4 border-l-emerald-600 shadow-sm">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Agenda Aktif</span>
            <div class="text-2xl font-bold text-emerald-700 mt-1">{{ $aktifCount }} Kegiatan</div>
            <div class="text-xs text-slate-500 font-medium mt-1">Sedang Berlangsung</div>
        </div>

        <div class="bg-white p-4 border border-slate-200 rounded-lg border-l-4 border-l-amber-500 shadow-sm">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Tahap Persiapan</span>
            <div class="text-2xl font-bold text-amber-700 mt-1">{{ $persiapanCount }} Event</div>
            <div class="text-xs text-amber-700 font-medium mt-1">Festival Shuka-sai & Panggung</div>
        </div>

        <div class="bg-white p-4 border border-slate-200 rounded-lg border-l-4 border-l-sky-600 shadow-sm">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Agenda Mendatang</span>
            <div class="text-2xl font-bold text-sky-700 mt-1">{{ $mendatangCount }} Kegiatan</div>
            <div class="text-xs text-slate-500 font-medium mt-1">UKK & Workshop Industri</div>
        </div>
    </div>

    <!-- FILTER & DAFTAR AGENDA KEGIATAN -->
    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white">
            <div>
                <h2 class="text-sm font-bold text-slate-900">Daftar Agenda Kegiatan Sekolah ({{ $agendas->total() }} Data)</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola, sunting, atau hapus jadwal kegiatan kesiswaan SMK Shuka.</p>
            </div>

            <!-- Filter Kategori & Status -->
            <form method="GET" action="{{ route('admin.agenda.index') }}" class="flex flex-wrap items-center gap-2">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari agenda..." 
                    class="text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-1.5 px-2.5"
                >
                <select name="kategori" class="text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-1.5 px-2.5">
                    <option value="all">Semua Kategori</option>
                    <option value="Latihan Band" {{ request('kategori') === 'Latihan Band' ? 'selected' : '' }}>Latihan Band</option>
                    <option value="Festival Sekolah" {{ request('kategori') === 'Festival Sekolah' ? 'selected' : '' }}>Festival Sekolah</option>
                    <option value="Workshop" {{ request('kategori') === 'Workshop' ? 'selected' : '' }}>Workshop</option>
                    <option value="Uji Kompetensi Kejuruan (UKK)" {{ request('kategori') === 'Uji Kompetensi Kejuruan (UKK)' ? 'selected' : '' }}>UKK Kejuruan</option>
                    <option value="Konseling" {{ request('kategori') === 'Konseling' ? 'selected' : '' }}>Konseling</option>
                </select>
                <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-white bg-slate-800 hover:bg-slate-900 rounded">
                    Filter
                </button>
                @if(request('search') || request('kategori'))
                    <a href="{{ route('admin.agenda.index') }}" class="px-2.5 py-1.5 text-xs text-slate-600 bg-slate-100 hover:bg-slate-200 rounded">Reset</a>
                @endif
            </form>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse ($agendas as $a)
                <div class="p-4 hover:bg-slate-50 transition-colors">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 mb-2">
                        <div>
                            <span class="inline-block px-2 py-0.5 text-[11px] font-semibold rounded bg-slate-100 text-slate-700 border border-slate-200 mb-1">
                                {{ $a->kategori }}
                            </span>
                            <h3 class="text-sm font-bold text-slate-900">{{ $a->judul }}</h3>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-2 py-0.5 text-xs font-semibold rounded {{ $a->status === 'Aktif' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : ($a->status === 'Persiapan' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-pink-50 text-pink-700 border border-pink-200') }}">
                                {{ $a->status }}
                            </span>
                            @if(Auth::user()->canManageAgenda())
                            <button 
                                type="button" 
                                @click="currentAgenda = {{ json_encode($a) }}; editModalOpen = true"
                                class="px-2 py-1 text-[11px] font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-300 rounded"
                            >
                                Edit
                            </button>
                            <form action="{{ route('admin.agenda.destroy', $a->id) }}" method="POST" onsubmit="return confirm('Hapus agenda ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1 text-[11px] font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded">
                                    Hapus
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-slate-600 mb-2">
                        <div><strong class="text-slate-700">Waktu:</strong> {{ $a->tanggal }} @if($a->jam) ({{ $a->jam }}) @endif</div>
                        <div><strong class="text-slate-700">Lokasi:</strong> {{ $a->lokasi ?? '—' }}</div>
                        <div class="sm:col-span-2"><strong class="text-slate-700">Penanggung Jawab:</strong> {{ $a->penanggung_jawab ?? '—' }}</div>
                        @if($a->personel)
                            <div class="sm:col-span-2"><strong class="text-slate-700">Partisipan / Anggota:</strong> {{ $a->personel }}</div>
                        @endif
                    </div>

                    @if($a->catatan)
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded text-xs text-slate-600">
                            <span class="font-semibold text-slate-700">Catatan:</span> {{ $a->catatan }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="p-8 text-center text-xs text-slate-400">
                    Belum ada agenda yang tersimpan. Klik tombol "Tambah Agenda Baru" di atas untuk menambahkan.
                </div>
            @endforelse
        </div>

        @if($agendas->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50">
                {{ $agendas->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL TAMBAH AGENDA BARU -->
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
                <h3 class="text-sm font-bold text-slate-900">Tambah Agenda Kegiatan Baru</h3>
                <button type="button" @click="addModalOpen = false" class="text-slate-400 hover:text-slate-700 text-sm font-bold">&times;</button>
            </div>

            <form method="POST" action="{{ route('admin.agenda.store') }}" class="space-y-3.5 text-xs">
                @csrf

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Judul Kegiatan / Agenda *</label>
                    <input type="text" name="judul" required placeholder="Contoh: Latihan Ensembel Band Studio 1" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Kategori Kegiatan *</label>
                        <select name="kategori" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                            <option value="Latihan Band">Latihan Band</option>
                            <option value="Festival Sekolah">Festival Sekolah</option>
                            <option value="Workshop">Workshop</option>
                            <option value="Uji Kompetensi Kejuruan (UKK)">UKK Kejuruan</option>
                            <option value="Konseling">Konseling</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Status Kegiatan *</label>
                        <select name="status" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                            <option value="Aktif">Aktif</option>
                            <option value="Persiapan">Persiapan</option>
                            <option value="Mendatang">Mendatang</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Tanggal Kegiatan *</label>
                        <input type="text" name="tanggal" required placeholder="Contoh: 28 Ags 2026 / Setiap Rabu" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Jam / Waktu Pelaksanaan</label>
                        <input type="text" name="jam" placeholder="Contoh: 16:30 - 19:30 JST" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Lokasi Tempat</label>
                        <input type="text" name="lokasi" placeholder="Contoh: STARRY Basement / Aula Utama" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Penanggung Jawab / Pembina</label>
                        <input type="text" name="penanggung_jawab" placeholder="Contoh: Seika Ijichi / PA-san" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Partisipan / Personel Siswa</label>
                    <input type="text" name="personel" placeholder="Contoh: Hitori Gotoh, Ikuyo Kita, Ryo Yamada, Nijika Ijichi" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Catatan / Deskripsi Agenda</label>
                    <textarea name="catatan" rows="2" placeholder="Tuliskan catatan teknis pelaksanaan..." class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-200">
                    <button type="button" @click="addModalOpen = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded shadow-sm">
                        Simpan Agenda
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT AGENDA -->
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
                <h3 class="text-sm font-bold text-slate-900">Sunting Agenda Kegiatan</h3>
                <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-700 text-sm font-bold">&times;</button>
            </div>

            <form :action="'{{ url('admin/agenda') }}/' + currentAgenda.id" method="POST" class="space-y-3.5 text-xs">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Judul Kegiatan / Agenda *</label>
                    <input type="text" name="judul" x-model="currentAgenda.judul" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Kategori Kegiatan *</label>
                        <select name="kategori" x-model="currentAgenda.kategori" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                            <option value="Latihan Band">Latihan Band</option>
                            <option value="Festival Sekolah">Festival Sekolah</option>
                            <option value="Workshop">Workshop</option>
                            <option value="Uji Kompetensi Kejuruan (UKK)">UKK Kejuruan</option>
                            <option value="Konseling">Konseling</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Status Kegiatan *</label>
                        <select name="status" x-model="currentAgenda.status" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                            <option value="Aktif">Aktif</option>
                            <option value="Persiapan">Persiapan</option>
                            <option value="Mendatang">Mendatang</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Tanggal Kegiatan *</label>
                        <input type="text" name="tanggal" x-model="currentAgenda.tanggal" required class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Jam / Waktu Pelaksanaan</label>
                        <input type="text" name="jam" x-model="currentAgenda.jam" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Lokasi Tempat</label>
                        <input type="text" name="lokasi" x-model="currentAgenda.lokasi" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Penanggung Jawab / Pembina</label>
                        <input type="text" name="penanggung_jawab" x-model="currentAgenda.penanggung_jawab" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Partisipan / Personel Siswa</label>
                    <input type="text" name="personel" x-model="currentAgenda.personel" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3">
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Catatan / Deskripsi Agenda</label>
                    <textarea name="catatan" x-model="currentAgenda.catatan" rows="2" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3"></textarea>
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
