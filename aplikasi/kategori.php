<?include('config.php');?>  
<?
function kdauto($tabel, $inisial){
	$struktur	= mysql_query("SELECT * FROM $tabel");
	$field		= mysql_field_name($struktur,0);
	$panjang	= mysql_field_len($struktur,0);

 	$qry	= mysql_query("SELECT max(".$field.") FROM ".$tabel);
 	$row	= mysql_fetch_array($qry); 
 	if ($row[0]=="") {
 		$angka=0;
	}
 	else {
 		$angka		= substr($row[0], strlen($inisial));
 	}
	
 	$angka++;
 	$angka	=strval($angka); 
 	$tmp	="";
 	for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
		$tmp=$tmp."0";	
	}
 	return $inisial.$tmp.$angka;
}?>
<script language="javascript">
function createRequestObject() {
var ajax;
if (navigator.appName == 'Microsoft Internet Explorer') {
ajax= new ActiveXObject('Msxml2.XMLHTTP');} 
else {
ajax = new XMLHttpRequest();}
return ajax;}

var http = createRequestObject();
function sendRequest(idkategori){
if(idkategori==""){
alert("Anda belum memilih kode kategori !");}
else{   
http.open('GET', 'aplikasi/filterkategori.php?idkategori=' + encodeURIComponent(idkategori) , true);
http.onreadystatechange = handleResponse;
http.send(null);}}

function handleResponse(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');
document.getElementById('idkategori').value = string[0];  
document.getElementById('kategori').value = string[1];
                                       
document.getElementById('jumlah').value="";
document.getElementById('jumlah').focus();

}}

var mywin; 
function popup(idkategori){
	if(idkategori==""){
alert("Anda kategori");}
else{   
mywin=window.open("manager/lap_jumkat.php?idkategori=" + idkategori ,"_blank",	"toolbar=yes,location=yes,menubar=yes,copyhistory=yes,directories=no,status=no,resizable=no,width=500, height=400"); mywin.moveTo(100,100);}
}



</script>
            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2> Data Kategori</h2>



                    </div>
                </div>

                <hr />


                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
          
                           <button class="btn btn-primary" data-toggle="modal"  data-target="#newReg">
                                Tambah 
                            </button>
						</div>
                        <div class="panel-body">
                            <div class="table-responsive" style='overflow: scroll;'>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID Kategori</th>
                                            <th>Kategori</th>
											 <th>Jml/Ketegori</th>
											 <th>Detail</th>
											 <th>Edit</th>
                                          
											
											<th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?$sql = mysql_query("SELECT * FROM tkategori");
				if(mysql_num_rows($sql) > 0){
				while($data = mysql_fetch_array($sql)){
				$idkategori=$data['idkategori'];
				$kategori=$data['kategori'];
		
			$tt = mysql_query("SELECT sum(stock)as jumlahh FROM  tbarang WHERE idkategori ='$idkategori' ");

	
				while($datatt = mysql_fetch_array($tt)){
				$jumlahh=$datatt['jumlahh'];
				}
				
			
				?>
				
                                        <tr class="gradeC">
                                            <td><? echo $idkategori ?></td>
                                            <td><? echo $kategori ?></td>
											    <td><? echo $jumlahh ?></td>
												 <td align="center">
				<button class="btn btn-primary" value="<?php echo $idkategori; ?>" onclick="popup(this.value)" name='tombol'>
                                Detail
                            </button>
		</td>
                                           <td class="center">
											
											
										
											 <button type="submit" class="btn btn-primary" value='<?php echo $idkategori; ?>' data-toggle="modal"  data-target="#newReggg" name='tomboledit'  onclick="new sendRequest(this.value)">
                                Edit
                            </button>
												
											</td>
                             
											  <td class="center"><form action="aplikasi/deletekategori.php" method="post" >
											<input type="hidden" name="idkategori" value=<?php echo $idkategori; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit">X</button>
											</form> </td>
                                            
                                        </tr>
		<?}}?>                      
                                    </tbody>
                                </table>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
           
		   
		   
		   
		   	   <div class="col-lg-12">
                        <div class="modal fade" id="newReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4"> Tambah Kategori</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpankategori.php" method="post"  enctype="multipart/form-data" name="postform2">
                                 
   <div class="form-group">
                                         
                                            <input class="form-control" type="text" name="idkategori" value="<? echo kdauto("tkategori",""); ?>" readonly>
                                    
                                        </div>
											
<div class="form-group">
                                           
                                            <input placeholder="Kategori" class="form-control" type="text" name="kategori"  >
                                    
                                        </div>	     

                                       
                                
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="Submit" class="btn btn-danger" name='tombol'>Simpan</button>
                                        </div>
										    </form>
                                    </div>
                                </div>
                            </div>
                    </div>
					
					
					
					
					  <div class="col-lg-12">
                        <div class="modal fade" id="newReggg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4">Edit Kategori</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/updatekategori.php" method="post"  enctype="multipart/form-data" name="postform2">
                                 
   <div class="form-group">
                                         
                                            <input class="form-control" type="text" name="idkategori" id="idkategori" readonly>
                                    
                                        </div>
											
<div class="form-group">
                                           
                                            <input placeholder="Kategori" class="form-control" type="text" name="kategori" id="kategori"  >
                                    
                                        </div>	     

                                       
                                
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="Submit" class="btn btn-danger" name='tombol'>Simpan</button>
                                        </div>
										    </form>
                                    </div>
                                </div>
                            </div>
                    </div>
					
					
					