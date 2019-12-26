<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__dir__).'../../PHPWORD/autoload.php';
class C_dokumen extends CI_Controller {

    public function __construct(){
		parent:: __construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('templates');
        $this->load->model('m_dokumen');
        $this->load->model('m_admin');

    
    }

    public function index(){
        $hak_akses = $this->session->userdata('hak_akses');
        $where = array('hak_akses'=> $hak_akses);
        $dokumen['dokumen'] = $this->m_dokumen->akses_dokumen($where)->result_array();
        $this->templates->utama('dokumen/v_dokumen_induk', $dokumen);
        }

    public function form_upload(){
        $where              = array ('id_auth'=> $this->session->userdata('id_auth'));
        $hak_akses       = $this->session->userdata('hak_akses');

        //cek apakah jabatan tersebut sudah memiliki akses untuk mebupload file baru
        $cek = $this->m_dokumen->get_pemeriksa("(dokumen_akses.hak_akses = '$hak_akses' AND aksi = 'penyusun')")->num_rows();
        if ($cek > 0){

        $data['data']       = $this->m_admin->cari_admin($where)->row();
        $data['dok_induk']  = $this->m_dokumen->dokumen_induk("(hak_akses = '$hak_akses' AND aksi = 'penyusun')")->result();
        $this->templates->utama('dokumen/v_upload_dokumen', $data);
        }else{
            $data = array (
                'title'   => 'Akses Tidak Ditemukan',
                'content' => 'Anda belum dapat mengupload dokumen',
                'url'     => base_url('c_dokumen'),
            );
            $this->templates->utama('pelanggan/v_error',$data);  
        }

    }

    public function list_jenisDokumen(){
        $id_dokumen_induk = $this->input->post('dokumen_induk');
        $hak_akses = $this->session->userdata('hak_akses');
        $jenis = $this->m_dokumen->jenis_dokumen("(id_dokumen_induk = '$id_dokumen_induk' AND hak_akses = '$hak_akses')")->result();  
        
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
        $hak_akses = $this->session->userdata('hak_akses');
        $row = $this->m_dokumen->get_by_id('hak_akses', 'id_hak_akses', $hak_akses);
        // ambil id golongan yang mengupload dokumen 
        $golongan = $row->id_golongan; 
        $golongan_pemeriksa = $golongan + 1; 

        // cari golongan yang berhak memeriksa berdasarkan jenis dokumen yang dipilih; 

        if ($golongan < 4){
        $id_jenis_dokumen = $this->input->post('jenis_dokumen');
        $kueri = $this->m_dokumen->get_pemeriksa("(id_jenis_dokumen = '$id_jenis_dokumen' AND id_golongan = '$golongan_pemeriksa' AND aksi = 'pemeriksa')")->result();

        $lists = "<option value=''> Pemeriksa</option>";       
        foreach($kueri as $data){      
            $lists .= "<option value='".$data->id_hak_akses."'>".$data->hak_akses."</option>"; 
        // Tambahkan tag op
        }     
    }else{
            $lists = "<option value= null> Pemeriksa</option>";  
        }
        $callback = array('list_pemeriksa'=>$lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota   
        echo json_encode($callback); // konversi varibael $callback menjadi JSON
    }


    public function action_upload_dokumen(){

        $row = $this->m_dokumen->get_by_id('admin', 'id_auth', $this->session->userdata('id_auth'));
        $id_admin = $row->id_admin;

        $row2 = $this->m_dokumen->get_by_id('hak_akses', 'id_hak_akses', $this->session->userdata('hak_akses'));
        $golongan = $row2->id_golongan; 

        $id_jenis_dokumen = $this->input->post('jenis_dokumen');
        $hak_akses = $this->session->userdata('hak_akses');
        $no_dokumen = $this->input->post('no_dokumen');
        $row3 = $this->m_dokumen->get_by_id('upload_dokumen', 'no_dokumen', $no_dokumen);

        $duplicate = $this->db->query("SELECT no_dokumen FROM upload_dokumen WHERE no_dokumen = '$no_dokumen' AND id_jenis_dokumen = '$row3->id_jenis_dokumen'")->num_rows();
        
        $this->form_validation->set_rules('dokumen_induk','Dokumen Induk','required|trim', array('required'=>'Pilih dokumen induk...!'));
        $this->form_validation->set_rules('jenis_dokumen','Jenis Dokumen','required|trim', array('required'=>'Pilih jenis dokumen...!'));
        $this->form_validation->set_rules('nama_dokumen','Nama Dokumen','required|trim', array('required'=>'Masukkan nama dokumen...!'));
        $this->form_validation->set_rules('pemeriksa','Pemeriksa','required|trim', array('required'=>'Pilih pemeriksa...!'));
        $this->form_validation->set_rules('no_dokumen','Pemeriksa','required|trim', array('required'=>'Masukkan nomor dokumen...!'));


        if (empty($_FILES['dokumen']['name'])){
        $this->form_validation->set_rules('dokumen','Dokumen','required|trim', array('required'=>'Lampirkan file...!'));
        }

        $row2 = $this->m_dokumen->get_by_id('hak_akses', 'id_hak_akses', $this->session->userdata('hak_akses'));
        $golongan = $row2->id_golongan; 

            if ($this->form_validation->run() == false){
                $this->form_upload();
            }else{   
                if ($golongan < 4){
                    $config['upload_path']          = './dokumen/';
                    $config['allowed_types']        = 'doc|docx';
                    $config['max_size']             = 5044070;
            
                    $this->load->library('upload', $config);
                   
                    if($this->upload->do_upload('dokumen')){
                      $finfo = $this->upload->data();
                      $dokumen = $finfo['file_name'];
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
                                $data = array(
                        'id_dokumen_induk' => $this->input->post('dokumen_induk'),
                        'id_jenis_dokumen' => $id_jenis_dokumen,
                        'nama_dok'         => $this->input->post('nama_dokumen'),
                        'no_dokumen'       => $this->input->post('no_dokumen'),
                        'id_penyusun'      => $id_admin, 
                        'jabatan_penyusun' => $hak_akses,
                        'tgl_buat'         => date('Y-m-d'),
                        'status'           => 0,
                        'dok'              =>  $dokumen
                      );
                      $run = $this->m_dokumen->insert($data, 'upload_dokumen'); 
                      $data2 = array(
                        'no_dokumen'          => $this->input->post('no_dokumen'),
                        'bidang'              => $row->id_bidang,
                        'id_pemeriksa'        => null,
                        'jabatan_pemeriksa'   => $this->input->post('pemeriksa'), 
                        'tgl_diperiksa'       => 0,
                        'id_pengesah'         => null,
                        'jabatan_pengesah'    => null,
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
                  }else{ //else
                    $config['upload_path']          = './dokumen/';
                    $config['allowed_types']        = 'doc|docx';
                    $config['max_size']             = 5044070;

                    $this->load->library('upload', $config);
                
                    if($this->upload->do_upload('dokumen')){
                    $finfo = $this->upload->data();
                    $dokumen = $finfo['file_name'];
                    if ($duplicate > 0){
                        echo $this->session->set_flashdata('pesan', 
                        '<script>
                            swal({
                            title: "Failed",
                            text: "Duplikat nomor sampel",
                            type: "warning",
                        });
                        </script>');
                    }else{
    
                    $data = array(
                        'id_dokumen_induk' => $this->input->post('dokumen_induk'),
                        'id_jenis_dokumen' => $id_jenis_dokumen,
                        'nama_dok'         => $this->input->post('nama_dokumen'),
                        'no_dokumen'       => $this->input->post('no_dokumen'),
                        'id_penyusun'      => $id_admin, 
                        'jabatan_penyusun' => $hak_akses,
                        'tgl_buat'         => date('Y-m-d'),
                        'status'           => 2,
                        'dok'              =>  $dokumen
                    );
                    $run = $this->m_dokumen->insert($data, 'upload_dokumen');         
                    if ($run = 1){
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
                            redirect('c_dokumen/form_upload');    
                }
          
        }

    
    public function periksa_dokumen(){
        $hak_akses = $this->session->userdata('hak_akses');

        $cek = $this->m_dokumen->get_pemeriksa("(dokumen_akses.hak_akses = '$hak_akses' AND aksi = 'pemeriksa')")->num_rows();
        if ($cek > 0){
            $data['data'] = $this->m_dokumen->jenis_dokumen("(hak_akses = '$hak_akses' AND aksi = 'pemeriksa')")->result();
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

    public function list_periksa_dokumen($id_jenis_dokumen){
     
        $hak_akses = $this->session->userdata('hak_akses');
        $row = $this->m_dokumen->get_by_id('admin', 'id_auth', $this->session->userdata('id_auth'));
        $bidang = $row->id_bidang; 

        //cek terlebih dahulu apakah user memiliki bidang atau tidak 
        //jika memiliki bidang maka kueri kan per bidangnya

        if ($bidang != null){
            $data['data'] = $this->m_dokumen->all_dataDokumen("(id_jenis_dokumen = '$id_jenis_dokumen' AND bidang = '$bidang')", "(jabatan_pemeriksa = '$hak_akses' AND status = '0')")->result();
            $this->templates->utama('dokumen/v_list_periksa_dokumen', $data);     
        }else{
            echo "usr tidak memiliki id bidang";
        }
    }

    public function detail_dokumen($no_dokumen){
        $data['data'] = $this->db->query("SELECT * FROM upload_dokumen JOIN approve_dokumen ON upload_dokumen.no_dokumen = approve_dokumen.no_dokumen WHERE upload_dokumen.no_dokumen = '$no_dokumen'")->result();
        $this->templates->utama('dokumen/v_detail_dokumen', $data);
    }

    public function form_tolak_dokumen(){
        $data['data'] = $this->input->post('rowid');
        $data['action'] = base_url('c_dokumen/action_tolak');
        $this->load->view('dokumen/v_tolak_dokumen', $data);
    }


    public function action_tolak(){
        $no_dokumen = $this->input->post('no_dokumen');

		$config['upload_path']          = './dokumen/';
		$config['allowed_types']        = 'docx|dox|rtf';
	
		$ambil_data = $this->db->query("SELECT * FROM upload_dokumen WHERE no_dokumen = '$no_dokumen'");
			
		if($ambil_data->num_rows() > 0){
			$pros=$ambil_data->row();
			$dokumen=$pros->dok;
			    if(is_file($lok=FCPATH.'/dokumen/'.$dokumen)){
					unlink($lok);
				}
			}
		$this->load->library('upload', $config);
			if($this->upload->do_upload('file')){
				$finfo = $this->upload->data();
				$nama_dokumen = $finfo['file_name'];

                $data = array(
                    'dok'       => $nama_dokumen,
                    'status'    => 3
                ); 
                $update = $this->m_dokumen->update(array('no_dokumen'=> $no_dokumen), $data, 'upload_dokumen');
                    if ($update = 1){
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
			redirect('c_dokumen/detail_dokumen/'.$no_dokumen);
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
        $objWriter->save("dokumen/".$nomor_dok.'.pdf', 'PDF');
    }


    public function action_setuju($id_jenis_dokumen, $no_dokumen){

        // periksa terlebih dahulu apakah dokumen ini disahkan atau tidak 
        $cek = $this->db->query("SELECT * FROM dokumen_akses WHERE id_jenis_dokumen = '$id_jenis_dokumen' AND aksi = 'pengesah'")->num_rows();
        
        if ($cek > 0){
               
                }else{
                    $ambil_data = $this->db->query("SELECT * FROM upload_dokumen WHERE no_dokumen = '$no_dokumen'");
                    $pros = $ambil_data->row();
    
                    $this->convert($pros->dok,$pros->no_dokumen);
                    
                    if($ambil_data->num_rows() > 0){
                        $dokumen=$pros->dok;
                            if(is_file($lok=FCPATH.'/dokumen/'.$dokumen)){
                                unlink($lok);
                            }
                        }

                    $data = array(
                        'status' => 1,
                        'dok'    => $pros->no_dokumen
                    );
                    $run = $this->m_dokumen->update(array('no_dokumen'=> $no_dokumen), $data, 'upload_dokumen');
                        if ($run = 1){
                            $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><center> Dokumen Sukses </center></strong></div>');
                        }else{
                            $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong><center> Dokumen Gagal </center></strong></div>');
                        }
                }
                redirect('c_dokumen/detail_dokumen/'.$no_dokumen);  

    }
   











































// function dokumen lama ke bawah 
    public function dokumen_mutu(){
        $hak_akses = $this->session->userdata('hak_akses');
        $table = 'dokumen_mutu';
        $data['dokumen'] = $this->m_dokumen->all_dokumen($table)->result_array();
        if ($hak_akses == "admin_sampel"){
        $this->templates->utama('dokumen/v_dokumen_mutu', $data);
        }
        else if ($hak_akses == "ka_laboratorium" or $hak_akses == "manajer_mutu" or $hak_akses == "manajer_operasional"
        or $hak_akses == "manajer_puncak"){
            $this->templates->all_manager('dokumen/v_dokumen_mutu', $data);
        }
        else if ($hak_akses == "manajer_teknik_mikro" or $hak_akses == "manajer_teknik_kimia" or $hak_akses = "manajer_teknik_farma"){
            $this->templates->manager_teknik('dokumen/v_dokumen_mutu');
        }
    }

    public function dokumen_prosedur(){
        $hak_akses = $this->session->userdata('hak_akses');
        $table = 'dokumen_prosedur';
        $data['dokumen'] = $this->m_dokumen->all_dokumen($table)->result_array();
        if ($hak_akses == "admin_sampel"){
        $this->templates->utama('dokumen/v_dokumen_prosedur', $data);
        }
        else if ($hak_akses == "ka_laboratorium" or $hak_akses == "manajer_mutu" or $hak_akses == "manajer_operasional"
        or $hak_akses == "manajer_puncak"){
            $this->templates->all_manager('dokumen/v_dokumen_prosedur', $data);
        }
        else if ($hak_akses == "manajer_teknik_mikro" or $hak_akses == "manajer_teknik_kimia" or $hak_akses = "manajer_teknik_farma"){
            $this->templates->manager_teknik('dokumen/v_dokumen_prosedur');
        }
        else if ($hak_akses == "penyelia"){
            $this->templates->penyelia('dokumen/v_dokumen_prosedur');
        }
    }

     public function dokumen_instruksi_kerja(){
        $hak_akses = $this->session->userdata('hak_akses');
        $table = 'dokumen_instruksi_kerja';
        $data['dokumen'] = $this->m_dokumen->all_dokumen($table)->result_array();
        if ($hak_akses == "admin_sampel"){
            $this->templates->utama('dokumen/v_dokumen_instruksi_kerja', $data);
            }
            else if ($hak_akses == "ka_laboratorium" or $hak_akses == "manajer_mutu" or $hak_akses == "manajer_operasional"
            or $hak_akses == "manajer_puncak" or $hak_akses == "analis"){
                $this->templates->all_manager('dokumen/v_dokumen_instruksi_kerja', $data);
            }
            else if ($hak_akses == "manajer_teknik_mikro" or $hak_akses == "manajer_teknik_kimia" or $hak_akses = "manajer_teknik_farma"){
                $this->templates->manager_teknik('dokumen/v_instruksi_kerja');
            }
            else if ($hak_akses == "penyelia"){
                $this->templates->penyelia('dokumen/v_dokumen_instruksi_kerja');
            }
    }

    public function dokumen_form(){
        $hak_akses = $this->session->userdata('hak_akses');
        $table = 'dokumen_form';
        $data['dokumen'] = $this->m_dokumen->all_dokumen($table)->result_array();
        if ($hak_akses == "admin_sampel"){
            $this->templates->utama('dokumen/v_dokumen_form', $data);
            }
            else if ($hak_akses == "ka_laboratorium" or $hak_akses == "manajer_mutu" or $hak_akses == "manajer_operasional"
            or $hak_akses == "manajer_puncak" or $hak_akses == "analis"){
                $this->templates->all_manager('dokumen/v_dokumen_form', $data);
            }
            else if ($hak_akses == "manajer_teknik_mikro" or $hak_akses == "manajer_teknik_kimia" or $hak_akses = "manajer_teknik_farma"){
                $this->templates->manager_teknik('dokumen/v_dokumen_form');
            }
            else if ($hak_akses == "penyelia"){
                $this->templates->penyelia('dokumen/v_dokumen_form');
            }
    }

    public function upload_dokumen(){
        $data['dokumen'] = $this->m_dokumen->dokumen()->result_array();
        $this->templates->utama('dokumen/v_upload_dokumen', $data);
    }

    public function insert_dokumen(){
       $jenis_dokumen  = $this->input->post('jenis_dokumen');   
       $judul   = $this->input->post('judul');
       $kode   = $this->input->post('kode');
       $lokasi   = $this->input->post('lokasi');
       $dokumen   = $this->input->post('dokumen');
        
       //DOKUMEN MUTU
        if  ($jenis_dokumen == '1'){

            $config['upload_path']          = './dokumen_mutu/';
            $config['allowed_types']        = 'pdf';
            $config['max_size']             = 5044070;
            
            $this->load->library('upload', $config);
            if($this->upload->do_upload('dokumen')){
                $finfo = $this->upload->data();
                $nama_dokumen = $finfo['file_name'];
                
        $dokumen_mutu = array(
           'judul'  => $judul,
           'kode'   => $kode,
           'lokasi' => $lokasi,
           'nama_dokumen'  => $nama_dokumen,
           'dibuat' => date('Y-m-d')
        );
    
        $insert_mutu['res'] = $this->m_dokumen->insert_dokumen($dokumen_mutu, 'dokumen_mutu');
        
        $id_dm = $this->db->insert_id();
        $tr_mutu = array(
            'id_dm'         => $id_dm
        );
        $insert_tr_mutu['doc'] = $this->m_dokumen->insert_dokumen($tr_mutu, 'tr_dokumen_mutu');

            if ($insert_mutu and $insert_tr_mutu ){
                $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				 <b>Sukses...!</b> Sukses Upload Dokumen </div>');
            }else{
                $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				 <b>Gagal...!</b> Gagal Upload Dokumen </div>');
            }
        }else{
            echo $this->session->set_flashdata('pesan', 
					'<script>
								swal({
								title: "Access Deny",
								text: " File Not Supported",
								type: "warning",
								});
							</script>');
        }
        redirect ('c_dokumen/dokumen_mutu');

        }else if ($jenis_dokumen == '2'){
            $config['upload_path']          = './dokumen_prosedur/';
            $config['allowed_types']        = 'pdf';
            $config['max_size']             = 5044070;
            
            $this->load->library('upload', $config);
            if($this->upload->do_upload('dokumen')){
                $finfo = $this->upload->data();
                $nama_dokumen = $finfo['file_name'];
                
        $dokumen_prosedur = array(
           'judul'  => $judul,
           'kode'   => $kode,
           'lokasi' => $lokasi,
           'nama_dokumen'  => $nama_dokumen,
           'dibuat' => date('Y-m-d')
        );
    
        $insert_prosedur['res'] = $this->m_dokumen->insert_dokumen($dokumen_prosedur, 'dokumen_prosedur');
        
        $id_dp = $this->db->insert_id();
        $tr_prosedur = array(
            'id_dp'         => $id_dp
        );
        $insert_tr_prosedur['doc'] = $this->m_dokumen->insert_dokumen($tr_prosedur, 'tr_dokumen_prosedur');

            if ($insert_prosedur and $insert_tr_prosedur ){
                $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				 <b>Sukses...!</b> Sukses Upload Dokumen </div>');
            }else{
                $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				 <b>Gagal...!</b> Gagal Upload Dokumen </div>');
            }
        }else{
            echo $this->session->set_flashdata('pesan', 
					'<script>
								swal({
								title: "Access Deny",
								text: " File Not Supported",
								type: "warning",
								});
							</script>');
        }
        redirect ('c_dokumen/dokumen_prosedur');

        }else if ($jenis_dokumen == '3'){
            $config['upload_path']          = './dokumen_instruksi_kerja/';
            $config['allowed_types']        = 'pdf';
            $config['max_size']             = 5044070;
            
            $this->load->library('upload', $config);
            if($this->upload->do_upload('dokumen')){
                $finfo = $this->upload->data();
                $nama_dokumen = $finfo['file_name'];
                
        $dokumen_ik = array(
           'judul'  => $judul,
           'kode'   => $kode,
           'lokasi' => $lokasi,
           'nama_dokumen'  => $nama_dokumen,
           'dibuat' => date('Y-m-d')
        );
    
        $insert_ik['res'] = $this->m_dokumen->insert_dokumen($dokumen_ik, 'dokumen_instruksi_kerja');
        
        $id_dik = $this->db->insert_id();
        $tr_ik = array(
            'id_dik'         => $id_dik
        );
        $insert_tr_ik['doc'] = $this->m_dokumen->insert_dokumen($tr_ik, 'tr_dokumen_instruksi_kerja');

            if ($insert_ik and $insert_tr_ik ){
                $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				 <b>Sukses...!</b> Sukses Upload Dokumen </div>');
            }else{
                $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				 <b>Gagal...!</b> Gagal Upload Dokumen </div>');
            }
        }else{
            echo $this->session->set_flashdata('pesan', 
					'<script>
								swal({
								title: "Access Deny",
								text: " File Not Supported",
								type: "warning",
								});
							</script>');
        }
        redirect ('c_dokumen/dokumen_instruksi_kerja');

        }else if ($jenis_dokumen == '4'){
            $config['upload_path']          = './dokumen_form/';
            $config['allowed_types']        = 'pdf';
            $config['max_size']             = 5044070;
            
            $this->load->library('upload', $config);
            if($this->upload->do_upload('dokumen')){
                $finfo = $this->upload->data();
                $nama_dokumen = $finfo['file_name'];
                
        $dokumen_form = array(
           'judul'  => $judul,
           'kode'   => $kode,
           'lokasi' => $lokasi,
           'nama_dokumen'  => $nama_dokumen,
           'dibuat' => date('Y-m-d')
        );
    
        $insert_form['res'] = $this->m_dokumen->insert_dokumen($dokumen_form, 'dokumen_form');
        
        $id_df = $this->db->insert_id();
        $tr_form = array(
            'id_df'         => $id_df
        );
        $insert_tr_form['doc'] = $this->m_dokumen->insert_dokumen($tr_form, 'tr_dokumen_form');

            if ($insert_form and $insert_tr_form ){
                $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				 <b>Sukses...!</b> Sukses Upload Dokumen </div>');
            }else{
                $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				 <b>Gagal...!</b> Gagal Upload Dokumen </div>');
            }
        }else{
            echo $this->session->set_flashdata('pesan', 
					'<script>
								swal({
								title: "Access Deny",
								text: " File Not Supported",
								type: "warning",
								});
							</script>');
        }
        redirect ('c_dokumen/dokumen_form');
        }
        
        else{
            echo $this->session->set_flashdata('pesan', 
					'<script>
								swal({
								title: "Access Deny",
								text: " Pilih Jenis Dokumen",
								type: "warning",
								});
                            </script>');
        }
        redirect('c_dokumen/upload_dokumen');
        
    }

    public function detail_dokumen_mutu(){
        $id_dm = $this->input->post('rowid');
        $where = array('id_dm' => $id_dm);
        $dokumen['revisi'] = $this->m_dokumen->revisi_dokumen($where, 'tr_dokumen_mutu')->result_array();
        $dokumen['dokumen_mutu'] = $this->m_dokumen->detail_dokumen($where, 'dokumen_mutu')->result_array();
        $this->load->view('dokumen/v_detail_dokumen_mutu', $dokumen);
    }

    public function detail_dokumen_prosedur(){
        $id_dp = $this->input->post('rowid');
        $where = array('id_dp' => $id_dp);
        $dokumen['revisi'] = $this->m_dokumen->revisi_dokumen($where, 'tr_dokumen_prosedur')->result_array();
        $dokumen['dokumen_prosedur'] = $this->m_dokumen->detail_dokumen($where, 'dokumen_prosedur')->result_array();
        $this->load->view('dokumen/v_detail_dokumen_prosedur', $dokumen);
    }

    public function detail_dokumen_instruksi_kerja(){
        $id_dik = $this->input->post('rowid');
        $where = array('id_dik' => $id_dik);
        $dokumen['revisi'] = $this->m_dokumen->revisi_dokumen($where, 'tr_dokumen_instruksi_kerja')->result_array();
        $dokumen['dokumen_ik'] = $this->m_dokumen->detail_dokumen($where, 'dokumen_instruksi_kerja')->result_array();
        $this->load->view('dokumen/v_detail_dokumen_instruksi_kerja', $dokumen);
    }

    public function detail_dokumen_form(){
        $id_df = $this->input->post('rowid');
        $where = array('id_df' => $id_df);
        $dokumen['revisi'] = $this->m_dokumen->revisi_dokumen($where, 'tr_dokumen_form')->result_array();
        $dokumen['dokumen_form'] = $this->m_dokumen->detail_dokumen($where, 'dokumen_form')->result_array();
        $this->load->view('dokumen/v_detail_dokumen_form', $dokumen);
    }


    public function hapus_dokumen_mutu($id_dm){
        if ($this->session->userdata('hak_akses') != "admin_sampel"){
            echo $this->session->set_flashdata('pesan', 
            '<script>
                        swal({
                        title: "Access Deny",
                        text: " Akses Ditolak",
                        type: "warning",
                        });
                    </script>');
                    
    }else{
    $where = array('id_dm' => $id_dm);
    $hasil  = $this->m_dokumen->hapus_dokumen($where,'dokumen_mutu');
        if($hasil){
            echo $this->session->set_flashdata('pesan', 
            '<script>
            swal("Success !", "Sukses Hapus Data !", "success"); 
            </script>');
        }else
        {
            echo $this->session->set_flashdata('pesan', 
            '<script>
                        swal({
                        title: "Failed",
                        text: "Gagal Hapus Data",
                        type: "warning",
                        });
                    </script>');
        }
    }
    redirect('c_dokumen/dokumen_mutu');	
    }

    public function hapus_dokumen_prosedur($id_dp){
        if ($this->session->userdata('hak_akses') != "admin_sampel"){
            echo $this->session->set_flashdata('pesan', 
            '<script>
                        swal({
                        title: "Access Deny",
                        text: " Akses Ditolak",
                        type: "warning",
                        });
                    </script>');
                    
    }else{
    $where = array('id_dp' => $id_dp);
    $hasil  = $this->m_dokumen->hapus_dokumen($where,'dokumen_prosedur');
        if($hasil){
            echo $this->session->set_flashdata('pesan', 
            '<script>
            swal("Success !", "Sukses Hapus Data !", "success"); 
            </script>');
        }else
        {
            echo $this->session->set_flashdata('pesan', 
            '<script>
                        swal({
                        title: "Failed",
                        text: "Gagal Hapus Data",
                        type: "warning",
                        });
                    </script>');
        }
    }
    redirect('c_dokumen/dokumen_prosedur');	
    }

    public function hapus_dokumen_instruksi_kerja($id_dik){
        if ($this->session->userdata('hak_akses') != "admin_sampel"){
            echo $this->session->set_flashdata('pesan', 
            '<script>
                        swal({
                        title: "Access Deny",
                        text: " Akses Ditolak",
                        type: "warning",
                        });
                    </script>');
                    
    }else{
    $where = array('id_dik' => $id_dik);
    $hasil  = $this->m_dokumen->hapus_dokumen($where,'dokumen_instruksi_kerja');
        if($hasil){
            echo $this->session->set_flashdata('pesan', 
            '<script>
            swal("Success !", "Sukses Hapus Data !", "success"); 
            </script>');
        }else
        {
            echo $this->session->set_flashdata('pesan', 
            '<script>
                        swal({
                        title: "Failed",
                        text: "Gagal Hapus Data",
                        type: "warning",
                        });
                    </script>');
        }
    }
    redirect('c_dokumen/dokumen_instruksi_kerja');	
    }

    public function hapus_dokumen_form($id_df){
        if ($this->session->userdata('hak_akses') != "admin_sampel"){
            echo $this->session->set_flashdata('pesan', 
            '<script>
                        swal({
                        title: "Access Deny",
                        text: " Akses Ditolak",
                        type: "warning",
                        });
                    </script>');
                    
    }else{
    $where = array('id_df' => $id_df);
    $hasil  = $this->m_dokumen->hapus_dokumen($where,'dokumen_form');
        if($hasil){
            echo $this->session->set_flashdata('pesan', 
            '<script>
            swal("Success !", "Sukses Hapus Data !", "success"); 
            </script>');
        }else
        {
            echo $this->session->set_flashdata('pesan', 
            '<script>
                        swal({
                        title: "Failed",
                        text: "Gagal Hapus Data",
                        type: "warning",
                        });
                    </script>');
        }
    }
    redirect('c_dokumen/dokumen_form');	
    }

    public function update_dokumen_mutu(){
        $id_dm = $this->input->post('id_dm');
        if($this->input->post('ubah_dokumen')){
			$config['upload_path']          = './dokumen_mutu/';
			$config['allowed_types']        = 'pdf';
            $config['max_size']             = 5044070;
            
            $where= array('id_dm'=> $id_dm);
			$ambil_data = $this->m_dokumen->ambil_dokumen($where, 'dokumen_mutu');
            
			if($ambil_data->num_rows() > 0){
				$pros=$ambil_data->row();
				$dokumen=$pros->nama_dokumen;
				
				  if(is_file($lok=FCPATH.'/dokumen_mutu/'.$dokumen)){
					unlink($lok);
				}
			}

			$this->load->library('upload', $config);
			
			if($this->upload->do_upload('dokumen')){
				$finfo = $this->upload->data();
				$nama_dokumen = $finfo['file_name'];

		$data = array(
            'id_dm'     =>$id_dm,
            'revisi'    => date('Y-m-d')
		);
		$data2 = array(
			'judul'             => $this->input->post('judul'),
			'kode'              => $this->input->post('kode'),
			'lokasi'            => $this->input->post('no_telp'),
            'nama_dokumen'      => $nama_dokumen
		);
        $hasi['res'] = $this->m_dokumen->insert_dokumen($data,'tr_dokumen_mutu');
        
		$hasil['res'] = $this->m_dokumen->update_dokumen($where, $data2, 'dokumen_mutu');
			if($hasil){
				echo $this->session->set_flashdata('pesan', 
						'<script>
						swal("Success !", "Sukses Update Dokumen !", "success"); 
						</script>');
			}
			else{
				echo $this->session->set_flashdata('pesan', 
				'<script>
					swal({
					title: "Failed",
					text: "Gagal Update Dokumen",
					type: "warning",
					});
				</script>');
				}
			}else{
				echo $this->session->set_flashdata('pesan', 
							'<script>
								swal({
								title: "Failed",
								text: "File Not Supported",
								type: "warning",
								});
							</script>');
							}
		}
	else{
		$data = array(
			'judul'      => $this->input->post('judul'),
			'kode'   => $this->input->post('kode'),
			'lokasi'   => $this->input->post('lokasi')
        );
        
		$where = array('id_dm'=>$id_dm);
		$hasil['res'] = $this->m_dokumen->update_dokumen($where, $data, 'dokumen_mutu');
			if($hasil){
				echo $this->session->set_flashdata('pesan', 
						'<script>
						swal("Success !", "Success Update Data !", "success"); 
						</script>');
			}
			else{
				echo $this->session->set_flashdata('pesan', 
				'<script>
					swal({
					title: "Failed",
					text: "Failed Update Data",
					type: "warning",
					});
				</script>');
				}
				
    }
    redirect('c_dokumen/dokumen_mutu');
        
    }

    public function update_dokumen_prosedur(){
        $id_dp = $this->input->post('id_dp');
        if($this->input->post('ubah_dokumen')){
			$config['upload_path']          = './dokumen_prosedur/';
			$config['allowed_types']        = 'pdf';
            $config['max_size']             = 5044070;
            
            $where= array('id_dp'=> $id_dp);
			$ambil_data = $this->m_dokumen->ambil_dokumen($where, 'dokumen_prosedur');
            
			if($ambil_data->num_rows() > 0){
				$pros=$ambil_data->row();
				$dokumen=$pros->nama_dokumen;
				
				  if(is_file($lok=FCPATH.'/dokumen_prosedur/'.$dokumen)){
					unlink($lok);
				}
			}

			$this->load->library('upload', $config);
			
			if($this->upload->do_upload('dokumen')){
				$finfo = $this->upload->data();
				$nama_dokumen = $finfo['file_name'];

		$data = array(
            'id_dp'     =>$id_dp,
            'revisi'    => date('Y-m-d')
		);
		$data2 = array(
			'judul'             => $this->input->post('judul'),
			'kode'              => $this->input->post('kode'),
			'lokasi'            => $this->input->post('no_telp'),
            'nama_dokumen'      => $nama_dokumen
		);
        $hasi['res'] = $this->m_dokumen->insert_dokumen($data,'tr_dokumen_prosedur');
    
		$hasil['res'] = $this->m_dokumen->update_dokumen($where, $data2, 'dokumen_prosedur');
			if($hasil){
				echo $this->session->set_flashdata('pesan', 
						'<script>
						swal("Success !", "Sukses Update Dokumen !", "success"); 
						</script>');
			}
			else{
				echo $this->session->set_flashdata('pesan', 
				'<script>
					swal({
					title: "Failed",
					text: "Gagal Update Dokumen",
					type: "warning",
					});
				</script>');
				}
			}else{
				echo $this->session->set_flashdata('pesan', 
							'<script>
								swal({
								title: "Failed",
								text: "File Not Supported",
								type: "warning",
								});
							</script>');
							}
		}
	else{
		$data = array(
			'judul'      => $this->input->post('judul'),
			'kode'   => $this->input->post('kode'),
			'lokasi'   => $this->input->post('lokasi')
        );
        
		$where = array('id_dp'=>$id_dp);
		$hasil['res'] = $this->m_dokumen->update_dokumen($where, $data, 'dokumen_prosedur');
			if($hasil){
				echo $this->session->set_flashdata('pesan', 
						'<script>
						swal("Success !", "Success Update Data !", "success"); 
						</script>');
			}
			else{
				echo $this->session->set_flashdata('pesan', 
				'<script>
					swal({
					title: "Failed",
					text: "Failed Update Data",
					type: "warning",
					});
				</script>');
				}
				
    }
    redirect('c_dokumen/dokumen_prosedur');

    }

    public function update_dokumen_instruksi_kerja(){
        $id_dik = $this->input->post('id_dik');
        if($this->input->post('ubah_dokumen')){
			$config['upload_path']          = './dokumen_instruksi_kerja/';
			$config['allowed_types']        = 'pdf';
            $config['max_size']             = 5044070;
            
            $where= array('id_dik'=> $id_dik);
			$ambil_data = $this->m_dokumen->ambil_dokumen($where, 'dokumen_instruksi_kerja');
            
			if($ambil_data->num_rows() > 0){
				$pros=$ambil_data->row();
				$dokumen=$pros->nama_dokumen;
				
				  if(is_file($lok=FCPATH.'/dokumen_instruksi_kerja/'.$dokumen)){
					unlink($lok);
				}
			}

			$this->load->library('upload', $config);
			
			if($this->upload->do_upload('dokumen')){
				$finfo = $this->upload->data();
				$nama_dokumen = $finfo['file_name'];

		$data = array(
            'id_dik'     =>$id_dik,
            'revisi'    => date('Y-m-d')
		);
		$data2 = array(
			'judul'             => $this->input->post('judul'),
			'kode'              => $this->input->post('kode'),
			'lokasi'            => $this->input->post('no_telp'),
            'nama_dokumen'      => $nama_dokumen
		);
        $hasi['res'] = $this->m_dokumen->insert_dokumen($data,'tr_dokumen_instruksi_kerja');
    
		$hasil['res'] = $this->m_dokumen->update_dokumen($where, $data2, 'dokumen_instruksi_kerja');
			if($hasil){
				echo $this->session->set_flashdata('pesan', 
						'<script>
						swal("Success !", "Sukses Update Dokumen !", "success"); 
						</script>');
			}
			else{
				echo $this->session->set_flashdata('pesan', 
				'<script>
					swal({
					title: "Failed",
					text: "Gagal Update Dokumen",
					type: "warning",
					});
				</script>');
				}
			}else{
				echo $this->session->set_flashdata('pesan', 
							'<script>
								swal({
								title: "Failed",
								text: "File Not Supported",
								type: "warning",
								});
							</script>');
							}
		}
	else{
		$data = array(
			'judul'      => $this->input->post('judul'),
			'kode'   => $this->input->post('kode'),
			'lokasi'   => $this->input->post('lokasi')
        );
        
		$where = array('id_dik'=>$id_dik);
		$hasil['res'] = $this->m_dokumen->update_dokumen($where, $data, 'dokumen_instruksi_kerja');
			if($hasil){
				echo $this->session->set_flashdata('pesan', 
						'<script>
						swal("Success !", "Success Update Data !", "success"); 
						</script>');
			}
			else{
				echo $this->session->set_flashdata('pesan', 
				'<script>
					swal({
					title: "Failed",
					text: "Failed Update Data",
					type: "warning",
					});
				</script>');
				}
				
    }
    redirect('c_dokumen/dokumen_instruksi_kerja');

    }

    public function update_dokumen_form(){
        $id_df = $this->input->post('id_df');
        if($this->input->post('ubah_dokumen')){
			$config['upload_path']          = './dokumen_form/';
			$config['allowed_types']        = 'pdf';
            $config['max_size']             = 5044070;
            
            $where= array('id_df'=> $id_df);
			$ambil_data = $this->m_dokumen->ambil_dokumen($where, 'dokumen_form');
            
			if($ambil_data->num_rows() > 0){
				$pros=$ambil_data->row();
				$dokumen=$pros->nama_dokumen;
				
				  if(is_file($lok=FCPATH.'/dokumen_form/'.$dokumen)){
					unlink($lok);
				}
			}

			$this->load->library('upload', $config);
			
			if($this->upload->do_upload('dokumen')){
				$finfo = $this->upload->data();
				$nama_dokumen = $finfo['file_name'];

		$data = array(
            'id_df'     =>$id_df,
            'revisi'    => date('Y-m-d')
		);
		$data2 = array(
			'judul'             => $this->input->post('judul'),
			'kode'              => $this->input->post('kode'),
			'lokasi'            => $this->input->post('no_telp'),
            'nama_dokumen'      => $nama_dokumen
		);
        $hasi['res'] = $this->m_dokumen->insert_dokumen($data,'tr_dokumen_form');
    
		$hasil['res'] = $this->m_dokumen->update_dokumen($where, $data2, 'dokumen_form');
			if($hasil){
				echo $this->session->set_flashdata('pesan', 
						'<script>
						swal("Success !", "Sukses Update Dokumen !", "success"); 
						</script>');
			}
			else{
				echo $this->session->set_flashdata('pesan', 
				'<script>
					swal({
					title: "Failed",
					text: "Gagal Update Dokumen",
					type: "warning",
					});
				</script>');
				}
			}else{
				echo $this->session->set_flashdata('pesan', 
							'<script>
								swal({
								title: "Failed",
								text: "File Not Supported",
								type: "warning",
								});
							</script>');
							}
		}
	else{
		$data = array(
			'judul'      => $this->input->post('judul'),
			'kode'   => $this->input->post('kode'),
			'lokasi'   => $this->input->post('lokasi')
        );
        
		$where = array('id_df'=>$id_df);
		$hasil['res'] = $this->m_dokumen->update_dokumen($where, $data, 'dokumen_form');
			if($hasil){
				echo $this->session->set_flashdata('pesan', 
						'<script>
						swal("Success !", "Success Update Data !", "success"); 
						</script>');
			}
			else{
				echo $this->session->set_flashdata('pesan', 
				'<script>
					swal({
					title: "Failed",
					text: "Failed Update Data",
					type: "warning",
					});
				</script>');
				}
				
    }
    redirect('c_dokumen/dokumen_form');

    }


    public function belajar(){
        $this->load->view('dokumen/form');
    }

    public function tangkap(){

        if (isset($_SESSION['nama'])) {
            $nama = $_SESSION['nama'];
           }
           if (isset($_SESSION['alamat'])) {
            $alamat = $_SESSION['alamat'];
           }

           if (isset($_SESSION['hobi'])) {
            $hobi = $_SESSION['hobi'];
           }

        $nama[] =$this->input->post('nama');
        $alamat[] = $this->input->post('alamat');
        $hobi[] = $this->input->post('hobi');

      
    

        $_SESSION['nama'] = $nama;
        $_SESSION['alamat'] = $alamat;
        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";
      

        $this->load->view('dokumen/form');
    }

    public function destroy(){
        unset(
            $_SESSION['nama'],
            $_SESSION['alamat'],
            $_SESSION['hobi']
        );
        redirect('c_dokumen/belajar');
    }

    public function des($nama){
        unset(
            $_SESSION['nama']
        );
    redirect('c_dokumen/belajar');
    }



}
?>