<?php
require_once __DIR__ . '/vendor/autoload.php';
include 'koneksi.php';

$mpdf = new \Mpdf\Mpdf();

$html = '
<h2 style="text-align:center;">Laporan Data Barang</h2>
<table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse;">
<tr style="background-color: #f0f0f0;">
  <th>Kode</th>
  <th>Nama</th>
  <th>Satuan</th>
  <th>Harga Jual</th>
  <th>Harga Beli</th>
  <th>Qty</th>
</tr>';

$data = $conn->query("SELECT * FROM Mst_barang");
while ($row = $data->fetch_assoc()) {
    $html .= "<tr>
      <td>{$row['Kode_Barang']}</td>
      <td>{$row['Nama_barang']}</td>
      <td>{$row['Satuan']}</td>
      <td>Rp" . number_format($row['Harga_jual'], 0, ',', '.') . "</td>
      <td>Rp" . number_format($row['Harga_beli'], 0, ',', '.') . "</td>
      <td>{$row['Qty']}</td>
    </tr>";
}

$html .= '</table>';

$mpdf->WriteHTML($html);
$mpdf->Output('laporan_barang.pdf', \Mpdf\Output\Destination::DOWNLOAD);
exit;
