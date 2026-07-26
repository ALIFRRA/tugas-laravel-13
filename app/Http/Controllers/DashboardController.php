<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->isGuru()) {
            return redirect()->route('guru.dashboard');
        }

        if ($user->isMurid()) {
            return redirect()->route('murid.dashboard');
        }

        return view('dashboard', [
            'siswaCount' => Siswa::count(),
            'guruCount' => Guru::count(),
            'mapelCount' => MataPelajaran::count(),
            'nilaiCount' => Nilai::count(),
            'userCount' => User::whereIn('role', [User::ROLE_GURU, User::ROLE_MURID])->count(),
            'jadwalHariIni' => Jadwal::with('mapel')
                ->where('hari', [
                    1 => 'Senin',
                    2 => 'Selasa',
                    3 => 'Rabu',
                    4 => 'Kamis',
                    5 => 'Jumat',
                    6 => 'Sabtu',
                    7 => 'Minggu',
                ][now()->dayOfWeekIso])
                ->orderBy('jam_mulai')
                ->take(5)
                ->get(),
            'nilaiTerbaru' => Nilai::with(['siswa', 'mapel'])->latest()->take(5)->get(),
        ]);
    }
}
