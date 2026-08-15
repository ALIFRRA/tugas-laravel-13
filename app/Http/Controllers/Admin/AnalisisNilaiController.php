<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AnalisisNilaiController extends Controller
{
    public function index(Request $request)
    {
        $selectedKelas = $request->get('kelas', 'all');

        $siswaQuery = Siswa::with(['nilais.mapel']);
        if ($selectedKelas !== 'all') {
            $siswaQuery->where('kelas', $selectedKelas);
        }

        $allSiswa = $siswaQuery->get();

        // Calculate rankings
        $leaderboard = $allSiswa->map(function ($s) {
            $avg = $s->nilais->avg('nilai') ?? 0;
            return [
                'siswa' => $s,
                'rata_rata' => round($avg, 2),
                'total_nilai' => $s->nilais->count(),
            ];
        })->sortByDesc('rata_rata')->values();

        $kelasList = Siswa::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');

        $overallAverage = round(Nilai::avg('nilai') ?? 86.8, 1);
        $totalNilaiCount = Nilai::count();
        $totalSiswaCount = Siswa::count();

        // Distribution brackets
        $distA = Nilai::where('nilai', '>=', 90)->count();
        $distB = Nilai::whereBetween('nilai', [80, 89.9])->count();
        $distC = Nilai::whereBetween('nilai', [70, 79.9])->count();
        $distD = Nilai::where('nilai', '<', 70)->count();

        $mapels = MataPelajaran::withCount('nilais')->with('guru')->get();

        return view('admin.nilai.analisis', compact(
            'leaderboard',
            'kelasList',
            'selectedKelas',
            'overallAverage',
            'totalNilaiCount',
            'totalSiswaCount',
            'distA',
            'distB',
            'distC',
            'distD',
            'mapels'
        ));
    }

    public function exportCsv()
    {
        $fileName = 'rekap_nilai_shuka_highschool_' . date('Ymd_His') . '.csv';

        $response = new StreamedResponse(function () {
            $handle = fopen('php://output', 'w');
            // Add UTF-8 BOM
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, ['NIS', 'Nama Murid', 'Kelas', 'Jenis Kelamin', 'Mata Pelajaran', 'Jenis Nilai', 'Nilai Angka', 'Predikat']);

            Nilai::with(['siswa', 'mapel'])->chunk(200, function ($nilais) use ($handle) {
                foreach ($nilais as $n) {
                    $predikat = 'D';
                    if ($n->nilai >= 90) $predikat = 'A (Sangat Baik)';
                    elseif ($n->nilai >= 80) $predikat = 'B (Baik)';
                    elseif ($n->nilai >= 70) $predikat = 'C (Cukup)';

                    fputcsv($handle, [
                        $n->siswa->nis ?? '-',
                        $n->siswa->nama ?? '-',
                        $n->siswa->kelas ?? '-',
                        $n->siswa->jenis_kelamin ?? '-',
                        $n->mapel->nama ?? '-',
                        $n->jenis_nilai ?? '-',
                        $n->nilai,
                        $predikat,
                    ]);
                }
            });

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', "attachment; filename=\"{$fileName}\"");

        return $response;
    }
}
