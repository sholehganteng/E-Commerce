<?php
session_start();
if (!isset($_SESSION['uname'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "retail");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$success = false;
$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode   = $conn->real_escape_string($_POST['kode']);
    $nama   = $conn->real_escape_string($_POST['nama']);
    $satuan = $conn->real_escape_string($_POST['satuan']);
    $jual   = (int) $_POST['jual'];
    $beli   = (int) $_POST['beli'];
    $qty    = (int) $_POST['qty'];

    $query = $conn->query("INSERT INTO Mst_barang VALUES ('$kode','$nama','$satuan','$jual','$beli','$qty')");
    if ($query) {
        $success = true;
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah Barang</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      background: #f6f8fa;
    }
    .card {
      border-radius: 1rem;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
  <div class="container">
    <a class="navbar-brand" href="#">📦 Cuysstore_Coffee
      
    </a>
    <a href="dashboard.php" class="btn btn-light btn-sm">Kembali</a>
  </div>
</nav>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-8">

      <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Sukses!</strong> Data barang berhasil ditambahkan.
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php elseif ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Error!</strong> Gagal menambahkan barang.
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <div class="card">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Barang Baru</h5>
        </div>
        <div class="card-body">
          <form method="POST" autocomplete="off">
            <div class="mb-3">
              <label class="form-label">Kode Barang</label>
              <input type="text" name="kode" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Nama Barang</label>
              <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Satuan</label>
              <input type="text" name="satuan" class="form-control" required>
            </div>
            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label">Harga Jual</label>
                <input type="number" name="jual" class="form-control" required min="0">
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Harga Beli</label>
                <input type="number" name="beli" class="form-control" required min="0">
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Qty</label>
                <input type="number" name="qty" class="form-control" required min="0">
              </div>
            </div>
            <div class="d-grid">
              <button class="btn btn-success" type="submit"><i class="bi bi-save"></i> Simpan Barang</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
