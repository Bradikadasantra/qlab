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
            <div class="card">
                <div class="card-body">
                    <small><i class="fas fa-check fa-fw"></i> Konfirmasi pembayaran</small><br>
                    <hr>
                    <h4 class="text-dark mt-4">Konfirmasi Pembayaran</h4>
                    <small>Silahkan lengkapi form dibawah untuk melengkapi konfirmasi pembayaran anda</small>
                        <div class="row p-3 mt-5">
                            <div class="col-md-10">
                                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                        <label for="no_order"> No Order </label>
                                        </div>
                                        <div class="col-md-8">
                                            <select class="form-control" name="no_order"  id="no_order" onchange="isi_otomatis()">
                                            <option value="" selected> ~ Pilih No Order ~</option>
                                                <?php
                                                    foreach ($data as $baris):
                                                ?>
                                                    <option value="<?php echo $baris->no_tagihan; ?>"><?php echo $baris->no_order; ?></option>
                                                    <?php endforeach;  ?>
                                            </select>
                                            <?php echo form_error('no_order','<small class="text-danger">','</small>') ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                        <label for="nama_pengirim"> Nama Pemilik Rekening * </label>
                                        </div>
                                        <div class="col-md-8">
                                        <input type="text" class="form-control" name="nama_pengirim" id="nama_pengirim" value="<?php echo set_value('nama_pengirim')?>">
                                        <?php echo form_error('nama_pengirim','<small class="text-danger">','</small>') ?>
                                        </div>
                                    </div>  
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                        <label for="bank_pengirim"> Pembayaran dari Bank </label>
                                        </div>
                                        <div class="col-md-8">
                                        <select class="form-control" name="bank_pengirim" id="bank_pengirim">
                                        <option value="" selected>~ Pilih Bank</option>
                                            <?php 
                                            $kueri = $this->db->query("SELECT * FROM bank")->result();
                                            foreach ($kueri as $row): ?>
                                                <option value="<?php echo $row->id_bank; ?>"><?php echo $row->bank; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php echo form_error('bank_pengirim','<small class="text-danger">','</small>') ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                        <label for="jumlah_dana"> Jumlah Dana </label>
                                        </div>
                                        <div class="col-md-8">
                                        <input type="text" class="form-control" name="jumlah_dana" id="jumlah_dana" value="<?php echo set_value('jumlah_dana') ?>" readonly>
                                        <?php echo form_error('jumlah_dana','<small class="text-danger">','</small>') ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                        <label for="bukti_bayar"> Bukti Pembayaran </label>
                                        </div>
                                        <div class="col-md-8">
                                        <input type="file" class="form-control" name="bukti_bayar" id="bukti_bayar">
                                        <?php echo form_error('bukti_bayar','<small class="text-danger">','</small>') ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                        <label for="tgl_bayar"> Tanggal Pembayaran </label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar fa-sm"></i></span>
                                                </div>
                                                <input type="text" class="form-control datepicker-here" data-position="top left"  data-language="en" name="tgl_bayar" id="tgl_bayar" value="<?php echo set_value('tgl_bayar') ?>">
                                            </div>
                                            <?php echo form_error('tgl_bayar','<small class="text-danger">','</small>') ?>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-md">
                                            <a href="<?php echo base_url('c_dashboard')?>" class="btn btn-danger btn-sm"><i class="fas fa-times fa-sm"></i>  Batal</a>
                                            <button class="btn btn-primary btn-sm" type="submit" value="Konfirmasi"><i class="fas fa-check fa-sm"></i> Konfirmasi</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function isi_otomatis(){
        var no_order = $("#no_order").val();
        $.ajax({
            url: "<?php echo base_url('c_pelanggan/ajax_tagihan')?>",
            data:"no_order="+no_order ,
            method:"POST"
        }).done(function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#jumlah_dana').val(obj.jumlah_dana);
        });
    }
</script>

