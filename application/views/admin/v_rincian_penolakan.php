<div class="container-fluid">
    <?php foreach ($data as $baris): ?>
    <div class="row mt-4">
        <div class="col-md">
            <div class="card">
                <div class="card-body bg-light border-light">
                    <div class="row">
                        <div class="col-md-3">
                            <?php echo WKT($baris->tgl_dibuat); ?>
                        </div>
                        <div class="col-md-6 offset-2">
                            <?php echo $baris->catatan_penolakan; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>