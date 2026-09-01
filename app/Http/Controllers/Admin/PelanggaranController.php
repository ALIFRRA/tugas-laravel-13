<?php
/**
     * Destroy.
     *
     * @return public destroy
     */

    /**
     * Update.
     *
     * @return public update
     */

    /**
     * Store.
     *
     * @return public store
     */

    /**
     * Index.
     *
     * @return public index
     */


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PelanggaranController extends Controller
{
    /**
     * menampilkan daftar rekapitulasi kedisiplinan dan sanksi siswa
     */
    public function index(Request $request): View
    {
        $query = Pelanggaran::with('siswa');
        $user = $request->user();

        // filter kelas khusus jika dipilih
        if ($request->filled('kelas') && $request->input('kelas') !== 'all') {
            $kelas = $request->input('kelas');
            $query->whereHas('siswa', fn ($sq) => $sq->where('kelas', $kelas));
        }

        // filter siswa spesifik
        if ($request->filled('siswa_id')) {
            $query->where('siswa_id', $request->integer('siswa_id'));
        }

        // filter kategori pelanggaran
        if ($request->filled('kategori') && $request->input('kategori') !== 'all') {
            $query->where('kategori', $request->input('kategori'));
        }

        // filter status tindak lanjut
        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        // pencarian multi-kriteria
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('jenis_pelanggaran', 'like', "%{$search}%")
                    ->orWhere('sanksi', 'like', "%{$search}%")
                    ->orWhere('guru_pencatat', 'like', "%{$search}%")
                    ->orWhereHas('siswa', function ($sq) use ($search) {
                        $sq->where('nama', 'like', "%{$search}%")
                            ->orWhere('nis', 'like', "%{$search}%")
                            ->orWhere('kelas', 'like', "%{$search}%");
                    });
            });
        }

        $pelanggarans = $query->latest('tanggal')->paginate(15)->withQueryString();

        // daftar siswa untuk modal input pelanggaran baru
        $siswas = Siswa::query()->orderBy('kelas')->orderBy('nama')->get(['id', 'nama', 'nis', 'kelas']);

        // ringkasan metrik statistik kedisiplinan sekolah
        $totalPelanggaran = Pelanggaran::count();
        $ringanCount = Pelanggaran::where('kategori', 'Ringan')->count();
        $sedangCount = Pelanggaran::where('kategori', 'Sedang')->count();
        $beratCount = Pelanggaran::where('kategori', 'Berat')->count();
        $dalamPembinaanCount = Pelanggaran::where('status', 'Dalam Pembinaan')->count();

        return view('admin.pelanggaran.index', compact(
            'pelanggarans',
            'siswas',
            'totalPelanggaran',
            'ringanCount',
            'sedangCount',
            'beratCount',
            'dalamPembinaanCount'
        ));
    }

    /**
     * menyimpan data catatan pelanggaran baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'siswa_id' => ['required', 'exists:siswas,id'],
            'jenis_pelanggaran' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'in:Ringan,Sedang,Berat'],
            'poin' => ['required', 'integer', 'min:1', 'max:100'],
            'sanksi' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'string', 'max:100'],
            'guru_pencatat' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:Dalam Pembinaan,Selesai,Ditindaklanjuti'],
            'catatan' => ['nullable', 'string'],
        ]);

        $validated['guru_pencatat'] = $validated['guru_pencatat'] ?? auth()->user()->name ?? 'Tim Kesiswaan';

        Pelanggaran::create($validated);

        return redirect()
            ->route('admin.pelanggaran.index')
            ->with('success', 'Catatan pelanggaran kesiswaan berhasil dicatat.');
    }

    /**
     * memperbarui data catatan pelanggaran
     */
    public function update(Request $request, Pelanggaran $pelanggaran): RedirectResponse
    {
        $validated = $request->validate([
            'siswa_id' => ['required', 'exists:siswas,id'],
            'jenis_pelanggaran' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'in:Ringan,Sedang,Berat'],
            'poin' => ['required', 'integer', 'min:1', 'max:100'],
            'sanksi' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'string', 'max:100'],
            'guru_pencatat' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:Dalam Pembinaan,Selesai,Ditindaklanjuti'],
            'catatan' => ['nullable', 'string'],
        ]);

        $pelanggaran->update($validated);

        return redirect()
            ->route('admin.pelanggaran.index')
            ->with('success', 'Catatan kedisiplinan berhasil diperbarui.');
    }

    /**
     * menghapus catatan pelanggaran
     */
    public function destroy(Pelanggaran $pelanggaran): RedirectResponse
    {
        $pelanggaran->delete();

        return redirect()
            ->route('admin.pelanggaran.index')
            ->with('success', 'Data pelanggaran berhasil dihapus.');
    }
}
