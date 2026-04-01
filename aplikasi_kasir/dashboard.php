<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$role = $_SESSION['role'];
$nama = $_SESSION['nama'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Aplikasi Kasir</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <h1>Aplikasi Kasir</h1>
        <div class="user-info">
            <div>
                <strong><?php echo $nama; ?></strong><br>
                <small><?php echo ucfirst($role); ?></small>
            </div>
            <button class="btn-logout" onclick="logout()">Logout</button>
        </div>
    </nav>

    <div class="container">
        <div class="dashboard-content">
            <h2>Selamat datang, <?php echo $nama; ?>!</h2>
            <p>Pilih menu di bawah untuk memulai</p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 30px;">
                <div class="card" style="cursor: pointer;" onclick="window.location.href='kasir.php'">
                    <h3>🛒 Kasir</h3>
                    <p>Lakukan penjualan produk</p>
                </div>

                <?php if ($role === 'administrator'): ?>
                <div class="card" style="cursor: pointer;" onclick="window.location.href='produk.php'">
                    <h3>📦 Manajemen Produk</h3>
                    <p>Kelola data produk</p>
                </div>
                <?php endif; ?>

                <div class="card" style="cursor: pointer;" onclick="window.location.href='laporan.php'">
                    <h3>📊 Laporan Penjualan</h3>
                    <p>Lihat data penjualan</p>
                </div>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
