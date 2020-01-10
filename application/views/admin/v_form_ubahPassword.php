<div class="container-fluid">
    <div class="row">
        <div class="col-md-10">
        <?php
            if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
                echo '<div class="pesan">'.$_SESSION['pesan'].'</div>';
            }
                    // mengatur session pesan menjadi kosong
                    $_SESSION['pesan'] = '';
            ?>
            <div class="card">
                <div class="card-body">
                <small><i class="fas fa-id-card fa-fw"></i>  Password</small> <i class="fas fa-chevron-right fa-sm mx-2"></i> <small> Form Ubah Password</small>
                    <h4 class="text-dark mt-4"> Form Ubah Password</h4>
                    
                </div>
            </div>
        </div>
    </div>
</div>