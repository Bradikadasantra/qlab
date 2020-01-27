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
                <div class="card-body p-4">
                <small><i class="fas fa-id-card fa-fw"></i>  Password</small> <i class="fas fa-chevron-right fa-sm mx-2"></i> <small> Form Ubah Password</small>
                    <h4 class="text-dark mt-4"> Formulir Ubah Password</h4>
                    <h6 class="text-dark">Lengapi form di bawah untuk mengubah password </h6>
                    <form action="<?php echo $action;  ?>" method="post">
                        <div class="row mt-5">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="hidden" name="id_auth" value="<?php echo $this->session->userdata('id_auth') ?>">
                                    <label for="password_lama" class="text-dark"> Password Lama </label>
                                    <input type="text" class="form-control" name="password_lama" placeholder="Masukkan password lama" value="<?php echo set_value('password_lama') ?>">
                                    <?php echo form_error('password_lama','<small class="text-danger">','</small>') ?>
                                </div>

                                <div class="form-group">
                                    <label for="password_baru" class="text-dark"> Password Baru </label>
                                    <input type="password" class="form-control form-password" name="password_baru" id="password_baru" placeholder="Masukkan password baru" value="<?php echo set_value('password_baru') ?>">
                                    <?php echo form_error('password_baru','<small class="text-danger">','</small>') ?>
                                </div>

                                <div class="form-group">
                                    <label for="konfirm_pass_baru" class="text-dark"> Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control form-password" name="konfirm_pass_baru" id="konfirm_pass_baru" placeholder=" Konfirmasi password baru" value="<?php echo set_value('konfirm_pass_baru') ?>">
                                    <?php echo form_error('konfirm_pass_baru','<small class="text-danger">','</small>') ?>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input form-checkbox" id="checkbox">
                                    <label class="form-check-label" for="exampleCheck1"> Lihat Password</label>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo base_url('c_dashboard') ?>" class="btn btn-primary btn-sm mt-5"><i class="fas fa-angle-double-left fa-fw"></i> Kembali</a>
                        <button type="submit" class="btn btn-success btn-sm mt-5"><i class="fas fa-save fa-fw"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

		<script type="text/javascript">
        //fungsi yang digunakan untuk visible dan unvisible password
				$(document).ready(function(){		
					$('.form-checkbox').click(function(){
						if($(this).is(':checked')){
						$('.form-password').attr('type','text');
				}else{
				$('.form-password').attr('type','password');
			}
				});
			});

			window.onload = function () {
                document.getElementById("password_baru").onchange = validatePassword;
                document.getElementById("konfirm_pass_baru").onchange = validatePassword;
            }
            function validatePassword(){
                var pass2=document.getElementById("konfirm_pass_baru").value;
                var pass1=document.getElementById("password_baru").value;
                if(pass1!=pass2)
                    document.getElementById("konfirm_pass_baru").setCustomValidity("Password tidak cocok !");
                else
                    document.getElementById("konfirm_pass_baru").setCustomValidity('');
            }			
		</script>