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
                <hr class="divider">
                    <h5 class="mt-4 mb-4 mx-3"> Upload Dokumen</h5>  
                        <form action="<?php echo base_url('c_dokumen/insert_dokumen') ?>" enctype="multipart/form-data" method="post">
                            <div class="row mx-2">
                                    <div class="col-md">
                                        <div class="form-group">
                                            <label for="jenis_dokumen">Jenis Dokumen Induk</label>
                                            <select class="form-control" name="jenis_dokumen" id="jenis_dokumen">
                                                <option value=" " selected>~ Pilih ~</option>
                                                <?php foreach($dokumen as $baris): ?>
                                                    <option value="<?php echo $baris['id_dokumen']?>"><?php echo $baris['dokumen']; ?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                        <label for="judul">Judul</label>
                                            <input type="text" class="form-control" name="judul" id="judul" placeholder="Masukkan Judul">
                                        </div>
            
                                        <div class="form-group">    
                                        <label for="kode">Kode</label>
                                            <input type="text" class="form-control" name="kode" id="kode" placeholder="Masukkan Kode">
                                        </div>
                                    </div>  
                                    <div class="col-md">
                                            <div class="form-group">    
                                            <label for="lokasi">Lokasi</label>
                                                <input type="text" class="form-control" name="lokasi" id="lokasi" placeholder="Masukkan Lokasi">
                                            </div>

                                            <div class="form-group">
                                            <label for="dokumen">File</label>        
                                                <input type="file" class="form-control-file" name="dokumen" id="dokumen">
                                            </div>
                                    </div>
                                </div>
                                <div class="row my-3 mx-3">
                                    <div class="col-md">
                                        <a href="#" class="btn btn-danger btn-sm" type="submit"><i class="fas fa-arrow-left fa-sm"></i> Kembali </a>
                                        <button class="btn btn-primary btn-sm" name="submit" type="submit"><i class="fas fa-save fa-sm"></i> Simpan </button>
                                    </div>
                                </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>



