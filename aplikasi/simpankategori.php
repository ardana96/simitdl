<?php
include('../config.php');
if(isset($_POST['tombol'])){
	
$idkategori=$_POST['idkategori'];
$kategori=$_POST['kategori'];
$nmkecil=strtolower($kategori);


$query_insert="insert into tkategori (idkategori,kategori) values ('".$idkategori."','".$nmkecil."')";	
$update=mysql_query($query_insert);
if($update){
header("location:../user.php?menu=kategori&stt= Simpan Berhasil");}
else{
header("location:../user.php?menu=kategori&stt=gagal");}}
?>