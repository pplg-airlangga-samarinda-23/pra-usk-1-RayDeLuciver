<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Aplikasi Kasir</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <h1>Laporan Penjualan</h1>
        <div class="user-info">
            <button class="btn" onclick="window.location.href='dashboard.php'" style="background-color: #34495e;">← Kembali</button>
            <button class="btn-logout" onclick="logout()">Logout</button>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <div class="laporan-header">
                <h2>Data Penjualan</h2>
                <button class="btn" onclick="window.print()" style="background-color: #3498db;">🖨 Cetak</button>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID Penjualan</th>
                        <th>Nama Petugas</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="laporan-table-body">
                    <tr>
                        <td colspan="5" style="text-align: center;">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="js/script.js"></script>
    <script>
        loadLaporan();
        // Refresh data setiap 30 detik
        setInterval(loadLaporan, 30000);
    </script>
</body>
</html>
