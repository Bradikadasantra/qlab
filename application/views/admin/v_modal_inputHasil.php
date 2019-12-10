
    <div class="container-fluid">
        <div class="row">
            <div class="col-md">
                <form action="<?php echo base_url('c_permintaan_uji/action_inputHasilPemeriksaan') ?>" method="post">
                        <div class="form-group">
                        <input type="hidden" name="kode" value="<?php echo $kode;  ?>">
                        <input type="hidden" value="<?php echo $id_sampel; ?>" name="id_sampel">
                        <label for="pemeriksaan">Pemeriksaan</label>
                            <select class="form-control" name="id_pemeriksaan" required>
                            <?php
                            foreach ($data as $baris):
                                $nama_pengujian = getName('pengujian','id_pengujian', $baris->id_pengujian, 'nama_pengujian');
                            ?>
                                <option value="<?php echo $baris->id_pemeriksaan; ?>"><?php echo $nama_pengujian;  ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hasil_pemeriksaan"> Hasil Pemeriksaan</label>   
                            <div class="input-group">    
                                <input type="text" class="form-control" name="hasil_pemeriksaan[]" required>
                                <div class="input-group-append">
                                    <button type="button" id="add" class="btn btn-primary btn-sm"><i class="fas fa-plus fa-sm"></i></button> 
                                </div>
                            </div> 
                        </div>          
                        <div id="tampil" class="mt-2 mb-2"></div>
                        <button type="submit" class="btn btn-primary btn-sm mt-3"><i class="fas fa-save fas-sm"></i> Simpan</button>
                    </form>
            </div>
        </div>
    </div>
    <script>
    var max = 4;
    var i = 1; 
        $(document).ready(function(e){
    $('#add').click(function(e){    
        if (i < max){  
          $('#tampil').append(
            '<div class="form-group add-row">'+
            '<label for="hasil_pemeriksaan">'+'Hasil Pemeriksaan'+'</label>'+
                    '<div class="input-group">'+
                        '<input type="text" name="hasil_pemeriksaan[]" class="form-control" required>'+
                        '<div class="input-group-append">'+
                        '<button type="button" class="btn btn-danger btn-sm remove"><i class="fas fa-minus fa-sm"></i></button>'+
                        '</div>'+
                '</div>'+
            '</div>'
            );
                i++;
        }else{
        alert('datalebih');
        }
    });
    $('#tampil').on('click','.remove',function(e){
       $(this).parents('.add-row').remove();
       i--;
    })
});
        
    </script>
