<?php

// Konfigurasi database
$server_database = "localhost";
$user_database = "root";
$password_database = "dlris30g";
$nama_database = "sitdl";

// Membuat koneksi menggunakan MySQLi
$koneksiv1 = new mysqli($server_database, $user_database, $password_database, $nama_database);

// Validasi koneksi
if ($koneksiv1->connect_error) {
    die(json_encode(array("error" => "Koneksi database gagal: " . $koneksiv1->connect_error)));
}

// Mendapatkan data dari request JSON
$data = json_decode(file_get_contents('php://input'), true);

// Debugging: Cek apakah request JSON diterima dengan benar
error_log("Request JSON: " . json_encode($data));

// Ambil parameter pagination
$start = isset($data['start']) ? intval($data['start']) : 0;
$length = isset($data['length']) ? intval($data['length']) : 100;

// Inisialisasi query dasar
$query = "SELECT * FROM pcaktif WHERE 1=1";
$params = array();
$types = "";

// Tambahkan filter berdasarkan input
if (!empty($data['divisi'])) {
    $query .= " AND divisi = ?";
    $params[] = $data['divisi'];
    $types .= "s";
}
if (!empty($data['bagian'])) {
    $query .= " AND bagian = ?";
    $params[] = $data['bagian'];
    $types .= "s";
}
if (!empty($data['subbagian'])) {
    $query .= " AND subbagian = ?";
    $params[] = $data['subbagian'];
    $types .= "s";
}
if (!empty($data['lokasi'])) {
    $query .= " AND lokasi = ?";
    $params[] = $data['lokasi'];
    $types .= "s";
}
if (!empty($data['bulan'])) {
    $query .= " AND bulan = ?";
    $params[] = $data['bulan'];
    $types .= "s";
}
if (!empty($data['model'])) {
    $query .= " AND model = ?";
    $params[] = $data['model'];
    $types .= "s";
}

// Tambahkan pagination
$query .= " LIMIT ?, ?";
$params[] = $start;
$params[] = $length;
$types .= "ii";

// Eksekusi Prepared Statement tanpa "..."
$stmt = $koneksiv1->prepare($query);

// Bind parameter secara manual
if (!empty($params)) {
    $bind_names = array();
    $bind_names[] = &$types;
    for ($i = 0; $i < count($params); $i++) {
        $bind_names[] = &$params[$i];
    }
    
    // Panggil bind_param dengan call_user_func_array
    call_user_func_array(array($stmt, 'bind_param'), $bind_names);
}

$stmt->execute();

// **PERBAIKAN: Menggunakan bind_result() karena get_result() tidak tersedia**
$meta = $stmt->result_metadata();
$output = array();

if ($meta) {
    $fields = array();
    $row = array();

    while ($field = $meta->fetch_field()) {
        $fields[] = $field->name;
        $row[$field->name] = null;
    }

    $bindParams = array();
    foreach ($fields as $field) {
        $bindParams[] = &$row[$field];
    }

    call_user_func_array(array($stmt, 'bind_result'), $bindParams);

    while ($stmt->fetch()) {
        $temp = array();
        foreach ($fields as $field) {
            $temp[$field] = $row[$field];
        }
        $output[] = $temp;
    }
}

// Jika tombol Clear diklik, kirim semua data tanpa filter
if (!empty($data['clear'])) {
    $query = "SELECT * FROM pcaktif ORDER BY ippc DESC LIMIT ?, ?";
    $stmt = $koneksiv1->prepare($query);
    $stmt->bind_param("ii", $start, $length);
    $stmt->execute();

    // **Gunakan bind_result() lagi**
    $meta = $stmt->result_metadata();
    $output = array();

    if ($meta) {
        $fields = array();
        $row = array();

        while ($field = $meta->fetch_field()) {
            $fields[] = $field->name;
            $row[$field->name] = null;
        }

        $bindParams = array();
        foreach ($fields as $field) {
            $bindParams[] = &$row[$field];
        }

        call_user_func_array(array($stmt, 'bind_result'), $bindParams);

        while ($stmt->fetch()) {
            $temp = array();
            foreach ($fields as $field) {
                $temp[$field] = $row[$field];
            }
            $output[] = $temp;
        }
    }
}

// Kirim hasil dalam format JSON
header('Content-Type: application/json');
echo json_encode($output);

// Tutup koneksi
$stmt->close();
$koneksiv1->close();

?>
