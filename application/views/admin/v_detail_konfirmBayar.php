
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <form action="#" method="post">
                <?php foreach ($data as $baris): ?>
                <div class="row">
                    <div class="col-md">
                        <div class="form-group">
                            <label for="no_invoice">No Invoice</label>
                            <input type="text" class="form-control" id="no_order" value="<?php echo $baris->no_tagihan?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="no_order">No Order</label>
                            <input type="text" class="form-control" id="no_order" value="<?php echo $baris->no_order;?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="pemilik_rekening">  Pemilik Rekening</label>
                            <input type="text" class="form-control"  id="pemilik_rekening" value="<?php echo $baris->pemilik_rekening; ?>" readonly>
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="form-group">
                            <label for="jumlah">Jumlah Tagihan</label>
                            <input type="text" class="form-control" id="jumlah" value="<?php echo rupiah($baris->jumlah); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="bank">Bank</label>
                            <input type="text" class="form-control" id="bank" value="<?php echo $baris->bank ?>" readonly>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md">
            <p><strong>Tanggal bayar : </strong><?php echo WKT($baris->tgl_byr);  ?></p>
            <p><strong>Tanggal Order : </strong><?php echo WKT($baris->tgl_order);  ?></p>
            <a href="<?php echo base_url('c_permintaan_uji/detail_permintaan/'.$baris->no_order)?>" class="btn btn-primary btn-sm"><i class="fas fa-eye fa-sm"></i> Detail Order</a>
        </div>
        <div class="col-md">
            <p><strong>Status Tagihan : </strong><?php echo StatusTagihan($baris->status_tagihan);  ?></p>
        </div>
    </div>
</div>