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
                            <h5 class="text-dark mt-4"> Detail Dokumen Perbaikan</h5>
                            <form action="<?php echo base_url('c_dokumen/ajukan_ulang/'.$no_dokumen)?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-9">
                                <table class="table table-borderless table-sm mt-4">
                                <?php foreach ($data as $baris): ?>
                                <tr>
                                    <td>No Dokumen</td><td>: <?php echo $baris->no_dokumen; ?></td>
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
                                    <td>Tgl Diperiksa</td><td>: <?php echo WKT($baris->tgl_diperiksa) ?></td>
                                </tr>
                                <?php if ($baris->status == 3){ ?>
                                <tr>
                                    <td>Dokumen</td><td><a href="<?php echo base_url('dokumen/'.$baris->dok) ?>"><i class="fas fa-file-word fa-sm fa-fw"></i> LIhat Perbaikan</a></td>
                                </tr>
                                <?php } ?>
                                <tr><td></td></tr>
                                <tr><td></td></tr>
                                <tr><td></td></tr>
                                <tr>
                                    <td class="text-dark">Lampirkan File</td>
                                </tr>
                                <tr><td><input type="file" class="form-control form-control-sm" name="file" required>  <?php echo form_error('file','<small class="text-danger">','</small>') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md">
                                <a href="<?php echo base_url('c_dokumen/riwayat') ?>" class="btn btn-primary btn-sm"><i class="fas fa-angle-double-left"></i> Kembali</a>
                                <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-upload"></i> Ajukan Ulang</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>