<html>
    <head>
        <script src	="<?php echo base_url()?>assets/tinymce/tinymce.min.js"></script>
    </head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="<?php echo $action; ?>" method="post">
                    <div class="form-group"> 
                        <input type="hidden" value="<?php echo $kode; ?>" name="kode">
                        <input type="hidden" name="id_sampel" value="<?php echo $id_sampel;?>">
                        <label for="catatan">Catatan </label>
                        <textarea id="mytextarea" name="catatan_penolakan"></textarea>
                    </div>
                        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-primary btn-sm" value="kirim">
                </form>
            </div>
        </div>
    </div>
    <script>
        tinymce.init({
        selector: '#mytextarea',
        height : 320, 
         });
    </script>
</body>
</html>