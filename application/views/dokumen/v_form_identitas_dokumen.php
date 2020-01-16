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
                <small><i class="fas fa-file-pdf fa-fw fa-sm"></i>  Dokumen <span class="fas fa-chevron-right fa-fw mx-1"></span> Identitas Dokumen</small>
                <h4 class="text-dark mt-5"> Form Identitas Dokumen Baru</h4>
                    <small>Silahkan lengkapi form dibawah untuk memberi identitas dokumen</small> 
                        <form action="<?php echo base_url('c_dokumen/action_form_identitasDokumen') ?>" method="post" enctype="multipart/form-data">
                            <?php foreach ($data as $baris) : ?>
                                <div class="row mt-5 mb-3">
                                    <div class="col-md mx-2">
                                        <div class="form-group row pt-2">
                                            <input type="hidden" name="id_upload_dokumen" value="<?php echo $baris->id_upload_dokumen;?>">
                                            <div class="col-md-4 p-2">
                                                <label for="dokumen_induk"> Dokumen Induk</label>
                                            </div>
                                            <div class="col-md-8">
                                            <select class="form-control" name="dokumen_induk" id="dokumen_induk">
                                                <option value=" " selected> ~ Pilih Dokumen Induk</option>
                                                <?php 
                                                    foreach ($dok_induk as $a): ?>
                                                    <option value="<?php echo $a->id_dokumen_induk ?>"><?php echo $a->dokumen;  ?></option>
                                                    <?php endforeach; ?>
                                            </select>
                                            <?php echo form_error('dokumen_induk','<small class="text-danger">','</small>') ?>
                                            </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group row pt-2">
                                        <div class="col-md-4 pt-2">
                                            <label for="jenis_dokumen"> Jenis Dokumen</label>
                                            </div>
                                        <div class="col-md-8">
                                            <select class="form-control" name="jenis_dokumen" id="jenis_dokumen">
                                                <option value=" " selected> Jenis Dokumen</option>
                                            </select>
                                            <?php echo form_error('jenis_dokumen','<small class="text-danger">','</small>') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row mt-3">
                                <div class="col-md p-3">
                                    <div class="form-group pt-2 row">
                                            <div class="col-md-4">
                                                <label for="penyusun"> Penyusun</label>
                                            </div>
                                            <div class="col-md-8">
                                               <input type="text" class="form-control" name="penyusun" id="penyusun" value="<?php echo getName('admin', 'id_admin', $baris->penyusun, 'nama') ?>" readonly >
                                            </div>
                                        </div>

                                        <div class="form-group pt-2 row">
                                            <div class="col-md-4">
                                                <label for="hak_akses"> Jabatan</label>
                                            </div>
                                            <div class="col-md-8">
                                               <input type="text" class="form-control" name="hak_akses" id="hak_akses" value="<?php echo hak_akses($baris->penyusun) ?>" readonly >
                                            </div>
                                        </div>
                                        
                                        <div class="form-group pt-2 row">
                                            <div class="col-md-4">
                                                <label for="nama_dokumen"> Nama Dokumen</label>
                                            </div>
                                            <div class="col-md-8">
                                               <input type="text" class="form-control" name="nama_dokumen" id="nama_dokumen" value="<?php echo $baris->nama_dokumen; ?>" readonly>
                                               <?php echo form_error('nama_dokumen','<small class="text-danger">','</small>') ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group pt-2 row">
                                            <div class="col-md-4">
                                                <label for="no_dokumen"> Nomor Dokumen</label>
                                            </div>
                                            <div class="col-md-8">
                                               <input type="text" class="form-control" name="no_dokumen" id="no_dokumen"  value="<?php echo set_value('no_dokumen') ?>" Placeholder="Masukkan nomor dokumen">
                                               <?php echo form_error('no_dokumen','<small class="text-danger">','</small>') ?>
                                            </div>
                                        </div>  

                                        <div class="form-group pt-2 row">
                                            <div class="col-md-4">
                                                <label for="lokasi"> Lokasi</label>
                                            </div>
                                            <div class="col-md-8">
                                               <input type="text" class="form-control" name="lokasi" id="lokasi" value="<?php echo set_value('lokasi') ?>"  Placeholder="Masukkan lokasi dokumen">
                                               <?php echo form_error('lokasi','<small class="text-danger">','</small>') ?>
                                            </div>
                                        </div>


                                        <div class="form-group pt-2 row">
                                            <div class="col-md-4">
                                                <label for="jml_hlm"> Jumlah Halaman</label>
                                            </div>
                                            <div class="col-md-8">
                                               <input type="text" class="form-control" name="jml_hlm" id="jml_hlm" value="<?php echo set_value('jml_hlm') ?>"  Placeholder="Masukkan jumlah halaman">
                                               <?php echo form_error('jml_hlm','<small class="text-danger">','</small>') ?>
                                            </div>
                                        </div>

                                        <div class="form-group pt-2 row">
                                            <div class="col-md-4">
                                                <label for="bidang"> Bidang</label>
                                            </div>
                                            <div class="col-md-8">
                                               <input type="text" class="form-control" name="bidang" id="bidang" value="<?php if ($baris->bidang == 'M') {echo "Mikrobiologi";}else if ($baris->bidang == 'F'){echo "Farmakologi";} else if ($baris->bidang == 'K'){echo "Kimia";}else{echo "-";} ?>" readonly> 
                                            </div>
                                        </div>
                                </div>
                                <div class="col-md p-3">
                                        <div class="form-group row pt-2">
                                            <div class="col-md-4">
                                                <label for="pemeriksa"> Pemeriksa</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-control" name="pemeriksa" id="pemeriksa"  onchange="isi_otomatis2()">
                                                <option value="" selected> ~ Pilih Pemeriksa</option>
                                                        
                                                </select>
                                               
                                            </div>
                                        </div>
                                        <div class="form-group row pt-2">
                                            <div class="col-md-4">
                                                <label for="jan"> Jabatan Pemeriksa</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" id="jan" class="form-control" readonly>                
                                            </div>
                                        </div>

                                        <div class="form-group row pt-2">
                                            <div class="col-md-4">
                                                <label for="pengesah"> Pengesah</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-control" name="pengesah" id="pengesah"  onchange="isi_otomatis3()">
                                                <option value="" selected> ~ Pilih Pengesah </option>
                                                            
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row pt-2">
                                            <div class="col-md-4">
                                                <label for="jun"> Jabatan Pengesah</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" id="jun" class="form-control" readonly>                
                                            </div>
                                        </div>

                                        <div class="form-group row pt-2">
                                            <div class="col-md-4">
                                                <label for="dokumen">Lampirkan File</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="file" class="form-control" name="dokumen" id="dokumen">
                                                <?php echo form_error('dokumen','<small class="text-danger">','</small>') ?>
                                                <?php 
                                                    $hak_akses = $this->session->userdata('hak_akses');
                                                    if ($hak_akses == 2) {
                                                ?>
                                                <span class="text-dark mt-2">Format file berekstensi .pdf</span>
                                                    <?php } else{ ?>
                                                <span class="text-dark mt-2">Format file berekstensi .docx</span>
                                                    <?php } ?>
                                            </div>
                                        </div>
                                </div>
                             </div>
                                <div class="row mt-5">
                                    <div class="col-md">
                                        <a href="<?php echo base_url("c_dokumen/list_identitas_dokumen") ?>" class="btn btn-primary btn-sm"><i class="fas fa-angle-double-left"></i> Kembali</a>
                                        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-upload"></i> Upload</button>
                                    </div>
                                </div>
                                <?php endforeach; ?>
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
    $("#loading").hide();       
    $("#jenis_dokumen").change(function(){ // Ketika user mengganti atau memilih data provinsi     
     $("#pemeriksa").hide(); // Sembunyikan dulu combobox kota nya      
     $("#loading").show(); // Tampilkan loadingnya         
         $.ajax({        
             type: "POST", // Method pengiriman data bisa dengan GET atau POST        
             url: "<?php echo base_url("c_dokumen/list_pemeriksa"); ?>", // Isi dengan url/path file php yang dituju        
             data: {jenis_dokumen : $("#jenis_dokumen").val()}, // data yang akan dikirim ke file yang dituju        
             dataType: "json",        beforeSend: function(e) {          
                 if(e && e.overrideMimeType) {           
                      e.overrideMimeType("application/json;charset=UTF-8");         
                       }      },        
                       success: function(response){ // Ketika proses pengiriman berhasil          
                       $("#loading").hide(); 
                       // Sembunyikan loadingnya         
                        // set isi dari combobox kota          
                        // lalu munculkan kembali combobox kotanya         
                         $("#pemeriksa").html(response.list_pemeriksa).show();        },       
                          error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error          
                          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error       
                           }      
                           });    
                           });  
                        });

$(document).ready(function(){ 
    // Ketika halaman sudah siap (sudah selesai di load)
    // Kita sembunyikan dulu untuk loadingnya    
    $("#loading").hide();       
    $("#jenis_dokumen").change(function(){ // Ketika user mengganti atau memilih data provinsi     
     $("#pengesah").hide(); // Sembunyikan dulu combobox kota nya      
     $("#loading").show(); // Tampilkan loadingnya         
         $.ajax({        
             type: "POST", // Method pengiriman data bisa dengan GET atau POST        
             url: "<?php echo base_url("c_dokumen/list_pengesah"); ?>", // Isi dengan url/path file php yang dituju        
             data: {jenis_dokumen : $("#jenis_dokumen").val()}, // data yang akan dikirim ke file yang dituju        
             dataType: "json",        beforeSend: function(e) {          
                 if(e && e.overrideMimeType) {           
                      e.overrideMimeType("application/json;charset=UTF-8");         
                       }      },        
                       success: function(response){ // Ketika proses pengiriman berhasil          
                       $("#loading").hide(); 
                       // Sembunyikan loadingnya         
                        // set isi dari combobox kota          
                        // lalu munculkan kembali combobox kotanya         
                         $("#pengesah").html(response.list_pengesah).show();        },       
                          error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error          
                          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error       
                           }      
                           });    
                           });  
                        });

    function isi_otomatis2(){
        var user = $("#pemeriksa").val();
        $.ajax({
            url: "<?php echo base_url('c_dokumen/ajax_user')?>",
            data:"user="+user ,
            method:"POST"
        }).done(function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#hak_akses2').val(obj.hak_akses);
            $('#jan').val(obj.jabatan);
        });
    }

    function isi_otomatis3(){
        var user = $("#pengesah").val();
        $.ajax({
            url: "<?php echo base_url('c_dokumen/ajax_user')?>",
            data:"user="+user ,
            method:"POST"
        }).done(function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#hak_akses3').val(obj.hak_akses);
            $('#jun').val(obj.jabatan);
        });
    }


    var doi = document.getElementById("hak_akses2").value;
    document.getElementById("jan").innerHTML;
                             
</script>


