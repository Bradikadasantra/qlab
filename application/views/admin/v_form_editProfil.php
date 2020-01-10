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
                <small><i class="fas fa-id-card fa-fw"></i>  Profil</small> <i class="fas fa-chevron-right fa-sm mx-2"></i> <small> Form Edit Profil</small>
                    <h4 class="text-dark mt-4"> Profil Anda</h4>
                    <?php foreach ($user as $baris): ?>
                    <form action="<?php echo $action;  ?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md">
                            <input type="hidden" value="<?php echo $this->session->userdata('id_auth') ?>" name="id_auth">
                                <div class="form-group">
                                    <label for="nama"> Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama" id="nama" Placeholder="Masukkan nama lengkap" value="<?php echo $baris->nama; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="alamat"> Alamat</label>
                                    <input type="text" class="form-control" name="alamat" id="alamat" Placeholder="Masukkan alamat" value="<?php echo $baris->alamat; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="no_telp"> No Telepon</label>
                                    <input type="text" class="form-control" name="no_telp" id="no_telp" Placeholder="Masukkan no telepon" value="<?php echo $baris->no_telp; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="email"> Email</label>
                                    <input type="text" class="form-control" name="email" id="email" Placeholder="Masukkan email" value="<?php echo $baris->email; ?>">
                                </div>  

                                <?php if ($this->session->userdata('hak_akses') == 12) { ?>
                                <div class="form-group">
                                    <label for="instansi"> Instansi</label>
                                    <input type="text" class="form-control" name="instansi" id="instansi" Placeholder="Masukkan Instansi" value="<?php echo $baris->instansi; ?>">
                                </div>  

                                <div class="form-group">
                                    <label for="alamat_instansi"> Alamat Instansi</label>
                                    <textarea class="form-control" rows="4" name="alamat_instansi" id="alamat_instansi" Placeholder = "Masukkan alamat instansi"><?php echo $baris->alamat_instansi; ?></textarea> 
                                </div>  
                                <?php } ?>

                                <?php if ($this->session->userdata('hak_akses') != 12) { ?>
                                <div class="form-group">
                                    <label for="hak_akses"> Hak akses </label>
                                    <select class="form-control" name="hak_akses" id="hak_akses" disabled>
                                        <?php 
                                            $kueri = $this->db->query("SELECT * FROM hak_akses")->result();
                                            $hak_ak = $baris->hak_akses; 
                                            foreach ($kueri as $row) : 
                                                if ($hak_ak == $row->id_hak_akses) { ?>
                                            <option value="<?php echo $row->hak_akses;  ?>"selected ><?php echo $row->hak_akses; ?></option>
                                                <?php } else { ?>
                                            <option value="<?php echo $row->hak_akses;  ?>"><?php echo $row->hak_akses; ?></option>
                                            <?php } endforeach;  ?>
                                    </select>
                                </div>
                                <?php } ?>
                                
                            </div>
                            <div class="col-md">
                                <div class="form-group">
								    <label for="foto">Foto</label><br>
									<div class="image"> 
										<?php if($baris->foto == 'Default.jpg' ){
								     ?>
									<img src="<?php echo base_url('assets/img/user1.jpg') ?>" style="height:100px; width:100px; "/>
									<?php
									}else{ ?>
										<img src ="<?php echo base_url('photo/'.$baris->foto) ?>" style="height:100px; width:100px;">
										<?php } ?>
										</div>
										<p style="color:grey;">Maks  2 MB </p>
											<input type="checkbox" name="ubah_photo" value="True"><span style="font-weight:bold; padding-left:10px;">Centang !! Jika anda ingin merubah foto..</span><br><br>
											<input type="file" class="form-control form-control-sm" name="photo" id="photo">
								</div>
                                    <?php if ($this->session->userdata('hak_akses') != 12) { ?>
                                        <?php if ($baris->id_bidang != null) { ?>
                                <div class="form-group">
                                    <label for="bidang"> Bidang</label>
                                    <select class="form-control" name="bidang" id="bidang">
                                        <?php 
                                            $kueri = $this->db->query("SELECT * FROM bidang")->result();
                                            $bid = $baris->id_bidang; 
                                            foreach ($kueri as $row) : 
                                                if ($bid == $row->id_bidang) { ?>
                                            <option value="<?php echo $row->id_bidang;  ?>"selected ><?php echo $row->nama_bidang; ?></option>
                                                <?php } else { ?>
                                            <option value="<?php echo $row->id_bidang;  ?>"><?php echo $row->nama_bidang; ?></option>
                                            <?php } endforeach;  ?>
                                    </select>
                                </div>
                                <?php } } ?>

                                <div class="form-group">
                                    <label for="aktif"> Status</label>
                                        <input type="text" class="form-control" name="aktif" id="aktif"  value="<?php echo aktif($baris->aktif);  ?>" readonly>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo base_url('c_dashboard')?>" class="btn btn-primary btn-sm mt-5"><i class="fas fa-angle-double-left fa-fw"></i> Kembali</a>
                        <button type="submit" class="btn btn-success btn-sm mt-5"><i class="fas fa-save fa-fw"></i> Simpan</button>
                    </form>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>