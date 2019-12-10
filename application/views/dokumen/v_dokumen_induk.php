<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
            <?php foreach ($dokumen as $baris):
                ?>
                <div class="col-md-3 my-2">
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