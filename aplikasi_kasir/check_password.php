<?php
require_once 'config.php';

$users = ['admin' => 'admin123', 'petugas' => 'petugas123'];

foreach ($users as $username => $plain) {
    $stmt = $conn->prepare('SELECT Password FROM pengguna WHERE Username = ? LIMIT 1');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($hash);
    if ($stmt->fetch()) {
        $ok = password_verify($plain, $hash) ? 'OK' : 'FAIL';
        echo "[{$username}] db-hash={$hash} <br> password_verify({$plain}) => {$ok}<br><br>";
    } else {
        echo "[{$username}] tidak ditemukan di tabel pengguna.<br><br>";
    }
    $stmt->close();
}

$conn->close();
?>