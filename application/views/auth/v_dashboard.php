
        <!-- Begin Page Content -->
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
          <!-- Page Heading -->
			  <h2 class="h3 mb-1">
            <?php 
               $hak_akses = $this->session->userdata('hak_akses');
               if ($hak_akses == 'Super Admin'){
                 echo "Dasboard";
               }else{
                 echo "Selamat Datang";
               }
            ?>
        </h2>
        <h5>
          <?php
          echo $this->session->userdata('email').'&nbsp'.'<small>('.$this->session->userdata('hak_akses').')</small>';  
          ?>
        </h5>
			<div class="row">
				<div class="col-md-12 mb-4">
					<div class="selamat_datang border-left-primary">
					<h2>Sistem Informasi Pengelolaan laboratorium Qlab</h2>
					<h3>Fakultas Farmasi Universitas Pancasila<h3>
					</div>
				</div>
			</div>

			<!-- Content Row -->
      <?php 
        if ($hak_akses == 'Super Admin'){
      ?>
          <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Permintaaan Pengujian</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">40 Permintaan</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Keuangan</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Data Aset</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">120 Aset</div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Sertifikat</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">18 Menunggu Approve</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-certificate fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
 
          <!-- Content Row -->
          <?php } ?>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
   



   <script>
//   angka 500 dibawah ini artinya pesan akan muncul dalam 0,5 detik setelah document ready
    	$(document).ready(function(){setTimeout(function(){$(".pesan").fadeIn('slow');}, 800);});
//         angka 3000 dibawah ini artinya pesan akan hilang dalam 3 detik setelah muncul
    	 setTimeout(function(){$(".pesan").fadeOut('slow');}, 8000);
    </script>     