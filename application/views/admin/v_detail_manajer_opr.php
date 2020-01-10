<div class = "container-fluid">
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
                    <small><i class="fas fas-eye fa-sm"></i> Sampel <span class="fas fa-chevron-right mx-1"></span> Detail Sampel</small>
                    <div class="row mt-3">
                    <?php
                        $jml = 1; 
                    foreach ($detail as $baris):?>
                            <div class="col-md-6">
                                <table class="table table-responsive-sm table-sm">
                                <thead class="thead-light">
                                    </thead>
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Sampel</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr><td>Nama Sampel</td><td><?php echo $baris->nama_sampel ?></td></tr>
                                            <tr><td>Nomor Sampel</td><td><?php echo $baris->no_sampel ?></td></tr>
                                            <tr><td>Pemerian</td><td>
                                            <?php $pemerian = $this->m_registrasi_sampel->get_by_id('pemerian', 'id_pemerian', $baris->pemerian);
                                             echo $pemerian->pemerian;?>
                                            </td></tr>
                                            <tr><td>Kode Batch</td><td><?php echo $baris->kode_batch ?></td></tr>
                                            <tr><td>Kemasan</td><td>
                                            <?php $kemasan = $this->m_registrasi_sampel->get_by_id('kemasan', 'id_kemasan', $baris->kemasan);
                                            echo $kemasan->kemasan;?>
                                            </td></tr>
                                            <tr><td>Transportasi Sampel</td><td>
                                            <?php 
                                              $trans = $this->m_registrasi_sampel->get_by_id('transportasi_sampel', 'id_transportasi_sampel', $baris->transportasi_sampel);
                                            echo $trans->transportasi_sampel;?>
                                            </td></tr>
                                            <tr><td>Tempat Penyimpanan</td><td><?php echo $baris->tempat_penyimpanan?></td></tr>
                                            <tr><td>Hal Lain</td><td><?php echo $baris->hal_lain ?></td></tr>
                                            <tr><td>Tgl Permohonan Uji</td><td><?php echo WKT($baris->tgl_order)?></td></tr>
                                            <tr><td>Status sampel</td><td><?php echo StatusSampel($baris->status_sampel); ?></td></tr>
                                            <tr>
                                                <td class="text-dark">Pemeriksaan </td>
                                                <td class ="text-dark">
                                                <?php 
                                                $query = "SELECT * FROM pemeriksaan where id_sampel = {$baris->id_sampel}";
                                                $run = $this->db->query($query)->result();
                                                foreach ($run as $row):?>
                                                    <?php  echo '- '. getName('pengujian', 'id_pengujian', $row->id_pengujian, 'nama_pengujian')."<br>";
                                                    endforeach; 
                                                    ?>
                                                </td>   
                                            </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md mt-2 offset-8 mb-2">
                                        <a href="<?php echo base_url('c_permintaan_uji/hasilTinjauan_mt/'.$baris->id_sampel) ?>" class="btn btn-primary btn-sm"><i class="fas fa-eye fa-sm"></i> Hasil Tinjauan</a>
                                    </div>
                                </div>
                            </div>        
                        <?php endforeach; ?> 
                    </div>
                    <a href="<?php echo base_url('c_permintaan_uji/view_manajer_opr') ?>" class="btn btn-primary btn-sm mt-4"><i class="fas fa-angle-double-left fa-fw"></i> Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //sampel jika ya
$(document).ready(function() {
        $('#myModal').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('id'));
        });
    });
</script>