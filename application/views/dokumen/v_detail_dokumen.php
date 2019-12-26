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
                            <small><i class="fas fa-file-pdf fa-fw fa-sm"></i>  Dokumen <span class="fas fa-chevron-right fa-fw mx-1"></span> Periksa Dokumen</small>
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
                                                echo $row->nama; 
                                            ?>
                                            </td></tr>
                                            <tr><td>Jabatan Penyusun</td><td>
                                            <?php 
                                                $row = $this->m_dokumen->get_by_id('hak_akses','id_hak_akses', $baris->jabatan_penyusun);
                                                echo $row->hak_akses; 
                                            ?>
                                            </td></tr>
                                            <tr><td>Status Dokumen</td><td><?php  echo StatusDokumen($baris->status)?></td></tr>
                                            <tr><td>Tanggal Disusun</td><td><?php echo WKT($baris->tgl_buat)?></td></tr>
                                            <tr><td>Dokumen</td><td><a href="<?php echo base_url('dokumen/'.$baris->dok)?>"><i class="fas fa-file"></i> Lihat Dokumen</a></td></tr>
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <a href="<?php echo base_url('c_dokumen/list_periksa_dokumen/'.$baris->id_jenis_dokumen) ?>" class="btn btn-primary btn-sm mt-5"><i class="fas fa-angle-double-left"></i> Kembali</a>
                            <a href="#myModal" data-toggle="modal" data-id="<?php echo $baris->no_dokumen; ?>" class="btn btn-danger btn-sm mt-5"><i class="fas fa-times"></i> Tolak</a>
                            <a href="<?php echo base_url('c_dokumen/action_setuju/'.$baris->id_jenis_dokumen.'/'.$baris->no_dokumen) ?>" class="btn btn-success btn-sm mt-5"><i class="fas fa-check"></i> Setuju</a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title" id="exampleModalLabel">Lampirkan File</h5>
				  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">x</span>
				  </button>
				</div>
				<div class="modal-body"><div class="fetched-data"></div>
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
				url : "<?php echo base_url('c_dokumen/form_tolak_dokumen')?>",
				 data :  'rowid='+ rowid,
				 
                success : function(data){
					    $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
</script>

