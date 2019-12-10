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
                <small><i class="fas fa-file-folder fa-fw fa-sm"></i>  Bahan <span class="fas fa-chevron-right fa-fw mx-1"></span>Tambah Bahan </small>
                <hr class="divider">
                    <h5 class="mt-4 mb-4 mx-3"> Tambah Bahan</h5>  
                        <form action="<?php echo base_url('c_bahan_uji/insert_bahan') ?>" method="post">
                            <div class="row mx-2">
                                    <div class="col-md">
                                        <div class="form-group">
                                        <label for="nama_bahan">Nama Bahan</label>
                                            <input type="text" class="form-control" name="nama_bahan" id="nama_bahan" placeholder="Nama Bahan">
                                        </div>

                                        <div class="form-group">
                                        <label for="pemasok">Pemasok</label>
                                            <input type="text" class="form-control" name="pemasok" id="pemasok" placeholder="Pemasok">
                                        </div>
            
                                        <label for="exp_date">Kadaluwarsa</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button disabled class="btn-primary btn-sm"><i class="fas fa-calendar"></i></button>
                                            </div>
                                            <input type="text" class="form-control datepicker-here" name="exp_date" data-language="en" placeholder="Kadaluwarsa">
                                        </div> 
                                    </div>
                                    <div class="col-md">
                                    <div class="form-group">
                                            <label for="jenis_bahan">Jenis Bahan</label>
                                            <select class="form-control" name="jenis_bahan" id="jenis_bahan">
                                                <option value=" " selected>~ Pilih ~</option>
                                                <?php foreach($jenis_bahan as $baris): ?>
                                                    <option value="<?php echo $baris['id']?>"><?php echo $baris['jenis_bahan']; ?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>

                                        <label for="retest_date">Tes Ulang</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <button class="btn-primary btn-sm" disabled><i class="fas fa-calendar"></i></button>
                                            </div>
                                            <input type="text" class="form-control datepicker-here" name="retest_date" data-language="en" placeholder="Tes Ulang">
                                        </div> 

                                        <div class="form-group">    
                                            <label for="penyimpanan">Penyimpanan</label>
                                                <input type="text" class="form-control" name="penyimpanan" id="penyimpanan" placeholder="Masukkan Penyimpanan">
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-3 mx-3">
                                    <div class="col-md">
                                        <button class="btn btn-primary btn-sm" name="submit" type="submit"><i class="fas fa-save fa-sm"></i> Simpan </button>
                                    </div>
                                </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>



