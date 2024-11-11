<?php
include('../config.php');
if(isset($_POST['tombol'])){
$idsupp=$_POST['idsupp'];

$query_delete="delete from tsupplier where idsupp='".$idsupp."'";	
$update=mysql_query($query_delete);
if($update){
header("location:../user.php?menu=supplier");}
else{
header("location:../user.php?menu=supplier");}}
?>