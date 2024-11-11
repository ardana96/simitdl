<?php
session_start();
include('../config.php');
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
	background-color: #999;
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
<?php
if(isset($_GET['idkategori'])){
$idkategori=$_GET['idkategori'];


$tanggal=true;

//$kd_toko=$_POST['kd_toko'];
$query_get_faktur="SELECT * from tbarang where idkategori='$idkategori' ";}
else{
$tanggal=false;

//$kd_toko=$_SESSION['kd_toko'];
$query_get_faktur="SELECT * from tbarang where idkategori='$idkategori' ";}

$get_faktur=mysql_query($query_get_faktur);
$count_faktur=mysql_num_rows($get_faktur);
$total_seluruh_beli=0; $total_seluruh_item=0; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/laporan.css" rel="stylesheet" type="text/css" />
</head>

<body >
<div id="tampil_laporan"><table width="95%" border="0" align="center">
  <tr>
    <td colspan="5" align="center" class="judul_laporan"><p>Detail Barang Per Kategori</p>
     <br></td>
    </tr>
	<tr class="header_footer">
    <td>Nama Barang</td>
	<td>Stock</td>
  </tr>

<?php
for($i=0; $i<$count_faktur; $i++){
$faktur=mysql_fetch_array($get_faktur);
$namabarang=$faktur['namabarang'];
$stock=$faktur['stock'];
?>



   
  

<tr class="isi_laporan">
<td><?php echo $namabarang; ?>&nbsp;</td>
<td><?php echo $stock; ?>&nbsp;</td>

  </tr>

<tr>
<td colspan='2'><hr></td>
</tr>
  <?php }?>




</table>
</div>
</body>
</html>
<iframe width=174 height=189 name="gToday:normal:../calender/agenda.js" id="gToday:normal:../calender/agenda.js" src="../calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>