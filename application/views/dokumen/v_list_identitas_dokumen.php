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
                    <small><i class="fas fa-file-pdf fa-fw fa-sm"></i>  Dokumen <span class="fas fa-chevron-right fa-fw mx-1"></span> Identitas Dokumen </small>   
                    <nav>
                        <div class="nav nav-tabs mt-4" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#dokumen_baru" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-list"></i> Dokumen Baru
                            <?php
                                $kueri = $this->m_dokumen->tmp_upload_dokumen('tmp_upload_dokumen')->num_rows();
                            ?>
                            <span class="badge badge-danger"><?php if ($kueri > 0) {echo $kueri; } ?></span>
                            </a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#riwayat" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-history"></i> Riwayat</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show mt-4 active" id="dokumen_baru" role="tabpanel" aria-labelledby="nav-home-tab">
                            <table class="table table-sm" id="table">
                                    <thead class="thead-light text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Dokumen</th>
                                            <th>Dokumen</th>
                                            <th>Tanggal Disusun</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php 
                                            $no = 1;
                                            foreach ($data as $baris):
                                        ?>
                                        <tr>
                                            <td><?php echo $no++;  ?></td>
                                            <td><?php echo $baris->nama_dokumen;  ?></td>
                                            <td><a href="<?php echo base_url('dokumen/'.$baris->file_dok) ?>"><i class="fas fa-file-word"></i> Dokumen</a></td>
                                            <td><?php echo WKT($baris->tgl_disusun) ?></td>
                                            <td><a href="<?php echo base_url('c_dokumen/form_identitas_dokumen/'.$baris->id_upload_dokumen) ?>" class="btn btn-primary btn-sm"><i class="fas fa-eye fa-fw"></i> Detail </a></td>
                                        </tr>
                                            <?php endforeach; ?>
                                    </tbody>
                                </table>            
                        </div>
                        <div class="tab-pane fade mt-4" id=riwayat role="tabpanel" aria-labelledby="nav-profile-tab">
                        <table class="table table-sm" id="table2">
                                    <thead class="thead-light text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Dokumen</th>
                                            <th>Dokumen Induk</th>
                                            <th>Jenis Dokumen</th>
                                            <th>Penyusun</th>
                                            <th>Tanggal Disusun</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php 
                                            $no = 1;
                                            foreach ($data2 as $baris2):
                                        ?>
                                        <tr>
                                            <td><?php echo $no++;  ?></td>
                                            <td><?php echo $baris2->nama_dok;  ?></td>
                                            <td><?php echo getName('dokumen_induk', 'id_dokumen_induk', $baris2->id_dokumen_induk, 'dokumen')?></td>
                                            <td><?php echo getName('jenis_dokumen', 'id_jenis_dokumen', $baris2->id_jenis_dokumen, 'nama_dokumen')?></td>
                                            <td><?php echo getName('admin', 'id_admin', $baris2->id_penyusun, 'nama')?></td>
                                            <td><?php echo WKT($baris2->tgl_buat) ?></td>
                                            <td><a href="<?php echo base_url('c_dokumen/detail_dokumen/'.$baris2->no_dokumen.'/identitas_dokumen') ?>" class="btn btn-primary btn-sm"><i class="fas fa-eye fa-fw"></i> Detail </a></td>
                                        </tr>
                                            <?php endforeach; ?>
                                    </tbody>
                                   
                                </table>    
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md">
                            <a href="<?php echo base_url('c_dokumen') ?>" class="btn btn-primary btn-sm"><i class="fas fa-angle-double-left"></i> Kembali</a>
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

            $(document).ready(function(){
			$('#table3').DataTable();
	        });
	</script>
