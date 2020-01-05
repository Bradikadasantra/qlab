<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-10 offset-1">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h5 class="text-light">Lengkapi data anda !!</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo base_url('c_dashboard/action_lengkapi_data') ?>" method="post">
                                <div class="row mx-2">
                                        <div class="col-md">
                                            <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                                <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Masukkan Alamat" value="<?php echo set_value('alamat') ?>">
                                                <?php echo form_error('alamat','<small class="text-danger">','</small>') ?>
                                            </div>
                
                                            <div class="form-group">    
                                            <label for="no_telp">No Telepon</label>
                                                <input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="Masukkan no telepon" value="<?php echo set_value('no_telp') ?>">
                                                <?php echo form_error('no_telp','<small class="text-danger">','</small>') ?>
                                            </div>  
                                        </div>  
                                        <div class="col-md">
                                            <div class="form-group">
                                            <label for="instansi"> Instansi</label>
                                                <input type="text" class="form-control" name="instansi" id="instansi" placeholder="Masukkan nama instansi" value="<?php echo set_value('instansi') ?>">
                                                <?php echo form_error('instansi','<small class="text-danger">','</small>') ?>
                                            </div>

                                            <div class="form-group">    
                                            <label for="alamat_instansi">Alamat Instansi</label>
                                                <input type="text" class="form-control" name="alamat_instansi" id="alamat_instansi" placeholder="Masukkan Alamat Instansi" value="<?php echo set_value('alamat_instansi') ?>">
                                                <?php echo form_error('alamat_instansi','<small class="text-danger">','</small>') ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-md">
                                            <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-save fa-sm"></i> Simpan </button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>