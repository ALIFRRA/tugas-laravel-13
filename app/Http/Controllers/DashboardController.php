<?php
class DashboardController extends Controller
{
    /** Handle an incoming request. */
    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->isAdministratorLevel()) {
            // akses dashboard pimpinan
        } elseif ($user->isGuru()) {
            return redirect()->route('guru.dashboard');
        } elseif ($user->isMurid()) {
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

        $programCount = 5; // 5 kejuruan unggulan

        $jadwalHariIni = Jadwal::with(['mapel:id,nama,guru_id', 'mapel.guru:id,nama'])
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
            'staffCount' => User::where('role', User::ROLE_STAFF)->count(),
            'agendaCount' => Agenda::count(),
            'pelanggaranCount' => Pelanggaran::count(),
            'pengumumanCount' => Pengumuman::count(),
            'canManageAcademic' => $user->isAdministratorLevel(),
            'jadwalHariIni' => $jadwalHariIni,
            'nilaiTerbaru' => Nilai::with(['siswa:id,nama', 'mapel:id,nama'])->latest()->take(5)->get(),
            'siswaTerbaru' => Siswa::latest('id')->take(20)->get(),
            'guruTerbaru' => Guru::with(['user:id,name,email,avatar', 'mataPelajarans:id,nama,guru_id'])->latest('id')->take(20)->get(),
            'agendaTerbaru' => Agenda::latest()->take(3)->get(),
            'pengumumanTerbaru' => Pengumuman::latest()->take(3)->get(),
            'pelanggaranTerbaru' => Pelanggaran::with('siswa:id,nama')->latest()->take(3)->get(),
        ]);
    }

    /** Handle an incoming request. */
    public function __invoke(Request $request): View|RedirectResponse
    {
        return $this->index($request);
    }
}