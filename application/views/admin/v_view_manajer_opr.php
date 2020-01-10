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
                        <small><i class="fas fa-list fa-fw"></i> Sampel <span class="fas fa-chevron-right mx-1"></span> Permintaan Uji Sampel</small><br>
                   <div class="card mt-3">
                        <div class="card-header bg-primary">
                            <h6 class="text-light">Permohonan Permintaan Uji</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm" id="table">
                                <thead style="text-align:center" class="thead-light">
                                    <th width="3%">No</th>
                                    <th width="20%">No Permintaan</th>
                                    <th width="25%">Pengirim Sampel</th>
                                    <th width="25%">Perusahaan</th>
                                    <th width="15%">Aksi</th>
                                <thead>
                                <tbody class="text-center">
                                <?php 
                                    $no =1;
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
												<td>
												<a href=<?php echo base_url('c_permintaan_uji/detail_permintaan/'.$baris->no_order) ?> class='btn btn-primary btn-sm'><i class="fas fa-eye fa-sm"></i> Detail</a>
                                                </td>
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

<script>
    $(document).ready(function(){
	    $('#table').DataTable();
	});
</script>
