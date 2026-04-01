<?php
header('Content-Type: application/json');
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    $nama = $conn->real_escape_string($data['nama']);
    $username = $conn->real_escape_string($data['username']);
    $password = password_hash($data['password'], PASSWORD_BCRYPT);
    
    // Cek username sudah ada
    $check = $conn->query("SELECT * FROM pengguna WHERE username = '$username'");
    
    if ($check->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Username sudah terdaftar'
        ]);
    } else {
        $sql = "INSERT INTO pengguna (NamaPengguna, Username, Password, Role) 
                VALUES ('$nama', '$username', '$password', 'petugas')";
        
        if ($conn->query($sql)) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Registrasi berhasil'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $conn->error
            ]);
        }
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Metode request tidak valid'
    ]);
}
?>
