<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        <?php
		if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
			echo '<div class="pesan">'.$_SESSION['pesan'].'</div>';
        }
				// mengatur session pesan menjadi kosong
				$_SESSION['pesan'] = '';
	?>
            <div class="card">
                <div class="card-body">
                <small><i class="fas fa-file-pdf fa-fw fa-sm"></i>  Dokumen <span class="fas fa-chevron-right fa-fw mx-1"></span> Upload Dokumen</small>
                <h4 class="text-dark mt-5"> Form Upload Dokumen Baru</h4>
                    <small>Silahkan lengkapi form dibawah untuk upoad dokumen baru</small> 
                        <form action="<?php echo base_url('c_dokumen/action_tmp_uploadDokumen') ?>" method="post" enctype="multipart/form-data">
                            <div class="row mt-3">
                                    <div class="col-md p-3">
                                        <div class="form-group pt-2 row">
                                            <div class="col-md-2">
                                                <label for="penyusun"> Penyusun</label>
                                            </div>
                                            <div class="col-md-5">
                                               <input type="text" class="form-control" name="penyusun" id="penyusun" value="<?php echo $data->nama ?>" readonly >
                                            </div>
                                        </div>

                                        <div class="form-group pt-2 row">
                                            <div class="col-md-2">
                                                <label for="hak_akses"> Jabatan</label>
                                            </div>
                                            <div class="col-md-5">
                                               <input type="text" class="form-control" name="hak_akses" id="hak_akses" value="<?php echo hak_akses($data->id_admin) ?>" readonly >
                                            </div>
                                        </div>

                                   
                                        <div class="form-group pt-2 row">
                                            <div class="col-md-2">
                                                <label for="nama_dokumen"> Nama Dokumen</label>
                                            </div>
                                            <div class="col-md-5">
                                               <input type="text" class="form-control" name="nama_dokumen" id="nama_dokumen" value="<?php echo set_value('nama_dokumen') ?>"  Placeholder="Masukkan nama dokumen">
                                               <?php echo form_error('nama_dokumen','<small class="text-danger">','</small>') ?>
                                            </div>
                                        </div>

                            
                                        <div class="form-group row pt-2">
                                            <div class="col-md-2">
                                                <label for="dokumen">Lampirkan File</label>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="file" class="form-control" name="dokumen" id="dokumen">
                                                <?php echo form_error('dokumen','<small class="text-danger">','</small>') ?>
                                                <span class="text-dark mt-2">Format file berekstensi .docx</span>   
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md">
                                        <a href="<?php echo base_url("c_dokumen") ?>" class="btn btn-primary btn-sm"><i class="fas fa-angle-double-left"></i> Kembali</a>
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-upload"></i> Upload</button>
                                    </div>
                                </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>  
$(document).ready(function(){ 
    // Ketika halaman sudah siap (sudah selesai di load)
    // Kita sembunyikan dulu untuk loadingnya    
    $("#loading").hide();       
    $("#dokumen_induk").change(function(){ // Ketika user mengganti atau memilih data provinsi     
     $("#jenis_dokumen").hide(); // Sembunyikan dulu combobox kota nya      
     $("#loading").show(); // Tampilkan loadingnya         
         $.ajax({        
             type: "POST", // Method pengiriman data bisa dengan GET atau POST        
             url: "<?php echo base_url("c_dokumen/list_jenisDokumen"); ?>", // Isi dengan url/path file php yang dituju        
             data: {dokumen_induk : $("#dokumen_induk").val()}, // data yang akan dikirim ke file yang dituju        
             dataType: "json",        beforeSend: function(e) {          
                 if(e && e.overrideMimeType) {           
                      e.overrideMimeType("application/json;charset=UTF-8");         
                       }      },        
                       success: function(response){ // Ketika proses pengiriman berhasil          
                       $("#loading").hide(); 
                       // Sembunyikan loadingnya         
                        // set isi dari combobox kota          
                        // lalu munculkan kembali combobox kotanya         
                         $("#jenis_dokumen").html(response.list_jenis_dokumen).show();        },       
                          error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error          
                          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error       
                           }      
                           });    
                           });  
                        }); 

                        $(document).ready(function(){ 
    // Ketika halaman sudah siap (sudah selesai di load)
    // Kita sembunyikan dulu untuk loadingnya   
</script>



