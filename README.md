# Hasilsetres (Web CRUD Laravel)

Dokumentasi repositori **Hasilsetres**, sebuah aplikasi web berbasis CRUD (Create, Read, Update, Delete) yang dibangun menggunakan kerangka kerja Laravel dan Blade engine, serta dikelola menggunakan NPM. Proyek ini dikembangkan sebagai bentuk eksperimen sederhana untuk menyalurkan kejenuhan koding.

---

## Fitur Utama

- **Create**: Menambahkan data baru ke dalam database.
- **Read**: Menampilkan seluruh entri data yang tersimpan secara terstruktur.
- **Update**: Memperbarui informasi data yang telah ada.
- **Delete**: Menghapus data dari sistem secara permanen.
- **Blade Templating**: Antarmuka pengguna yang terintegrasi menggunakan komponen Blade milik Laravel (`@extends`, `@section`, `@yield`).

---

## Tumpukan Teknologi (Tech Stack)

- **Backend**: Laravel Framework
- **Frontend Engine**: Laravel Blade Templating & CSS
- **Package Manager**: NPM (Node Package Manager) untuk manajemen aset antarmuka
- **Database**: MySQL / MariaDB

---

## Panduan Instalasi dan Penggunaan

### 1. Prasyarat Sistem
- PHP >= 8.1
- Composer
- Node.js & NPM
- Database MySQL/MariaDB (Laragon / XAMPP / Docker)

### 2. Langkah-Langkah Instalasi

1. **Kloning Repositori**:
   ```bash
   git clone https://github.com/ALIFRRA/hasilsetres.git
   cd hasilsetres
   ```

2. **Instalasi Dependensi PHP (Composer)**:
   ```bash
   composer install
   ```

3. **Instalasi Dependensi JavaScript (NPM)**:
   ```bash
   npm install
   ```

4. **Konfigurasi Lingkungan (.env)**:
   Salin berkas konfigurasi sampel menjadi berkas `.env` utama:
   ```bash
   cp .env.example .env
   ```

5. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

### 3. Konfigurasi Database
Buka berkas `.env` dan sesuaikan parameter kredensial database lokal Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hasilsetres_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi Database dan Jalankan Server

```bash
# Jalankan skrip migrasi untuk membuat tabel
php artisan migrate

# Kompilasi aset frontend via NPM
npm run dev

# Jalankan server pengembangan lokal
php artisan serve
```

Akses aplikasi melalui peramban pada alamat `http://127.0.0.1:8000`.

---

## Analisis Risiko dan Evaluasi Arsitektur

- **Trade-off Performa (Tingkat Keyakinan Risiko: Tinggi)**: Proses kompilasi aset pada lingkungan pengembangan (`npm run dev`) perlu ditransisikan ke mode produksi (`npm run build`) sebelum dilakukan *deployment* untuk meminimalkan beban *load time* peramban.
- **Keamanan Aplikasi (Tingkat Keyakinan Risiko: Sedang)**: Pastikan variabel `APP_DEBUG` pada berkas `.env` diatur ke `false` saat aplikasi diakses oleh publik untuk menghindari kebocoran jejak *stack trace* dan informasi sensitif.
- **Integritas Database (Tingkat Keyakinan Risiko: Rendah)**: Operasi hapus data (*Delete*) saat ini bersifat permanen. Disarankan menerapkan *Soft Deletes* milik Laravel jika data yang dihapus masih membutuhkan audit atau pemulihan di kemudian hari.

---

## Kontribusi

Kontribusi dan perbaikan bug terbuka untuk siapa saja.

1. *Fork* repositori ini.
2. Buat cabang fitur baru (`git checkout -b feature/FiturBaru`).
3. Lakukan *commit* perubahan (`git commit -m 'Menambahkan FiturBaru'`).
4. Unggah ke cabang tujuan (`git push origin feature/FiturBaru`).
5. Buat *Pull Request*.

---

## Lisensi

Repositori ini dilindungi di bawah **MIT License**.
