 
 
 <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon mx-1">
			<img src="<?php echo base_url('image/logo_up.png') ?>">
        </div>
        <div class="sidebar-brand-text mx-1">laboratorium Qlab ganti</div>
      </a>

		<!-- Divider -->
		<hr class="sidebar-divider"><hr>
	  
<!--START MENU SUPER ADMIN-->
<?php 
    $hak_akses = $this->session->userdata('hak_akses');

    if ($hak_akses == 'Super Admin'){
 ?>

    <!-- Heading -->
		  <div class="sidebar-heading">
		Administrator
		</div>
      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('c_dashboard') ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard Admin</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Sampel</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Data Sampel:</h6>
            <a class="collapse-item" href="<?php echo base_url('c_permintaan_uji/approval_sa')?>">Permintaan Uji Sampel</a>
            <a class="collapse-item" href="#">Hasil Pengujian</a>
            <a class="collapse-item" href="#">Rekap Registrasi Sampel</a>
            </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-user"></i>
          <span>User</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manajemen User</h6>
            <a class="collapse-item" href="<?php echo base_url('c_admin/daftar_pelanggan'); ?>">Pelanggan</a>
            <a class="collapse-item" href="<?php echo base_url('c_admin/daftar_admin'); ?>">Admin</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('c_permintaan_uji/approve_konfirmasiBayar') ?>">
          <i class="fas fa-fw fa-check"></i>
          <span>Konfirmasi Pembayaran</span></a>
      </li>
	  
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('c_admin/daftar_aset') ?>">
          <i class="fas fa-fw fa-folder"></i>
          <span>Aset</span></a>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('c_bahan_uji') ?>">
          <i class="fas fa-fw fa-folder"></i>
          <span>Bahan</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-fw fa-award"></i>
          <span>Sertifikat</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('c_dokumen')?>">
          <i class="fas fa-fw fa-file-pdf"></i>
          <span>Dokumen Induk</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#laporan" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-book"></i>
          <span>Laporan</span>
        </a>
        <div id="laporan" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manajemen User</h6>
            <a class="collapse-item" href="#">Keuangan</a>
            <a class="collapse-item" href="#">Sampel</a>
          </div>
        </div>
      </li>
      <?php } ?>
<!--END MENU SUPER ADMIN-->

<!--START MENU PELANGGAN-->
    <?php 
      if ($hak_akses == 'pelanggan'){
    ?>
    	<!-- Heading -->
		<div class="sidebar-heading">
		Pelanggan
		</div>
        <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('c_pelanggan') ?>">
          <i class="fas fa-fw fa-home"></i>
          <span>Beranda</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Sampel</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url('c_registrasi_sampel');?>">Pedaftaran Sampel</a>
            <a class="collapse-item" href="<?php echo base_url('c_pelanggan/tampil_riwayat'); ?>">Riwayat</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('c_user/penawaran_harga') ?>">
          <i class="fas fa-fw fa-tag"></i>
          <span>Penawaran harga</span></a>
      </li>
      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('c_pelanggan/konfirmasi_pembayaran') ?>">
          <i class="fas fa-fw fa-check"></i>
          <span>Konfirmasi Pembayaran</span></a>
      </li>

      <?php } ?>
 <!--END MENU PELANGGAN--> 

<!--START MENU MANAJER TEKNIK-->
<?php
  if ($hak_akses == 'manajer_teknik'){
?>
	<!-- Heading -->
  <div class="sidebar-heading">
		Manajer Teknik
	</div>
        <!-- Nav Item - Dashboard -->
<li class="nav-item">
  <a class="nav-link" href="<?php echo base_url('c_dashboard') ?>">
    <i class="fas fa-fw fa-home"></i>
    <span>Beranda</span></a>
</li>

  <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Sampel</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url('c_permintaan_uji/approval_mt') ?>">Approval Permintaan Uji</a>
            <a class="collapse-item" href="<?php echo base_url('c_permintaan_uji/approve_HasilPemeriksaan') ?>">Approval Hasil Uji</a>
          </div>
        </div>
      </li>

<li class="nav-item">
  <a class="nav-link" href="<?php echo base_url('c_dokumen') ?>">
    <i class="fas fa-fw fa-file-pdf"></i>
    <span>Dokumen</span></a>
</li>
<?php 
  }
?>
<!--END MENU MANAJER TEKNIK-->


<!--START MENU TEKNIS/ANALIS-->
<?php 
  if ($hak_akses == 'analis'){
?>
  <!-- Nav Item - Dashboard -->
<li class="nav-item">
  <a class="nav-link" href="<?php echo base_url('c_dashboard') ?>">
    <i class="fas fa-fw fa-home"></i>
    <span>Beranda</span></a>
</li>

  <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Sampel</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url('c_permintaan_uji/approval_tek')?>">Sampel Siap Uji</a>
          </div>
        </div>
      </li>

<li class="nav-item">
  <a class="nav-link" href="<?php echo base_url('c_dokumen') ?>">
    <i class="fas fa-fw fa-file-pdf"></i>
    <span>Dokumen</span></a>
</li>
<?php } ?>
<!--END MENU TEKNIS-->


<!--START MENU ALL MANAJER-->
<?php
  if($hak_akses == 'manajer_mutu' or $hak_akses == 'manajer_operasional' or $hak_akses == 'manajer_puncak' or $hak_akses == 'penyelia'){
?>
<!-- Nav Item - Dashboard -->
<li class="nav-item">
  <a class="nav-link" href="<?php echo base_url('c_dashboard') ?>">
    <i class="fas fa-fw fa-home"></i>
    <span>Beranda</span></a>
</li>

<li class="nav-item">
  <a class="nav-link" href="<?php echo base_url('c_dokumen') ?>">
    <i class="fas fa-fw fa-file-pdf"></i>
    <span>Dokumen</span></a>
</li>
  <?php } ?>
<!--END MENU ALL MANAJER-->







 <!-- Divider -->
 <hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
</ul>
<!-- End of Sidebar -->