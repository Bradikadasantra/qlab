
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

            <?php 
               $hak_akses = $this->session->userdata('hak_akses');
               $row = $this->m_admin->get_by_id('hak_akses','id_hak_akses', $hak_akses);
                ?>
               <div class="alert alert-info"><i class="fas fa-check fa-sm fa-fw text-success"></i> Selamat datang <b><?php echo $row->hak_akses; ?></b> di <i class="text-primary">SISTEM INFORMASI LABORATOIUM QLAB </i> FAKULTAS FARMASI, UNIVERSITAS PANCASILA</b></div>
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
        if ($hak_akses == 1){
      ?>
          <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Permintaaan Pengujian</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <?php 
                      $calculate = $this->db->query("SELECT * FROM `order` WHERE `status`= '0' ")->num_rows();
                      echo  $calculate; 
                      ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard fa-2x text-gray-300"></i>
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
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Konfirmasi Pembayaran</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <?php 
                      $calculate = $this->db->query("SELECT * FROM tagihan WHERE status_tagihan = '1' ")->num_rows();
                      echo  $calculate; 
                      ?>
                      </div>
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
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sertifikat</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                          <?php 
                            $calculate = $this->m_registrasi_sampel->view_sertifikat(array('status_tagihan'=>2), array('status_sampel !=' => 3))->num_rows();
                            echo  $calculate; 
                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-certificate fa-2x text-gray-300"></i>
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
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pelanggan</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                      <?php 
                      $calculate = $this->db->query("SELECT * FROM pelanggan ")->num_rows();
                      echo  $calculate; 
                      ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user fa-2x text-gray-300"></i>
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