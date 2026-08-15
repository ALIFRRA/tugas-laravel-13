<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EkskulController extends Controller
{
    public function index(Request $request): View
    {
        $ekskulList = [
            [
                'nama' => 'Kessoku Band (Klub Musik & Band)',
                'kategori' => 'Seni Musik',
                'pembina' => 'Seika Ijichi (Manager STARRY) & Gin Sasaki, S.Pd.',
                'ketua' => 'Nijika Ijichi (X-SMP-2)',
                'anggota' => 28,
                'jadwal' => 'Rabu & Sabtu, 16:30 JST',
                'lokasi' => 'Livehouse STARRY Basement',
                'deskripsi' => 'Fokus pada aransemen lagu rock/indie, perform panggung, dan rekaman single band sekolah.',
                'badge' => 'Prioritas Utama',
            ],
            [
                'nama' => 'Studio Audio & Sound Reinforcement',
                'kategori' => 'Teknologi Suara',
                'pembina' => 'PA-san, S.T., M.Kom.',
                'ketua' => 'Ryo Yamada (X-SMP-2)',
                'anggota' => 22,
                'jadwal' => 'Selasa & Kamis, 15:30 JST',
                'lokasi' => 'Lab Audio & DAW Center',
                'deskripsi' => 'Pengoperasian digital mixer, microphoning, acoustic testing, dan live sound reinforcement.',
                'badge' => 'Kejuruan AET',
            ],
            [
                'nama' => 'DKV Manga, Merchandise & Album Art',
                'kategori' => 'Desain & Seni Rupa',
                'pembina' => 'Yoko Sasaki, S.Sn.',
                'ketua' => 'Hitori Gotoh (X-SMP-1)',
                'anggota' => 35,
                'jadwal' => 'Senin & Jumat, 15:30 JST',
                'lokasi' => 'Studio Desain Grafis DKV',
                'deskripsi' => 'Pembuatan desain merchandise kaos, stiker, cover album vinyl, dan poster festival.',
                'badge' => 'Kejuruan DKV',
            ],
            [
                'nama' => 'Broadcasting, Podcast & Live Streaming',
                'kategori' => 'Media & Penyiaran',
                'pembina' => 'Hiroshi Tanaka, M.I.Kom.',
                'ketua' => 'Ikuyo Kita (X-SMP-1)',
                'anggota' => 26,
                'jadwal' => 'Kamis & Sabtu, 14:00 JST',
                'lokasi' => 'Studio Siaran Shuka Live',
                'deskripsi' => 'Produksi podcast sekolah "Guitarhero Room", video live streaming event, dan social media marketing.',
                'badge' => 'Kejuruan MBE',
            ],
            [
                'nama' => 'STARRY Culinary & Cafe Management',
                'kategori' => 'Hospitality & Kuliner',
                'pembina' => 'Michiyo Gotoh, S.Pd.',
                'ketua' => 'Futari Gotoh (X-SMP-1)',
                'anggota' => 30,
                'jadwal' => 'Rabu, 15:30 JST',
                'lokasi' => 'Dapur Praktek Tata Boga',
                'deskripsi' => 'Manajemen hospitality cafe live house, barista drinks, dan booth kuliner festival Shuka-sai.',
                'badge' => 'Hospitality',
            ],
            [
                'nama' => 'Web Development & Audio Software Lab',
                'kategori' => 'Teknologi Informasi',
                'pembina' => 'Daisuke Suzuki, M.Kom.',
                'ketua' => 'Shinji Yamamoto (X-RPL-1)',
                'anggota' => 24,
                'jadwal' => 'Senin & Kamis, 15:30 JST',
                'lokasi' => 'Lab Komputer RPL',
                'deskripsi' => 'Pengembangan portal sistem informasi akademik sekolah dan plugin audio DSP berbasis web.',
                'badge' => 'Kejuruan RPL',
            ],
            [
                'nama' => 'Fotografi Panggung & Jurnalistik',
                'kategori' => 'Jurnalistik',
                'pembina' => 'Akiko Matsumoto, S.Pd.',
                'ketua' => 'Yoyoko Ohtsuki (XI-SMP-1)',
                'anggota' => 19,
                'jadwal' => 'Jumat, 15:00 JST',
                'lokasi' => 'Ruang Redaksi Shuka',
                'deskripsi' => 'Liputan konser live, jurnalisme musik indie, dan publikasi buletin berkala Shuka Post.',
                'badge' => 'Media',
            ],
            [
                'nama' => 'Stage Lighting & Tata Cahaya Konser',
                'kategori' => 'Teknik Panggung',
                'pembina' => 'Naoki Gotoh, M.Sc.',
                'ketua' => 'Eliza Shimizu (XI-AET-1)',
                'anggota' => 18,
                'jadwal' => 'Selasa, 16:00 JST',
                'lokasi' => 'Gymnasium / Panggung Shuka',
                'deskripsi' => 'DMX512 lighting console, laser synchronization, moving heads, dan efek panggung visual.',
                'badge' => 'Teknik Panggung',
            ],
            [
                'nama' => 'Paduan Suara & Vokal Harmoni',
                'kategori' => 'Seni Vokal',
                'pembina' => 'Kikuri Hiroi, S.Sn.',
                'ketua' => 'Shima Iwashita (XI-SMP-2)',
                'anggota' => 32,
                'jadwal' => 'Rabu & Jumat, 15:30 JST',
                'lokasi' => 'Ruang Akustik Vokal',
                'deskripsi' => 'Pelatihan teknik pernapasan diafragma, solfeggio, harmoni vokal 4 suara, dan ensemble.',
                'badge' => 'Seni Vokal',
            ],
            [
                'nama' => 'Cosplay & Teater Pertunjukan',
                'kategori' => 'Seni Peran',
                'pembina' => 'Kaori Watanabe, S.Pd.',
                'ketua' => 'Akebi Hasegawa (XI-DKV-1)',
                'anggota' => 25,
                'jadwal' => 'Kamis, 15:30 JST',
                'lokasi' => 'Aula Teater Shuka',
                'deskripsi' => 'Tata panggung drama musikal, perancangan kostum karakter, dan ekspresi panggung.',
                'badge' => 'Seni Peran',
            ],
            [
                'nama' => 'Badminton & Stamina Panggung',
                'kategori' => 'Olahraga & Kebugaran',
                'pembina' => 'Jimihen Sensei, M.M.',
                'ketua' => 'Takumi Kato (X-RPL-1)',
                'anggota' => 40,
                'jadwal' => 'Senin & Sabtu, 08:00 JST',
                'lokasi' => 'Gelanggang Olahraga',
                'deskripsi' => 'Pembinaan kebugaran jasmani, ketahanan stamina pemain band konser, dan turnamen olahraga.',
                'badge' => 'Olahraga',
            ],
            [
                'nama' => 'Japanese Culture & Sastra Modern',
                'kategori' => 'Bahasa & Budaya',
                'pembina' => 'Michiyo Gotoh, S.Pd.',
                'ketua' => 'Kana Koyama (XI-SMP-2)',
                'anggota' => 20,
                'jadwal' => 'Selasa, 15:00 JST',
                'lokasi' => 'Perpustakaan Lt. 2',
                'deskripsi' => 'Penulisan lirik puisi lagu modern, apresiasi literatur Jepang, dan penulisan skenario.',
                'badge' => 'Sastra',
            ],
        ];

        $inventarisAlat = [
            ['nama' => 'Gibson Les Paul Custom ' . '68 Reissue (Black Beauty)', 'kategori' => 'Gitar Listrik', 'pemilik' => 'Inventaris Khusus / Hitori', 'kondisi' => 'Sangat Baik', 'status' => 'Dipakai'],
            ['nama' => 'Fender Junior Collection Telecaster (Fiesta Red)', 'kategori' => 'Gitar Listrik', 'pemilik' => 'Ikuyo Kita', 'kondisi' => 'Sangat Baik', 'status' => 'Dipakai'],
            ['nama' => 'Fender Precision Bass (Olympic White)', 'kategori' => 'Bass Listrik', 'pemilik' => 'Ryo Yamada', 'kondisi' => 'Sangat Baik', 'status' => 'Dipakai'],
            ['nama' => 'Yamada Custom Drum Kit + Paiste Cymbals', 'kategori' => 'Drum Set', 'pemilik' => 'Nijika Ijichi / STARRY', 'kondisi' => 'Sangat Baik', 'status' => 'Tersedia di Studio'],
            ['nama' => 'Marshall JCM900 Lead 1960 Amp Head + Cabinet', 'kategori' => 'Amplifier', 'pemilik' => 'Studio Musik Shuka', 'kondisi' => 'Baik', 'status' => 'Tersedia'],
            ['nama' => 'Yamaha THR30II Wireless Amplifier & Shure SM58 Mic Set', 'kategori' => 'Audio System', 'pemilik' => 'Lab Audio', 'kondisi' => 'Sangat Baik', 'status' => 'Tersedia'],
        ];

        return view('admin.ekskul.index', compact('ekskulList', 'inventarisAlat'));
    }
}
