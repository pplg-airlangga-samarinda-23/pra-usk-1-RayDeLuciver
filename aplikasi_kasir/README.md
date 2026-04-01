# Aplikasi Kasir POS - Panduan Instalasi

Aplikasi Kasir berbasis web dengan PHP dan MySQL untuk manajemen penjualan barang.

## 📋 Fitur Utama

- ✅ **Login & Registrasi** - Sistem autentikasi pengguna
- ✅ **Dua Role** - Administrator dan Petugas
- ✅ **Manajemen Produk** - Tambah, edit, hapus produk (Admin only)
- ✅ **Penjualan/POS** - Sistem poin penjualan real-time
- ✅ **Laporan Penjualan** - Lihat history transaksi
- ✅ **Database MySQL** - Penyimpanan data terstruktur

## 🛠 Persyaratan Sistem

- **XAMPP** (Apache + MySQL + PHP)
- **Browser Modern** (Chrome, Firefox, Edge)
- **PHP 7.0+**
- **MySQL 5.7+**

## 📦 Instalasi

### 1. Setup Database

1. Buka **phpMyAdmin**: http://localhost/phpmyadmin
2. Buat database baru bernama `aplikasi_kasir`
3. Pilih database `aplikasi_kasir`
4. Buka tab **"Import"**
5. Pilih file `database.sql` dari folder aplikasi
6. Klik **"Go"** untuk mengimport

**ATAU** jalankan query SQL secara manual:
```sql
CREATE DATABASE IF NOT EXISTS aplikasi_kasir;
USE aplikasi_kasir;

-- Buat tabel pengguna, produk, penjualan, dll
-- (Lihat file database.sql)
```

### 2. Copy Folder Aplikasi

1. Copy folder `aplikasi_kasir` ke: `C:\xampp\htdocs\`
2. Pastikan folder structure:
   ```
   C:\xampp\htdocs\aplikasi_kasir\
   ├── index.php
   ├── dashboard.php
   ├── kasir.php
   ├── produk.php
   ├── laporan.php
   ├── config.php
   ├── database.sql
   ├── api/
   │   ├── login.php
   │   ├── registrasi.php
   │   ├── produk.php
   │   ├── penjualan.php
   │   ├── logout.php
   │   └── check_session.php
   ├── css/
   │   └── style.css
   └── js/
       └── script.js
   ```

### 3. Update Config Database (Jika diperlukan)

Edit file `config.php`:
```php
define('DB_HOST', 'localhost');    // Sesuaikan dengan host Anda
define('DB_USER', 'root');         // Username MySQL
define('DB_PASS', '');             // Password MySQL (kosong jika default)
define('DB_NAME', 'aplikasi_kasir');
```

### 4. Jalankan Aplikasi

1. Pastikan XAMPP sudah running (Apache & MySQL)
2. Buka browser: **http://localhost/aplikasi_kasir/**
3. Login dengan akun demo:
   - **Username**: admin / **Password**: admin123 (Administrator)
   - **Username**: petugas / **Password**: petugas123 (Petugas)

## 👥 Akun Demo

### Administrator
- Username: `admin`
- Password: `admin123`
- Akses: Login, Logout, Registrasi, Pendataan Barang, Pembelian, Stok Barang

### Petugas
- Username: `petugas`
- Password: `petugas123`
- Akses: Login, Logout, Pendataan Barang, Pembelian, Stok Barang

## 🎯 Cara Menggunakan

### Halaman Kasir (POS)
1. Klik menu "Kasir" di dashboard
2. Pilih produk dengan klik tombol "+ Tambah"
3. Atur jumlah barang di keranjang
4. Klik "Bayar Sekarang" untuk menyelesaikan transaksi

### Manajemen Produk (Admin Only)
1. Klik menu "Manajemen Produk"
2. Klik "+ Tambah Produk" untuk menambah produk baru
3. Isi form: Nama, Harga, Stok
4. Edit atau hapus produk sesuai kebutuhan

### Laporan Penjualan
1. Klik menu "Laporan Penjualan"
2. Lihat daftar semua transaksi
3. Klik "Cetak" untuk print laporan

## 📊 Struktur Database

### Tabel Pengguna
- PenggunaID (Primary Key)
- NamaPengguna
- Username (Unique)
- Password (Hash)
- Role (administrator/petugas)

### Tabel Produk
- ProdukID (Primary Key)
- NamaProduk
- Harga
- Stok

### Tabel Penjualan
- PenjualanID (Primary Key)
- PenggunaID (Foreign Key)
- TanggalPenjualan
- TotalHarga

### Tabel DetailPenjualan
- DetailID (Primary Key)
- PenjualanID (Foreign Key)
- ProdukID (Foreign Key)
- JumlahProduk
- Subtotal

## 🔒 Keamanan

- Password menggunakan enkripsi BCrypt
- Session management untuk autentikasi
- Input validation dan SQL escape
- Role-based access control

## 🐛 Troubleshooting

### Koneksi Database Gagal
- Pastikan MySQL running
- Cek username & password di `config.php`
- Pastikan database `aplikasi_kasir` sudah ada

### Session tidak bekerja
- Pastikan session sudah diaktifkan di PHP
- Clear browser cookies & cache
- Reload halaman

### CSS/JS tidak loading
- Pastikan file ada di folder `css/` dan `js/`
- Clear browser cache (Ctrl+Shift+Delete)

## 📝 Catatan

- Aplikasi ini sederhana dan cocok untuk pembelajaran
- Untuk production, gunakan framework seperti Laravel
- Tambahkan validation & error handling lebih baik
- Implementasikan backup database rutin

## 📄 Lisensi

Aplikasi ini dibuat untuk tujuan pendidikan.

---

**Dibuat untuk:** Uji Kompetensi Kejuruan - Rekayasa Perangkat Lunak
**Tahun:** 2023/2024

Semoga bermanfaat! 🎉
