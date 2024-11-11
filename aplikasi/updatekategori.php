<?php
include('../config.php');
if(isset($_POST['tombol'])){
$idkategori=$_POST['idkategori'];
$kategori=$_POST['kategori'];


$query_update="UPDATE tkategori SET kategori= '".$kategori."' WHERE idkategori='".$idkategori."'";	
$update=mysql_query($query_update);
if($update){
header("location:../user.php?menu=kategori&stt= Update Berhasil");}
else{
header("location:../user.php?menu=kategori&stt=gagal");}}
?>