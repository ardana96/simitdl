<?php
include("../config.php"); // Panggil koneksi database

// Jika tanpa filter, ambil semua data
if (isset($_POST['all_data']) && $_POST['all_data'] == "true") {
    $query = "SELECT nomor, id_perangkat, perangkat, tipe, user, divisi, bulan, tgl_perawatan 
              FROM peripheral 
              ORDER BY nomor ASC";
} else {
    // Ambil filter dari AJAX dan bersihkan spasi yang tidak perlu
    $filterPerangkat = isset($_POST['perangkat']) ? trim($_POST['perangkat']) : '';
    $filterTipe = isset($_POST['tipe']) ? trim($_POST['tipe']) : '';
    $filterUser = isset($_POST['user']) ? trim($_POST['user']) : '';
    $filterBulan = isset($_POST['bulan']) ? trim($_POST['bulan']) : '';
    $filterDivisi = isset($_POST['divisi']) ? trim($_POST['divisi']) : '';

    // Bangun query dengan filter
    $query = "SELECT nomor, id_perangkat, perangkat, tipe, user, divisi, bulan, tgl_perawatan 
              FROM peripheral WHERE 1=1";
    
    if (!empty($filterPerangkat)) {
        $query .= " AND perangkat = '$filterPerangkat'";
    }
    if (!empty($filterTipe)) {
        $query .= " AND tipe = '$filterTipe'";
    }
    if (!empty($filterUser)) {
        $query .= " AND user = '$filterUser'";
    }
    if (!empty($filterBulan)) { // "00" untuk semua bulan
        $query .= " AND bulan = '$filterBulan'";
    }
    if (!empty($filterDivisi)) {
        $query .= " AND divisi = '$filterDivisi'";
    }

    // Tambahkan ORDER BY di akhir query
    $query .= " ORDER BY nomor ASC";  
}

// Jalankan query
$result = mysql_query($query);

// Jika query gagal
if (!$result) {
    die(json_encode(array("error" => mysql_error())));
}

// Simpan hasil query ke dalam array
$data = array();
while ($row = mysql_fetch_assoc($result)) {
    $data[] = $row;
}

// Simpan hasil ke dalam file JSON sementara
$file = '../excel/export_data_peripheral.json';
file_put_contents($file, json_encode($data));

// Kirim nama file JSON ke AJAX
echo json_encode(array("file" => $file));
?>
