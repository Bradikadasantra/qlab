<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary">
                    <h6 class="text-light"> Form Penolakan</h6>
                </div>
                <div class="card-body">
                    <form action="<?php echo base_url ('c_permintaan_uji/insert_penolakan') ?>" method="POST">
                            <?php foreach($sampel as $baris): ?>    
                        <input type="hidden" name="id_pemeriksaan" value="<?php echo $baris->id_pemeriksaan?>">
                        <div class="form-group">
                            <label for="id_sampel"> No Sampel</label>
                                <input type="text" class="form-control" value="<?php echo $baris->no_sampel ?>" readonly>
                            </div>
                        <div class="form-group">
                            <label for="pemeriksaan"> Pemeriksaan</label>
                                <input type="text" class="form-control" value="<?php echo getName('pengujian','id_pengujian',$baris->id_pengujian, 'nama_pengujian') ?>" readonly>
                            </div>
                            <?php endforeach; ?>
                        <div class="form-group">
                            <label for="alasan"> Alasan Penolakan</label>
                                <textarea name="alasan" id="alasan" rows="4" placeholder="Alasan Penolakan" class="form-control"></textarea>
                        </div>
                        <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-times fa-sm"></i> Batal</a>  
                        <button class="btn btn-primary btn-sm mt-2 mb-2"><i class="fas fa-check fa-sm"></i> Kirim</button>    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>