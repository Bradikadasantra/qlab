<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo base_url('c_admin/update_admin'); ?>" method="post" enctype='multipart/form-data'>
                <?php foreach ($admin as $baris): ?>
                <div class="row">
                    <div class="col-md">
                        <input type="hidden" name="id_admin" value="<?php echo $baris['id_admin']; ?>">
                        <input type="hidden" name="id_auth" value="<?php echo $baris['id_auth']; ?>">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $baris['nama']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" name="alamat" id="alamat" value="<?php echo $baris['alamat']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="no_telp">Telepon</label>
                            <input type="text" class="form-control" name="no_telp" id="no_telp" value="<?php echo $baris['no_telp']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="no_telp">Hak Akses</label>
                                <select class="form-control" name="hak_akses">
                                <?php 
										 if($baris['hak_akses'] == 'Super Admin'){
                                            echo "<option value =\"Super Admin\" selected >Super Admin</option>";
                                                }
                                            else{
                                                echo "<option value=\"Super Admin\">Super Admin</option>";
                                                }
                                        if($baris['hak_akses'] == 'manajer_puncak'){
                                            echo "<option value =\"manajer_puncak\" selected >Manajer Puncak</option>";
                                                }
                                            else{
                                                echo "<option value=\"manajer_puncak\">Manajer Puncak</option>";
                                                }
                                        if($baris['hak_akses'] == 'ka_laboratorium'){
                                            echo "<option value =\"ka_laboratorium\" selected >Ka Laboratorium</option>";
                                                }
                                            else{
                                                echo"<option value=\"ka_laboratoirum\">Ka Laboratorium</option>";	
                                            }
                                        if($baris['hak_akses'] == 'manajer_mutu'){
                                                echo "<option value =\"manajer_mutu\" selected >Manajer Mutu</option>";
                                                }
                                            else{
                                                echo"<option value=\"manajer_mutu\">Manajer Mutu</option>";
                                            }
                                        if($baris['hak_akses'] == 'manajer_operasional'){
                                                echo "<option value =\"manajer_operasional\" selected >Manajer Operasional</option>";
                                                }
                                            else{
                                                echo"<option value=\"manajer_operasional\">Manajer Operasional</option>";
                                            }
                                        if($baris['hak_akses'] == 'manajer_teknik'){
                                                echo "<option value =\"manajer_teknik\" selected >Manajer Teknik</option>";
                                                }
                                            else{
                                                echo"<option value=\"manajer_teknik\">Manajer Teknik</option>";
                                            }
                                        if($baris['hak_akses'] == 'analis'){
                                                echo "<option value =\"analis\" selected >Analis</option>";
                                                }
                                            else{
                                                echo"<option value=\"analis\">Analis</option>";
                                            }
                                        if($baris['hak_akses'] == 'penyelia'){
                                                echo "<option value =\"penyelia\" selected >Penyelia</option>";
                                                }
                                            else{
                                                echo"<option value=\"penyelia\">Penyelia</option>";
                                            }
                                    ?>
                                </select>
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="form-group">
                            <label for="gambar">Photo</label><br>
                                <div class="image"> 
                                     <?php if($baris['foto'] == null ){
                                        ?>
                                     <img src="<?php echo base_url('assets/image/user1.jpg') ?>" style="height:100px; width:100px; "/>
                                         <?php
                                     }else{ ?>
                                    <img src ="<?php echo base_url('photo/'.$baris['foto']) ?>" style="height:100px; width:100px;">
                                     <?php } ?>
                                 </div>
                            <input type="checkbox" name="ubah_photo" value="True"><span style="font-weight:bold; padding-left:10px;">Cheklist !! If You Want Change Photo</span><br><br>
							<input type="file" name="photo">						
                         </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" readonly class="form-control" name="email" id="email" value="<?php echo $baris['email']; ?>">
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
                <div class="row">
                    <div class="col-md">
                        <b><p>Dibuat : <?php echo  date('d-m-Y', strtotime($baris['dibuat'])); ?></p></b>
                    </div>
                    <div class="col-md">
                        <b><p>Diperbarui : <?php echo date('d-m-Y',strtotime($baris['diubah'])); ?></p></b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">
                        <button type="submit" class="btn btn-primary btn-sm"> <i class="fas fa-save fa-sm"></i> Simpan </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>