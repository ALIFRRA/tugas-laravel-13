<?php

namespace Tests\Feature;

use App\Models\Agenda;
use App\Models\Guru;
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

    public function test_public_japanese_vocational_school_routes_are_accessible(): void
    {
        // 1. Beranda / Top Page (ホーム)
        $responseHome = $this->get('/');
        $responseHome->assertStatus(200);
        $responseHome->assertSee('SMK SHUKA');
        $responseHome->assertSee('秀華高等専門学校');

        // 2. Profil Sekolah (学校案内)
        $responseProfil = $this->get('/profil');
        $responseProfil->assertStatus(200);
        $responseProfil->assertSee('Profil Sekolah (学校案内)');
        $responseProfil->assertSee('Seika Ijichi');

        // 3. Program Keahlian (学科紹介)
        $responseJurusan = $this->get('/jurusan');
        $responseJurusan->assertStatus(200);
        $responseJurusan->assertSeeText('Seni Musik Populer & Band (SMP)');
        $responseJurusan->assertSeeText('Audio Engineering & Tata Suara (AET)');
        $responseJurusan->assertSeeText('Desain Komunikasi Visual & Merchandise (DKV)');
        $responseJurusan->assertSeeText('Rekayasa Perangkat Lunak & Multimedia (RPL)');
        $responseJurusan->assertSeeText('Manajemen Bisnis Pertunjukan & Live Event (MBE)');

        // 4. Tenaga Pendidik (教職員紹介)
        $responseGuru = $this->get('/guru');
        $responseGuru->assertStatus(200);
        $responseGuru->assertSee('Tenaga Pendidik & Instruktur (教職員紹介)');

        // 5. Ekstrakurikuler (部活動)
        $responseEkskul = $this->get('/ekskul');
        $responseEkskul->assertStatus(200);
        $responseEkskul->assertSee('Kessoku Band');
        $responseEkskul->assertSee('12 Klub Aktif');

        // 6. Agenda & Pengumuman (行事・お知らせ)
        $responseAgenda = $this->get('/agenda-pengumuman');
        $responseAgenda->assertStatus(200);
        $responseAgenda->assertSeeText('Agenda & Pengumuman Sekolah');

        // 7. Kontak & Akses (交通アクセス)
        $responseKontak = $this->get('/kontak');
        $responseKontak->assertStatus(200);
        $responseKontak->assertSee('Shimokitazawa');
        $responseKontak->assertSee('小田急小田原線');
    }

    public function test_admin_dashboard_and_modules_walkthrough(): void
    {
        $admin = User::where('email', 'admin@shuka.test')->first();
        $this->assertNotNull($admin);

        // 1. Admin Dashboard
        $responseDash = $this->actingAs($admin)->get('/dashboard');
        $responseDash->assertStatus(200);
        $responseDash->assertSee('Dasbor Akademik SMK Shuka');

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
            'tanggal' => '15 Ags 2026',
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
        $responseEkskulAdmin->assertSee('Direktori Ekstrakurikuler SMK Shuka (12 Klub)');

        // 6. User Profile Show
        $responseProfile = $this->actingAs($admin)->get(route('profile.show', $admin->id));
        $responseProfile->assertStatus(200);
        $responseProfile->assertSee('Profil Pengguna');
    }

    public function test_guru_can_access_dashboard_and_manage_grades(): void
    {
        $guruUser = User::where('role', 'guru')->first();
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
        $guruUser = User::where('role', 'guru')->first();
        $this->assertNotNull($guruUser);

        // 1. Guru can access Pelanggaran & Sanksi
        $responsePelanggaran = $this->actingAs($guruUser)->get(route('admin.pelanggaran.index'));
        $responsePelanggaran->assertStatus(200);

        // 2. Guru can record violation
        $siswa = Siswa::first();
        $this->actingAs($guruUser)->post(route('admin.pelanggaran.store'), [
            'siswa_id' => $siswa->id,
            'jenis_pelanggaran' => 'Tidak Membawa Partitur Not Balok',
            'kategori' => 'Ringan',
            'poin' => 5,
            'sanksi' => 'Latihan solfeggio mandiri',
            'tanggal' => '15 Ags 2026',
            'guru_pencatat' => $guruUser->name,
            'status' => 'Selesai',
        ]);

        $this->assertDatabaseHas('pelanggarans', [
            'siswa_id' => $siswa->id,
            'jenis_pelanggaran' => 'Tidak Membawa Partitur Not Balok',
        ]);

        // 3. Guru can access Agenda Sekolah
        $responseAgenda = $this->actingAs($guruUser)->get(route('admin.agenda.index'));
        $responseAgenda->assertStatus(200);

        // 4. Guru can access Ekstrakurikuler
        $responseEkskul = $this->actingAs($guruUser)->get(route('admin.ekskul.index'));
        $responseEkskul->assertStatus(200);

        // 5. Guru can access Data Siswa
        $responseSiswa = $this->actingAs($guruUser)->get(route('admin.siswa.index'));
        $responseSiswa->assertStatus(200);
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

        // 1. Kepala TU can access Data Guru and Mapel
        $this->actingAs($tuHead)->get(route('admin.guru.index'))->assertStatus(200);
        $this->actingAs($tuHead)->get(route('admin.mapel.index'))->assertStatus(200);

        // 2. IT Staff can access Data Guru and Jadwal
        $this->actingAs($itStaff)->get(route('admin.guru.index'))->assertStatus(200);
        $this->actingAs($itStaff)->get(route('admin.jadwal.index'))->assertStatus(200);

        // 3. Kepsek and Wakepsek can access Data Guru
        $this->actingAs($kepsek)->get(route('admin.guru.index'))->assertStatus(200);
        $this->actingAs($wakepsek)->get(route('admin.guru.index'))->assertStatus(200);
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

        // 3. Blocked from Data Guru (403 Forbidden)
        $this->actingAs($kesiswaan)->get(route('admin.guru.index'))->assertStatus(403);
        $this->actingAs($koperasi)->get(route('admin.guru.index'))->assertStatus(403);
        $this->actingAs($guruUmum)->get(route('admin.guru.index'))->assertStatus(403);
    }
}


