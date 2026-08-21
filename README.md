# SiPinjam - Sistem Peminjaman Barang Kampus

Aplikasi Laravel 13 untuk peminjaman barang kampus dengan role `admin` dan `mahasiswa`.

## Fitur

### Mahasiswa
- Login dan registrasi
- Dashboard ringkasan peminjaman
- Katalog barang
- Pencarian dan filter kategori
- Detail barang
- Pengajuan peminjaman
- Riwayat dan detail peminjaman
- Profil

### Admin
- Dashboard statistik
- CRUD barang
- Upload foto barang
- Kelola peminjaman
- Setujui/tolak peminjaman
- Tandai barang sudah diserahkan
- Tandai barang sudah dikembalikan
- Kelola pengguna dan role
- Profil admin

## Teknologi
- Laravel 13
- PHP 8.3+
- MySQL
- Blade
- Tailwind CSS via CDN

## Menjalankan di Laragon

1. Extract folder `sipinjam`.
2. Pastikan PHP Laragon menggunakan PHP 8.3 atau lebih baru.
3. Buat database MySQL bernama `db_sipinjam`.
4. Periksa `.env`:
   - `DB_DATABASE=db_sipinjam`
   - `DB_USERNAME=root`
   - `DB_PASSWORD=` jika MySQL Laragon tidak memakai password.
5. Dari folder project jalankan:

```bash
composer install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Atau buka project melalui Laragon.

## Akun Demo

Admin:
- Email: `admin@kampus.ac.id`
- Password: `password`

Mahasiswa:
- Email: `mahasiswa@kampus.ac.id`
- Password: `87654321`

## Alternatif database

File `database/sipinjam.sql` berisi struktur MySQL dan data demo. Gunakan jika ingin import database langsung melalui phpMyAdmin. Jika menggunakan SQL tersebut, tidak perlu menjalankan `migrate --seed`.

## Catatan

Folder `vendor` disertakan dalam paket ini. Jika dependency bermasalah, jalankan `composer install`.

Jika foto barang ingin ditampilkan dari `storage`, jalankan `php artisan storage:link`.
