<?php
//session_start();
include('../config.php');
if(isset($_POST['idbarang'])&&isset($_POST['nofaktur'])){
$kd_barang=$_POST['idbarang'];
$no_faktur=$_POST['nofaktur'];
$jml=$_POST['jumlah'];
$nok=$_POST['nomorkasus'];
$tindakan=$_POST['TindakanPerbaikan'];
$teknisi=$_POST['TeknisiPerbaikan'];


$query="SELECT * from tbarang,tkategori where tbarang.idkategori=tkategori.idkategori and  tbarang.idbarang='$kd_barang' ";
$get_data=mysql_query($query);
$found=mysql_num_rows($get_data);
if($found>0){
$data=mysql_fetch_array($get_data);
$idbarang=$data['idbarang'];
$kategori=$data['kategori'];
$namabarang=$data['namabarang'];
$stock=$data['stock'];
$stockbaru=$stock-$jml;



$query_rinci_jual="INSERT INTO trincipengambilan (nofaktur,idbarang,jumlah,namabarang,sesi)VALUES ('".$no_faktur."','".$idbarang."','".$jml."','".$namabarang."','ADM') ";
$insert_rinci_jual=mysql_query($query_rinci_jual);

$query_update="update tbarang set stock='$stockbaru' where idbarang='$kd_barang'";
$update=mysql_query($query_update);



if($insert_rinci_jual){
header("location:../user.php?menu=fkerusakanpcbaru&nomor=".$nok."&teknisi=".$teknisi."&tindakan=".$tindakan);}
else{
echo "Terjadi Kesalahan, Tidak dapat melanjutkan proses";}}
else{
echo "<script type='text/javascript'> alert('Kode Barang Tidak Terdaftar/Stock Habis!'); document.location.href='../user.php?menu=keluar'; </script>;";}}
?>