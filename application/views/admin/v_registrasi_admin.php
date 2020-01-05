<div class="container-fluid">
    <div class="row">
    <style>
         .bu{
            color: #fff;
            display:none;
            }
    </style>
    <?php
		if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
			echo '<div class="pesan">'.$_SESSION['pesan'].'</div>';
        }
				// mengatur session pesan menjadi kosong
				$_SESSION['pesan'] = '';
	?>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <small class="text-dark"><i class="fas fa-user fa-fw fa-sm"></i>  User <span class="fas fa-chevron-right fa-fw mx-1"></span> Tambah Admin</small>
                <hr class="divider">
                    <h5 class="mt-4 mb-4 mx-3"> Tambah Data Admin</h5>  
                        <form action="<?php echo base_url('c_admin/insert_registrasi') ?>" enctype="multipart/form-data"  method="post">
                            <div class="row mx-2">
                                    <div class="col-md">
                                        <div class="form-group">
                                        <label for="nama">Nama</label>
                                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama" value="<?php echo set_value('nama') ?>">
                                            <?php echo form_error('nama','<small class="text-danger">','</small>') ?>
                                        </div>
            
                                        <div class="form-group">    
                                        <label for="alamat">Alamat</label>
                                            <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo set_value('alamat') ?>">
                                            <?php echo form_error('alamat','<small class="text-danger">','</small>') ?>
                                        </div>
                                     
                                        <div class="form-group">
                                        <label for="no_telp">Telepon</label>
                                            <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="Telepon" value="<?php echo set_value('no_telp') ?>">
                                            <?php echo form_error('no_telp','<small class="text-danger">','</small>') ?>
                                        </div>
                                      
                                        <div class="form-group">
                                        <label for="email">Email</label>
                                            <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo set_value('email') ?>">
                                            <?php echo form_error('email','<small class="text-danger">','</small>') ?>
                                        </div>
                                    </div>  
                                    <div class="col-md">
                                        <label for="photo">Foto</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="photo">
                                            <label class="custom-file-label">Choose file</label>
                                            <?php echo form_error('photo','<small class="text-danger">','</small>') ?>
                                        </div>
                                     
                                        <div class="form-group mt-3">
                                        <label for="hak_akses">Hak Akses</label>
                                           <select class="form-control" name="hak_akses">
                                           <option value="" selected> ~ Pilih Hak Akses</option>
                                              <?php
                                                foreach ($data as $baris):?>
                                              <option value="<?php echo $baris->id_hak_akses; ?>"><?php echo $baris->hak_akses; ?></option>
                                                <?php endforeach; ?>
                                           </select>
                                           <?php echo form_error('hak_akses','<small class="text-danger">','</small>') ?>
                                        </div>

                                        <div class="form-group">
                                        <label for="nama">Password</label>
                                            <input type="text" readonly class="form-control" name="password" id="password" value="pancasila">
                                        </div>

                                        <div class="form-group row pt-4">
                                                <div class="col-md-6">
                                                <label for="bidang">  Apakah user memiliki bidang ? </label>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="bidang" id="inlineRadio1" value="ya">
                                                        <label class="form-check-label" for="inlineRadio1">Ya</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="bidang" id="inlineRadio2" value="tidak">
                                                        <label class="form-check-label" for="inlineRadio2">Tidak</label>
                                                    </div> 
                                                </div>
                                                <?php echo form_error('bidang','<small class="text-danger pl-4">','</small>') ?>
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
                                </div>
                                <div class="row my-3">
                                    <div class="col-md">
                                        <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-save fa-sm"></i> Simpan </button>
                                    </div>
                                </div>
                        </form>
                        <a href="<?php echo base_url('c_admin/daftar_admin') ?>" class="btn btn-primary btn-sm mt-5"><i class="fas fa-arrow-circle-left"></i> Kembali</a>
                </div>
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
</script>