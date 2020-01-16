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
            <div class="row">
                <div class="col-md-11">
                    <div class="card">
                        <div class="card-body">
                            <small><i class="fas fa-file-pdf fa-fw fa-sm"></i>  Dokumen <span class="fas fa-chevron-right fa-fw mx-1"></span> <?php echo $judul; ?> <span class="fas fa-chevron-right fa-fw mx-1"></span>   <?php echo $judul2; ?> </small>  
                            <h5 class="text-dark mt-4"> Detail Dokumen</h5>
                            <div class="row mt-4">
                                <div class="col-md-8">
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                        <?php foreach ($data as $baris): ?>
                                            <tr><td>Dokumen Induk</td><td>
                                            <?php 
                                                $row = $this->m_dokumen->get_by_id('dokumen_induk', 'id_dokumen_induk', $baris->id_dokumen_induk);
                                                echo $row->dokumen; 
                                            ?>
                                            </td></tr>

                                            <tr><td>Jenis Dokumen</td><td>
                                            <?php
                                            $row = $this->m_dokumen->get_by_id('jenis_dokumen', 'id_jenis_dokumen', $baris->id_jenis_dokumen);
                                                echo $row->nama_dokumen; 
                                            ?>
                                            </td></tr>

                                            <tr><td>Nama Dokumen</td><td>
                                            <?php echo $baris->nama_dok; ?>
                                            </td></tr>
                                            <tr><td>Nomor Dokumen</td><td>
                                            <?php echo $baris->no_dokumen; ?>
                                            </td></tr>
                                            <tr><td>Peyusun</td><td>
                                            <?php 
                                                $row = $this->m_dokumen->get_by_id('admin', 'id_admin', $baris->id_penyusun);
                                                echo $row->nama. ' ('.hak_akses($baris->id_penyusun).')';
                                            ?>
                                            </td></tr>

                                            <tr><td>Pemeriksa</td><td>
                                            <?php 
                                                if ($baris->id_pemeriksa == ''){
                                                    echo "-";
                                                }else{
                                                    $row = $this->m_dokumen->get_by_id('admin', 'id_admin', $baris->id_pemeriksa);
                                                    echo $row->nama. ' ('.hak_akses($baris->id_pemeriksa).')';
                                                }
                                            ?>
                                            </td></tr>

                                            <tr><td>Pengesah</td><td>
                                            <?php 
                                            if ($baris->id_pengesah == ''){
                                                echo "-";
                                            }else{
                                                $row = $this->m_dokumen->get_by_id('admin', 'id_admin', $baris->id_pengesah);
                                                echo $row->nama. ' ('.hak_akses($baris->id_pengesah).')';
                                            }
                                            ?>
                                            </td></tr>

                                            <tr><td>Status Dokumen</td><td><?php  echo StatusDokumen($baris->status)?></td></tr>
                                            <tr><td>Tanggal Disusun</td><td><?php echo WKT($baris->tgl_buat)?></td></tr>
                                            <tr>
                                                <td>Dokumen</td>
                                                <td>
                                                   <?php if ($param == 'dokumen' or $param == 'identitas_dokumen' or $param == 'all_dokumen' or $param == 'riwayat') { ?>
                                                    <?php if ($baris->status == 2 ) { ?>
                                                        <a href="<?php echo base_url('ViewerJS/#../dokumen/'.$baris->dok)?>"><img src="<?php echo base_url('assets/img/pdf.png')?>" style="width:20px; height:20px"> Dokumen</a>
                                                    <?php } else{ ?>
                                                        <a href="<?php echo base_url('dokumen/'.$baris->dok) ?>"><i class="fas fa-file-word fa-fw"></i> Dokumen</a>
                                                    <?php } ?>

                                                    <?php } else { ?>
                                                        <a href="<?php echo base_url('dokumen/'.$baris->dok) ?>"><i class="fas fa-file-word fa-fw"></i> Dokumen</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                                <?php endforeach;  ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    
                            <?php if ($param == 'dokumen') { ?>
                                <a href="<?php echo base_url('c_dokumen/list_periksa_dokumen/'.$baris->id_jenis_dokumen) ?>" class="btn btn-primary btn-sm mt-5"><i class="fas fa-angle-double-left"></i> Kembali</a>
                            <?php } else if ($param == 'identitas_dokumen') { ?>
                            <a href="<?php echo base_url('c_dokumen/list_identitas_dokumen') ?>" class="btn btn-primary btn-sm mt-5"><i class="fas fa-angle-double-left"></i> Kembali</a>
                            <?php } else if ($param == 'periksa_ulang') { ?>
                                <a href="<?php echo base_url('c_dokumen/list_periksa_dokumen/'.$baris->id_jenis_dokumen) ?>" class="btn btn-primary btn-sm mt-5"><i class="fas fa-angle-double-left"></i> Kembali</a>
                            <?php } else if ($param == 'all_dokumen') { ?>
                                <a href="<?php echo base_url('c_dokumen/list_all_dokumen/'.$id_dokumen_induk) ?>" class="btn btn-primary btn-sm mt-5"><i class="fas fa-angle-double-left"></i> Kembali</a>
                            <?php  } else if ($param == 'riwayat') { ?>
                                <a href="<?php echo base_url('c_dokumen/riwayat') ?>" class="btn btn-primary btn-sm mt-5"><i class="fas fa-angle-double-left"></i> Kembali</a>
                                <a href="#konfirmasi_hapus" class='btn btn-danger btn-sm mt-5' data-toggle='modal' data-id="<?php echo base_url('c_dokumen/hapus_dokumen/'.$no_dokumen)?>"><i class="fas fa-trash fa-sm"></i> Hapus</a>
                            <?php } ?>

                            <?php 
                                if ($this->session->userdata('hak_akses') == 1 ) { ?>
                                 <a href="#myModal" data-toggle="modal" data-id="<?php echo $no_dokumen; ?>" class="btn btn-info btn-sm mt-5"><i class="fas fa-edit fa-fw"></i> Edit</a>
                                <?php  } ?>
                            <?php 
                                if ($edit > 0){
                            if ($baris->status == 0){ ?>
                            <a href="#myModal" data-toggle="modal" data-id="<?php echo $no_dokumen; ?>" class="btn btn-info btn-sm mt-5"><i class="fas fa-edit fa-fw"></i> Edit</a>
                            <?php } else { ?>
                                <a href="#myModal" data-toggle="modal" data-id="<?php echo $no_dokumen; ?>" class="btn btn-info btn-sm mt-5 disabled"><i class="fas fa-edit fa-fw"></i> Edit</a>
                            <?php } } ?>



                            <?php 
                                if ($setuju > 0) {
                            if ($param == 'dokumen'){ ?>
                                <?php if ($baris->status == 0) {?>
                            <a href="#youModal" data-toggle="modal" data-id="<?php echo $baris->no_dokumen; ?>" class="btn btn-danger btn-sm mt-5"><i class="fas fa-times"></i> Tolak</a>
                            <a href="<?php echo base_url('c_dokumen/action_setuju/'.$baris->no_dokumen) ?>" class="btn btn-success btn-sm mt-5"><i class="fas fa-check"></i> Setuju</a>
                            <?php } else{ ?>
                                <a href="#youModal" data-toggle="modal" data-id="<?php echo $baris->no_dokumen; ?>" class="btn btn-danger btn-sm mt-5 disabled"><i class="fas fa-times"></i> Tolak</a>
                                <a href="<?php echo base_url('c_dokumen/action_setuju/'.$baris->no_dokumen) ?>" class="btn btn-success btn-sm mt-5 disabled"><i class="fas fa-check"></i> Setuju</a>
                            <?php } ?>

                            <?php }else { ?>
                                <?php if ($baris->status == 4) {?>
                            <a href="#youModal" data-toggle="modal" data-id="<?php echo $baris->no_dokumen; ?>" class="btn btn-danger btn-sm mt-5"><i class="fas fa-times"></i> Tolak</a>
                            <a href="<?php echo base_url('c_dokumen/action_setuju/'.$baris->no_dokumen) ?>" class="btn btn-success btn-sm mt-5"><i class="fas fa-check"></i> Setuju</a>
                            <?php } else { ?>

                                <a href="#youModal" data-toggle="modal" data-id="<?php echo $baris->no_dokumen; ?>" class="btn btn-danger btn-sm mt-5 disabled"><i class="fas fa-times"></i> Tolak</a>
                                <a href="<?php echo base_url('c_dokumen/action_setuju/'.$baris->no_dokumen) ?>" class="btn btn-success btn-sm mt-5 disabled"><i class="fas fa-check"></i> Setuju</a>

                            <?php } } } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <div class="modal fade bd-example-modal-lg"  id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Dokumen</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="fetched-data"></div>
				</div>
			</div>
		</div>
	</div>
    <div class="modal fade" id="youModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title" id="exampleModalLabel">Lampirkan File</h5>
				  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">x</span>
				  </button>
				</div>
				<div class="modal-body"><div class="fetched-data2"></div>
			</div>
		</div>
	</div> 
</div>

<script>
  $(document).ready(function(){
        $('#myModal').on('show.bs.modal', function (e) {
			var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
				url : "<?php echo base_url('c_dokumen/edit_all_dokumen/'.$this->uri->segment(4))?>",
				 data :  'rowid='+ rowid,
                success : function(data){
					    $('.fetched-data').html(data);
                }
            });
         });
    });

    $(document).ready(function(){
        $('#youModal').on('show.bs.modal', function (e) {
			var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
				url : "<?php echo base_url('c_dokumen/form_tolak_dokumen')?>",
				 data :  'rowid='+ rowid,
				 
                success : function(data){
					    $('.fetched-data2').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });

    $(document).ready(function() {
        $('#konfirmasi_hapus').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('id'));
        });
    });

</script>

