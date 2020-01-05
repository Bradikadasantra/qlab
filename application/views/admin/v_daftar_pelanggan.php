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
                        <small><i class="fas fa-list fa-fw"></i> User <span class="fas fa-chevron-right mx-1"></span> Daftar Pelanggan</small><br>
                   <div class="card my-4">
                        <div class="card-header bg-primary">
                            <h6 class="text-light">Daftar Pelanggan</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm" id="table">
                                <thead style="text-align:center" class="thead-light">
                                    <th width="8%">No</th>
                                    <th width="25%">Nama</th>
                                    <th width="19%">Alamat</th>
                                    <th width="6%">Foto</th>
                                    <th width="18%">Telepon</th>
                                    <th width="10%">Aksi</th>
                                <thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    foreach ($pelanggan as $baris):?>    
                                    <tr style="text-align:center">     
                                        <td><?php echo $no++; ?></td>                                    
                                        <td><?php echo $baris['nama']; ?></td>
                                        <td><?php echo $baris['alamat']; ?></td>
                                        <td>
                                        <?php if ($baris['foto'] == 'Default.jpg') { ?>
                                        <a href="<?php echo base_url('assets/img/user1.jpg');?>" data-fancybox><i class="fas fa-search"></i></a>
                                        <?php }else{ ?>
                                            <a href="<?php echo base_url('photo/'.$baris['foto']);?>" data-fancybox><i class="fas fa-search"></i></a>
                                        <?php } ?>
                                        </td>
                                        <td><?php echo $baris['no_telp']; ?></td>     
                                        <td><a href='#myModal' class='btn btn-primary btn-sm' id='custId' data-toggle='modal' data-id="<?php echo $baris['id_pelanggan']; ?>"><i class="fas fa-edit fa-sm"></i></a>
									    <a href="#konfirmasi_hapus" class='btn btn-danger btn-sm' data-toggle='modal' data-id="<?php echo base_url('c_admin/hapus_pelanggan/'.$baris['id_pelanggan'])?>"><i class="fas fa-trash fa-sm"></i></a></td>
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
				url : "<?php echo base_url('c_admin/detail_pelanggan')?>",
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
	