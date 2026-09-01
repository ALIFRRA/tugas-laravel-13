<?php
/**
     * Test wali kelas module authorization and class access.
     *
     * @return public test_wali_kelas_module_authorization_and_class_access
     */

    /**
     * Test operational staff and teachers have full student access but blocked from guru management.
     *
     * @return public test_operational_staff_and_teachers_have_full_student_access_but_blocked_from_guru_management
     */

    /**
     * Test leadership and tu head and it staff have administrator access.
     *
     * @return public test_leadership_and_tu_head_and_it_staff_have_administrator_access
     */

    /**
     * Test guru can access shared admin modules and record violations.
     *
     * @return public test_guru_can_access_shared_admin_modules_and_record_violations
     */

    /**
     * Test guest can access login and register pages.
     *
     * @return public test_guest_can_access_login_and_register_pages
     */

    /**
     * Test murid can access dashboard and view report.
     *
     * @return public test_murid_can_access_dashboard_and_view_report
     */

    /**
     * Test teacher search uses the subject relation.
     *
     * @return public test_teacher_search_uses_the_subject_relation
     */

    /**
     * Test guru can access dashboard and manage grades.
     *
     * @return public test_guru_can_access_dashboard_and_manage_grades
     */

    /**
     * Test admin dashboard and modules walkthrough.
     *
     * @return public test_admin_dashboard_and_modules_walkthrough
     */

    /**
     * Test public state vocational school routes are accessible.
     *
     * @return public test_public_state_vocational_school_routes_are_accessible
     */

    /**
     * Setup.
     *
     * @return protected setUp
     */


namespace Tests\Feature;

use App\Models\Agenda;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use App\Models\Pelanggaran;
use App\Models\Pengumuman;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmkShukaPortalWalkthroughTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_state_vocational_school_routes_are_accessible(): void
    {
        // 1. Beranda / Top Page
        $responseHome = $this->get('/');
        $responseHome->assertStatus(200);
        $responseHome->assertSee('SMK SHUKA');
        $responseHome->assertSee('秀華高等専門学校');

        // 2. Profil Sekolah
        $responseProfil = $this->get('/profil');
        $responseProfil->assertStatus(200);
        $responseProfil->assertSee('Profil Sekolah');
        $responseProfil->assertSee('Seika Ijichi');

        // 3. Program Keahlian
        $responseJurusan = $this->get('/jurusan');
        $responseJurusan->assertStatus(200);
        $responseJurusan->assertSeeText('Seni Musik Populer & Band (SMP)');
        $responseJurusan->assertSeeText('Audio Engineering & Tata Suara (AET)');
        $responseJurusan->assertSeeText('Desain Komunikasi Visual & Merchandise (DKV)');
        $responseJurusan->assertSeeText('Rekayasa Perangkat Lunak & Multimedia (RPL)');
        $responseJurusan->assertSeeText('Manajemen Bisnis Pertunjukan & Live Event (MBE)');

        // 4. Tenaga Pendidik
        $responseGuru = $this->get(route('public.guru'));
        $responseGuru->assertStatus(200);
        $responseGuru->assertSee('Tenaga Pendidik & Instruktur');

        // 5. Ekstrakurikuler
        $responseEkskul = $this->get('/ekskul');
        $responseEkskul->assertStatus(200);
        $responseEkskul->assertSee('Kessoku Band');
        $responseEkskul->assertSee('12 Klub Aktif');

        // 6. Agenda & Pengumuman
        $responseAgenda = $this->get('/agenda-pengumuman');
        $responseAgenda->assertStatus(200);
        $responseAgenda->assertSeeText('Agenda & Pengumuman Sekolah');

        // 7. Kontak & Akses
        $responseKontak = $this->get('/kontak');
        $responseKontak->assertStatus(200);
        $responseKontak->assertSee('Shimokitazawa');
        $responseKontak->assertSee('Odakyu Odawara');
    }

    public function test_admin_dashboard_and_modules_walkthrough(): void
    {
        $admin = User::where('email', 'admin@shuka.test')->first();
        $this->assertNotNull($admin);

        // 1. Admin Dashboard
        $responseDash = $this->actingAs($admin)->get('/dashboard');
        $responseDash->assertStatus(200);
        $responseDash->assertSee('Dasbor Akademik');

        // 2. Data Siswa with Multi-Criteria Dropdown Filter
        $responseSiswa = $this->actingAs($admin)->get('/admin/siswa?jurusan=SMP&tingkat=X&gender=P');
        $responseSiswa->assertStatus(200);

        // 3. Pengumuman Management & Toggle Active Status
        $responsePengumuman = $this->actingAs($admin)->get('/admin/pengumuman');
        $responsePengumuman->assertStatus(200);

        $pengumuman = Pengumuman::create([
            'judul' => 'Gladi Resik Panggung Shuka Test',
            'isi' => 'Pemeriksaan kabel dan sound console.',
            'tipe' => 'penting',
            'target' => 'semua',
            'is_active' => true,
            'penulis' => 'Admin Test',
        ]);

        $this->actingAs($admin)->post(route('admin.pengumuman.toggle', $pengumuman->id));
        $this->assertFalse($pengumuman->fresh()->is_active);

        // 4. Kedisiplinan & Pelanggaran Kesiswaan
        $responsePelanggaran = $this->actingAs($admin)->get('/admin/pelanggaran');
        $responsePelanggaran->assertStatus(200);
        $responsePelanggaran->assertSeeText('Catatan Pelanggaran & Sanksi Kesiswaan');

        $siswa = Siswa::first();
        $this->actingAs($admin)->post(route('admin.pelanggaran.store'), [
            'siswa_id' => $siswa->id,
            'jenis_pelanggaran' => 'Terlambat Latihan Band',
            'kategori' => 'Ringan',
            'poin' => 5,
            'sanksi' => 'Membersihkan kabel studio',
            'tanggal' => '2026-08-15',
            'guru_pencatat' => 'PA-san',
            'status' => 'Dalam Pembinaan',
            'catatan' => 'Siswa berjanji tidak mengulangi.',
        ]);

        $this->assertDatabaseHas('pelanggarans', [
            'siswa_id' => $siswa->id,
            'jenis_pelanggaran' => 'Terlambat Latihan Band',
        ]);

        // 5. Agenda Sekolah & Ekstrakurikuler
        $responseAgendaAdmin = $this->actingAs($admin)->get('/admin/agenda');
        $responseAgendaAdmin->assertStatus(200);
        $responseAgendaAdmin->assertSeeText('Agenda & Kalender Kegiatan SMK Shuka');

        $responseEkskulAdmin = $this->actingAs($admin)->get('/admin/ekskul');
        $responseEkskulAdmin->assertStatus(200);
        $responseEkskulAdmin->assertSee('Direktori Ekstrakurikuler');

        // 6. User Profile Show
        $responseProfile = $this->actingAs($admin)->get(route('profile.show', $admin->id));
        $responseProfile->assertStatus(200);
        $responseProfile->assertSee('Profil Pengguna');
    }

    public function test_guru_can_access_dashboard_and_manage_grades(): void
    {
        $guruUser = User::where('email', 'guru10@shuka.test')->first();
        $this->assertNotNull($guruUser);

        // Dashboard Guru
        $responseDash = $this->actingAs($guruUser)->get(route('guru.dashboard'));
        $responseDash->assertStatus(200);
        $responseDash->assertSeeText('Portal Guru');
        $responseDash->assertSeeText('Mapel Diampu');

        // Nilai Guru
        $responseNilai = $this->actingAs($guruUser)->get(route('guru.nilai.index'));
        $responseNilai->assertStatus(200);
        $responseNilai->assertSeeText('Input & Kelola Nilai Siswa');

        // Form Create Nilai
        $responseCreate = $this->actingAs($guruUser)->get(route('guru.nilai.create'));
        $responseCreate->assertStatus(200);
        $responseCreate->assertSeeText('Formulir Penilaian Siswa');
    }

    public function test_teacher_search_uses_the_subject_relation(): void
    {
        $mapel = MataPelajaran::query()->firstOrFail();
        $admin = User::where('email', 'admin@shuka.test')->firstOrFail();

        $this->get(route('public.guru', ['search' => $mapel->kode]))
            ->assertOk()
            ->assertSee($mapel->nama);

        $this->actingAs($admin)
            ->get(route('admin.guru.index', ['search' => $mapel->kode]))
            ->assertOk()
            ->assertSee($mapel->nama);
    }

    public function test_murid_can_access_dashboard_and_view_report(): void
    {
        $muridUser = User::where('role', 'murid')->first();
        $this->assertNotNull($muridUser);

        // Dashboard Murid
        $responseDash = $this->actingAs($muridUser)->get(route('murid.dashboard'));
        $responseDash->assertStatus(200);
        $responseDash->assertSeeText('Portal Siswa');
        $responseDash->assertSeeText('Transkrip Nilai Akademik Siswa');
    }

    public function test_guest_can_access_login_and_register_pages(): void
    {
        $responseLogin = $this->get(route('login'));
        $responseLogin->assertStatus(200);
        $responseLogin->assertSeeText('Masuk ke Akun Portal');

        $responseRegister = $this->get(route('register'));
        $responseRegister->assertStatus(200);
        $responseRegister->assertSeeText('Buat Akun Baru');
    }

    public function test_guru_can_access_shared_admin_modules_and_record_violations(): void
    {
        $guruUser = User::where('email', 'guru10@shuka.test')->first();
        $this->assertNotNull($guruUser);

        // Guru can read student-related tables without edit access.
        $responsePelanggaran = $this->actingAs($guruUser)->get(route('admin.pelanggaran.index'));
        $responsePelanggaran->assertStatus(200);

        // 2. Guru can record violation
        $kelasYangDiajar = Jadwal::whereIn('mapel_id', $guruUser->guru->mataPelajarans()->pluck('id'))
            ->pluck('kelas')
            ->unique();
        $siswa = Siswa::whereIn('kelas', $kelasYangDiajar)->first();
        $this->assertNotNull($siswa);

        $responseStore = $this->actingAs($guruUser)->post(route('admin.pelanggaran.store'), [
            'siswa_id' => $siswa->id,
            'jenis_pelanggaran' => 'Tidak Membawa Partitur Not Balok',
            'kategori' => 'Ringan',
            'poin' => 5,
            'sanksi' => 'Latihan solfeggio mandiri',
            'tanggal' => '2026-08-15',
            'guru_pencatat' => $guruUser->name,
            'status' => 'Selesai',
        ]);
        $responseStore->assertRedirect(route('admin.pelanggaran.index'));

        $this->assertDatabaseHas('pelanggarans', [
            'siswa_id' => $siswa->id,
            'jenis_pelanggaran' => 'Tidak Membawa Partitur Not Balok',
        ]);

        // 3. Guru can access Agenda Sekolah
        $responseAgenda = $this->actingAs($guruUser)->get(route('admin.agenda.index'));
        $responseAgenda->assertStatus(200);

        // Read-only access to extracurricular and student directories.
        $responseEkskul = $this->actingAs($guruUser)->get(route('admin.ekskul.index'));
        $responseEkskul->assertStatus(200);

        // Guru can view but cannot create student records.
        $responseSiswa = $this->actingAs($guruUser)->get(route('admin.siswa.index'));
        $responseSiswa->assertStatus(200);
        $this->actingAs($guruUser)->get(route('admin.siswa.create'))->assertStatus(403);
    }

    public function test_leadership_and_tu_head_and_it_staff_have_administrator_access(): void
    {
        $tuHead = User::where('email', 'tu@shuka.test')->first();
        $itStaff = User::where('email', 'it@shuka.test')->first();
        $kepsek = User::where('email', 'seika@shuka.test')->first();
        $wakepsek = User::where('email', 'pasan@shuka.test')->first();

        $this->assertNotNull($tuHead);
        $this->assertNotNull($itStaff);
        $this->assertNotNull($kepsek);
        $this->assertNotNull($wakepsek);

        $this->assertTrue($tuHead->isAdministratorLevel());
        $this->assertTrue($itStaff->isAdministratorLevel());
        $this->assertTrue($kepsek->isAdministratorLevel());
        $this->assertTrue($wakepsek->isAdministratorLevel());
        $this->assertSame(User::ROLE_ADMIN, $kepsek->role);

        // 1. Kepala TU can access Data Guru and Mapel
        $this->actingAs($tuHead)->get(route('admin.guru.index'))->assertStatus(200);
        $this->actingAs($tuHead)->get(route('admin.mapel.index'))->assertStatus(200);

        // 2. IT Staff can access Data Guru and Jadwal
        $this->actingAs($itStaff)->get(route('admin.guru.index'))->assertStatus(200);
        $this->actingAs($itStaff)->get(route('admin.jadwal.index'))->assertStatus(200);

        // 3. Kepsek and Wakepsek can access Data Guru and Pengguna directories
        $this->actingAs($kepsek)->get(route('admin.guru.index'))->assertStatus(200);
        $this->actingAs($wakepsek)->get(route('admin.guru.index'))->assertStatus(200);
        $this->actingAs($kepsek)->get(route('admin.pengguna.guru'))->assertStatus(200);
        $this->actingAs($kepsek)->get(route('admin.pengguna.murid'))->assertStatus(200);
        $this->actingAs($kepsek)->get(route('dashboard'))->assertSeeText('Dasbor Akademik');

        // 4. Leadership can view other user profiles
        $otherStudent = User::where('role', User::ROLE_MURID)->first();
        $this->actingAs($tuHead)->get(route('profile.show', $otherStudent->id))->assertStatus(200);
    }

    public function test_operational_staff_and_teachers_have_full_student_access_but_blocked_from_guru_management(): void
    {
        $kesiswaan = User::where('email', 'kesiswaan@shuka.test')->first();
        $koperasi = User::where('email', 'koperasi@shuka.test')->first();
        $guruUmum = User::where('email', 'guru10@shuka.test')->first();

        $this->assertNotNull($kesiswaan);
        $this->assertNotNull($koperasi);
        $this->assertNotNull($guruUmum);

        $this->assertFalse($kesiswaan->isAdministratorLevel());
        $this->assertFalse($koperasi->isAdministratorLevel());
        $this->assertFalse($guruUmum->isAdministratorLevel());

        // 1. Full student-related access for Kesiswaan
        $this->actingAs($kesiswaan)->get(route('admin.siswa.index'))->assertStatus(200);
        $this->actingAs($kesiswaan)->get(route('admin.pelanggaran.index'))->assertStatus(200);
        $this->actingAs($kesiswaan)->get(route('admin.agenda.index'))->assertStatus(200);
        $this->actingAs($kesiswaan)->get(route('admin.pengumuman.index'))->assertStatus(200);

        // 2. Full student-related access for general teacher
        $this->actingAs($guruUmum)->get(route('admin.siswa.index'))->assertStatus(200);
        $this->actingAs($guruUmum)->get(route('admin.pelanggaran.index'))->assertStatus(200);
        $this->actingAs($guruUmum)->get(route('admin.ekskul.index'))->assertStatus(200);
        $this->actingAs($guruUmum)->get(route('admin.mapel.index'))->assertStatus(200);
        $this->actingAs($guruUmum)->get(route('admin.jadwal.index'))->assertStatus(200);
        $this->actingAs($guruUmum)->get(route('admin.mapel.create'))->assertStatus(403);
        $this->actingAs($guruUmum)->get(route('admin.jadwal.create'))->assertStatus(403);

        // 3. Blocked from Data Guru (403 Forbidden)
        $this->actingAs($kesiswaan)->get(route('admin.guru.index'))->assertStatus(403);
        $this->actingAs($koperasi)->get(route('admin.guru.index'))->assertStatus(403);
        $this->actingAs($guruUmum)->get(route('admin.guru.index'))->assertStatus(403);
    }

    public function test_wali_kelas_module_authorization_and_class_access(): void
    {
        $admin = User::where('email', 'admin@shuka.test')->first();
        $guruWali = User::where('email', 'guru10@shuka.test')->first(); // Wali Kelas X-SMP-1
        $guruNonWali = User::where('email', 'guru30@shuka.test')->first(); // Non-wali
        $murid = User::where('email', 'student1@murid.shuka.test')->first();

        $this->assertNotNull($admin);
        $this->assertNotNull($guruWali);
        $this->assertNotNull($guruNonWali);
        $this->assertNotNull($murid);

        // 1. Admin can access with dropdown and view any class
        $resAdmin = $this->actingAs($admin)->get(route('admin.walikelas.index', ['kelas' => 'X-SMP-1']));
        $resAdmin->assertStatus(200);
        $resAdmin->assertSee('Kelas Binaan X-SMP-1');
        $resAdmin->assertSee('Pilih Rombel:');

        $resAdmin2 = $this->actingAs($admin)->get(route('admin.walikelas.index', ['kelas' => 'XI-DKV-1']));
        $resAdmin2->assertStatus(200);
        $resAdmin2->assertSee('Kelas Binaan XI-DKV-1');

        // 2. Guru Wali Kelas is locked to own class (X-SMP-1)
        $this->assertTrue($guruWali->isWaliKelas());
        $resGuruWali = $this->actingAs($guruWali)->get(route('admin.walikelas.index'));
        $resGuruWali->assertStatus(200);
        $resGuruWali->assertSee('Kelas Binaan X-SMP-1');

        // Even if trying to pass another class query parameter, locked to X-SMP-1
        $resGuruWaliTamper = $this->actingAs($guruWali)->get(route('admin.walikelas.index', ['kelas' => 'XII-RPL-1']));
        $resGuruWaliTamper->assertStatus(200);
        $resGuruWaliTamper->assertSee('Kelas Binaan X-SMP-1');

        // 3. Guru Non-Wali is blocked (403 Forbidden)
        $this->assertFalse($guruNonWali->isWaliKelas());
        $resGuruNonWali = $this->actingAs($guruNonWali)->get(route('admin.walikelas.index'));
        $resGuruNonWali->assertStatus(403);

        // 5. Verifikasi seluruh 18 rombel kelas terisi penuh dan memiliki wali kelas valid
        $all18Classes = [
            'X-SMP-1', 'X-SMP-2', 'X-AET-1', 'X-DKV-1', 'X-RPL-1', 'X-MBE-1',
            'XI-SMP-1', 'XI-SMP-2', 'XI-AET-1', 'XI-DKV-1', 'XI-RPL-1', 'XI-MBE-1',
            'XII-SMP-1', 'XII-SMP-2', 'XII-AET-1', 'XII-DKV-1', 'XII-RPL-1', 'XII-MBE-1',
        ];

        foreach ($all18Classes as $kelasName) {
            $wali = Guru::where('wali_kelas', $kelasName)->first();
            $this->assertNotNull($wali, "Wali kelas untuk {$kelasName} harus terdaftar.");
            
            $count = Siswa::where('kelas', $kelasName)->count();
            $this->assertGreaterThanOrEqual(25, $count, "Kelas {$kelasName} harus memiliki minimal 25 siswa aktif.");

            $res = $this->actingAs($admin)->get(route('admin.walikelas.index', ['kelas' => $kelasName]));
            $res->assertStatus(200);
            $res->assertSee("Kelas Binaan {$kelasName}");
            $res->assertSee($wali->nama);
            $res->assertDontSee('Belum ada data peserta didik di kelas ini.');
        }
    }
}

