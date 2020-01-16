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
                    <small><i class="fas fa-file-pdf fa-fw fa-sm"></i> Dokumen <span class="fas fa-chevron-right fa-fw mx-1"></span> <?php $nama = $this->m_dokumen->get_by_id('dokumen_induk', 'id_dokumen_induk', $dokumen_induk);
                        echo $nama->dokumen;
                    ?></small>   
                    <div class="row mt-4">
                        <div class="col-md">
                            <a href="<?php echo base_url('c_dokumen/tambah_dokumen') ?>" class="btn btn-secondary btn-sm"><i class="fas fa-plus fa-fw"></i> Dokumen</a>   
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-print"></i> Print Dokumen</button>
                                    <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?php echo base_url('c_laporan/print_dokumen/'.$dokumen_induk.'/all_doc') ?>">All</a>
                                    <?php foreach ($jenis_dokumen as $rot): ?>
                                        <a class="dropdown-item" href="<?php echo base_url('c_laporan/print_dokumen/'.$rot->id_jenis_dokumen.'/print_dokumen_by_jenis_dokumen') ?>"><?php echo $rot->nama_dokumen;?></a>
                                    <?php endforeach;   ?>
                                    </div>
                            </div>
                        </div>
                       
                    </div>
                        <div class="row mt-4">
                            <div class="col-md">
                                <table class="table table-sm" id="table">
                                    <thead class="thead-light text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>No Dokumen</th>
                                            <th>Nama Dokumen</th>
                                            <th>Lokasi</th>
                                            <th>Dokumen</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php 
                                            $no = 1; 
                                        foreach ($data as $baris): ?>
                                            <tr>
                                                <td><?php echo $no++;  ?></td>
                                                <td><?php echo $baris->no_dokumen; ?></td>
                                                <td><?php echo $baris->nama_dok ?></td>
                                                <td><?php echo $baris->lokasi; ?></td>
                                                <td> <a href="<?php echo base_url('ViewerJS/#../dokumen/'.$baris->dok)?>"><img src="<?php echo base_url('assets/img/pdf.png')?>" style="width:20px; height:20px"></a></td>
                                                <td><a href="<?php echo base_url('c_dokumen/detail_dokumen/'.$baris->no_dokumen.'/all_dokumen')?>" class="btn btn-primary btn-sm"><i class="fas fa-eye fa-fw"></i> Detail</a></td>
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
	</script>