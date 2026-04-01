<?php
// Hati-hati, gunakan hanya sementara untuk debugging/lokal.
require_once 'config.php';

$users = [
    'admin' => 'admin123',
    'petugas' => 'petugas123'
];

foreach ($users as $username => $plain) {
    $hash = password_hash($plain, PASSWORD_BCRYPT);
    $sql = "UPDATE pengguna SET Password = '$hash' WHERE Username = '$username'";
    if ($conn->query($sql) !== true) {
        echo "Gagal update $username: " . $conn->error . "<br>";
    } else {
        echo "Password $username diset ulang ke '$plain'<br>";
    }
}

echo "Selesai. Silakan hapus file ini setelah digunakan untuk keamanan.";
?>