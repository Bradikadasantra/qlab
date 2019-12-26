<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2 mb-2">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <i class="far fa-file"  style="font-size:50px;"></i>
                        </div>
                        <a class="card-footer bg-light small text-center" href="<?php echo base_url('c_dokumen/form_upload')?>">
                            <span class="text-center"> Upload Baru</span>
                        </a>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                          <i class="fas fa-search"  style="font-size:50px;"></i>
                        </div>
                        <a class="card-footer bg-light small text-center" href="<?php echo base_url('c_dokumen/periksa_dokumen') ?>">
                            <span class="text-center"> Periksa Dokumen</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
        <h5 class="text-dark p-2"> Dokumen Induk</h5>
            <div class="row">
            <?php foreach ($dokumen as $baris):
                ?>
                <div class="col-md-2 my-2">
                    <div class="card text-white <?php echo $baris['background'] ?> o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                        <i class="<?php echo $baris['icon'];?> mb-3" style="font-size:50px;"></i><h4>12</h4>
                        </div>
                        <div><?php echo $baris['dokumen'];?></div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1 <?php echo $baris['background'] ?>" href="<?php echo base_url($baris['url']) ?>">
                        <span class="float-left">Daftar Dokumen</span>
                        <span class="float-right">
                        <i class="fas fa-angle-right"></i>
                        </span>
                    </a>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>