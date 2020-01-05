<div class="container-fluid">
    <div class="row">
        <div class="col-md">
            <?php
                if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
                    echo '<div class="pesan">'.$_SESSION['pesan'].'</div>';
                }
                        // mengatur session pesan menjadi kosong
                        $_SESSION['pesan'] = '';
                ?>
            <div class="card">
                <div class="card-body">
                    <small><i class="fas fa-list fa-fw"></i> List Sertifikat</small><br>
                    <div class="row mt-4">
                        <div class="col-md">
                            <table class="table table-sm mt-4" id="mytable">
                                <thead class="thead-light  text-center">
                                    <th>No</th>
                                    <th>Nomor Sertifikat</th>
                                    <th>Pemilik</th>
                                    <th>Instansi</th>
                                    <th>Sertifikat</th>
                                </thead>
                                <tbody class="text-center">
                                    <?php
                                    $no = 1; 
                                    foreach ($data as $baris): 
                                    $row = $this->m_registrasi_sampel->get_by_id('pelanggan', 'id_pelanggan', $baris->id_pelanggan);
                                    $pemilik = $row->nama;  
                                    $instansi = $row->instansi;    
                                    ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td> Nomor : <?php echo setNosampel($baris->no_sampel, $baris->tgl_order) ?></td>
                                            <td><?php echo $pemilik;  ?></td>
                                            <td><?php echo  $instansi;  ?></td>
                                            <td class="text-center"><a href="<?php echo base_url('c_pelanggan/print_hasilPemeriksaan/'.$baris->id_sampel) ?>"><i class="fas fa-file-pdf fa-sm"></i> Lihat</a></td>
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
<script>
    $(document).ready(function(){
		$('#mytable').DataTable();
    });
</script>