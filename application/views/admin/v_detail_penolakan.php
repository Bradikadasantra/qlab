<div class="row">
    <div class="col-md-12">
        <form>
        <?php foreach ($pemeriksaan as $baris) : ?>
          
            <div class="form-group">
                <label for="no_sampel"> No Sampel </label>
                <input type="text" class="form-control  " name="no_sampel" id="no_sampel" value="<?php echo $baris->no_sampel ?>">
            </div>

            <div class="form-group">
                <label for="pemeriksaan"> Pemeriksaan </label>
                <input type="text" class="form-control" name="pemeriksaan" id="pemeriksaan" value="<?php echo getName('pengujian', 'id_pengujian',$baris->id_pengujian, 'nama_pengujian') ?>">
            </div>

            <div class="form-group">
                <label for="alasan"> Alasan Penolakan </label>
                <textarea class="form-control" name="alasan"  rows="9" id="alasan"><?php echo $baris->alasan; ?></textarea>
            </div>
        <?php endforeach; ?>
        </form>
    </div>
</div>