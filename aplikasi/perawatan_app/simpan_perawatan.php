<?php
session_start();
// Koneksi ke database
$server = "localhost";
$username = "root";
$password = "dlris30g";
$database = "sitdl";

$conn = mysql_connect($server, $username, $password);
mysql_select_db($database, $conn);

// Mengambil data dari POST
$bulan = $_POST['bulan']; // Ambil bulan dari request
$idpc = $_POST['idpc'];
$user = $_POST['user'];
$lokasi = $_POST['lokasi'];
$tipe_perawatan_id = $_POST['tipe_perawatan_id']; // ID tipe perawatan
$tahun = $_POST['tahun'];
$selectedItems = $_POST['selected_items']; // Array checkbox yang dicentang
$unselectedItems = $_POST['unselected_items'];
$tanggal = date("Y-m-d");
$treated_by = $_POST['treated_by'];
$keterangan = $_POST['keterangan'];
$approve_by = $_POST['approve_by'];

// Cek apakah tipe_perawatan_id adalah 24 (Server) atau 25 (UPS)
$isServerOrUPS = ($tipe_perawatan_id == 24 || $tipe_perawatan_id == 25);

// Simpan ke tabel ket_perawatan (selalu menyertakan bulan)
$exist_ket_perawatan = mysql_query(
    "SELECT * FROM ket_perawatan WHERE idpc = '$idpc' AND tahun = '$tahun' AND bulan = '$bulan' AND treated_by = '$treated_by' "
);
$exist_ket_perawatan_count = mysql_num_rows($exist_ket_perawatan);

if ($exist_ket_perawatan_count == 0) {
    $query_ket = "INSERT INTO ket_perawatan (idpc, treated_by, ket, tahun, bulan, approve_by) 
                  VALUES ('$idpc', '$treated_by', '$keterangan', '$tahun', '$bulan', '$approve_by')";
    mysql_query($query_ket, $conn);
} else {
    $query_ket = "UPDATE ket_perawatan SET ket = '$keterangan', approve_by = '$approve_by' 
                  WHERE idpc = '$idpc' AND tahun = '$tahun' AND bulan = '$bulan' AND treated_by = '$treated_by'";
    mysql_query($query_ket, $conn);
}

// **Tambah Perawatan**
if (count($selectedItems) > 0) {
    foreach ($selectedItems as $itemId) {
        // Query cek eksistensi data dengan pengecualian
        if ($isServerOrUPS) {
            // Server & UPS menggunakan tahun dan bulan
            $query_exist = mysql_query(
                "SELECT id FROM perawatan 
                 WHERE idpc = '$idpc' AND tipe_perawatan_id = '$tipe_perawatan_id' 
                 AND tipe_perawatan_item_id = '$itemId' AND tahun = '$tahun'
                 AND bulan = '$bulan'"
                // --  AND bulan = '$bulan'"
            );
        } else {
            // Perawatan lain hanya menggunakan tahun
            $query_exist = mysql_query(
                "SELECT id FROM perawatan 
                 WHERE idpc = '$idpc' AND tipe_perawatan_id = '$tipe_perawatan_id' 
                 AND tipe_perawatan_item_id = '$itemId' AND YEAR(tanggal_perawatan) = '$tahun'"
            );
        }
        
        $exist_count = mysql_num_rows($query_exist);
        
        if ($exist_count == 0) {
            // Query insert dengan pengecualian
            if ($isServerOrUPS) {
                // Server & UPS menggunakan tahun dan bulan
                $query = "INSERT INTO perawatan (idpc, tipe_perawatan_id, tipe_perawatan_item_id, tanggal_perawatan, bulan, tahun) 
                          VALUES ('$idpc', '$tipe_perawatan_id', '$itemId', '$tanggal', '$bulan', '$tahun')";
            } else {
                // Perawatan lain hanya menggunakan tahun
                $query = "INSERT INTO perawatan (idpc, tipe_perawatan_id, tipe_perawatan_item_id, tanggal_perawatan) 
                          VALUES ('$idpc', '$tipe_perawatan_id', '$itemId', '$tanggal')";
            }

            mysql_query($query, $conn);
        }
    }
}

// **Hapus Perawatan**
if (count($unselectedItems) > 0) {
    foreach ($unselectedItems as $itemId) {
        // Query cek eksistensi dengan pengecualian
        if ($isServerOrUPS) {
            // Server & UPS menggunakan tahun dan bulan bedanya mengambil kolom tahun bukan tanggal_perawatan
            $query_exist = mysql_query(
                "SELECT id FROM perawatan 
                 WHERE idpc = '$idpc' AND tipe_perawatan_id = '$tipe_perawatan_id'  
                 AND tipe_perawatan_item_id = '$itemId' AND tahun = '$tahun' 
                 AND bulan = '$bulan'"
                //  AND bulan = '$bulan'"
            );
        } else {
            // Perawatan lain hanya menggunakan tahun
            $query_exist = mysql_query(
                "SELECT id FROM perawatan 
                 WHERE idpc = '$idpc' AND tipe_perawatan_id = '$tipe_perawatan_id' 
                 AND tipe_perawatan_item_id = '$itemId' AND YEAR(tanggal_perawatan) = '$tahun'"
            );
        }

        $exist_count = mysql_num_rows($query_exist);

        if ($exist_count > 0) {
            $row = mysql_fetch_array($query_exist);
            $idperawatan = $row['id'];

            // Hapus berdasarkan ID yang ditemukan
            $querydelete = "DELETE FROM perawatan WHERE id = '$idperawatan'";
            mysql_query($querydelete, $conn);
        }
    }
}

// Cek apakah ada perubahan data
if (mysql_affected_rows($conn) > 0) {
    echo "Data berhasil disimpan.";
} else {
    echo "Gagal menyimpan data.";
}

// Tutup koneksi
mysql_close($conn);

?>