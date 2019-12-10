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
                        <small><i class="fas fa-list fa-fw"></i> Sampel <span class="fas fa-chevron-right mx-1"></span> Approval Permintaan Uji</small><br>
                        <nav>
                            <div class="nav nav-tabs mt-5" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-paperclip"></i> Approval Permintaan Uji
                                    <?php 
                                        
                                        $notif = notif_navbar(array('id_bidang'=> $id_bidang), array('status'=> 1), 'status_tinjauan_mt = 0');

                                        if ($notif > 0){
                                    ?>

                                    <span class="badge badge-danger"><?php echo $notif; ?></span>
                                        <?php } ?>
                                </a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-calendar-check"></i>  Konfirmasi Pelanggan 
                                    <?php 
                                        $kue = $this->m_registrasi_sampel->all_data_perbidang(array('id_bidang' => $id_bidang), "(status = '6' AND status_sampel = '5')")->num_rows();
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
                                    <table class="table table-sm" id="table">
                                        <thead style="text-align:center" class="thead-light">
                                            <th width="7%">No</th>
                                            <th width="20%">No Order </th>
                                            <th width="22%">Pengirim Sampel</th>
                                            <th width="25%">Perusahaan</th>
                                            <th width="17%">Status</th>
                                            <th width="18%">Aksi</th>
                                        <thead>
                                        <tbody class="text-center">
                                        <?php 
                                        $no = 1; 
                                            foreach ($list as $baris):?> 
                                            <tr> 
                                            <td><?php echo $no++; ?></td> 
                                            <td><?php echo $baris->no_order; ?></td>  
                                            <?php 
                                                    $que = "SELECT * FROM pelanggan WHERE id_pelanggan = '{$baris->id_pelanggan}'";
                                                    $info = $this->db->query($que)->result();
                                                    foreach ($info as $ap): ?>                                   
                                                        <td><?php echo $ap->nama?></td>
                                                        <td><?php echo $ap->instansi; ?></td>
                                                        <?php endforeach ?>
                                                        <td><?php echo status_tinjauan(array('order.no_order'=> $baris->no_order), array('id_bidang'=> $id_bidang), "(status_tinjauan_mt = '0' OR status_tinjauan_mt = '1')") ?></td>        
                                                        <td>
                                                        <a href=<?php echo base_url('c_permintaan_uji/detail_permintaan/'.$baris->no_order) ?> class='btn btn-primary btn-sm'><i class="fas fa-edit fa-sm"></i> Detail </a>
                                                        </td>
                                            </tr>
                                            <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="card-body mt-2">
                                <table class="table table-sm" id="table2">
                                        <thead style="text-align:center" class="thead-light">
                                            <th width="7%">No</th>
                                            <th width="10%">No Order </th>
                                            <th width="10%">Pengirim Sampel</th>
                                            <th width="13%">Perusahaan</th>
                                        <thead>
                                        <tbody class="text-center">
                                        <?php 
                                        $no = 1; 
                                            foreach ($list_2 as $row):?> 
                                            
                                            <tr> 
                                            <td><?php echo $no++; ?></td> 
                                            <td><a href="<?php echo base_url('c_permintaan_uji/detail_permintaan/'.$row->no_order)?>" ><?php echo $row->no_order; ?></a></td>  
                                            <?php 
                                                    $que = "SELECT * FROM pelanggan WHERE id_pelanggan = '{$row->id_pelanggan}'";
                                                    $in = $this->db->query($que)->result();
                                                    foreach ($in as $a): ?>                                   
                                                        <td><?php echo $a->nama?></td>
                                                        <td><?php echo $a->instansi; ?></td>
                                                        <?php endforeach ?>        
                                            </tr>
                                            <?php endforeach;?>
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
	    $('#table2').DataTable();
	});
</script>

	