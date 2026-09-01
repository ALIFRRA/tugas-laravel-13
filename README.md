# SMK Shuka (秀華高等専門学校) — Sistem Informasi Akademik & Portal Kejuruan

[![Laravel 13](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP 8.3+](https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![MySQL / MariaDB](https://img.shields.io/badge/Database-MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge)](https://opensource.org/licenses/MIT)

**SMK Shuka (Hasilsetres)** adalah aplikasi web Sistem Informasi Akademik (SIA) dan Portal Sekolah Menengah Kejuruan berbasis Laravel 13, Blade Templating Engine, dan MySQL. Aplikasi ini dirancang untuk memfasilitasi tata kelola akademik terpadu—mencakup pengelolaan data guru, siswa, kurikulum mata pelajaran, jadwal mingguan, rekap dan analisis nilai, catatan kedisiplinan kesiswaan (BK), ekstrakurikuler, kalender agenda, hingga pengumuman digital interaktif.

Proyek ini sekaligus menjadi implementasi lengkap dan mendalam atas seluruh materi praktikum:
- BAB 4: Controller Laravel 13
- BAB 5: Blade Template Engine
- BAB 6: Database Migration & Seeder

---

## Pemenuhan Standar Kurikulum Praktikum

### BAB 4 – Controller Laravel 13
- **Pembuatan Controller Artisan**: Controller dibuat terstruktur menggunakan `php artisan make:controller`.
- **Resource Controller (RESTful)**: Implementasi penuh 7 method RESTful (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`) pada data Tenaga Guru (`Admin\GuruController`) dan seluruh modul akademik lainnya.
- **Dependency Injection**: Menggunakan `Request $request` serta Form Request kelas terdedikasi (`StoreGuruRequest`, `UpdateGuruRequest`, `StoreSiswaRequest`, dll.) untuk validasi data input yang ketat dan aman.
- **Response JSON API**: Menyediakan endpoint `GET /api/guru` yang mengembalikan koleksi data guru terformat JSON melalui `response()->json(...)`.
- **Redirect & Flash Message**: Integrasi alur redirect pasca-aksi (`return redirect()->route(...)->with('success', '...')`) dengan notifikasi dinamis pada view Blade.
- **Tantangan & Keamanan**: Dukungan database transaction (`DB::transaction`), penanganan error terpadu (`back()->with('error', ...)`), dan pencegahan penghapusan relasi aktif.

### BAB 5 – Blade Template Engine
- **Master Layouts Hirarkis**:
  - `layouts/admin.blade.php`: Kerangka antarmuka pengelola (Admin, Kepsek, Ka. TU, Staf IT).
  - `layouts/guru.blade.php`: Portal kerja khusus tenaga pendidik.
  - `layouts/murid.blade.php`: Portal siswa untuk transkrip nilai dan jadwal.
  - `layouts/public.blade.php`: Portal profil publik dan informasi sekolah.
  - `layouts/app.blade.php`: Layout dasar aplikasi.
- **Directives Blade Lengkap**: Pemanfaatan `@extends`, `@section`, `@yield`, `@include`, `@if`, `@foreach`, `@auth`, dan `@guest`.
- **Partials Modular**:
  - `partials/navbar.blade.php`: Bar navigasi atas dan identitas pengguna aktif.
  - `partials/sidebar.blade.php`: Bar navigasi samping multi-level dengan indikator semester.
  - `partials/footer.blade.php`: Hak cipta dan informasi kemitraan sekolah.
- **Blade Components & Slots (`{{ $slot }}`)**:
  - `<x-alert />`: Komponen alert notifikasi session flash (sukses, error, dan validasi form).
  - `<x-card>`: Komponen pembungkus panel konten modular.
  - `<x-avatar>`: Komponen avatar pengguna dengan progressive loading dan inisial fallback.
  - `<x-button>`, `<x-modal>`, `<x-table>`, `<x-input>`, dll.
- **7 Halaman Utama Proyek Mini Terpenuhi**:
  1. **Dashboard**: Statistik metrik, jadwal harian, nilai terbaru, dan notifikasi pengumuman.
  2. **Data Guru**: Pencarian multi-kriteria guru, NIP, mapel diampu, dan profil detail.
  3. **Data Siswa**: Database 600 siswa dengan filter multi-kriteria rombel (Tingkat, Jurusan, Gender).
  4. **Mata Pelajaran**: Kurikulum kejuruan dan umum dengan penautan guru pengampu.
  5. **Jadwal Pelajaran**: Alokasi jadwal mingguan 18 rombel kelas (Senin s/d Sabtu).
  6. **Rekap & Analisis Nilai**: Entri nilai tugas/UTS/UAS, visualisasi peringkat, dan ekspor CSV.
  7. **Profil Pengguna**: Manajemen akun personal, pergantian avatar, dan detail biodata.

### BAB 6 – Migration & Seeder
- **Struktur Database Relasional**:
  - `gurus`: Tabel data tenaga pendidik (NIP, no telepon, relasi akun user).
  - `siswas`: Tabel data peserta didik (NIS, kelas, gender, alamat, tgl lahir).
  - `mata_pelajarans`: Tabel kurikulum mapel dengan *foreign key* `guru_id`.
  - `jadwals`, `nilais`, `users`, `ekskuls`, `pelanggarans`, `pengumumans`, `agendas`.
- **Migration Modifikasi & Versioning**:
  - Migrasi penambahan kolom avatar, role, dan jabatan pada tabel users.
  - Migrasi refactor relasi guru dan mata pelajaran.
  - Migrasi implementasi *Soft Deletes* (`deleted_at`) pada seluruh entitas akademik.
- **Rollback & Refresh Ready**: Seluruh berkas migrasi dilengkapi method `up()` dan `down()` yang konsisten untuk mendukung `php artisan migrate:rollback` dan `php artisan migrate:refresh --seed`.
- **AcademicSeeder Komprehensif**:
  - **45 Tenaga Guru** aktif lengkap dengan data akun dan NIP resmi.
  - **600 Peserta Didik** terdistribusi di 18 rombel kelas kejuruan (X, XI, XII).
  - **45 Mata Pelajaran** kejuruan seni musik, audio engineering, DKV, RPL, dan umum.
  - Ratusan data jadwal, rekap nilai akademik, klub ekskul, agenda, dan pengumuman.

---

## Matriks Hak Akses & Multi-Role Authentication

| Fitur / Modul | Publik | Siswa (Murid) | Guru | Admin & Pimpinan (Kepsek, Wakepsek, TU, IT) |
|---|:---:|:---:|:---:|:---:|
| Beranda & Profil Publik | Ya | Ya | Ya | Ya |
| Dashboard Khusus | Tidak | Portal Siswa | Portal Guru | Dasbor Utama Admin |
| Manajemen Data Guru (CRUD) | Direktori Saja | Tidak | Tidak | Full CRUD |
| Manajemen Data Siswa (CRUD) | Tidak | Tidak | Read-only | Full CRUD |
| Input & Kelola Nilai | Tidak | Transkrip Sendiri | Input Mapelnya | Full CRUD & Analisis CSV |
| Catatan Kedisiplinan (BK) | Tidak | Poin Sendiri | Catat Pelanggaran | Full Manajemen Sanksi |
| Agenda & Pengumuman | Publik | Pengumuman | Agenda | Full Kelola & Toggle |
| API Guru JSON (`/api/guru`) | Tidak | Tidak | Tidak | Akses Terotentikasi |

---

## Akun Demo Pengujian (Default Credentials)

Semua akun demo di bawah ini menggunakan kata sandi standar: **`password`**

| Role / Jabatan | Alamat Email | Hak Akses Utama |
|---|---|---|
| Super Administrator | `admin@shuka.test` | Akses penuh ke seluruh fitur dan pengaturan sistem |
| Kepala Sekolah | `seika@shuka.test` | Administrator level (Pimpinan institusi & STARRY) |
| Wakepsek Bidang IT & Kurikulum | `pasan@shuka.test` | Administrator level (Pengelolaan kurikulum & IT) |
| Kepala Tata Usaha | `tu@shuka.test` | Administrator level (Administrasi & Kesiswaan) |
| Staf TU Bagian IT | `it@shuka.test` | Administrator level (Pemeliharaan data sistem) |
| Guru & Wali Kelas X-SMP-1 (Yoshida Emi) | `guru10@shuka.test` | Portal Guru: input nilai & modul wali kelas rombel X-SMP-1 |
| Guru Pengampu Lainnya | `guru1@shuka.test` s/d `guru45@shuka.test` | Portal Guru: input nilai & catatan pelanggaran |
| Siswa (Hitori Gotoh) | `student1@murid.shuka.test` | Portal Siswa: transkrip rapor & jadwal kelas |
| Siswa Umum | `murid1@shuka.test` s/d `murid590@shuka.test` | Portal Siswa |

---

## Struktur Direktori Proyek

```text
hasilsetres/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/              # Controller CRUD modul Administrator & Pimpinan
│   │   │   │   ├── GuruController.php
│   │   │   │   ├── SiswaController.php
│   │   │   │   ├── MapelController.php
│   │   │   │   ├── JadwalController.php
│   │   │   │   ├── NilaiController.php
│   │   │   │   ├── AnalisisNilaiController.php
│   │   │   │   ├── PelanggaranController.php
│   │   │   │   ├── PengumumanController.php
│   │   │   │   └── EkskulController.php
│   │   │   ├── Guru/               # Controller modul Tenaga Pendidik
│   │   │   ├── Murid/              # Controller modul Peserta Didik
│   │   │   ├── Auth/               # Autentikasi Laravel Breeze
│   │   │   ├── DashboardController.php
│   │   │   └── PublicController.php
│   │   └── Requests/Admin/         # Form Request Validation (Store & Update)
│   ├── Models/                     # Eloquent Models & Relasi Database
│   │   ├── Guru.php, Siswa.php, MataPelajaran.php, Jadwal.php, Nilai.php
│   │   ├── User.php, Ekskul.php, Pelanggaran.php, Pengumuman.php, Agenda.php
│   └── Services/AvatarService.php  # Layanan avatar dinamis & progressive loading
├── database/
│   ├── migrations/                 # Skema tabel database & modifikasi kolom
│   └── seeders/                    # AcademicSeeder & DatabaseSeeder
├── resources/
│   └── views/
│       ├── layouts/                # Master layout (admin, guru, murid, public, app)
│       ├── partials/               # Partials (navbar, sidebar, footer)
│       ├── components/             # Blade components (alert, card, avatar, button, modal)
│       ├── admin/                  # View CRUD admin (guru, siswa, mapel, jadwal, nilai, dll.)
│       ├── guru/                   # View portal guru
│       ├── murid/                  # View portal siswa
│       ├── public/                 # View profil sekolah publik
│       └── profile/                # View profil pengguna
├── routes/
│   ├── web.php                     # Definisi rute web & middleware
│   └── auth.php                    # Rute autentikasi
└── tests/
    └── Feature/                    # Automated Feature & Integration Tests
```

---

## Panduan Instalasi dan Penggunaan

### 1. Prasyarat Sistem
- PHP >= 8.3 dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `bcmath`
- Composer (Dependency Manager PHP)
- Node.js (v18+) & NPM
- MySQL / MariaDB (melalui Laragon, XAMPP, atau Docker)

### 2. Langkah Instalasi

```bash
# 1. Kloning repositori
git clone https://github.com/ALIFRRA/hasilsetres.git
cd hasilsetres

# 2. Instal dependensi backend (Composer)
composer install

# 3. Instal dependensi frontend (NPM)
npm install

# 4. Buat salinan berkas environment
cp .env.example .env

# 5. Generate Application Encryption Key
php artisan key:generate
```

### 3. Konfigurasi Database

Buka berkas `.env` lalu sesuaikan konfigurasi database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hasilsetres_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Menjalankan Migrasi, Seeder, dan Server

```bash
# Jalankan migrasi database dan isi seluruh data akademik contoh
php artisan migrate:refresh --seed

# Kompilasi aset frontend
npm run build
# Atau jalankan Vite development server:
# npm run dev

# Jalankan server pengembangan Laravel
php artisan serve
```

Aplikasi siap diakses melalui peramban pada tautan: `http://127.0.0.1:8000`

---

## Pengujian Otomatis (Automated Testing)

Aplikasi telah dilengkapi rangkaian automated feature tests berbasis PHPUnit untuk menguji seluruh rute publik, hak akses role middleware, autentikasi, controller CRUD, hingga response JSON API:

```bash
php artisan test
```

---

## Lisensi

Proyek ini dilindungi di bawah lisensi terbuka [MIT License](LICENSE).
