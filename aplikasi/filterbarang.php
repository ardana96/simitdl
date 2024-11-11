<?php
include('../config.php');
$idbarang=$_GET['idbarang'];
$query="SELECT * from  tbarang WHERE idbarang='".$idbarang."' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);
$idbarang=$hasil['idbarang'];
$idkategori=$hasil['idkategori'];
$namabarang=$hasil['namabarang'];
$barcode=$hasil['barcode'];
$stock=$hasil['stock'];
$inventory=$hasil['inventory'];
$refil=$hasil['refil'];
$stockawal=$hasil['stockawal'];
$keterangan=$hasil['keterangan'];

$data=$idbarang."&&&".$idkategori."&&&".$namabarang."&&&".$barcode."&&&".$stock."&&&".$inventory."&&&".$refil."&&&".$keterangan."&&&".$stockawal;
echo $data; ?>