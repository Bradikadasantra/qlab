<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_pelanggan extends CI_Controller {

    public function __construct(){
		parent:: __construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('templates');
        $this->load->model('m_pelanggan');
        $this->load->model('m_registrasi_sampel');
        $this->load->library('pdf');
        $this->load->library('hasilPemeriksaan');
    }

    public function index(){
      redirect('c_dashboard');
    }
    
    
  public function tampil_riwayat(){
      $id_auth = $this->session->userdata('id_auth');
      $cari_id_pelanggan = $this->m_pelanggan->ambil_info_pelanggan($id_auth)->row();
      $id_pelanggan = $cari_id_pelanggan->id_pelanggan;

      $cek = $this->db->query("SELECT * FROM `order` WHERE id_pelanggan = '$id_pelanggan'")->num_rows();
      if ($cek > 0){
      $data['riwayat'] = $this->m_registrasi_sampel->tampil_riwayat($id_pelanggan)->result();
      $this->templates->utama('pelanggan/v_riwayat', $data);
      }else {
        $data = array (
          'title'   => 'Riwayat',
          'content' => 'Anda belum memiliki riwayat',
          'url'     => base_url('c_dashboard')
        );
        $this->templates->utama('pelanggan/v_error',$data);  
      }
    }


    public function konfirmasi_pembayaran(){
      $id = $this->session->userdata('id_auth');
      $cari = $this->m_registrasi_sampel->get_by_id('pelanggan', 'id_auth', $id);
  
      $data['action'] = base_url('c_pelanggan/action_konfirmasiPembayaran');
      $data['data'] = $this->db->query("SELECT * FROM `order` JOIN tagihan ON `order`.no_order = tagihan.no_order WHERE id_pelanggan = '$cari->id_pelanggan' AND status_tagihan = '0'")->result();
      $this->templates->utama('pelanggan/v_konfirmasi_pembayaran', $data);
    }

    public function ajax_tagihan(){
      $no_tagihan = $this->input->post('no_order');
      $kueri = $this->db->query("SELECT * FROM tagihan WHERE no_tagihan = '$no_tagihan'")->roW();

      $data = array(
        'jumlah_dana'  => $kueri->jumlah_tagihan
      ); 
     echo json_encode($data);
    }

    public function action_konfirmasiPembayaran(){
    
      $this->form_validation->set_rules('nama_pengirim','Nama Pengirim','required|trim', array('required'=>'Masukkan nama pengirim...!'));
      $this->form_validation->set_rules('bank_pengirim','Bank Pengirim','required|trim', array('required'=>'Masukkan Bank anda...!'));
      $this->form_validation->set_rules('jumlah_dana','Jumlah Dana','required|trim|numeric', array('required'=>'Masukkan Jumlah Nominal Transfer...!', 'numeric'=> 'Masukkan angka yang valid...!'));
      $this->form_validation->set_rules('tgl_bayar','Tgl Bayar','required|trim', array('required'=>'Masukkan Tanggal Bayar...!'));
    
          if ($this->form_validation->run() == false){
            $this->konfirmasi_pembayaran();
          }else{
            $config['upload_path']          = './bukti_bayar/';
            $config['allowed_types']        = 'png|jpg|jpeg';
            $config['max_width']            = 1024;
            $config['max_height']           = 768;
            
            $this->load->library('upload', $config);
           
            if($this->upload->do_upload('bukti_bayar')){
              $finfo = $this->upload->data();
              $bukti_bayar = $finfo['file_name'];
               
              $data = array(
                'no_tagihan'       => $this->input->post('no_order'),
                'pemilik_rekening' => $this->input->post('nama_pengirim'),
                'bank'             => $this->input->post('bank_pengirim'),
                'jumlah'           => $this->input->post('jumlah_dana'),
                'bukti_byr'        => $bukti_bayar,
                'tgl_byr'          => date('Y-m-d', strtotime($this->input->post('tgl_bayar')))
              );
              $d = array(
                'status_tagihan'          => 1
              );
              $run = $this->m_registrasi_sampel->insert($data, 'konfirmasi_byr');
              $r   = $this->m_registrasi_sampel->update(array('no_tagihan'=> $this->input->post('no_order')), $d, 'tagihan');
                if ($run = 1 AND $r = 1){
                  echo $this->session->set_flashdata('pesan', 
                  '<script>
                  swal("Success !", "Konfrimasi Pembayaran Berhasil", "success"); 
                  </script>');
                } else{
                  echo $this->session->set_flashdata('pesan', 
                  '<script>
                     swal({
                     title: "Failed",
                     text: "Konfirmasi Pembayaran Gagal",
                    type: "warning",
                 });
                 </script>');
                }
              }else{
                echo $this->session->set_flashdata('pesan', 
                '<script>
                  swal({
                  title: "Failed",
                  text: "Format file tidak didukung",
                  type: "warning",
                  });
                </script>');
                }
                redirect('c_pelanggan/konfirmasi_pembayaran');
              }
            
            }


  public function print_hasilPemeriksaan($id_sampel){
    $run = $this->m_registrasi_sampel->get_by_id('sampel','id_sampel',$id_sampel);
    if ($run->status_sampel == 3 OR $run->status_sertifikat != 2){
      $hak_akses = $this->session->userdata('hak_akses');

      if ($hak_akses == 1){

        $data = array(
        'title'   => 'Hasil Pemeriksaan',
        'content' => 'Maaf, hasil pengujian sampel yang di uji belum keluar',
        'url'     => base_url('c_permintaan_uji/rekap_registrasiSampel')
        );
      }
      else if ($hak_akses == 6 ){
        $data = array(
        'title'   => 'Hasil Pemeriksaan',
        'content' => 'Maaf, hasil pengujian sampel yang di uji belum keluar',
        'url'     => base_url('c_permintaan_uji')
      );
      }
      else {
      $data = array (
        'title'   => 'Hasil Pemeriksaan',
        'content' => 'Maaf, hasil pengujian sampel yang di uji belum keluar',
        'url'     => base_url('c_pelanggan/tampil_riwayat')
      );
    }
      $this->templates->utama('pelanggan/v_error',$data);
    }else{
    
    $row = $this->m_registrasi_sampel->get_by_id('sampel','id_sampel',$id_sampel);
    $row2 = $this->m_registrasi_sampel->get_by_id('order_detail','id_order_detail',$row->id_order_detail);
    $run   = $this->m_registrasi_sampel->all_data_order(array('id_sampel'=> $id_sampel))-> result();

    foreach ($run as $baris){
      $pdf = new HasilPemeriksaan('P','mm','A4');
      $pdf->SetMargins(10,10,10);

       // membuat halaman baru
      $pdf->AddPage();
      $pdf->SetFont('arial','B',9);
      $pdf->Cell(200,0,'Laporan Pengujian Laboratorium',0,1,'C');
      $pdf->SetFont('arial','',7);
      $pdf->Cell(200,9,'Nomor:'.setNosampel($baris->no_sampel,$baris->tgl_order),0,1,'C');
      $pdf->SetLineWidth(0,1);
      $pdf->Line(200,47,10,47 );

      $pdf->Cell(10,3,'',0,1);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(5,5,'Nama Sampel',0,0,'L');
      $pdf->Cell(50);
      $pdf->Cell(4,5,':',0,0,'L');
      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(5,5, $baris->nama_sampel,0,0,'L');
   
      $pdf->Cell(10,6,'',0,1);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(5,5,'No Batch',0,0,'L');
      $pdf->Cell(50);
      $pdf->Cell(4,5,':',0,0,'L');
      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(5,5, $baris->kode_batch,0,0,'L');
    
      $pdf->Cell(10,6,'',0,1);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(5,5,'Nama Pengirim',0,0,'L');
      $pdf->Cell(50);
      $pdf->Cell(4,5,':',0,0,'L');
      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(5,5, $baris->nama.' '.' ('.$baris->instansi.') ',0,0,'L');

      $pdf->Cell(10,6,'',0,1);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(5,5,'Alamat Pengirim',0,0,'L');
      $pdf->Cell(50);
      $pdf->Cell(4,5,':',0,0,'L');
      $pdf->SetFont('Arial', '', 8);
      $pdf->MultiCell(90,5, $baris->alamat_instansi);

      $pdf->Cell(10,0,'',0,1);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(5,5,'Tanggal Penerimaan Sampel',0,0,'L');
      $pdf->Cell(50);
      $pdf->Cell(4,5,':',0,0,'L');
      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(5,5,WKT($baris->terima_sampel),0,0,'L');

      $pdf->Cell(10,6,'',0,1);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(5,5,'Kode Sampel',0,0,'L');
      $pdf->Cell(50);
      $pdf->Cell(4,5,':',0,0,'L');
      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(5,5,$baris->no_sampel,0,0,'L');


      $que = "SELECT * FROM sampel JOIN pemeriksaan ON sampel.id_sampel = pemeriksaan.id_sampel WHERE sampel.id_sampel = '$baris->id_sampel'";
      $fr = $this->db->query($que)->result();

      $pdf->Cell(10,6,'',0,1);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(5,5,'Metode Pengujian',0,0,'L');
      $pdf->Cell(50);
      $pdf->Cell(4,5,':',0,0,'L');
      foreach ($fr as $f){
      $nama_pemeriksaan=getName("pengujian","id_pengujian",$f->id_pengujian,"nama_pengujian");
      $pdf->SetFont('Arial','', 8);
      $pdf->MultiCell(50,5,'- '.$nama_pemeriksaan);
      $pdf->Cell(59,15);
      }
    
      $pdf->Cell(5,25,'',0,1);
      $pdf->Cell(5,5,'Hasil Pengujian :',0,1,'L');

      $pre = "SELECT * FROM pemeriksaan WHERE id_sampel = '$baris->id_sampel'";
      $running = $this->db->query($pre)->result();  
      $pdf->SetFont('Arial','B', 9);
      $pdf->Cell(10,5,'No',1,0,'C');
      $pdf->Cell(90,5,'Metode Pengujian',1,0,'C');
      $pdf->Cell(90,5,'Hasil Pemeriksaan',1,1,'C');
      $no = 1;   
      foreach($running as $man){
        $pdf->SetFont('Arial','', 8);
          $name = getName("pengujian","id_pengujian",$man->id_pengujian,"nama_pengujian");
          $pdf->Cell(10,5,$no++,1,0,'C');
          $pdf->Cell(90,5,$name,1,0,'C');
          $querti = "SELECT hasil_pemeriksaan FROM hasil_pemeriksaan WHERE id_pemeriksaan = '$man->id_pemeriksaan'";
          $jos = $this->db->query($querti)->result();
            foreach ($jos as $jas){
              $pdf->Cell(90,5,$jas->hasil_pemeriksaan,1,1,'C');
              $pdf->Cell(100,5);
            }
            $pdf->Cell(90,5,'',0,1,'C');
        }
        $pdf->Cell(10,0,'',0,1);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10,15,'Kesimpulan',0,0,'L');
        $pdf->Cell(10);
        $pdf->Cell(4,15,':',0,0,'L');
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(4,15,'Hasil pengujian seperti tertera pada di atas',0,1,'L');

        $pdf->Cell(130);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(4,1,'Jakarta'.', '.WKT(date('Y-m-d')),0,1,'L');
        $pdf->Cell(112);
        $pdf->Cell(4,6,'Laboratorium Jasa Pengujian dan Penelitian (QLab)',0,1,'L');
        $pdf->Cell(117);
        $pdf->Cell(4,3,'Fakultas Farmasi Universitas Pancasila',0,1,'L');
        $pdf->Cell(127);
        $kueri = "SELECT nama,hak_akses,id_bidang  from admin JOIN auth ON admin.id_auth = auth.id_auth WHERE id_bidang = '$baris->id_bidang' and hak_akses = '6'";
        $man = $this->db->query($kueri)->row();
        
        if ($man->id_bidang == 'M'){
          $pdf->Cell(4,5,'Manajer Teknis Mikrobiologi',0,1,'L');
          $pdf->Cell(127);
          $pdf->Cell(4,55,'( '.$man->nama.' )',0,1,'L');
        }else if ($man->id_bidang == 'K'){
          $pdf->Cell(4,5,'Manajer Teknis Kimia',0,1,'L');
          $pdf->Cell(127);
          $pdf->Cell(4,55,'( '.$man->nama.' )',0,1,'L');
        }else{
          $pdf->Cell(4,5,'Manajer Teknis Farmakologi',0,1,'L');
          $pdf->Cell(127);
          $pdf->Cell(4,55,'( '.$man->nama.' )',0,1,'L');
        }
        $pdf->SetFont('Arial', 'I', 8);
        $pdf->Cell(4,-30,'Laporan pengujian laboratorium hanya berlaku untuk sampel yang diuji',0,1,'L');
      }        
        $pdf->Output(('Hasil Pemeriksaan  '.$row2->no_order),'I');
  }

  }

  public function print_invoice($no_order){
    $pdf = new pdf('L','mm','A4');
    $pdf->SetMargins(10,10,10);
    $pdf->AliasNbPages();
    // membuat halaman baru
    $pdf->AddPage();
    $pdf->SetFont('Times', 'B', 14);
    $pdf->Cell(0,2, 'INVOICE',0,1,'C');
  
    $pel = $this->m_registrasi_sampel->invoice($no_order)->result();
    
    foreach($pel as $baris){
      $pdf->Cell(10,9,'',0,1);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(5,5,'No Order',0,0,'L');
      $pdf->Cell(27);
      $pdf->Cell(4,5,':',0,0,'L');
      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(5,5, $no_order,0,0,'L');
      $pdf->Cell(165);

      // no invoice
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(5,5,'No Invoice',0,0,'L');
      $pdf->Cell(27);
      $pdf->Cell(4,5,':',0,0,'L');
      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(5,5, 'INV/20198989',0,1,'L');
      
      //nama pelanggan
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(5,5,'Nama Pelanggan',0,0,'L');
      $pdf->Cell(27);
      $pdf->Cell(4,5,':',0,0,'L');
      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(5,5, $baris->nama,0,0,'L');
      $pdf->Cell(165);
      //Tanggal cetak Invoice
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(5,5,'Tanggal',0,0,'L');
      $pdf->Cell(27);
      $pdf->Cell(4,5,':',0,0,'L');
      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(5,5, WKT($baris->tgl_order),0,1,'L');
    
       //nama perusahaan 
       $pdf->SetFont('Arial', 'B', 8);
       $pdf->Cell(5,5,'Nama Perusahaan',0,0,'L');
       $pdf->Cell(27);
       $pdf->Cell(4,5,':',0,0,'L');
       $pdf->SetFont('Arial', '', 8);
       $pdf->Cell(5,5, $baris->instansi,0,0,'L');
       $pdf->Cell(165);
       //nomor invoice
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(5,5,'Pembayaran',0,0,'L');
      $pdf->Cell(27);
      $pdf->Cell(4,5,':',0,0,'L');
      $pdf->SetFont('Arial', '', 8);
      $pdf->Cell(4,5, 'Jasa Pengujian',0,1,'L');
       
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(5,5,'Alamat Perusahaan',0,0,'L');
      $pdf->Cell(27);
      $pdf->Cell(4,5,':',0,0,'L');
      $pdf->SetFont('Arial', '', 8);
      $pdf->MultiCell(50, 4, $baris->alamat_instansi, 0,'J');

      $pdf->Cell(10,9,'',0,1);
      $pdf->SetFont('Arial', 'B', 8);
      //tabel
      $pdf->Cell(5,5,'No',1,0,'C');
      $pdf->Cell(80,5,'Nama Sampel',1,0,'C');
      $pdf->Cell(80,5,'Jenis Pengujian',1,0,'C');
      $pdf->Cell(20,5,'Jml Sampel',1,0,'C');
      $pdf->Cell(35,5,'Biaya Satuan',1,0,'C');
      $pdf->Cell(45,5,'Total Harga',1,1,'C');
    }
    $pdf->SetFont('Arial', '', 8);
    $result = $this->m_registrasi_sampel->detail_order($no_order)->result();
    $no = 1; 
    $sub_total = 0;
      foreach ($result as $row){
        $total_harga = $row->jumlah * $row->biaya_pemeriksaan;
        $sub_total += $total_harga; 

        $pdf->Cell(5,5,$no++,1,0,'C');
        $nama=getName("pengujian","id_pengujian",$row->id_pengujian,"nama_pengujian");
        $pdf->Cell(80,5,$row->nama_sampel.'-'.$row->no_sampel,1,0,'C');
        $pdf->Cell(80,5,$nama,1,0,'C');
        $pdf->Cell(20,5,$row->jumlah,1,0,'C');
        $pdf->Cell(35,5,angka($row->biaya_pemeriksaan),1,0,'C');
        $pdf->Cell(45,5,angka($total_harga),1,1,'C');
     
      } 
      $pdf->Cell(3);
      $pdf->SetFont('Arial', 'B', '10');
      $terbilang = '<b>Terbilang  : <i>'.terbilang($sub_total).'Rupiah,-</i></b>';
      $pdf->WriteHTML($terbilang);
     
      $pajak  = $sub_total * 0.02;
      $total_nonpajak = $sub_total - $pajak;
      
      $pdf->Cell(10,9,'',0,1);
      $pdf->SetFont('Arial', 'B', 8);
      $pdf->Cell(30,5,'Sub Total',1,0,'C');
      $pdf->Cell(55 ,5,angka($sub_total),1,1,'R');
      $pdf->Cell(30,5,'ppH 2%',1,0,'C');
      $pdf->Cell(55 ,5,angka($pajak),1,1,'R');
      $pdf->Cell(30,5,'Total Harga',1,0,'C');
      $pdf->Cell(55 ,5,angka($total_nonpajak),1,1,'R');
      $pdf->Cell(30,5,'Total Harga Netto',1,0,'C');
      $pdf->Cell(55 ,5,angka($total_nonpajak),1,0,'R');

      $pdf->Cell(10,7,'',0,1);
      $pdf->SetFont('Arial', 'B', 9);
      $pdf->Cell(220);
      $pdf->Cell(30,5,'Hormat Kami,',0,1,'C');
      $pdf->Ln(20);
      $pdf->Cell(220);
      $pdf->Cell(30,5,'Laboratorium Qlab Fakultas Farmasi',0,1,'C');
      $pdf->Cell(220);
      $pdf->Cell(30,3,'Universitas Pancasila Jakarta',0,1,'C');

      $pdf->SetFont('Arial', 'B', 9);
      $pdf->Cell(30,4,'An Qlab Fakultas Farmasi UP',0,1,'L');
      $pdf->Cell(30,4,'Bank Mandiri KCP Jakarta Universitas Pancasila',0,1,'L');
      $pdf->Cell(30,4,'No Rekening : 127-00-0759937-4',0,1,'L');

    $pdf->Output(('Invoice  '.$no_order),'I');

  }

  }
?>