<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['uname'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

// Cek koneksi database
$statusOnline = $conn ? true : false;

// Ambil total barang
$data = $conn->query("SELECT * FROM Mst_Barang");
$totalBarang = $data ? $data->num_rows : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Cuysstore_Coffee | Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      font-family: 'Segoe UI', sans-serif;
      color: white;
    }
    .sidebar {
      min-height: 100vh;
      backdrop-filter: blur(14px);
      background: rgba(255, 255, 255, 0.05);
      border-right: 1px solid rgba(255, 255, 255, 0.1);
      padding: 2rem 1rem;
    }
    .sidebar a {
      color: #fff;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      text-decoration: none;
      padding: 0.75rem 1rem;
      border-radius: 12px;
      transition: background 0.3s;
    }
    .sidebar a:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }
    .profile {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 2rem;
      padding: 0 0.5rem;
    }
    .profile img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 50%;
      border: 2px solid #00f2fe;
      box-shadow: 0 0 10px rgba(0, 254, 178, 0.3);
    }
    .profile h6 {
      margin: 0;
      font-weight: 600;
      color: #00f2fe;
    }
    .main-content {
      padding: 2rem;
    }
    .card {
      background: rgba(255,255,255,0.05);
      backdrop-filter: blur(8px);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 20px;
      color: white;
    }
    .card-header {
      background: linear-gradient(90deg, #00c6ff, #0072ff);
      border-top-left-radius: 20px;
      border-top-right-radius: 20px;
      font-weight: bold;
    }
    .btn {
      transition: all 0.3s ease-in-out;
    }
    .btn:hover {
      transform: scale(1.05);
    }
    .btn-success {
      background-color: #28a745;
      border: none;
    }
    .btn-warning, .btn-danger {
      border: none;
    }
    .badge-warning {
      background-color: #ffc107;
      color: #000;
      font-size: 0.75rem;
      padding: 3px 7px;
      border-radius: 5px;
    }
    .table th {
      background-color: rgba(255, 255, 255, 0.1);
      color: #00f2fe;
    }
    .table-hover tbody tr:hover {
      background-color: rgba(255,255,255,0.05);
    }
    footer {
      text-align: center;
      margin-top: 4rem;
      color: #0dfb95;
    }
  </style>
</head>

<body>
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 sidebar">
      <div class="profile">
        <img src="user.png" alt="Foto Profil">
        <div>
          <h6><?= htmlspecialchars($_SESSION['uname']) ?></h6>
          <small class="<?= $statusOnline ? 'text-success' : 'text-danger' ?>">
            <?= $statusOnline ? '🟢 Online' : '🔴 Offline' ?>
          </small>
        </div>
      </div>
      <a href="#master-barang"><i class="bi bi-box"></i> Master Barang</a>
      <a href="laporan_barang.php"><i class="bi bi-bar-chart-fill"></i> Laporan Barang</a>
      <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 main-content">
      <h3>👋 Selamat Datang, <?= htmlspecialchars($_SESSION['uname']) ?></h3>

      <!-- Status Koneksi dan Total Barang -->
      <div class="row mt-4">
        <div class="col-md-6">
          <div class="card mb-3">
            <div class="card-header">Status Koneksi</div>
            <div class="card-body">
              <h5><?= $statusOnline ? '🟢 Terkoneksi dengan Database' : '🔴 Tidak Terkoneksi' ?></h5>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card mb-3">
            <div class="card-header">Total Barang</div>
            <div class="card-body">
              <h5><?= $totalBarang ?> barang terdata</h5>
            </div>
          </div>
        </div>
      </div>

      <!-- Master Barang Section -->
      <div class="card mt-4" id="master-barang">
        <div class="card-header text-white">
          <i class="bi bi-clipboard-data"></i> Master Barang
        </div>
        <div class="card-body">
          <a href="barang_tambah.php" class="btn btn-success mb-3">
            <i class="bi bi-plus-circle"></i> Tambah Barang
          </a>

          <div class="table-responsive">
            <table class="table table-hover table-borderless align-middle text-white">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Satuan</th>
                  <th>Harga Jual</th>
                  <th>Harga Beli</th>
                  <th>Qty</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($data && $data->num_rows > 0): ?>
                  <?php while ($row = $data->fetch_assoc()): ?>
                    <tr>
                      <td><?= htmlspecialchars($row['Kode_Barang']) ?></td>
                      <td><?= htmlspecialchars($row['Nama_barang']) ?></td>
                      <td><?= htmlspecialchars($row['Satuan']) ?></td>
                      <td>Rp<?= number_format($row['Harga_jual'], 0, ',', '.') ?></td>
                      <td>Rp<?= number_format($row['Harga_beli'], 0, ',', '.') ?></td>
                      <td>
                        <?= $row['Qty'] ?>
                        <?php if ($row['Qty'] <= 5): ?>
                          <span class="badge badge-warning">Stok Tipis</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <a href="barang_edit.php?id=<?= urlencode($row['Kode_Barang']) ?>" class="btn btn-sm btn-warning">
                          <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <a href="barang_hapus.php?id=<?= urlencode($row['Kode_Barang']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">
                          <i class="bi bi-trash"></i> Hapus
                        </a>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="7" class="text-center text-muted">Tidak ada data barang</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <footer class="mt-5">
        <small>© <?= date('Y') ?> <span style="color:#0dfb95;">Retail App by M. Sholeh</span></small>
      </footer>
    </div>
  </div>
</div>
</body>
</html>
