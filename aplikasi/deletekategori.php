<?php
include('../config.php');
if(isset($_POST['tombol'])){
$idkategori=$_POST['idkategori'];

$query_delete="delete from tkategori where idkategori='".$idkategori."'";	
$update=mysql_query($query_delete);
if($update){
header("location:../user.php?menu=kategori");}
else{
header("location:../user.php?menu=kategori");}}
?>