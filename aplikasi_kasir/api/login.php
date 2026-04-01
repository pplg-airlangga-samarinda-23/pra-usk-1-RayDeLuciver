<?php
header('Content-Type: application/json');
session_start();
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    $username = $conn->real_escape_string($data['username']);
    $password = $data['password'];
    
    $sql = "SELECT * FROM pengguna WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['PenggunaID'];
            $_SESSION['username'] = $user['Username'];
            $_SESSION['role'] = $user['Role'];
            $_SESSION['nama'] = $user['NamaPengguna'];
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Login berhasil',
                'user' => [
                    'id' => $user['PenggunaID'],
                    'nama' => $user['NamaPengguna'],
                    'role' => $user['Role'],
                    'username' => $user['Username']
                ]
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Password salah'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Username tidak ditemukan'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Metode request tidak valid'
    ]);
}
?>
