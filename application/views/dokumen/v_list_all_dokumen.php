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
                    <small><i class="fas fa-file-pdf fa-fw fa-sm"></i> <?php $nama = $this->m_dokumen->get_by_id('dokumen_induk', 'id_dokumen_induk', $dokumen_induk);
                        echo $nama->dokumen;
                    ?></small>   
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
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
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