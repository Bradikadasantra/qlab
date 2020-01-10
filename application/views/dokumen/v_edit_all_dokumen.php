<div class="container-fluid">
    <div class="row">
    <style>
         .bu{
            color: #fff;
            display:none;
            }
    </style>
        <div class="col-md-12">
            <form action="<?php echo base_url('c_dokumen/action_edit_allDokumen') ?>" enctype="multipart/form-data" method="post">
                <?php foreach ($dokumen as $baris): ?>
                <div class="row">
                    <div class="col-md">   
                        <div class="form-group">
                            <label for="dokumen_induk"> Dokumen Induk</label>
                            <select class="form-control" name="dokumen_induk">
                                <?php 
                                    $kueri = $this->db->query("SELECT * FROM dokumen_induk")->result();
                                    $dok_in = $baris->id_dokumen_induk; 
                                    foreach ($kueri as $row):
                                    if ($dok_in == $row->id_dokumen_induk) { ?>
                                    <option value="<?php echo $row->id_dokumen_induk;?>" selected><?php echo $row->dokumen;  ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $row->id_dokumen_induk;  ?>"><?php echo $row->dokumen;  ?></option>
                                    <?php } endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jenis_dokumen"> Jenis Dokumen</label>
                            <select class="form-control" name="jenis_dokumen">
                            <?php 
                                    $kueri = $this->db->query("SELECT * FROM jenis_dokumen")->result();
                                    $jenis_dok = $baris->id_jenis_dokumen; 
                                    foreach ($kueri as $row):
                                    if ($jenis_dok == $row->id_jenis_dokumen) { ?>
                                    <option value="<?php echo $row->id_jenis_dokumen;?>" selected><?php echo $row->nama_dokumen; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $row->id_jenis_dokumen;?>"><?php echo $row->nama_dokumen; ?></option>
                             <?php } endforeach ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="nomor_dokumen"> Nomor Dokumen</label>
                            <input type="text" class="form-control" name="no_dokumen" id="no_dokumen" value="<?php echo $baris->no_dokumen;?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="nama_dokumen"> Nama Dokumen</label>
                            <input type="text" class="form-control" name="nama_dokumen" id="nama_dokumen" value="<?php echo $baris->nama_dok;?>">
                        </div>

                        <div class="form-group">
                            <label for="lokasi"> Lokasi</label>
                            <input type="text" class="form-control" name="lokasi" id="lokasi" value="<?php echo $baris->lokasi;?>">
                        </div> 
                    </div>

                    <div class="col-md">
                        <div class="form-group">
                            <label for="penyusun"> Penyusun</label>
                            <select class="form-control" name="penyusun" id="penyusun" onchange="isi_otomatis()">
                                <?php 
                                    $peny = $baris->id_penyusun;
                                    foreach ($user as $row):
                                        if ($peny == $row->id_admin){
                                ?>
                                <option value="<?php echo $row->id_admin; ?>" selected><?php echo $row->nama; ?></option>
                                        <?php } else { ?>
                                <option value="<?php echo $row->id_admin; ?>"><?php echo $row->nama; ?></option>
                                        <?php } endforeach;  ?>
                            </select>
                        </div>

                        <?php 
                            if ($baris->id_pemeriksa != null){
                        ?>
                        <div class="form-group">
                            <label for="pemeriksa"> Pemeriksa</label>
                            <select class="form-control" name="pemeriksa" id="pemeriksa" onchange="isi_otomatis2()">
                                <?php 
                                    $pemer = $baris->id_pemeriksa; 
                                    foreach ($user as $row):
                                        if ($pemer == $row->id_admin){
                                ?>
                                <option value="<?php echo $row->id_admin; ?>" selected><?php echo $row->nama; ?></option>
                                        <?php } else { ?>
                                <option value="<?php echo $row->id_admin; ?>"><?php echo $row->nama; ?></option>
                                        <?php } endforeach;  ?>
                            </select>
                        </div>
                        <?php } ?>

                        <?php 
                            if ($baris->id_pengesah != null){
                        ?>
                        <div class="form-group">
                            <label for="pengesah"> Pengesah</label>
                            <select class="form-control" name="pengesah" id="pengesah" onchange="isi_otomatis3()">
                                <?php 
                                    $pen = $baris->id_pengesah;
                                    foreach ($user as $row):
                                        if ($pen == $row->id_admin){
                                ?>
                                <option value="<?php echo $row->id_admin; ?>" selected><?php echo $row->nama; ?></option>
                                        <?php } else { ?>
                                <option value="<?php echo $row->id_admin; ?>"><?php echo $row->nama; ?></option>
                                <?php } endforeach;  ?>
                            </select>
                        </div>
                        <?php } ?>

                        <?php if ($baris->bidang != null) { ?>
                        <div class="form-group">
                            <label for="bidang"> Bidang</label>
                            <select class="form-control" name="bidang" id="bidang">
                                <?php 
                                    $kueri = $this->db->query("SELECT * FROM bidang")->result();
                                    $bid = $baris->bidang; 
                                    foreach ($kueri as $row):
                                        if ($bid == $row->id_bidang) {
                                ?>
                                <option value="<?php echo $row->id_bidang; ?>" selected><?php echo $row->nama_bidang; ?></option>
                                        <?php } else { ?>
                                <option value="<?php echo $row->id_bidang; ?>"><?php echo $row->nama_bidang; ?></option>
                                        <?php } endforeach;  ?>
                            </select>
                        </div>
                        <?php }  ?>

                        <div class="form-group row pt-3">
                            <div class="col-md-9">
                                <label for="ubah_dokumen"> Apakah ingin merubah dokumen ?</label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input myCheckbox"  type="checkbox" name="ubah_dokumen" id="ubah_dokumen" value="ya">
                                        <label class="form-check-label" for="ubah_dokumen">Ya</label>
                                </div>  
                            </div>
                        </div>   

                        <div class="form-group ya bu">
                            <input type="file" name="dokumen" class="form-control">
                        </div>

                        <input type="hidden" class="form-control" name="jabatan_penyusun"  id="hak_akses" value="<?php echo $baris->jabatan_penyusun; ?>">
                        <input type="hidden" class="form-control" name="jabatan_pemeriksa" id="hak_akses2" value="<?php echo $baris->jabatan_pemeriksa; ?>">
                        <input type="hidden" class="form-control"  name="jabatan_pengesah" id="hak_akses3" value="<?php echo $baris->jabatan_pengesah; ?>">
                    </div>
                </div>
                <?php endforeach;?>
                <div class="row mt-4">
                    <div class="col-md">
                        <button type="submit" class="btn btn-primary btn-sm"> <i class="fas fa-save fa-sm"></i> Simpan </button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </div>   
            </form>
        </div>
    </div>
</div>

<script>
   $(document).ready(function(){
        $('input.myCheckbox').click(function(){
        if($(this).prop('checked')) {
            $('.ya').show();
        }
        else{
            $('.ya').hide();
        }
    });
});

    function isi_otomatis(){
        var user = $("#penyusun").val();
        $.ajax({
            url: "<?php echo base_url('c_dokumen/ajax_user')?>",
            data:"user="+user ,
            method:"POST"
        }).done(function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#hak_akses').val(obj.hak_akses);
        });
    }

    function isi_otomatis2(){
        var user = $("#pemeriksa").val();
        $.ajax({
            url: "<?php echo base_url('c_dokumen/ajax_user')?>",
            data:"user="+user ,
            method:"POST"
        }).done(function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#hak_akses2').val(obj.hak_akses);
        });
    }

    function isi_otomatis3(){
        var user = $("#pengesah").val();
        $.ajax({
            url: "<?php echo base_url('c_dokumen/ajax_user')?>",
            data:"user="+user ,
            method:"POST"
        }).done(function (data) {
            var json = data,
            obj = JSON.parse(json);
            $('#hak_akses3').val(obj.hak_akses);
        });
    }
</script>