 <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light topbar mb-3 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

    
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
            <!-- Nav Item - Alerts -->
            <li class="nav-item">
                <i class="fas fa-calendar-alt fa-fw mt-4 my-1"></i> <span class="text-gray-800" style="font-size:13px;"><?php echo WKT(date('Y-m-d')); ?></span> 
            </li>
            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $this->session->userdata('email');?></span>
                  <!-- pelanggan -->
                <?php 
                  $hak_akses = $this->session->userdata('hak_akses');
                  
                  if ($hak_akses == 12){
                    $cari_pel = $this->m_admin->cari_pelangganAuth(array('auth.id_auth'=> $this->session->userdata('id_auth')))->row();
                    $foto_pel = $cari_pel->foto; 
                      if ($foto_pel == 'Default.jpg'){
                ?>
                <img class="img-profile rounded-circle" src="<?php echo base_url('assets/img/user1.jpg') ?>">
                      <?php } else { ?>
                <img class="img-profile rounded-circle" src="<?php echo base_url('photo/'.$foto_pel) ?>">
                      <?php } } else { ?>
                
                <!-- not pelanggan -->
                <?php  
                    $cari_ad = $this->m_admin->cari_adminAuth(array('auth.id_auth'=> $this->session->userdata('id_auth')))->row();
                    $foto_adm = $cari_ad->foto; 
                    if ($foto_adm == 'Default.jpg'){ ?>
                      <img class="img-profile rounded-circle" src="<?php echo base_url('assets/img/user1.jpg') ?>">
                      <?php } else { ?>
                        <img class="img-profile rounded-circle" src="<?php echo base_url('photo/'.$foto_adm) ?>">
                        <?php } } ?> 
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                
                <?php 
                  if ($this->session->userdata('hak_akses') == 12){
                ?>
                <a class="dropdown-item" href="<?php echo base_url('c_pelanggan/form_editProfil') ?>">
                  <?php } else { ?>
                <a class="dropdown-item" href="<?php echo base_url('c_admin/form_editProfil') ?>">
                  <?php } ?>
                  <i class="fas fa-id-card fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profil
                </a>

                <?php 
                  if ($this->session->userdata('hak_akses') == 12){
                ?>
                <a class="dropdown-item" href="<?php echo  base_url('c_pelanggan/ubah_password')?>">
                  <?php } else { ?>
                <a class="dropdown-item" href="<?php echo  base_url('c_admin/ubah_password')?>">
                  <?php } ?>
                  <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                  Password
                </a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Keluar
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->