# Laporan Desain Sistem Laravel - SiPinjam

## Ringkasan
Implementasi desain sistem untuk UKK telah dibuat pada proyek Laravel dengan fokus pada:
1. Arsitektur MVC (Model, View, Controller)
2. Fitur utama: Auth, CRUD Alat, CRUD Peminjaman
3. Struktur database: `users`, `alat`, `peminjaman`
4. Relasi Eloquent ORM
5. Routing `web.php` dan `api.php`
6. Flow sistem login, pinjam alat, pengembalian

## Command Artisan (termasuk make:migration)
```bash
php artisan make:model Alat
php artisan make:model Peminjaman
php artisan make:controller AlatController --resource
php artisan make:controller PeminjamanController --resource
php artisan make:migration add_role_to_users_table --table=users
php artisan make:migration create_alat_table --create=alat
php artisan make:migration create_peminjaman_table --create=peminjaman
php artisan migrate
```

## Perubahan Utama
- Menambahkan kolom `role` pada tabel `users`.
- Menambahkan tabel `alat`.
- Menambahkan tabel `peminjaman` dengan foreign key ke `users` dan `alat`.
- Menambahkan relasi Eloquent di model:
  - `User hasMany Peminjaman`
  - `Alat hasMany Peminjaman`
  - `Peminjaman belongsTo User`
  - `Peminjaman belongsTo Alat`
- Menambahkan controller CRUD untuk Alat dan Peminjaman.
- Menambahkan flow aksi bisnis:
  - approve peminjaman
  - reject peminjaman
  - kembalikan alat + update stok
- Menambahkan route web dan api untuk modul Alat/Peminjaman.
- Menambahkan Blade view minimal untuk modul Alat/Peminjaman agar fitur bisa langsung diuji.

## Hasil Verifikasi
- Migrasi database berhasil dijalankan.
- Route Alat/Peminjaman terdaftar di route list.
- Test suite Laravel: PASS (25 passed, 0 failed).

## Catatan
- Middleware role belum dipisah menjadi file middleware khusus; saat ini kontrol akses role diterapkan di controller (`isAdminOrPetugas`).
- Struktur ini sudah siap dilanjutkan ke tahap desain detail UI dan implementasi modul lanjutan (kategori, laporan, log aktivitas, denda).
