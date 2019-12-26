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
                        <small><i class="fas fa-list fa-fw"></i> Sampel <span class="fas fa-chevron-right mx-1"></span> Sampel Siap Uji</small><br>
                        <nav>
                            <div class="nav nav-tabs mt-5" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#sampel_siap_uji" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-paperclip"> Sampel Siap Uji</i>
                                <?php   
                                        $notif = notif_navbar(array('id_bidang'=> $id_bidang), "(status = '2' AND status_sampel != '3' AND status_sampel != '6')", array('status_tinjauan_anl'=> 0));
                                        if ($notif > 0){
                                    ?>
                                    <span class="badge badge-danger"><?php echo $notif; ?></span>
                                        <?php } ?>
                                </a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#input_hasil_uji" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-pen"></i>  Input Hasil Uji 
                                <?php 
                                        $notif = notif_navbar(array('id_bidang'=> $id_bidang), "(status = '2' AND status_sampel != '3')", array('status_tinjauan_anl'=> 1));
                                        if ($notif > 0){
                                    ?>
                                    <span class="badge badge-danger"><?php echo $notif; ?></span>
                                        <?php } ?>
                                </a>
                                <a class="nav-item nav-link" id="nav-uji-ulang" data-toggle="tab" href="#uji_ulang" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-redo-alt"></i> Uji Ulang
                                <?php 
                                        $not = notif_navbar(array('id_bidang'=> $id_bidang), array('status'=> 9),'status_sertifikat = 3');
                                        if ($not > 0){
                                    ?>
                                    <span class="badge badge-danger"><?php echo $not; ?></span>
                                        <?php } ?>
                                </a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="sampel_siap_uji" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="card-body mt-2">
                                    <table class="table table-sm" id="table">
                                        <thead style="text-align:center" class="thead-light">
                                            <th width="7%">No</th>
                                            <th width="17%">No Order </th>
                                            <th width="23%">Pengirim Sampel</th>
                                            <th width="25%">Instansi</th>
                                            <th width="18%">Status</th>
                                            <th width="14%">Aksi</th>
                                        <thead>
                                        <tbody class="text-center">
                                            <?php
                                                $no = 1;  
                                                foreach ($permintaan as $baris) :
                                                $pelanggan = $this->m_registrasi_sampel->get_by_id('pelanggan', 'id_pelanggan', $baris->id_pelanggan);
                                                $pengirim = $pelanggan->nama; 
                                                $instansi = $pelanggan->instansi; 
                                            ?>
                                                <tr>
                                                    <td><?php echo $no++;  ?></td>
                                                    <td><?php echo $baris->no_order; ?></td>
                                                    <td><?php echo $pengirim; ?></td>
                                                    <td><?php echo $instansi; ?></td>
                                                    <td><?php echo status_tinjauan(array('order.no_order'=>$baris->no_order), array('id_bidang'=> $id_bidang), "(status_sampel !='3' AND status_sampel != '6' AND status_tinjauan_anl = '0')"); ?></td>
                                                    <td><a href="<?php echo base_url('c_permintaan_uji/detail_permintaan/'.$baris->no_order)?>" class="btn btn-primary btn-sm"><i class="fas fa-eye fa-sm"></i> Detail</a></td>
                                                </tr>
                                            <?php endforeach;  ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="input_hasil_uji" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="card-body mt-2">
                                        <table class="table table-sm" id="tab">
                                        <thead style="text-align:center" class="thead-light">
                                            <th width="7%">No</th>
                                            <th width="17%">No Order </th>
                                            <th width="23%">Pengirim Sampel</th>
                                            <th width="23%">Status</th>
                                            <th width="14%">Aksi</th>
                                        <thead>
                                        <tbody class="text-center">
                                            <?php
                                                $no = 1;  
                                                foreach ($permintaan_2 as $row) :
                                                $pelanggan = $this->m_registrasi_sampel->get_by_id('pelanggan', 'id_pelanggan', $row->id_pelanggan);
                                                $pengirim = $pelanggan->nama; 
                                            ?>
                                                <tr>
                                                    <td><?php echo $no++;  ?></td>
                                                    <td><?php echo $row->no_order; ?></td>
                                                    <td><?php echo $pengirim; ?></td>
                                                    <td><?php status_tinjauan(array('order.no_order'=> $row->no_order), array('id_bidang'=> $id_bidang), array('status_tinjauan_anl'=> 1)) ?></td>
                                                    <td><a href="<?php echo base_url('c_permintaan_uji/input_hasilpemeriksaan/'.$row->no_order.'/'.'input_hasil')?>" class="btn btn-primary btn-sm"><i class="fas fa-pen fa-sm"></i> Input hasil</a></td>
                                                </tr>
                                            <?php endforeach;  ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="uji_ulang" role="tabpanel" aria-labelledby="nav-uji-ulang">
                                 <div class="card-body mt-2">
                                        <table class="table table-sm" id="ta">
                                        <thead style="text-align:center" class="thead-light">
                                            <th width="7%">No</th>
                                            <th width="17%">No Order </th>
                                            <th width="23%">Pengirim Sampel</th>
                                        <thead>
                                        <tbody class="text-center">
                                        <?php 
                                            $no = 1;
                                            foreach ($permintaan_3 as $bi):
                                            $pelanggan = $this->m_registrasi_sampel->get_by_id('pelanggan', 'id_pelanggan', $row->id_pelanggan);
                                            $pengirim = $pelanggan->nama; 
                                        ?>
                                        <tr>
                                            <td><?php echo $no++;  ?></td>
                                            <td><a href="<?php echo base_url('c_permintaan_Uji/input_hasilpemeriksaan/'.$bi->no_order.'/'.'uji_ulang')?>"><?php echo $bi->no_order; ?></a></td>
                                            <td><?php echo $pengirim;?></td>
                                        </tr>
                                            <?php endforeach; ?>
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
	    $('#table').DataTable();
	});

    $(document).ready(function(){
	    $('#tab').DataTable();
	});

    $(document).ready(function(){
	    $('#ta').DataTable();
	});

</script>
