
    <div class="container-fluid">
        <div class="row">
            <div class="col-md">
                <form action="<?php echo base_url('c_permintaan_uji/action_editHasilPemeriksaan') ?>" method="post">
                        <div class="form-group">
                        <input type="hidden" value="<?php echo $kode;?>" name="kode">
                        <input type="hidden" value="<?php echo $id_sampel;  ?>" name="id_sampel">
                        <input type="hidden" value="<?php echo $id_hasil_pemeriksaan; ?>" name="id_hasil_pemeriksaan">
                        <label for="pemeriksaan">Pemeriksaan</label>
                            <select class="form-control" name="id_pemeriksaan"  readonly>
                                <option selected><?php echo $pengujian;  ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hasil_pemeriksaan"> Hasil Pemeriksaan</label>   
                            <input type="text" class="form-control" id="hasil_pemeriksaan" name="hasil_pemeriksaan" value="<?php echo $hasil_pemeriksaan?>">
                        </div>          
                        <div id="tampil" class="mt-2 mb-2"></div>
                        <button type="submit" class="btn btn-primary btn-sm mt-3"><i class="fas fa-save fas-sm"></i> Simpan</button>
                    </form>
            </div>
        </div>
    </div>
    
