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
                        <small><i class="fas fa-list fa-fw"></i> Sampel <span class="fas fa-chevron-right mx-1"></span> Appprove Hasil Uji</small><br>
                        <nav>
                            <div class="nav nav-tabs mt-5" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-paperclip"></i> Approval Hasil Uji
                                    <?php 
                                        $notif = notif_navbar(array('id_bidang'=> $id_bidang), "(status = '8' AND status_sampel != '3')", 'status_tinjauan_mt != 4');

                                        if ($notif > 0){
                                    ?>

                                    <span class="badge badge-danger"><?php echo $notif; ?></span>
                                        <?php } ?>
                                </a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-redo-alt "></i> Sampel Uji Ulang 
                                    <?php 
                                        $kue = notif_navbar(array('id_bidang' => $id_bidang),array('status'=> 9),"(status_tinjauan_mt = '5' AND status_sertifikat = '4')");
                                        if ($kue > 0){
                                    ?>
                                    <span class="badge badge-danger"><?php echo $kue;  ?></span>
                                    <?php } ?> 
                                </a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                 <div class="card-body mt-2">
                                    <table class="table table-sm" id="tab">
                                            <thead style="text-align:center" class="thead-light">
                                                <th width="3%">No</th>
                                                <th width="18%">No Order</th>
                                                <th width="22%">Pengirim Sampel</th>
                                                <th width="20%">Instansi</th>
                                                <th width="18%">Status</th>
                                                <th width="10%">Aksi</th>
                                            <thead>
                                            <tbody class="text-center">
                                                <?php 
                                                $no = 1; 
                                                foreach ($detail as $baris): 
                                                $pelanggan = $this->m_registrasi_sampel->get_by_id('pelanggan', 'id_pelanggan', $baris->id_pelanggan);
                                                $pengirim = $pelanggan->nama; 
                                                $instansi = $pelanggan->instansi; 
                                                ?>
                                                
                                                    <tr>
                                                        <td><?php echo $no++;  ?></td>
                                                        <td><?php echo $baris->no_order; ?></td>
                                                        <td><?php echo $pengirim; ?></td>
                                                        <td><?php echo $instansi; ?></td>
                                                        <td><?php echo status_tinjauan(array('order.no_order'=> $baris->no_order), "(id_bidang = '$id_bidang' AND status_sampel != '3')", "(status_tinjauan_mt = '2' OR status_tinjauan_mt = '3')") ?></td>
                                                        <td><a href="<?php echo base_url('c_permintaan_uji/detail_HasilPemeriksaan/'.$baris->no_order.'/'.'approve') ?>" class="btn btn-primary btn-sm"><i class="fas fa-eye fa-sm"></i> Lihat</a></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                    </table>
                                </div>
                            </div>          
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="card-body">
                                <table class="table table-sm" id="tab2">
                                        <thead style="text-align:center" class="thead-light">
                                            <th width="7%">No</th>
                                            <th width="17%">No Order </th>
                                            <th width="23%">Pengirim Sampel</th>
                                            <th width="23%">Status</th>
                                        <thead>
                                        <tbody>
                                            <?php 
                                                $no = 1;
                                                foreach ($detail2 as $row):
                                                    $pelanggan = $this->m_registrasi_sampel->get_by_id('pelanggan', 'id_pelanggan', $row->id_pelanggan);
                                                    $pengirim = $pelanggan->nama; 
                                            ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><a href="<?php echo base_url('c_permintaan_uji/detail_HasilPemeriksaan/'.$row->no_order.'/'.'approve_ulang') ?>"><?php echo $row->no_order;?></a></td>
                                                <td><?php echo $pengirim; ?></td>
                                            </tr>
                                                <?php endforeach;  ?>
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
	    $('#tab').DataTable();
	});

    $(document).ready(function(){
	    $('#tab2').DataTable();
	});
</script>
