
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
                <small><i class="fas fa-file-pdf fa-fw fa-sm"></i>  Registrasi <span class="fas fa-chevron-right fa-fw mx-1"></span> Sampel</small>
                <hr class="divider">
                    <h5 class="mt-4 mb-4 mx-3 text-center"> Permintaan Pengujian Sampel</h5>  
                        <form action="<?php echo base_url('c_registrasi_sampel/insert_sampel_2') ?>" method="post">
                        <div class="row">
                            <div class="col-md-10 mb-4">  
                                <div class="form-group">
                                    <label for="no_order">No Order</label>
                                    <input type="text"  readonly class="form-control" name="no_order" value="<?php echo $no_order; ?>">
                                </div>
                            </div>
                        </div>
                        <h5 class="text-info">Pengirim Sampel</h5>
                        <?php foreach ($pelanggan as $pel): ?>
                            <div class="row">
                                <div class="col-md">
                                    <input type="hidden" value="<?php echo $pel['id_pelanggan'] ?>">
                                    <div class="form-group">
                                         <input type="text" class="form-control" readonly value="<?php echo $pel['nama'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control"  readonly value="<?php echo $pel['no_telp']?>">
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                         <input type="text" class="form-control" readonly value="<?php echo $pel['instansi']?>">
                                    </div>
                                    <div class="form-group">
                                       <textarea class="form-control" rows="4" cols="4" readonly> <?php echo $pel['alamat_instansi']?></textarea>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <h5 class="text-info mt-4">Identitas Sampel</h5>
                            <div class="row mt-3">
                                <div class="col-md">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="nama_sampel" id="nama_sampel" placeholder="Nama Sampel" value="<?php echo set_value('nama_sampel') ?>">
                                        <?php echo form_error('nama_sampel','<small class="text-danger pl-3">','</small>') ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="pemerian" id="pemerian" placeholder="Pemerian" value="<?php echo set_value('pemerian') ?>">
                                        <?php echo form_error('pemerian','<small class="text-danger pl-3">','</small>') ?>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="kode_batch" id="kode_batch" placeholder="Kode Batch" value="<?php echo set_value('kode_batch') ?>">
                                        <?php echo form_error('kode_batch','<small class="text-danger pl-3">','</small>') ?>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="jumlah" id="jumlah" value="1" readonly>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="kemasan" id="kemasan" placeholder="Kemasan" value="<?php echo set_value('kemasan') ?>">
                                        <?php echo form_error('kemasan','<small class="text-danger pl-3">','</small>') ?>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="transportasi_sampel" id="transportasi_sampel" placeholder="Transportasi Sampel" value="<?php echo set_value('transportasi_sampel') ?>">
                                        <?php echo form_error('transportasi_sampel','<small class="text-danger pl-3">','</small>') ?>
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="tempat_penyimpanan" id="tempat_penyimpanan" placeholder="Tempat Penyimpanan" value="<?php echo set_value('tempat_penyimpanan') ?>">
                                        <?php echo form_error('tempat_penyimpanan','<small class="text-danger pl-3">','</small>') ?>
                                    </div>
                                </div>
                            </div>
                            <h5 class="text-info mt-4 mx-2 mb-3">Pengujian Yang Diminta</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class=""> Mikrobiologi</h6>
                                    <select class="form-control sel" name="mikrobiologi[]" multiple="multiple">
                                    <?php foreach($mikrobiologi as $baris): ?>
                                        <option value="<?php echo $baris['id_pengujian']?>"><?php echo $baris['nama_pengujian']; ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                <h6 class=""> Kimia</h6>
                                    <select class="form-control sel" name="kimia[]" multiple="multiple">
                                       <?php foreach($kimia as $baris): ?>
                                        <option value="<?php echo $baris['id_pengujian']?>"><?php echo $baris['nama_pengujian']; ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <h6 class="">Farmakologi</h6>
                                    <select class="form-control sel" name="farmakologi[]" multiple="multiple">
                                    <?php foreach($farmakologi as $baris): ?>
                                        <option value="<?php echo $baris['id_pengujian']?>"><?php echo $baris['nama_pengujian']; ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md mt-4">
                                    <div class="form-group">
                                        <label for="mytextarea">Hal Lain</label>
                                        <textarea class="form-control" id="mytextarea" rows="4" name="hal_lain" placeholder="Hal Lain"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <input type="submit" class="btn btn-primary btn-sm" name="submit" value="Tambah">
                                    <a href="#" class="btn btn-danger btn-sm"><span class="fas fa-times fa-sm"></span> Batal</a>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <th>No</th>
                    <th>Nama Sampel </th>
                    <th>Kode Batch </th>
                    <th>Jumlah </th>
                    <th>Pemeriksaan </th>
                    <th>Aksi </th>
                </thead>
                <tbody>
                    <?php 
                    $id_auth = $this->session->userdata('id_auth');
                    $cari = $this->m_pelanggan->ambil_info_pelanggan($id_auth)->row();
                    $id_pelanggan = $cari->id_pelanggan; 
                    $no = 0; 
                    $query = "SELECT * FROM tmp_order_detail where id_pelanggan = '$id_pelanggan'";
                    $order_detail = $this->db->query($query)->result();
                    foreach ($order_detail as $od):
                    ?>
                        <tr>
                            <td><?php echo ++$no ?></td>
                            <td><?php echo $od->nama_sampel ?></td>
                            <td><?php echo $od->kode_batch ?></td>
                            <td><?php echo $od->jumlah ?></td>
                            <td>
                                <?php 
                                $p = $this->db->query("SELECT * FROM tmp_pemeriksaan join tmp_sampel ON tmp_pemeriksaan.id_sampel = tmp_sampel.id_sampel where  id_order_detail='{$od->id_order_detail}'")->result();
                                foreach ($p as $row){
                                    $nama=getName("pengujian","id_pengujian",$row->id_pengujian,"nama_pengujian");
				                    echo '-'.$nama.'<br>';
                                }
                                
                                ?>
                            </td>
                            <td style="text-align:center" width="50px">
                                <a href="#konfirmasi_hapus" class='btn btn-danger btn-sm' data-toggle='modal'  data-href="<?php echo base_url('c_registrasi_sampel/konfirmasi_hapus/'.$od->id_order_detail)?>"><i class="fas fa-trash"></i> </a>
                                 </td>
                        <tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php 
                if  ($no > 0){
            ?>
                <a href="<?php echo base_url('c_registrasi_sampel/selesai/'.$id_pelanggan) ?>" class="btn btn-success btn-sm"><span class="fas fa-check fa-sm"></span> Selesai Order</a>
            <?php } ?>
        </div>
    </div>
    <div class="modal fade" id="konfirmasi_hapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
				  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">x</span>
				  </button>
				</div>
				<div class="modal-body">Anda yakin ingin menghapus data ini...?</div>
				<div class="modal-footer">
				  <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
				  <a class="btn btn-danger btn-ok" href="#">Hapus</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(".sel").select2({
    placeholder: "Jenis Pemeriksaan"
        });

        tinymce.init({
        selector: '#mytextarea',
        height : 320, 
         });

// konfirmasi penghapusan sampel
    $(document).ready(function() {
        $('#konfirmasi_hapus').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    });

</script>





