<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_dokumen extends CI_Controller {

    public function __construct(){
		parent:: __construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('templates');
        $this->load->model('m_dokumen');
    }

    public function index(){
        $hak_akses = $this->session->userdata('hak_akses');
        $dokumen['dokumen'] = $this->m_dokumen->akses_dokumen($hak_akses)->result_array();
        if ($hak_akses == "Super Admin"){
            $this->templates->utama('dokumen/v_dokumen_induk', $dokumen);
        }
        else if ($hak_akses == "manajer_puncak" or $hak_akses == "manajer_mutu" or $hak_akses == "manajer_operasional" or
        $hak_akses == "ka_laboratorium" or $hak_akses == "analis"){
            $this->templates->utama('dokumen/v_dokumen_induk', $dokumen);
        }
        else if ($hak_akses == "manajer_teknik" or $hak_akses == "manajer_teknik" or $hak_akses == "manajer_teknik")
        {
            $this->templates->utama('dokumen/v_dokumen_induk', $dokumen);
        }
        else{
            $this->templates->utama('dokumen/v_dokumen_induk', $dokumen);
        }
    }

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