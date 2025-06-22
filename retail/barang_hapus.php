<?php
session_start();
if (!isset($_SESSION['uname'])) {
    header("Location: login.php");
    exit;
}

// Koneksi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "retail";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$kode = $_GET['id'] ?? '';

if ($kode !== '') {
    $hapus = $conn->query("DELETE FROM Mst_barang WHERE Kode_Barang = '$kode'");
    if ($hapus) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.location='dashboard.php';</script>";
    }
} else {
    header("Location: dashboard.php");
    exit;
}
?>
