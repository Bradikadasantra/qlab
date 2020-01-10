<div class="container-fluid">
    <div class="row">
    <style>
         .bu{
            color: #fff;
            display:none;
            }
    </style>
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
                <small><i class="fas fa-file-pdf fa-fw fa-sm"></i> Dokumen Induk <span class="fas fa-chevron-right fa-fw mx-1"></span> Tambah dokumen</small>
                <h4 class="text-dark mt-5"> Form Tambah Dokumen</h4>
                    <small>Silahkan lengkapi form dibawah untuk tambah dokumen</small> 
                        <form action="<?php echo base_url('c_dokumen/action_tambah_dokumen')?>" method="post" enctype="multipart/form-data">
                            <div class="row mt-5 mb-3">
                                <div class="col-md mx-2">
                                    <div class="form-group row pt-2">
                                        <div class="col-md-4 p-2">
                                            <label for="dokumen_induk"> Dokumen Induk*</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="custom-select" name="dokumen_induk" id="dokumen_induk">
                                                <option value=" " selected> ~ Pilih Dokumen Induk</option>
                                                <?php 
                                                    foreach ($dokumen_induk as $a): ?>
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
                                            <label for="jenis_dokumen"> Jenis Dokumen* </label>
                                            </div>
                                        <div class="col-md-8">
                                            <select class="custom-select" name="jenis_dokumen" id="jenis_dokumen">
                                                <option value=" " selected> Jenis Dokumen </option>
                                                        
                                            </select>
                                            <?php echo form_error('jenis_dokumen','<small class="text-danger">','</small>') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group pt-2 row">
                                                <div class="col-md-4">
                                                    <label for="no_dokumen"> No Dokumen* </label>
                                                </div>
                                                <div class="col-md-8">
                                                <input type="text" class="form-control" name="no_dokumen" id="no_dokumen" placeholder="Masukkan nomor dokumen" value="<?php echo set_value('no_dokumen') ?>">
                                                <?php echo form_error('no_dokumen','<small class="text-danger">','</small>') ?>
                                                </div>
                                            </div>

                                            <div class="form-group pt-2 row">
                                                <div class="col-md-4">
                                                    <label for="nama_dokumen"> Nama Dokumen* </label>
                                                </div>
                                                <div class="col-md-8">
                                                <input type="text" class="form-control" name="nama_dokumen" id="nama_dokumen" placeholder="Masukkan nama dokumen"  value="<?php echo set_value('nama_dokumen') ?>">
                                                <?php echo form_error('nama_dokumen','<small class="text-danger">','</small>') ?>
                                                </div>
                                            </div>

                                            <div class="form-group pt-2 row">
                                                <div class="col-md-4">
                                                    <label for="lokasi"> Lokasi* </label>
                                                </div>
                                                <div class="col-md-8">
                                                <input type="text" class="form-control" name="lokasi" id="lokasi" placeholder="Masukkan lokasi dokumen"  value="<?php echo set_value('lokasi') ?>">
                                                <?php echo form_error('lokasi','<small class="text-danger">','</small>') ?>
                                                </div>
                                            </div>

                                            <div class="form-group pt-2 row">
                                                <div class="col-md-4">
                                                    <label for="penyusun"> Penyusun*</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <select class="custom-select" name="penyusun" id="penyusun" onchange="isi_otomatis()">
                                                    <option value=" " selected> ~ Penyusun</option>
                                                        <?php foreach ($user as $row): ?>
                                                        <option value="<?php echo $row->id_admin ?>"><?php echo $row->nama; ?></option>
                                                        <?php endforeach;  ?>
                                                    </select>
                                                    <?php echo form_error('penyusun','<small class="text-danger">','</small>') ?>
                                                </div>
                                            </div>

                                            <div class="form-group pt-2 row">
                                                <div class="col-md-4">
                                                    <label for="file"> Lampirkan Dokumen*</label>
                                                </div>
                                                <div class="col-md-8">
                                                <input type="file" class="form-control" name="file" id="file" placeholder="Lampirkan file dokumen">
                                                <small class="mt-3">Format File harus beresktensi .pdf</small>
                                                <p>  <?php echo form_error('file','<small class="text-danger">','</small>') ?></p>
                                                </div>
                                              
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group pt-2 row">
                                                <div class="col-md-4">
                                                    <label for="pemeriksa"> Pemeriksa</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <select class="custom-select" name="pemeriksa" id="pemeriksa" onchange="isi_otomatis2()">
                                                    <option value="" selected> ~ Pemeriksa</option>
                                                        <?php foreach ($user as $row): ?>
                                                        <option value="<?php echo $row->id_admin ?>"><?php echo $row->nama; ?></option>
                                                        <?php endforeach;  ?>
                                                    </select>
                                                  <!--  <?php echo form_error('pemeriksa','<small class="text-danger">','</small>') ?> -->
                                                </div>
                                            </div>

                                            <div class="form-group pt-2 row">
                                                <div class="col-md-4">
                                                    <label for="pengesah"> Pengesah</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <select class="custom-select" name="pengesah" id="pengesah" onchange="isi_otomatis3()">
                                                    <option value="" selected> ~ Pengesah</option>
                                                        <?php foreach ($user as $row): ?>
                                                        <option value="<?php echo $row->id_admin ?>"><?php echo $row->nama; ?></option>
                                                        <?php endforeach;  ?>
                                                       <!-- <?php echo form_error('pengesah','<small class="text-danger">','</small>') ?> -->
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row pt-2">
                                                <div class="col-md-4">
                                                <label for="tgl_disusun"> Tgl disusun*</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar fa-sm"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control datepicker-here" data-position="top left"  data-language="en" name="tgl_disusun" id="tgl_disusun" value="<?php echo set_value('tgl_disusun') ?>">
                                                    </div>
                                                    <?php echo form_error('tgl_disusun','<small class="text-danger">','</small>') ?>
                                                </div>
                                            </div>

                                            <div class="form-group row pt-2">
                                                <div class="col-md-4">
                                                <label for="tgl_disahkan"> Tgl disahkan*</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-calendar fa-sm"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control datepicker-here" data-position="bottom right"  data-language="en" name="tgl_disahkan" id="tgl_disahkan" value="<?php echo set_value('tgl_disahkan') ?>">
                                                    </div>
                                                    <?php echo form_error('tgl_disahkan','<small class="text-danger">','</small>') ?>
                                                </div>
                                            </div>

                                            <div class="form-group row pt-3">
                                                <div class="col-md-6">
                                                <label for="bidang"> Apakah dokumen memiliki bidang ? </label>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="bidang" id="bidang" value="ya">
                                                        <label class="form-check-label" for="bidang">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="bidang" id="bidang" value="tidak">
                                                        <label class="form-check-label" for="bidang">Tidak</label>
                                                    </div> 
                                                    <p><?php echo form_error('bidang','<small class="text-danger">','</small>') ?></p>
                                                </div>
                                            </div>    

                                            <div class="form-group ya bu">
                                                <div class="col-md-8">
                                                    <select class="custom-select" name="id_bidang">
                                                    <option value="" selected> ~ Bidang</option>
                                                    <?php
                                                        $uwew = $this->db->query("SELECT * FROM bidang")->result();
                                                        foreach ($uwew as $row): ?>
                                                        <option value="<?php echo $row->id_bidang ?>"><?php echo $row->nama_bidang ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" name="jabatan_penyusun" id="hak_akses">
                                        <input type="hidden" class="form-control" name="jabatan_pemeriksa" id="hak_akses2">
                                        <input type="hidden" class="form-control"  name="jabatan_pengesah" id="hak_akses3">
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

<script>
    $(document).ready(function(){
        $('input[type="radio"]').click(function(){
            var inputValue = $(this).attr("value");
            var targetBox = $("." + inputValue);
            $(".bu").not(targetBox).hide();
            $(targetBox).show();
        });
    });

$(document).ready(function(){ 
    // Ketika halaman sudah siap (sudah selesai di load)
    // Kita sembunyikan dulu untuk loadingnya    
    $("#loading").hide();       
    $("#dokumen_induk").change(function(){ // Ketika user mengganti atau memilih data provinsi     
     $("#jenis_dokumen").hide(); // Sembunyikan dulu combobox kota nya      
     $("#loading").show(); // Tampilkan loadingnya         
         $.ajax({        
             type: "POST", // Method pengiriman data bisa dengan GET atau POST        
             url: "<?php echo base_url("c_dokumen/list_AlljenisDokumen"); ?>", // Isi dengan url/path file php yang dituju        
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
                        
function isi_otomatis(){
        var user = $("#penyusun").val();
        $.ajax({
            url: "<?php echo base_url('c_dokumen/ajax_user')?>",
            data:"user="+user ,
            method:"POST"
        }).done(function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#hak_akses').val(obj.hak_akses);
        });
    }

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
        });
    }
</script>
</div>

    



