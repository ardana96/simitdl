<?php
include('../config.php');
if(isset($_POST['tombol'])){
$idbarang=$_POST['idbarang'];

$query_delete="delete from tbarang where idbarang='".$idbarang."'";	
$update=mysql_query($query_delete);
if($update){
header("location:../user.php?menu=barang");}
else{
header("location:../user.php?menu=barang");}}
?>