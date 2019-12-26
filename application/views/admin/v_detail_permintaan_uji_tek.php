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
                                        <?php if ($baris->status_sampel != 1){ ?>
                                    <a href="<?php echo base_url('c_permintaan_uji/hasilTinjauan_mt/'.$baris->id_sampel) ?>" class="btn btn-primary btn-sm"><i class="fas fa-eye fa-sm"></i> Hasil Tinjauan</a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>           
                        <?php endforeach; ?> 
                    </div> 
                        <a href="<?php echo base_url('c_permintaan_uji/approval_tek')?>" class="btn btn-primary btn-sm mt-5"><i class="fas fa-chevron-circle-left"></i> Kembali </a>   
                        <?php 
                            $will = $this->m_registrasi_sampel->all_data_perbidang2(array('order.no_order' => $baris->no_order), array('id_bidang' => $baris->id_bidang), "(status_tinjauan_anl = '0' AND status_sampel != '3' AND status_sampel != '6')")->num_rows();
                            if ($will > 0){
                        ?>
                        <a href="<?php echo base_url('c_permintaan_uji/kerjakan_sampel/'.$no_order.'/'.$baris->id_bidang) ?>" class="btn btn-success btn-sm mt-5"><i class="fas fa-check fa-sm"></i> Kerjakan sampel</a>
                            <?php } else { ?>
                                <a href="#" class="btn btn-success btn-sm mt-5 disabled"><i class="fas fa-check fa-sm"></i> Kerjakan sampel</a>
                            <?php }?>
                </div>  
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
				  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">x</span>
				  </button>
				</div>
				<div class="modal-body">Anda yakin ingin melanjutkan pengujian sampel ini ?</div>
				<div class="modal-footer">
				  <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
				  <a class="btn btn-primary btn-ok" href="#"> Ya</a>
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