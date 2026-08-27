<?php

use App\Http\Controllers\Admin\AgendaKessokuController;
use App\Http\Controllers\Admin\AnalisisNilaiController;
use App\Http\Controllers\Admin\EkskulController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\NilaiController;
use App\Http\Controllers\Admin\PelanggaranController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\NilaiController as GuruNilaiController;
use App\Http\Controllers\Murid\DashboardController as MuridDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileShowController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// --- PUBLIC ROUTES (Sekolah Menengah Kejuruan Jepang / 秀華高等専門学校) ---
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/profil', [PublicController::class, 'profil'])->name('public.profil');
Route::get('/jurusan', [PublicController::class, 'jurusan'])->name('public.jurusan');
Route::get('/guru', [PublicController::class, 'guru'])->name('public.guru');
Route::get('/api/guru', [GuruController::class, 'apiIndex'])->name('api.guru.index');
Route::get('/ekskul', [PublicController::class, 'ekskul'])->name('public.ekskul');
Route::get('/agenda-pengumuman', [PublicController::class, 'agenda'])->name('public.agenda');
Route::get('/kontak', [PublicController::class, 'kontak'])->name('public.kontak');

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/shuka-dashboard', function () {
    return view('shuka-dashboard');
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

        // 1. Modul Terkait Murid / Kesiswaan (Akses Penuh untuk Admin, Staff, dan Guru)
        Route::middleware('can_access:admin,staff,guru')->group(function () {
            Route::resource('siswa', SiswaController::class);
            Route::resource('agenda', AgendaKessokuController::class)->except(['create', 'show', 'edit']);

            // Ekskul CRUD
            Route::resource('ekskul', EkskulController::class)->except(['index']);
            Route::get('ekskul', [EkskulController::class, 'index'])->name('ekskul.index');
            Route::get('ekskul/{ekskul}/members', [EkskulController::class, 'members'])->name('ekskul.members');
            Route::post('ekskul/{ekskul}/add-member', [EkskulController::class, 'addMember'])->name('ekskul.add-member');
            Route::delete('ekskul/{ekskul}/remove-member/{siswa}', [EkskulController::class, 'removeMember'])->name('ekskul.remove-member');
            Route::put('ekskul/{ekskul}/update-member/{siswa}', [EkskulController::class, 'updateMember'])->name('ekskul.update-member');

            Route::resource('pelanggaran', PelanggaranController::class)->except(['create', 'show', 'edit']);
            Route::post('pengumuman/{pengumuman}/toggle', [PengumumanController::class, 'toggle'])->name('pengumuman.toggle');
            Route::resource('pengumuman', PengumumanController::class)->except(['create', 'show', 'edit']);
        });

        // 2. Modul Tingkat Administrator (Kepsek, Wakepsek, Kepala TU, Staf TU IT, Super Admin)
        Route::middleware('can_access:admin_level')->group(function () {
            Route::resource('guru', GuruController::class);
            Route::resource('mapel', MapelController::class);
            Route::resource('jadwal', JadwalController::class);
            Route::get('nilai/analisis', [AnalisisNilaiController::class, 'index'])->name('nilai.analisis');
            Route::get('nilai/export', [AnalisisNilaiController::class, 'exportCsv'])->name('nilai.export');
            Route::resource('nilai', NilaiController::class);
        });
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
