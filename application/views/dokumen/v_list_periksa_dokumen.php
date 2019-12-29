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
            <?php 
                $where 	= array('id_auth'=> $this->session->userdata('id_auth'));
                $row    = $this->m_admin->cari_admin($where)->row();
            ?>
                <div class="card-body">
                    <small><i class="fas fa-file-pdf fa-fw fa-sm"></i>  Dokumen <span class="fas fa-chevron-right fa-fw mx-1"></span> Periksa Dokumen </small>   
                    <nav>
                        <div class="nav nav-tabs mt-4" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#list_dokumen" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-list"></i> Dokumen
                            <span class="badge badge-danger"><?php echo periksa_ulang("(id_pemeriksa = '$row->id_admin' AND id_jenis_dokumen = '$id_jenis_dokumen')", "(status = '0')") ?></span>
                            </a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#periksa_ulang" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-redo-alt"></i> Periksa Ulang
                                <span class="badge badge-danger"><?php echo periksa_ulang("(id_pemeriksa = '$row->id_admin' AND id_jenis_dokumen = '$id_jenis_dokumen')", "(status = '4')") ?></span>
                            </a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show mt-4 active" id="list_dokumen" role="tabpanel" aria-labelledby="nav-home-tab">
                                <table class="table table-sm" id="table">
                                    <thead class="thead-light text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Dokumen</th>
                                            <th>No Dokumen</th>
                                            <th>Status</th>
                                            <th>Dokumen</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php 
                                            $no = 1; 
                                        foreach ($data as $baris): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $baris->nama_dok; ?></td>
                                                <td><?php echo $baris->no_dokumen;  ?></td>
                                                <td><?php echo StatusDokumen($baris->status); ?></td>
                                                <td><a href="<?php echo base_url('dokumen/'.$baris->dok) ?>"><?php echo $baris->dok; ?></a></td>
                                                <td><a href="<?php echo base_url('c_dokumen/detail_dokumen/'.$baris->no_dokumen.'/dokumen')?>" class="btn btn-primary btn-sm"><i class="fas fa-eye fa-fw"></i> Detail</a></td>
                                            </tr>
                                        <?php endforeach; ?> 
                                    </tbody>
                                </table>
                        </div>
                        <div class="tab-pane fade mt-4" id="periksa_ulang" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <table class="table table-sm" id="table2">
                                <thead class="thead-light text-center"> 
                                    <tr>
                                        <th>No Dokumen</th>
                                        <th>Nama Dokumen</th>
                                        <th>Status</th>
                                        <th>Detail</th>
                                    </tr>                                            
                                </thead>
                                <tbody class="text-center">
                                    <?php foreach ($periksa_ulang as $row): ?>
                                    <tr>
                                        <td><?php echo $row->no_dokumen; ?></td>
                                        <td><?php echo $row->nama_dok; ?></td>
                                        <td><?php echo StatusDokumen($row->status); ?></td>
                                        <td><a href="<?php echo base_url('c_dokumen/detail_dokumen/'.$baris->no_dokumen.'/periksa_ulang')?>" class="btn btn-primary btn-sm"><i class="fas fa-eye fa-fw"></i> Detail</a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    
                    <div class="row mt-5">
                        <div class="col-md">
                            <a href="<?php echo base_url('c_dokumen/periksa_dokumen') ?>" class="btn btn-primary btn-sm"><i class="fas fa-angle-double-left"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script type="text/javascript">
		$(document).ready(function(){
			$('#table').DataTable();
	        });
        
        $(document).ready(function(){
			$('#table2').DataTable();
	        });
	</script>