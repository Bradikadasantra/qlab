<div class="container-fluid">
    <div class="row">
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
                        <form action="<?php echo base_url('c_admin/insert_registrasi') ?>"  enctype="multipart/form-data"  method="post">
                            <div class="row mx-2">
                                    <div class="col-md">
                                        <div class="form-group">
                                        <label for="nama">Nama</label>
                                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama">
                                        </div>
            
                                        <div class="form-group">    
                                        <label for="nama">Alamat</label>
                                            <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat">
                                        </div>
                                     
                                        <div class="form-group">
                                        <label for="nama">Telepon</label>
                                            <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="Telepon">
                                        </div>
                                      
                                        <div class="form-group">
                                        <label for="nama">Email</label>
                                            <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                                        </div>
                                    </div>  
                                    <div class="col-md">
                                        <label for="foto">Foto</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="photo">
                                            <label class="custom-file-label">Choose file</label>
                                        </div>
                                     
                                        <div class="form-group mt-3">
                                        <label for="nama">Hak Akses</label>
                                           <select class="form-control" name="hak_akses">
                                              <?php
                                                foreach ($data as $baris):?>
                                              <option value="<?php echo $baris->id_hak_akses; ?>"><?php echo $baris->hak_akses; ?></option>
                                                <?php endforeach; ?>
                                           </select>
                                        </div>

                                        <div class="form-group">
                                        <label for="id_bidang"> Bidang </label>
                                            <select class="form-control" name="id_bidang">
                                                <?php
                                                    $run = $this->db->query("SELECT * FROM bidang")->result(); 
                                                    foreach ($run as $baris):
                                                ?>
                                                <option value="<?php echo $baris->id_bidang;?>"><?php echo $baris->nama_bidang;?></option>
                                                    <?php endforeach;  ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                        <label for="nama">Password</label>
                                            <input type="text" readonly class="form-control" name="password" id="password" value="pancasila">
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