<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AcademicSeeder extends Seeder
{
    public function run(): void
    {
        $avatars = User::avatarPresetKeys();
        $password = Hash::make('password');

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@shuka.test'],
            [
                'name' => 'Hitori Admin',
                'password' => $password,
                'email_verified_at' => now(),
                'avatar' => 'bocchi',
                'role' => User::ROLE_ADMIN,
            ]
        );

        $guruAccounts = [
            [
                'email' => 'ryo@shuka.test',
                'name' => 'Ryo Yamada',
                'avatar' => 'bocchi',
                'profil' => ['nip' => '19890101001', 'mata_pelajaran' => 'Musik', 'no_telepon' => '081234567801'],
            ],
            [
                'email' => 'nijika@shuka.test',
                'name' => 'Nijika Ijichi',
                'avatar' => 'bocchi-shy',
                'profil' => ['nip' => '19890202002', 'mata_pelajaran' => 'Matematika', 'no_telepon' => '081234567802'],
            ],
            [
                'email' => 'kita@shuka.test',
                'name' => 'Ikuyo Kita',
                'avatar' => 'bocchi-maid',
                'profil' => ['nip' => '19890303003', 'mata_pelajaran' => 'Bahasa Inggris', 'no_telepon' => '081234567803'],
            ],
        ];

        $gurus = collect($guruAccounts)->map(function (array $account) use ($password) {
            $user = User::query()->updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'password' => $password,
                    'email_verified_at' => now(),
                    'avatar' => $account['avatar'],
                    'role' => User::ROLE_GURU,
                ]
            );

            return Guru::query()->updateOrCreate(
                ['nip' => $account['profil']['nip']],
                [
                    'user_id' => $user->id,
                    'nama' => $account['name'],
                    'mata_pelajaran' => $account['profil']['mata_pelajaran'],
                    'no_telepon' => $account['profil']['no_telepon'],
                ]
            );
        })->values();

        $mapels = collect([
            ['nama' => 'Matematika', 'kode' => 'MTK-01', 'guru_id' => $gurus[1]->id],
            ['nama' => 'Bahasa Indonesia', 'kode' => 'BIN-01', 'guru_id' => $gurus[0]->id],
            ['nama' => 'Bahasa Inggris', 'kode' => 'BIG-01', 'guru_id' => $gurus[2]->id],
            ['nama' => 'Fisika', 'kode' => 'FIS-01', 'guru_id' => $gurus[1]->id],
            ['nama' => 'Kimia', 'kode' => 'KIM-01', 'guru_id' => $gurus[1]->id],
            ['nama' => 'Sejarah', 'kode' => 'SEJ-01', 'guru_id' => $gurus[2]->id],
            ['nama' => 'Seni Musik', 'kode' => 'SMU-01', 'guru_id' => $gurus[0]->id],
            ['nama' => 'Olahraga', 'kode' => 'ORJ-01', 'guru_id' => $gurus[2]->id],
        ])->map(fn (array $data) => MataPelajaran::create($data));

        $namaSiswa = [
            'Hitori Gotou', 'Kikuri Hiroi', 'Seika Ijichi', 'PA-san', 'Futari Gotou',
            'Michiyo Gotou', 'Naoki Gotou', 'Yoyoko', 'Eliza', 'Subaru',
            'Kita Ikuyo Jr', 'Ryo Mini', 'Nijika Jr', 'Sakura Amane', 'Hiroto Ken',
            'Mei Amamiya', 'Sora Tanaka', 'Yuki Nakamura', 'Aoi Fujita', 'Ren Okada',
            'Hana Sato', 'Kai Watanabe', 'Mio Takahashi', 'Leo Suzuki', 'Nana Ito',
        ];

        $kelasList = ['X-1', 'X-2', 'XI-1', 'XI-2', 'XII-1'];
        $alamatList = ['Shimokitazawa', 'Tokyo', 'Shibuya', 'Kichijoji', 'Nakano'];

        $siswas = collect($namaSiswa)->values()->map(function (string $nama, int $i) use ($kelasList, $alamatList, $avatars, $password) {
            $userId = null;

            if ($i < 12) {
                $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '', explode(' ', $nama)[0]));
                $email = $slug.$i.'@murid.shuka.test';

                $user = User::query()->updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $nama,
                        'password' => $password,
                        'email_verified_at' => now(),
                        'avatar' => $avatars[$i % count($avatars)],
                        'role' => User::ROLE_MURID,
                    ]
                );

                $userId = $user->id;
            }

            return Siswa::create([
                'user_id' => $userId,
                'nama' => $nama,
                'nis' => sprintf('2026%03d', $i + 1),
                'kelas' => $kelasList[$i % count($kelasList)],
                'jenis_kelamin' => $i % 5 === 0 || $i % 7 === 0 ? 'L' : 'P',
                'alamat' => $alamatList[$i % count($alamatList)],
                'tanggal_lahir' => now()->subYears(16 + ($i % 4))->subDays($i * 11)->toDateString(),
            ]);
        });

        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $slots = [
            ['07:30', '09:00'],
            ['09:15', '10:45'],
            ['11:00', '12:30'],
            ['13:15', '14:45'],
        ];

        foreach ($hariList as $i => $hari) {
            foreach ([0, 1] as $slotOffset) {
                $slot = $slots[($i + $slotOffset) % count($slots)];
                Jadwal::create([
                    'mapel_id' => $mapels[($i + $slotOffset) % $mapels->count()]->id,
                    'kelas' => $kelasList[($i + $slotOffset) % count($kelasList)],
                    'hari' => $hari,
                    'jam_mulai' => $slot[0],
                    'jam_selesai' => $slot[1],
                ]);
            }
        }

        $jenis = ['UH', 'UTS', 'UAS', 'Tugas'];
        foreach ($siswas->take(12) as $siswa) {
            foreach ($mapels->take(4) as $mapel) {
                Nilai::create([
                    'siswa_id' => $siswa->id,
                    'mapel_id' => $mapel->id,
                    'jenis_nilai' => $jenis[array_rand($jenis)],
                    'nilai' => fake()->randomFloat(2, 68, 98),
                ]);
            }
        }

        unset($admin);
    }
}
