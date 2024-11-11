<?php
include('../config.php');
$idkategori=$_GET['idkategori'];
$query="SELECT * from  tkategori WHERE idkategori='".$idkategori."' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);
$idkategori=$hasil['idkategori'];
$kategori=$hasil['kategori'];


$data=$idkategori."&&&".$kategori;
echo $data; ?>