<?php

use App\Http\Controllers\Admin\AgendaKessokuController;
use App\Http\Controllers\Admin\AnalisisNilaiController;
use App\Http\Controllers\Admin\EkskulController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\NilaiController;
use App\Http\Controllers\Admin\PelanggaranController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\WaliKelasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\NilaiController as GuruNilaiController;
use App\Http\Controllers\Murid\DashboardController as MuridDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileShowController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// --- PUBLIC ROUTES (Sekolah Menengah Kejuruan Negeri / 秀華高等専門学校) ---
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/profil', [PublicController::class, 'profil'])->name('public.profil');
Route::get('/jurusan', [PublicController::class, 'jurusan'])->name('public.jurusan');
Route::get('/profil/guru', [PublicController::class, 'guru'])->name('public.guru');
Route::get('/api/guru', [GuruController::class, 'apiIndex'])
    ->middleware(['auth', 'can_access:admin_level', 'throttle:60,1'])
    ->name('api.guru.index');
Route::get('/ekskul', [PublicController::class, 'ekskul'])->name('public.ekskul');
Route::get('/agenda-pengumuman', [PublicController::class, 'agenda'])->name('public.agenda');
Route::get('/kontak', [PublicController::class, 'kontak'])->name('public.kontak');
Route::get('/avatar/{filename}', [ProfileShowController::class, 'avatar'])
    ->where('filename', '[A-Za-z0-9_-]+\.(jpg|jpeg|png|webp|gif)')
    ->name('avatar.show');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/shuka-dashboard', function () {
    return response()->file(public_path('shuka-dashboard.html'));
})->name('shuka.dashboard');

// --- AUTHENTICATED USERS ROUTES ---
Route::middleware('auth')->group(function () {
    Route::get('/profile/{id}', [ProfileShowController::class, 'show'])->name('profile.show');
    Route::put('/profile/{id}', [ProfileShowController::class, 'update'])->name('profile.update.user');

    Route::get('/account/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/account/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/account/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin & Staff & Guru Shared Management Group
    Route::prefix('admin')->name('admin.')->group(function () {

        // Modul yang dapat dibaca guru dan staf tanpa hak mengubah data.
        Route::middleware('can_access:school_tables')->group(function () {
            Route::get('siswa', [SiswaController::class, 'index'])->name('siswa.index');
            Route::get('siswa/{siswa}', [SiswaController::class, 'show'])->whereNumber('siswa')->name('siswa.show');
            Route::get('ekskul', [EkskulController::class, 'index'])->name('ekskul.index');
            Route::get('ekskul/{ekskul}', [EkskulController::class, 'show'])->whereNumber('ekskul')->name('ekskul.show');
            Route::get('ekskul/{ekskul}/members', [EkskulController::class, 'members'])->name('ekskul.members');
            Route::get('pelanggaran', [PelanggaranController::class, 'index'])->name('pelanggaran.index');
            Route::get('agenda', [AgendaKessokuController::class, 'index'])->name('agenda.index');
            Route::get('pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
            Route::get('mapel', [MapelController::class, 'index'])->name('mapel.index');
            Route::get('mapel/{mapel}', [MapelController::class, 'show'])->whereNumber('mapel')->name('mapel.show');
            Route::get('jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
            Route::get('jadwal/{jadwal}', [JadwalController::class, 'show'])->whereNumber('jadwal')->name('jadwal.show');
            Route::get('wali-kelas', [WaliKelasController::class, 'index'])->name('walikelas.index');
        });

        Route::post('pelanggaran', [PelanggaranController::class, 'store'])
            ->middleware('can_access:discipline_write')
            ->name('pelanggaran.store');

        Route::middleware('can_access:agenda_write')->group(function () {
            Route::resource('agenda', AgendaKessokuController::class)->except(['index', 'show', 'create', 'edit']);
        });

        Route::middleware('can_access:academic_write')->group(function () {
            Route::resource('siswa', SiswaController::class)->except(['index', 'show']);
            Route::resource('ekskul', EkskulController::class)->except(['index', 'show']);
            Route::post('ekskul/{ekskul}/add-member', [EkskulController::class, 'addMember'])->name('ekskul.add-member');
            Route::delete('ekskul/{ekskul}/remove-member/{siswa}', [EkskulController::class, 'removeMember'])->name('ekskul.remove-member');
            Route::put('ekskul/{ekskul}/update-member/{siswa}', [EkskulController::class, 'updateMember'])->name('ekskul.update-member');
            Route::resource('pelanggaran', PelanggaranController::class)->except(['index', 'create', 'show', 'edit', 'store']);
            Route::post('pengumuman/{pengumuman}/toggle', [PengumumanController::class, 'toggle'])->name('pengumuman.toggle');
            Route::resource('pengumuman', PengumumanController::class)->except(['index', 'create', 'show', 'edit']);
        });

        // 2. Modul Tingkat Administrator (Kepsek, Wakepsek, Kepala TU, Staf TU IT, Super Admin)
        Route::middleware('can_access:admin_level')->group(function () {
            Route::resource('mapel', MapelController::class)->except(['index', 'show']);
            Route::resource('jadwal', JadwalController::class)->except(['index', 'show']);
            Route::get('nilai/analisis', [AnalisisNilaiController::class, 'index'])->name('nilai.analisis');
            Route::get('nilai/export', [AnalisisNilaiController::class, 'exportCsv'])->name('nilai.export');
            Route::resource('nilai', NilaiController::class);
            Route::get('pengguna/guru', [PenggunaController::class, 'guru'])->name('pengguna.guru');
            Route::get('pengguna/murid', [PenggunaController::class, 'murid'])->name('pengguna.murid');
        });
    });

    Route::middleware('can_access:admin_level')->group(function () {
        Route::resource('guru', GuruController::class)
            ->names('admin.guru')
            ->whereNumber('guru');
    });

    // Guru Group
    Route::prefix('guru')->name('guru.')->middleware('can_access:guru')->group(function () {
        Route::get('/dashboard', GuruDashboardController::class)->name('dashboard');
        Route::resource('nilai', GuruNilaiController::class)->except(['show']);
    });

    // Murid Group
    Route::prefix('murid')->name('murid.')->middleware('can_access:murid')->group(function () {
        Route::get('/dashboard', MuridDashboardController::class)->name('dashboard');
    });
});

require __DIR__.'/auth.php';
