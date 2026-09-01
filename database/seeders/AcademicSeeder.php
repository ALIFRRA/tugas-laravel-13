<?php
/**
     * Run.
     *
     * @return public run
     */


namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\Ekskul;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Pelanggaran;
use App\Models\Pengumuman;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AcademicSeeder extends Seeder
{
    public function run(): void
    {
        // reset tabel
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Pelanggaran::truncate();
            Pengumuman::truncate();
            Agenda::truncate();
            Nilai::truncate();
            Jadwal::truncate();
            DB::table('ekskul_siswa')->truncate();
            Ekskul::truncate();
            Siswa::truncate();
            MataPelajaran::truncate();
            Guru::truncate();
            User::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } else {
            Pelanggaran::query()->delete();
            Pengumuman::query()->delete();
            Agenda::query()->delete();
            Nilai::query()->delete();
            Jadwal::query()->delete();
            DB::table('ekskul_siswa')->delete();
            Ekskul::query()->delete();
            Siswa::query()->delete();
            MataPelajaran::query()->delete();
            Guru::query()->delete();
            User::query()->delete();
        }

        $avatars = [
            'https://api.dicebear.com/9.x/bottts/svg?seed=hitori-gotoh&backgroundColor=ffe7f3',
            'https://api.dicebear.com/9.x/icons/svg?seed=ikuyo-kita&backgroundColor=fce7f3',
            'https://api.dicebear.com/9.x/shapes/svg?seed=nijika-ijichi&backgroundColor=f3e8ff',
            'https://api.dicebear.com/9.x/identicon/svg?seed=ryo-yamada&backgroundColor=e0f2fe',
            'https://api.dicebear.com/9.x/thumbs/svg?seed=seika-ijichi&backgroundColor=dcfce7',
            'https://api.dicebear.com/9.x/fun-emoji/svg?seed=futari-gotoh&backgroundColor=ffe7f3',
            'https://api.dicebear.com/9.x/bottts/svg?seed=kikuri-hiroi&backgroundColor=fef3c7',
            'https://api.dicebear.com/9.x/icons/svg?seed=yoyoko-ohtsuki&backgroundColor=fce7f3',
            'https://api.dicebear.com/9.x/shapes/svg?seed=eliza-shimizu&backgroundColor=e0f2fe',
            'https://api.dicebear.com/9.x/rings/svg?seed=pa-san&backgroundColor=f3e8ff',
        ];
        $password = Hash::make('password');

        // akun admin
        $admin = User::create([
            'email' => 'admin@shuka.test',
            'name' => 'Hitori Admin',
            'password' => $password,
            'email_verified_at' => now(),
            'avatar' => 'https://api.dicebear.com/9.x/bottts/svg?seed=hitori-gotoh&backgroundColor=ffe7f3',
            'role' => User::ROLE_ADMIN,
            'jabatan' => 'Super Administrator SIA',
        ]);

        // staf tenaga kependidikan & tu
        $staffMembers = [
            [
                'email' => 'tu@shuka.test',
                'name' => 'Erika Sasaki, S.AP.',
                'avatar' => 'https://api.dicebear.com/9.x/icons/svg?seed=tu-erika&backgroundColor=ffe7f3',
                'jabatan' => 'Kepala Tata Usaha & Administrasi',
            ],
            [
                'email' => 'it@shuka.test',
                'name' => 'Daisuke Suzuki, M.Kom.',
                'avatar' => 'https://api.dicebear.com/9.x/bottts/svg?seed=daisuke-suzuki&backgroundColor=ffe7f3',
                'jabatan' => 'Staf TU Bagian IT & Administrator Sistem',
            ],
            [
                'email' => 'kesiswaan@shuka.test',
                'name' => 'Kazutoshi Sawada, S.Sos.',
                'avatar' => 'https://api.dicebear.com/9.x/shapes/svg?seed=kazutoshi-sawada&backgroundColor=ffe7f3',
                'jabatan' => 'Staf TU Kesiswaan & Kedisiplinan',
            ],
            [
                'email' => 'koperasi@shuka.test',
                'name' => 'Yoko Yoshida, A.Md.',
                'avatar' => 'https://api.dicebear.com/9.x/thumbs/svg?seed=yoko-yoshida&backgroundColor=ffe7f3',
                'jabatan' => 'Pengelola Koperasi Sekolah & Sarpras',
            ],
            [
                'email' => 'studio@shuka.test',
                'name' => 'Kenji Ishida, S.T.',
                'avatar' => 'https://api.dicebear.com/9.x/icons/svg?seed=kenji-ishida&backgroundColor=ffe7f3',
                'jabatan' => 'Teknisi Studio STARRY & Lab Audio',
            ],
        ];

        foreach ($staffMembers as $staff) {
            User::create([
                'email' => $staff['email'],
                'name' => $staff['name'],
                'password' => $password,
                'email_verified_at' => now(),
                'avatar' => $staff['avatar'],
                'role' => User::ROLE_STAFF,
                'jabatan' => $staff['jabatan'],
            ]);
        }

        // data guru dan staf pengajar
        $easterEggTeachers = [
            ['name' => 'Seika Ijichi, S.Sn., M.Pd.', 'email' => 'seika@shuka.test', 'nip' => '198504122008012001', 'mapel' => 'Manajemen Event & Livehouse STARRY', 'phone' => '0812-3344-9001', 'avatar' => 'https://api.dicebear.com/9.x/bottts/svg?seed=seika-ijichi&backgroundColor=ffe7f3', 'jabatan' => 'Kepala Sekolah & Pembina STARRY'],
            ['name' => 'PA-san, S.T., M.Kom.', 'email' => 'pasan@shuka.test', 'nip' => '198809222010012002', 'mapel' => 'Audio Engineering & Live Sound Mixing', 'phone' => '0812-3344-9002', 'avatar' => 'https://api.dicebear.com/9.x/icons/svg?seed=pa-san&backgroundColor=ffe7f3', 'jabatan' => 'Wakil Kepala Sekolah Bidang Kurikulum & IT'],
            ['name' => 'Gin Sasaki, S.Pd.', 'email' => 'sasaki@shuka.test', 'nip' => '198205152005011003', 'mapel' => 'Seni Musik Populer: Gitar & Vokal', 'phone' => '0812-3344-9003', 'avatar' => 'https://api.dicebear.com/9.x/shapes/svg?seed=gin-sasaki&backgroundColor=ffe7f3', 'jabatan' => 'Wakil Kepala Sekolah Bidang Kesiswaan'],
            ['name' => 'Naoki Gotoh, M.Sc.', 'email' => 'naoki@shuka.test', 'nip' => '198001102003011004', 'mapel' => 'Fisika Gelombang Akustik & Bunyi', 'phone' => '0812-3344-9004', 'avatar' => 'https://api.dicebear.com/9.x/bottts/svg?seed=naoki-gotoh&backgroundColor=ffe7f3', 'jabatan' => 'Guru Fisika & Akustik'],
            ['name' => 'Michiyo Gotoh, S.Pd.', 'email' => 'michiyo@shuka.test', 'nip' => '198103192004012005', 'mapel' => 'Bahasa Jepang & Lirik Lagu', 'phone' => '0812-3344-9005', 'avatar' => 'https://api.dicebear.com/9.x/fun-emoji/svg?seed=michiyo-gotoh&backgroundColor=ffe7f3', 'jabatan' => 'Guru Bahasa Jepang'],
            ['name' => 'Jimihen Sensei, M.M.', 'email' => 'jimihen@shuka.test', 'nip' => '197906202002011006', 'mapel' => 'Pendidikan Jasmani & Kebugaran Panggung', 'phone' => '0812-3344-9006', 'avatar' => 'https://api.dicebear.com/9.x/thumbs/svg?seed=jimihen&backgroundColor=ffe7f3', 'jabatan' => 'Guru PJOK & Pelatih Fisik'],
            ['name' => 'Kikuri Hiroi, S.Sn.', 'email' => 'kikuri@shuka.test', 'nip' => '198711302011012007', 'mapel' => 'Harmoni Bass Eksperimental & Slap', 'phone' => '0812-3344-9007', 'avatar' => 'https://api.dicebear.com/9.x/bottts/svg?seed=kikuri-hiroi&backgroundColor=ffe7f3', 'jabatan' => 'Guru Tamu Spesialis Bass'],
        ];

        $teacherFirstNames = ['Kenji', 'Daisuke', 'Satoshi', 'Hiroshi', 'Takumi', 'Kazuki', 'Yuji', 'Shinji', 'Taro', 'Ryota', 'Emi', 'Yoko', 'Ayumi', 'Kaori', 'Mayumi', 'Shizuka', 'Tomoko', 'Akiko', 'Noriko', 'Keiko'];
        $teacherLastNames = ['Tanaka', 'Sato', 'Suzuki', 'Takahashi', 'Watanabe', 'Ito', 'Yamamoto', 'Nakamura', 'Kobayashi', 'Kato', 'Yoshida', 'Yamada', 'Sasaki', 'Yamaguchi', 'Saito', 'Matsumoto', 'Inoue', 'Kimura', 'Hayashi', 'Shimizu'];

        $guruModels = [];

        foreach ($easterEggTeachers as $gt) {
            $user = User::create([
                'name' => $gt['name'],
                'email' => $gt['email'],
                'password' => $password,
                'email_verified_at' => now(),
                'avatar' => $gt['avatar'],
                'role' => $gt['email'] === 'seika@shuka.test' ? User::ROLE_ADMIN : User::ROLE_GURU,
                'jabatan' => $gt['jabatan'] ?? 'Tenaga Pendidik (Guru)',
            ]);

            $guruModels[] = Guru::create([
                'user_id' => $user->id,
                'nama' => $gt['name'],
                'nip' => $gt['nip'],
                'no_telepon' => $gt['phone'],
            ]);
        }

        // pemetaan 18 guru wali kelas
        $waliKelasMap = [
            10 => 'X-SMP-1', // yoshida emi, s.pd.
            11 => 'X-SMP-2',
            12 => 'X-AET-1',
            13 => 'X-DKV-1',
            14 => 'X-RPL-1',
            15 => 'X-MBE-1',
            16 => 'XI-SMP-1',
            17 => 'XI-SMP-2',
            18 => 'XI-AET-1',
            19 => 'XI-DKV-1',
            20 => 'XI-RPL-1',
            21 => 'XI-MBE-1',
            22 => 'XII-SMP-1',
            23 => 'XII-SMP-2',
            24 => 'XII-AET-1',
            25 => 'XII-DKV-1',
            26 => 'XII-RPL-1',
            27 => 'XII-MBE-1',
        ];

        for ($i = count($guruModels) + 1; $i <= 45; $i++) {
            $fname = $teacherFirstNames[$i % count($teacherFirstNames)];
            $lname = $teacherLastNames[($i * 3) % count($teacherLastNames)];
            $name = "{$lname} {$fname}, S.Pd.";
            $email = "guru{$i}@shuka.test";

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'email_verified_at' => now(),
                'avatar' => $avatars[$i % count($avatars)],
                'role' => User::ROLE_GURU,
                'jabatan' => isset($waliKelasMap[$i]) ? 'Tenaga Pendidik & Wali Kelas ' . $waliKelasMap[$i] : 'Tenaga Pendidik (Guru)',
            ]);

            $guruModels[] = Guru::create([
                'user_id' => $user->id,
                'nama' => $name,
                'nip' => '198' . (70 + ($i % 25)) . sprintf('%04d', $i) . '200' . ($i % 9) . '01',
                'no_telepon' => '0812-8899-' . (1000 + $i),
                'wali_kelas' => $waliKelasMap[$i] ?? null,
            ]);
        }

        // data mata pelajaran
        $subjectNames = [
            ['code' => 'SMK-SMP01', 'name' => 'Seni Musik Populer: Gitar & Melodi', 'sks' => 3],
            ['code' => 'SMK-SMP02', 'name' => 'Seni Musik Populer: Bass & Drum', 'sks' => 3],
            ['code' => 'SMK-SMP03', 'name' => 'Harmoni & Aransemen Band Panggung', 'sks' => 3],
            ['code' => 'SMK-AET01', 'name' => 'Audio Engineering & Live Sound Mixing', 'sks' => 3],
            ['code' => 'SMK-AET02', 'name' => 'Digital Audio Workstation & Mastering Studio', 'sks' => 3],
            ['code' => 'SMK-AET03', 'name' => 'Akustik Ruang & Sound Reinforcement', 'sks' => 2],
            ['code' => 'SMK-DKV01', 'name' => 'Desain Grafis Digital & Merchandise Band', 'sks' => 3],
            ['code' => 'SMK-DKV02', 'name' => 'Ilustrasi Karakter & Cover Album Art', 'sks' => 2],
            ['code' => 'SMK-DKV03', 'name' => 'Fotografi Panggung & Videografi Konser', 'sks' => 2],
            ['code' => 'SMK-RPL01', 'name' => 'Rekayasa Perangkat Lunak & Web Portal SIA', 'sks' => 3],
            ['code' => 'SMK-RPL02', 'name' => 'Pemrograman Audio & Sistem Basis Data', 'sks' => 3],
            ['code' => 'SMK-MBE01', 'name' => 'Manajemen Pertunjukan & Live Event', 'sks' => 2],
            ['code' => 'SMK-MBE02', 'name' => 'Pemasaran Media Kreatif & Promosi Band', 'sks' => 2],
            ['code' => 'SMK-MBE03', 'name' => 'Hospitality & Manajemen Cafe STARRY', 'sks' => 2],
            ['code' => 'SMK-MAT01', 'name' => 'Matematika Terapan Kejuruan X', 'sks' => 4],
            ['code' => 'SMK-MAT02', 'name' => 'Matematika Terapan Kejuruan XI', 'sks' => 4],
            ['code' => 'SMK-MAT03', 'name' => 'Kalkulus & Statistik Terapan XII', 'sks' => 4],
            ['code' => 'SMK-FIS01', 'name' => 'Fisika Gelombang Akustik & Bunyi', 'sks' => 3],
            ['code' => 'SMK-KIM01', 'name' => 'Kimia Bahan Elektronika Musik', 'sks' => 2],
            ['code' => 'SMK-JPN01', 'name' => 'Bahasa Jepang Komunikasi & Sastra', 'sks' => 3],
            ['code' => 'SMK-JPN02', 'name' => 'Bahasa Jepang Industri & Lirik Lagu', 'sks' => 2],
            ['code' => 'SMK-ING01', 'name' => 'Bahasa Inggris Bisnis & Industri Kreatif', 'sks' => 3],
            ['code' => 'SMK-SEJ01', 'name' => 'Sejarah Modern & Industri Musik Dunia', 'sks' => 2],
            ['code' => 'SMK-SOS01', 'name' => 'Sosiologi Komunitas Kreatif', 'sks' => 2],
            ['code' => 'SMK-OR01',  'name' => 'Pendidikan Jasmani & Kebugaran Panggung', 'sks' => 2],
            ['code' => 'SMK-PKN01', 'name' => 'Pendidikan Pancasila & Etika Profesi', 'sks' => 2],
            ['code' => 'SMK-AGM01', 'name' => 'Pendidikan Etika & Budi Pekerti', 'sks' => 2],
            ['code' => 'SMK-BK01',  'name' => 'Bimbingan Karier Industri Musik & Konseling', 'sks' => 1],
        ];

        $additionalSubjectNames = [
            ['code' => 'SMK-SMP04', 'name' => 'Teknik Vokal Panggung & Interpretasi Lagu'],
            ['code' => 'SMK-AET04', 'name' => 'Microphone Placement & Recording Session'],
            ['code' => 'SMK-AET05', 'name' => 'Post Production Audio & Sound Editing'],
            ['code' => 'SMK-DKV04', 'name' => 'Tipografi & Identitas Visual Musisi'],
            ['code' => 'SMK-DKV05', 'name' => 'Motion Graphic untuk Promosi Konser'],
            ['code' => 'SMK-RPL03', 'name' => 'Pemrograman Backend & Integrasi API'],
            ['code' => 'SMK-RPL04', 'name' => 'UI/UX Design untuk Produk Digital Kreatif'],
            ['code' => 'SMK-MBE04', 'name' => 'Produksi Panggung & Manajemen Venue'],
            ['code' => 'SMK-MBE05', 'name' => 'Administrasi Keuangan Event Kreatif'],
            ['code' => 'SMK-UMU01', 'name' => 'Bahasa Indonesia Profesional'],
            ['code' => 'SMK-UMU02', 'name' => 'Bahasa Inggris Presentasi & Public Speaking'],
            ['code' => 'SMK-UMU03', 'name' => 'Pendidikan Agama & Karakter Profesi'],
            ['code' => 'SMK-UMU04', 'name' => 'Kewirausahaan Industri Kreatif'],
            ['code' => 'SMK-UMU05', 'name' => 'Pendidikan Kewarganegaraan'],
            ['code' => 'SMK-UMU06', 'name' => 'Seni Pertunjukan & Apresiasi Budaya'],
            ['code' => 'SMK-UMU07', 'name' => 'Keselamatan Kerja Studio & Panggung'],
            ['code' => 'SMK-UMU08', 'name' => 'Proyek Kolaborasi Lintas Keahlian'],
        ];

        foreach ($additionalSubjectNames as $subject) {
            $subjectNames[] = [...$subject, 'sks' => 2];
        }

        $mapelModels = [];
        foreach ($subjectNames as $idx => $s) {
            $guru = $guruModels[$idx % count($guruModels)];
            $mapelModels[] = MataPelajaran::create([
                'kode' => $s['code'],
                'nama' => $s['name'],
                'guru_id' => $guru->id,
            ]);
        }

        // data siswa aktif
        $easterEggStudents = [
            ['name' => 'Hitori Gotoh (後藤 ひとり)', 'kelas' => 'X-SMP-1', 'gender' => 'P', 'alamat' => 'Yokohama / Shimokitazawa'],
            ['name' => 'Ikuyo Kita (喜多 郁代)', 'kelas' => 'X-SMP-1', 'gender' => 'P', 'alamat' => 'Tokyo / Shimokitazawa'],
            ['name' => 'Nijika Ijichi (伊地知 虹夏)', 'kelas' => 'X-SMP-2', 'gender' => 'P', 'alamat' => 'Livehouse STARRY, Shimokitazawa'],
            ['name' => 'Ryo Yamada (山田 リョウ)', 'kelas' => 'X-SMP-2', 'gender' => 'P', 'alamat' => 'Shimokitazawa, Tokyo'],
            ['name' => 'Futari Gotoh (後藤 ふたり)', 'kelas' => 'X-SMP-1', 'gender' => 'P', 'alamat' => 'Yokohama'],
            ['name' => 'Yoyoko Ohtsuki (大槻 ヨヨコ)', 'kelas' => 'XI-SMP-1', 'gender' => 'P', 'alamat' => 'Shinjuku, Tokyo'],
            ['name' => 'Eliza Shimizu', 'kelas' => 'XI-AET-1', 'gender' => 'P', 'alamat' => 'Shinjuku, Tokyo'],
            ['name' => 'Shima Iwashita', 'kelas' => 'XI-SMP-2', 'gender' => 'P', 'alamat' => 'Shinjuku, Tokyo'],
            ['name' => 'Akebi Hasegawa', 'kelas' => 'XI-DKV-1', 'gender' => 'P', 'alamat' => 'Shinjuku, Tokyo'],
            ['name' => 'Fumi Honjo', 'kelas' => 'XI-RPL-1', 'gender' => 'P', 'alamat' => 'Shinjuku, Tokyo'],
            ['name' => 'Kana Koyama', 'kelas' => 'XI-MBE-1', 'gender' => 'P', 'alamat' => 'Shinjuku, Tokyo'],
        ];

        $studentPoolF = [
            'Aoi', 'Hina', 'Yui', 'Mio', 'Ritsu', 'Tsumugi', 'Azusa', 'Akari', 'Mei', 'Sakura',
            'Koharu', 'Nanami', 'Rin', 'Kanna', 'Chika', 'Honoka', 'Kotori', 'Umi', 'Maki', 'Nozomi',
            'Ayaka', 'Haruka', 'Misaki', 'Sora', 'Yuna', 'Momoka', 'Saki', 'Kaede', 'Chihiro', 'Yuki',
            'Kana', 'Shiori', 'Rena', 'Miku', 'Miyu', 'Sayaka', 'Erika', 'Natsuki', 'Riko', 'Yuriko',
            'Megumi', 'Rei', 'Asuka', 'Hinata', 'Kagami', 'Tsukasa', 'Tomoyo', 'Nagisa', 'Kyouko', 'Madoka'
        ];

        $studentPoolM = [
            'Ren', 'Haruto', 'Sota', 'Yuto', 'Riku', 'Kaito', 'Asahi', 'Taiki', 'Daiki', 'Kensuke',
            'Shin', 'Shota', 'Kazuma', 'Takashi', 'Hayato', 'Minato', 'Ryusei', 'Koki', 'Yuuki', 'Sho',
            'Kenta', 'Ryo', 'Hiroto', 'Tatsuya', 'Kohei', 'Masaki', 'Tomoya', 'Kento', 'Shunsuke', 'Yuma',
            'Keisuke', 'Naoto', 'Taiga', 'Kazuya', 'Sosuke', 'Katsuki', 'Kenji', 'Shinji', 'Taro', 'Ryota',
            'Arata', 'Itsuki', 'Shoma', 'Haruki', 'Sora', 'Gaku', 'Kazuki', 'Yamato', 'Soma', 'Reo'
        ];

        $studentLastNames = [
            'Sato', 'Suzuki', 'Takahashi', 'Tanaka', 'Watanabe', 'Ito', 'Yamamoto', 'Nakamura', 'Kobayashi', 'Kato',
            'Yoshida', 'Yamada', 'Sasaki', 'Yamaguchi', 'Saito', 'Matsumoto', 'Inoue', 'Kimura', 'Hayashi', 'Shimizu',
            'Yamazaki', 'Mori', 'Abe', 'Ikeda', 'Hashimoto', 'Yamashita', 'Ishikawa', 'Nakajima', 'Maeda', 'Fujita',
            'Ogawa', 'Goto', 'Okada', 'Hasegawa', 'Murakami', 'Kondo', 'Ishii', 'Sakamoto', 'Endo', 'Aoki',
            'Fujii', 'Nishimura', 'Fukuda', 'Ota', 'Miura', 'Fujiwara', 'Okamoto', 'Matsuda', 'Nakagawa', 'Harada'
        ];

        // 18 rombel kelas
        $kelasList = [
            'X-SMP-1', 'X-SMP-2', 'X-AET-1', 'X-DKV-1', 'X-RPL-1', 'X-MBE-1',
            'XI-SMP-1', 'XI-SMP-2', 'XI-AET-1', 'XI-DKV-1', 'XI-RPL-1', 'XI-MBE-1',
            'XII-SMP-1', 'XII-SMP-2', 'XII-AET-1', 'XII-DKV-1', 'XII-RPL-1', 'XII-MBE-1'
        ];
        $alamatList = ['Shimokitazawa', 'Tokyo', 'Shibuya', 'Kichijoji', 'Nakano', 'Shinjuku', 'Yokohama', 'Setagaya', 'Suginami'];

        $usedNames = [];
        foreach ($easterEggStudents as $idx => $st) {
            $usedNames[$st['name']] = true;
            $email = "student" . ($idx + 1) . "@murid.shuka.test";
            $user = User::create([
                'name' => $st['name'],
                'email' => $email,
                'password' => $password,
                'email_verified_at' => now(),
                'avatar' => $avatars[$idx % count($avatars)],
                'role' => User::ROLE_MURID,
            ]);

            $siswaModels[] = Siswa::create([
                'user_id' => $user->id,
                'nama' => $st['name'],
                'nis' => sprintf('2026%04d', $idx + 1),
                'kelas' => $st['kelas'],
                'jenis_kelamin' => $st['gender'],
                'alamat' => $st['alamat'],
                'tanggal_lahir' => now()->subYears(16)->toDateString(),
            ]);
        }

        // generate siswa reguler dengan nama 100% unik
        for ($i = count($siswaModels) + 1; $i <= 590; $i++) {
            $isFemale = ($i % 2 === 0);
            $pool = $isFemale ? $studentPoolF : $studentPoolM;

            // cari kombinasi nama unik tanpa duplikasi
            $attempt = 0;
            do {
                $fIdx = ($i * 7 + $attempt * 3 + (int) floor($i / 13)) % count($pool);
                $lIdx = ($i * 19 + $attempt * 11 + (int) floor($i / 7)) % count($studentLastNames);
                $fname = $pool[$fIdx];
                $lname = $studentLastNames[$lIdx];
                $name = "{$lname} {$fname}";
                $attempt++;
            } while (isset($usedNames[$name]) && $attempt < 300);

            $usedNames[$name] = true;
            $kelas = $kelasList[$i % count($kelasList)];
            $alamat = $alamatList[$i % count($alamatList)];

            $user = User::create([
                'name' => $name,
                'email' => "murid{$i}@shuka.test",
                'password' => $password,
                'email_verified_at' => now(),
                'avatar' => $avatars[$i % count($avatars)],
                'role' => User::ROLE_MURID,
            ]);
            $userId = $user->id;

            $siswaModels[] = Siswa::create([
                'user_id' => $userId,
                'nama' => $name,
                'nis' => sprintf('2026%04d', $i),
                'kelas' => $kelas,
                'jenis_kelamin' => $isFemale ? 'P' : 'L',
                'alamat' => $alamat,
                'tanggal_lahir' => now()->subYears(15 + ($i % 3))->subDays($i * 5)->toDateString(),
            ]);
        }

        // 4b. Seed Top 5 Alumni Berprestasi (Lulusan Terbaik)
        $topAlumni = [
            [
                'name' => 'Yamamoto Aiko',
                'email' => 'alumni.yamamoto@shuka.test',
                'nis' => '20230001',
                'kelas' => 'XII-SMP-1 (Lulus 2025)',
                'jenis_kelamin' => 'P',
                'alamat' => 'Tokyo, Setagaya',
                'tanggal_lahir' => '2007-04-15',
                'avatar' => 'bocchi',
                'prestasi' => 'Juara 1 Festival Musik Nasional 2025, Debut Single "Hikari" di Spotify Top 50 Japan',
                'penghargaan' => 'Gold Medal Festival Musik Nasional, Best New Artist AMI Awards 2025',
                'rata_rata' => 98.5,
            ],
            [
                'name' => 'Tanaka Ren',
                'email' => 'alumni.tanaka@shuka.test',
                'nis' => '20230002',
                'kelas' => 'XII-AET-1 (Lulus 2025)',
                'jenis_kelamin' => 'L',
                'alamat' => 'Yokohama',
                'tanggal_lahir' => '2007-08-22',
                'avatar' => 'bocchi-shy',
                'prestasi' => 'Sound Engineer untuk Album Indie "Neon Dreams", Nominasi Best Mixing Engineer AMI Awards 2025',
                'penghargaan' => 'Best Audio Engineering Student 2025, Internship di Sony Music Japan',
                'rata_rata' => 97.8,
            ],
            [
                'name' => 'Sato Hana',
                'email' => 'alumni.sato@shuka.test',
                'nis' => '20230003',
                'kelas' => 'XII-DKV-1 (Lulus 2025)',
                'jenis_kelamin' => 'P',
                'alamat' => 'Shibuya',
                'tanggal_lahir' => '2007-11-03',
                'avatar' => 'bocchi-maid',
                'prestasi' => 'Designer Merchandise Band "After School", Kolaborasi dengan UNIQLO UT x Anime 2025',
                'penghargaan' => 'Best Visual Design Student, Kontrak Freelance di Studio Ghibli',
                'rata_rata' => 97.2,
            ],
            [
                'name' => 'Suzuki Kaito',
                'email' => 'alumni.suzuki@shuka.test',
                'nis' => '20230004',
                'kelas' => 'XII-RPL-1 (Lulus 2025)',
                'jenis_kelamin' => 'L',
                'alamat' => 'Shinjuku',
                'tanggal_lahir' => '2007-02-18',
                'avatar' => 'bocchi',
                'prestasi' => 'Fullstack Developer di Startup AI Music "Harmony Labs", Pemilik Patent Audio DSP Real-time',
                'penghargaan' => 'Young Innovator Award 2025, Beasiswa Monbukagakusho Jepang',
                'rata_rata' => 96.9,
            ],
            [
                'name' => 'Watanabe Mei',
                'email' => 'alumni.watanabe@shuka.test',
                'nis' => '20230005',
                'kelas' => 'XII-MBE-1 (Lulus 2025)',
                'jenis_kelamin' => 'P',
                'alamat' => 'Kichijoji',
                'tanggal_lahir' => '2007-06-30',
                'avatar' => 'bocchi-shy',
                'prestasi' => 'Event Manager Festival "Tokyo Indie Wave 2025", Mengelola 50+ Artis & 10.000 Penonton',
                'penghargaan' => 'Best Event Management Student, Magang di Live Nation Japan',
                'rata_rata' => 96.5,
            ],
        ];

        // siswa berprestasi
        $highAchievers = [
            ['name' => 'Kimura Yuki', 'kelas' => 'XII-SMP-1', 'gender' => 'P', 'nilai' => 99.2, 'prestasi' => 'Juara 1 Solo Gitar Festival Shuka-sai 2026', 'penghargaan' => 'Best Guitarist Award, Scholarship Yamaha Music'],
            ['name' => 'Sato Haruki', 'kelas' => 'XII-AET-1', 'gender' => 'L', 'nilai' => 98.7, 'prestasi' => 'Best Live Mix Engineer Shuka-sai 2026', 'penghargaan' => 'Pro Tools Certification, Internship di Avex Studio'],
            ['name' => 'Tanaka Mei', 'kelas' => 'XII-DKV-1', 'gender' => 'P', 'nilai' => 98.3, 'prestasi' => 'Desain Poster Resmi Shuka-sai 2026 Terpilih', 'penghargaan' => 'Adobe Certified Professional, Freelance untuk Band Indie'],
            ['name' => 'Yamamoto Ken', 'kelas' => 'XII-RPL-1', 'gender' => 'L', 'nilai' => 97.9, 'prestasi' => 'Membangun Portal Alumni SMK Shuka v2.0', 'penghargaan' => 'Hackathon Winner Tokyo Tech 2026, GitHub Student Developer'],
            ['name' => 'Watanabe Sora', 'kelas' => 'XII-MBE-1', 'gender' => 'P', 'nilai' => 97.5, 'prestasi' => 'Project Manager Festival Shuka-sai 2026', 'penghargaan' => 'Leadership Award, Magang di Live Nation Japan'],
            ['name' => 'Suzuki Rina', 'kelas' => 'XI-SMP-2', 'gender' => 'P', 'nilai' => 99.0, 'prestasi' => 'Juara 2 Vokal Solo Kompetisi Antar SMK Se-Jabodetabek', 'penghargaan' => 'Vocal Excellence Scholarship'],
            ['name' => 'Nakamura Daiki', 'kelas' => 'XI-AET-1', 'gender' => 'L', 'nilai' => 98.5, 'prestasi' => 'Sound Design Game Indie "Echoes of Shibuya"', 'penghargaan' => 'Unity Audio Implementation Certified'],
            ['name' => 'Kobayashi Yui', 'kelas' => 'XI-DKV-1', 'gender' => 'P', 'nilai' => 97.8, 'prestasi' => 'Illustrator Cover Album Band "Midnight Train"', 'penghargaan' => 'Pixiv Contest Winner, Komisi dari Major Label'],
            ['name' => 'Matsumoto Ryo', 'kelas' => 'XI-RPL-1', 'gender' => 'L', 'nilai' => 97.2, 'prestasi' => 'Developer Aplikasi "ShukaSchedule" untuk Siswa', 'penghargaan' => 'Apple Swift Student Challenge Finalist'],
            ['name' => 'Inoue Aya', 'kelas' => 'XI-MBE-1', 'gender' => 'P', 'nilai' => 96.8, 'prestasi' => 'Marketing Campaign "Shuka-sai 2026" Viral di TikTok', 'penghargaan' => 'Social Media Marketing Certified, 1M+ Views'],
        ];

        foreach ($highAchievers as $idx => $achiever) {
            $i = 591 + $idx;
            $isFemale = ($achiever['gender'] === 'P');
            $user = User::create([
                'name' => $achiever['name'],
                'email' => "achiever{$idx}@shuka.test",
                'password' => $password,
                'email_verified_at' => now(),
                'avatar' => $avatars[($i * 3) % count($avatars)],
                'role' => User::ROLE_MURID,
            ]);
            $userId = $user->id;

            $siswa = Siswa::create([
                'user_id' => $userId,
                'nama' => $achiever['name'],
                'nis' => sprintf('2026%04d', $i),
                'kelas' => $achiever['kelas'],
                'jenis_kelamin' => $achiever['gender'],
                'alamat' => $alamatList[$i % count($alamatList)],
                'tanggal_lahir' => now()->subYears(16 + ($i % 2))->subDays($i * 3)->toDateString(),
            ]);

        }

        // 5. Seed Ekskul (12 Clubs) - Using Ekskul Model
        $ekskulData = [
            [
                'nama' => 'Kessoku Band (軽音楽部)',
                'nama_en' => 'Kessoku Band (Light Music Club)',
                'kategori' => 'Seni Musik Populer',
                'pembina' => 'Seika Ijichi (Manager STARRY) & Gin Sasaki, S.Pd.',
                'ketua' => 'Nijika Ijichi (X-SMP-2)',
                'anggota' => 28,
                'jadwal' => 'Rabu & Sabtu, 16:30',
                'lokasi' => 'Livehouse STARRY Basement & Studio 1',
                'deskripsi' => 'Pengembangan teknik instrumen ensemble, komposisi lirik/melodi, live performance, dan rekaman single band.',
                'kegiatan_utama' => 'Latihan rutin band, panggung Shuka-sai, dan live show showcase.',
                'prestasi' => 'Juara 1 Festival Band SMK Se-Jabodetabek 2026, Performa di Java Jazz Festival 2026',
            ],
            [
                'nama' => 'Studio Audio & Sound Lab (音響研究部)',
                'nama_en' => 'Studio Audio & Sound Lab',
                'kategori' => 'Teknologi Audio & PA',
                'pembina' => 'PA-san, S.T., M.Kom.',
                'ketua' => 'Ryo Yamada (X-SMP-2)',
                'anggota' => 22,
                'jadwal' => 'Selasa & Kamis, 15:30',
                'lokasi' => 'Lab Audio & DAW Center',
                'deskripsi' => 'Pelatihan tata suara panggung live, sound reinforcement, digital mixer console, microphoning, dan mastering.',
                'kegiatan_utama' => 'Praktik live mixing panggung, instalasi sound system, dan rekaman multitrack.',
                'prestasi' => 'Best Sound System Design Shuka-sai 2026, Kolaborasi recording dengan band indie terkenal',
            ],
            [
                'nama' => 'DKV Manga, Merchandise & Artwork (美術・デザイン部)',
                'nama_en' => 'DKV Manga, Merchandise & Artwork',
                'kategori' => 'Desain Visual & Merchandise',
                'pembina' => 'Yoko Sasaki, S.Sn.',
                'ketua' => 'Hitori Gotoh (X-SMP-1)',
                'anggota' => 35,
                'jadwal' => 'Senin & Jumat, 15:30',
                'lokasi' => 'Studio Desain Grafis DKV',
                'deskripsi' => 'Pembuatan merchandise resmi kaos band, stiker, pin enamel, artwork cover album vinyl, dan fotografi panggung.',
                'kegiatan_utama' => 'Pameran karya desain, produksi merchandise kreatif, dan publikasi poster festival.',
                'prestasi' => 'Merchandise terjual 5000+ unit Shuka-sai 2026, Kolaborasi UNIQLO UT',
            ],
            [
                'nama' => 'Broadcasting & Podcast Shuka (放送・メディア部)',
                'nama_en' => 'Broadcasting & Podcast Shuka',
                'kategori' => 'Media & Penyiaran',
                'pembina' => 'Hiroshi Tanaka, M.I.Kom.',
                'ketua' => 'Ikuyo Kita (X-SMP-1)',
                'anggota' => 26,
                'jadwal' => 'Kamis & Sabtu, 14:00',
                'lokasi' => 'Studio Siaran Shuka Live',
                'deskripsi' => 'Produksi podcast radio sekolah "Guitarhero Room", video live streaming event, dan social media creative.',
                'kegiatan_utama' => 'Live streaming festival, wawancara musisi tamu, dan publikasi buletin mingguan.',
                'prestasi' => 'Podcast "Guitarhero Room" Top 10 Spotify Indonesia Education, 100k+ subscribers YouTube',
            ],
            [
                'nama' => 'STARRY Cafe & Hospitality (カフェ・調理部)',
                'nama_en' => 'STARRY Cafe & Hospitality',
                'kategori' => 'Hospitality & Kuliner',
                'pembina' => 'Michiyo Gotoh, S.Pd.',
                'ketua' => 'Futari Gotoh (X-SMP-1)',
                'anggota' => 30,
                'jadwal' => 'Rabu, 15:30',
                'lokasi' => 'Dapur Praktik Tata Boga',
                'deskripsi' => 'Keterampilan barista, peracikan mocktail khas event, dan manajemen booth cafe livehouse saat festival.',
                'kegiatan_utama' => 'Pengelolaan booth cafe Shuka-sai dan kreasi minuman bertema seni musik.',
                'prestasi' => 'Booth cafe paling ramai Shuka-sai 2026, Resep mocktail viral di TikTok 2M views',
            ],
            [
                'nama' => 'Web Dev & Audio Software Lab (情報技術部)',
                'nama_en' => 'Web Dev & Audio Software Lab',
                'kategori' => 'Teknologi Informasi',
                'pembina' => 'Daisuke Suzuki, M.Kom.',
                'ketua' => 'Shinji Yamamoto (X-RPL-1)',
                'anggota' => 24,
                'jadwal' => 'Senin & Kamis, 15:30',
                'lokasi' => 'Lab Komputer RPL',
                'deskripsi' => 'Pengembangan portal sistem informasi akademik sekolah, audio synthesizer berbasis web, dan basis data.',
                'kegiatan_utama' => 'Coding portal web, pembuatan plugin audio DSP, dan pemeliharaan server.',
                'prestasi' => 'Aplikasi "ShukaSchedule" dipakai 500+ siswa, Plugin VST didownload 10k+ kali',
            ],
            [
                'nama' => 'Fotografi Panggung & Jurnalistik (写真部)',
                'nama_en' => 'Stage Photography & Journalism',
                'kategori' => 'Jurnalistik Foto',
                'pembina' => 'Akiko Matsumoto, S.Pd.',
                'ketua' => 'Yoyoko Ohtsuki (XI-SMP-1)',
                'anggota' => 19,
                'jadwal' => 'Jumat, 15:00',
                'lokasi' => 'Ruang Redaksi Foto Shuka',
                'deskripsi' => 'Liputan konser live panggung, teknik pencahayaan low-light panggung musik, dan buletin visual.',
                'kegiatan_utama' => 'Dokumentasi konser live, pameran foto panggung, dan galeri majalah dinding.',
                'prestasi' => 'Foto resmi Shuka-sai 2026, Pameran "Stage Lights" di Galeri Nasional',
            ],
            [
                'nama' => 'Stage Lighting & Tata Cahaya (舞台照明部)',
                'nama_en' => 'Stage Lighting & Lighting Design',
                'kategori' => 'Teknik Panggung',
                'pembina' => 'Naoki Gotoh, M.Sc.',
                'ketua' => 'Eliza Shimizu (XI-AET-1)',
                'anggota' => 18,
                'jadwal' => 'Selasa, 16:00',
                'lokasi' => 'Auditorium & Gymnasium',
                'deskripsi' => 'DMX512 lighting console, laser synchronization, moving heads, dan efek visual panggung konser.',
                'kegiatan_utama' => 'Pengoperasian tata cahaya konser festival dan instalasi pencahayaan panggung.',
                'prestasi' => 'Lighting Design terbaik Shuka-sai 2026, Kolaborasi dengan lighting designer internasional',
            ],
            [
                'nama' => 'Paduan Suara & Vokal Harmoni (合唱部)',
                'nama_en' => 'Choir & Vocal Harmony',
                'kategori' => 'Seni Vokal',
                'pembina' => 'Kikuri Hiroi, S.Sn.',
                'ketua' => 'Shima Iwashita (XI-SMP-2)',
                'anggota' => 32,
                'jadwal' => 'Rabu & Jumat, 15:30',
                'lokasi' => 'Ruang Akustik Vokal',
                'deskripsi' => 'Pelatihan teknik pernapasan vokal diafragma, solfeggio harmoni 4 suara, dan ensemble vokal.',
                'kegiatan_utama' => 'Paduan suara upacara dan konser resital musik vokal.',
                'prestasi' => 'Juara 1 Paduan Suara SMK Se-Jawa Barat 2026, Performa di Istana Negara',
            ],
            [
                'nama' => 'Cosplay & Teater Musikal (演劇・コスプレ部)',
                'nama_en' => 'Cosplay & Musical Theater',
                'kategori' => 'Seni Peran & Karakter',
                'pembina' => 'Kaori Watanabe, S.Pd.',
                'ketua' => 'Akebi Hasegawa (XI-DKV-1)',
                'anggota' => 25,
                'jadwal' => 'Kamis, 15:30',
                'lokasi' => 'Aula Teater Shuka',
                'deskripsi' => 'Tata panggung drama musikal, perancangan kostum karakter, makeup panggung, dan olah vokal peran.',
                'kegiatan_utama' => 'Pementasan drama musikal tahunan Shuka-sai.',
                'prestasi' => 'Musical "Bocchi the Rock! The Stage" sold out 3 hari, Review 5/5 dari kritik teater',
            ],
            [
                'nama' => 'Badminton & Stamina Panggung (バドミントン部)',
                'nama_en' => 'Badminton & Stage Stamina',
                'kategori' => 'Olahraga & Kebugaran',
                'pembina' => 'Jimihen Sensei, M.M.',
                'ketua' => 'Takumi Kato (X-RPL-1)',
                'anggota' => 40,
                'jadwal' => 'Senin & Sabtu, 08:00',
                'lokasi' => 'Gelanggang Olahraga',
                'deskripsi' => 'Pembinaan kebugaran jasmani, ketahanan stamina pemain band konser live, dan turnamen olahraga antar kelas.',
                'kegiatan_utama' => 'Latihan fisik stamina panggung dan turnamen bulutangkis.',
                'prestasi' => 'Juara 1 Turnamen Badminton SMK Se-Setagaya 2026, Fisik terbaik band Shuka-sai',
            ],
            [
                'nama' => 'Japanese Culture & Sastra Modern (日本文化・文芸部)',
                'nama_en' => 'Japanese Culture & Modern Literature',
                'kategori' => 'Bahasa & Budaya',
                'pembina' => 'Michiyo Gotoh, S.Pd.',
                'ketua' => 'Kana Koyama (XI-SMP-2)',
                'anggota' => 20,
                'jadwal' => 'Selasa, 15:00',
                'lokasi' => 'Perpustakaan Lt. 2',
                'deskripsi' => 'Penulisan lirik lagu puisi modern, apresiasi literatur Jepang, dan penulisan skenario pertunjukan.',
                'kegiatan_utama' => 'Workshop lirik lagu dan publikasi antologi puisi siswa.',
                'prestasi' => 'Antologi "Hikari no Uta" diterbitkan ISBN, Workshop dikunjungi penulis Jepang ternama',
            ],
        ];

        foreach ($ekskulData as $ek) {
            $ekskul = Ekskul::create($ek);
            $memberCount = min($ek['anggota'], count($siswaModels));
            $memberIds = collect($siswaModels)
                ->shuffle()
                ->take($memberCount)
                ->pluck('id');

            $memberRows = [];
            foreach ($memberIds->values() as $memberIndex => $siswaId) {
                $memberRows[] = [
                    'ekskul_id' => $ekskul->id,
                    'siswa_id' => $siswaId,
                    'posisi' => $memberIndex === 0 ? 'Ketua' : 'Anggota',
                    'tahun_bergabung' => 2026,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if ($memberRows !== []) {
                DB::table('ekskul_siswa')->insert($memberRows);
            }
        }

        // 7. Seed Jadwal Pelajaran 18 Rombel SMK
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $slots = [
            ['07:30', '09:00'],
            ['09:15', '10:45'],
            ['11:00', '12:30'],
            ['13:30', '15:00'],
            ['15:15', '16:30'],
        ];

        foreach ($hariList as $hIdx => $hari) {
            foreach ($kelasList as $kIdx => $kelas) {
                $mapel = $mapelModels[($hIdx + $kIdx) % count($mapelModels)];
                $slot = $slots[($hIdx + $kIdx) % count($slots)];

                Jadwal::create([
                    'mapel_id' => $mapel->id,
                    'kelas' => $kelas,
                    'hari' => $hari,
                    'jam_mulai' => $slot[0],
                    'jam_selesai' => $slot[1],
                ]);
            }
        }

        // 8. Seed Nilai Akademik for every active student
        $jenisNilaiList = ['Tugas', 'UH', 'UTS', 'UAS'];
        $nilaiRows = [];
        $gradeStudents = Siswa::query()->orderBy('id')->get();
        $gradeSubjects = MataPelajaran::query()->orderBy('id')->take(12)->get();
        $highAchieverNames = collect($highAchievers)->pluck('name')->all();

        foreach ($gradeStudents as $studentIndex => $siswa) {
            foreach ($gradeSubjects as $mapel) {
                // Keep the seeded distribution realistic: A 15%, B 30%, C 50%, D 5%.
                if (in_array($siswa->nama, $highAchieverNames, true)) {
                    $nilaiMin = 95.0;
                    $nilaiMax = 99.5;
                } elseif ($studentIndex % 20 < 3) {
                    $nilaiMin = 90.0;
                    $nilaiMax = 94.9;
                } elseif ($studentIndex % 20 < 9) {
                    $nilaiMin = 80.0;
                    $nilaiMax = 89.9;
                } elseif ($studentIndex % 20 < 19) {
                    $nilaiMin = 70.0;
                    $nilaiMax = 79.9;
                } else {
                    $nilaiMin = 60.0;
                    $nilaiMax = 69.9;
                }
                $nilaiRows[] = [
                    'siswa_id' => $siswa->id,
                    'mapel_id' => $mapel->id,
                    'jenis_nilai' => $jenisNilaiList[array_rand($jenisNilaiList)],
                    'nilai' => fake()->randomFloat(1, $nilaiMin, $nilaiMax),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if (count($nilaiRows) >= 500) {
                    DB::table('nilais')->insert($nilaiRows);
                    $nilaiRows = [];
                }
            }
        }

        if ($nilaiRows !== []) {
            DB::table('nilais')->insert($nilaiRows);
        }

        // 9. Seed Data Agenda Sekolah SMK Shuka
        $initialAgendas = [
            [
                'judul' => 'Latihan Rutin Panggung Ensembel di Livehouse STARRY',
                'kategori' => 'Latihan Band',
                'tanggal' => 'Setiap Rabu & Sabtu',
                'jam' => '16:30 - 19:30 JST',
                'lokasi' => 'Livehouse STARRY, Basement Shimokitazawa',
                'penanggung_jawab' => 'Seika Ijichi (Manager)',
                'personel' => 'Siswa Jurusan Seni Musik Populer (X-SMP-1, X-SMP-2)',
                'status' => 'Aktif',
                'catatan' => 'Persiapan setlist Shuka-sai: "Ano Bando", "Guitar, Loneliness and Blue Planet", "That Band".'
            ],
            [
                'judul' => 'Festival Budaya SMK Shuka (Shuka-sai 2026)',
                'kategori' => 'Festival Sekolah',
                'tanggal' => '28 - 29 Agustus 2026',
                'jam' => '09:00 - 17:00 JST',
                'lokasi' => 'Gymnasium & Panggung Utama SMK Shuka',
                'penanggung_jawab' => 'Gin Sasaki, S.Pd. & OSIS Shuka',
                'personel' => 'Kessoku Band, SICK HACK (Guest Star), Seluruh Siswa Jurusan SMP, AET, DKV, RPL, MBE',
                'status' => 'Persiapan',
                'catatan' => 'Panggung utama, sound check pukul 07:30 JST bersama PA-san.'
            ],
            [
                'judul' => 'Workshop Audio Mixing & Digital Audio Workstation',
                'kategori' => 'Workshop',
                'tanggal' => '5 September 2026',
                'jam' => '13:00 - 15:30 JST',
                'lokasi' => 'Lab Multimedia & Audio Studio SMK Shuka',
                'penanggung_jawab' => 'PA-san, S.T., M.Kom.',
                'personel' => 'Siswa Jurusan AET & Anggota Ekskul Audio',
                'status' => 'Mendatang',
                'catatan' => 'Membahas pengoperasian Digital Audio Workstation, Mic Placement, dan Soundboard console.'
            ],
            [
                'judul' => 'Uji Kompetensi Kejuruan (UKK) Seni Musik & Ensembel',
                'kategori' => 'Uji Kompetensi Kejuruan (UKK)',
                'tanggal' => '18 - 20 September 2026',
                'jam' => '08:00 - 15:00 JST',
                'lokasi' => 'Auditorium Musik SMK Shuka',
                'penanggung_jawab' => 'Kikuri Hiroi, S.Sn. & Penguji Eksternal Industri',
                'personel' => 'Seluruh Siswa Kelas XII Jurusan Seni Musik Populer (XII-SMP-1 & XII-SMP-2)',
                'status' => 'Mendatang',
                'catatan' => 'Ujian performa repertoar instrumen wajib, harmoni panggung, dan sight reading.'
            ],
            [
                'judul' => 'Sesi Konseling Karier Seni & Industri Kreatif',
                'kategori' => 'Konseling',
                'tanggal' => 'Kamis Rutin',
                'jam' => '15:30 - 17:00 JST',
                'lokasi' => 'Ruang Bimbingan Konseling 2B',
                'penanggung_jawab' => 'Seika Ijichi & Kikuri Hiroi',
                'personel' => 'Siswa Jurusan Musik & Bisnis Pertunjukan',
                'status' => 'Aktif',
                'catatan' => 'Sesi pembinaan mental tampil di panggung publik dan persiapan portofolio perguruan tinggi seni.'
            ],
        ];

        foreach ($initialAgendas as $ag) {
            Agenda::create($ag);
        }

        // 10. Seed Pengumuman Resmi Sekolah
        $initialPengumumans = [
            [
                'judul' => 'Persiapan Gladi Bersih Panggung Festival Shuka-sai 2026',
                'isi' => 'Diberitahukan kepada seluruh perwakilan rombel kelas dan pengisi acara panggung untuk hadir gladi resik di Gymnasium pada Kamis, 27 Agustus 2026 pukul 14:00 JST.',
                'tipe' => 'penting',
                'target' => 'semua',
                'is_active' => true,
                'penulis' => 'Wakasek Kesiswaan (Gin Sasaki, S.Pd.)',
            ],
            [
                'judul' => 'Jadwal Peminjaman Studio Audio & Sound Lab Livehouse STARRY',
                'isi' => 'Peminjaman instrumen kabel jack dan sound mixer untuk latihan wajib mengisi formulir izin di ruang teknisi PA-san paling lambat H-1 kegiatan.',
                'tipe' => 'info',
                'target' => 'murid',
                'is_active' => true,
                'penulis' => 'Kepala Lab Audio (PA-san, S.T.)',
            ],
            [
                'judul' => 'Peringatan Ketertiban & Kebersihan Ruang Latihan Musik',
                'isi' => 'Siswa dilarang meninggalkan sampah makanan/minuman di dalam ruang studio drum dan kabel amplifier. Pelanggaran akan dikenakan sanksi piket studio.',
                'tipe' => 'mendesak',
                'target' => 'murid',
                'is_active' => false,
                'penulis' => 'Tim Kedisiplinan Sekolah',
            ],
        ];

        foreach ($initialPengumumans as $peng) {
            Pengumuman::create($peng);
        }

        // data pelanggaran kesiswaan
        $samplePelanggarans = [
            [
                'siswa_id' => $siswaModels[0]->id, // Hitori Gotoh (X-SMP-1)
                'jenis_pelanggaran' => 'Terlambat Masuk Jam Pelajaran Pertama (15 Menit)',
                'kategori' => 'Ringan',
                'poin' => 5,
                'sanksi' => 'Teguran lisan & menyusun partitur lagu wajib',
                'tanggal' => '2026-08-12',
                'guru_pencatat' => 'Yoshida Emi, S.Pd.',
                'status' => 'Selesai',
                'catatan' => 'Terhambat kereta komuter dari arah Yokohama.',
            ],
            [
                'siswa_id' => $siswaModels[1]->id, // Ikuyo Kita (X-SMP-2)
                'jenis_pelanggaran' => 'Lupa Mengembalikan Mikrofon Studio 2 ke Lemari Inventaris',
                'kategori' => 'Ringan',
                'poin' => 5,
                'sanksi' => 'Merapikan rak mikrofon dan kabel audio lab',
                'tanggal' => '2026-08-14',
                'guru_pencatat' => 'PA-san, S.T., M.Kom.',
                'status' => 'Selesai',
                'catatan' => 'Segera merapikan setelah diingatkan.',
            ],
            [
                'siswa_id' => $siswaModels[2]->id, // Nijika Ijichi (X-SMP-1)
                'jenis_pelanggaran' => 'Menggunakan Ruang Studio Drum Melebihi Jadwal Sesi',
                'kategori' => 'Ringan',
                'poin' => 5,
                'sanksi' => 'Teguran lisan & pembagian jadwal ulang',
                'tanggal' => '2026-08-16',
                'guru_pencatat' => 'Yoshida Emi, S.Pd.',
                'status' => 'Selesai',
                'catatan' => 'Antusias latihan fills drum lagu baru.',
            ],
            [
                'siswa_id' => $siswaModels[3]->id, // Ryo Yamada (XI-SMP-1)
                'jenis_pelanggaran' => 'Tidur di Jam Pelajaran Teori Harmoni Musik',
                'kategori' => 'Ringan',
                'poin' => 5,
                'sanksi' => 'Mengerjakan 10 soal aransemen akord di papan tulis',
                'tanggal' => '2026-08-13',
                'guru_pencatat' => 'Kenji Tanaka, S.Pd.',
                'status' => 'Selesai',
                'catatan' => 'Kelelahan setelah lembur aransemen lagu bass.',
            ],
            [
                'siswa_id' => $siswaModels[10]->id, // X-SMP-1
                'jenis_pelanggaran' => 'Atribut Seragam Praktik Studio Tidak Lengkap',
                'kategori' => 'Ringan',
                'poin' => 5,
                'sanksi' => 'Membeli badge resmi di koperasi sekolah',
                'tanggal' => '2026-08-18',
                'guru_pencatat' => 'Yoshida Emi, S.Pd.',
                'status' => 'Selesai',
                'catatan' => 'Badge hilang saat mencuci pakaian.',
            ],
            [
                'siswa_id' => $siswaModels[15]->id, // X-AET-1
                'jenis_pelanggaran' => 'Menyimpan Kabel Audio Tidak Menggulung dengan Teknik Over-Under',
                'kategori' => 'Ringan',
                'poin' => 5,
                'sanksi' => 'Praktik ulang penggulungan 10 kabel XLR studio',
                'tanggal' => '2026-08-19',
                'guru_pencatat' => 'PA-san, S.T., M.Kom.',
                'status' => 'Selesai',
                'catatan' => 'Sudah lulus evaluasi ulang teknis kabel.',
            ],
            [
                'siswa_id' => $siswaModels[20]->id, // X-DKV-1
                'jenis_pelanggaran' => 'Meninggalkan Sampah Botol Minuman di Ruang Studio',
                'kategori' => 'Sedang',
                'poin' => 15,
                'sanksi' => 'Piket membersihkan seluruh ruang studio musik selama 3 hari',
                'tanggal' => '2026-08-20',
                'guru_pencatat' => 'Seika Ijichi, S.Sn.',
                'status' => 'Dalam Pembinaan',
                'catatan' => 'Sedang menjalani masa sanksi piket.',
            ],
            [
                'siswa_id' => $siswaModels[25]->id, // X-RPL-1
                'jenis_pelanggaran' => 'Bermain Game Daring saat Jam Praktik Basis Data',
                'kategori' => 'Sedang',
                'poin' => 10,
                'sanksi' => 'Membuat resume materi query SQL 5 halaman tulisan tangan',
                'tanggal' => '2026-08-21',
                'guru_pencatat' => 'Daisuke Suzuki, M.Kom.',
                'status' => 'Ditindaklanjuti',
                'catatan' => 'Tugas resume telah diserahkan dan diperiksa.',
            ],
            [
                'siswa_id' => $siswaModels[30]->id, // X-MBE-1
                'jenis_pelanggaran' => 'Terlambat Menyerahkan Laporan Anggaran Kas Booth Festival',
                'kategori' => 'Sedang',
                'poin' => 10,
                'sanksi' => 'Revisi pembukuan kas didampingi guru pembina',
                'tanggal' => '2026-08-22',
                'guru_pencatat' => 'Gin Sasaki, S.Pd.',
                'status' => 'Selesai',
                'catatan' => 'Laporan keuangan telah diverifikasi akurat.',
            ],
            [
                'siswa_id' => $siswaModels[45]->id, // XI-SMP-1
                'jenis_pelanggaran' => 'Tidak Mengikuti Gladi Resik Panggung Tanpa Keterangan Izin',
                'kategori' => 'Sedang',
                'poin' => 15,
                'sanksi' => 'Membantu tim logistik panggung menyiapkan amplifier festival',
                'tanggal' => '2026-08-23',
                'guru_pencatat' => 'Gin Sasaki, S.Pd.',
                'status' => 'Dalam Pembinaan',
                'catatan' => 'Sedang melaksanakan tugas piket logistik.',
            ],
            [
                'siswa_id' => $siswaModels[60]->id, // XI-AET-2
                'jenis_pelanggaran' => 'Mengoperasikan Fader Audio Mixer Melebihi Batas Desibel Aman (>105dB)',
                'kategori' => 'Sedang',
                'poin' => 15,
                'sanksi' => 'Ujian ulang kalibrasi sound level meter & hearing safety',
                'tanggal' => '2026-08-24',
                'guru_pencatat' => 'PA-san, S.T., M.Kom.',
                'status' => 'Selesai',
                'catatan' => 'Telah memahami batas aman pendengaran akustik.',
            ],
            [
                'siswa_id' => $siswaModels[75]->id, // XI-DKV-2
                'jenis_pelanggaran' => 'Mencetak Poster Pribadi Menggunakan Kertas Art Paper Sekolah',
                'kategori' => 'Sedang',
                'poin' => 15,
                'sanksi' => 'Mengganti rim kertas inventaris dan membuat poster edukasi kebersihan',
                'tanggal' => '2026-08-25',
                'guru_pencatat' => 'Akiko Matsumoto, S.Pd.',
                'status' => 'Ditindaklanjuti',
                'catatan' => 'Kertas pengganti telah diserahkan ke ruang inventaris.',
            ],
            [
                'siswa_id' => $siswaModels[90]->id, // XII-SMP-1
                'jenis_pelanggaran' => 'Mengabaikan Panggilan Konseling Karier Seni Semester Akhir',
                'kategori' => 'Ringan',
                'poin' => 5,
                'sanksi' => 'Penjadwalan ulang sesi bimbingan konseling dan menyusun CV portofolio',
                'tanggal' => '2026-08-26',
                'guru_pencatat' => 'Seika Ijichi, S.Sn.',
                'status' => 'Selesai',
                'catatan' => 'Konseling karier telah diselesaikan dengan baik.',
            ],
            [
                'siswa_id' => $siswaModels[110]->id, // XII-RPL-1
                'jenis_pelanggaran' => 'Mengubah Konfigurasi IP Gateway Lab Komputer Tanpa Izin',
                'kategori' => 'Berat',
                'poin' => 30,
                'sanksi' => 'Pemanggilan orang tua & skorsing penggunaan lab mandiri 1 pekan',
                'tanggal' => '2026-08-27',
                'guru_pencatat' => 'Daisuke Suzuki, M.Kom.',
                'status' => 'Dalam Pembinaan',
                'catatan' => 'Orang tua telah hadir dan menandatangani surat komitmen.',
            ],
            [
                'siswa_id' => $siswaModels[130]->id, // XII-MBE-1
                'jenis_pelanggaran' => 'Menjual Tiket Panggung Festival di Luar Saluran Loket Resmi',
                'kategori' => 'Berat',
                'poin' => 35,
                'sanksi' => 'Audit seluruh dana tiket, pembinaan khusus wakasek kesiswaan',
                'tanggal' => '2026-08-28',
                'guru_pencatat' => 'Gin Sasaki, S.Pd.',
                'status' => 'Ditindaklanjuti',
                'catatan' => 'Dana telah disetor utuh ke kas bendahara sekolah.',
            ],
        ];

        foreach ($samplePelanggarans as $pel) {
            Pelanggaran::create($pel);
        }

        unset($admin);
    }
}
