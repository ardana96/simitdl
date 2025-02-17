<?php

// Bersihkan output buffer sebelum mengirim header
ob_end_clean();
ob_start();

// Set header agar file di-download sebagai Excel
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=export_peripheral.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Tambahkan BOM UTF-8 agar karakter terbaca dengan benar di Excel
echo "\xEF\xBB\xBF";

// Ambil data dari file JSON sementara
$jsonFile = '../excel/export_data_peripheral.json';

if (!file_exists($jsonFile)) {
    die("<h2 style='color:red; text-align:center;'>Data tidak ditemukan!</h2>");
}

$data = json_decode(file_get_contents($jsonFile), true);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        .header { background-color: #D3D3D3; font-weight: bold; text-align: center; }
    </style>
</head>
<body>
    <table border="1">
        <tr>
            <th colspan="8" style="text-align:center;"><h2>DAFTAR PERANGKAT PERIPHERAL</h2></th>
        </tr>
        <tr class="header">
            <th>Nomor</th>
            <th>ID Perangkat</th>
            <th>Nama Perangkat</th>
            <th>Tipe</th>
            <th>User</th>
            <th>Divisi</th>
            <th>Bulan</th>
            <th>Tanggal Perawatan</th>
        </tr>

        <?php 
        if (!empty($data)) {
            foreach ($data as $row) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nomor'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['id_perangkat'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['perangkat'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['tipe'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['user'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['divisi'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['bulan'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['tgl_perawatan'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php 
            } 
        } else { ?>
            <tr>
                <td colspan="8" style="text-align:center; font-weight:bold; color:red;">Tidak ada data yang tersedia!</td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
