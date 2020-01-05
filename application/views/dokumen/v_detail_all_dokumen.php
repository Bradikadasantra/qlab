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
                                <div class="col-md-9">
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                        <?php foreach ($data as $baris): ?>
                                            <tr>
                                                <td>Dokumen Induk</td>
                                                <td>:
                                                <?php 
                                                $row = $this->m_dokumen->get_by_id('dokumen_induk', 'id_dokumen_induk', $baris->id_dokumen_induk);
                                                echo $row->dokumen; 
                                                ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jenis Dokumen</td>
                                                <td>:
                                                <?php
                                                    $row = $this->m_dokumen->get_by_id('jenis_dokumen', 'id_jenis_dokumen', $baris->id_jenis_dokumen);
                                                        echo $row->nama_dokumen; 
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Nomor Dokumen</td>
                                                <td>:
                                                <?php echo $baris->no_dokumen; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Nama Dokumen</td>
                                                <td>: <?php echo $baris->nama_dok; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Lokasi</td>
                                                <td>: <?php echo $baris->lokasi; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Penyusun</td>
                                                <td>:
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
                                                <td>Pemeriksa</td>
                                                <td>:
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
                                                <td>Pengesah</td>
                                                <td>:
                                                <?php
                                                    if ($baris->id_pemeriksa == null){
                                                        echo "-";
                                                    }else{
                                                        $row = $this->m_dokumen->get_by_id('admin','id_admin',$baris->id_pengesah);
                                                        $row2 = $this->m_dokumen->get_by_id('auth','id_auth',$row->id_auth);
                                                        $row3 = $this->m_dokumen->get_by_id('hak_akses','id_hak_akses',$row2->hak_akses);
                                                        echo $row->nama." ( ".$row3->hak_akses." )";
                                                    }
                                                    ?>    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tgl Berlaku</td>
                                                <td>: <?php echo WKT($baris->tgl_disahkan)?></td>
                                            </tr>
                                            <tr>
                                                <td>Dokumen Awal</td>
                                                <td>:
                                                    <?php if ($baris->status != 0) { ?>
                                                        <a href="<?php echo base_url('ViewerJS/#../dokumen/'.$baris->dok)?>"><img src="<?php echo base_url('assets/img/pdf.png')?>" style="width:20px; height:20px"> Dokumen</a>
                                                    <?php } else{ ?>
                                                        <a href="<?php echo base_url('dokumen/'.$baris->dok) ?>"><i class="fas fa-file-word fa-fw"></i> Dokumen</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                            </div>
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
                                        </thead>
                                        <tbody class="text-center">
                                            <?php $no = 1; foreach ($data_2 as $row): ?>
                                                <tr>
                                                    <td><?php echo "Revisi ke - ".$no++; ?></td>
                                                    <td><?php echo $row->nama_dok; ?></td>
                                                    <td><?php echo WKT($row->tgl_revisi); ?></td>
                                                    <td>  <a href="<?php echo base_url('ViewerJS/#../dokumen_revisi/'.$row->dok_revisi)?>"><img src="<?php echo base_url('assets/img/pdf.png')?>" style="width:20px; height:20px"> Dokumen</a></td>
                                                </tr>
                                            <?php endforeach;  ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <a href="<?php echo base_url('c_dokumen/list_all_dokumen/'.$id_dokumen_induk) ?>" class="btn btn-primary btn-sm mt-5"><i class="fas fa-angle-double-left"></i> Kembali</a>
                            <a href="#modalku" data-toggle="modal"  data-id="<?php echo $no_dokumen; ?>" class="btn btn-success btn-sm mt-5"><i class="fas fa-info fa-fw"></i> Revisi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalku" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        $('#modalku').on('show.bs.modal', function (e) {
			var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
				url : "<?php echo base_url('c_dokumen/modal_dokumen_revisi')?>",
				 data :  'rowid='+ rowid,
				 
                success : function(data){
					    $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
</script>

