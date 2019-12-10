		
    <?php foreach($aset as $baris) { ?>
             <div class="col-md-12">
                <form action="<?php echo base_url('c_admin/update_aset'); ?>" enctype="multipart/form-data" method="post">
                    <div class="row">
                        <div class="col-md">
                            <input type="hidden" name="id_aset" value="<?php echo $baris['id_aset'] ?>"/>
                            <div class="form-group">
                                <label for="jenis_aset">Jenis Aset</label>
                                    <input type="text" class="form-control" id="jenis_barang" name="jenis_barang" value="<?php echo $baris['jenis_barang']; ?>">
                            
                            </div>	
                            <div class="form-group">
                                <label for="type">Type</label>
                                    <input type="text" class="form-control" id="type" name="type" value="<?php echo $baris['type'] ?>">
                            </div>	
                            <div class="form-group">
                                <label for="merk">Merk</label>
                                <select class="form-control" name="merk">
                                    <?php foreach ($merk as $merk): 
                                    $idmerk = $merk['id_merk'];
                                    $namamerk = $merk['merk'];
                                     if($idmerk == $baris['id_merk']) {
                                        echo "<option value=\"$idmerk\" selected>$namamerk</option>";
                                        
                                    }else{
                                        echo "<option value=\"$idmerk\">$namamerk</option>";
                                        }
                                    	?>		
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jumlah">Jumlah</label>
                                    <input type="text" class="form-control" id="jumlah" name="jumlah" value="<?php echo $baris['jumlah']; ?>">
                            </div>	
                        </div>
                        <div class="col-md">
                        <div class="form-group">
							<label for="gambar">Photo</label><br>
								<div class="image"> 
									<?php if($baris['foto'] == 'Default.jpg' ){ ?>
										<img src="<?php echo base_url('assets/img/aset.png') ?>" style="height:100px; width:100px; "/>
					
											<?php
											}else{
											?>
										<img src ="<?php echo base_url('photo_aset/'.$baris['foto']) ?>" style="height:100px; width:100px;">
										<?php
												}
												
										?>
								</div>
							    <p style="color:grey;">Maks  2 MB </p>
							    <input type="checkbox" name="ubah_photo" value="True"><span style="font-weight:bold; padding-left:10px;">Cheklist !! If You Want Change Photo</span><br><br>
								<input type="file" name="photo">
							</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <p><b> Dibuat :<?php echo date('m-d-Y', strtotime($baris['dibuat']))?></b></p>
                        </div>
                        <div class="col-md">
                            <p><b> Diperbarui :<?php echo date('m-d-Y', strtotime($baris['diubah']))?></b></p>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-md offset-6">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save fa-sm"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
	<?php 
		}
	?>
			