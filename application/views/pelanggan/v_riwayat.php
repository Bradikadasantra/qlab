<style>
.inv {
    text_decoration:none; 
}

.invo:hover{
    color:white; 
    text-decoration:none; 
    text-style:none; 
}

</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-md">
        <?php
                if (isset($_SESSION['pesan']) && $_SESSION['pesan']) {
              echo '<div class="pesan">'.$_SESSION['pesan'].'</div>';
                }
            
            // mengatur session pesan menjadi kosong
                    $_SESSION['pesan'] = '';
        ?>
        <?php $collapse = 1; 
        $r = 1; 
        foreach ($riwayat as $baris):?>
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="<?php echo '#colapse'.$collapse; ?>" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <div class="row">
                        <div class="col-md-6">
                        <h6 class="m-0 font-weight-bold text-primary">Riwayat <?php echo $r++; ?></h6><small>Dibuat tanggal : </small></i><span class="badge badge-secondary"><?php echo WKT($baris->tgl_order) ?></span>
                        <small> | <?php echo $baris->no_order;  ?></small>
                        </div>
                        <div class="col-md-2 offset-4">
                            <?php
                                $query = "SELECT * FROM tagihan where no_order = '{$baris->no_order}'";
                                $cari = $this->db->query($query)->row();
                                $tagihan = $cari->status_tagihan;
                               echo  StatusTagihan($tagihan)
                            ?></span>
                        </div>
                    </div>
                </a>
               
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="<?php echo 'colapse'.$collapse; ?>">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php 
                                    $row = $this->m_registrasi_sampel->get_by_id('order','no_order', $baris->no_order);
                                    if ($row->status == 4){
                                ?>
                                        <div class="alert alert-danger" role="alert">
                                            <i class= "fas fa-times fa-sm pr-"></i> Beberapa sampel dibatalkan atau perlu konfirmasi anda !!! </<i>
                                        </div>
                                    <?php } ?>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                <?php 
                                    if ($baris->status != 0 and $baris->status != 1){
                                ?>
                                    <button class="btn btn-sm btn-outline-info" onclick="window.location.href='<?php echo base_url('c_pelanggan/print_invoice/'.$baris->no_order) ?>'"><i class="fas fa-file-invoice"></i> Invoice</button>
                                    <?php } else { ?>
                                        <button class="btn btn-sm btn-outline-info" disabled onclick="window.location.href='<?php echo base_url('c_pelanggan/print_invoice/'.$baris->no_order) ?>'"><i class="fas fa-file-invoice disabled"></i> Invoice</button>
                                    <?php } ?>
                                    <?php 
                                        $cek_bayar = $this->m_registrasi_sampel->get_by_id('tagihan','no_order',$baris->no_order);
                                        if ($cek_bayar->status_tagihan != 2){  ?>
                                            <button class="btn btn-outline-info dropdown-toggle" disabled type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-file"></i> Hasil Pengujian</button>
                                             <div class="dropdown-menu"></div>   
                                        <?php }else { ?>
                                    
                                    <button class="btn btn-outline-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-file"></i> Hasil Pengujian</button>
                                    <div class="dropdown-menu">
                                    <?php 
                                        $sql = "SELECT * FROM order_detail JOIN sampel ON order_detail.id_order_detail = sampel.id_order_detail WHERE no_order = '$baris->no_order' AND status_sampel != '3'";
                                        $run = $this->db->query($sql)->result();
                                        foreach($run as $de): ?>
                                        <a class="dropdown-item" href="<?php echo base_url('c_pelanggan/print_hasilPemeriksaan/'.$de->id_sampel)?>"><?php echo setNosampel($de->no_sampel, $baris->tgl_order);?></a>
                                        <?php endforeach; ?>
                                   </div>   
                                        <?php }?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                
                                        
                            </div>
                        </div>
                        <div class="row">
                            <?php
                                $order_detail = $this->db->query("SELECT * from order_detail JOIN sampel ON order_detail.id_order_detail = sampel.id_order_detail where no_order = '{$baris->no_order}'")->result();
                                foreach ($order_detail as $od):
                            ?>
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <thead class="thead-light">
                                        <th> # </th>
                                        <th>Sampel</th>
                                    </thead>
                                    <tbody>
                                        <tr><td>Nama sampel</td><td><?php echo $od->nama_sampel ?></td><tr>
                                        <tr><td>Pemerian</td><td>
                                        <?php $pemerian = $this->m_registrasi_sampel->get_by_id('pemerian', 'id_pemerian', $od->pemerian);
                                        echo $pemerian->pemerian;?>
                                        </td><tr>
                                        <tr><td>Kode Batch</td><td><?php echo $od->kode_batch ?></td><tr>
                                        <tr><td>Jumlah</td><td><?php echo $od->jumlah ?></td><tr>
                                        <tr><td>Kemasan</td><td>
                                        <?php 
                                              $kemasan = $this->m_registrasi_sampel->get_by_id('kemasan', 'id_kemasan', $od->kemasan);
                                            echo $kemasan->kemasan;?>
                                        </td><tr>
                                        <tr><td>Transportasi Sampel</td><td>
                                        <?php 
                                              $trans = $this->m_registrasi_sampel->get_by_id('transportasi_sampel', 'id_transportasi_sampel', $od->transportasi_sampel);
                                            echo $trans->transportasi_sampel;?>
                                        </td><tr>
                                        <tr><td>Tempat Penyimpanan</td><td><?php echo $od->tempat_penyimpanan ?></td><tr>
                                        <tr><td>Hal Lain</td><td><?php echo $od->hal_lain ?></td><tr>
                                        <tr><td>
                                                Status Sampel</td><td>
                                                <?php echo StatusSampel($od->status_sampel) ?>
                                              
                                                <?php 
                                                    if ($od->status_tinjauan_mt != 0 AND $od->status_sampel != 6){
                                                ?>
                                                   <a href="<?php echo base_url('c_permintaan_uji/hasilTinjauan_mt/'.$od->id_sampel) ?>" class="text-primary p-4" style="font-style:italic;" > Lihat Tinjauan</a>
                                                    <?php } else { }?>
                                            </td>
                                        </tr>
                                        <tr>
                                        <td>Pemeriksaan</td>
                                            <td>
                                                <?php 
                                                    $query = "SELECT * FROM pemeriksaan where id_sampel = '{$od->id_sampel}'";
                                                    $pemeriksaan  = $this->db->query($query)->result();
                                                    foreach ($pemeriksaan as $row):
                                                        $nama_pemeriksaan=getName("pengujian","id_pengujian",$row->id_pengujian,"nama_pengujian");
                                                        echo '-&nbsp&nbsp'. $nama_pemeriksaan. '<br>';
                                                    endforeach;
                                                ?>
                                            </td>
                                        <tr>
                                    </tbody>
                                </table>
                                <?php if ($baris->status == 4 AND $od->status_sampel == 4) { ?>
                                    <div class="alert alert-secondary" role="alert">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <p>Beberapa sampel perlu konfirmasi anda !</p>
                                            </div>
                                            <div class="col-md-4">
                                                <a href="<?php echo base_url('c_permintaan_uji/hasilTinjauan_mt/'.$od->id_sampel) ?>" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Konfirmasi</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else if ($od->status_sampel == 5) { ?>
                                    <div class="alert alert-secondary text-center" role="alert">  
                                        <p style="font-weight:bold;" class="text-primary">Sudah dikonfirmasi</p>
                                    </div>
                                <?php } else { } ?>

                         <!--
                                <?php 
                                    if ($od->status_sampel == 0){
                                ?>
                                <small><a href="<?php echo base_url('c_registrasi_sampel/edit_PermohonanSampel/'.$od->id_sampel)?>" class=" col-md-2 offset-10"><i class="fas fa-edit fa-sm"></i> Ubah</a></small>
                                    <?php }else { ?>
                                        <small><a href="<?php echo base_url('c_registrasi_sampel/edit_PermohonanSampel/'.$od->id_sampel)?>" class="col-md-2 offset-10" style="pointer-events:none; cursor:default; color:grey;"><i class="fas fa-edit fa-sm"></i> Ubah</a></small>
                                    <?php } ?>
                            -->
                            <!--
                            <?php if ($baris->status == 0) {?>
                          <a href="#mymodal"  data-id="<?php echo base_url('c_registrasi_sampel/batalkan_pelanggan/'.$od->id_sampel) ?>" data-toggle="modal" class="btn btn-outline-danger mb-5 btn-sm"> Batalkan Pengujian</a>
                            <?php } else { ?>
                                <a href="#" class="btn btn-outline-secondary mb-5 btn-sm"> Batalkan Pengujian</a>
                            <?php } ?>
                                -->
                            </div> 
                            <?php endforeach;?>
                        </div>
                            <?php 
                               $hm = $this->m_registrasi_sampel->all_data_perbidang(array('order.no_order'=> $baris->no_order), array('status_sampel'=> 4))->num_rows(); 
                            if ($baris->status == 4){
                            ?>
                            <div class="row mt-4">
                                <div class="col-md-9">
                                    <div class="alert alert-secondary">
                                        <p> Apakah anda ingin tetap melanjutkan pengujian ?</p>
                                        <?php if ($hm > 0) { ?>
                                        <a href="#konfirmasi_sampel_tidak" data-id="<?php echo base_url('c_permintaan_uji/jika_tidak/'.$baris->no_order) ?>" class="btn btn-danger btn-sm disabled" data-toggle="modal"> Tidak </a>
                                        <a href="#konfirmasi_sampel_ya" data-id="<?php echo base_url('c_permintaan_uji/jika_ya/'.$baris->no_order) ?>" class="btn btn-primary btn-sm disabled" data-toggle="modal"> Ya </a>
                                        <?php } else { ?>
                                        <a href="#konfirmasi_sampel_tidak" data-id="<?php echo base_url('c_permintaan_uji/jika_tidak/'.$baris->no_order) ?>" class="btn btn-danger btn-sm" data-toggle="modal"> Tidak </a>
                                        <a href="#konfirmasi_sampel_ya" data-id="<?php echo base_url('c_permintaan_uji/jika_ya/'.$baris->no_order) ?>" class="btn btn-primary btn-sm    " data-toggle="modal"> Ya </a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                    </div>  
                </div>
            </div>
            <?php $collapse++; ?>
        <?php endforeach; ?>
        <p class="text-left" style="font-size:15px; font-style:italic; "> *Pengerjaan sampel terhitung  14 hari sejak sampel diterima</p>
        </div>
    </div>
    <div class="modal fade" id="konfirmasi_sampel_ya" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
				  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">x</span>
				  </button>
				</div>
				<div class="modal-body">Anda yakin ingin melanjutkan pengujian ?</div>
				<div class="modal-footer">
				  <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
				  <a class="btn btn-primary btn-ok" href="#"> Ya</a>
				</div>
			</div>
		</div>
	</div>

    <div class="modal fade" id="konfirmasi_sampel_tidak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
				  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">x</span>
				  </button>
				</div>
				<div class="modal-body">Anda yakin ingin membatalkan pengujian sampel ini  ?</div>
				<div class="modal-footer">
				  <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
				  <a class="btn btn-danger btn-ok" href="#"> Ya</a>
				</div>
			</div>
		</div>
	</div>

    <div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
				  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">x</span>
				  </button>
				</div>
				<div class="modal-body">Anda yakin ingin membatalkan pengujian ?</div>
				<div class="modal-footer">
				  <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
				  <a class="btn btn-danger btn-ok" href="#"> Ya</a>
				</div>
			</div>
		</div>
	</div>
</div>  
<script>

//sampel jika ya
$(document).ready(function() {
        $('#konfirmasi_sampel_ya').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('id'));
        });
    });

//sampel jika tidak
$(document).ready(function() {
        $('#konfirmasi_sampel_tidak').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('id'));
        });
    });

// pembatalan by pelanggan 
$(document).ready(function() {
        $('#mymodal').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('id'));
        });
    });
</script>

    
    