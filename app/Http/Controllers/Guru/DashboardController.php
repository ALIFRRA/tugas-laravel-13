<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $guru = $this->guru($request);

        $mapelIds = $guru->mataPelajarans()->pluck('id');
        $nilaiQuery = Nilai::query()->whereIn('mapel_id', $mapelIds);

        $kelasList = Jadwal::query()
            ->whereIn('mapel_id', $mapelIds)
            ->select('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        return view('guru.dashboard', [
            'guru' => $guru,
            'mapelCount' => $mapelIds->count(),
            'nilaiCount' => (clone $nilaiQuery)->count(),
            'rataRata' => round((float) (clone $nilaiQuery)->avg('nilai'), 2),
            'mapels' => $guru->mataPelajarans()->withCount('nilais')->orderBy('nama')->get(),
            'kelasList' => $kelasList,
            'nilaiRingkasan' => Nilai::query()
                ->select('mapel_id')
                ->selectRaw('COUNT(*) as total_nilai')
                ->selectRaw('ROUND(AVG(nilai), 2) as rata_rata')
                ->with('mapel')
                ->whereIn('mapel_id', $mapelIds)
                ->groupBy('mapel_id')
                ->orderByDesc('total_nilai')
                ->get(),
        ]);
    }

    private function guru(Request $request): Guru
    {
        $guru = $request->user()->guru;

        abort_unless($guru, 403, 'Profil guru belum terhubung ke akun ini.');

        return $guru->load('mataPelajarans');
    }
}