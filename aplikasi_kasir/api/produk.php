<?php
header('Content-Type: application/json');
session_start();
require_once '../config.php';

// Cek session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Tidak terautentikasi']);
    exit();
}

// GET - Ambil semua produk atau produk tertentu
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM produk";
    $result = $conn->query($sql);
    
    $produk = [];
    while ($row = $result->fetch_assoc()) {
        $produk[] = $row;
    }
    
    echo json_encode([
        'status' => 'success',
        'data' => $produk
    ]);
}

// POST - Tambah produk (hanya admin)
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SESSION['role'] !== 'administrator') {
        echo json_encode(['status' => 'error', 'message' => 'Anda tidak memiliki akses']);
        exit();
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    $nama = $conn->real_escape_string($data['nama_produk']);
    $harga = floatval($data['harga']);
    $stok = intval($data['stok']);
    
    $sql = "INSERT INTO produk (NamaProduk, Harga, Stok) VALUES ('$nama', $harga, $stok)";
    
    if ($conn->query($sql)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Produk berhasil ditambahkan',
            'id' => $conn->insert_id
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal menambahkan produk'
        ]);
    }
}

// PUT - Update produk
elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    if ($_SESSION['role'] !== 'administrator') {
        echo json_encode(['status' => 'error', 'message' => 'Anda tidak memiliki akses']);
        exit();
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    $id = intval($data['id']);
    $nama = $conn->real_escape_string($data['nama_produk']);
    $harga = floatval($data['harga']);
    $stok = intval($data['stok']);
    
    $sql = "UPDATE produk SET NamaProduk='$nama', Harga=$harga, Stok=$stok WHERE ProdukID=$id";
    
    if ($conn->query($sql)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Produk berhasil diupdate'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal mengupdate produk'
        ]);
    }
}

// DELETE - Hapus produk
elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if ($_SESSION['role'] !== 'administrator') {
        echo json_encode(['status' => 'error', 'message' => 'Anda tidak memiliki akses']);
        exit();
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    $id = intval($data['id']);
    
    $sql = "DELETE FROM produk WHERE ProdukID=$id";
    
    if ($conn->query($sql)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Produk berhasil dihapus'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal menghapus produk'
        ]);
    }
}
?>
