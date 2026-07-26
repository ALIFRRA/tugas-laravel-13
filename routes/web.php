<?php

use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\NilaiController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\NilaiController as GuruNilaiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Murid\DashboardController as MuridDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileShowController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/{id}', [ProfileShowController::class, 'show'])->name('profile.show');
    Route::put('/profile/{id}', [ProfileShowController::class, 'update'])->name('profile.update.user');

    Route::get('/account/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/account/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/account/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('pengguna/guru', [PenggunaController::class, 'indexGuru'])->name('pengguna.guru');
        Route::get('pengguna/murid', [PenggunaController::class, 'indexMurid'])->name('pengguna.murid');

        Route::resource('siswa', SiswaController::class);
        Route::resource('guru', GuruController::class);
        Route::resource('mapel', MapelController::class);
        Route::resource('jadwal', JadwalController::class);
        Route::resource('nilai', NilaiController::class);
    });

    Route::prefix('guru')->name('guru.')->middleware('role:guru')->group(function () {
        Route::get('/dashboard', GuruDashboardController::class)->name('dashboard');
        Route::resource('nilai', GuruNilaiController::class)->except(['show']);
    });

    Route::prefix('murid')->name('murid.')->middleware('role:murid')->group(function () {
        Route::get('/dashboard', MuridDashboardController::class)->name('dashboard');
    });
});

require __DIR__.'/auth.php';
