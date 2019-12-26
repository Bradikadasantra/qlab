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
                    <small><i class="fas fa-file-pdf fa-fw fa-sm"></i>  Dokumen <span class="fas fa-chevron-right fa-fw mx-1"></span> Periksa Dokumen   
                    <span class="fas fa-chevron-right fa-fw mx-1"></span> List Dokumen</small>
                    <div class="row my-4">
                        <div class="col-md">
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
                                            <td><?php echo $baris->status; ?></td>
                                            <td><a href="<?php echo base_url('dokumen/'.$baris->dok) ?>"><?php echo $baris->dok; ?></a></td>
                                            <td><a href="<?php echo base_url('c_dokumen/detail_dokumen/'.$baris->no_dokumen)?>" class="btn btn-primary btn-sm"><i class="fas fa-eye fa-fw"></i> Detail</a></td>
                                        </tr>
                                    <?php endforeach; ?> 
                                </tbody>
                            </table>
                        </div>
                    <div>
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