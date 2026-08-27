<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Pelanggaran;
use App\Models\Pengumuman;
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

        $todayName = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ][now()->dayOfWeekIso] ?? 'Sabtu';

        $programCount = Siswa::query()
            ->whereNotNull('kelas')
            ->pluck('kelas')
            ->map(fn (string $kelas) => explode('-', $kelas)[1] ?? null)
            ->filter()
            ->unique()
            ->count();

        $jadwalHariIni = Jadwal::with(['mapel', 'mapel.guru'])
            ->where('hari', $todayName)
            ->orderBy('jam_mulai')
            ->get();

        return view('dashboard', [
            'siswaCount' => Siswa::count(),
            'guruCount' => Guru::count(),
            'mapelCount' => MataPelajaran::count(),
            'programCount' => $programCount,
            'nilaiCount' => Nilai::count(),
            'userCount' => User::count(),
            'agendaCount' => Agenda::count(),
            'pelanggaranCount' => Pelanggaran::count(),
            'pengumumanCount' => Pengumuman::count(),
            'canManageAcademic' => $user->isAdministratorLevel(),
            'jadwalHariIni' => $jadwalHariIni,
            'nilaiTerbaru' => Nilai::with(['siswa', 'mapel'])->latest()->take(5)->get(),
            'siswaTerbaru' => Siswa::latest('id')->take(50)->get(),
            'agendaTerbaru' => Agenda::latest()->take(3)->get(),
            'pengumumanTerbaru' => Pengumuman::latest()->take(3)->get(),
            'pelanggaranTerbaru' => Pelanggaran::with('siswa')->latest()->take(3)->get(),
        ]);
    }
}
