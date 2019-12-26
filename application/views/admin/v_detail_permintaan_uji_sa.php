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
                    foreach ($detail as $baris): ?>
                            <div class="col-md-6 mt-2 mb-2">
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
                                            <?php 
                                              $pemerian = $this->m_registrasi_sampel->get_by_id('pemerian', 'id_pemerian', $baris->pemerian);
                                                echo $pemerian->pemerian; ?>
                                            </td></tr>
                                            <tr><td>Kode Batch</td><td><?php echo $baris->kode_batch ?></td></tr>
                                            <tr><td>Kemasan</td><td>
                                            <?php 
                                              $kemasan = $this->m_registrasi_sampel->get_by_id('kemasan', 'id_kemasan', $baris->kemasan);
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
                                            <tr><td>Status sampel</td><td><?php echo StatusSampel($baris->status_sampel) ?></td></tr>
                                          
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
                                            <?php 
                                                $query = "SELECT * FROM pemeriksaan where id_sampel = {$baris->id_sampel} and status_pemeriksaan = 3";
                                                $run = $this->db->query($query)->result();
                                                foreach ($run as $row):
                                                    if ($row->status_pemeriksaan == 3){
                                                ?>
                                                <tr><td></td><td><i style="font-size:15px;"><a href="#modal" data-toggle="modal" data-id="<?php echo $row->id_pemeriksaan?>" >Detail Penolakan ...</a></i></td></tr>
                                                 <?php } endforeach?>
                                    </tbody>
                                </table>
                                <?php 
                                    if ($baris->status_sampel == 0){
                                ?>
                                <a href="<?php echo base_url('c_permintaan_uji/terima_sampel/'.$baris->id_sampel)?>" class="btn btn-primary btn-sm offset-9 mb-3"><i class="fas fa-check fa-sm"></i> Terima sampel</a>
                                    <?php } else{ ?>
                                <a href="#" class="btn btn-primary btn-sm offset-9 disabled mb-3"><i class="fas fa-check fa-sm"></i> Terima sampel</a>
                                    <?php } ?>    
                            </div>
                    <?php endforeach; ?>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-12">
                        <a href="<?php echo base_url('c_permintaan_uji/approval_sa')?>" class="btn btn-primary btn-sm mt-4"><i class="fas fa-chevron-circle-left"></i> Kembali </a>
                        <?php 
                            $run = $this->m_registrasi_sampel->all_data_perbidang(array('order.no_order' =>$no_order), array('status_sampel'=> 0))->num_rows();
                            $row = $this->m_registrasi_sampel->get_by_id('order','no_order', $no_order); 
                            if ($run > 0 or $row->status != 0 ){
                        ?>
                        <a href="<?php  ?>" class="btn btn-success btn-sm mt-4 disabled"><i class="fas fa-check fa-sm"></i> Selesai </a>
                            <?php } else { ?>
                        <a href="<?php echo base_url('c_permintaan_uji/terima_sa/'.$no_order) ?>" class="btn btn-success btn-sm mt-4"><i class="fas fa-check fa-sm"></i> Selesai </a>   
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Detail Penolakan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="fetched-data">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
        $('#modal').on('show.bs.modal', function (e) {
			var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
				url : "<?php echo base_url('c_permintaan_Uji/detail_penolakan')?>",
				 data :  'rowid='+ rowid,
                success : function(data){
					    $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
</script>