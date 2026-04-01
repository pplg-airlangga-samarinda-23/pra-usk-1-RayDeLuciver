-- Buat Database
CREATE DATABASE IF NOT EXISTS aplikasi_kasir;
USE aplikasi_kasir;

-- Tabel Pengguna
CREATE TABLE IF NOT EXISTS pengguna (
    PenggunaID INT(11) AUTO_INCREMENT PRIMARY KEY,
    NamaPengguna VARCHAR(255) NOT NULL,
    Alamat TEXT,
    NomorTelepon VARCHAR(15),
    Username VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Role ENUM('administrator', 'petugas') DEFAULT 'petugas',
    TanggalDibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Produk
CREATE TABLE IF NOT EXISTS produk (
    ProdukID INT(11) AUTO_INCREMENT PRIMARY KEY,
    NamaProduk VARCHAR(255) NOT NULL,
    Harga DECIMAL(10, 2) NOT NULL,
    Stok INT(11) NOT NULL DEFAULT 0,
    TanggalDibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Penjualan
CREATE TABLE IF NOT EXISTS penjualan (
    PenjualanID INT(11) AUTO_INCREMENT PRIMARY KEY,
    PenggunaID INT(11) NOT NULL,
    TanggalPenjualan DATE NOT NULL,
    TotalHarga DECIMAL(10, 2) NOT NULL,
    TanggalDibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (PenggunaID) REFERENCES pengguna(PenggunaID)
);

-- Tabel Detail Penjualan
CREATE TABLE IF NOT EXISTS detailpenjualan (
    DetailID INT(11) AUTO_INCREMENT PRIMARY KEY,
    PenjualanID INT(11) NOT NULL,
    ProdukID INT(11) NOT NULL,
    JumlahProduk INT(11) NOT NULL,
    Subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (PenjualanID) REFERENCES penjualan(PenjualanID),
    FOREIGN KEY (ProdukID) REFERENCES produk(ProdukID)
);

-- Insert Data Pengguna Demo (Password: admin123 dan petugas123)
INSERT INTO pengguna (NamaPengguna, Alamat, NomorTelepon, Username, Password, Role) VALUES
('Admin', 'Jl. Merdeka No. 1', '081234567890', 'admin', '$2y$10$yQvjYLMy1zV0l3Q1b5QFe.kqM.mK5hZ8P1L7X9.1W7A9Q5B0K', 'administrator'),
('Petugas', 'Jl. Sudirman No. 5', '081234567891', 'petugas', '$2y$10$v5l8k3Q2z1X9b7M4p9Y5d.kqM.mK5hZ8P1L7X9.1W7A9Q5B0K', 'petugas');

-- Insert Data Produk Demo
INSERT INTO produk (NamaProduk, Harga, Stok) VALUES
('Mie Instan', 2500.00, 50),
('Air Mineral 600ml', 3000.00, 100),
('Rokok Marlboro', 45000.00, 20),
('Teh Botol', 5000.00, 80),
('Kopi Instan', 8000.00, 30),
('Biscuit', 10000.00, 60);
