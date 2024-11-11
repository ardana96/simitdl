<?php
include('../config.php');
if(isset($_POST['tombol'])){
$idbarang=$_POST['idbarang'];
$idkategori=$_POST['idkategori'];
$namabarang=$_POST['namabarang'];
$barcode=$_POST['barcode'];
$stock=$_POST['stock'];
$inventory=$_POST['inventory'];
$refil=$_POST['refil'];
$stockawal=$_POST['stockawal'];
$keterangan=$_POST['keterangan'];

$query_update="UPDATE tbarang SET stockawal= '".$stockawal."',keterangan= '".$keterangan."',inventory= '".$inventory."',refil= '".$refil."',idkategori= '".$idkategori."',stock= '".$stock."',barcode= '".$barcode."',namabarang= '".$namabarang."' WHERE idbarang='".$idbarang."'";	
$update=mysql_query($query_update);
if($update){
header("location:../user.php?menu=barang&stt= Update Berhasil");}
else{
header("location:../user.php?menu=barang&stt=gagal");}}
?>