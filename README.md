<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400">
  </a>
</p>

# SI-MBEK

**SI-MBEK** (Sistem Informasi Monitoring Peternakan Kambing) adalah aplikasi web berbasis Laravel yang dikembangkan untuk membantu peternak, admin, dan superadmin dalam memantau, mengelola, dan meningkatkan efisiensi manajemen peternakan kambing. Sistem ini menyediakan fitur monitoring kesehatan, pertumbuhan, vaksinasi, serta penjualan kambing secara digital dan transparan.

---

## Fitur Utama

- **Manajemen Kambing:** Tambah, edit, hapus, dan lihat detail data kambing.
- **Manajemen Pemilik:** Kelola data pemilik/peternak dan relasinya dengan kambing.
- **Monitoring Kesehatan & Vaksinasi:** Catat dan pantau status kesehatan serta vaksinasi kambing.
- **Manajemen Penjualan:** Tandai kambing siap jual dan kelola data penjualan.
- **Upload & Resize Foto:** Simpan foto kambing dengan fitur resize otomatis untuk efisiensi penyimpanan.
- **Dashboard User & Superadmin:** Tampilan dashboard khusus untuk masing-masing peran.
- **Hak Akses Terpisah:** Otorisasi user & superadmin, keamanan data lebih terjaga.
- **Pencarian & Paginasi:** Navigasi data mudah dan cepat.
- **Notifikasi & Validasi:** Feedback sistem untuk setiap aksi penting.

---

## Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/rizkipgt/SI-MBEK-v3.git
   cd SI-MBEK
   ```

2. **Install Dependency**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi Database**
   ```bash
   php artisan migrate
   ```

5. **Buat Storage Link**
   ```bash
   php artisan storage:link
   ```

6. **Jalankan Server & Asset**
   ```bash
   php artisan serve
   npm run dev
   ```

---

## Update Project

1. Buat branch baru sesuai fitur yang dikerjakan (contoh: navbar, halaman-utama, dsb).
2. Setelah selesai, jalankan:
   ```bash
   git add .
   git commit -m "deskripsi update"
   git push origin <nama_branch>
   ```
   **Catatan:** Jangan push langsung ke branch `main`.

---

## Struktur Folder Utama

- `app/Http/Controllers` — Logika aplikasi (controller)
- `app/Models` — Model data
- `database/migrations` — Migrasi database
- `resources/views` — Tampilan (Blade)
- `public/uploads` — File upload (foto kambing)
- `routes/web.php` — Rute aplikasi

---

## Kontribusi

Kontribusi sangat terbuka!  
Silakan fork repository ini, buat branch baru untuk fitur atau perbaikan, dan ajukan pull request.

---

## Tim Pengembang

### SI MBEK V1
- Yos Marison Sianipar ([@vianpr0](https://github.com/vianpr0))
- Rizki Pangestu ([@rizkipgt](https://github.com/rizkipgt))
- Elika Dwi Utami ([@ElikaDwiUtami](https://github.com/ElikaDwiUtami))

### SI MBEK V2
- Teguh Karya Rizki ([@Teguhkr](https://github.com/Teguhkr))
- Rizki Pangestu ([@rizkipgt](https://github.com/rizkipgt))
- Elika Dwi Utami ([@ElikaDwiUtami](https://github.com/ElikaDwiUtami))

---

## Lisensi

Proyek ini bersifat privat dan untuk pengembangan internal.  
Untuk akses lebih lanjut, silakan hubungi pengelola.

---

<p align="center">
  <b>SI-MBEK</b> — Sistem Informasi Monitoring Peternakan Kambing<br>
  <i>Dikembangkan oleh Universitas Lampung, 2025</i>
</p>
