
    <form action ="<?php echo $action;  ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" value="<?php echo $no_dokumen;?>" name="no_dokumen">
        <div class="form-group">
            <label for="file">Lampirkan Dokumen Revisi</label>
            <input type="file" class="form-control" name="file" id="file" required>
            <small>Dokumen harus berekstensi (.pdf)</small>
        </div>
        <div class="row">
            <div class="col-md mt-4">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-upload"></i> Upload</button>
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </form>
    