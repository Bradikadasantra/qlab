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
                    <?php 
                        $where 	= array('id_auth'=> $this->session->userdata('id_auth'));
                        $row    = $this->m_admin->cari_admin($where)->row();
                     ?>
                        <small><i class="fas fa-file-pdf fa-fw fa-sm"></i>  Dokumen <span class="fas fa-chevron-right fa-fw mx-1"></span> Riwayat</small>
                        <nav>
                            <div class="nav nav-tabs mt-4" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#riwayat" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-list"></i> Riwayat</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#upload_ulang" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-redo-alt"></i>  Upload Ulang
                                    <span class="badge badge-danger"><?php echo periksa_ulang(array('id_penyusun'=> $row->id_admin), array('status'=>3));?></span>
                                 </a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show mt-4 active" id="riwayat" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <table class="table table-sm" id="table">
                                        <thead class="thead-light text-center">
                                            <tr>
                                                <th>No dokumen</th>
                                                <th>Nama dokumen</th>
                                                <th>Jenis Dokumen</th>
                                                <th>Status</th>
                                                <th>Tgl Buat</th>
                                                <th>Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <?php foreach ($riwayat as $baris): ?>
                                            <tr>
                                                <td><?php echo $baris->no_dokumen; ?></td>
                                                <td><?php echo $baris->nama_dok ?></td>
                                                <td>
                                                    <?php 
                                                        $row = $this->m_dokumen->get_by_id('jenis_dokumen', 'id_jenis_dokumen', $baris->id_jenis_dokumen);
                                                        echo $row->nama_dokumen; 
                                                    ?>
                                                </td>
                                                <td><?php echo StatusDokumen($baris->status);?></td>
                                                <td><?php echo WKT($baris->tgl_buat)?></td>
                                                <td><a class="btn btn-primary btn-sm" href="<?php echo base_url('c_dokumen/detail_riwayat/'.$baris->no_dokumen) ?>"><i class="fas fa-eye fa-fw"></i> Detail</a></td>
                                            </tr>
                                            <?php endforeach;  ?>
                                        </tbody>
                                    </table>
                            </div>
                            <div class="tab-pane fade mt-4" id="upload_ulang" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <table class="table table-sm" id="table2">
                                        <thead class="thead-light text-center">
                                            <tr>
                                                <th>No dokumen</th>
                                                <th>Nama dokumen</th>
                                                <th>Status</th>
                                                <th>Detail</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                                <?php foreach ($upload_ulang as $col): ?>
                                                    <tr>
                                                        <td><?php echo $col->no_dokumen; ?></td>
                                                        <td><?php echo $col->nama_dok; ?></td>
                                                        <td><?php echo StatusDokumen($col->status) ?></td>
                                                        <td><a href="<?php echo base_url('c_dokumen/detail_penolakan/'.$col->no_dokumen) ?>" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Detail</a></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md">
                                <a href="<?php echo base_url('c_dokumen')?>" class="btn btn-primary btn-sm"><i class="fas fa-angle-double-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    <div>
</div>
<script type="text/javascript">
		$(document).ready(function(){
			$('#table').DataTable();
	        });

        $(document).ready(function(){
			$('#table2').DataTable();
	        });


	</script>
    