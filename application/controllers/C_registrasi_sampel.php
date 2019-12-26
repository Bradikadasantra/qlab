<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_registrasi_sampel extends CI_Controller {

    public function __construct(){
		parent:: __construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('templates');
        $this->load->model('m_registrasi_sampel');
        $this->load->model('m_pelanggan');
        $this->load->model('m_admin');
    }

    public function index(){       
        $K ='K'; $M = 'M'; $F = 'F';
        $data['kimia'] = $this->m_registrasi_sampel->pengujian($K)->result_array();
        $data['mikrobiologi'] = $this->m_registrasi_sampel->pengujian($M)->result_array();
        $data['farmakologi'] = $this->m_registrasi_sampel->pengujian($F)->result_array();
        $data['no_order'] = getNota("`order`", "no_order", "OR-");

        $id_auth = $this->session->userdata('id_auth');
        $data['pelanggan'] = $this->m_pelanggan->ambil_info_pelanggan($id_auth)->result_array();
        $this->templates->utama('pelanggan/v_registrasi_sampel_2', $data);
    }


//mulai dari sini functon untuk registrasi sampel 
  public function registrasi (){
    $K ='K'; $M = 'M'; $F = 'F';
    $data['kimia'] = $this->m_registrasi_sampel->pengujian($K)->result_array();
    $data['mikrobiologi'] = $this->m_registrasi_sampel->pengujian($M)->result_array();
    $data['farmakologi'] = $this->m_registrasi_sampel->pengujian($F)->result_array();
    $data['no_order'] = getNota("`order`", "no_order", "OR-");
    $id_auth = $this->session->userdata('id_auth');

    $data['pelanggan'] = $this->m_pelanggan->ambil_info_pelanggan($id_auth)->result_array();
    $this->templates->utama('pelanggan/v_registrasi_sampel_2', $data);
  }


  public function tambah_pemerian(){
    $pemerian =$this->input->post('pemerian');

    $cek = $this->db->query("SELECT * FROM pemerian WHERE pemerian = '$pemerian'")->num_rows();
    if ($cek > 0 ){
      echo $this->session->set_flashdata('pesan', 
      '<script>
         swal({
         title: "Failed",
         text: "nama ini sudah ada",
        type: "warning",
     });
     </script>');
    }else{
    $data = array(
      'pemerian' => $pemerian
    );
    $run = $this->m_registrasi_sampel->insert($data, 'pemerian');
      if ($run = 1){
        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong> 1 Data pemerian berhasil ditambahkan</strong></div>');
      }else{
        $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>1 Data pemerian gagal di tambahkan </strong></div>');
      }
    }
      redirect('c_registrasi_sampel');
  }

  public function tambah_kemasan(){
    $kemasan =$this->input->post('kemasan');

    $cek = $this->db->query("SELECT * FROM kemasan WHERE kemasan = '$kemasan'")->num_rows();

    if ($cek > 0){
      echo $this->session->set_flashdata('pesan', 
      '<script>
         swal({
         title: "Failed",
         text: "nama ini sudah ada",
        type: "warning",
     });
     </script>');
    }else{
    $data = array(
      'kemasan' => $kemasan
    );
    $run = $this->m_registrasi_sampel->insert($data, 'kemasan');
    
      if ($run = 1){
        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong> 1 Data kemasan berhasil ditambahkan</strong></div>');
      }else{
        $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>1 Data kemasan gagal di tambahkan </strong></div>');
      }
    }
      redirect('c_registrasi_sampel');
  }

  public function tambah_transportasi(){
    $trans =$this->input->post('transportasi_sampel');

    $cek = $this->db->query("SELECT * FROM transportasi_sampel WHERE transportasi_sampel = '$trans'")->num_rows();
    if ($cek > 0){
      echo $this->session->set_flashdata('pesan', 
      '<script>
         swal({
         title: "Failed",
         text: "nama ini sudah ada",
        type: "warning",
     });
     </script>'); 
    }else{
    $data = array(
      'transportasi_sampel' => $trans
    );
    $run = $this->m_registrasi_sampel->insert($data, 'transportasi_sampel');
    
      if ($run = 1){
        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong> 1 Data transportasi sampel berhasil ditambahkan</strong></div>');
      }else{
        $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>1 Data transportasi gagal di tambahkan </strong></div>');
      }
    }
      redirect('c_registrasi_sampel');
  }
  

  public function insert_sampel_2(){
    $this->form_validation->set_rules('nama_sampel','Nama Sampel','required|trim', array('required'=>'Nama sampel tidak boleh kosong...!'));
    $this->form_validation->set_rules('pemerian','Pemerian','required|trim', array('required'=>'Pemerian tidak boleh kosong...!'));
    $this->form_validation->set_rules('kode_batch','Kode Batch','required|trim', array('required'=>'Kode Batch tidak boleh kosong...!'));
    $this->form_validation->set_rules('kemasan','Kemasan','required|trim', array('required'=>'Kemasan tidak boleh kosong...!'));
    $this->form_validation->set_rules('transportasi_sampel','Transportasi Sampel','required|trim', array('required'=>'Transporatasi sampel tidak boleh kosong...!'));
    $this->form_validation->set_rules('tempat_penyimpanan','Tempat Penyimpanan','required|trim', array('required'=>'Tempat penyimpanan tidak boleh kosong...!'));
    $id_auth = $this->session->userdata('id_auth');
    $cari = $this->m_pelanggan->ambil_info_pelanggan($id_auth)->row();
    $id_pelanggan = $cari->id_pelanggan; 

    $nama_sampel = $this->input->post('nama_sampel');
    $kode_batch  = $this->input->post('kode_batch');
    $valid = $this->db->query("SELECT * FROM tmp_order_detail WHERE nama_sampel ='$nama_sampel' AND id_pelanggan = '$id_pelanggan' AND kode_batch = '$kode_batch'")->num_rows();
  
    if ($this->form_validation->run() == false){
        if ($this->input->post('submit')){
          if ($this->input->post ('kimia[]') == 0 and $this->input->post('mikrobiologi[]') == 0  and $this->input->post('farmakologi[]') == 0){
            echo $this->session->set_flashdata('pesan', 
            '<script>
                swal({
                title: "Pengujian Tidak Boleh Kosong",
                text: "Pengujian wajib diisi",
                type: "warning",
                });
            </script>');
          }  
        }
        $this->index();
      }
   else if($valid > 0){  
            echo $this->session->set_flashdata('pesan', 
            '<script>
                swal({
                title: "FAILED",
                text: "Duplikat Sampel",
                type: "warning",
                });
            </script>');
            $this->index();
    }
    else{
    $data_order_detail = array (
      'id_pelanggan'        => $id_pelanggan, 
      'nama_sampel'         => $this->input->post('nama_sampel'),
      'pemerian'            => $this->input->post('pemerian'),
      'kode_batch'          => $this->input->post('kode_batch'),
      'jumlah'              => $this->input->post('jumlah'),
      'kemasan'             => $this->input->post('kemasan'),
      'transportasi_sampel' => $this->input->post('transportasi_sampel'),
      'tempat_penyimpanan'  => $this->input->post('tempat_penyimpanan'),
      'hal_lain'            => $this->input->post('hal_lain')
    );

    $this->m_registrasi_sampel->insert($data_order_detail, 'tmp_order_detail');
    $id_order_detail = $this->db->insert_id();

    //inser data pengujian kimia
     $K = $this->input->post('kimia');
     $jumlah_dipilihK = count($K);
     if ($jumlah_dipilihK > 0){
        $no_sampel = getNoSampel("K");
        $data_sampel = array(
          'id_order_detail'   => $id_order_detail,
          'id_bidang'         => "K",
          'no_sampel'         => "0",
          'status_sampel'     => StatusSampel(0),
          'status_sertifikat' => StatusSertifikat(0),
          'tanggal'           => date('Y-m-d')
        );

    $this->m_registrasi_sampel->insert($data_sampel, 'tmp_sampel');        
     }

    $id_sampel = $this->db->insert_id();
    for ($x=0; $x<$jumlah_dipilihK; $x++){
      $id_pengujian = $K[$x];

      $biaya_pemeriksaan=getName("pengujian","id_pengujian",$id_pengujian,"biaya");
				 $data_pemeriksaan = array(
					'id_sampel' => $id_sampel,
					'id_pengujian' => $id_pengujian,
					'biaya_pemeriksaan' => $biaya_pemeriksaan,
					);
				  $this->m_registrasi_sampel->insert($data_pemeriksaan, "tmp_pemeriksaan");
    }

    // insert data pengujian Mikrobiologi
    $M = $this->input->post('mikrobiologi');
    $jumlah_dipilihM = count($M);
    if ($jumlah_dipilihM > 0){
       $no_sampel = getNoSampel("M");
       $data_sampel = array(
         'id_order_detail'   => $id_order_detail,
         'id_bidang'         => "M",
         'no_sampel'         => "0",
         'status_sampel'     => StatusSampel(0),
          'status_sertifikat' => StatusSertifikat(0),
          'tanggal'           => date('Y-m-d')
       );

   $this->m_registrasi_sampel->insert($data_sampel, 'tmp_sampel');        
    }

   $id_sampel = $this->db->insert_id();
   for ($x=0; $x<$jumlah_dipilihM; $x++){
     $id_pengujian = $M[$x];

     $biaya_pemeriksaan=getName("pengujian","id_pengujian",$id_pengujian,"biaya");
        $data_pemeriksaan = array(
         'id_sampel' => $id_sampel,
         'id_pengujian' => $id_pengujian,
         'biaya_pemeriksaan' => $biaya_pemeriksaan,
         );
         $this->m_registrasi_sampel->insert($data_pemeriksaan, "tmp_pemeriksaan");
   }

   // insert data pengujian farmakologi
   $F= $this->input->post('farmakologi');
   $jumlah_dipilihF = count($F);
   if ($jumlah_dipilihF > 0){
      $no_sampel = getNoSampel("F");
      $data_sampel = array(
        'id_order_detail'   => $id_order_detail,
        'id_bidang'         => "F",
        'no_sampel'         => "0",
        'status_sampel'     => StatusSampel(0),
        'status_sertifikat' => StatusSertifikat(0),
        'tanggal'           => date('Y-m-d')
      );

  $this->m_registrasi_sampel->insert($data_sampel, 'tmp_sampel');        
   }

  $id_sampel = $this->db->insert_id();
  for ($x=0; $x<$jumlah_dipilihF; $x++){
    $id_pengujian = $F[$x];

    $biaya_pemeriksaan=getName("pengujian","id_pengujian",$id_pengujian,"biaya");
       $data_pemeriksaan = array(
        'id_sampel' => $id_sampel,
        'id_pengujian' => $id_pengujian,
        'biaya_pemeriksaan' => $biaya_pemeriksaan,
        );
        $this->m_registrasi_sampel->insert($data_pemeriksaan, "tmp_pemeriksaan");
  }
      $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>1 Data Berhasil Ditambahkan</strong></div>');
      redirect('c_registrasi_sampel'); 
     
  }  
}

  public function konfirmasi_hapus($id_order_detail){
    $result = $this->m_registrasi_sampel->delete(array('id_order_detail'=> $id_order_detail), 'tmp_order_detail');
    if ($result = 1){
      $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>1 Data Berhasil Dihapus</strong></div>');
    }else{
      $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>1 Data Gagal Dihapus</strong></div>');
    }
    redirect('c_registrasi_sampel');
  }

  public function selesai ($id_pelanggan){
    $no_order = getNota("`order`", "no_order", "OR-");

    $d = array(
      'no_order'      => $no_order,
      'id_pelanggan'  => $id_pelanggan,
      'tgl_order'     => date('Y-m-d'),
      'status'        => 0
    );   
    $this->m_registrasi_sampel->insert($d,'order');

    $query = $this->db->query ("SELECT * FROM tmp_order_detail where id_pelanggan = '$id_pelanggan'")->result();
    foreach($query as $b1){

    $data = array (
      'no_order'            => $no_order,
      'nama_sampel'         => $b1->nama_sampel, 
      'pemerian'            => $b1->pemerian, 
      'kode_batch'          => $b1->kode_batch, 
      'jumlah'              => $b1->jumlah,
      'kemasan'             => $b1->kemasan, 
      'transportasi_sampel' => $b1->transportasi_sampel,
      'tempat_penyimpanan'  => $b1->tempat_penyimpanan, 
      'terima_sampel'       => '',
      'hal_lain'            => $b1->hal_lain 
    );


    $this->m_registrasi_sampel->insert($data, 'order_detail');
    $id_order_detail = $this->db->insert_id();
   
    $query2 = $this->db->query("SELECT * FROM tmp_sampel where id_order_detail= '$b1->id_order_detail'")->result();
        foreach ($query2 as $baris){

            if ($baris->id_bidang == 'K'){
              $no_sampel =getNosampel('K');

              $data2 = array(
                'id_order_detail'     => $id_order_detail,
                'id_bidang'           => $baris->id_bidang,
                'no_sampel'           => $no_sampel,
                'status_sampel'       => $baris->status_sampel,
                'status_sertifikat'   => $baris->status_sertifikat,
                'status_tinjauan_mt'  => 0,
                'status_tinjauan_anl' => 0, 
                'tanggal'             => $baris->tanggal
              );
                $this->m_registrasi_sampel->insert($data2, 'sampel');

                $id_sampel = $this->db->insert_id();
                $query3 = $this->db->query("SELECT * FROM tmp_pemeriksaan where id_sampel = '$baris->id_sampel'")->result();

                foreach ($query3 as $bar){
                  
                  $data3 = array(
                  'id_sampel'   => $id_sampel,
                  'id_pengujian'  => $bar->id_pengujian,
                  'status_pemeriksaan'  =>$bar->status_pemeriksaan,
                  'biaya_pemeriksaan'   => $bar->biaya_pemeriksaan);
                
                  $this->m_registrasi_sampel->insert($data3, 'pemeriksaan');
                }
            } 

            if ($baris->id_bidang == 'M'){
              $no_sampel =getNosampel('M');

              $data2 = array(
                'id_order_detail'   => $id_order_detail,
                'id_bidang'         => $baris->id_bidang,
                'no_sampel'         => $no_sampel,
                'status_sampel'     => $baris->status_sampel,
                'status_sertifikat' => $baris->status_sertifikat, 
                'tanggal'           => $baris->tanggal
              );
                $this->m_registrasi_sampel->insert($data2, 'sampel');

                $id_sampel = $this->db->insert_id();
                $query3 = $this->db->query("SELECT * FROM tmp_pemeriksaan where id_sampel = '$baris->id_sampel'")->result();
                foreach ($query3 as $bar){
                  
                  $data3 = array(
                  'id_sampel'   => $id_sampel,
                  'id_pengujian'  => $bar->id_pengujian,
                  'status_pemeriksaan'  =>$bar->status_pemeriksaan,
                  'biaya_pemeriksaan'   => $bar->biaya_pemeriksaan);
                
                  $this->m_registrasi_sampel->insert($data3, 'pemeriksaan');
                }
            } 
          
            if ($baris->id_bidang == 'F'){
              $no_sampel =getNosampel('F');

              $data2 = array(
                'id_order_detail'   => $id_order_detail,
                'id_bidang'         => $baris->id_bidang,
                'no_sampel'         => $no_sampel,
                'status_sampel'     => $baris->status_sampel,
                'status_sertifikat' => $baris->status_sertifikat, 
                'tanggal'           => $baris->tanggal
              );
                $this->m_registrasi_sampel->insert($data2, 'sampel');

                $id_sampel = $this->db->insert_id();
                $query3 = $this->db->query("SELECT * FROM tmp_pemeriksaan where id_sampel = '$baris->id_sampel'")->result();
                foreach ($query3 as $bar){
                  
                  $data3 = array(
                  'id_sampel'   => $id_sampel,
                  'id_pengujian'  => $bar->id_pengujian,
                  'status_pemeriksaan'  =>$bar->status_pemeriksaan,
                  'biaya_pemeriksaan'   => $bar->biaya_pemeriksaan);
                
                  $this->m_registrasi_sampel->insert($data3, 'pemeriksaan');
                }
            } 
        }
    }
    $tag = array(
      'no_tagihan'        => SetInvoice("INV_"),
      'no_order'          => $no_order,
      'jumlah_tagihan'    => getJumlah($no_order),
      'status_tagihan'    => 0
    );

    $tagihan['res']  = $this->m_registrasi_sampel->insert($tag, 'tagihan');
    $where = array('id_pelanggan'=>$id_pelanggan);
    $hapus_tmp['res'] = $this->m_registrasi_sampel->delete($where, 'tmp_order_detail');
    
    if ($tagihan and $hapus_tmp){
      $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong><center> Permintaan Pengujian Berhasil Dibuat </center></strong></div>');
    }else{
      $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong><center> Permintaan Pengujian Gagal Dibuat </center></strong></div>');
    }
    redirect('c_registrasi_sampel/registrasi');
  }  


  public function edit_PermohonanSampel($id_sampel){
    $hak_akses = $this->session->userdata('hak_akses');
    $where = array('id_sampel' => $id_sampel);

    $data['detail'] = $this->m_registrasi_sampel->order_orderDetail($where)->result();
    $data['kimia'] = $this->m_registrasi_sampel->pengujian("K")->result();
  
    $this->templates->utama('pelanggan/v_edit_PermohonanSampel', $data);
  }

  public function update_PermohonanSampel(){

    $id_order_detail = $this->input->post('id_order_detail');
    $where = array('id_order_detail'  => $id_order_detail);
    
    $this->form_validation->set_rules('nama_sampel','Nama Sampel','required|trim', array('required'=>'Nama sampel tidak boleh kosong...!'));
    $this->form_validation->set_rules('pemerian','Pemerian','required|trim', array('required'=>'Pemerian tidak boleh kosong...!'));
    $this->form_validation->set_rules('kode_batch','Kode Batch','required|trim', array('required'=>'Kode Batch tidak boleh kosong...!'));
    $this->form_validation->set_rules('kemasan','Kemasan','required|trim', array('required'=>'Kemasan tidak boleh kosong...!'));
    $this->form_validation->set_rules('transportasi_sampel','Transportasi Sampel','required|trim', array('required'=>'Transporatasi sampel tidak boleh kosong...!'));
    $this->form_validation->set_rules('tempat_penyimpanan','Tempat Penyimpanan','required|trim', array('required'=>'Tempat penyimpanan tidak boleh kosong...!'));
    $this->form_validation->set_rules('hal_lain','Hal Lain','required|trim', array('required'=>'Hal lain tidak boleh kosong...!'));

    if ($this->form_validation->run() == false){
      $this->edit_PermohonanSampel($id_order_detail);
    }else{
      $data  = array(
        'nama_sampel'         => $this->input->post('nama_sampel'),
        'pemerian'            => $this->input->post('pemerian'),
        'kode_batch'          => $this->input->post('kode_batch'),
        'kemasan'             => $this->input->post('kemasan'),
        'transportasi_sampel' => $this->input->post('transportasi_sampel'),
        'tempat_penyimpanan'  => $this->input->post('tempat_penyimpanan'),
        'hal_lain'            => $this->input->post('hal_lain')  
      );

      $update['res'] = $this->m_registrasi_sampel->update($where, $data, 'order_detail');

      if ($update){
          $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong><center> Update Data Berhasil </center></strong></div>');
      }else{
          $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong><center> Update Data Gagal </center></strong></div>');
      }
    }
    redirect ('c_pelanggan/tampil_riwayat');
  }


  public function batalkan_pelanggan($id_sampel){
    $row = $this->m_registrasi_sampel->get_by_id('sampel','id_sampel', $id_sampel);
    $row2 = $this->m_registrasi_sampel->get_by_id('order_detail', 'id_order_detail', $row->id_order_detail);
    
    $tagihan = $this->db->query("SELECT * FROM pemeriksaan where id_sampel = '$id_sampel'")->result();
    $data = array (
      'status_sampel' => 6,
      'status_tinjauan_mt'=> 2
    );
    $run =$this->m_registrasi_sampel->update(array('id_sampel'=> $id_sampel),  $data, 'sampel');
    foreach ($tagihan as $cost){
      $biaya = array(
        'biaya_pemeriksaan' => 0
      );
      $run = $this->m_registrasi_sampel->update(array('id_pemeriksaan'=> $cost->id_pemeriksaan), $biaya, 'pemeriksaan');
    }
    
    $total = array(
      'jumlah_tagihan' => getJumlah($row2->no_order));

    $run = $this->m_registrasi_sampel->update(array('no_order'=>$row2->no_order), $total, 'tagihan');

    if ($run = 1){
      echo $this->session->set_flashdata('pesan', 
      '<script>
      swal("Success !", "Pembatalan pengujian berhasil !", "success"); 
      </script>');
    }else{
      echo $this->session->set_flashdata('pesan', 
      '<script>
          swal({
          title: "Failed",
          text: "Pembatalan pengujian gagal",
          type: "warning",
          });
      </script>');
    }
    redirect("c_pelanggan/tampil_riwayat");
  }

}

?>