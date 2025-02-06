<?php

// Bersihkan output buffer sebelum mengirim header
ob_end_clean();
ob_start();

// Set header agar file di-download sebagai Excel
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=peripheral_export.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Tambahkan BOM UTF-8 agar karakter terbaca dengan benar di Excel
echo "\xEF\xBB\xBF";

// Cek apakah data dikirim dari frontend
$rawData = isset($_POST["tableData"]) ? $_POST["tableData"] : "";

// Debugging - Simpan data mentah ke file untuk pengecekan
file_put_contents("debug_raw_post.txt", print_r($rawData, true));

$tableData = array();

// Decode JSON dengan aman
if (!empty($rawData)) {
    $decodedData = json_decode(stripslashes($rawData), true);
    
    // Pastikan hasil decoding adalah array
    if (is_array($decodedData)) {
        $tableData = $decodedData;
    }
}

// Debugging - Simpan hasil parsing ke file
// file_put_contents("debug_decoded_array.txt", print_r($tableData, true));

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
            <th colspan="6" style="text-align:center;"><h2>DATA MASTER BARANG PERIPHERAL</h2></th>
        </tr>
        <tr class="header">
            <th>No</th>
            <th>ID Perangkat</th>
            <th>Nama Perangkat</th>
            <th>Tipe</th>
            <th>User</th>
            <th>Divisi</th>
        </tr>

        <?php 
        if (!empty($tableData)) {
            $no = 1;
            foreach ($tableData as $row) { ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo htmlspecialchars($row[1], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row[2], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row[3], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row[4], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($row[5], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php 
                $no++; 
            } 
        } else { ?>
            <tr>
                <td colspan="6" style="text-align:center; font-weight:bold; color:red;">Tidak ada data yang tersedia!</td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
