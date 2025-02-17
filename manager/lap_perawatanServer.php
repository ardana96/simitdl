<?php
require('kop_perawatanServer.php');

 
function GenerateWord()
{
	//Get a random word
	$nb=rand(3,10);
	$w='';
	for($i=1;$i<=$nb;$i++)
		$w.=chr(rand(ord('a'),ord('z')));
	return $w;
}

function GenerateSentence()
{
	//Get a random sentence
	$nb=rand(1,10);
	$s='';
	for($i=1;$i<=$nb;$i++)
		$s.=GenerateWord().' ';
	return substr($s,0,-1);
}


$pdf=new PDF ('L');
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
//Table with 20 rows and 5 columns
$pdf->SetWidths(array(7,25,20,25,42,50,20,15,15,15,15,15,15));
//srand(microtime()*1000000);

//koneksi ke database
mysql_connect("localhost","root","dlris30g");
mysql_select_db("sitdl");

$status=$_POST['status'];
$bulan=$_POST['bulan'] ? $_POST['bulan'] : $_GET['bulan'];
$pdivisi=$_POST['pdivisi'] ? $_POST['pdivisi'] : $_GET['pdivisi'];
$tahun_rawat=$_POST['tahun'] ? $_POST['tahun'] : $_GET['tahun'];
function generatebulan($tgl)
{

	$bln_angka =  $tgl;
	
	$tahun = substr($tgl, 0,4);
	 console.log($bln_angka);
	 //var_dump($bln_angka);
	if($bln_angka == "01"){
	$bln_nama = "JANUARI";
	}
	else if ($bln_angka == "02") {
		$bln_nama="FEBRUARI";
	}
	else if ($bln_angka == "03") {
		$bln_nama="MARET";
	}
	else  if ($bln_angka == "04"){
		$bln_nama="APRIL";
	}
	else if ($bln_angka == "05") {
		$bln_nama="MEI";
	}
	else if ($bln_angka == "06") {
		$bln_nama="JUNI";
	}
	else if ($bln_angka == "07") {
		$bln_nama="JULI";
	}
	else if ($bln_angka == "08") {
		$bln_nama="AGUSTUS";
	}
	else if ($bln_angka == "09") {
		$bln_nama="SEPTEMBER";
	}
	else if ($bln_angka == "10") {
		$bln_nama="OKTOBER";
	}
	else if ($bln_angka == "11") {
		$bln_nama="NOVEMBER";
	}
	else if ($bln_angka == "12"){
		$bln_nama="DESEMBER";
	}else{
		$bln_nama="SEMUA";
	}

	return $bln_nama;

}
$bulanGen = generatebulan($bulan);
$pdf->Header1($bulanGen);


//mengambil data dari tabel
//$sql=mysql_query("Select * from peripheral where (bulan LIKE '%".$bulan."%' OR '".$bulan."' = '') AND (divisi LIKE '%".$pdivisi."%' OR '".$pdivisi."' = '') and tipe = 'server'  order by nomor ");
//$sql=mysql_query("Select * from pcaktif2  where  divisi='".$pdivisi."'order by nomor ");

// $sql=mysql_query("SELECT 
    
//     a.id_perangkat ,
//     a.user,
//     a.divisi AS bagian,
//     b.tipe_perawatan_id,
//     a.`tgl_perawatan` AS tgl_perawatan,
// 	a.lokasi,
// 	a.perangkat,
	
// 	b.tanggal_perawatan,
// 	(SELECT treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = a.id_perangkat AND  tahun = $tahun_rawat Order BY id desc) AS treated_by,
//     (SELECT approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = a.id_perangkat AND tahun = $tahun_rawat) AS approve_by,
//     MAX(CASE WHEN d.nama_perawatan = 'Kondisi OS' THEN 'true' END) AS item1,
//     MAX(CASE WHEN d.`nama_perawatan` = 'Kondisi Fisik Server' THEN 'true' END) AS item2,
//     MAX(CASE WHEN d.`nama_perawatan` = 'Kondisi Apps' THEN 'true' END) AS item3,
// 	MAX(CASE WHEN d.`nama_perawatan` = 'Kondisi CPU' THEN 'true' END) AS item4

// FROM 
//     peripheral a
// LEFT JOIN 
    

// 	(SELECT * FROM perawatan WHERE YEAR(tanggal_perawatan) = '".$tahun_rawat."'  ) AS b ON a.id_perangkat = b.idpc

// LEFT JOIN  
//  	tipe_perawatan_item d ON b.`tipe_perawatan_item_id` = d.`id`
// WHERE LOWER(a.tipe) = 'server' 
// AND
// (a.bulan LIKE '%".$bulan."%' OR '".$bulan."' = '') AND (a.divisi LIKE '%".$pdivisi."%' OR '".$pdivisi."' = '') 



// GROUP BY 
//     a.id_perangkat, a.user, b.tipe_perawatan_id



// ");


// $sql=mysql_query("SELECT 
//     a.id_perangkat, 
//     a.user, 
//     a.divisi AS bagian, 
//     a.tgl_perawatan, 
//     a.lokasi, 
//     a.perangkat, 
//     COALESCE(b.tipe_perawatan_id, '-') AS tipe_perawatan_id, 
//     COALESCE(b.tanggal_perawatan, '-') AS tanggal_perawatan, 

//     (SELECT treated_by 
//      FROM ket_perawatan 
//      WHERE idpc = a.id_perangkat 
//      AND tahun = '$tahun_rawat'
//      AND bulan = '$bulan' 
//      ORDER BY id DESC 
//      LIMIT 1) AS treated_by,

//     (SELECT approve_by 
//      FROM ket_perawatan 
//      WHERE idpc = a.id_perangkat 
//      AND tahun = '$tahun_rawat' 
//      AND bulan = '$bulan'
//      LIMIT 1) AS approve_by,

// 	MAX(CASE WHEN d.nama_perawatan = 'Kondisi OS' THEN 'true' END) AS item1,
//     MAX(CASE WHEN d.`nama_perawatan` = 'Kondisi Fisik Server' THEN 'true' END) AS item2,
// 	MAX(CASE WHEN d.`nama_perawatan` = 'Kondisi Apps' THEN 'true' END) AS item3,
//  	MAX(CASE WHEN d.`nama_perawatan` = 'Kondisi CPU' THEN 'true' END) AS item4

// FROM peripheral a

// -- Perbaikan agar semua perangkat tetap muncul
// LEFT JOIN (SELECT * FROM perawatan WHERE tahun = '$tahun_rawat' AND bulan = '$bulan') AS b 
//     ON a.id_perangkat = b.idpc

// LEFT JOIN tipe_perawatan_item d 
//     ON b.tipe_perawatan_item_id = d.id

// WHERE LOWER(a.tipe) = 'server' 

// -- Perbaikan agar filter bulan tidak menghilangkan data
// AND a.bulan = '00'

// -- Filter divisi tetap fleksibel
// AND ('$pdivisi' = '' OR a.divisi LIKE '%$pdivisi%')

// -- Perbaikan di GROUP BY
// GROUP BY a.id_perangkat, a.user, a.divisi, a.tgl_perawatan, 
//          a.lokasi, a.perangkat, b.tipe_perawatan_id, b.tanggal_perawatan;
// ");


$sql=mysql_query("SELECT 
    a.id_perangkat, 
    a.user, 
    a.divisi AS bagian, 

    -- Modifikasi Tanggal Perawatan mengikuti realisasi bulan sebelumnya, kecuali untuk Januari
    CASE 
        -- Jika bulan ekspor Januari, gunakan tanggal perawatan dari tabel asli
        WHEN '$bulan' = '01' 
        THEN COALESCE(a.tgl_perawatan, b.tanggal_perawatan, '-') 

        -- Jika ada realisasi bulan sebelumnya, gunakan tanggal yang sama tetapi ubah bulannya
        WHEN (SELECT p.tanggal_perawatan 
              FROM perawatan p
              WHERE p.idpc = a.id_perangkat 
              AND p.bulan = LPAD('$bulan' - 1, 2, '0')
              AND p.tahun = '$tahun_rawat'
              ORDER BY p.id DESC LIMIT 1) IS NOT NULL 
        THEN DATE_FORMAT(
            STR_TO_DATE(
                CONCAT(
                    (SELECT DAY(p.tanggal_perawatan) 
                     FROM perawatan p
                     WHERE p.idpc = a.id_perangkat 
                     AND p.bulan = LPAD('$bulan' - 1, 2, '0')
                     AND p.tahun = '$tahun_rawat'
                     ORDER BY p.id DESC LIMIT 1), 
                    '-$bulan-$tahun_rawat'
                ), '%d-%m-%Y'
            ), '%Y-%m-%d')
        ELSE '-' 
    END AS tgl_perawatan,

    -- Kolom Tgl Realisasi tetap tidak diubah
    COALESCE(b.tanggal_perawatan, '-') AS tgl_realisasi,

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

-- Menggunakan LEFT JOIN untuk mengambil data perawatan terkait
LEFT JOIN perawatan b 
    ON a.id_perangkat = b.idpc 
    AND b.tahun = '$tahun_rawat' 
    AND b.bulan = '$bulan' 

LEFT JOIN tipe_perawatan_item d 
    ON b.tipe_perawatan_item_id = d.id

WHERE LOWER(a.tipe) = 'server' 

AND a.bulan = '00'

-- Filter divisi tetap fleksibel
AND ('$pdivisi' = '' OR a.divisi LIKE '%$pdivisi%')

-- Perbaikan di GROUP BY
GROUP BY a.id_perangkat, a.user, a.divisi, tgl_perawatan, 
         a.lokasi, a.perangkat, b.tipe_perawatan_id, b.tanggal_perawatan, b.tanggal_perawatan;
");

$count=mysql_num_rows($sql);
$no=1;
for($i=0;$i<$count;$i++);{
while ($database = mysql_fetch_array($sql)) {
	$nomor=$database['nomor'];
	$tgl_perawatan=$database['tgl_perawatan'];
	$tanggal_realisasi = $database['tanggal_perawatan'];
	$user=$database['user'];
	$keterangan=$database['keterangan'];
	
	$bagian = $database['bagian'];
	$lokasi= $database['lokasi'];
	
	$id_perangkat = $database['id_perangkat'];
	$perangkat = $database['perangkat'];
	$item1 = $database['item1'];
	$item2 = $database['item2'];
	$item3 = $database['item3'];
	$item4 = $database['item4'];
	$treated_by = $database['treated_by'];
$approve_by = $database['approve_by'];
$b=mysql_query("select * from bulan where id_bulan='".$bulan."'");
while($dat=mysql_fetch_array($b)){
	$namabulan=$dat['bulan'];
	$bulanbesar=strtoupper($namabulan);
}

// $tgl_jadwal = date('Y-m-d', strtotime('+1 year', strtotime( $tgl_realisasi )));

// if ($tgl_jadwal == '1971-01-01')
// 	$tgl_jadwal2 = '-';
// else 
// 	$tgl_jadwal2 = $tgl_jadwal;

$data = array(
	//array($no++, $bagianbesar, $tgl_jadwal2, '', $id, $namapc.'/'.$user, $item1, $item2, $item3, $item4, $item5, $item6, $item7, '', '', ''),
	array($no++, $lokasi,$tgl_perawatan,$tanggal_realisasi ,$id_perangkat,$perangkat.' / '.$user,$item1, $item2, $item3, $item4, $treated_by , $approve_by,'')
	//array($no++, $lokasi,$tgl_perawatan,'',$id_perangkat,$perangkat.' / '.$user,'','','','','','')
	
	
	// Tambahkan baris lain jika diperlukan
);
foreach ($data as $row) {
    // Angka dalam array menunjukkan indeks kolom yang akan menampilkan gambar ceklis
    $pdf->RowWithCheck($row, 'true'); // Kolom ke-4, ke-7, dan ke-11 berisi gambar ceklis
}

//$pdf->Row(array($no++,$bulanbesar,$tgl_jadwal2,$ippc,$namapc.'/'.$user,$osbesar,$appsbesar,'',$cpubesar,$monitorbesar,$printerbesar,'','',$petugas,$a,$keterangan));

//$pdf->Row(array($no++, $lokasi,$tgl_perawatan,'',$id_perangkat,$perangkat.' / '.strtoupper($user),'','','','','','',''));
}}
$pdf->Output();
?>
