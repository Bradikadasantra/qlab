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

    public function detail_riwayat($no_dokumen){
        $where = array('upload_dokumen.no_dokumen'=> $no_dokumen);
        $row = $this->db->query("SELECT `status` FROM upload_dokumen WHERE no_dokumen = '$no_dokumen'")->row();
        $data['status'] = $row->status; 
        $data['no_dokumen'] = $no_dokumen; 
        $data['data'] = $this->m_dokumen->upload_approve($where)->result();
        $data['data_2'] = $this->m_dokumen->DokumenRevisi($where)->result();
        $this->templates->utama('dokumen/v_detail_riwayat',$data);

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

        $duplicate = $this->db->query("SELECT no_dokumen FROM upload_dokumen WHERE no_dokumen = '$no_dokumen'")->num_rows();
        
        $this->form_validation->set_rules('dokumen_induk','Dokumen Induk','required|trim', array('required'=>'Pilih dokumen induk...!'));
        $this->form_validation->set_rules('jenis_dokumen','Jenis Dokumen','required|trim', array('required'=>'Pilih jenis dokumen...!'));
        $this->form_validation->set_rules('nama_dokumen','Nama Dokumen','required|trim', array('required'=>'Masukkan nama dokumen...!'));
        $this->form_validation->set_rules('pemeriksa','Pemeriksa','required|trim', array('required'=>'Pilih pemeriksa...!'));
        $this->form_validation->set_rules('no_dokumen','No Dokumen','required|trim', array('required'=>'Masukkan nomor dokumen...!'));
        $this->form_validation->set_rules('lokasi','Lokasi','required|trim', array('required'=>'Masukkan lokasi dokumen...!'));


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
                    $config['remove_space']             = true;
            
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
                        'nama_dok'         => ucwords($this->input->post('nama_dokumen')),
                        'no_dokumen'       => strtoupper($this->input->post('no_dokumen')),
                        'lokasi'           => strtoupper($this->input->post('lokasi')),
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
                    $config['allowed_types']        = 'pdf';
                    $config['remove_space']         = true;

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
                        'nama_dok'         => ucwords($this->input->post('nama_dokumen')),
                        'no_dokumen'       => strtoupper($this->input->post('no_dokumen')),
                        'lokasi'           => strtoupper($this->input->post('lokasi')),
                        'id_penyusun'      => $id_admin, 
                        'jabatan_penyusun' => $hak_akses,
                        'tgl_buat'         => date('Y-m-d'),
                        'status'           => 2,
                        'dok'              =>  $dokumen
                    );
                    $run = $this->m_dokumen->insert($data, 'upload_dokumen'); 
                    $ded = array(
                        'no_dokumen'  => $this->input->post('no_dokumen'),
                        'tgl_diperiksa' => date('Y-m-d'),
                        'tgl_disahkan'=> date('Y-m-d')
                    );
                    $ruin = $this->m_dokumen->insert($ded, 'approve_dokumen');

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
                        }  
                            redirect('c_dokumen/form_upload');    
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
        $cek = $this->m_dokumen->get_pemeriksa("(dokumen_akses.hak_akses = '$hak_akses' AND aksi = 'pengesah')")->num_rows();
        if ($cek > 0){
            $data['data'] = $this->m_dokumen->jenis_dokumen("(hak_akses = '$hak_akses' AND aksi = 'pengesah')")->result();
            $data['hak_akses'] = $hak_akses; 
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
     
        $hak_akses = $this->session->userdata('hak_akses');
        $row = $this->m_dokumen->get_by_id('admin', 'id_auth', $this->session->userdata('id_auth'));
        $bidang = $row->id_bidang; 

        //cek terlebih dahulu apakah user memiliki bidang atau tidak 
        //jika memiliki bidang maka kueri kan per bidangnya

        if ($bidang != null){
            $data['data'] = $this->m_dokumen->all_dataDokumen("(id_jenis_dokumen = '$id_jenis_dokumen' AND bidang = '$bidang')", "(jabatan_pemeriksa = '$hak_akses')")->result();
            $data['periksa_ulang'] = $this->m_dokumen->all_dataDokumen("(id_jenis_dokumen = '$id_jenis_dokumen' AND bidang = '$bidang')", "(jabatan_pemeriksa = '$hak_akses' AND status = '4')")->result();
            $data['id_jenis_dokumen'] = $id_jenis_dokumen;
            $this->templates->utama('dokumen/v_list_periksa_dokumen', $data);     
        }else{
            $data['data'] = $this->m_dokumen->all_dataDokumen("(id_jenis_dokumen = '$id_jenis_dokumen')", "(jabatan_pemeriksa = '$hak_akses')")->result();
            $data['periksa_ulang'] = $this->m_dokumen->all_dataDokumen("(id_jenis_dokumen = '$id_jenis_dokumen')", "(jabatan_pemeriksa = '$hak_akses' AND status = '4')")->result();
            $data['id_jenis_dokumen'] = $id_jenis_dokumen;
            $this->templates->utama('dokumen/v_list_periksa_dokumen', $data);   
        }
    }

    public function list_sahkan_dokumen($id_jenis_dokumen){
        $hak_akses = $this->session->userdata('hak_akses');
        $data['data'] = $this->m_dokumen->all_dataDokumen(array('id_jenis_dokumen'=> $id_jenis_dokumen), "(jabatan_pengesah ='$hak_akses' AND status != '0')")->result();
        $data['id_jenis_dokumen'] = $id_jenis_dokumen;
        $this->templates->utama('dokumen/v_list_sahkan_dokumen', $data);   
    }

    public function detail_dokumen($no_dokumen, $param){
        if ($param == 'dokumen'){
            $data ['param'] = $param;
            $data['data'] = $this->db->query("SELECT * FROM upload_dokumen JOIN approve_dokumen ON upload_dokumen.no_dokumen = approve_dokumen.no_dokumen WHERE upload_dokumen.no_dokumen = '$no_dokumen'")->result();
            $this->templates->utama('dokumen/v_detail_dokumen', $data);
        }else{
            $data['param'] = $param;
            $data['data'] = $this->db->query("SELECT * FROM upload_dokumen JOIN approve_dokumen ON upload_dokumen.no_dokumen = approve_dokumen.no_dokumen WHERE upload_dokumen.no_dokumen = '$no_dokumen'")->result();
            $this->templates->utama('dokumen/v_detail_dokumen', $data);
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
                $data2 = array(
                    'id_pemeriksa'      => $row->id_admin,
                    'tgl_diperiksa'     => date('Y-m-d')
                );

                $update = $this->m_dokumen->update(array('no_dokumen'=> $no_dokumen), $data, 'upload_dokumen');
                $update = $this->m_dokumen->update(array('id_approve'=> $row2->id_approve), $data2, 'approve_dokumen');
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


    public function action_setuju($id_jenis_dokumen, $no_dokumen){
        $row = $this->m_dokumen->get_by_id('approve_dokumen', 'no_dokumen', $no_dokumen);
        $row2 = $this->m_dokumen->get_by_id('admin', 'id_auth', $this->session->userdata('id_auth'));
        // periksa terlebih dahulu apakah dokumen ini disahkan atau tidak 
        $cek = $this->db->query("SELECT * FROM dokumen_akses WHERE id_jenis_dokumen = '$id_jenis_dokumen' AND aksi = 'pengesah'")->num_rows();
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
                    'id_pemeriksa'   => $row2->id_admin,
                    'tgl_diperiksa' => date('Y-m-d'),
                    'jabatan_pengesah'  => 2
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
                        'id_pemeriksa'  => $row2->id_admin,
                        'tgl_diperiksa' => date('Y-m-d'),
                        'tgl_disahkan'  => date("Y-m-d")
                    );
                }
                $run = $this->m_dokumen->update(array('no_dokumen'=> $no_dokumen), $data, 'upload_dokumen');
                $run = $this->m_dokumen->update(array('id_approve'=> $row->id_approve), $data_2, 'approve_dokumen');
                if ($run = 1){
                    $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><center> Dokumen Sukses </center></strong></div>');
                }else{
                    $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong><center> Dokumen Gagal </center></strong></div>');
                }
                redirect('c_dokumen/detail_dokumen/'.$no_dokumen.'/dokumen');  
    }

    public function ajukan_ulang($no_dokumen){

		$config['upload_path']          = './dokumen/';
        $config['allowed_types']        = 'docx|doc|rtf';
        $config['remove_space']         = true;
	
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
                    'status'    => 4
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
       
        
        $data = array(
            'hak_akses' => $queri->hak_akses
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
        $jabatan_pemeriksa = $this->input->post('jabatan_pemeriksa');
        $jabatan_pengesah = $this->input->post('jabatan_pengesah');
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
                $jabatan_pem = null;
        }else {
                $IdPemeriksa = $id_pemeriksa;   
                $jabatan_pem = $jabatan_pemeriksa;
        }

        if ($id_pengesah == ""){
            $IdPengesah     = null;
            $jabatan_peng   = null;
        }else {
            $IdPengesah = $id_pengesah;
            $jabatan_peng = $jabatan_pengesah;
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
                    'jabatan_penyusun'  => $this->input->post('jabatan_penyusun'),
                    'status'            => 2,
                    'tgl_buat'      => date('Y-m-d', strtotime($this->input->post('tgl_disusun'))),
                    'dok'               => $nama_dokumen
                ); 
                $update = $this->m_dokumen->insert($data, 'upload_dokumen');

                $data_2  = array(
                    'no_dokumen'        => $no_dokumen,
                    'bidang'            => $bidang,
                    'id_pemeriksa'      => $IdPemeriksa,
                    'jabatan_pemeriksa' => $jabatan_pem,
                    'id_pengesah'       => $IdPengesah,
                    'jabatan_pengesah'  => $jabatan_peng,
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

    public function detail_all_dokumen($no_dokumen){
        $where = array('upload_dokumen.no_dokumen'=> $no_dokumen);
        $row = $this->m_dokumen->get_by_id('upload_dokumen', 'no_dokumen', $no_dokumen);
        $data['id_dokumen_induk'] = $row->id_dokumen_induk;
        $data['data'] = $this->m_dokumen->upload_approve($where)->result();
        $data['data_2'] = $this->m_dokumen->DokumenRevisi($where)->result();
        $data['no_dokumen'] = $no_dokumen; 
        $this->templates->utama('dokumen/v_detail_all_dokumen', $data);
    }

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

     // edit all dokumen
     public function edit_all_dokumen(){

        $hak_akses  = $this->session->userdata('hak_akses');
        $no_dokumen = $this->input->post('rowid');
        $where = array('upload_dokumen.no_dokumen'=> $no_dokumen);

        if ($hak_akses == 1){
            $data['user'] = $this->m_admin->data_admin()->result();
            $data['action'] = base_url('c_dokumen/action_edit_allDokumen');
            $data['dokumen'] = $this->m_dokumen->upload_approve($where)->result();
            $this->load->view('dokumen/v_edit_all_dokumen', $data);
        }else{
            $data['hak_akses'] = $this->m_admin->all_hak_akses()->result();
            $data['dokumen'] = $this->m_dokumen->upload_approve($where)->result();
            $data['action'] = base_url('c_dokumen/action_edit_dokumenRiwayat');
            $this->load->view('dokumen/v_edit_dokumen_riwayat', $data);
        }
     }

     public function action_edit_allDokumen(){
        $no_dokumen = $this->input->post('no_dokumen');
        $where = array('no_dokumen'=>$no_dokumen);

        $id_bidang = $this->input->post('bidang');
        $jabatan_pemeriksa = $this->input->post('jabatan_pemeriksa');
        $jabatan_pengesah = $this->input->post('jabatan_pengesah');
        $id_pemeriksa = $this->input->post('pemeriksa');
        $id_pengesah = $this->input->post('pengesah');

        if ($id_bidang == ''){
            $bidang = null;
        }else{
            $bidang = $id_bidang; 
        }

        // jika tidak ada pemeriksa 
        if ($id_pemeriksa == ""){
                $IdPemeriksa = null;
                $jabatan_pem = null;
        }else {
                $IdPemeriksa = $id_pemeriksa;   
                $jabatan_pem = $jabatan_pemeriksa;
        }

        if ($id_pengesah == ""){
            $IdPengesah     = null;
            $jabatan_peng   = null;
        }else {
            $IdPengesah = $id_pengesah;
            $jabatan_peng = $jabatan_pengesah;
            }

        if ($this->input->post('ubah_dokumen')){
            
            $config['upload_path']          = './dokumen/';
            $config['allowed_types']        = 'pdf';
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
                    'id_penyusun'       => $this->input->post('penyusun'),
                    'jabatan_penyusun'  => $this->input->post('jabatan_penyusun'),
                    'dok'               => $nama_dokumen
                ); 
                $update = $this->m_dokumen->update($where, $data, 'upload_dokumen');

                $data_2  = array(
                    'bidang'            => $bidang,
                    'id_pemeriksa'      => $IdPemeriksa,
                    'jabatan_pemeriksa' =>  $jabatan_pem,
                    'id_pengesah'       =>  $IdPengesah,
                    'jabatan_pengesah'  => $jabatan_peng
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
                'id_penyusun'       => $this->input->post('penyusun'),
                'jabatan_penyusun'  => $this->input->post('jabatan_penyusun')
            ); 
            $update = $this->m_dokumen->update($where, $data, 'upload_dokumen');

            $data_2  = array(
                'bidang'            => $bidang,
                'id_pemeriksa'      => $IdPemeriksa,
                'jabatan_pemeriksa' =>  $jabatan_pem,
                'id_pengesah'       =>  $IdPengesah,
                'jabatan_pengesah'  => $jabatan_peng
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
         redirect('c_dokumen/detail_all_dokumen/'.$no_dokumen);
     }

     public function action_edit_dokumenRiwayat(){

        $no_dokumen = $this->input->post('no_dokumen');
        $where = array('no_dokumen'=> $no_dokumen);
        $jabatan_pemeriksa = $this->input->post('pemeriksa');
        $jabatan_pengesah = $this->input->post('pengesah');
        $bidang = $this->input->post('bidang');

        if ($jabatan_pemeriksa == ''){
            $jabatan_pem = null;
        }else{
            $jabatan_pem = $jabatan_pemeriksa; 
        }

        if ($jabatan_pengesah == ''){
            $jabatan_peng = null; 
        }else{
            $jabatan_peng = $jabatan_pengesah; 
        }

        if ($this->input->post('ubah_dokumen')){
            $config['upload_path']          = './dokumen/';
            $config['allowed_types']        = 'rtf|docx';
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
                    'dok'               => $nama_dokumen
                ); 
                $update = $this->m_dokumen->update($where, $data, 'upload_dokumen');

                $data_2  = array(
                    'bidang'            => $bidang,
                    'jabatan_pemeriksa' =>  $jabatan_pem,
                    'jabatan_pengesah'  => $jabatan_peng
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
                'id_jenis_dokumen'  => $this->input->post('jenis_dokumen')
            ); 
            $update = $this->m_dokumen->update($where, $data, 'upload_dokumen');

            $data_2  = array(
                'bidang'            => $bidang,
                'jabatan_pemeriksa' =>  $jabatan_pem,
                'jabatan_pengesah'  => $jabatan_peng
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
            redirect('c_dokumen/detail_riwayat/'.$no_dokumen);
     }
}
?>