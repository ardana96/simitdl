<?php

// Sertakan file konfigurasi database
include('../config.php'); // Pastikan koneksi MySQL diambil dari config.php

// Pastikan koneksi tersedia
if (!$koneksi) {
    die(json_encode(array("error" => "Koneksi database tidak valid.")));
}

// Mendapatkan data dari request JSON
$data = json_decode(file_get_contents('php://input'), true);

// Debugging: Cek apakah request JSON diterima dengan benar
error_log("Request JSON: " . json_encode($data));

// Inisialisasi query dasar
$query = "SELECT nomor, id_perangkat, perangkat, tipe, user, divisi, bulan, tgl_perawatan FROM peripheral WHERE 1=1";

// Tambahkan filter berdasarkan input
if (!empty($data['perangkat'])) {
    $query .= " AND perangkat = '" . mysql_real_escape_string($data['perangkat']) . "'";
}
if (!empty($data['tipe'])) {
    $query .= " AND tipe = '" . mysql_real_escape_string($data['tipe']) . "'";
}
if (!empty($data['user'])) {
    $query .= " AND user = '" . mysql_real_escape_string($data['user']) . "'";
}
if (!empty($data['bulan']) ) { // "00" untuk menampilkan semua bulan
    $query .= " AND bulan = '" . mysql_real_escape_string($data['bulan']) . "'";
}
if (!empty($data['divisi'])) {
    $query .= " AND divisi = '" . mysql_real_escape_string($data['divisi']) . "'";
}

// Jalankan query
$result = mysql_query($query);

// Periksa apakah query berhasil
if (!$result) {
    die(json_encode(array("error" => "Query gagal: " . mysql_error())));
}

// Simpan hasil query ke dalam array
$output = array();
while ($row = mysql_fetch_assoc($result)) {
    $output[] = $row;
}

// Jika tombol Reset (Clear) diklik, tampilkan semua data tanpa filter
if (!empty($data['clear'])) {
    $query = "SELECT nomor, id_perangkat, perangkat, tipe, user, divisi, bulan, tgl_perawatan FROM peripheral ORDER BY tipe ASC";
    $result = mysql_query($query);

    // Periksa apakah query berhasil
    if (!$result) {
        die(json_encode(array("error" => "Query gagal: " . mysql_error())));
    }

    // Simpan hasil query ke dalam array
    $output = array();
    while ($row = mysql_fetch_assoc($result)) {
        $output[] = $row;
    }
}

// Kirim hasil dalam format JSON
header('Content-Type: application/json');
echo json_encode($output);

// Tutup koneksi
mysql_close($koneksi);

?>
