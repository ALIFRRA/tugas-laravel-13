# Shuka Highschool

Aplikasi akademik Laravel 13 (Blade + Tailwind + Breeze) bertema pink lembut.

## Persyaratan

- PHP 8.3+
- Composer
- Node.js & npm
- MySQL

## Instalasi

1. Salin environment dan sesuaikan kredensial MySQL:

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```
APP_NAME="Shuka Highschool"
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shuka_highschool
DB_USERNAME=root
DB_PASSWORD=
```

2. Buat database MySQL `shuka_highschool`, lalu:

```bash
composer install
npm install
php artisan migrate --seed
npm run build
```

3. Jalankan aplikasi (dua terminal):

```bash
php artisan serve
npm run dev
```

Buka http://127.0.0.1:8000

## Akun demo

Password semua: `password`

| Role | Email |
|------|--------|
| Admin | `admin@shuka.test` |
| Guru | `ryo@shuka.test`, `nijika@shuka.test`, `kita@shuka.test` |
| Murid | `hitori0@murid.shuka.test` (dan murid seed lainnya) |

- Admin → `/dashboard` + `/admin/*` (termasuk pengguna guru/murid)
- Guru → `/guru/dashboard`, kelola nilai mapel sendiri
- Murid → `/murid/dashboard`, lihat nilai & statistik

## Modul

Admin: `/admin/siswa`, `/admin/guru`, `/admin/mapel`, `/admin/jadwal`, `/admin/nilai`, `/admin/pengguna/guru`, `/admin/pengguna/murid`

Profil (nama + avatar Bocchi): `/profile/{id}` — owner edit; admin bisa lihat profil orang lain.

Gambar mascot: `public/images/bocchi.png`, `bocchi-shy.png`, `bocchi-maid.png`

```bash
php artisan storage:link
```
