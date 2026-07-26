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
            'nilaiTerbaru' => Nilai::with(['siswa', 'mapel'])
                ->whereIn('mapel_id', $mapelIds)
                ->latest()
                ->take(5)
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
