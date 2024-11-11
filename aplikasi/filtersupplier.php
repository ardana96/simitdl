<?php
include('../config.php');
$idsupp=$_GET['idsupp'];
$query="SELECT * from  tsupplier WHERE idsupp='".$idsupp."' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);
$idsupp=$hasil['idsupp'];
$namasupp=$hasil['namasupp'];
$alamatsupp=$hasil['alamatsupp'];
$telpsupp=$hasil['telpsupp'];

$data=$namasupp."&&&".$alamatsupp."&&&".$telpsupp."&&&".$idsupp;
echo $data; ?>