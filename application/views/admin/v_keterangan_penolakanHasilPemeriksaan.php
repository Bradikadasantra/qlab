<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <form action="<?php echo $action; ?>" method="post">
                <div class="form-group">
                    <label id="id_hasil"> ID Hasil</label>
                        <input type="text" class="form-control" name="id_hasil" id="id_hasil" value="<?php echo $id_hasil;?>" readonly>
                </div>
                <div class="form-group">
                    <label id="Pemeriksaan">Pemeriksaan</label>
                        <input type="text" class="form-control" name="pemeriksaan" id="pemeriksaan" value="<?php echo $pemeriksaan; ?>" readonly>
                </div>
                <div class="form-group">
                    <label id="hasil_pemeriksaan">Hasil Pemeriksaan</label>
                        <input type="tet" class="form-control" name="hasil_pemeriksaan" id="hasil_pemeriksaan" value="<?php echo $hasil_pemeriksaan ?>" readonly>
                </div>

                <div class="form-group">
                    <label id="keterangan">Keterangan Penolakan</label>
                      <textarea cols="4" rows="4" name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan Penolakan"><?php echo $keterangan;  ?></textarea>
                </div>

                <div class="modal-footer">
                   <?php echo $simpan; ?>
                   <a href="<?php  $batal; ?>" class="btn btn-danger btn-sm"> Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>