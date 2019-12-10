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
                foreach($detail as $baris):
            ?>
            <div class="card mt-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <?php echo $baris->nama_sampel;
                            echo "<br>";   
                                echo setNosampel($baris->no_sampel, $baris->tgl_order);
                                echo "<br>"; 
                                echo "Kode batch :" . "  ". $baris->kode_batch. "<br>"; 
                                echo "Pemerian :" ."  ". $baris->pemerian; 
                            ?>
                        </div>
                        <div class="col-md-3 offset-6">
                            <h6> Status Sertifikat : <?php echo StatusSertifikat($baris->status_sertifikat)?></h6>
                        </div>
                    </div>
                    <div class="row mt-3">  
                        <div class="col-md-12">
                            <table class="table table-sm">
                                <tbody>
                                            <?php  $query = "SELECT * FROM pemeriksaan where id_sampel = '$baris->id_sampel'";
                                            $pemeriksaan  = $this->db->query($query)->result();
                                                foreach ($pemeriksaan as $row):
                                                    $nama_pemeriksaan=getName("pengujian","id_pengujian",$row->id_pengujian,"nama_pengujian");
                                            ?>
                                            <tr>
                                                <td width="40%"><?php echo $nama_pemeriksaan;  ?></td>
                                                <td width="40%">
                                                    <table>
                                                    <?php 
                                                            $kueri = $this->db->query("SELECT * FROM hasil_pemeriksaan WHERE id_pemeriksaan = '$row->id_pemeriksaan'")->result();
                                                                foreach ($kueri as $col):
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $col->hasil_pemeriksaan;  ?></td>
                                                            <td width="20%">
                                                            <a href="#youModal" data-toggle="modal" data-id="<?php echo $col->id_hasil_pemeriksaan;?>"><i class="fas fa-pencil-alt fa-sm"></i> edit</a><br>
                                                            <a href="#weModal" data-toggle="modal" data-id="<?php echo base_url('c_permintaan_uji/hapus_hasilUji/'.$col->id_hasil_pemeriksaan.'/'.$this->uri->segment(4)) ?>" class="text-danger"><i class="fas fa-trash-alt fa-sm"></i> hapus</a>    
                                                            </td>
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
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <a href="#myModal"  data-toggle="modal" id='custId' data-id="<?php echo $baris->id_sampel; ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit fa-sm"></i> Input hasil</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <div class="row mt-5">
                <div class="col-md">
                    <a href="<?php echo base_url('c_permintaan_uji/approval_tek')?>" class="btn btn-primary btn-sm"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
                    <?php 

                        if ($this->uri->segment(4) == 'input_hasil'){
                        $kueri  = count($this->m_registrasi_sampel->detail_order2(array('no_order'=> $no_order), array('id_bidang' => $id_bidang), 'status_sampel != 3')->result());
                        $kueri2 = count($this->m_registrasi_sampel->detail_order3(array('no_order'   => $no_order), array('id_bidang' => $id_bidang),  'status_sampel != 3')->result());
                        $kueri3 = count($this->m_registrasi_sampel->detail_order3(array('no_order'   => $no_order), array('id_bidang' => $id_bidang),  'status_tinjauan_anl = 1')->result());                                            
                       if ($kueri == $kueri2 AND $kueri3 > 0){ ?>   
                             <a href="<?php echo $action; ?>" class="btn btn-success btn-sm"><i class="fas fa-check fa-sm"></i> Ajukan sertifikasi</a>
                        <?php } else{  ?>
                            <a href="#" class="btn btn-success btn-sm disabled"><i class="fas fa-check fa-sm"></i> Ajukan sertifikasi</a>
                        <?php }  }else {
                        $kueri  = count($this->m_registrasi_sampel->detail_order2(array('no_order'=> $no_order), array('id_bidang' => $id_bidang), 'status_sampel != 3')->result());
                        $kueri2 = count($this->m_registrasi_sampel->detail_order3(array('no_order'   => $no_order), array('id_bidang' => $id_bidang),  'status_sampel != 3')->result());
                        $kueri3 = count($this->m_registrasi_sampel->detail_order3(array('no_order'   => $no_order), array('id_bidang' => $id_bidang),  'status_tinjauan_anl = 3')->result());                                            
                       if ($kueri == $kueri2 AND $kueri3 > 0){ ?>   
                             <a href="<?php echo $action; ?>" class="btn btn-success btn-sm"><i class="fas fa-check fa-sm"></i> Ajukan sertifikasi</a>
                        <?php } else {  ?>
                            <a href="#" class="btn btn-success btn-sm disabled"><i class="fas fa-check fa-sm"></i> Ajukan sertifikasi</a>
                        <?php } }?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
                <div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Input Hasil Pemeriksaan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
                    <div class="fetched-data"></div>
				</div>
			</div>
		</div>
	</div>

    <div class="modal fade bd-example-modal-lg" id="youModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
                <div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Hasil Pemeriksaan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
                    <div class="fetched-data2"></div>
				</div>
			</div>
		</div>
	</div>

    <!--modal untuk hapus -->
    <div class="modal fade" id="weModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
				  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">x</span>
				  </button>
				</div>
				<div class="modal-body">Anda yakin ingin hapus ?</div>
				<div class="modal-footer">
				  <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
				  <a class="btn btn-danger btn-ok" href="#"> Ya</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
//modal input hasil
$(document).ready(function(){
        $('#myModal').on('show.bs.modal', function (e) {
			var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
				url : "<?php echo base_url('c_permintaan_uji/modal_inputHasil/'.$this->uri->segment(4))?>",
				 data :  'rowid='+ rowid,
                success : function(data){
					    $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });

// modal edit hasil 
    $(document).ready(function(){
        $('#youModal').on('show.bs.modal', function (e) {
			var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
				url : "<?php echo base_url('c_permintaan_uji/modal_editHasil/'.$this->uri->segment(4))?>",
				 data :  'rowid='+ rowid,
                success : function(data){
					    $('.fetched-data2').html(data);//menampilkan data ke dalam modal
                }
            });
         });
    });

    $(document).ready(function() {
        $('#weModal').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('id'));
        });
    });
</script>