

    <?php foreach($bahan as $baris) { ?>
        
             <div class="col-md-12">
                <form action="<?php echo base_url('c_bahan_uji/update_bahan'); ?>" method="post">
                    <div class="row">
                        <div class="col-md">
                            <input type="hidden" name="id_bahan_uji" value="<?php echo $baris['id_bahan_uji'] ?>"/>
                            <div class="form-group">
                                <label for="nama_bahan">Nama Bahan</label>
                                    <input type="text" class="form-control" id="nama_bahan" name="nama_bahan" value="<?php echo $baris['nama_bahan']; ?>">
                            </div>	
                            <div class="form-group">
                                <label for="pemasok">Pemasok</label>
                                    <input type="text" class="form-control" id="pemasok" name="pemasok" value="<?php echo $baris['pemasok'] ?>">
                            </div>	

                            <div class="form-group">
                                <label for="jenis_bahan">Jenis Bahan</label>
                                <select class="form-control" name="jenis_bahan">
                                    <?php foreach ($jenis_bahan as $bar): 
                                    $id_jenis = $bar['id'];
                                    $jenis_bahan = $bar['jenis_bahan'];
                                     if($id_jenis == $baris['id_jenis_bahan']) {
                                        echo "<option value=\"$id_jenis\" selected>$jenis_bahan</option>";
                                        
                                    }else{
                                        echo "<option value=\"$id_jenis\">$jenis_bahan</option>";
                                        }
                                    	?>		
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md">
                        <label for="retest_date">Tes Ulang</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn-primary btn-sm" disabled><i class="fas fa-calendar"></i></button>
                                </div>
                                    <input type="text" class="form-control datepicker-here" name="retest_date" data-language="en" value="<?php echo date('d-m-Y', strtotime($baris['retest_date'])) ?>" placeholder="yyyy-mm-dd">
                            </div>

                            <label for="exp_date">Expired</label>
                            <div class="input-group mb-3 mt-2">
                                <div class="input-group-prepend">
                                    <button class="btn-primary btn-sm" disabled><i class="fas fa-calendar"></i></button>
                                </div>
                                    <input type="text" class="form-control datepicker-here" name="exp_date" data-language="en" value="<?php echo date('d-m-Y', strtotime($baris['exp_date'])) ?>" placeholder="yyyy-mm-dd" value="">
                            </div>

                            <div class="form-group">
                                <label for="peyimpanan">Penyimpanan</label>
                                    <input type="text" class="form-control" id="penyimpanan" name="penyimpanan" value="<?php echo $baris['penyimpanan'] ?>">
                            </div>	 
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
