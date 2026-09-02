# SMK Shuka — Sistem Informasi Akademik & Portal Kejuruan

[![Laravel 13](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP 8.3+](https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![MySQL / MariaDB](https://img.shields.io/badge/Database-MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge)](https://opensource.org/licenses/MIT)

**SMK Shuka** adalah aplikasi web Sistem Informasi Akademik (SIA) dan Portal Sekolah Menengah Kejuruan berbasis Laravel 13, Blade Templating Engine, dan MySQL. Aplikasi ini dirancang untuk memfasilitasi tata kelola akademik terpadu—mencakup pengelolaan data guru, siswa, kurikulum mata pelajaran, jadwal mingguan, rekap dan analisis nilai, catatan kedisiplinan kesiswaan (BK), ekstrakurikuler, kalender agenda, hingga pengumuman digital interaktif.


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
