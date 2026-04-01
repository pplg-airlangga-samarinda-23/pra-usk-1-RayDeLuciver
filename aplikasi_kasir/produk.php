<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SESSION['role'] !== 'administrator') {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - Aplikasi Kasir</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <h1>Manajemen Produk</h1>
        <div class="user-info">
            <button class="btn" onclick="window.location.href='dashboard.php'" style="background-color: #34495e;">← Kembali</button>
            <button class="btn-logout" onclick="logout()">Logout</button>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2>Daftar Produk</h2>
                <button class="btn btn-add" onclick="openAddProdukModal()">+ Tambah Produk</button>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="produk-table-body">
                    <tr>
                        <td colspan="5" style="text-align: center;">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL TAMBAH/EDIT PRODUK -->
    <div id="produk-modal" class="modal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal('produk-modal')">×</button>
            <h2 id="produk-modal-title">Tambah Produk</h2>
            <form id="form-produk" onsubmit="saveProduk(event)">
                <input type="hidden" id="produk-id">
                
                <div class="form-group">
                    <label for="produk-nama">Nama Produk</label>
                    <input type="text" id="produk-nama" required>
                </div>
                
                <div class="form-group">
                    <label for="produk-harga">Harga</label>
                    <input type="number" id="produk-harga" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="produk-stok">Stok</label>
                    <input type="number" id="produk-stok" required>
                </div>
                
                <button type="submit" class="btn">Simpan</button>
            </form>
        </div>
    </div>

    <script src="js/script.js"></script>
    <script>
        loadProdukAdmin();
    </script>
</body>
</html>
