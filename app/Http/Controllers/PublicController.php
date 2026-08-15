<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use App\Models\Pengumuman;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicController extends Controller
{
    private function getEkskulList(): array
    {
        return [
            [
                'nama' => 'Kessoku Band (軽音楽部)',
                'nama_jp' => '軽音楽部（バンド・ポピュラー音楽）',
                'kategori' => 'Seni Musik Populer',
                'pembina' => 'Seika Ijichi (Manager STARRY) & Gin Sasaki, S.Pd.',
                'ketua' => 'Nijika Ijichi (X-SMP-2)',
                'anggota' => 28,
                'jadwal' => 'Rabu & Sabtu, 16:30 JST',
                'lokasi' => 'Livehouse STARRY Basement & Studio 1',
                'deskripsi' => 'Pengembangan teknik instrumen ensemble, komposisi lirik/melodi, live performance, dan rekaman single band.',
                'kegiatan_utama' => 'Latihan rutin band, panggung Shuka-sai, dan live show showcase.',
            ],
            [
                'nama' => 'Studio Audio & Sound Lab (音響研究部)',
                'nama_jp' => '音響・PAエンジニアリング部',
                'kategori' => 'Teknologi Audio & PA',
                'pembina' => 'PA-san, S.T., M.Kom.',
                'ketua' => 'Ryo Yamada (X-SMP-2)',
                'anggota' => 22,
                'jadwal' => 'Selasa & Kamis, 15:30 JST',
                'lokasi' => 'Lab Audio & DAW Center',
                'deskripsi' => 'Pelatihan tata suara panggung live, sound reinforcement, digital mixer console, microphoning, dan mastering.',
                'kegiatan_utama' => 'Praktik live mixing panggung, instalasi sound system, dan rekaman multitrack.',
            ],
            [
                'nama' => 'DKV Manga, Merchandise & Artwork (美術・デザイン部)',
                'nama_jp' => 'デザイン・イラスト・グッズ開発部',
                'kategori' => 'Desain Visual & Merchandise',
                'pembina' => 'Yoko Sasaki, S.Sn.',
                'ketua' => 'Hitori Gotoh (X-SMP-1)',
                'anggota' => 35,
                'jadwal' => 'Senin & Jumat, 15:30 JST',
                'lokasi' => 'Studio Desain Grafis DKV',
                'deskripsi' => 'Pembuatan merchandise resmi kaos band, stiker, pin enamel, artwork cover album vinyl, dan fotografi panggung.',
                'kegiatan_utama' => 'Pameran karya desain, produksi merchandise kreatif, dan publikasi poster festival.',
            ],
            [
                'nama' => 'Broadcasting & Podcast Shuka (放送・メディア部)',
                'nama_jp' => '放送・映像配信メディア部',
                'kategori' => 'Media & Penyiaran',
                'pembina' => 'Hiroshi Tanaka, M.I.Kom.',
                'ketua' => 'Ikuyo Kita (X-SMP-1)',
                'anggota' => 26,
                'jadwal' => 'Kamis & Sabtu, 14:00 JST',
                'lokasi' => 'Studio Siaran Shuka Live',
                'deskripsi' => 'Produksi podcast radio sekolah "Guitarhero Room", video live streaming event, dan social media creative.',
                'kegiatan_utama' => 'Live streaming festival, wawancara musisi tamu, dan publikasi buletin mingguan.',
            ],
            [
                'nama' => 'STARRY Cafe & Hospitality (カフェ・調理部)',
                'nama_jp' => 'カフェ運営・ホスピタリティ研究部',
                'kategori' => 'Hospitality & Kuliner',
                'pembina' => 'Michiyo Gotoh, S.Pd.',
                'ketua' => 'Futari Gotoh (X-SMP-1)',
                'anggota' => 30,
                'jadwal' => 'Rabu, 15:30 JST',
                'lokasi' => 'Dapur Praktik Tata Boga',
                'deskripsi' => 'Keterampilan barista, peracikan mocktail khas event, dan manajemen booth cafe livehouse saat festival.',
                'kegiatan_utama' => 'Pengelolaan booth cafe Shuka-sai dan kreasi minuman bertema seni musik.',
            ],
            [
                'nama' => 'Web Dev & Audio Software Lab (情報技術部)',
                'nama_jp' => '情報技術・ソフトウェア開発部',
                'kategori' => 'Teknologi Informasi',
                'pembina' => 'Daisuke Suzuki, M.Kom.',
                'ketua' => 'Shinji Yamamoto (X-RPL-1)',
                'anggota' => 24,
                'jadwal' => 'Senin & Kamis, 15:30 JST',
                'lokasi' => 'Lab Komputer RPL',
                'deskripsi' => 'Pengembangan portal sistem informasi akademik sekolah, audio synthesizer berbasis web, dan basis data.',
                'kegiatan_utama' => 'Coding portal web, pembuatan plugin audio DSP, dan pemeliharaan server.',
            ],
            [
                'nama' => 'Fotografi Panggung & Jurnalistik (写真部)',
                'nama_jp' => 'ライブ写真・報道写真部',
                'kategori' => 'Jurnalistik Foto',
                'pembina' => 'Akiko Matsumoto, S.Pd.',
                'ketua' => 'Yoyoko Ohtsuki (XI-SMP-1)',
                'anggota' => 19,
                'jadwal' => 'Jumat, 15:00 JST',
                'lokasi' => 'Ruang Redaksi Foto Shuka',
                'deskripsi' => 'Liputan konser live panggung, teknik pencahayaan low-light panggung musik, dan buletin visual.',
                'kegiatan_utama' => 'Dokumentasi konser live, pameran foto panggung, dan galeri majalah dinding.',
            ],
            [
                'nama' => 'Stage Lighting & Tata Cahaya (舞台照明部)',
                'nama_jp' => '舞台照明・DMXエンジニアリング部',
                'kategori' => 'Teknik Panggung',
                'pembina' => 'Naoki Gotoh, M.Sc.',
                'ketua' => 'Eliza Shimizu (XI-AET-1)',
                'anggota' => 18,
                'jadwal' => 'Selasa, 16:00 JST',
                'lokasi' => 'Auditorium & Gymnasium',
                'deskripsi' => 'DMX512 lighting console, laser synchronization, moving heads, dan efek visual panggung konser.',
                'kegiatan_utama' => 'Pengoperasian tata cahaya konser festival dan instalasi pencahayaan panggung.',
            ],
            [
                'nama' => 'Paduan Suara & Vokal Harmoni (合唱部)',
                'nama_jp' => '合唱・ヴォーカルアンサンブル部',
                'kategori' => 'Seni Vokal',
                'pembina' => 'Kikuri Hiroi, S.Sn.',
                'ketua' => 'Shima Iwashita (XI-SMP-2)',
                'anggota' => 32,
                'jadwal' => 'Rabu & Jumat, 15:30 JST',
                'lokasi' => 'Ruang Akustik Vokal',
                'deskripsi' => 'Pelatihan teknik pernapasan vokal diafragma, solfeggio harmoni 4 suara, dan ensemble vokal.',
                'kegiatan_utama' => 'Paduan suara upacara dan konser resital musik vokal.',
            ],
            [
                'nama' => 'Cosplay & Teater Musikal (演劇・コスプレ部)',
                'nama_jp' => '演劇・舞台表現研究部',
                'kategori' => 'Seni Peran & Karakter',
                'pembina' => 'Kaori Watanabe, S.Pd.',
                'ketua' => 'Akebi Hasegawa (XI-DKV-1)',
                'anggota' => 25,
                'jadwal' => 'Kamis, 15:30 JST',
                'lokasi' => 'Aula Teater Shuka',
                'deskripsi' => 'Tata panggung drama musikal, perancangan kostum karakter, makeup panggung, dan olah vokal peran.',
                'kegiatan_utama' => 'Pementasan drama musikal tahunan Shuka-sai.',
            ],
            [
                'nama' => 'Badminton & Stamina Panggung (バドミントン部)',
                'nama_jp' => 'バドミントン・体力づくり部',
                'kategori' => 'Olahraga & Kebugaran',
                'pembina' => 'Jimihen Sensei, M.M.',
                'ketua' => 'Takumi Kato (X-RPL-1)',
                'anggota' => 40,
                'jadwal' => 'Senin & Sabtu, 08:00 JST',
                'lokasi' => 'Gelanggang Olahraga',
                'deskripsi' => 'Pembinaan kebugaran jasmani, ketahanan stamina pemain band konser live, dan turnamen olahraga antar kelas.',
                'kegiatan_utama' => 'Latihan fisik stamina panggung dan turnamen bulutangkis.',
            ],
            [
                'nama' => 'Japanese Culture & Sastra Modern (日本文化・文芸部)',
                'nama_jp' => '日本文化・作詞文芸研究部',
                'kategori' => 'Bahasa & Budaya',
                'pembina' => 'Michiyo Gotoh, S.Pd.',
                'ketua' => 'Kana Koyama (XI-SMP-2)',
                'anggota' => 20,
                'jadwal' => 'Selasa, 15:00 JST',
                'lokasi' => 'Perpustakaan Lt. 2',
                'deskripsi' => 'Penulisan lirik lagu puisi modern, apresiasi literatur Jepang, dan penulisan skenario pertunjukan.',
                'kegiatan_utama' => 'Workshop lirik lagu dan publikasi antologi puisi siswa.',
            ],
        ];
    }

    public function index(): View
    {
        return view('public.home', [
            'siswaCount' => Siswa::count(),
            'guruCount' => Guru::count(),
            'mapelCount' => MataPelajaran::count(),
            'jadwalCount' => Jadwal::count(),
            'gurus' => Guru::with('user')->take(6)->get(),
            'agendas' => Agenda::where('status', '!=', 'Selesai')->latest()->take(4)->get(),
            'pengumumans' => Pengumuman::active()->latest()->take(3)->get(),
            'ekskuls' => array_slice($this->getEkskulList(), 0, 6),
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
        $query = Guru::query()->with('user');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('mata_pelajaran', 'like', "%{$search}%");
            });
        }

        $gurus = $query->orderBy('nama')->paginate(16)->withQueryString();

        return view('public.guru', compact('gurus'));
    }

    public function ekskul(): View
    {
        return view('public.ekskul', [
            'ekskuls' => $this->getEkskulList(),
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
