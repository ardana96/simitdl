<div class="inner">
    <div class="row">
        <div class="col-lg-12">

            <h2>Data Perawatan</h2>

        </div>  
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="panel panel-danger">
                        <div class="panel-body">
                            <form method="GET" action="index.php">
                                <div class="form-group" >
                                    <b> Nama Bulan</b>        
                                    <select class="form-control" name='bulan' required='required'>	 
                                    <option> </option>
                                            
                                            <?	$ss = mysql_query("SELECT * FROM bulan  ");
                                                if(mysql_num_rows($ss) > 0){
                                            while($datass = mysql_fetch_array($ss)){
                                                $id_bulan=$datass['id_bulan'];
                                                $bulan=$datass['bulan'];
                                                ?>
                                            <option value="<? echo $id_bulan; ?>"> <? echo $bulan; ?>
                                            </option>
                                            
                                            <?}}?>
                                            
                                    
                                    </select> 
                                </div>	

                                <div class="form-group" >
                                    <b> Tahun</b>        
                                    <select class="form-control" name="tahun" size="1" id="tahun">
                                        <?php
                                        for ($i = date('Y'); $i >= 2022; $i--) {
                                        if($i<10){ $i="0".$i; }
                                        echo"<option value=".$i.">".$i."</option>";}
                                        ?>    
                                    </select>
                                </div>
                                <div class="form-group">
                                    <b> Divisi</b>        
                                    <select class="form-control" name='namadivisi' required='required'>	 
                                    <option> </option>
                                            
                                            <?	$ss = mysql_query("SELECT * FROM divisi  ");
                                                if(mysql_num_rows($ss) > 0){
                                            while($datass = mysql_fetch_array($ss)){
                                                $namadivisi=$datass['namadivisi'];
                                                ?>
                                            <option value="<? echo $namadivisi; ?>"> <? echo $namadivisi; ?>
                                            </option>
                                            
                                            <?}}?>
                                            
                                    
                                    </select> 
                                        
                                    
                                </div>
                                <div class="form-group">
                                    <b> Perangkat Yang Dirawat</b>        
                                    <select class="form-control" name='perangkat' required='required'>	 
                                    <option> </option>
                                            
                                            <?	$ss = mysql_query("SELECT * FROM tipe_perawatan  ");
                                                if(mysql_num_rows($ss) > 0){
                                            while($datass = mysql_fetch_array($ss)){
                                                $id = $datass['id'];
                                                $nama_perangkat=$datass['nama_perangkat'];
                                                ?>
                                            <option value="<? echo $id; ?>"> <? echo $nama_perangkat; ?>
                                            </option>
                                            
                                            <?}}?>
                                            
                                    
                                    </select> 
                                        
                                    
                                </div>
                                <button type="submit" class="btn btn-primary">Cari</button>	
                            </form>
                        </div>
                    </div>
                </div>
            </div>    
            <!-- <form method="GET" action="index.php">
                <label for="customer_name">Nama Pelanggan:</label>
                <input type="text" name="customer_name" id="customer_name" placeholder="Nama Pelanggan">
                <br>

                <label for="start_date">Dari Tanggal:</label>
                <input type="date" name="start_date" id="start_date">
                <br>

                <label for="end_date">Sampai Tanggal:</label>
                <input type="date" name="end_date" id="end_date">
                <br>

                <button type="submit" class="btn btn-primary">Cari</button>
            </form> -->

            <br>
            <div class="panel-body">
                <div class="table-responsive" style='overflow: scroll;'>
            <!-- Tabel Laporan -->
                        <table class="table table-bordered table-hover" id="data">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Lokasi</th>
                                    <th>Aksi</th>
                                    <th>Perangkat</th>
                                </tr>
                            </thead>
                            <tbody id="tableData">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>

 

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Item Yang Di Cek</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- <p><strong>Perangkat yang Dipilih:</strong> <span id="modalPerangkatValue"></span></p> -->
                    <!-- Div untuk menampilkan hasil query dari get_perawatan_items.php -->
                    <input type="text" class="form-control" name="perangkatId" id="perangkatId" disabled>
                    <input type="text" class="form-control" name="tahunModal" id="tahunModal" disabled>
                    <div class="form-group">
                        <label for="editOrderDate">ID</label>
                        <input type="text" class="form-control" name="idpc" id="idpc" disabled>
                    </div>
                    <div class="form-group">
                        <label for="editOrderDate">User</label>
                        <input type="text" class="form-control" name="user" id="user" disabled>
                    </div>
                    <div class="form-group">
                        <label for="editOrderDate">Lokasi</label>
                        <input type="text" class="form-control" name="lokasi" id="lokasi" disabled>
                    </div>
                    <div class="form-group">
                        <label for="editOrderDate">Jenis Perawatan</label>
                    </div>
                    <div id="modalCheckboxes"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpanPerawatan()">Submit</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal untuk Edit
    <div class="col-lg-12">
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Item Yang Di Cek</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <form id="editForm" method="POST" action="edit_order.php">

                            <?php
            // Koneksi ke database
                                        $conn = mysql_connect("localhost", "root", "dlris30g");
                                        mysql_select_db("sitdl", $conn);

                                        // Ambil semua data dari tabel master
                                        $master_query = mysql_query("SELECT * FROM tipe_perawatan_item where tipe_perawatan_id = 15", $conn);
                                        $master_data = array();
                                        while ($row = mysql_fetch_assoc($master_query)) {
                                            $master_data[] = $row;
                                        }

                                        // Ambil data terpilih berdasarkan user_id (misalnya user_id = 1)
                                        // $user_id = 1; // Ganti dengan ID pengguna yang sesuai
                                        // $selected_query = mysql_query("SELECT master_id FROM user_selected WHERE user_id = $user_id", $conn);
                                        $selected_data = array();
                                        // while ($row = mysql_fetch_assoc($selected_query)) {
                                        //     $selected_data[] = $row['master_id'];
                                        // }
                                        ?>

                                        <?php foreach ($master_data as $item): ?>
                                                <div class="form-group">
                                                    <label>
                                                        <input type="checkbox" name="selected_items[]" value="<?php echo $item['id']; ?>" 
                                                            <?php echo in_array($item['id'], $selected_data) ? 'checked' : ''; ?>>
                                                        <?php echo $item['nama_perawatan']; ?>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                     
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div> -->

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        // Fungsi untuk menampilkan data di modal Detail

        function loadData() {
            // Dapatkan nilai dari input pencarian
            const bulan = document.querySelector("[name='bulan']").value;
            const tahun = document.querySelector("[name='tahun']").value;
            const namadivisi = document.querySelector("[name='namadivisi']").value;
            const perangkat = document.querySelector("[name='perangkat']").value;

            // AJAX untuk memuat data dari search_orders.php
            $.ajax({
                url: 'aplikasi/perawatan_app/cariperawatan.php',
                type: 'GET',
                data: {
                    bulan: bulan,
                    tahun: tahun,
                    namadivisi: namadivisi,
                    perangkat: perangkat
                },
                success: function(response) {
                    $('#tableData').html(response); // Menampilkan data di tabel
                },
                error: function() {
                    alert('Gagal memuat data.');
                }
            });
        }

        // Memanggil loadData saat halaman dimuat
        $(document).ready(function() {
            loadData();

            // Memanggil loadData saat tombol Cari diklik
            $('form').on('submit', function(e) {
                e.preventDefault(); // Mencegah reload halaman
                loadData();
            });
        });

        function showDetails(data) {
            document.getElementById("modalOrderId").textContent = data.id;
            document.getElementById("modalOrderDate").textContent = data.order_date;
            document.getElementById("modalCustomerName").textContent = data.customer_name;
            document.getElementById("modalProductName").textContent = data.product_name;
            document.getElementById("modalQuantity").textContent = data.quantity;
            document.getElementById("modalTotalPrice").textContent = data.total_price;
            $('#detailModal').modal('show');
        }

        // Fungsi untuk menampilkan data di modal Edit
        // function showEdit(data) {
        //     // document.getElementById("editOrderId").value = data.id;
        //     // document.getElementById("editOrderDate").value = data.order_date;
        //     // document.getElementById("editCustomerName").value = data.customer_name;
        //     // document.getElementById("editProductName").value = data.product_name;
        //     // document.getElementById("editQuantity").value = data.quantity;
        //     // document.getElementById("editTotalPrice").value = data.total_price;
        //     $('#editModal').modal('show');
        // }

        function showEdit(data) {
            // Ambil nilai dari elemen perangkat
            const perangkatValue = document.querySelector("[name='perangkat']").value;
            const tahunValue = document.querySelector("[name='tahun']").value;
           // document.getElementById("idpc").textContent = data.idpc;
            document.getElementById("idpc").value = data.idpc;
            document.getElementById("user").value = data.user;
            document.getElementById("lokasi").value = data.lokasi;
            document.getElementById("perangkatId").value = perangkatValue;
            document.getElementById("tahunModal").value = tahunValue;
            console.log(data.idpc);
            // AJAX untuk mengirim perangkatValue ke server dan mendapatkan data
            $.ajax({
                url: 'aplikasi/perawatan_app/get_perawatan_items.php', // File PHP yang akan memproses query
                type: 'GET',
                data: { 
                    idpc: data.idpc,
                    perangkat_id: perangkatValue,
                    tahun : tahunValue },
                success: function(response) {
                    // Menampilkan data yang dikembalikan dalam modal
                    $('#modalCheckboxes').html(response);
                    $('#modalPerangkatValue').text(perangkatValue); // Menampilkan perangkat di modal
                    $('#editModal').modal('show'); // Tampilkan modal
                },
                error: function() {
                    alert('Gagal memuat data.');
                }
            });
        }

        function simpanPerawatan() {
            // Ambil semua checkbox yang dicentang
                const selectedItems = Array.from(document.querySelectorAll("input[name='selected_items[]']:checked")).map(cb => cb.value);
                const unselectedItems = Array.from(document.querySelectorAll("input[name='selected_items[]']:not(:checked)")).map(cb => cb.value);
                
                // Ambil data dari input lainnya
                const idpc = document.getElementById("idpc").value;
                const user = document.getElementById("user").value;
                const lokasi = document.getElementById("lokasi").value;
                const tipe_perawatan_id = document.getElementById("perangkatId").value;
                const tahun = document.getElementById("tahun").value;
                console.log(selectedItems);
                console.log(unselectedItems);
                // Kirim data menggunakan AJAX
               // if (selectedItems.length > 0) {
                    $.ajax({
                        url: 'aplikasi/perawatan_app/simpan_perawatan.php', // Sesuaikan dengan URL untuk menyimpan data
                        type: 'POST',
                        data: {
                            idpc: idpc,
                            user: user,
                            lokasi: lokasi,
                            tipe_perawatan_id :tipe_perawatan_id,
                            tahun:tahun,
                            selected_items: selectedItems,
                            unselected_items : unselectedItems
                        },
                        success: function(response) {
                            console.log(response);
                            //alert('Data berhasil disimpan!');
                            $('#editModal').modal('hide');// Tutup modal setelah menyimpan
                            loadData() ; 
                        },
                        error: function() {
                            alert('Gagal menyimpan data.');
                        }
                    });
                // } else {
                //     alert("Pilih minimal satu jenis perawatan.");
                // }
        }

    </script>
</div>