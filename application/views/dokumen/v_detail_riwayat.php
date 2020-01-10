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
                            <small><i class="fas fa-file-pdf fa-fw fa-sm"></i>  Dokumen <span class="fas fa-chevron-right fa-fw mx-1"></span> Riwayat 
                            <span class="fas fa-chevron-right fa-fw mx-1"></span> Detail 
                            </small>
                            <h5 class="text-dark mt-4"> Detail Riwayat</h5>
                            <div class="row">
                                <div class="col-md-9">
                                <table class="table table-borderless table-sm mt-4">
                                <?php foreach ($data as $baris): ?>
                                <tr>
                                    <td>No Dokumen</td><td>: <?php echo $baris->no_dokumen;  ?></td>
                                </tr>
                                <tr>
                                    <td>Dokumen Induk</td><td> : 
                                    <?php 
                                        $row = $this->m_dokumen->get_by_id('dokumen_induk','id_dokumen_induk',$baris->id_dokumen_induk);
                                        echo $row->dokumen; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jenis Dokumen</td><td> :
                                    <?php 
                                        $row = $this->m_dokumen->get_by_id('jenis_dokumen','id_jenis_dokumen',$baris->id_jenis_dokumen);
                                        echo $row->nama_dokumen; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nama Dokumen</td><td>: <?php echo $baris->nama_dok; ?></td>
                                </tr>
                                <tr>
                                    <td>Lokasi</td><td>: <?php echo $baris->lokasi; ?></td>
                                </tr>
                                <tr>
                                    <td>Penyusun</td><td> :
                                    <?php 
                                        if ($baris->id_penyusun == null){
                                                echo "-";
                                        }else{
                                            $row = $this->m_dokumen->get_by_id('admin','id_admin',$baris->id_penyusun);
                                        $row2 = $this->m_dokumen->get_by_id('auth','id_auth',$row->id_auth);
                                        $row3 = $this->m_dokumen->get_by_id('hak_akses','id_hak_akses',$row2->hak_akses);
                                        echo $row->nama." ( ".$row3->hak_akses." )";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pemeriksa</td><td> :
                                    <?php
                                    if ($baris->id_pemeriksa == null){
                                        echo "-";
                                    }else{
                                        $row = $this->m_dokumen->get_by_id('admin','id_admin',$baris->id_pemeriksa);
                                        $row2 = $this->m_dokumen->get_by_id('auth','id_auth',$row->id_auth);
                                        $row3 = $this->m_dokumen->get_by_id('hak_akses','id_hak_akses',$row2->hak_akses);
                                        echo $row->nama." ( ".$row3->hak_akses." )";
                                    }
                                    ?>    
                                    </td>
                                </tr>
                                <tr>
                                    <td>Status Dokumen</td><td>: <?php echo StatusDokumen($baris->status);?></td>
                                </tr>
                                <tr>
                                    <td>Tgl Disusun</td><td>: <?php echo WKT($baris->tgl_buat) ?></td>
                                </tr>
                                <tr>
                                    <td>Tgl Diperiksa</td>
                                    <td>: <?php if ($baris->tgl_diperiksa == 0){ echo "-"; }else{ echo WKT($baris->tgl_diperiksa); } ?></td>
                                </tr>
                                <tr>
                                    <td>Dokumen</td>
                                    <td>
                                    <?php if ($baris->status != 0 ) { ?>
                                            <a href="<?php echo base_url('ViewerJS/#../dokumen/'.$baris->dok)?>"><img src="<?php echo base_url('assets/img/pdf.png')?>" style="width:20px; height:20px"> Dokumen</a>
                                        <?php } else{ ?>
                                            <a href="<?php echo base_url('dokumen/'.$baris->dok) ?>"><i class="fas fa-file-word fa-fw"></i> Dokumen</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                             
                            </table>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md">
                                <?php if ($baris->status != 2) {?>
                                <a href="#myModal" data-toggle="modal" data-id="<?php echo $no_dokumen; ?>" class="btn btn-info btn-sm"><i class="fas fa-edit fa-fw"></i> Edit</a>
                                <?php } else { ?>
                                    <a href="#myModal" data-toggle="modal" data-id="<?php echo $no_dokumen; ?>" class="btn btn-info btn-sm disabled"><i class="fas fa-edit fa-fw"></i> Edit</a>
                                <?php } ?>
                                <a href="#konfirmasi_hapus" class='btn btn-danger btn-sm' data-toggle='modal' data-id="<?php echo base_url('c_dokumen/hapus_dokumen/'.$no_dokumen)?>"><i class="fas fa-trash fa-sm"></i> Hapus</a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <!-- Dokumen revisi -->
                            <hr class="mt-2">
                           <h5 class="text-dark mt-4"> Revisi Dokumen</h5>
                            <div class="row mt-3">
                                <div class="col-md">
                                    <table class="table table-sm tableborderless">
                                        <thead class="thead-light text-center">
                                            <th>Revisi</th>
                                            <th>Nama dokumen</th>
                                            <th>Tanggal Revisi</th>
                                            <th>Dokumen</th>
                                            <th>Aksi</th>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php $no = 1; foreach ($data_2 as $row): ?>
                                                <tr>
                                                    <td><?php echo "Revisi ke - ".$no++; ?></td>
                                                    <td><?php echo $row->nama_dok; ?></td>
                                                    <td><?php echo WKT($row->tgl_revisi); ?></td>
                                                    <td><a href="<?php echo base_url('ViewerJS/#../dokumen_revisi/'.$row->dok_revisi)?>"><img src="<?php echo base_url('assets/img/pdf.png')?>" style="width:20px; height:20px"> Dokumen</a></td>
                                                    <td>
                                                    <a href="#konfirmasi_hapus" class='btn btn-danger btn-sm' data-toggle='modal' data-id="<?php echo base_url('c_dokumen/hapus_dokumen_revisi/'.$row->id_revisi)?>"><i class="fas fa-trash fa-sm"></i></a>
                                                    <a href="#edit_revisi" class='btn btn-info btn-sm' data-toggle='modal' data-id="<?php echo $row->id_revisi; ?>"><i class="fas fa-edit  fa-sm"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach;  ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <a href="<?php echo base_url('c_dokumen/riwayat') ?>" class="btn btn-primary btn-sm mt-5"><i class="fas fa-angle-double-left"></i> Kembali</a>
                            <?php  if ($status == 2 ) { ?>
                            <a href="#upload_revisi" data-toggle="modal" data-id="<?php echo $no_dokumen; ?>" class="btn btn-success btn-sm mt-5"><i class="fas fa-info fa-fw"></i> Revisi</a>
                            <?php } else { ?>
                                <a href="#upload_revisi" data-toggle="modal" data-id="<?php echo $no_dokumen; ?>" class="btn btn-success btn-sm mt-5 disabled"><i class="fas fa-info fa-fw"></i> Revisi</a>
                            <?php } ?>
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
				  <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Batal</button>
				  <a class="btn btn-danger btn-sm btn-ok" href="#">Hapus</a>
				</div>
			</div>
		</div>
	</div>

    <div class="modal fade" id="upload_revisi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Dokumen Revisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="fetched-data2"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_revisi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Edit Dokumen Revisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="fetched-data3"></div>
                </div>
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
				url : "<?php echo base_url('c_dokumen/edit_all_dokumen')?>",
				 data :  'rowid='+ rowid,
				 
                success : function(data){
					    $('.fetched-data').html(data);
                }
            });
         });
    });

    $(document).ready(function(){
        $('#upload_revisi').on('show.bs.modal', function (e) {
			var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
				url : "<?php echo base_url('c_dokumen/modal_dokumen_revisi/'.$this->uri->segment(2))?>",
				 data :  'rowid='+ rowid,
                success : function(data){
					    $('.fetched-data2').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });

    $(document).ready(function(){
        $('#edit_revisi').on('show.bs.modal', function (e) {
			var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
				url : "<?php echo base_url('c_dokumen/modal_editdokumen_revisi/'.$this->uri->segment(2))?>",
				 data :  'rowid='+ rowid,
                success : function(data){
					    $('.fetched-data3').html(data);//menampilkan data ke dalam modal
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