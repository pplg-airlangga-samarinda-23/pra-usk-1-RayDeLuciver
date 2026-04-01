<?php
header('Content-Type: application/json');
session_start();

if (isset($_SESSION['user_id'])) {
    echo json_encode([
        'status' => 'success',
        'user' => [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'role' => $_SESSION['role'],
            'nama' => $_SESSION['nama']
        ]
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Tidak ada session'
    ]);
}
?>
