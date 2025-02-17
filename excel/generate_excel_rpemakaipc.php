<?php

// Bersihkan output buffer sebelum mengirim header
ob_end_clean();
ob_start();

// Set header agar file di-download sebagai Excel
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=export_pemakaian_pc.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Tambahkan BOM UTF-8 agar karakter terbaca dengan benar di Excel
echo "\xEF\xBB\xBF";

// Ambil data dari file JSON sementara
$jsonFile = '../excel/export_data_rpemakaipc.json';

if (!file_exists($jsonFile)) {
    die("<h2 style='color:red; text-align:center;'>Data tidak ditemukan!</h2>");
}

$data = json_decode(file_get_contents($jsonFile), true);

// Debugging - Simpan hasil parsing ke file
// file_put_contents("debug_decoded_array.txt", print_r($data, true));

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
            <th colspan="14" style="text-align:center;"><h2>DAFTAR PEMAKAI KOMPUTER</h2></th>
        </tr>
        <tr class="header">
            <th>Nomor</th>
            <th>IP PC</th>
            <th>ID PC</th>
            <th>User</th>
            <th>Nama PC</th>
            <th>Bagian</th>
            <th>Sub Bagian</th>
            <th>Lokasi</th>
            <th>Prosesor</th>
            <th>Motherboard</th>
            <th>Ram</th>
            <th>Harddisk</th>
            <th>Bulan</th>
            <th>Cek Perawatan</th>
        </tr>

        <?php 
        if (!empty($data)) {
            foreach ($data as $row) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nomor'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['ippc'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['idpc'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['user'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['namapc'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['bagian'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['subbagian'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['lokasi'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['prosesor'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['mobo'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['ram'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['harddisk'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['bulan'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row['tgl_perawatan'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php 
            } 
        } else { ?>
            <tr>
                <td colspan="14" style="text-align:center; font-weight:bold; color:red;">Tidak ada data yang tersedia!</td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
