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
                        <small><i class="fas fa-list fa-folder"></i> Bahan <span class="fas fa-chevron-right mx-1"></span> Daftar Bahan</small><br>
                        <a class="btn btn-primary btn-sm mt-4 mb-2" href="<?php echo base_url('c_bahan_uji/tambah_bahan') ?>"> <span class="fas fa-plus fa-sm fa-fw"></span> Bahan</a>
                   <div class="card">
                        <div class="card-header bg-primary">
                            <h6 class="text-light">Daftar Bahan</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-sm" id="table">
                                <thead style="text-align:center" class="thead-light">
                                    <th width="8%">No</th>
                                    <th width="18%">Nama Bahan</th>
                                    <th width="15%">Pemasok</th>
                                    <th width="19%">Exp Date</th>
                                    <th width="13%">Retest Date</th>
                                    <th width="18%">Jenis Bahan</th>
                                    <th width="10%">Aksi</th>
                                <thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    foreach ($bahan as $baris):?>    
                                    <tr style="text-align:center">     
                                        <td><?php echo $no++; ?></td>                                    
                                        <td><?php echo $baris['nama_bahan']; ?></td>
                                        <td><?php echo $baris['pemasok']; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($baris['exp_date'])); ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($baris['retest_date'])); ?></td>
                                        <td><?php echo $baris['jenis_bahan']; ?></td>     
                                        <td><a href='#myModal' class='btn btn-primary btn-sm' id='custId' data-toggle='modal' data-id="<?php echo $baris['id_bahan_uji']; ?>"><i class="fas fa-edit fa-sm"></i></a>
									    <a href="#konfirmasi_hapus" class='btn btn-danger btn-sm' data-toggle='modal' data-id="<?php echo base_url('c_bahan_uji/hapus_bahan/'.$baris['id_bahan_uji'])?>"><i class="fas fa-trash fa-sm"></i></a></td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                   </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
	    $('#table').DataTable();
	});
</script>

<div class="modal fade bd-example-modal-lg"  id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Detail Admin</h5>
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
	//detail data admin
	$(document).ready(function(){
        $('#myModal').on('show.bs.modal', function (e) {
			var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
				url : "<?php echo base_url('c_bahan_uji/detail_bahan')?>",
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
	