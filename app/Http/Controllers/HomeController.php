<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use App\Models\Pengumuman;
use App\Models\Siswa;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $ekskulList = [
            [
                'nama' => 'Kessoku Band (Klub Musik & Band)',
                'kategori' => 'Seni Musik Populer',
                'pembina' => 'Seika Ijichi (Manager STARRY) & Gin Sasaki, S.Pd.',
                'jadwal' => 'Rabu & Sabtu, 16:30 JST',
                'lokasi' => 'Livehouse STARRY Basement',
                'deskripsi' => 'Fokus pada komposisi aransemen lagu rock/indie, persiapan perform panggung, dan rekaman single band.',
                'kegiatan_utama' => 'Latihan rutin band, panggung Shuka-sai, dan live show showcase.',
            ],
            [
                'nama' => 'Studio Audio & Sound Reinforcement',
                'kategori' => 'Teknologi Audio',
                'pembina' => 'PA-san, S.T., M.Kom.',
                'jadwal' => 'Selasa & Kamis, 15:30 JST',
                'lokasi' => 'Lab Audio & DAW Center',
                'deskripsi' => 'Pelatihan tata suara konser live, pengoperasian digital mixer soundboard, microphoning, dan mastering.',
                'kegiatan_utama' => 'Praktik live mixing panggung, instalasi sound system, dan rekaman multitrack.',
            ],
            [
                'nama' => 'DKV Manga, Merchandise & Cover Art',
                'kategori' => 'Desain Komunikasi Visual',
                'pembina' => 'Yoko Sasaki, S.Sn.',
                'jadwal' => 'Senin & Jumat, 15:30 JST',
                'lokasi' => 'Studio Desain Grafis DKV',
                'deskripsi' => 'Perancangan merchandise resmi band (kaos, stiker, pin), cover album vinyl, dan media promosi konser.',
                'kegiatan_utama' => 'Pameran karya desain, produksi sablon merchandise, dan publikasi poster festival.',
            ],
            [
                'nama' => 'Broadcasting & Podcast Live Shuka',
                'kategori' => 'Media & Penyiaran',
                'pembina' => 'Hiroshi Tanaka, M.I.Kom.',
                'jadwal' => 'Kamis & Sabtu, 14:00 JST',
                'lokasi' => 'Studio Siaran Shuka Live',
                'deskripsi' => 'Produksi podcast radio sekolah "Guitarhero Room", video live streaming, serta liputan jurnalistik.',
                'kegiatan_utama' => 'Live streaming festival, wawancara musisi tamu, dan podcast mingguan.',
            ],
            [
                'nama' => 'STARRY Culinary & Cafe Management',
                'kategori' => 'Hospitality & Kuliner',
                'pembina' => 'Michiyo Gotoh, S.Pd.',
                'jadwal' => 'Rabu, 15:30 JST',
                'lokasi' => 'Dapur Praktik Tata Boga',
                'deskripsi' => 'Keterampilan barista, manajemen hospitality cafe livehouse, dan penyajian kuliner festival.',
                'kegiatan_utama' => 'Pengelolaan booth cafe Shuka-sai dan pelatihan kreasi minuman khas band.',
            ],
            [
                'nama' => 'Web Development & Audio Software Lab',
                'kategori' => 'Teknologi Informasi',
                'pembina' => 'Daisuke Suzuki, M.Kom.',
                'jadwal' => 'Senin & Kamis, 15:30 JST',
                'lokasi' => 'Lab Komputer RPL',
                'deskripsi' => 'Pengembangan portal sistem informasi akademik sekolah dan aplikasi synthesizer musik digital.',
                'kegiatan_utama' => 'Coding portal web, pembuatan plugin efek gitar web-audio, dan maintenance database.',
            ],
        ];

        return view('home', [
            'siswaCount' => Siswa::count(),
            'guruCount' => Guru::count(),
            'mapelCount' => MataPelajaran::count(),
            'jadwalCount' => Jadwal::count(),
            'gurus' => Guru::with('user')->take(8)->get(),
            'agendas' => Agenda::where('status', '!=', 'Selesai')->latest()->take(4)->get(),
            'pengumumans' => Pengumuman::active()->latest()->take(3)->get(),
            'ekskuls' => $ekskulList,
        ]);
    }
}
