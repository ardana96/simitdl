<?php
include('../config.php');
if(isset($_POST['tombol'])){
$idsupp=$_POST['idsupp'];
$namasupp=$_POST['namasupp'];
$alamatsupp=$_POST['alamatsupp'];
$telpsupp=$_POST['telpsupp'];

$query_update="UPDATE tsupplier SET namasupp= '".$namasupp."',alamatsupp= '".$alamatsupp."',telpsupp= '".$telpsupp."' WHERE idsupp='".$idsupp."'";	
$update=mysql_query($query_update);
if($update){
header("location:../user.php?menu=supplier&stt= Update Berhasil");}
else{
header("location:../user.php?menu=supplier&stt=gagal");}}
?>