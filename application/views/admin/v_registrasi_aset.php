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
                <small><i class="fas fa-folder fa-fw fa-sm"></i>  Aset <span class="fas fa-chevron-right fa-fw mx-1"></span> Tambah Aset</small>
                <hr class="divider">
                    <h5 class="mt-4 mb-4 mx-3"> Tambah Data Aset</h5>  
                        <form action="<?php echo base_url('c_admin/insert_aset') ?>" method="post">
                            <div class="row mx-2">
                                    <div class="col-md">
                                        <div class="form-group">
                                        <label for="jenis_barang">Jenis Barang</label>
                                            <input type="text" class="form-control" name="jenis_barang" id="jenis_barang" placeholder="Masukkan Jenis Barang">
                                        </div>
            
                                        <div class="form-group">    
                                        <label for="type">Type</label>
                                            <input type="text" class="form-control" name="type" id="type" placeholder="Masukkan Type">
                                        </div>
                                     
                                        <div class="form-group">	
                                            <label for="merk">Merk</label>
                                                <div class="input-group">
                                                        <select class="form-control" id="merk" name="merk">
                                                            <option value="" selected>-- Pilih Merk--</option>
                                                                <?php 
                                                                foreach($merk as $m){
                                                                ?>
                                                                <option value="<?php echo $m['id_merk']; ?>"><?php echo $m['merk']; ?></option>	
                                                                    
                                                                    <?php } ?>
                                                    </select>
                                                    <span class="input-group-append">
                                                        <a class="btn btn-info" href="#" data-toggle="modal" data-target="#tambah-merk"><span class="fas fa-plus-square"></span></a>
                                                        <a class="btn btn-danger" href="#" data-toggle="modal" data-target="#hapus-merk" id='custId'><span class="fas fa-trash"></span></a>
                                                    </span>
                                            </div>
                                        </div>
                
                                    </div>  
                                    <div class="col-md">
                                        <div class="form-group">
                                        <label for="kodefikiasi">Kodefikiasi</label>
                                            <input type="text" class="form-control" name="kodefikiasi" id="kodefikiasi" placeholder="Masukkan Kodefikiasi">
                                        </div>
                                      
                                        <div class="form-group">
                                        <label for="jumlah">Jumlah</label>
                                            <input type="text" class="form-control" name=jumlah id="jumlah" placeholder="Masukkan Jumlah">
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="row my-3 mx-3">
                                    <div class="col-md">
                                        <a href="<?php echo base_url('c_admin/daftar_aset');?>" class="btn btn-danger btn-sm" type="submit"><i class="fas fa-arrow-left fa-sm"></i> Kembali </a>
                                        <button class="btn btn-primary btn-sm" name="submit" type="submit"><i class="fas fa-save fa-sm"></i> Simpan </button>
                                    </div>
                                </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg"  id="tambah-merk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Tambah Merk</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
                    <form action="<?php echo base_url('c_admin/tambah_merk');?>" method="post">
                        <div class="row"> 
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="merk">Merk</label>
                                    <input type="text" class="form-control" name="merk" id="merk" placeholder="Masukkan Merk">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save fa-sm"></i> Simpan </button>
                            </div>
                        </div>
                    </form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>

    <!-- modal hapus merk -->
    <div class="modal fade bd-example-modal-sm"  id="hapus-merk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Merk</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="fetched-data2"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
	$(document).ready(function(){
		$('#hapus-merk').on('show.bs.modal', function (e) {
  
		//menggunakan fungsi ajax untuk pengambilan data
		$.ajax({
			type : 'post',
			url : "<?php echo site_url('c_admin/tampil_merk')?>",
			success : function(data){
				
			$('.fetched-data2').html(data);//menampilkan data ke dalam modal
					}
		});
			 });
	});
	</script>
