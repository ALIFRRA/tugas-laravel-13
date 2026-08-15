<?php

namespace Database\Seeders;

use App\Models\Agenda;
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
        // Disable foreign key constraints while truncating for clean re-seeding
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Pelanggaran::truncate();
            Pengumuman::truncate();
            Agenda::truncate();
            Nilai::truncate();
            Jadwal::truncate();
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
            Siswa::query()->delete();
            MataPelajaran::query()->delete();
            Guru::query()->delete();
            User::query()->delete();
        }

        $avatars = User::avatarPresetKeys();
        $password = Hash::make('password');

        // 1. Admin Account (Hitori Admin)
        $admin = User::create([
            'email' => 'admin@shuka.test',
            'name' => 'Hitori Admin',
            'password' => $password,
            'email_verified_at' => now(),
            'avatar' => 'bocchi-shy',
            'role' => User::ROLE_ADMIN,
            'jabatan' => 'Super Administrator SIA',
        ]);

        // 1b. Staff Tenaga Kependidikan & Tata Usaha / Koperasi / IT
        $staffMembers = [
            [
                'email' => 'tu@shuka.test',
                'name' => 'Erika Sasaki, S.AP.',
                'avatar' => 'bocchi',
                'jabatan' => 'Kepala Tata Usaha & Administrasi',
            ],
            [
                'email' => 'it@shuka.test',
                'name' => 'Daisuke Suzuki, M.Kom.',
                'avatar' => 'bocchi',
                'jabatan' => 'Staf TU Bagian IT & Administrator Sistem',
            ],
            [
                'email' => 'kesiswaan@shuka.test',
                'name' => 'Kazutoshi Sawada, S.Sos.',
                'avatar' => 'bocchi-maid',
                'jabatan' => 'Staf TU Kesiswaan & Kedisiplinan',
            ],
            [
                'email' => 'koperasi@shuka.test',
                'name' => 'Yoko Yoshida, A.Md.',
                'avatar' => 'bocchi-shy',
                'jabatan' => 'Pengelola Koperasi Sekolah & Sarpras',
            ],
            [
                'email' => 'studio@shuka.test',
                'name' => 'Kenji Ishida, S.T.',
                'avatar' => 'bocchi',
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

        // 2. Seed 45 Guru SMK Shuka (with Bocchi the Rock! Character Faculty & Leadership)
        $easterEggTeachers = [
            ['name' => 'Seika Ijichi, S.Sn., M.Pd.', 'email' => 'seika@shuka.test', 'nip' => '198504122008012001', 'mapel' => 'Manajemen Event & Livehouse STARRY', 'phone' => '0812-3344-9001', 'avatar' => 'bocchi', 'jabatan' => 'Kepala Sekolah & Pembina STARRY'],
            ['name' => 'PA-san, S.T., M.Kom.', 'email' => 'pasan@shuka.test', 'nip' => '198809222010012002', 'mapel' => 'Audio Engineering & Live Sound Mixing', 'phone' => '0812-3344-9002', 'avatar' => 'bocchi-shy', 'jabatan' => 'Wakil Kepala Sekolah Bidang Kurikulum & IT'],
            ['name' => 'Gin Sasaki, S.Pd.', 'email' => 'sasaki@shuka.test', 'nip' => '198205152005011003', 'mapel' => 'Seni Musik Populer: Gitar & Vokal', 'phone' => '0812-3344-9003', 'avatar' => 'bocchi-maid', 'jabatan' => 'Wakil Kepala Sekolah Bidang Kesiswaan'],
            ['name' => 'Naoki Gotoh, M.Sc.', 'email' => 'naoki@shuka.test', 'nip' => '198001102003011004', 'mapel' => 'Fisika Gelombang Akustik & Bunyi', 'phone' => '0812-3344-9004', 'avatar' => 'bocchi', 'jabatan' => 'Guru Fisika & Akustik'],
            ['name' => 'Michiyo Gotoh, S.Pd.', 'email' => 'michiyo@shuka.test', 'nip' => '198103192004012005', 'mapel' => 'Bahasa Jepang & Lirik Lagu', 'phone' => '0812-3344-9005', 'avatar' => 'bocchi-shy', 'jabatan' => 'Guru Bahasa Jepang'],
            ['name' => 'Jimihen Sensei, M.M.', 'email' => 'jimihen@shuka.test', 'nip' => '197906202002011006', 'mapel' => 'Pendidikan Jasmani & Kebugaran Panggung', 'phone' => '0812-3344-9006', 'avatar' => 'bocchi-maid', 'jabatan' => 'Guru PJOK & Pelatih Fisik'],
            ['name' => 'Kikuri Hiroi, S.Sn.', 'email' => 'kikuri@shuka.test', 'nip' => '198711302011012007', 'mapel' => 'Harmoni Bass Eksperimental & Slap', 'phone' => '0812-3344-9007', 'avatar' => 'bocchi', 'jabatan' => 'Guru Tamu Spesialis Bass'],
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
                'role' => User::ROLE_GURU,
                'jabatan' => $gt['jabatan'] ?? 'Tenaga Pendidik (Guru)',
            ]);

            $guruModels[] = Guru::create([
                'user_id' => $user->id,
                'nama' => $gt['name'],
                'nip' => $gt['nip'],
                'mata_pelajaran' => $gt['mapel'],
                'no_telepon' => $gt['phone'],
            ]);
        }

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
                'jabatan' => 'Tenaga Pendidik (Guru)',
            ]);

            $guruModels[] = Guru::create([
                'user_id' => $user->id,
                'nama' => $name,
                'nip' => '198' . (70 + ($i % 25)) . sprintf('%04d', $i) . '200' . ($i % 9) . '01',
                'mata_pelajaran' => 'Pendidik Kejuruan SMK Shuka',
                'no_telepon' => '0812-8899-' . (1000 + $i),
            ]);
        }

        // 3. Seed 28 Mata Pelajaran SMK (Muatan Kejuruan & Umum)
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

        $mapelModels = [];
        foreach ($subjectNames as $idx => $s) {
            $guru = $guruModels[$idx % count($guruModels)];
            $mapelModels[] = MataPelajaran::create([
                'kode' => $s['code'],
                'nama' => $s['name'],
                'guru_id' => $guru->id,
            ]);
        }

        // 4. Seed 600 Murid SMK Shuka
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

        $studentPoolF = ['Aoi', 'Hina', 'Yui', 'Mio', 'Ritsu', 'Tsumugi', 'Azusa', 'Akari', 'Mei', 'Sakura', 'Koharu', 'Nanami', 'Rin', 'Kanna', 'Chika', 'Honoka', 'Kotori', 'Umi', 'Maki', 'Nozomi'];
        $studentPoolM = ['Ren', 'Haruto', 'Sota', 'Yuto', 'Riku', 'Kaito', 'Asahi', 'Taiki', 'Daiki', 'Kensuke', 'Shin', 'Shota', 'Kazuma', 'Takashi', 'Hayato', 'Minato', 'Ryusei', 'Koki', 'Yuuki', 'Sho'];
        $studentLastNames = ['Sato', 'Suzuki', 'Takahashi', 'Tanaka', 'Watanabe', 'Ito', 'Yamamoto', 'Nakamura', 'Kobayashi', 'Kato', 'Yoshida', 'Yamada', 'Sasaki', 'Yamaguchi', 'Saito', 'Matsumoto', 'Inoue', 'Kimura', 'Hayashi', 'Shimizu'];

        // 18 Rombel Kelas SMK Shuka
        $kelasList = [
            'X-SMP-1', 'X-SMP-2', 'X-AET-1', 'X-DKV-1', 'X-RPL-1', 'X-MBE-1',
            'XI-SMP-1', 'XI-SMP-2', 'XI-AET-1', 'XI-DKV-1', 'XI-RPL-1', 'XI-MBE-1',
            'XII-SMP-1', 'XII-SMP-2', 'XII-AET-1', 'XII-DKV-1', 'XII-RPL-1', 'XII-MBE-1'
        ];
        $alamatList = ['Shimokitazawa', 'Tokyo', 'Shibuya', 'Kichijoji', 'Nakano', 'Shinjuku', 'Yokohama'];

        $siswaModels = [];

        foreach ($easterEggStudents as $idx => $st) {
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

        for ($i = count($siswaModels) + 1; $i <= 600; $i++) {
            $isFemale = ($i % 2 === 0);
            $fname = $isFemale ? $studentPoolF[$i % count($studentPoolF)] : $studentPoolM[$i % count($studentPoolM)];
            $lname = $studentLastNames[($i * 7) % count($studentLastNames)];
            $name = "{$lname} {$fname}";
            $kelas = $kelasList[$i % count($kelasList)];
            $alamat = $alamatList[$i % count($alamatList)];

            // Create User account for first 50 students, others are unlinked student records
            $userId = null;
            if ($i <= 50) {
                $user = User::create([
                    'name' => $name,
                    'email' => "murid{$i}@shuka.test",
                    'password' => $password,
                    'email_verified_at' => now(),
                    'avatar' => $avatars[$i % count($avatars)],
                    'role' => User::ROLE_MURID,
                ]);
                $userId = $user->id;
            }

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

        // 5. Seed Jadwal Pelajaran 18 Rombel SMK
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

        // 6. Seed Nilai Akademik
        $jenisNilaiList = ['Tugas', 'UH', 'UTS', 'UAS'];
        foreach (array_slice($siswaModels, 0, 50) as $siswa) {
            foreach (array_slice($mapelModels, 0, 6) as $mapel) {
                Nilai::create([
                    'siswa_id' => $siswa->id,
                    'mapel_id' => $mapel->id,
                    'jenis_nilai' => $jenisNilaiList[array_rand($jenisNilaiList)],
                    'nilai' => fake()->randomFloat(1, 75.0, 98.5),
                ]);
            }
        }

        // 7. Seed Data Agenda Sekolah SMK Shuka
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

        // 8. Seed Pengumuman Resmi Sekolah
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

        // 9. Seed Catatan Kedisiplinan & Pelanggaran Kesiswaan
        $samplePelanggarans = [
            [
                'siswa_id' => $siswaModels[0]->id, // Hitori Gotoh
                'jenis_pelanggaran' => 'Terlambat Masuk Jam Pelajaran Pertama (15 Menit)',
                'kategori' => 'Ringan',
                'poin' => 5,
                'sanksi' => 'Teguran lisan & menyusun partitur lagu wajib',
                'tanggal' => '12 Ags 2026',
                'guru_pencatat' => 'Gin Sasaki, S.Pd.',
                'status' => 'Selesai',
                'catatan' => 'Terhambat kereta komuter dari arah Yokohama.',
            ],
            [
                'siswa_id' => $siswaModels[3]->id, // Ryo Yamada
                'jenis_pelanggaran' => 'Tidur di Jam Pelajaran Matematika Terapan',
                'kategori' => 'Ringan',
                'poin' => 5,
                'sanksi' => 'Mengerjakan 10 soal latihan kalkulus di papan tulis',
                'tanggal' => '13 Ags 2026',
                'guru_pencatat' => 'Kenji Tanaka, S.Pd.',
                'status' => 'Selesai',
                'catatan' => 'Kelelahan setelah lembur aransemen lagu bass.',
            ],
            [
                'siswa_id' => $siswaModels[1]->id, // Ikuyo Kita
                'jenis_pelanggaran' => 'Lupa Mengembalikan Mikrofon Studio 2 ke Lemari Inventaris',
                'kategori' => 'Ringan',
                'poin' => 5,
                'sanksi' => 'Merapikan rak mikrofon dan kabel audio lab',
                'tanggal' => '14 Ags 2026',
                'guru_pencatat' => 'PA-san, S.T.',
                'status' => 'Selesai',
                'catatan' => 'Segera merapikan setelah diingatkan.',
            ],
            [
                'siswa_id' => $siswaModels[20]->id,
                'jenis_pelanggaran' => 'Meninggalkan Sampah Botol Minuman di Ruang Studio',
                'kategori' => 'Sedang',
                'poin' => 15,
                'sanksi' => 'Piket membersihkan seluruh ruang studio musik selama 3 hari',
                'tanggal' => '15 Ags 2026',
                'guru_pencatat' => 'Seika Ijichi, S.Sn.',
                'status' => 'Dalam Pembinaan',
                'catatan' => 'Sedang menjalani masa sanksi piket.',
            ],
        ];

        foreach ($samplePelanggarans as $pel) {
            Pelanggaran::create($pel);
        }

        unset($admin);
    }
}
