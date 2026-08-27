<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Ekskul;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Pengumuman;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicController extends Controller
{
    private function getTeacherQuotes(): array
    {
        return [
            [
                'text' => 'Musik bukan hanya tentang nada, tapi tentang jiwa yang berbicara melalui melodi.',
                'author' => 'Gin Sasaki, S.Pd.',
                'role' => 'Wakil Kepala Sekolah Bidang Kesiswaan',
                'avatar' => 'bocchi-maid'
            ],
            [
                'text' => 'Sound engineering adalah seni mengubah suara menjadi emosi yang tersentuh hati pendengar.',
                'author' => 'PA-san, S.T., M.Kom.',
                'role' => 'Wakil Kepala Sekolah Bidang Kurikulum & IT',
                'avatar' => 'bocchi-shy'
            ],
            [
                'text' => 'Desain visual yang baik tidak hanya indah, tapi bercerita dan menggerakkan hati.',
                'author' => 'Yoko Sasaki, S.Sn.',
                'role' => 'Pembina DKV & Desain Merchandise',
                'avatar' => 'bocchi'
            ],
            [
                'text' => 'Kode yang bersih adalah puisi bagi mesin, dan fondasi bagi inovasi teknologi.',
                'author' => 'Daisuke Suzuki, M.Kom.',
                'role' => 'Pembina Web Dev & Audio Software Lab',
                'avatar' => 'bocchi-shy'
            ],
            [
                'text' => 'Manajemen event adalah orkestrasi di balik layar agar panggung bersinar maksimal.',
                'author' => 'Michiyo Gotoh, S.Pd.',
                'role' => 'Pembina STARRY Cafe & Hospitality',
                'avatar' => 'bocchi'
            ]
        ];
    }

    /** Featured alumni are editorial content, not student records. */
    private function getFeaturedAlumni(): array
    {
        return [
            ['nama' => 'Mio Tanaka', 'jurusan' => 'SMP', 'pencapaian' => 'Gitaris tur nasional', 'avatar' => 'mio-tanaka'],
            ['nama' => 'Ren Aoki', 'jurusan' => 'AET', 'pencapaian' => 'Sound engineer studio', 'avatar' => 'ren-aoki'],
            ['nama' => 'Sora Miyazaki', 'jurusan' => 'DKV', 'pencapaian' => 'Ilustrator cover album', 'avatar' => 'sora-miyazaki'],
            ['nama' => 'Hana Watanabe', 'jurusan' => 'RPL', 'pencapaian' => 'Pengembang aplikasi kreatif', 'avatar' => 'hana-watanabe'],
            ['nama' => 'Kaito Sato', 'jurusan' => 'MBE', 'pencapaian' => 'Manajer produksi event', 'avatar' => 'kaito-sato'],
        ];
    }

    public function index(): View
    {
        $teacherQuotes = $this->getTeacherQuotes();
        $programCount = Siswa::query()
            ->whereNotNull('kelas')
            ->pluck('kelas')
            ->map(fn (string $kelas) => explode('-', $kelas)[1] ?? null)
            ->filter()
            ->unique()
            ->count();

        // Get top 5 students by average grade (current students)
        $topStudents = Siswa::with(['user', 'nilais'])
            ->where('kelas', 'not like', '%Lulus%')
            ->whereHas('nilais')
            ->get()
            ->map(function ($siswa) {
                $avgNilai = $siswa->nilais->avg('nilai');
                return [
                    'siswa' => $siswa,
                    'avg_nilai' => $avgNilai ? round($avgNilai, 1) : 0,
                    'nilai_count' => $siswa->nilais->count(),
                ];
            })
            ->sortByDesc('avg_nilai')
            ->take(5)
            ->values();

        $topAlumni = $this->getFeaturedAlumni();
        $staff = User::query()
            ->where('role', User::ROLE_STAFF)
            ->orderBy('jabatan')
            ->get();

        // Get high achieving current students (with awards/prestasi - using high grades as proxy)
        $highAchievers = Siswa::with(['user', 'nilais'])
            ->where('kelas', 'not like', '%Lulus%')
            ->whereHas('nilais')
            ->get()
            ->filter(function ($siswa) {
                $avgNilai = $siswa->nilais->avg('nilai');
                return $avgNilai >= 95;
            })
            ->map(function ($siswa) {
                $avgNilai = $siswa->nilais->avg('nilai');
                return [
                    'siswa' => $siswa,
                    'avg_nilai' => round($avgNilai, 1),
                ];
            })
            ->sortByDesc('avg_nilai')
            ->take(5)
            ->values();

        // Fallback empty collections if no data
        if ($highAchievers->isEmpty()) {
            $highAchievers = collect();
        }
        return view('public.home', [
            'siswaCount' => Siswa::count(),
            'guruCount' => Guru::count(),
            'staffCount' => $staff->count(),
            'tenagaCount' => Guru::count() + $staff->count(),
            'mapelCount' => MataPelajaran::count(),
            'programCount' => $programCount,
            'ekskulCount' => Ekskul::active()->count(),
            'jadwalCount' => Jadwal::count(),
            'gurus' => Guru::with(['user', 'mataPelajarans'])->whereHas('mataPelajarans')->take(6)->get(),
            'staff' => $staff,
            'agendas' => Agenda::where('status', '!=', 'Selesai')->latest()->take(4)->get(),
            'pengumumans' => Pengumuman::active()->latest()->take(3)->get(),
            'ekskuls' => Ekskul::active()->withCount('siswas')->take(6)->get(),
            'teacherQuotes' => $teacherQuotes,
            'topStudents' => $topStudents,
            'topAlumni' => $topAlumni,
            'highAchievers' => $highAchievers,
        ]);
    }

    public function profil(): View
    {
        return view('public.profil', [
            'siswaCount' => Siswa::count(),
            'guruCount' => Guru::count(),
            'mapelCount' => MataPelajaran::count(),
        ]);
    }

    public function jurusan(): View
    {
        return view('public.jurusan', [
            'mapels' => MataPelajaran::with('guru')->get(),
        ]);
    }

    public function guru(Request $request): View
    {
        $query = Guru::query()->with(['user', 'mataPelajarans']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhereHas('mataPelajarans', function ($mapelQuery) use ($search) {
                      $mapelQuery->where('nama', 'like', "%{$search}%")
                          ->orWhere('kode', 'like', "%{$search}%");
                  });
            });
        }

        $gurus = $query->orderBy('nama')->paginate(16)->withQueryString();
        $staff = User::query()
            ->where('role', User::ROLE_STAFF)
            ->orderBy('jabatan')
            ->get();

        return view('public.guru', compact('gurus', 'staff'));
    }

    public function ekskul(): View
    {
        return view('public.ekskul', [
            'ekskuls' => Ekskul::active()->withCount('siswas')->get(),
        ]);
    }

    public function agenda(Request $request): View
    {
        $queryAgenda = Agenda::query();
        if ($request->filled('kategori') && $request->input('kategori') !== 'all') {
            $queryAgenda->where('kategori', $request->input('kategori'));
        }
        $agendas = $queryAgenda->latest()->paginate(10)->withQueryString();

        $pengumumans = Pengumuman::active()->latest()->take(6)->get();

        return view('public.agenda', compact('agendas', 'pengumumans'));
    }

    public function kontak(): View
    {
        return view('public.kontak');
    }
}
