<?php
include("../config.php"); // Panggil koneksi database

// Jika tanpa filter, ambil semua data
if (isset($_POST['all_data']) && $_POST['all_data'] == "true") {
    $query = "SELECT nomor, ippc, idpc, user, namapc, bagian, subbagian, lokasi, 
                     prosesor, mobo, ram, harddisk, bulan, tgl_perawatan 
              FROM pcaktif 
              ORDER BY nomor ASC";
} else {
    // Ambil filter dari AJAX dan bersihkan spasi yang tidak perlu
    $filterDivisi = isset($_POST['divisi']) ? trim($_POST['divisi']) : '';
    $filterBagian = isset($_POST['bagian']) ? trim($_POST['bagian']) : '';
    $filterSubBagian = isset($_POST['subbagian']) ? trim($_POST['subbagian']) : '';
    $filterLokasi = isset($_POST['lokasi']) ? trim($_POST['lokasi']) : '';
    $filterBulan = isset($_POST['bulan']) ? trim($_POST['bulan']) : '';
    $filterModel = isset($_POST['model']) ? trim($_POST['model']) : '';

    // Bangun query dengan filter
    $query = "SELECT nomor, ippc, idpc, user, namapc, bagian, subbagian, lokasi, 
                     prosesor, mobo, ram, harddisk, bulan, tgl_perawatan 
              FROM pcaktif WHERE 1=1";
    
    if (!empty($filterDivisi)) {
        $query .= " AND divisi = '$filterDivisi'"; // Gunakan '=' untuk pencocokan ketat
    }
    if (!empty($filterBagian)) {
        $query .= " AND bagian = '$filterBagian'"; // Gunakan '=' agar tidak tertangkap bagian lain
    }
    if (!empty($filterSubBagian)) {
        $query .= " AND subbagian = '$filterSubBagian'"; // Sama untuk subbagian
    }
    if (!empty($filterLokasi)) {
        $query .= " AND lokasi = '$filterLokasi'";
    }
    if (!empty($filterBulan)) {
        $query .= " AND bulan = '$filterBulan'";
    }
    if (!empty($filterModel)) {
        $query .= " AND model = '$filterModel'";
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
$file = '../excel/export_data_rpemakaipc.json';
file_put_contents($file, json_encode($data));

// Kirim nama file JSON ke AJAX
echo json_encode(array("file" => $file));
?>
