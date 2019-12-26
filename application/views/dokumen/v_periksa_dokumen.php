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
                    <small><i class="fas fa-file-pdf fa-fw fa-sm"></i>  Dokumen <span class="fas fa-chevron-right fa-fw mx-1"></span> Periksa Dokumen</small>
                    <h5 class="text-dark mt-5"> Periksa Dokumen</h5>
                    <div class="row mt-4">
                        <div class="col-md-7">
                            <?php foreach ($data as $baris): ?>
                                <div class="alert alert-primary" role="alert">
                                    <a href="<?php echo base_url('c_dokumen/list_periksa_dokumen/'.$baris->id_jenis_dokumen) ?>"><?php echo $baris->nama_dokumen; ?></a><span class=" badge badge-danger mx-2">1</span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <a href="<?php echo base_url('c_dokumen')?>" class="btn btn-primary btn-sm mt-5"><i class="fas fa-angle-double-left"></i> Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>