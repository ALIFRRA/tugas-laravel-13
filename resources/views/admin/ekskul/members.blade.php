@extends('layouts.admin')

@section('title', 'Kelola Anggota - {{ $ekskul->nama }} — SMK Shuka')
@section('heading', 'Anggota Klub')
@section('subheading', '{{ $ekskul->nama }} - Kelola keanggotaan siswa')

@section('content')
<div class="space-y-6">

    <!-- Header Info -->
    <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-pink-100 text-pink-600 rounded-xl flex items-center justify-center font-bold text-xl border border-pink-200 shrink-0">
                    {{ strtoupper(substr($ekskul->nama, 0, 2)) }}
                </div>
                <div>
                    <h3 class="font-bold text-slate-800">{{ $ekskul->nama }}</h3>
                    <p class="text-xs text-slate-500">{{ $ekskul->kategori }} • {{ $ekskul->siswas_count ?? 0 }} Anggota</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.ekskul.show', $ekskul) }}" class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-300 rounded hover:bg-slate-50 transition-colors">
                    Kembali ke Detail
                </a>
                <button type="button" onclick="openAddMemberModal()" class="px-3 py-1.5 bg-pink-500 hover:bg-pink-600 text-white font-semibold text-xs rounded transition-colors shadow-sm inline-flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Anggota</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Members Table -->
    <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <h3 class="text-sm font-bold text-slate-900">Daftar Anggota ({{ $ekskul->siswas_count ?? 0 }} Siswa)</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-semibold uppercase tracking-wider sticky top-0 bg-slate-50 z-10">
                        <th class="py-2.5 px-4">NIS</th>
                        <th class="py-2.5 px-4">Nama Siswa</th>
                        <th class="py-2.5 px-4">Kelas / Jurusan</th>
                        <th class="py-2.5 px-4 text-center">L/P</th>
                        <th class="py-2.5 px-4">Posisi</th>
                        <th class="py-2.5 px-4">Tahun Bergabung</th>
                        <th class="py-2.5 px-4 text-center">Status</th>
                        <th class="py-2.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($ekskul->siswas as $siswa)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-2.5 px-4 font-mono font-semibold text-slate-600">{{ $siswa->nis }}</td>
                            <td class="py-2.5 px-4 font-bold text-slate-900">{{ $siswa->nama }}</td>
                            <td class="py-2.5 px-4">
                                <span class="inline-block px-1.5 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200 text-[11px] font-semibold">
                                    {{ $siswa->kelas }}
                                </span>
                            </td>
                            <td class="py-2.5 px-4 text-center">
                                <span class="inline-block px-1.5 py-0.5 text-[10px] font-semibold rounded {{ $siswa->jenis_kelamin === 'P' ? 'bg-pink-50 text-pink-700 border border-pink-200' : 'bg-sky-50 text-sky-700 border border-sky-200' }}">
                                    {{ $siswa->jenis_kelamin }}
                                </span>
                            </td>
                            <td class="py-2.5 px-4">
                                <span class="inline-block px-2 py-0.5 rounded text-[11px] font-semibold {{ $siswa->pivot->posisi === 'Ketua' ? 'bg-pink-50 text-pink-700 border border-pink-200' : ($siswa->pivot->posisi === 'Wakil Ketua' ? 'bg-sky-50 text-sky-700 border border-sky-200' : 'bg-slate-50 text-slate-700 border border-slate-200') }}">
                                    {{ $siswa->pivot->posisi ?? 'Anggota' }}
                                </span>
                            </td>
                            <td class="py-2.5 px-4 text-center font-mono text-slate-600">{{ $siswa->pivot->tahun_bergabung ?? '—' }}</td>
                            <td class="py-2.5 px-4 text-center">
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold {{ $siswa->pivot->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                                    {{ $siswa->pivot->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td class="py-2.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button type="button" onclick="openEditPositionModal({{ $siswa->id }}, '{{ $siswa->pivot->posisi ?? 'Anggota' }}')" class="px-2 py-1 text-[11px] font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-300 rounded transition-colors">
                                        Edit Posisi
                                    </button>
                                    <form action="{{ route('admin.ekskul.remove-member', [$ekskul, $siswa]) }}" method="POST" onsubmit="return confirm('Hapus anggota ini dari klub?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 text-[11px] font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-8 text-center text-slate-400">Belum ada anggota di klub ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-3 bg-slate-50 border-t border-slate-200 text-center">
            <a href="{{ route('admin.ekskul.show', $ekskul) }}" class="text-xs font-semibold text-pink-600 hover:text-pink-700">← Kembali ke Detail Klub</a>
        </div>
    </div>

</div>

<!-- Add Member Modal -->
<div id="addMemberModal" class="fixed inset-0 z-50 hidden overflow-y-auto" x-data="{ open: false }">
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeMemberModals()"></div>
    <div class="relative mx-auto my-20 max-w-md bg-white rounded-lg shadow-xl" @click.outside="open = false">
        <form method="POST" action="{{ route('admin.ekskul.add-member', $ekskul) }}">
            @csrf
            <div class="p-5 border-b border-slate-200 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Tambah Anggota ke {{ $ekskul->nama }}</h3>
                <button type="button" onclick="closeMemberModals()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <!-- komponen pencarian siswa -->
                <x-siswa-picker :siswas="$siswas" label="Pilih Siswa Calon Anggota" />
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Posisi</label>
                    <select name="posisi" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3 bg-white">
                        <option value="Anggota">Anggota</option>
                        <option value="Ketua">Ketua</option>
                        <option value="Wakil Ketua">Wakil Ketua</option>
                        <option value="Sekretaris">Sekretaris</option>
                        <option value="Bendahara">Bendahara</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tahun Bergabung</label>
                    <input type="number" name="tahun_bergabung" value="{{ now()->year }}" min="2020" max="2030" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3 bg-white" />
                </div>
            </div>
            <div class="p-5 border-t border-slate-200 flex justify-end gap-2">
                <button type="button" onclick="closeMemberModals()" class="px-3 py-2 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded">Batal</button>
                <button type="submit" class="px-3 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold text-xs rounded">Tambah Anggota</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Position Modal -->
<div id="editPositionModal" class="fixed inset-0 z-50 hidden overflow-y-auto" x-data="{ open: false, siswaId: null, currentPosition: '' }">
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeMemberModals()"></div>
    <div class="relative mx-auto my-20 max-w-md bg-white rounded-lg shadow-xl" @click.outside="open = false">
        <form method="POST" action="">
            @csrf
            @method('PUT')
            <div class="p-5 border-b border-slate-200 flex items-center justify-between">
                <h3 class="font-bold text-slate-800">Edit Posisi Anggota</h3>
                <button type="button" onclick="closeMemberModals()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <input type="hidden" name="siswa_id" x-ref="siswaIdInput">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Posisi Baru</label>
                    <select name="posisi" x-ref="positionSelect" class="w-full text-xs rounded border-slate-300 focus:border-pink-500 focus:ring-pink-500 py-2 px-3 bg-white">
                        <option value="Anggota">Anggota</option>
                        <option value="Ketua">Ketua</option>
                        <option value="Wakil Ketua">Wakil Ketua</option>
                        <option value="Sekretaris">Sekretaris</option>
                        <option value="Bendahara">Bendahara</option>
                    </select>
                </div>
            </div>
            <div class="p-5 border-t border-slate-200 flex justify-end gap-2">
                <button type="button" onclick="closeMemberModals()" class="px-3 py-2 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded">Batal</button>
                <button type="submit" class="px-3 py-2 bg-pink-500 hover:bg-pink-600 text-white font-semibold text-xs rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddMemberModal() {
        document.getElementById('addMemberModal').classList.remove('hidden');
    }

    function closeMemberModals() {
        document.getElementById('addMemberModal').classList.add('hidden');
        document.getElementById('editPositionModal').classList.add('hidden');
    }

    function openEditPositionModal(siswaId, currentPosition) {
        const modal = document.getElementById('editPositionModal');
        modal.classList.remove('hidden');
        modal.querySelector('[x-ref="siswaIdInput"]').value = siswaId;
        modal.querySelector('[x-ref="positionSelect"]').value = currentPosition;
        modal.querySelector('form').action = `{{ route('admin.ekskul.update-member', [$ekskul, ':siswaId']) }}`.replace(':siswaId', siswaId);
    }
</script>
@endsection
