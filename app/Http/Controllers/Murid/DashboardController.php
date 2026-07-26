<?php

namespace App\Http\Controllers\Murid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user()->load(['siswa.nilais.mapel']);
        $siswa = $user->siswa;

        $nilais = $siswa?->nilais()->with('mapel')->latest()->get() ?? collect();

        return view('murid.dashboard', [
            'user' => $user,
            'siswa' => $siswa,
            'nilais' => $nilais,
            'rataRata' => $nilais->avg('nilai'),
            'tertinggi' => $nilais->max('nilai'),
            'terendah' => $nilais->min('nilai'),
            'mapelCount' => $nilais->pluck('mapel_id')->unique()->count(),
        ]);
    }
}
