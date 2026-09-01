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
use App\Http\Controllers\Admin\WaliKelasController;
use App\Http\Controllers\ApiTestController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\NilaiController as GuruNilaiController;
use App\Http\Controllers\Murid\DashboardController as MuridDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileShowController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
 * API ROUTES - hasilsetres (Laravel 13)
 * 
 * CURRENT STATUS:
 * - Only 1 true API endpoint exists: GET /api/guru
 * - All other routes in routes/web.php return views (HTML)
 * - API response format is inconsistent (mix of views and JSON)
 * 
 * RECOMMENDATIONS for Laravel 13 Best Practices:
 * 1. Move all JSON API endpoints to this routes/api.php file
 * 2. Apply api.php middleware:('api') consistently
 * 3. Use resource routes with consistent JSON response shapes
 * 4. Implement implicit route model binding via TypeHinting
 * 5. Standardize JSON response format: {'data': [...], 'meta': {...}}
 * 6. Version API prefixes (e.g., /api/v1/)
 */

//
// PUBLIC API ENDPOINTS (guest-accessible)
 //

/*
 * GET /api/guru - List all gurus (JSON)
 * 
 * Controller: App\Http\Controllers\Admin\GuruController::apiIndex()
 * Middleware: auth, can_access:admin_level, throttle:60,1
 * Response: { data: [{id, nama, nip, email, no_telepon, mata_pelajaran}, ...] }
 * 
 * TODO: Move to api.php with proper versioning and api middleware group
 */

Route::get('/api/guru', [GuruController::class, 'apiIndex'])
    ->middleware(['auth', 'can_access:admin_level', 'throttle:60,1'])
    ->name('api.guru.index');

// 
// ADMIN API ENDPOINTS (authenticated, can_access:admin_level)
 //

/*
 * Resource routes for admin API - consistent JSON responses
 * 
 * Each resource controller should return:
 * - GET index: { data: [...], meta: { current_page, last_page, total, per_page} }
 * - GET show: { data: {id, ...} }
 * - POST store: { data: {id, ...}, message: "Created successfully" }
 * - PUT/PATCH update: { data: {id, ...}, message: "Updated successfully" }
 * - DELETE destroy: { data: null, message: "Deleted successfully" }
 */

// Guru resource API (full resource with model binding)
Route::prefix('guru')->name('api.guru.')->middleware('can_access:guru')->group(function () {
    // API version prefix consideration: /api/v1/guru
    Route::resource('nilai', GuruNilaiController::class)->except(['show']);
    // Single guru lookup with explicit model binding
    Route::get('guru/{guru}', [GuruController::class, 'show'])
        ->middleware('can_access:guru')
        ->name('guru.show');
});

// Siswa resource API
Route::prefix('siswa')->name('api.siswa.')->middleware('can_access:school_tables')->group(function () {
    Route::resource('siswa', SiswaController::class)->except(['index', 'show']);
    Route::get('siswa/{siswa}', [SiswaController::class, 'show'])
        ->whereNumber('siswa')
        ->name('siswa.show');
});

// Ekskul resource API
Route::prefix('ekskul')->name('api.ekskul.')->middleware('can_access:school_tables')->group(function () {
    Route::resource('ekskul', EkskulController::class)->except(['index', 'show']);
    Route::get('ekskul/{ekskul}', [EkskulController::class, 'show'])
        ->whereNumber('ekskul')
        ->name('ekskul.show');
    Route::get('ekskul/{ekskul}/members', [EkskulController::class, 'members'])
        ->name('ekskul.members');
});

// Mapel resource API
Route::prefix('mapel')->name('api.mapel.')->middleware('can_access:school_tables')->group(function () {
    Route::resource('mapel', MapelController::class)->except(['index', 'show']);
    Route::get('mapel/{mapel}', [MapelController::class, 'show'])
        ->whereNumber('mapel')
        ->name('mapel.show');
});

// Jadwal resource API
Route::prefix('jadwal')->name('api.jadwal.')->middleware('can_access:school_tables')->group(function () {
    Route::resource('jadwal', JadwalController::class)->except(['index', 'show']);
    Route::get('jadwal/{jadwal}', [JadwalController::class, 'show'])
        ->whereNumber('jadwal')
        ->name('jadwal.show');
});

// Pelanggaran resource API
Route::prefix('pelanggaran')->name('api.pelanggaran.')->middleware('can_access:discipline_write')->group(function () {
    Route::resource('pelanggaran', PelanggaranController::class)->except(['index', 'create', 'show', 'edit', 'store']);
    Route::post('pelanggaran', [PelanggaranController::class, 'store'])
        ->name('pelanggaran.store');
});

// Agenda resource API
Route::prefix('agenda')->name('api.agenda.')->middleware('can_access:agenda_write')->group(function () {
    Route::resource('agenda', AgendaKessokuController::class)->except(['index', 'show', 'create', 'edit']);
});

// Pengumuman resource API
Route::prefix('pengumuman')->name('api.pengumuman.')->middleware('can_access:academic_write')->group(function () {
    Route::resource('pengumuman', PengumumanController::class)->except(['index', 'create', 'show', 'edit']);
    Route::post('pengumuman/{pengumuman}/toggle', [PengumumanController::class, 'toggle'])
        ->name('pengumuman.toggle');
});

// Guru dashboard (API-compatible)
Route::get('guru/dashboard', GuruDashboardController::class)->name('api.guru.dashboard');

// Murid dashboard (API-compatible)
Route::prefix('murid')->name('api.murid.')->middleware('can_access:murid')->group(function () {
    Route::get('dashboard', MuridDashboardController::class)->name('api.murid.dashboard');
});

// Analytics/analysis API
Route::get('nilai/analisis', [AnalisisNilaiController::class, 'index'])
    ->name('api.nilai.analisis');
Route::get('nilai/export', [AnalisisNilaiController::class, 'exportCsv'])
    ->name('api.nilai.export');

// User profile API
Route::middleware('auth')->group(function () {
    Route::get('profile/{id}', [ProfileShowController::class, 'show'])
        ->name('api.profile.show');
    Route::put('profile/{id}', [ProfileShowController::class, 'update'])
        ->name('api.profile.update');
    Route::patch('account/profile', [ProfileController::class, 'update'])
        ->name('api.profile.edit.update');
    Route::delete('account/profile', [ProfileController::class, 'destroy'])
        ->name('api.profile.destroy');
});

//
// RESPONSE FORMAT CONSISTENCY
 //

/*
 * Standard JSON Response Shape (Laravel 13):
 * 
 * SUCCESS responses:
 * [
 *     'status' => 'success',
 *     'data' => [...|{}],
 *     'message' => 'Optional success message',
 *     'meta' => [
 *         'page' => current_page,
 *         'per_page' => items_per_page,
 *         'total' => total_items,
 *         'last_page' => last_page_number,
 *     ]
 * ]
 * 
 * ERROR responses:
 * [
 *     'status' => 'error',
 *     'message' => 'Human-readable error description',
 *     'errors' => [...], // Validation errors
 *     'status_code' => HTTP status code
 * ]
 * 
 * PAGINATED responses (using Laravel's Resource classes):
 * The above meta fields come from Laravel's LengthAwarePaginator
 * automatically when using API Resources.
 */

// Example API Resource pattern (to be created in app/HttpResources/):
/*
 * php artisan make:resource Admin/GuruResource
 * php artisan make:resource Admin/SiswaResource
 * php artisan make:resource Admin/EkskulResource
 * 
 * Each resource should shape the JSON output consistently.
 * 
 * Example GuruResource:
 * public function toArray($request): array
 * {
 *     return [
 *         'id' => $this->id,
 *         'nama' => $this->nama,
 *         'nip' => $this->nip,
 *         'email' => $this->user?->email,
 *         'no_telepon' => $this->no_telepon,
 *         'mata_pelajaran' => $this->mataPelajarans->pluck('nama')->values(),
 *     ];
 * }
 */

//
// MIDDLEWARE CONSISTENCY
 //

/*
 * Recommended middleware groups for api.php:
 * 
 * 'api' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
 * 'throttle:60,1' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
 * 'auth' => \App\Http\Middleware\Authenticate::class,
 * 'can_access:*' => \App\Http\Middleware\CanAccess::class,
 * 
 * Current api.php lacks - needs:
 * - api middleware group with SubstituteBindings (implicit model binding)
 * - Consistent throttle rates
 * - Proper auth guards
 */

//
// MODEL BINDING
 //

/*
 * Current state: Explicit whereNumber() used in routes/web.php
 * 
 * Laravel 13 recommendation: Use implicit route model binding via type-hinting
 * in controllers, combined with the 'api' middleware group which automatically
 * substitutes bindings using key (primary key) lookup.
 * 
 * Example (after moving to api.php with 'api' middleware):
 * 
 * // Controller method:
 * public function show(Guru $guru) // $guru automatically resolved by key
 * {
 *     return response()->json(['data' => $guru->only(['id', 'nama', 'nip'])]);
 * }
 * 
 * // Route:
 * Route::get('guru/{guru}', [GuruController::class, 'show'])
 *     ->name('api.guru.show');
 * 
 * This replaces the current explicit:
 * ->whereNumber('guru')
 */

//
// TODO MIGRATION PATH
 //

/*
 * Phase 1 - Immediate (this audit):
 * 1. Document existing endpoints above
 * 2. Ensure /api/guru returns consistent JSON shape
 * 3. Add api middleware group to existing API routes
 * 
 * Phase 2 - Medium term:
 * 1. Create API Resource classes for all models
 * 2. Move all JSON endpoints from web.php to api.php
 * 3. Replace whereNumber() with implicit model binding
 * 4. Standardize all responses to {status, data, message, meta} format
 * 
 * Phase 3 - Long term:
 * 1. API versioning (/api/v1/, /api/v2/)
 * 2. API rate limiting per endpoint
 * 3. API documentation generation (Laravel Passport/Sanctum + doc generator)
 * 4. Public API portal
 */

// End of api.php