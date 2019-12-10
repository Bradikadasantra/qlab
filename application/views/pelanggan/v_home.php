
<div class="container-fluid">
<div class="row my-3">
	<div class="col-md">
		<?php
			if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
			echo '<div class="pesan">'.$_SESSION['pesan'].'</div>';
			}
			// mengatur session pesan menjadi kosong
			$_SESSION['pesan'] = '';
		?>
		</div>
	</div>
	<div class="row">
		<div class="col-md">
			<h3><b>Selamat Datang di laman Pendaftaran Uji Sampel Laboratorium Qlab</b></h3>
			<h4>Fakultas Farmasi Universitas Pancasila</h4>
		</div>
	</div>
	<div class="row mb-5 mt-3">
		<div class="col-md-12" style="float:left;">
			<h4><b><?php  echo $this->session->userdata('email');?></b></h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md">
			 <div class="card mb-4">
                <div class="card-header center">
                  Data Customer
                </div>
                <div class="card-body">
					
                </div>
              </div>
		</div>
		<div class="col-md">
			 <div class="card mb-4">
                <div class="card-header center">
                <i class="fas fa-fw fa-info"></i> Data Customer
                </div>
                <div class="card-body">
					
                </div>
              </div>
		</div>
	</div>
</div>
<script>
//   angka 500 dibawah ini artinya pesan akan muncul dalam 0,5 detik setelah document ready
    	$(document).ready(function(){setTimeout(function(){$(".pesan").fadeIn('slow');}, 800);});
//         angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
    	 setTimeout(function(){$(".pesan").fadeOut('slow');}, 8000);
    </script>