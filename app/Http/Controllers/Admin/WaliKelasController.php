<?php
/**
     * Index.
     *
     * @return public index
     */


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WaliKelasController extends Controller
{
    /**
     * kelola kelas binaan wali kelas
     */
    public function index(Request $request): View
    {
        $user = Auth::user();

        // otorisasi akses
        $canSelectKelas = $user->isAdministratorLevel() || $user->isAdmin() || $user->isStaff();
        $isGuruWaliKelas = $user->isWaliKelas();

        if (! $canSelectKelas && ! $isGuruWaliKelas) {
            abort(403, 'Akses ditolak. Halaman ini hanya untuk wali kelas dan pimpinan sekolah.');
        }

        // daftar 18 rombel resmi
        $kelasList = [
            'X-SMP-1', 'X-SMP-2', 'X-AET-1', 'X-DKV-1', 'X-RPL-1', 'X-MBE-1',
            'XI-SMP-1', 'XI-SMP-2', 'XI-AET-1', 'XI-DKV-1', 'XI-RPL-1', 'XI-MBE-1',
            'XII-SMP-1', 'XII-SMP-2', 'XII-AET-1', 'XII-DKV-1', 'XII-RPL-1', 'XII-MBE-1',
        ];

        // tentukan rombel aktif
        if ($canSelectKelas) {
            $selectedKelas = $request->query('kelas', 'X-SMP-1');
            if (! in_array($selectedKelas, $kelasList)) {
                $selectedKelas = 'X-SMP-1';
            }
        } else {
            $selectedKelas = $user->waliKelas();
        }

        // profil wali kelas
        $waliGuru = Guru::where('wali_kelas', $selectedKelas)->with('user')->first();

        // data siswa dan relasi nilai
        $siswas = Siswa::where('kelas', $selectedKelas)
            ->with(['nilais', 'nilais.mapel', 'pelanggarans'])
            ->orderBy('nama')
            ->get();

        // hitung rata-rata dan kasus bk
        $totalNilaiCount = 0;
        $totalNilaiSum = 0;
        $totalPelanggaran = 0;

        foreach ($siswas as $siswa) {
            $totalPelanggaran += $siswa->pelanggarans->count();
            foreach ($siswa->nilais as $n) {
                $totalNilaiSum += (float) $n->nilai;
                $totalNilaiCount++;
            }
        }

        $rataRataKelas = $totalNilaiCount > 0 ? round($totalNilaiSum / $totalNilaiCount, 2) : 0;

        return view('admin.walikelas.index', compact(
            'selectedKelas',
            'waliGuru',
            'siswas',
            'kelasList',
            'canSelectKelas',
            'rataRataKelas',
            'totalPelanggaran'
        ));
    }
}
