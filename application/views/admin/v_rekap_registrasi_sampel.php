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
                <small><i class="fas fa-list fa-fw"></i> Rekap Registrasi Sampel</small><br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row mt-4">
                                    <div class="col-md">
                                        <form action="" method="post">
                                            <div class="form-group row pl-3 pb-2">
                                                <label for="bidang">PIlih Bidang</label>
                                                <div class="col-md-4">
                                                    <select class="form-control" id="bidang" name="bidang">
                                                        <option value="M">Mikrobiologi</option>
                                                        <option value="K">Kimia</option>
                                                        <option value="F">Farmakologi</option>
                                                    </select>
                                                </div>
                                                <input type="submit" class="btn btn-outline-secondary btn-sm" value="Submit" name="submit">
                                            </div>  
                                        </form>
                                    </div>
                                </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-print fa-fw"></i> Print
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Mikrobiologi</a>
                                            <a class="dropdown-item" href="#">Kimia</a>
                                            <a class="dropdown-item" href="#">Farmakologi</a>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    <div class="row mt-4">
                        <div class="col-md">
                            <table class="table" id="table">
                                <thead class="thead-light text-center">
                                    <th>Nomor</th>
                                    <th>Pengirim</th>
                                    <th>Kode</th>
                                    <th>Invoice</th>
                                    <th>Pemeriksaan</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Coa</th>
                                    <th>Ket</th>

                                </thead>
                                <tbody>
                                    <?php foreach ($detail as $baris): 
                                        $row = $this->m_registrasi_sampel->get_by_id('pelanggan', 'id_pelanggan', $baris->id_pelanggan);
                                        $pengirim = $row->nama;     
                                    ?>
                                    <tr>
                                        <td><?php echo setNosampel($baris->no_sampel, $baris->tgl_order); ?></td>
                                        <td><?php echo $pengirim; ?></td>
                                        <td><?php echo $baris->kode_batch; ?></td>
                                        <td><?php echo $baris->no_tagihan; ?></td>
                                        <td>    
                                            <?php 
                                                   $query = "SELECT * FROM pemeriksaan where id_sampel = '{$baris->id_sampel}'";
                                                   $pemeriksaan  = $this->db->query($query)->result();
                                                   foreach ($pemeriksaan as $row):
                                                       $nama_pemeriksaan=getName("pengujian","id_pengujian",$row->id_pengujian,"nama_pengujian");
                                                       echo  $nama_pemeriksaan." ";
                                                   endforeach;
                                            ?>
                                        </td>
                                        <td>
                                            <table class="table table-sm">
                                                <thead class="thead-light">
                                                   <th>Terima</th>
                                                   <th>Selesai</th>
                                                </thead>
                                                <tbody>
                                                   <tr>
                                                   <td><?php echo date('d/m/y', strtotime($baris->terima_sampel)) ?></td><td><?php echo date('d/m/y', strtotime($baris->selesai_sampel))?></td>
                                                   </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td class="text-center"><?php
                                            if ($baris->status_sampel != '3'){
                                                echo StatusTagihan($baris->status_tagihan);
                                            }else{
                                                echo "-";
                                            }
                                        ?></td>
                                        <td class="text-center"><a href="<?php echo base_url('c_pelanggan/print_hasilPemeriksaan/'.$baris->id_sampel) ?>"><i class="fas fa-search fa-sm"></a></td>
                                        <td class="text-center">
                                            <?php 
                                                   if ($baris->status_sampel == 3){
                                                       echo "<p class='text-danger'>Ditolak</p>";
                                                   }else if ($baris->status_sampel == 4){
                                                    echo "<p class='text-dark'>Konfirmasi</p>";
                                                   }else{
                                                       echo "-";
                                                   }
                                            ?>
                                        </td>
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
<script>
    $(document).ready(function(){
		$('#table').DataTable();
    });
</script>