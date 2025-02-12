<?php
require('kop_perawatanUPS.php');

// Koneksi ke database
$conn = mysql_connect("localhost", "root", "dlris30g");
if (!$conn) {
    die("Koneksi database gagal: " . mysql_error());
}
mysql_select_db("sitdl");

$status = isset($_POST['status']) ? $_POST['status'] : '';
$bulan = isset($_POST['bulan']) ? $_POST['bulan'] : (isset($_GET['bulan']) ? $_GET['bulan'] : '');
$pdivisi = isset($_POST['pdivisi']) ? $_POST['pdivisi'] : (isset($_GET['pdivisi']) ? $_GET['pdivisi'] : '');
$tahun_rawat = isset($_POST['tahun']) ? $_POST['tahun'] : (isset($_GET['tahun']) ? $_GET['tahun'] : '');

function generatebulan($tgl) {
    $bulan_array = array(
        "01" => "JANUARI", "02" => "FEBRUARI", "03" => "MARET", "04" => "APRIL",
        "05" => "MEI", "06" => "JUNI", "07" => "JULI", "08" => "AGUSTUS",
        "09" => "SEPTEMBER", "10" => "OKTOBER", "11" => "NOVEMBER", "12" => "DESEMBER"
    );
    return isset($bulan_array[$tgl]) ? $bulan_array[$tgl] : "SEMUA";
}

$bulanGen = generatebulan($bulan);

$pdf = new PDF('L');
$pdf->AddPage();
$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(7, 25, 20, 25, 42, 45, 20, 15, 20, 15, 15, 15, 15));
$pdf->Header1($bulanGen);

// $query = "SELECT 
//     a.id_perangkat, a.user, a.divisi AS bagian, b.tipe_perawatan_id,
//     a.tgl_perawatan, a.lokasi, a.perangkat, b.tanggal_perawatan,
//     (SELECT treated_by FROM ket_perawatan WHERE idpc = a.id_perangkat AND tahun = '$tahun_rawat' ORDER BY id DESC LIMIT 1) AS treated_by,
//     (SELECT approve_by FROM ket_perawatan WHERE idpc = a.id_perangkat AND tahun = '$tahun_rawat' LIMIT 1) AS approve_by,
//     MAX(CASE WHEN d.nama_perawatan = 'Kondisi Fisik UPS' THEN 'true' END) AS item1,
//     MAX(CASE WHEN d.nama_perawatan = 'Kondisi Baterai' THEN 'true' END) AS item2,
//     MAX(CASE WHEN d.nama_perawatan = 'Kondisi Lampu Indikator' THEN 'true' END) AS item3,
//     MAX(CASE WHEN d.nama_perawatan = 'Kondisi Alarm' THEN 'true' END) AS item4
// FROM peripheral a
// LEFT JOIN (SELECT * FROM perawatan WHERE YEAR(tanggal_perawatan) = '$tahun_rawat') AS b ON a.id_perangkat = b.idpc
// LEFT JOIN tipe_perawatan_item d ON b.tipe_perawatan_item_id = d.id
// WHERE LOWER(a.tipe) = 'ups' 
// AND ('$bulan' = '' OR a.bulan LIKE '%$bulan%')
// AND ('$pdivisi' = '' OR a.divisi LIKE '%$pdivisi%')
// GROUP BY a.id_perangkat, a.user, b.tipe_perawatan_id";


$query =
"SELECT 
    a.id_perangkat, 
    a.user, 
    a.divisi AS bagian, 
    a.tgl_perawatan, 
    a.lokasi, 
    a.perangkat, 
    COALESCE(b.tipe_perawatan_id, '-') AS tipe_perawatan_id, 
    COALESCE(b.tanggal_perawatan, '-') AS tanggal_perawatan, 

    (SELECT treated_by 
     FROM ket_perawatan 
     WHERE idpc = a.id_perangkat 
     AND tahun = '$tahun_rawat'
     AND bulan = '$bulan' 
     ORDER BY id DESC 
     LIMIT 1) AS treated_by,

    (SELECT approve_by 
     FROM ket_perawatan 
     WHERE idpc = a.id_perangkat 
     AND tahun = '$tahun_rawat' 
     AND bulan = '$bulan'
     LIMIT 1) AS approve_by,

    MAX(CASE WHEN d.nama_perawatan = 'Kondisi Fisik UPS' THEN 'true' END) AS item1,
    MAX(CASE WHEN d.nama_perawatan = 'Kondisi Baterai' THEN 'true' END) AS item2,
    MAX(CASE WHEN d.nama_perawatan = 'Kondisi Lampu Indikator' THEN 'true' END) AS item3,
    MAX(CASE WHEN d.nama_perawatan = 'Kondisi Alarm' THEN 'true' END) AS item4

FROM peripheral a

-- Perbaikan agar semua perangkat tetap muncul
LEFT JOIN (SELECT * FROM perawatan WHERE tahun = '$tahun_rawat' and bulan = '$bulan') AS b 
    ON a.id_perangkat = b.idpc

LEFT JOIN tipe_perawatan_item d 
    ON b.tipe_perawatan_item_id = d.id

WHERE LOWER(a.tipe) = 'ups' 

-- Perbaikan agar filter bulan tidak menghilangkan data
AND a.bulan = '00'

-- Filter divisi tetap fleksibel
AND ('$pdivisi' = '' OR a.divisi LIKE '%$pdivisi%')

-- Perbaikan di GROUP BY
GROUP BY a.id_perangkat, a.user, a.divisi, a.tgl_perawatan, 
         a.lokasi, a.perangkat, b.tipe_perawatan_id, b.tanggal_perawatan;
";

$sql = mysql_query($query);
if (!$sql) {
    die("Query Error: " . mysql_error());
}

$no = 1;
while ($database = mysql_fetch_array($sql)) {
    $data = array(
        array(
            $no++, $database['lokasi'], $database['tgl_perawatan'], $database['tanggal_perawatan'],
            $database['id_perangkat'], $database['perangkat'] . ' / ' . $database['user'],
            $database['item1'], $database['item2'], $database['item3'], $database['item4'],
            $database['treated_by'], $database['approve_by'], ''
        )
    );
    foreach ($data as $row) {
        $pdf->RowWithCheck($row, 'true');
    }
}
$pdf->Output();
?>
