		
    <?php foreach($dokumen_form as $baris):?>
             <div class="col-md-12">
                <form action="<?php echo base_url('c_dokumen/update_dokumen_form'); ?>" enctype="multipart/form-data" method="post">
                    <div class="row">
                        <div class="col-md">
                            <input type="hidden" name="id_df" value="<?php echo $baris['id_df'] ?>"/>
                            <div class="form-group">
                                <label for="judul">Judul</label>
                                    <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $baris['judul']; ?>">
                            </div>	
                        
                             <div class="form-group">
                                    <label for="dokumen">Dokumen</label><br>
                                    <div> 
                                        <?php if($baris['nama_dokumen'] == 'Default.pdf' or $baris['nama_dokumen']  == null ){ ?>
                                            <img src="<?php echo base_url('assets/img/pdf.png') ?>" style="height:100px; width:100px; "/>
                                                <?php
                                                }else{
                                                ?>
                                            <embed src ="<?php echo base_url('dokumen_form/'.$baris['nama_dokumen']) ?>" style="height:150px; width:300px;">
                                            <?php
                                                    }
                                                    
                                            ?>
                                    </div>
                                    <?php
                                        $hak_akses = $this->session->userdata('hak_akses');
                                        if ($hak_akses == "admin_sampel") { ?>
                                    <p style="color:grey;">Maks 5 MB </p>
                                    <input type="checkbox" name="ubah_dokumen" value="True"><span style="font-weight:bold; padding-left:10px;">Cheklist !! If You Want Update Document</span><br><br>
                                    <input type="file" name="dokumen">
                                        <?php } ?>
                            </div>  
                        </div>
                        <div class="col-md">  
                            <div class="form-group">
                                <label for="type">Kode</label>
                                    <input type="text" class="form-control" id="kode" name="kode" value="<?php echo $baris['kode'] ?>">
                            </div>	
            
                            <div class="form-group">
                                <label for="lokasi">Lokasi</label>
                                    <input type="text" class="form-control" id="lokasi" name="lokasi" value="<?php echo $baris['lokasi']; ?>">
                            </div>	 
                             <?php $no = 1; 
                            foreach ($revisi as $row): ?>
                                <div class="form-group">
                                    <?php 
                                        if ($row['revisi'] == '0000-00-00')
                                        {}else{
                                    ?>
                                    <label for="revisi">Revisi <?php echo $no++; ?></label>
                                    <input type="text" class="form-control" readonly value="<?php echo date('d-m-Y', strtotime($row['revisi'])) ?>">
                                        <?php } ?>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <p><b> Dibuat : <?php echo date('d-m-Y', strtotime($baris['dibuat']))?></b></p>
                        </div>  
                    </div>
                    <?php
                        $hak_akses = $this->session->userdata('hak_akses');
                        if ($hak_akses == "admin_sampel") { ?>
                    <div class="row my-3">
                        <div class="col-md offset-6">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-save fa-sm"></i> Simpan</button>
                        </div>
                    </div>
                        <?php } ?>
                </form>
            </div>
            <?php endforeach; ?>
