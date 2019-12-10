	
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
				<div class="form-panel">
					<div class="form-header bg-primary">
					  <h2 class="panel-title"><strong>Tambah Aset</strong></h2>
					</div>
						<form class="form-body" action="<?php echo base_url('c_admin/validasi_tambah_aset')?>" method="post" >
							<h3>Data Aset</h3>
							<div class="row my-4">
								<div class="col-md">
									<div class="form-group">
										<label for="jenis_aset">Jenis Aset</label>
										<input type="text" class="form-control" name="jenis_aset" id="jenis_aset" placeholder="Jenis Aset" value="<?php echo set_value('jenis_aset');?>">
										<?php echo form_error('jenis_aset','<p class="text-danger pl-2">','</p>') ?>
									</div>
									
									<div class="form-group">
										<label for="type">Type</label>
										<input type="text" class="form-control" name="type" id="type" placeholder="Type" value="<?php echo set_value('type');?>">
										<?php echo form_error('type','<p class="text-danger pl-2">','</p>') ?>
                                    </div>
									
                                 
                                    <div class="form-group">	
                                        <label for="merk">Merk</label>
                                            <div class="input-group">
                                                    <select class="form-control" id="merk" name="merk">
                                                        <option value="" selected>-- Pilih Merk--</option>
                                                            <?php 
                                                            foreach($merk as $m){
                                                            ?>
                                                            <option value="<?php echo $m->id_merk; ?>"><?php echo $m->nama_merk; ?></option>	
                                                                
                                                                <?php } ?>
												</select>
												<span class="input-group-append">
													<a class="btn btn-info" href="#" data-toggle="modal" data-target="#tambah-merk"><span class="fas fa-plus-square"></span></a>
													<a class="btn btn-danger" href="#" data-toggle="modal" data-target="#hapus-merk" id='custId'><span class="fas fa-trash"></span></a>
												</span>
                                        </div>
                                    </div>
                                    <?php echo form_error('merk','<p class="text-danger pl-2">','</p>') ?>
                                </div>
                             
								<div class="col-md">
                                    <div class="form-group">
										<label for="jumlah">Jumlah</label>
										<input type="text" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" value="<?php echo set_value('jumlah') ?>">
                                        <?php echo form_error('jumlah','<p class="text-danger pl-2">','</p>') ?>
                                    </div>
                                    <div class="form-group">
										<label for="kodefikiasi">Kodefikiasi</label>
										<input type="text" class="form-control" name="kodefikiasi" id="kodefikiasi" placeholder="Kodefikiasi" value="<?php echo set_value('kodefikiasi'); ?>">
                                        <?php echo form_error('kodefikiasi','<p class="text-danger pl-2">','</p>') ?>
                                    </div>
								    
									<div class="row">
										<div class="col-md">
											<input type="submit" value="Submit" name="submit" class="btn btn-primary btn-block mt-4">
										</div>
									</div>
							</div>
						</form>
				</div>
			</div>
		</div>
    </div>

<!-- Modal tambah merk -->
<div class="modal fade bd-example-modal-lg"  id="tambah-merk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Detail Pegawai</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="fetched-data"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>

    <!-- modal hapus merk -->
    <div class="modal fade" id="hapus-merk" tabindex="0" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
				  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">x</span>
				  </button>
				</div>
				<div class="modal-body">Anda yakin ingin menghapus data ini...?</div>
				<div class="modal-footer">
				  <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
				  <a class="btn btn-danger btn-ok" href="#">Hapus</a>
				</div>
			</div>
		</div>
	</div>
    
	
	<script type="text/javascript">
	$(document).ready(function(){
		$('#hapus-jabatan').on('show.bs.modal', function (e) {
  
		//menggunakan fungsi ajax untuk pengambilan data
		$.ajax({
			type : 'post',
			url : "<?php echo site_url('c_jabatan/tampil_jabatan')?>",
			success : function(data){
				
			$('.fetched-data').html(data);//menampilkan data ke dalam modal
					}
		});
			 });
	});
	</script>
