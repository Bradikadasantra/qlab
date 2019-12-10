
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
				<div class="row my-3">
					<div class="col-md">
						<a href="#" class="btn btn-success btn-sm"><span class="fas fa-plus"></span> Tambah Aset</a>
					</div>
				</div>
				<div class="panel panel-info panel-dashboard">
					<div class="panel-heading bg-primary">
					  <h2 class="panel-title"><strong>Data Aset</strong></h2>
					</div>
					<div class="panel-body">
						<table class="table table-bordered table-admin"  id="data">
							<thead>
								<tr>
									<th width="1%">No</th>
									<th width="25%">Jenis Aset</th>
									<th width="15%">type</th>
									<th width="17%">Merk</th>
									<th width="4%">Jumlah</th>
									<th width="18%">Kodefikiasi</th>
									<th width="18%">Action</th>
								</tr>
							</thead>
								<tbody>
									<?php 
									 $no =1;
										foreach ($aset as $baris ){
									?>
									<tr style="text-align:center;">
										<td><?php echo $no++; ?></td>
										<td><?php echo $baris->jenis_aset; ?></td>
										<td><?php echo $baris->type; ?></td>
										<td><?php echo $baris->nama_merk; ?></td>
                                        <td><?php echo $baris->jumlah; ?></td>
                                        <td><?php echo $baris->kodefikiasi; ?></td>
										<td><a href='#myModal' class='btn btn-primary btn-sm' id='custId' data-toggle='modal' data-id="<?php echo $baris->id_aset; ?>"><i class="fas fa-edit"></i> Detail</a>
									    <a href="#konfirmasi-hapus" class='btn btn-danger btn-sm' data-toggle='modal' data-id="<?php echo base_url('c_admin/hapus_aset/'.$baris->id_aset)?>"><i class="fas fa-trash"></i> Hapus</a></td>
									</tr>
		
									<?php 
									
									} ?>	
								</tbody>
						</table>
					</div>
						<script type="text/javascript">
						$(document).ready(function(){
							$('#data').DataTable();
						});
						</script>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal detail aset -->
	<div class="modal fade bd-example-modal-lg"  id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Detail Aset</h5>
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


	<!-- Delete Modal-->
	<div class="modal fade" id="konfirmasi_hapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
	<script>
	//detail data aset
	$(document).ready(function(){
        $('#myModal').on('show.bs.modal', function (e) {
			var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
				url : "<?php echo base_url('c_admin/detail_aset')?>",
				 data :  'rowid='+ rowid,
				 
                success : function(data){
					    $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
	//Hapus Data
    $(document).ready(function() {
        $('#konfirmasi_hapus').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('id'));
        });
    });
	</script>
	
	