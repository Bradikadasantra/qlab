<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__dir__).'../../PHPWORD/autoload.php';

class C_dokumen extends MY_Controller {

    public function __construct(){
        parent:: __construct();
        $this->cekLogin();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('templates');
        $this->load->model('m_dokumen');
        $this->load->model('m_admin');
    }

    public function index(){
        $hak_akses = $this->session->userdata('hak_akses');
        $where = array('hak_akses'=> $hak_akses);
        $dokumen['dokumen'] = $this->m_dokumen->akses_dokumen($where)->result();
        $this->templates->utama('dokumen/v_dokumen_induk', $dokumen);
        }

    public function riwayat(){
        $where = array('id_auth'=> $this->session->userdata('id_auth'));

        $hak_akses = $this->session->userdata('hak_akses');
        $row       = $this->m_admin->cari_admin($where)->row();
        //cek apakah jabatan ini memunyai hak akses untuk memngupoad dokumen ?

        //$cek = $this->m_dokumen->get_pemeriksa("(dokumen_akses.hak_akses = '$hak_akses' AND aksi = 'penyusun')")->num_rows();
        $cek = $this->db->query("SELECT * FROM upload_dokumen WHERE id_penyusun = '$row->id_admin'")->num_rows();
        if ($cek > 0){
            //tampilkan semua dokumen yang telah user buat
            $data['riwayat']  = $this->db->query("SELECT * FROM upload_dokumen WHERE id_penyusun = '$row->id_admin'")->result();
            $data['upload_ulang'] = $this->db->query("SELECT * FROM upload_dokumen WHERE id_penyusun = '$row->id_admin' AND status='3'")->result();
            $this->templates->utama('dokumen/v_riwayat', $data);
        }else{
                $data = array (
                'title'   => 'Akses Tidak Ditemukan',
                'content' => 'Anda belum memiliki riwayat',
                'url'     => base_url('c_dokumen'),
            );
            $this->templates->utama('pelanggan/v_error',$data);  
        }   
    }

    public function detail_penolakan($no_dokumen){
        $where = array('upload_dokumen.no_dokumen'=> $no_dokumen);
        $data['no_dokumen'] = $no_dokumen;
        $data['data'] = $this->m_dokumen->upload_approve($where)->result();
        $this->templates->utama('dokumen/v_detail_penolakan', $data);
    }


    public function list_jenisDokumen(){
        $id_dokumen_induk = $this->input->post('dokumen_induk');
        $jenis = $this->m_dokumen->induk_jenis(array('dokumen_induk.id_dokumen_induk'=> $id_dokumen_induk))->result();  
        
        // Buat variabel untuk menampung tag-tag option nya    
        // Set defaultnya dengan tag option Pilih    
        $lists = "<option value=''> Jenis Dokumen</option>";       
            foreach($jenis as $data){      
                $lists .= "<option value='".$data->id_jenis_dokumen."'>".$data->nama_dokumen."</option>"; 
            // Tambahkan tag option ke variabel $lists    
        }     
         $callback = array('list_jenis_dokumen'=>$lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota   
          echo json_encode($callback); // konversi varibael $callback menjadi JSON

    }
    
    public function list_pemeriksa(){
            $id_jenis_dokumen = $this->input->post('jenis_dokumen');
            $pemeriksa = $this->m_dokumen->get_pemeriksa("(id_jenis_dokumen = '$id_jenis_dokumen' AND aksi = 'pemeriksa')")->result();  
            
            // Buat variabel untuk menampung tag-tag option nya    
            // Set defaultnya dengan tag option Pilih    
            $lists = "<option value=''> ~Pemeriksa</option>";       
                foreach($pemeriksa as $data){      
                    $lists .= "<option value='".$data->id_admin."'>".$data->nama."</option>"; 
                // Tambahkan tag option ke variabel $lists    
            }     
             $callback = array('list_pemeriksa'=>$lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota   
              echo json_encode($callback); // konversi varibael $callback menjadi JSON
        }

    public function list_pengesah(){
        $id_jenis_dokumen = $this->input->post('jenis_dokumen');
        $hak_akses_pengesah = $this->m_dokumen->get_pemeriksa("(id_jenis_dokumen = '$id_jenis_dokumen' AND aksi = 'pengesah')")->result();  
        
        // Buat variabel untuk menampung tag-tag option nya    
        // Set defaultnya dengan tag option Pilih    
        $lists = "<option value=''> ~Pengesah</option>";       
            foreach($hak_akses_pengesah as $data){      
                $lists .= "<option value='".$data->id_admin."'>".$data->nama."</option>"; 
            // Tambahkan tag option ke variabel $lists    
        }     
         $callback = array('list_pengesah'=>$lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota   
          echo json_encode($callback); // konversi varibael $callback menjadi JSON
    }


    public function form_tmp_upload(){
        $where              = array ('id_auth'=> $this->session->userdata('id_auth'));
        $data['data']       = $this->m_admin->cari_admin($where)->row();
        $this->templates->utama('dokumen/v_tmp_upload_dokumen', $data);
    }

    public function action_tmp_uploadDokumen(){
        $row = $this->m_dokumen->get_by_id('admin', 'id_auth', $this->session->userdata('id_auth'));
        $id_admin = $row->id_admin;
        $this->form_validation->set_rules('nama_dokumen','Nama Dokumen','required|trim', array('required'=>'Masukkan nama dokumen...!'));
        
        if (empty($_FILES['dokumen']['name'])){
            $this->form_validation->set_rules('dokumen','Dokumen','required|trim', array('required'=>'Lampirkan file...!'));
            }

        if ($this->form_validation->run() == false){
            $this->form_tmp_upload();
        }else{
            $config['upload_path']          = './dokumen/';
            $config['allowed_types']        = 'rtf|docx';
            $config['remove_space']         = true;
    
            $this->load->library('upload', $config);
           
            if($this->upload->do_upload('dokumen')){
              $finfo = $this->upload->data();
              $dokumen = $finfo['file_name'];

              $data = array(
                  'nama_dokumen'        => ucwords($this->input->post('nama_dokumen')),
                  'penyusun'            => $id_admin,
                  'tgl_disusun'         => date('Y-m-d'),
                  'bidang'              => $row->id_bidang,
                  'file_dok'            => $dokumen 
              );

              $hasil = $this->m_dokumen->insert($data, 'tmp_upload_dokumen');

              if ($hasil = 1){
                    echo $this->session->set_flashdata('pesan', 
                    '<script>
                    swal("Success !", "Upload Dokumen Berhasil", "success"); 
                    </script>');
              }else{
                    echo $this->session->set_flashdata('pesan', 
                    '<script>
                    swal({
                    title: "Failed",
                    text: "Upload Dokuen Gagal",
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
            redirect('c_dokumen/action_tmp_uploadDokumen');
        }
        
    }


    public function list_identitas_dokumen(){
        $data['data'] = $this->m_dokumen->tmp_upload_dokumen('tmp_upload_dokumen')->result();
        $data['data2'] = $this->m_dokumen->tmp_upload_dokumen('upload_dokumen')->result();
        $this->templates->utama('dokumen/v_list_identitas_dokumen', $data);
    }

    public function form_identitas_dokumen($id_upload_dokumen){
        $result['dok_induk'] = $this->m_dokumen->dokumen_induk()->result();
        $result['data'] = $this->db->query("SELECT * FROM tmp_upload_dokumen WHERE id_upload_dokumen = '$id_upload_dokumen'")->result();
        $this->templates->utama('dokumen/v_form_identitas_dokumen', $result);
    }


    public function action_form_identitasDokumen(){
        $no_dokumen = $this->input->post('no_dokumen');
        $param = $this->input->post('id_upload_dokumen');
        $cari = $this->db->query("SELECT * FROM tmp_upload_dokumen WHERE id_upload_dokumen = '$param'")->row();

        $duplicate = $this->db->query("SELECT no_dokumen FROM upload_dokumen WHERE no_dokumen = '$no_dokumen'")->num_rows();
      
        $this->form_validation->set_rules('dokumen_induk','Dokumen Induk','required|trim', array('required'=>'Pilih dokumen induk...!'));
        $this->form_validation->set_rules('jenis_dokumen','Jenis Dokumen','required|trim', array('required'=>'Pilih jenis dokumen...!'));
        $this->form_validation->set_rules('no_dokumen','No Dokumen','required|trim', array('required'=>'Masukkan nomor dokumen...!'));
        $this->form_validation->set_rules('lokasi','Lokasi','required|trim', array('required'=>'Masukkan lokasi dokumen...!'));
        $this->form_validation->set_rules('jml_hlm','Jumlah Halaman','required|trim|numeric', array('required'=>'Masukkan jumlah halaman...!', 'numeric'=> 'Masukkan angka yang valid'));
    
        if (empty($_FILES['dokumen']['name'])){
            $this->form_validation->set_rules('dokumen','Dokumen','required|trim', array('required'=>'Lampirkan file...!'));
            }

        $pemeriksa = $this->input->post('pemeriksa');
        $pengesah = $this->input->post('pengesah');

        if ($pemeriksa == ''){
            $pem = null;
        }else{
            $pem = $pemeriksa;
        }

        if ($pengesah == ''){
            $penge = null; 
        }else{
            $penge = $pengesah; 
        }

        if ($this->form_validation->run() == false){
            $this->form_identitas_dokumen($param);
        }else{
            if ($duplicate > 0){
                echo $this->session->set_flashdata('pesan', 
                '<script>
                    swal({
                    title: "Failed",
                    text: "Duplicate Nomor sampel",
                    type: "warning",
                });
                </script>');
            }else{
                $config['upload_path']          = './dokumen/';
                $config['allowed_types']        = 'rtf|docx';
                $config['remove_space']             = true;

                $this->load->library('upload', $config);

                if($this->upload->do_upload('dokumen')){

                    $ambil_data = $this->db->query("SELECT * FROM tmp_upload_dokumen WHERE id_upload_dokumen = '$param'");	
                    if($ambil_data->num_rows() > 0){
                        $pros=$ambil_data->row();
                        $dokumen=$pros->file_dok;
                            if(is_file($lok=FCPATH.'/dokumen/'.$dokumen)){
                                unlink($lok);
                            }
                        }
                    $finfo = $this->upload->data();
                    $dokumen = $finfo['file_name'];
                    
                    if ($pemeriksa != ''){
                        $result = array();
                        foreach ($cari as $baris => $v){
                            array_push($result, $v);
                        }
                            $data = array(
                                'id_dokumen_induk' => $this->input->post('dokumen_induk'),
                                'id_jenis_dokumen' =>$this->input->post('jenis_dokumen'),
                                'nama_dok'         => $result[2],
                                'no_dokumen'       => strtoupper($this->input->post('no_dokumen')),
                                'lokasi'           => strtoupper($this->input->post('lokasi')),
                                'jml_hlm'          => $this->input->post('jml_hlm'),
                                'id_penyusun'      => $result[3],
                                'tgl_buat'         => $result[4],
                                'status'           => 0,
                                'dok'              => $dokumen
                              );
                        
                      $run = $this->m_dokumen->insert($data, 'upload_dokumen'); 
                         $data2 = array(
                            'no_dokumen'          => strtoupper($this->input->post('no_dokumen')),
                            'bidang'              => $result[1],
                            'id_pemeriksa'        => $pem,
                            'tgl_diperiksa'       => 0,
                            'id_pengesah'         => $penge,
                            'tgl_disahkan'        => 0    
                            );
                             $ruin = $this->m_dokumen->insert($data2, 'approve_dokumen');
                                if ($run = 1 and $ruin = 1){
                                echo $this->session->set_flashdata('pesan', 
                                '<script>
                                swal("Success !", "Upload Dokumen Berhasil", "success"); 
                                </script>');
                            }else{
                            echo $this->session->set_flashdata('pesan', 
                            '<script>
                                swal({
                                title: "Failed",
                                text: "Upload Dokumen Gagal",
                                type: "warning",
                            });
                            </script>');
                            }
                        $delete = $this->m_dokumen->hapus(array('id_upload_dokumen'=>  $param), 'tmp_upload_dokumen');
                    }else{
                        $result = array();
                        foreach ($cari as $baris => $v){
                            array_push($result, $v);
                        }
                        $data = array(
                            'id_dokumen_induk' => $this->input->post('dokumen_induk'),
                            'id_jenis_dokumen' =>$this->input->post('jenis_dokumen'),
                            'nama_dok'         => $result[2],
                            'no_dokumen'       => strtoupper($this->input->post('no_dokumen')),
                            'lokasi'           => strtoupper($this->input->post('lokasi')),
                            'jml_hlm'          => $this->input->post('jml_hlm'),
                            'id_penyusun'      => $result[3],
                            'tgl_buat'         => $result[4],
                            'status'           => 2,
                            'dok'              => $dokumen
                          );
                        $run = $this->m_dokumen->insert($data, 'upload_dokumen'); 
                        $ambil_data = $this->db->query("SELECT * FROM upload_dokumen WHERE no_dokumen = '$no_dokumen'");
                        $pros = $ambil_data->row();  
                                      $this->convert($pros->dok,$pros->no_dokumen);
                            if($ambil_data->num_rows() > 0){
                                $dokumen=$pros->dok;
                                if(is_file($lok=FCPATH.'/dokumen/'.$dokumen)){
                                    unlink($lok);
                                }
                        }
                        $change = array(
                            'dok'    => $pros->no_dokumen.'.pdf'
                        );
                        $rush = $this->m_dokumen->update(array('no_dokumen'=> $no_dokumen), $change, 'upload_dokumen');
                     
                        $data2 = array(
                        'no_dokumen'          => strtoupper($this->input->post('no_dokumen')),
                        'bidang'              => $result[1],
                        'id_pemeriksa'        => $pem,
                        'tgl_diperiksa'       => $result[4],
                        'id_pengesah'         => $penge,
                        'tgl_disahkan'        => $result[4],   
                        );
                    $ruin = $this->m_dokumen->insert($data2, 'approve_dokumen');
                            if ($run = 1 and $ruin = 1 and $rush = 1){
                            echo $this->session->set_flashdata('pesan', 
                            '<script>
                            swal("Success !", "Upload Dokumen Berhasil", "success"); 
                            </script>');
                            }else{
                            echo $this->session->set_flashdata('pesan', 
                            '<script>
                                swal({
                                title: "Failed",
                                text: "Upload Dokumen Gagal",
                                type: "warning",
                            });
                            </script>');
                         }
                         $delete = $this->m_dokumen->hapus(array('id_upload_dokumen'=>  $param), 'tmp_upload_dokumen');
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
                }
       
        redirect('c_dokumen/list_identitas_dokumen');
    }
}


    public function periksa_dokumen(){
        $hak_akses = $this->session->userdata('hak_akses');

        $cek = $this->m_dokumen->get_pemeriksa("(dokumen_akses.hak_akses = '$hak_akses' AND aksi = 'pemeriksa')")->num_rows();
        if ($cek > 0){
            $data['data'] = $this->m_dokumen->jenis_dokumen("(hak_akses = '$hak_akses' AND aksi = 'pemeriksa')")->result();
            $data['hak_akses'] = $hak_akses; 
            $this->templates->utama('dokumen/v_periksa_dokumen', $data);
        }else{
            $data = array (
                'title'   => 'Akses Tidak Ditemukan',
                'content' => 'Anda belum dapat memeriksa dokumen',
                'url'     => base_url('c_dokumen'),
            );
            $this->templates->utama('pelanggan/v_error',$data);  
        }
    }

    public function sahkan_dokumen(){
        $hak_akses = $this->session->userdata('hak_akses');
        $row = $this->m_dokumen->get_by_id('admin', 'id_auth', $this->session->userdata('id_auth'));
        $bidang = $row->id_bidang; 

        $cek = $this->m_dokumen->get_pemeriksa("(dokumen_akses.hak_akses = '$hak_akses' AND aksi = 'pengesah')")->num_rows();
        if ($cek > 0){
            $data['data'] = $this->m_dokumen->jenis_dokumen("(hak_akses = '$hak_akses' AND aksi = 'pengesah')")->result();
            $data['id_admin'] = $row->id_admin; 
            $this->templates->utama('dokumen/v_sahkan_dokumen', $data);
        }else{
            $data = array (
                'title'   => 'Akses Tidak Ditemukan',
                'content' => 'Anda belum dapat mengesahkan dokumen',
                'url'     => base_url('c_dokumen'),
            );
            $this->templates->utama('pelanggan/v_error',$data);  
        }
    }

    public function action_sahkan($no_dokumen){
        $row = $this->m_dokumen->get_by_id('admin', 'id_auth', $this->session->userdata('id_auth'));
        $row2 = $this->m_dokumen->get_by_id('approve_dokumen', 'no_dokumen', $no_dokumen);
        
        $data = array(
            'status'    => 2
        );
        $data2 = array(
            'id_pengesah'   => $row->id_admin,
            'tgl_disahkan'  => date('Y-m-d')
        );
        $update = $this->m_dokumen->update(array('no_dokumen'=> $no_dokumen), $data, 'upload_dokumen');
        $update = $this->m_dokumen->update(array('id_approve'=> $row2->id_approve), $data2, 'approve_dokumen');

            if ($update = 1){
                echo $this->session->set_flashdata('pesan', 
                    '<script>
                        swal("Success !", "Dokumen berhasil disahkan", "success"); 
                     </script>');
            }else{
                echo $this->session->set_flashdata('pesan', 
                '<script>
                swal({
                title: "Failed",
                text: "Dokumen gagal disahkan",
                type: "warning",
            });
            </script>');
            }
             redirect('c_dokumen/detail_pengesahanDokumen/'.$no_dokumen);
        }
            


    public function list_periksa_dokumen($id_jenis_dokumen){
     
        $row = $this->m_dokumen->get_by_id('admin', 'id_auth', $this->session->userdata('id_auth'));
        $bidang = $row->id_bidang; 

        //cek terlebih dahulu apakah user memiliki bidang atau tidak 
        //jika memiliki bidang maka kueri kan per bidangnya
        if ($bidang != null){
            $data['data'] = $this->m_dokumen->all_dataDokumen("(id_jenis_dokumen = '$id_jenis_dokumen' AND bidang = '$bidang')", "(id_pemeriksa = '$row->id_admin')")->result();
            $data['periksa_ulang'] = $this->m_dokumen->all_dataDokumen("(id_jenis_dokumen = '$id_jenis_dokumen' AND bidang = '$bidang')", "(id_pemeriksa = '$row->id_admin' AND status = '4')")->result();
            $data['id_jenis_dokumen'] = $id_jenis_dokumen;
            $this->templates->utama('dokumen/v_list_periksa_dokumen', $data);     
        }else{
            $data['data'] = $this->m_dokumen->all_dataDokumen("(id_jenis_dokumen = '$id_jenis_dokumen')", "(id_pemeriksa = '$row->id_admin')")->result();
            $data['periksa_ulang'] = $this->m_dokumen->all_dataDokumen("(id_jenis_dokumen = '$id_jenis_dokumen')", "(id_pemeriksa = '$row->id_admin' AND status = '4')")->result();
            $data['id_jenis_dokumen'] = $id_jenis_dokumen;
            $this->templates->utama('dokumen/v_list_periksa_dokumen', $data);   
        }
    }

    public function list_sahkan_dokumen($id_jenis_dokumen){
        $row = $this->m_dokumen->get_by_id('admin', 'id_auth', $this->session->userdata('id_auth'));
        $data['data'] = $this->m_dokumen->all_dataDokumen(array('id_jenis_dokumen'=> $id_jenis_dokumen), "(id_pengesah ='$row->id_admin' AND status != '0')")->result();
        $data['id_jenis_dokumen'] = $id_jenis_dokumen;
        $this->templates->utama('dokumen/v_list_sahkan_dokumen', $data);   
    }

    public function detail_dokumen($no_dokumen, $param){
        if ($param == 'dokumen'){
            $data ['param'] = $param;
            $data['judul'] = "Detail Dokumen";
            $data['judul2'] = "Detail";
            $data['data'] = $this->db->query("SELECT * FROM upload_dokumen JOIN approve_dokumen ON upload_dokumen.no_dokumen = approve_dokumen.no_dokumen WHERE upload_dokumen.no_dokumen = '$no_dokumen'")->result();
            $data['setuju'] = 1 ; 
            $data['edit'] = 0; 
            $this->templates->utama('dokumen/v_detail_identitasDokumen', $data);

        }else if ($param == 'identitas_dokumen'){
            $data ['param'] = $param;
            $data['no_dokumen'] = $no_dokumen;
            $data['judul'] = "Identitas Dokumen";
            $data['judul2'] = "Detail";
            $data['setuju'] = 0; 
            $data['edit'] = 1; 
            $data['data'] = $this->db->query("SELECT * FROM upload_dokumen JOIN approve_dokumen ON upload_dokumen.no_dokumen = approve_dokumen.no_dokumen WHERE upload_dokumen.no_dokumen = '$no_dokumen'")->result();
            $this->templates->utama('dokumen/v_detail_identitasDokumen', $data);

        }else if ($param == 'periksa_ulang'){
            $data ['param'] = $param;
            $data['judul'] = "Periksa Dokumen";
            $data['judul2'] = "Detail";
            $data['data'] = $this->db->query("SELECT * FROM upload_dokumen JOIN approve_dokumen ON upload_dokumen.no_dokumen = approve_dokumen.no_dokumen WHERE upload_dokumen.no_dokumen = '$no_dokumen'")->result();
            $data['setuju'] = 1 ; 
            $data['edit'] = 0; 
            $this->templates->utama('dokumen/v_detail_identitasDokumen', $data);

        }else if ($param == 'all_dokumen'){
            $row = $this->m_dokumen->get_by_id('upload_dokumen', 'no_dokumen', $no_dokumen);
            $data['id_dokumen_induk'] = $row->id_dokumen_induk;
            $cro = $this->m_dokumen->get_by_id('dokumen_induk', 'id_dokumen_induk', $row->id_dokumen_induk);
            $data ['param'] = $param;
            $data['judul'] =  $cro->dokumen;
            $data['judul2'] = "Detail";
            $data['no_dokumen'] = $no_dokumen;
            $data['data'] = $this->db->query("SELECT * FROM upload_dokumen JOIN approve_dokumen ON upload_dokumen.no_dokumen = approve_dokumen.no_dokumen WHERE upload_dokumen.no_dokumen = '$no_dokumen'")->result();
            $data['setuju'] = 0 ; 
            $data['edit'] = 0; 
            $this->templates->utama('dokumen/v_detail_identitasDokumen', $data);
        }
    }


    public function detail_pengesahanDokumen($no_dokumen){
        $data['data'] = $this->db->query("SELECT * FROM upload_dokumen JOIN approve_dokumen ON upload_dokumen.no_dokumen = approve_dokumen.no_dokumen WHERE upload_dokumen.no_dokumen = '$no_dokumen'")->result();
        $this->templates->utama('dokumen/v_detail_pengesahanDokumen', $data);
    }

    public function form_tolak_dokumen(){
        $data['data'] = $this->input->post('rowid');
        $data['action'] = base_url('c_dokumen/action_tolak');
        $this->load->view('dokumen/v_tolak_dokumen', $data);
    }

    public function action_tolak(){
        $row = $this->m_dokumen->get_by_id('admin', 'id_auth', $this->session->userdata('id_auth'));
        $no_dokumen = $this->input->post('no_dokumen');
        $row2 = $this->m_dokumen->get_by_id('approve_dokumen','no_dokumen', $no_dokumen);

		$config['upload_path']          = './dokumen/';
        $config['allowed_types']        = 'docx|rtf';
        $config['remove_space']        =   true;
	
		$this->load->library('upload', $config);
			if($this->upload->do_upload('file')){
				$finfo = $this->upload->data();
				$nama_dokumen = $finfo['file_name'];
                
                $ambil_data = $this->db->query("SELECT * FROM upload_dokumen WHERE no_dokumen = '$no_dokumen'");
			
                if($ambil_data->num_rows() > 0){
                    $pros=$ambil_data->row();
                    $dokumen=$pros->dok;
                        if(is_file($lok=FCPATH.'/dokumen/'.$dokumen)){
                            unlink($lok);
                        }
                    }
                $data = array(
                    'dok'       => $nama_dokumen,
                    'status'    => 3
                ); 
                $data2 = array(
                    'id_pemeriksa'      => $row->id_admin,
                    'tgl_diperiksa'     => date('Y-m-d')
                );

                $update = $this->m_dokumen->update(array('no_dokumen'=> $no_dokumen), $data, 'upload_dokumen');
                $update = $this->m_dokumen->update(array('id_approve'=> $row2->id_approve), $data2, 'approve_dokumen');

              
                    if ($update = 1){
                        echo $this->session->set_flashdata('pesan', 
                        '<script>
                            swal("Success !", "Perbaikan dokumen berhasil", "success"); 
                         </script>');
                    }else{
                        echo $this->session->set_flashdata('pesan', 
                        '<script>
                            swal({
                            title: "Failed",
                            text: "Perbaikan dokumn gagal",
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
			redirect('c_dokumen/detail_dokumen/'.$no_dokumen.'/dokumen');
    }
    

    private function convert($nama_dok, $nomor_dok){
        $objReader= \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
        $posisi = "dokumen/".$nama_dok;
        $contents=$objReader->load($posisi);

        $rendername= \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;

        $renderLibrary="TCPDF";
        $renderLibraryPath=''.$renderLibrary;
        if(!\PhpOffice\PhpWord\Settings::setPdfRenderer($rendername,$renderLibrary)){
            die("Provide Render Library And Path");
        }
        $renderLibraryPath=''.$renderLibrary;
        $objWriter= \PhpOffice\PhpWord\IOFactory::createWriter($contents,'PDF');
        $objWriter->save("dokumen/".$nomor_dok.'.pdf');
    }


    public function action_setuju($no_dokumen){
        $row = $this->m_dokumen->get_by_id('approve_dokumen', 'no_dokumen', $no_dokumen);

        // periksa terlebih dahulu apakah dokumen ini disahkan atau tidak 
        $cek = $this->db->query("SELECT * FROM approve_dokumen WHERE no_dokumen = '$no_dokumen' AND id_pengesah is not null ")->num_rows();
        $ambil_data = $this->db->query("SELECT * FROM upload_dokumen WHERE no_dokumen = '$no_dokumen'");
        $pros = $ambil_data->row();


        if ($cek > 0){
                $this->convert($pros->dok,$pros->no_dokumen);

                if($ambil_data->num_rows() > 0){
                    $dokumen=$pros->dok;
                        if(is_file($lok=FCPATH.'/dokumen/'.$dokumen)){
                            unlink($lok);
                        }
                    }

                $data = array(
                    'status' => 1,
                    'dok'    => $pros->no_dokumen.'.pdf'
                );
                $data_2 = array(
                    'tgl_diperiksa' => date('Y-m-d'),
                );
                }else{
                    $this->convert($pros->dok,$pros->no_dokumen);
                    
                    if($ambil_data->num_rows() > 0){
                        $dokumen=$pros->dok;
                            if(is_file($lok=FCPATH.'/dokumen/'.$dokumen)){
                                unlink($lok);
                            }
                        }
                    $data = array(
                        'status' => 2,
                        'dok'    => $pros->no_dokumen.'.pdf'
                    );  
                    $data_2 = array(
                        'tgl_diperiksa' => date('Y-m-d'),
                        'tgl_disahkan'  => date("Y-m-d")
                    );
                }
                $run = $this->m_dokumen->update(array('no_dokumen'=> $no_dokumen), $data, 'upload_dokumen');
                $run = $this->m_dokumen->update(array('id_approve'=> $row->id_approve), $data_2, 'approve_dokumen');
                if ($run = 1){
                    echo $this->session->set_flashdata('pesan', 
                    '<script>
                        swal("Success !", "Berhasil", "success"); 
                     </script>');
                }else{
                    echo $this->session->set_flashdata('pesan', 
					'<script>
						swal({
						title: "Failed",
						text: "Gagal",
						type: "warning",
						});
						</script>');
                        }
                        redirect('c_dokumen/detail_dokumen/'.$no_dokumen.'/dokumen'); 
                }
               

    public function ajukan_ulang($no_dokumen){

		$config['upload_path']          = './dokumen/';
        $config['allowed_types']        = 'docx|rtf';
        $config['remove_space']         = true;

		$this->load->library('upload', $config);
			if($this->upload->do_upload('file')){
				$finfo = $this->upload->data();
				$nama_dokumen = $finfo['file_name'];
               
                $ambil_data = $this->db->query("SELECT * FROM upload_dokumen WHERE no_dokumen = '$no_dokumen'");
			
                if($ambil_data->num_rows() > 0){
                    $pros=$ambil_data->row();
                    $dokumen=$pros->dok;
                        if(is_file($lok=FCPATH.'/dokumen/'.$dokumen)){
                            unlink($lok);
                        }
                    }
                $data = array(
                    'dok'       => $nama_dokumen,
                    'status'    => 4
                ); 
               
                $update = $this->m_dokumen->update(array('no_dokumen'=> $no_dokumen), $data, 'upload_dokumen');
                    if ($update = 1){
                        echo $this->session->set_flashdata('pesan', 
                        '<script>
                            swal("Success !", "Berhasil diajukan ulang", "success"); 
                         </script>');
                    }else{
                        echo $this->session->set_flashdata('pesan', 
                        '<script>
                            swal({
                            title: "Failed",
                            text: "Gagal diajukan ulang",
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
            redirect('c_dokumen/detail_penolakan/'.$no_dokumen);
    }

    public function list_all_dokumen($id_dokumen_induk){
        $data['data'] = $this->m_dokumen->upload_approve("(id_dokumen_induk = '$id_dokumen_induk' AND status = '2')")->result();
        $data['dokumen_induk'] = $id_dokumen_induk;
        $data['jenis_dokumen'] = $this->db->query("SELECT * FROM jenis_dokumen WHERE id_dokumen_induk = '$id_dokumen_induk'")->result();
        $this->templates->utama('dokumen/v_list_all_dokumen', $data);
    
    }
   
    public function tambah_dokumen(){
        $data['dokumen_induk'] = $this->db->query("SELECT * FROM dokumen_induk")->result();
        $data['user'] = $this->m_admin->data_admin()->result();
        $this->templates->utama('dokumen/v_form_tambah_dokumen', $data);
    }

    public function ajax_user(){
        $user = $this->input->post('user');
        $queri = $this->m_admin->detail_admin($user)->row();
        $row =  $this->m_dokumen->get_by_id('hak_akses', 'id_hak_akses', $queri->hak_akses);
       
        
        $data = array(
            'hak_akses' => $queri->hak_akses,
            'jabatan'   => $row->hak_akses
          ); 
         echo json_encode($data);
    }

    public function list_AlljenisDokumen(){
        $id_dokumen_induk = $this->input->post('dokumen_induk');
        $jenis = $this->m_dokumen->jenis_dokumen("(id_dokumen_induk = '$id_dokumen_induk')")->result();  
        
        // Buat variabel untuk menampung tag-tag option nya    
        // Set defaultnya dengan tag option Pilih    
        $lists = "<option value=''> Jenis Dokumen</option>";       
            foreach($jenis as $data){      
                $lists .= "<option value='".$data->id_jenis_dokumen."'>".$data->nama_dokumen."</option>"; 
            // Tambahkan tag option ke variabel $lists    
        }     
         $callback = array('list_jenis_dokumen'=>$lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota   
          echo json_encode($callback); // konversi varibael $callback menjadi JSON
    }



    public function action_tambah_dokumen(){
        $no_dokumen = $this->input->post('no_dokumen');
        $this->form_validation->set_rules('dokumen_induk','Dokumen Induk','required|trim', array('required'=>'Pilih dokumen induk...!'));
        $this->form_validation->set_rules('jenis_dokumen','Jenis Dokumen','required|trim', array('required'=>'Pilih jenis dokumen...!'));
        $this->form_validation->set_rules('no_dokumen','Nomor Dokumen','required|trim', array('required'=>'Masukkan nomor dokumen...!'));
        $this->form_validation->set_rules('nama_dokumen','Nama Dokumen','required|trim', array('required'=>'Masukkan nama dokumen...!'));
        $this->form_validation->set_rules('lokasi','Lokasi','required|trim', array('required'=>'Masukkan lokasi dokumen...!'));
        $this->form_validation->set_rules('penyusun','Penyusun','required|trim', array('required'=>'Pilih penyusun dokumen...!'));
        $this->form_validation->set_rules('tgl_disusun','Tgl Disusun','required|trim', array('required'=>'Masukkan tanggal...!'));
        $this->form_validation->set_rules('tgl_disahkan','Tanggal Disahkan','required|trim', array('required'=>'Masukkan tanggal...!'));
        $this->form_validation->set_rules('bidang','Bidang','required|trim', array('required'=>'Harap dipilih...!'));

        $id_bidang = $this->input->post('id_bidang');
        $id_pemeriksa = $this->input->post('pemeriksa');
        $id_pengesah = $this->input->post('pengesah');

        //jika tidak ada bidang
        if ($id_bidang == ''){
            $bidang = null;
        }else{
            $bidang = $id_bidang; 
        }

        // jika tidak ada pemeriksa 
        if ($id_pemeriksa == ""){
                $IdPemeriksa = null;
        }else {
                $IdPemeriksa = $id_pemeriksa;   
        }

        if ($id_pengesah == ""){
            $IdPengesah     = null;
        }else {
            $IdPengesah = $id_pengesah;
            }
    
        if (empty($_FILES['file']['name'])){
            $this->form_validation->set_rules('file','File','required|trim', array('required'=>'Lampirkan file...!'));
            }
        
        if ($this->form_validation->run() == false){
            $this->tambah_dokumen($this->uri->segment(3));
        }else{

            $duplicate = $this->db->query("SELECT no_dokumen FROM upload_dokumen WHERE no_dokumen = '$no_dokumen'")->num_rows();
            if ($duplicate > 0 ){
                echo $this->session->set_flashdata('pesan', 
                '<script>
                    swal({
                    title: "Failed",
                    text: "Duplikat nomor dokumen",
                    type: "warning",
                    });
                    </script>');
                redirect('c_dokumen/tambah_dokumen');
            }else{            
            $config['upload_path']          = './dokumen/';
            $config['allowed_types']        = 'pdf';
            $config['remove_space']         = true;
            $this->load->library('upload', $config);
            
            if($this->upload->do_upload('file')){
				$finfo = $this->upload->data();
				$nama_dokumen = $finfo['file_name'];

                $data = array(
                    'no_dokumen'        => strtoupper($this->input->post('no_dokumen')),
                    'id_dokumen_induk'  => $this->input->post('dokumen_induk'),
                    'nama_dok'          => ucwords($this->input->post('nama_dokumen')),
                    'lokasi'            => strtoupper($this->input->post('lokasi')),
                    'id_jenis_dokumen'  => $this->input->post('jenis_dokumen'),
                    'id_penyusun'       => $this->input->post('penyusun'),
                    'status'            => 2,
                    'tgl_buat'      => date('Y-m-d', strtotime($this->input->post('tgl_disusun'))),
                    'dok'               => $nama_dokumen
                ); 
                $update = $this->m_dokumen->insert($data, 'upload_dokumen');

                $data_2  = array(
                    'no_dokumen'        => $no_dokumen,
                    'bidang'            => $bidang,
                    'id_pemeriksa'      => $IdPemeriksa,
                    'id_pengesah'       => $IdPengesah,
                    'tgl_diperiksa'     => 0,
                    'tgl_disahkan'      => date('Y-m-d', strtotime($this->input->post('tgl_disahkan')))
                );
                $update2 = $this->m_dokumen->insert($data_2, 'approve_dokumen');
                    if ($update = 1 AND $update2 = 1){
                        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong><center> Perbaikan dokumen berhasil dikirim </center></strong></div>');
                    }else{
                        $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong><center> Perbaikan dokumen gagal dibuat </center></strong></div>');
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
            redirect('c_dokumen/tambah_dokumen');
            }
        }
    }

    // dikaji lagi dihapus
    public function detail_all_dokumen($no_dokumen){
        $where = array('upload_dokumen.no_dokumen'=> $no_dokumen);
        $row = $this->m_dokumen->get_by_id('upload_dokumen', 'no_dokumen', $no_dokumen);
        $data['id_dokumen_induk'] = $row->id_dokumen_induk;
        $data['data'] = $this->m_dokumen->upload_approve($where)->result();
        $data['data_2'] = $this->m_dokumen->DokumenRevisi($where)->result();
        $data['no_dokumen'] = $no_dokumen; 
        $this->templates->utama('dokumen/v_detail_all_dokumen', $data);
    }
    //end

      public function detail_riwayat($no_dokumen){
        $where = array('upload_dokumen.no_dokumen'=> $no_dokumen);
        $row = $this->db->query("SELECT `status` FROM upload_dokumen WHERE no_dokumen = '$no_dokumen'")->row();
        $data['status'] = $row->status; 
        $data['no_dokumen'] = $no_dokumen; 
        $data['data'] = $this->m_dokumen->upload_approve($where)->result();
        //$data['data_2'] = $this->m_dokumen->DokumenRevisi($where)->result();
        $this->templates->utama('dokumen/v_detail_riwayat',$data);
    }

   
     public function hapus_dokumen($no_dokumen){
            $ambil_data = $this->db->query("SELECT * FROM upload_dokumen WHERE no_dokumen = '$no_dokumen'");
            
            if($ambil_data->num_rows() > 0){
                $pros=$ambil_data->row();
                $dokumen=$pros->dok;
                    if(is_file($lok=FCPATH.'/dokumen/'.$dokumen)){
                        unlink($lok);
                    }
                }

            $where = array('no_dokumen'=> $no_dokumen);
            $delete = $this->m_dokumen->hapus($where, 'upload_dokumen');

            if ($delete = 1){
                echo $this->session->set_flashdata('pesan', 
                '<script>
                    swal("Success !", "Hapus dokumen berhasil", "success"); 
                </script>');
            }else{
                echo $this->session->set_flashdata('pesan', 
                '<script>
                    swal({
                    title: "Failed",
                    text: "Hapus dokumen gagal",
                    type: "warning",
                    });
                    </script>');
            }
            redirect('c_dokumen');
     }


     // edit all dokumen
     public function edit_all_dokumen($param){
        $hak_akses  = $this->session->userdata('hak_akses');
        $no_dokumen = $this->input->post('rowid');
        $where = array('upload_dokumen.no_dokumen'=> $no_dokumen);

        if ($param == 'all_dokumen'){
            $data['param'] = $param; 
            $data['user'] = $this->m_admin->data_admin()->result();
            $data['action'] = base_url('c_dokumen/action_edit_allDokumen');
            $data['dokumen'] = $this->m_dokumen->upload_approve($where)->result();
            $this->load->view('dokumen/v_edit_identitasDokumen', $data);
        }else if ($param == 'identitas_dokumen'){
            $data['param'] = $param;  
            $data['user'] = $this->m_admin->data_admin()->result();
            $data['dokumen'] = $this->m_dokumen->upload_approve($where)->result();
            $data['action'] = base_url('c_dokumen/action_edit_allDokumen');
         
        }
     }


     public function action_edit_allDokumen(){

        $param = $this->input->post('param');
        $no_dokumen = $this->input->post('no_dokumen');
        $where = array('no_dokumen'=>$no_dokumen);

        $id_pemeriksa = $this->input->post('pemeriksa');
        $id_pengesah = $this->input->post('pengesah');

        // jika tidak ada pemeriksa 
        if ($id_pemeriksa == ""){
                $IdPemeriksa = null;
        }else {
                $IdPemeriksa = $id_pemeriksa;   
        }

        if ($id_pengesah == ""){
            $IdPengesah     = null;
        }else {
            $IdPengesah = $id_pengesah;
            }

        if ($this->input->post('ubah_dokumen')){
            
            $config['upload_path']          = './dokumen/';
            $config['allowed_types']        = 'docx';
            $config['remove_space']         = true;

            $ambil_data = $this->db->query("SELECT * FROM upload_dokumen WHERE no_dokumen = '$no_dokumen'");     
            if($ambil_data->num_rows() > 0){
                $pros = $ambil_data->row();
                $dokumen = $pros->dok;
                  if(is_file($lok=FCPATH.'/dokumen/'.$dokumen)){
                    unlink($lok);
                }
            }

            $this->load->library('upload', $config);
            if($this->upload->do_upload('dokumen')){
                $finfo = $this->upload->data();
                $nama_dokumen = $finfo['file_name'];

                $data = array(
                    'id_dokumen_induk'  => $this->input->post('dokumen_induk'),
                    'nama_dok'          => ucwords($this->input->post('nama_dokumen')),
                    'lokasi'            => strtoupper($this->input->post('lokasi')),
                    'id_jenis_dokumen'  => $this->input->post('jenis_dokumen'),
                    'jml_hlm'           => $this->input->post('jml_hlm'),
                    'dok'               => $nama_dokumen
                ); 
                $update = $this->m_dokumen->update($where, $data, 'upload_dokumen');

                $data_2  = array(
                    'id_pemeriksa'      => $IdPemeriksa,
                    'id_pengesah'       =>  $IdPengesah
                );
                $update2 = $this->m_dokumen->update($where, $data_2, 'approve_dokumen');
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
        }else{
            $data = array(
                'id_dokumen_induk'  => $this->input->post('dokumen_induk'),
                'nama_dok'          => ucwords($this->input->post('nama_dokumen')),
                'lokasi'            => strtoupper($this->input->post('lokasi')),
                'id_jenis_dokumen'  => $this->input->post('jenis_dokumen'),
                'jml_hlm'           => $this->input->post('jml_hlm')
            ); 
            $update = $this->m_dokumen->update($where, $data, 'upload_dokumen');

            $data_2  = array(
                'id_pemeriksa'      => $IdPemeriksa,
                'id_pengesah'       =>  $IdPengesah
            );
            $update2 = $this->m_dokumen->update($where, $data_2, 'approve_dokumen');
        }
    
            if ($update  = 1 and $update2 = 1){
                echo $this->session->set_flashdata('pesan', 
                '<script>
                    swal("Success !", "Update dokumen berhasil", "success"); 
                 </script>');
            }else{
                echo $this->session->set_flashdata('pesan', 
                '<script>
                    swal({
                    title: "Failed",
                    text: "Update dokumen gagal",
                    type: "warning",
                    });
                    </script>');
            }
         redirect('c_dokumen/detail_dokumen/'.$no_dokumen.'/'.$param);
     }








     



     // function REVISI

     public function modal_dokumen_revisi($param){
        $data['param'] = $param; 
        $data['no_dokumen'] = $this->input->post('rowid');
        $data['action'] = base_url('c_dokumen/action_upload_dokumenRevisi');
        $data['lampirkan'] = "Lampirkan dokumen revisi";
        $this->load->view('dokumen/v_modal_dokumen_revisi', $data);
    }

    public function modal_editdokumen_revisi($param){
        $data['param'] = $param; 
        $data['no_dokumen'] = $this->input->post('rowid');
        $data['action'] = base_url('c_dokumen/action_edit_dokumenRevisi');
        $data['lampirkan'] = "Lampirkan dokumen revisi (Edit)";
        $this->load->view('dokumen/v_modal_dokumen_revisi', $data);
    }


    public function action_upload_dokumenRevisi(){
        $no_dokumen = $this->input->post('no_dokumen');
        $this_day = date('Y-m-d');

        $param = $this->input->post('param');

        $cek = $this->db->query("SELECT * FROM revisi WHERE no_dokumen = '$no_dokumen' AND tgl_revisi = '$this_day'");

        if ($cek->num_rows() > 0){
            echo $this->session->set_flashdata('pesan', 
            '<script>
                swal({
                title: "Failed",
                text: "Duplikat Dokumen Revisi",
                type: "warning",
                });
                </script>');
        }else{
        $config['upload_path']          = './dokumen_revisi/';
        $config['allowed_types']        = 'pdf';
        $config['remove_space']         =   true;
        
        $this->load->library('upload', $config);
        
        if($this->upload->do_upload('file')){
            $finfo = $this->upload->data();
            $nama_dokumen = $finfo['file_name'];

            $data = array(
                'no_dokumen'        => $no_dokumen,
                'tgl_revisi'        => date('Y-m-d'),
                'dok_revisi'        => $nama_dokumen
            ); 
            $update = $this->m_dokumen->insert($data, 'revisi');
                if ($update = 1 AND $update2 = 1){
                    $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><center> Berhasil </center></strong></div>');
                }else{
                    $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><center> Gagal </center></strong></div>');
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
        }
        if ($param == 'detail_riwayat'){
            redirect('c_dokumen/detail_riwayat/'.$no_dokumen);	
        }else{
            redirect('c_dokumen/detail_all_dokumen/'.$no_dokumen);
        }
       	                
    }


    public function hapus_dokumen_revisi($id_revisi){
        $ambil_data = $this->db->query("SELECT * FROM revisi WHERE id_revisi = '$id_revisi'");
			
		if($ambil_data->num_rows() > 0){
			$pros=$ambil_data->row();
			$dokumen=$pros->dok_revisi;
			    if(is_file($lok=FCPATH.'/dokumen_revisi/'.$dokumen)){
					unlink($lok);
				}
            }
            $where = array('id_revisi'=> $id_revisi);
            $delete = $this->m_dokumen->hapus($where, 'revisi');

            if ($delete = 1){
                echo $this->session->set_flashdata('pesan', 
                '<script>
                    swal("Success !", "Hapus dokumen berhasil", "success"); 
                </script>');
            }else{
                echo $this->session->set_flashdata('pesan', 
                '<script>
                    swal({
                    title: "Failed",
                    text: "Hapus dokumen gagal",
                    type: "warning",
                    });
                    </script>');
            }
            redirect('c_dokumen');
     }

    public function action_edit_dokumenRevisi(){
        $id_revisi = $this->input->post('no_dokumen');
        $row = $this->m_dokumen->get_by_id('revisi','id_revisi', $id_revisi);
        $where = array('id_revisi'=> $id_revisi);

        $config['upload_path']          = './dokumen_revisi/';
        $config['allowed_types']        = 'pdf';
        $config['remove_space']        =   true;

        $ambil_data = $this->db->query("SELECT * FROM revisi WHERE id_revisi = '$id_revisi'");
            
        if($ambil_data->num_rows() > 0){
            $pros=$ambil_data->row();
            $dokumen=$pros->dok_revisi;
                if(is_file($lok=FCPATH.'/dokumen_revisi/'.$dokumen)){
                    unlink($lok);
                }
            }

            $this->load->library('upload', $config);
        
            if($this->upload->do_upload('file')){
                $finfo = $this->upload->data();
                $nama_dokumen = $finfo['file_name'];
    
                $data = array(
                    'dok_revisi'        => $nama_dokumen
                ); 
                $update = $this->m_dokumen->update($where, $data, 'revisi');
                    if ($update = 1 AND $update2 = 1){
                        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong><center> Berhasil </center></strong></div>');
                    }else{
                        $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong><center> Gagal </center></strong></div>');
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
                
                $param = $this->input->post('param');
                if ($param == 'detail_riwayat'){
                    redirect('c_dokumen/detail_riwayat/'.$row->no_dokumen);	
                }else{
                    redirect('c_dokumen/detail_all_dokumen/'.$row->no_dokumen);
                 } 
            }
}
?>