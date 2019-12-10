<hr class="container-fluid">
    <div class="row">
    <?php
	        if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
				echo '<div class="pesan">'.$_SESSION['pesan'].'</div>';
				}
				 
		// mengatur session pesan menjadi kosong
		$_SESSION['pesan'] = '';
		?>
        <div class="col-md-10 offset-1">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Permintaan Pengujian Sampel</h6>
                    </div>
                        <div class="card-body">
                            <form action="<?php echo base_url('c_user/insert_sampel') ?>" method="post">
                                <h4> Pengirim Sampel </h4>
                                <div class="row my-4">
                                    <div class="col-md">
                                        <div class="input-group mb-3 input-group-sm">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-user"></i></div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" name="nama" readonly value="<?php echo $this->session->userdata['name']; ?>">
                                        </div>

                                        <div class="input-group mb-3 input-group-sm">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-building"></i></div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" name="instansi" placeholder="Instansi">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md">
                                         <div class="input-group mb-3 input-group-sm">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-map-marker"></i></div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" name="alamat" placeholder="Alamat">
                                        </div>

                                        <div class="input-group mb-3 input-group-sm">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fas fa-phone"></i></div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" name="no_telp" placeholder="No Telp / Fax">
                                        </div>
                                    </div>
                                </div>
                                <hr class="divider">
                                <h4>Identitas Sampel</h4>
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                                <button type="button" id="add" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Baris</button>
                                        </div>
                                    </div>
                                </div>
                        
                                <div class="row">
                                    <div class="col-md">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm" name="nama_sampel[]" placeholder="Nama Sampel">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm" name="pemerian[]" placeholder="Pemerian">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm" name="kode_batch[]" placeholder="Nomor / Kode Batch">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm" name="jumlah[]" placeholder="Jumlah">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm" name="kemasan[]" placeholder="Kemasan">
                                        </div>
                                    </div>
                                    <div class="col-md">
                                            <div class="form-group">	
                                             <select class="custom-select custom-select-sm" name="id_pengujian[]">
                                                <option value="" selected>-- Pilih Pengujian 1--</option>
                                                    <?php 
                                                    foreach($detail_pengujian as $baris){
                                                     ?>
                                                 <option value="<?php echo $baris->id_detail_pengujian; ?>"><?php echo $baris->detail; ?></option>	
                                                                
                                                    <?php } ?>
												 </select>
                                            </div>
                        
                                            <div class="form-group">	
                                             <select class="custom-select custom-select-sm" name="id_pengujian[]">
                                                <option value="" selected>-- Pilih Pengujian 2--</option>
                                                    <?php 
                                                    foreach($detail_pengujian as $baris){
                                                     ?>
                                                 <option value="<?php echo $baris->id_detail_pengujian; ?>"><?php echo $baris->detail; ?></option>	
                                                                
                                                    <?php } ?>
												 </select>
                                    
                                            </div>
                                            <div class="form-group">	
                                                <select class="custom-select custom-select-sm" name="id_pengujian[]">
                                                <option value="" selected>-- Pilih Pengujian 3  --</option>
                                                    <?php 
                                                    foreach($detail_pengujian as $baris){
                                                     ?>
                                                 <option value="<?php echo $baris->id_detail_pengujian; ?>"><?php echo $baris->detail; ?></option>	
                                                                
                                                    <?php } ?>
												 </select>
                                    
                                            </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm" name="transportasi_sampel[]" placeholder="Transportasi Sampel">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm" name="tempat_penyimpanan[]" placeholder="Tempat Penyimpanan">
                                        </div>
                                    </div>
                                </div>
                                <p id="tampil"></p>
                                <div class="form-group">
                                            <textarea class="form-control" name="hal_lain" rows="4" Placeholder="Hal Lain"></textarea>
                                        </div>
                                <div class="row">
                                    <div class="col-md">
                                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                    </div>
                                </div>
                            </form>     
                        </div>  
                 </div>
            </div>
        </div>

 <script type="text/javascript">
    var max = 3;
    var i = 1;
$(document).ready(function(e){
    $('#add').click(function(e){    
        var jumlah = i + 1;
        if (i <= max){  
          $('#tampil').append(
                    '<div class="row add-row mt-3">'+
                    '<div class="col-md">'+
                    '<div class="row"><div class="col-md">'+
                    '<b> Sampel ke- '+ jumlah+'</b></div></div>'+
                    '<div class="form-group"><input type="text" class="form-control form-control-sm" name="nama_sampel[]" placeholder="Nama Sampel"></div>'+
                    '<div class="form-group"><input type="text" class="form-control form-control-sm" name="pemerian[]" placeholder="Pemerian"></div>'+
                    '<div class="form-group"><input type="text" class="form-control form-control-sm" name="kode_batch[]" placeholder="No / Kode Batch"></div>'+
                    '<div class="form-group"><input type="text" class="form-control form-control-sm" name="jumlah[]" placeholder="Jumlah"></div>'+
                    '<div class="form-group"><input type="text" class="form-control form-control-sm" name="kemasan[]" placeholder="Kemasan"></div>'+
                '</div>'+

               '<div class="col-md mt-4">'+
                    '<div class="form-group">'+
                        '<select class="custom-select custom-select-sm" name="id_pengujian[]">'+
                            '<option value="" selected>-- Pilih Pengujian 1  --</option>'+
                                '<?php foreach($detail_pengujian as $baris){'+
                                '?>'+
                            '<option value="<?php echo $baris->id_detail_pengujian; ?>"><?php echo $baris->detail; ?></option>'+	
                                                                
                              '<?php } ?>'+
						'</select>'+        
                    '</div>'+
                    '<div class="form-group">'+
                        '<select class="custom-select custom-select-sm" name="id_pengujian[]">'+
                            '<option value="" selected>-- Pilih Pengujian 2  --</option>'+
                                '<?php foreach($detail_pengujian as $baris){'+
                                '?>'+
                            '<option value="<?php echo $baris->id_detail_pengujian; ?>"><?php echo $baris->detail; ?></option>'+	
                                                                
                              '<?php } ?>'+
						'</select>'+        
                    '</div>'+
                    '<div class="form-group">'+
                        '<select class="custom-select custom-select-sm" name="id_pengujian[]">'+
                            '<option value="" selected>-- Pilih Pengujian 3  --</option>'+
                                '<?php foreach($detail_pengujian as $baris){'+
                                '?>'+
                            '<option value="<?php echo $baris->id_detail_pengujian; ?>"><?php echo $baris->detail; ?></option>'+	
                                                                
                              '<?php } ?>'+
						'</select>'+        
                    '</div>'+
                    '<div class="form-group"><input type="text" class="form-control form-control-sm" name="transportasi_sampel[]" placeholder="Transportasi Sampel"></div>'+
                    '<div class="form-group"><input type="text" class="form-control form-control-sm" name="tempat_penyimpanan[]" placeholder="Tempat Penyimpanan"></div>'+
                     
                    '<div class="row">'+
                         '<div class="col-md-2">'+
                           '<div class="col-md"><button type="button" class="btn btn-danger btn-sm remove">Hapus</button></div></div>'+
                            '</div>'+
                   '</div>'+
               '</div>'+
         '</tr>');  
          i++;
        }
        else{
            alert('datalebih');
        }
    });
    $('#tampil').on('click','.remove',function(e){
       $(this).parents('.add-row').remove();
       i--;
    })
});

</script>
    