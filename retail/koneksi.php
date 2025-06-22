<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'retail';

try {
    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        throw new Exception("Gagal koneksi ke database: " . $conn->connect_error);
    }
} catch (Exception $e) {
    // Jika koneksi gagal, tampilkan pesan ramah dan set $conn ke null
    $conn = null;
    // Catatan: jangan echo error ini ke user di produksi
    // echo "Database tidak tersedia: " . $e->getMessage();
}
