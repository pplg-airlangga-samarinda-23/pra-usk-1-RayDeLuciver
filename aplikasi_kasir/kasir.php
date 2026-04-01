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
    <title>Kasir - Aplikasi Kasir</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <h1>Aplikasi Kasir - POS</h1>
        <div class="user-info">
            <button class="btn" onclick="window.location.href='dashboard.php'" style="background-color: #34495e;">← Kembali</button>
            <button class="btn-logout" onclick="logout()">Logout</button>
        </div>
    </nav>

    <div class="container">
        <div class="card" style="margin-bottom: 0;">
            <div class="kasir-container">
                <!-- DAFTAR PRODUK -->
                <div>
                    <h3>Daftar Produk</h3>
                    <div class="produk-list" id="produk-container">
                        <!-- Produk akan dimuat di sini -->
                    </div>
                </div>

                <!-- KERANJANG -->
                <div class="cart-section">
                    <h3>🛒 Keranjang Belanja</h3>
                    <div id="cart-items">
                        <p style="text-align: center; color: #999;">Keranjang kosong</p>
                    </div>
                    <div class="cart-summary">
                        <div class="summary-row">
                            <span>Total:</span>
                            <span id="cart-total">Rp 0</span>
                        </div>
                        <input type="hidden" id="cart-total-value" value="0">
                    </div>
                    <button class="btn btn-checkout" onclick="checkout()">✓ Bayar Sekarang</button>
                    <button class="btn btn-clear" onclick="clearCart()">🔄 Bersihkan Keranjang</button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
    <script>
        // Load produk saat halaman dibuka
        loadProduk();
    </script>
</body>
</html>
