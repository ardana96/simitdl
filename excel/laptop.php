<?php
session_start();
include('../config.php');
?>
<?php

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=pemakaipc.xls");//ganti nama sesuai keperluan
header("Pragma: no-cache");
header("Expires: 0");

$user_database="root";
$password_database="dlris30g";
$server_database="localhost";
$nama_database="sitdl";
$koneksi=mysql_connect($server_database,$user_database,$password_database);
if(!$koneksi){
die("Tidak bisa terhubung ke server".mysql_error());}
$pilih_database=mysql_select_db($nama_database,$koneksi);
if(!$pilih_database){
die("Database tidak bisa digunakan".mysql_error());}
$id_divisi=$_POST['id_divisi'];
$status=$_POST['status'];
$bln_akhir=$_POST['bln_akhir'];
$thn_akhir=$_POST['thn_akhir'];
$tanggal_akhir=$thn_akhir.$bln_akhir.$tgl_akhir;
$tanggal_akhir_format=$bln_akhir."-".$thn_akhir;

?>
<style>
#pilih_laporan {
	background-color: #666; height: 30px; width: 100%;
	font-weight: bold; color: #FFF;
	text-transform: capitalize;}
#tampil_laporan{
	height: auto;width: 100%; overflow: auto;
	text-transform: capitalize;}
.judul_laporan{
	font-size: 14pt; font-weight: bold;
	color: #000; text-align: center;}
.header_footer{
	background-color: #F5F5F5;
	text-align: center; font-weight: bold;}
.isi_laporan{
	font-size: 10pt; color: #000;
	background-color: #FFF;}
.resume_laporan{
	background-color: #333;
	font-weight: bold; color: #FFF;}
@media print {  
#pilih_laporan{display: none;} } 
</style>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/laporan.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div id="tampil_laporan"><table width="95%" border="0" align="center">
  <tr>
    <td colspan="6" align="center" class="judul_laporan"><p>Daftar Pemakaian Laptop</p>
	<br>
   </td>
    </tr>
	
	
	
  <tr class="header_footer">
<td>Nomor</td>
    <td>User</td>
    <td>Divisi</td>
	<td>Bagian</td>
	<td>ID PC</td>
	<td>Nama PC</td>

  </tr>
  
<?
$no=1;
$a="SELECT * from pcaktif  where model='laptop' ";
$aa=mysql_query($a);
while ($dataaa=mysql_fetch_array($aa)){
$user=$dataaa['user'];
$divisi=$dataaa['divisi'];
$bagian=$dataaa['bagian'];
$idpc=$dataaa['idpc'];
$namapc=$dataaa['namapc'];?>
<tr >
<td><?echo $no++;?></td>
    <td><?echo $user;?></td>
    <td><?echo $divisi;?></td>
	<td><?echo $bagian;?></td>
	<td><?echo $idpc;?></td>
	<td><?echo $namapc;?></td>

  </tr>
  <tr>
  <td colspan=6><hr></td>
  </tr>
  
<?}?>

 

  
   

 


</table>
</div>
</body>
</html>
<iframe width=174 height=189 name="gToday:normal:../calender/agenda.js" id="gToday:normal:../calender/agenda.js" src="../calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>


