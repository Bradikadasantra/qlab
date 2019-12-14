<div class="container-fluid">
    <div class="row">
        <div class="col-md-11">
                <?php
                if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
                    echo '<div class="pesan">'.$_SESSION['pesan'].'</div>';
                }
                        // mengatur session pesan menjadi kosong
                        $_SESSION['pesan'] = '';
                ?>
                <?php 
                    foreach ($detail as $baris): ?>
            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="text-dark text-center">Nomor : <?php echo setNosampel($baris->no_sampel, $baris->tgl_order);  ?></h6>
                    <hr>
                    <div class="row">
                        <div class="col-md-5">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <td>Nama sampel<td>:</td></td><td><?php echo $baris->nama_sampel; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Pemerian</td><td>:</td><td><?php echo $baris->pemerian; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah</td><td>:</td><td><?php echo $baris->jumlah; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kemasan </td><td>:</td><td><?php echo $baris->kemasan; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Transportasi sampel </td><td>:</td><td><?php echo $baris->transportasi_sampel; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-5">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <td>Tempat penyimpanan</td><td>:</td><td><?php echo $baris->tempat_penyimpanan; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Hal lain</td><td>:</td><td><?php echo $baris->hal_lain; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Terima sampel</td><td>:</td><td><?php echo WKT($baris->terima_sampel); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Status sertifikat</td><td>:</td><td><?php echo StatusSertifikat($baris->status_sertifikat) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-sm">
                                <thead class="thead-light">
                                    <th>#</th>
                                    <th>Pemeriksaan</th>
                                    <th>Hasil pemeriksaan</th>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1; 
                                    $query = "SELECT * FROM pemeriksaan where id_sampel = '$baris->id_sampel'";
                                    $pemeriksaan  = $this->db->query($query)->result();
                                        foreach ($pemeriksaan as $row):
                                            $nama_pemeriksaan=getName("pengujian","id_pengujian",$row->id_pengujian,"nama_pengujian");
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $nama_pemeriksaan; ?></td>
                                    <td>   
                                        <table class="table table-borderless table-sm">
                                                <?php 
                                                $kueri = "SELECT hasil_pemeriksaan FROM hasil_pemeriksaan WHERE id_pemeriksaan = '$row->id_pemeriksaan'";
                                                $hasil = $this->db->query($kueri)->result();
                                                    foreach ($hasil as $r):                                  
                                            ?>
                                                <tr>
                                                    <td><?php echo $r->hasil_pemeriksaan; ?></td>
                                                </tr>
                                                    <?php endforeach;  ?>
                                        </table>      
                                    </td>
                                </tr>
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <?php 
                                if ($this->uri->segment(4) == 'approve'){
                            if ($baris->status_sertifikat != 1){
                            ?>
                                <a href="" class="btn btn-info btn-sm disabled"><i class="fas fa-redo-alt fa-sm"></i> Uji ulang</a>
                               <a href="#" class="btn btn-primary btn-sm disabled"><i class="fas fa-check fa-sm"></i> Setujui</a>
                            <?php } else{ ?>
                                <a href="#weModal" data-toggle="modal"  data-id="<?php echo $baris->id_sampel; ?>" class="btn btn-info btn-sm"><i class="fas fa-redo-alt fa-sm"></i> Uji ulang</a>
                                <a href="<?php echo base_url('c_permintaan_uji/setujui/'.$baris->id_sampel.'/'.'approve') ?>" class="btn btn-primary btn-sm"><i class="fas fa-check fa-sm"></i> Setujui</a>
                            <?php }
                                
                            }else { 
                               if ($baris->status_sertifikat == 4){ ?>
                                <a href="#weModal" data-toggle="modal"  data-id="<?php echo $baris->id_sampel; ?>" class="btn btn-info btn-sm"><i class="fas fa-redo-alt fa-sm"></i> Uji ulang</a>
                                <a href="<?php echo base_url('c_permintaan_uji/setujui/'.$baris->id_sampel.'/'.'approve_ulang') ?>" class="btn btn-primary btn-sm"><i class="fas fa-check fa-sm"></i> Setujui</a>
                            <?php } else { ?>
                                <a href="" class="btn btn-info btn-sm disabled"><i class="fas fa-redo-alt fa-sm"></i> Uji ulang</a>
                               <a href="#" class="btn btn-primary btn-sm disabled"><i class="fas fa-check fa-sm"></i> Setujui</a>
                            <?php } }?>
                        </div>
                    </div>
                </div>
            </div>
                 <?php endforeach;?>                    
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md">
            <a href="<?php echo base_url('c_permintaan_uji/approve_HasilPemeriksaan') ?>" class="btn btn-primary btn-sm"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
           
            <?php 
                if ($this->uri->segment(4) == 'approve'){
                $kuy = $this->m_registrasi_sampel->all_data_perbidang2(array('order.no_order'=> $no_order), array('id_bidang'=>$id_bidang), array('status_sertifikat'=> 1))->num_rows();
                $cari = $this->m_registrasi_sampel->all_data_perbidang2(array('order.no_order'=> $no_order), array('id_bidang'=>$id_bidang), array('status_tinjauan_mt'=> 4))->num_rows();
                if ($kuy > 0  or  $cari > 0){
            ?>
            <a href="#" class="btn btn-success btn-sm disabled"><i class="fa fa-check"></i> Selesai</a>
                <?php } else {?>
            <a href="<?php echo base_url('c_permintaan_Uji/selesai_setujuHasilPemeriksaan/'.$no_order.'/'.$id_bidang)?>" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Selesai</a>
                <?php } 
            } 
            else { ?>
            <?php  $kuy = $this->m_registrasi_sampel->all_data_perbidang2(array('order.no_order'=> $no_order), array('id_bidang'=>$id_bidang), array('status_sertifikat'=> 4))->num_rows();
                if ($kuy > 0){ ?>
            <a href="<?php echo base_url('c_permintaan_Uji/selesai_setujuHasilPemeriksaan/'.$no_order.'/'.$id_bidang)?>" class="btn btn-success btn-sm disabled"><i class="fa fa-check"></i> Selesai</a>
                <?php }else { ?>
                    <a href="<?php echo base_url('c_permintaan_Uji/selesai_setujuHasilPemeriksaan/'.$no_order.'/'.$id_bidang)?>" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Selesai</a>
            <?php } }?>
        </div>
    </div>
    <div class="modal fade" id="weModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title" id="exampleModalLabel">Catatan Penolakan Hasil Uji</h5>
				  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">x</span>
				  </button>
				</div>
				<div class="modal-body">    
                    <div class="fetched-data"></div>
                </div>
			</div>
		</div>
	</div>

<script>
    $(document).ready(function(){
        $('#weModal').on('show.bs.modal', function (e) {
			var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
				url : "<?php echo base_url('c_permintaan_uji/modal_uji_ulang/'.$this->uri->segment(4))?>",
    		    data :  'rowid='+ rowid,
                success : function(data){
					   $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });
</script>
</div>






