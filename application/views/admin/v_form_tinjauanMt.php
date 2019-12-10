<div class="container-fluid">
    <div class="row">
       <div class="col-md-12">
            <div class="row">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h6 class="text-light"> Form Tinjauan</h6>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo $action;  ?>" method="POST">
                            <input type="hidden"  name="id_sampel" value="<?php echo $id_sampel;  ?>">
                            <input type="hidden"  name="id_admin" value="<?php echo $id_admin;  ?>">
                            <h5 class="text-dark pb-3"> Tinjauan Manajer Teknik</h5>
                            <div class="row ml-4 mt-3">
                                <div class="col-md-3">
                                    <p>1.  Kesiapan Teknik</p>
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"  value="Personel" name="kesiapan_teknik[]" id="personel">
                                        <label class="form-check-label" for="personel">
                                            Personel
                                        </label>
                                    </div> 
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Metode Qlab" name="kesiapan_teknik[]" id="metode_qlab">
                                        <label class="form-check-label" for="metode_qlab">
                                            Metode Qlab
                                        </label>
                                    </div> 
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"  value="Metode Pelanggan" name="kesiapan_teknik[]" id="metode_pelanggan">
                                        <label class="form-check-label" for="metode_pelanggan">
                                            Metode Pelanggan
                                        </label>
                                    </div> 
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Alat" name="kesiapan_teknik[]" id="alat" >
                                        <label class="form-check-label" for="alat">
                                            Alat
                                        </label>
                                    </div> 
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Bahan" name="kesiapan_teknik[]" id="bahan" >
                                        <label class="form-check-label" for="bahan">
                                            Bahan
                                        </label>
                                    </div>
                                    <?php echo form_error('kesiapan_teknik[]','<small class="text-danger">','</small>') ?>
                                </div>
                            </div>
                            <div class="row ml-4 mt-5">
                                <div class="col-md-3">
                                    <p>2.   Kesimpulan</p>
                                </div> 
                                <div class="col-md-5">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kesimpulan" value="Dapat dilaksanakan" id="dapat_dilaksanakan">
                                        <label class="form-check-label" for="dapat_dilaksanakan">
                                            Dapat Dilaksanakan
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"  name="kesimpulan" value="Tidak dapat dilaksanakan" id="tidak_dapat_dilaksanakan">
                                        <label class="form-check-label" for="tidak_dapat_dilaksanakan">
                                            Tidak dapat dilaksanakan
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kesimpulan" value="Dapat dilaksanakan dengan" id="dapat_dilaksanakan_dengan">
                                        <label class="form-check-label" for="dapat_dilaksanakan_dengan">
                                            Dapat dilaksanakan dengan
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="3"  id="cb" name="catatan" placeholder="Catatan..."></textarea>
                                        <?php echo form_error('kesimpulan','<small class="text-danger">','</small>') ?>
                                </div>
                                </div> 
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-6 offset-8">
                                    <p>Manajer Teknik <?php echo $bidang; ?> </p>  <br><br><br>
                                    <p style="text-align:justify;">( <?php echo $nama;  ?> )</p>
                                </div>
                            </div>            
                                <a href="<?php echo $back;  ?>" class="btn btn-primary btn-sm"><span class="fas fa-arrow-alt-circle-left"></span> Kembali</a>
                                <input type="submit" class="btn btn-success btn-sm" name="submit" value="Submit">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </div>
    <script>    
        $(document).ready(function() {
            // Kondisi saat Form di-load
            if($('input:radio[name=kesimpulan]:checked').val() ==" "){
                $('#cb').removeAttr('disabled');
            } else {
                $('#cb').attr('disabled','disabled'); 
            }
            // Kondisi saat Radio Button diklik
            // $('input[type="radio"]').click(function(){
                $('input[name=kesimpulan]:radio').click(function(){
                if($(this).attr("value")=="Dapat dilaksanakan dengan" ){
                    $('#cb').removeAttr('disabled');
                    $('#cb').focus();
                } else {
                    $('#cb').attr('disabled','disabled'); 
                    $('#cb').val('');
                } 
            });
        }); 
    </script>
</div>