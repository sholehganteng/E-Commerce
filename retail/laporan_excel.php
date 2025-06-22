<?php
include 'koneksi.php';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_barang.xls");

echo "<table border='1'>";
echo "<tr><th>Kode</th><th>Nama</th><th>Satuan</th><th>Harga Jual</th><th>Harga Beli</th><th>Qty</th></tr>";

$data = $conn->query("SELECT * FROM Mst_barang");
while ($row = $data->fetch_assoc()) {
    echo "<tr>
            <td>{$row['Kode_Barang']}</td>
            <td>{$row['Nama_barang']}</td>
            <td>{$row['Satuan']}</td>
            <td>{$row['Harga_jual']}</td>
            <td>{$row['Harga_beli']}</td>
            <td>{$row['Qty']}</td>
          </tr>";
}
echo "</table>";
