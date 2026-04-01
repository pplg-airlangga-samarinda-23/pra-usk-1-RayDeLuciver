<?php
header('Content-Type: application/json');
session_start();
require_once '../config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Tidak terautentikasi']);
    exit();
}

// GET - Ambil data penjualan
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT p.*, u.NamaPengguna FROM penjualan p 
            JOIN pengguna u ON p.PenggunaID = u.PenggunaID 
            ORDER BY p.TanggalDibuat DESC LIMIT 100";
    $result = $conn->query($sql);
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    echo json_encode([
        'status' => 'success',
        'data' => $data
    ]);
}

// POST - Buat penjualan baru
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    $user_id = $_SESSION['user_id'];
    $items = $data['items'];
    $total = floatval($data['total']);
    $tanggal = date('Y-m-d');
    
    // Mulai transaksi
    $conn->begin_transaction();
    
    try {
        // Insert penjualan
        $sql = "INSERT INTO penjualan (PenggunaID, TanggalPenjualan, TotalHarga) 
                VALUES ('$user_id', '$tanggal', $total)";
        $conn->query($sql);
        $penjualan_id = $conn->insert_id;
        
        // Insert detail penjualan dan update stok
        foreach ($items as $item) {
            $produk_id = intval($item['produk_id']);
            $jumlah = intval($item['jumlah']);
            $subtotal = floatval($item['subtotal']);
            
            // Insert detail
            $sql = "INSERT INTO detailpenjualan (PenjualanID, ProdukID, JumlahProduk, Subtotal) 
                    VALUES ($penjualan_id, $produk_id, $jumlah, $subtotal)";
            $conn->query($sql);
            
            // Update stok produk
            $sql = "UPDATE produk SET Stok = Stok - $jumlah WHERE ProdukID = $produk_id";
            $conn->query($sql);
        }
        
        $conn->commit();
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Penjualan berhasil disimpan',
            'penjualan_id' => $penjualan_id
        ]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal membuat penjualan: ' . $e->getMessage()
        ]);
    }
}

// DELETE - Hapus penjualan dan restore stok (hanya admin)
elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    $penjualan_id = isset($data['penjualan_id']) ? intval($data['penjualan_id']) : 0;

    if ($penjualan_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'ID penjualan tidak valid']);
        exit();
    }

    // Pastikan penjualan ada
    $check = $conn->query("SELECT * FROM penjualan WHERE PenjualanID = $penjualan_id");
    if ($check->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Data penjualan tidak ditemukan']);
        exit();
    }

    $conn->begin_transaction();
    try {
        $sql = "SELECT ProdukID, JumlahProduk FROM detailpenjualan WHERE PenjualanID = $penjualan_id";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $produk_id = intval($row['ProdukID']);
            $jumlah = intval($row['JumlahProduk']);
            $sqlUpdate = "UPDATE produk SET Stok = Stok + $jumlah WHERE ProdukID = $produk_id";
            $conn->query($sqlUpdate);
        }

        $conn->query("DELETE FROM detailpenjualan WHERE PenjualanID = $penjualan_id");
        $deleted = $conn->query("DELETE FROM penjualan WHERE PenjualanID = $penjualan_id");

        if ($conn->affected_rows === 0) {
            $conn->rollback();
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus: data tidak ditemukan']);
            exit();
        }

        $conn->commit();
        echo json_encode(['status' => 'success', 'message' => 'Penjualan berhasil dihapus']);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => 'Gagal hapus penjualan: ' . $e->getMessage()]);
    }
}
?>
