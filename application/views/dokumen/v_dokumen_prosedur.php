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
                        <small><i class="fas fa-list fa-fw"></i> Dokumen <span class="fas fa-chevron-right mx-1"></span> Daftar Dokumen Prosedur</small><br>
                        <?php
                        $hak_akses = $this->session->userdata('hak_akses');
                        if ($hak_akses == "admin_sampel") { ?>
                        <a href="<?php echo base_url('c_dokumen/upload_dokumen'); ?>" class="btn btn-primary btn-sm mt-4 mb-2"><i class="fas fa-upload fa-sm"></i> Dokumen</a>  
                        <?php } ?>   
                   <div class="card">
                        <div class="card-header bg-primary">
                            <h6 class="text-light">Daftar Dokumen Prosedur</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-sm" id="table">
                                <thead style="text-align:center" class="thead-light">
                                    <th width="8%">No</th>
                                    <th width="20%">Judul</th>
                                    <th width="20%">Kode</th>
                                    <th width="20%">Lokasi</th>
                                    <th width="10%">Dokumen</th>
                                    <th width="9%">Aksi</th>
                                <thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    foreach ($dokumen as $baris):?>    
                                    <tr style="text-align:center">     
                                        <td><?php echo $no++; ?></td>                                    
                                        <td><?php echo $baris['judul']; ?></td>
                                        <td><?php echo $baris['kode']; ?></td>
                                        <td><?php echo $baris['lokasi']; ?></td>
                                        <td><a href="<?php echo base_url('ViewerJS/#../dokumen_prosedur/'.$baris['nama_dokumen'])?>"><img src="<?php echo base_url('assets/img/pdf.png')?>" style="width:20px; height:20px"></a></td>
                                        <td><a href='#myModal' class='btn btn-primary btn-sm' id='custId' data-toggle='modal' data-id="<?php echo $baris['id_dp']; ?>"><i class="fas fa-edit fa-sm"></i></a>
                                        <?php
                                        $hak_akses = $this->session->userdata('hak_akses');
                                            if ($hak_akses == "admin_sampel") { ?>
                                        <a href="#konfirmasi_hapus" class='btn btn-danger btn-sm' data-toggle='modal' data-id="<?php echo base_url('c_dokumen/hapus_dokumen_prosedur/'.$baris['id_dp'])?>"><i class="fas fa-trash fa-sm"></i></a></td>
                                            <?php } ?> 
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                   </div>
                   <a href="<?php echo base_url('c_dokumen');?>" class="btn btn-primary btn-sm my-3"><i class="fas fa-arrow-left fa-sm"></i> Kembali</a>
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
					<h5 class="modal-title" id="exampleModalLabel">Detail Dokumen</h5>
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
				url : "<?php echo base_url('c_dokumen/detail_dokumen_prosedur')?>",
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