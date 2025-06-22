<?php
session_start();
if (!isset($_SESSION['uname'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';
$data = $conn->query("SELECT * FROM Mst_barang");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Barang Futuristik</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      color: white;
      font-family: 'Segoe UI', sans-serif;
      min-height: 100vh;
    }
    .glass-card {
      backdrop-filter: blur(12px);
      background: rgba(255, 255, 255, 0.1);
      border-radius: 20px;
      box-shadow: 0 8px 32px rgba(0,0,0,0.2);
      border: 1px solid rgba(255,255,255,0.1);
    }
    .title-icon {
      font-size: 2rem;
      color: #00f2fe;
    }
    h2 {
      font-weight: 700;
      color: #00f2fe;
    }
    .btn-glow {
      border: none;
      padding: 10px 20px;
      font-weight: 600;
      border-radius: 30px;
      transition: all 0.3s ease-in-out;
    }
    .btn-glow:hover {
      transform: scale(1.05);
      box-shadow: 0 0 15px rgba(255,255,255,0.3);
    }
    .btn-danger { background: #ff416c; color: white; }
    .btn-success { background: #28a745; color: white; }
    .btn-info { background: #00c6ff; color: white; }
    .btn-secondary { background: #6c757d; color: white; }

    .table thead {
      background-color: rgba(255, 255, 255, 0.1);
      color: #00f2fe;
    }
    .table td, .table th {
      vertical-align: middle;
      border: none;
    }
    .table-hover tbody tr:hover {
      background-color: rgba(0, 242, 254, 0.05);
      transition: background 0.3s;
    }
    .rounded-top-custom {
      border-top-left-radius: 20px;
      border-top-right-radius: 20px;
    }
  </style>
</head>
<body>

<div class="container py-5">
  <div class="glass-card p-4">
    <h2 class="text-center mb-4"><i class="bi bi-box title-icon"></i> Laporan Data Barang</h2>

    <div class="d-flex justify-content-center flex-wrap gap-2 mb-4">
      <a href="laporan_pdf.php" class="btn btn-danger btn-glow"><i class="bi bi-file-earmark-pdf-fill"></i> PDF</a>
      <a href="laporan_excel.php" class="btn btn-success btn-glow"><i class="bi bi-file-earmark-excel-fill"></i> Excel</a>
      <a href="laporan_csv.php" class="btn btn-info btn-glow"><i class="bi bi-folder-symlink"></i> CSV</a>
      <a href="/retail/dashboard.php" class="btn btn-secondary btn-glow"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    <div class="table-responsive">
      <table class="table table-hover text-white">
        <thead class="rounded-top-custom">
          <tr class="text-center">
            <th>Kode</th>
            <th>Nama</th>
            <th>Satuan</th>
            <th>Harga Jual</th>
            <th>Harga Beli</th>
            <th>Qty</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $data->fetch_assoc()): ?>
          <tr class="text-center">
            <td><?= $row['Kode_Barang'] ?></td>
            <td><?= $row['Nama_barang'] ?></td>
            <td><?= $row['Satuan'] ?></td>
            <td>Rp<?= number_format($row['Harga_jual'], 0, ',', '.') ?></td>
            <td>Rp<?= number_format($row['Harga_beli'], 0, ',', '.') ?></td>
            <td><?= $row['Qty'] ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
