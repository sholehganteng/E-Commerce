<?php
include 'koneksi.php';
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="laporan_barang.csv"');

$output = fopen("php://output", "w");
fputcsv($output, ['Kode', 'Nama', 'Satuan', 'Harga Jual', 'Harga Beli', 'Qty']);

$data = $conn->query("SELECT * FROM Mst_barang");
while ($row = $data->fetch_assoc()) {
    fputcsv($output, $row);
}
fclose($output);
exit;
