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
                                            <tr><td>Dokumen Induk</td><td>:
                                            <?php 
                                                $row = $this->m_dokumen->get_by_id('dokumen_induk', 'id_dokumen_induk', $baris->id_dokumen_induk);
                                                echo $row->dokumen; 
                                            ?>
                                            </td></tr>
                                            <tr><td>Jenis Dokumen</td><td>:
                                            <?php
                                            $row = $this->m_dokumen->get_by_id('jenis_dokumen', 'id_jenis_dokumen', $baris->id_jenis_dokumen);
                                                echo $row->nama_dokumen; 
                                            ?>
                                            <tr><td>Nomor Dokumen</td><td>:
                                            <?php echo $baris->no_dokumen; ?>
                                            </td></tr>
                                            <tr>
                                                <td>Nama Dokumen</td><td>: <?php echo $baris->nama_dok; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Lokasi</td><td>: <?php echo $baris->lokasi; ?></td>
                                            </tr>
                                            <tr><td>Peyusun</td><td>:
                                            <?php 
                                                $row = $this->m_dokumen->get_by_id('admin', 'id_admin', $baris->id_penyusun);
                                                echo $row->nama; 
                                            ?>
                                            </td></tr>
                                            

                                            <tr><td>Peyusun</td><td>
                                            <?php 
                                                $row = $this->m_dokumen->get_by_id('admin', 'id_admin', $baris->id_penyusun);
                                                echo $row->nama. ' ('.hak_akses($baris->id_penyusun).')';
                                            ?>
                                            </td></tr>

                                            <tr><td>Pemeriksa</td><td>
                                            <?php 
                                                if ($baris->id_pemeriksa == ''){
                                                    echo "-";
                                                }else{
                                                    $row = $this->m_dokumen->get_by_id('admin', 'id_admin', $baris->id_pemeriksa);
                                                    echo $row->nama. ' ('.hak_akses($baris->id_pemeriksa).')';
                                                }
                                            ?>
                                            </td></tr>

                                            <tr><td>Pengesah</td><td>
                                            <?php 
                                            if ($baris->id_pengesah == ''){
                                                echo "-";
                                            }else{
                                                $row = $this->m_dokumen->get_by_id('admin', 'id_admin', $baris->id_pengesah);
                                                echo $row->nama. ' ('.hak_akses($baris->id_pengesah).')';
                                            }
                                            ?>
                                            </td></tr>
                                            <tr><td>Status Dokumen</td><td>: <?php  echo StatusDokumen($baris->status)?></td></tr>
                                            <tr><td>Tanggal Disusun</td><td>: <?php echo WKT($baris->tgl_buat)?></td></tr>
                                            <tr>
                                                <td>Dokumen</td>
                                                <td>:
                                                    <?php if ($baris->status != 0) { ?>
                                                        <a href="<?php echo base_url('ViewerJS/#../dokumen/'.$baris->dok)?>"><img src="<?php echo base_url('assets/img/pdf.png')?>" style="width:20px; height:20px"> Dokumen</a>
                                                    <?php } else{ ?>
                                                        <a href="<?php echo base_url('dokumen/'.$baris->dok) ?>"><i class="fas fa-file-word fa-fw"></i> Dokumen</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <a href="<?php echo base_url('c_dokumen/list_sahkan_dokumen/'.$baris->id_jenis_dokumen) ?>" class="btn btn-primary btn-sm mt-5"><i class="fas fa-angle-double-left"></i> Kembali</a>
                            <?php if ($baris->status == 1) { ?>
                            <a href="<?php echo base_url('c_dokumen/action_sahkan/'.$baris->no_dokumen) ?>" class="btn btn-success btn-sm mt-5"><i class="fas fa-check fa-fw"></i> Sahkan</a>               
                            <?php } else { ?>
                                <a href="<?php echo base_url('c_dokumen/action_sahkan/'.$baris->no_dokumen) ?>" class="btn btn-success btn-sm mt-5 disabled"><i class="fas fa-check fa-fw"></i> Sahkan</a>
                            <?php } endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

