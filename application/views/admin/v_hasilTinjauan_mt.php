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
            <div class="row">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h6 class="text-light"> Form Tinjauan</h6>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo $action;  ?>" method="POST">
                            <input type="hidden"  name="id_sampel" value="<?php echo $id_sampel;  ?>">
                            <h5 class="text-dark pb-3"> Tinjauan Manajer Teknik</h5>
                            <div class="row ml-4 mt-3">
                                <div class="col-md-3">
                                    <p>1.  Kesiapan Teknik</p>
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"  value="Personel" <?php in_array('Personel', $cek) ? print 'checked' : ' ' ?> name="kesiapan_teknik[]" id="personel" <?php echo $disabled_mt; ?>>
                                        <label class="form-check-label" for="personel">
                                            Personel
                                        </label>
                                    </div> 
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Metode Qlab" <?php in_array('Metode Qlab', $cek) ? print 'checked' : ' ' ?> name="kesiapan_teknik[]" id="metode_qlab" <?php echo $disabled_mt; ?>>
                                        <label class="form-check-label" for="metode_qlab">
                                            Metode Qlab
                                        </label>
                                    </div> 
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"  value="Metode Pelanggan" <?php in_array('Metode Pelanggan', $cek) ? print 'checked' : ' ' ?> name="kesiapan_teknik[]" id="metode_pelanggan" <?php echo $disabled_mt; ?>>
                                        <label class="form-check-label" for="metode_pelanggan">
                                            Metode Pelanggan
                                        </label>
                                    </div> 
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Alat" <?php in_array('Alat', $cek) ? print 'checked' : ' ' ?> name="kesiapan_teknik[]" id="alat" <?php echo $disabled_mt; ?>>
                                        <label class="form-check-label" for="alat">
                                            Alat
                                        </label>
                                    </div> 
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="Bahan" <?php in_array('Bahan', $cek) ? print 'checked' : ' ' ?> name="kesiapan_teknik[]" id="bahan"<?php echo $disabled_mt; ?>>
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
                                        <input class="form-check-input" type="radio" name="kesimpulan" value="Dapat dilaksanakan" <?php if($cek_kesimpulan == 'Dapat dilaksanakan'){echo 'checked';} ?> id="dapat_dilaksanakan" <?php echo $disabled_mt; ?>>
                                        <label class="form-check-label" for="dapat_dilaksanakan">
                                            Dapat Dilaksanakan
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"  name="kesimpulan" value="Tidak dapat dilaksanakan" <?php if($cek_kesimpulan == 'Tidak dapat dilaksanakan'){echo 'checked';} ?> id="tidak_dapat_dilaksanakan" <?php echo $disabled_mt; ?>>
                                        <label class="form-check-label" for="tidak_dapat_dilaksanakan">
                                            Tidak dapat dilaksanakan
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kesimpulan" value="Dapat dilaksanakan dengan" <?php if($cek_kesimpulan == 'Dapat dilaksanakan dengan'){echo 'checked';} ?> id="dapat_dilaksanakan_dengan"<?php echo $disabled_mt; ?>>
                                        <label class="form-check-label" for="dapat_dilaksanakan_dengan">
                                            Dapat dilaksanakan dengan
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="3"  id="cb" name="catatan" placeholder="Catatan..."  <?php echo $disabled_mt; ?>><?php echo $catatan; ?></textarea>
                                        <?php echo form_error('kesimpulan','<small class="text-danger">','</small>') ?>
                                </div>
                                </div> 
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-6 offset-8">
                                    <p>Manajer Teknik <?php if($bidang == 'M'){echo 'Mikrobiologi';}else if($bidang == 'K'){echo 'Kimia';}else if($bidang == 'F'){echo 'Farmakologi';}else{echo ' ';} ?> </p>  <br><br><br>
                                    <p style="text-align:justify;">( <?php echo $nama;  ?> )</p>
                                </div>
                            </div>
                
                            <?php 
                            

                            $hm = $this->db->query("SELECT status_sampel FROM sampel WHERE id_sampel = '$id_sampel'")->row();
                            $status_sampel = $hm->status_sampel;
                                if ($status_sampel  == 4 OR $status_sampel == 5 ){
                            ?>
                            <h5 class="text-dark"> Persetujuan Pelanggan (Bila ada ketidaksesuaian dengan permintaan)</h5>
                            <div class="row mt-1">
                                <div class="col-md-10 mt-2">
                                    <div class="form-group">
                                      <textarea class="form-control" rows="6" placeholder ="Konfirmasi Pelanggan" <?php echo $disabled_textarea; ?>  name="konfirmasi_pelanggan"> <?php echo $konfirmasi_pelanggan ?></textarea>
                                      <?php echo form_error('konfirmasi_pelanggan','<small class="text-danger">','</small>') ?>
                                    </div>
                                </div>
                            </div>  
                            <div class="row mt-4">
                                <div class="col-md-5 offset-8">
                                    <p> Pelanggan</p><br><br><br>
                                    <p>  ( TTD Pelanggan )</p>
                                </div>
                            </div>
                                <?php } ?>
                                <a href="<?php echo $back;  ?>" class="btn btn-primary btn-sm"><span class="fas fa-arrow-alt-circle-left"></span> Kembali</a>
                                <?php 
                                    $debug = $this->db->query("SELECT status_sampel FROM sampel WHERE id_sampel = '$id_sampel'")->row();
                                if ($debug->status_sampel == 4)  {
                                    echo $submit_button; 
                                }else{
                                    echo " ";
                                } ?>
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