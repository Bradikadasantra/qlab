<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?php 
                $no = 1; 
            foreach ($detail as $baris): ?>
            <div class="card mt-4 mb-3">
                <div class="card-header">
                    <h6 class=""> Data Sampel ke <?php echo $no++;  ?></h6>
                </div>
                <div class="card-body">
                    <form action="<?php echo base_url('c_registrasi_sampel/update_PermohonanSampel') ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                            <input type="hidden" name="id_order_detail" id="id_order_detail" value="<?php echo $baris->id_order_detail; ?>">
                                <div class="form-group">
                                    <label for="nama_sampel"> Nama Sampel</label>
                                        <input type="text" class="form-control" name="nama_sampel" id="nama_sampel" value="<?php echo $baris->nama_sampel; ?>">
                                        <?php echo form_error('nama_sampel','<small class="text-danger pl-3">','</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label for="pemerian"> Pemerian</label>
                                    <input type="text" class="form-control" name="pemerian" id="pemerian" value="<?php echo $baris->pemerian; ?>">
                                    <?php echo form_error('pemerian','<small class="text-danger pl-3">','</small>') ?>
                                </div>

                                <div class="form-group">
                                    <label for="kode_batch"> Kode Batch</label>
                                    <input type="text" class="form-control" name="kode_batch" id="kode_batch" value="<?php echo $baris->kode_batch; ?>">
                                    <?php echo form_error('kode_batch','<small class="text-danger pl-3">','</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah"> Jumlah</label>
                                    <input type="text" class="form-control" name="jumlah" id="jumlah" value="<?php echo $baris->jumlah; ?>" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kemasan"> Kemasan</label>
                                    <input type="text" class="form-control" name="kemasan" id="kemasan" value="<?php echo $baris->kemasan; ?>">
                                    <?php echo form_error('kemasan','<small class="text-danger pl-3">','</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label for="transportasi_sampel"> Transportasi Sampel</label>
                                    <input type="text" class="form-control" name="transportasi_sampel" id="transportasi_sampel" value="<?php echo $baris->transportasi_sampel; ?>">
                                    <?php echo form_error('transportasi_sampel','<small class="text-danger pl-3">','</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label for="tempat_penyimpanan"> Tempat Penyimpanan</label>
                                    <input type="text" class="form-control" name="tempat_penyimpanan" id="tempat_penyimpanan" value="<?php echo $baris->tempat_penyimpanan; ?>">
                                    <?php echo form_error('tempat_penyimpanan','<small class="text-danger pl-3">','</small>') ?>
                                </div>
                                <div class="form-group">
                                    <label for="hal_lain"> Hal Lain</label>
                                    <input type="text" class="form-control" name="hal_lain" id="hal_lain" value="<?php echo $baris->hal_lain; ?>">
                                    <?php echo form_error('hal_lain','<small class="text-danger pl-3">','</small>') ?>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md">
                                <a href="<?php echo base_url('c_pelanggan/tampil_riwayat') ?>"  class="btn btn-secondary btn-sm"> Batal</a>
                                <button type="submit" class="btn btn-primary btn-sm"> Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php endforeach;  ?>
        </div>
    </div>
</div>