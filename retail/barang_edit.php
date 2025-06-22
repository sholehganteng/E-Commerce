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
$data = $conn->query("SELECT * FROM Mst_barang WHERE Kode_Barang = '$kode'");
$row  = $data->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = $_POST['nama'];
    $satuan = $_POST['satuan'];
    $jual   = $_POST['jual'];
    $beli   = $_POST['beli'];
    $qty    = $_POST['qty'];

    $update = $conn->query("UPDATE Mst_barang SET 
      Nama_barang = '$nama',
      Satuan = '$satuan',
      Harga_jual = '$jual',
      Harga_beli = '$beli',
      Qty = '$qty'
      WHERE Kode_Barang = '$kode'
    ");

    if ($update) {
        echo "<script>alert('Data berhasil diubah!'); window.location='dashboard.php';</script>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>Gagal mengubah data!</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Barang</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
  <h4>Edit Barang</h4>
  <form method="POST">
    <div class="mb-3">
      <label>Kode Barang</label>
      <input type="text" class="form-control" value="<?= $row['Kode_Barang'] ?>" disabled>
    </div>
    <div class="mb-3">
      <label>Nama Barang</label>
      <input type="text" name="nama" value="<?= $row['Nama_barang'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Satuan</label>
      <input type="text" name="satuan" value="<?= $row['Satuan'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Harga Jual</label>
      <input type="number" name="jual" value="<?= $row['Harga_jual'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Harga Beli</label>
      <input type="number" name="beli" value="<?= $row['Harga_beli'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Qty</label>
      <input type="number" name="qty" value="<?= $row['Qty'] ?>" class="form-control" required>
    </div>
    <button class="btn btn-primary">Simpan Perubahan</button>
    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>
</body>
</html>
