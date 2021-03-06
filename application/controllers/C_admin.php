<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_admin extends MY_Controller {
    public function __construct(){
		parent:: __construct();
		$this->cekLogin();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('templates');
        $this->load->model('m_login');
        $this->load->model('m_admin');
		$this->load->model('m_pelanggan');	
    }

    public function registrasi_admin(){
		$data['data']  = $this->m_admin->all_hak_akses()->result();
        $this->templates->utama('admin/v_registrasi_admin', $data);
    }

    public function daftar_admin(){
        $data['admin'] = $this->m_admin->data_admin()->result_array();
        $this->templates->utama ('admin/v_daftar_admin', $data);
    }

    public function detail_admin(){
        $id_admin = $this->input->post('rowid');
		$detail_admin['admin'] = $this->m_admin->detail_admin($id_admin)->result_array();
		$detail_admin['hak_akses'] = $this->m_admin->all_hak_akses()->result();
        $this->load->view('admin/v_detail_admin',$detail_admin);
    }

    public function hapus_admin($id_admin){
		if ($this->session->userdata('hak_akses') != 1 ){
					echo $this->session->set_flashdata('pesan', 
					'<script>
								swal({
								title: "Access Deny",
								text: " Akses Ditolak",
								type: "warning",
								});
							</script>');
							
			}else{
			$where = array('id_admin' => $id_admin);
			$hasil  = $this->m_admin->hapus_admin($where,'admin');
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
			redirect('c_admin/daftar_admin');	
		
	}

    public function update_admin(){
		$id_admin   = $this->input->post('id_admin');
		$id_auth 	= $this->input->post('id_auth');
		
		if($this->input->post('ubah_photo')){
			$config['upload_path']          = './photo/';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 2044070;
			$config['max_width']            = 1024;
			$config['max_height']           = 768;
			$ambil_data = $this->m_admin->ambil_admin($id_admin);
			
			if($ambil_data->num_rows() > 0){
				$pros=$ambil_data->row();
				$gambar=$pros->foto;
				
				  if(is_file($lok=FCPATH.'/photo/'.$gambar)){
					unlink($lok);
				}
			}

			$this->load->library('upload', $config);
			
			if($this->upload->do_upload('photo')){
				$finfo = $this->upload->data();
				$nama_foto = $finfo['file_name'];

		$data = array(
			'hak_akses' =>$this->input->post('hak_akses')
		);
		$data2 = array(
			'nama'      => ucwords($this->input->post('nama')),
			'alamat '   => ucwords($this->input->post('alamat')),
			'no_telp'   => $this->input->post('no_telp'),
            'foto'      =>$nama_foto,
            'diubah'    => date('Y-m-d')
		);

		$where = array ('id_auth'=>$id_auth);
		$where2 = array('id_admin'=>$id_admin);
		$hasi['res'] = $this->m_admin->update_admin($where,$data, 'auth');
		$hasil['res'] = $this->m_admin->update_admin($where2, $data2, 'admin');
			if($hasil){
				echo $this->session->set_flashdata('pesan', 
						'<script>
						swal("Success !", "Sukses Perbarui Data !", "success"); 
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
				redirect('c_admin/daftar_admin');
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
				redirect('c_admin/daftar_admin');
		}
	else{
		$data = array(
			'hak_akses' =>$this->input->post('hak_akses')
		);
		$data2 = array(
			'nama'      => $this->input->post('nama'),
			'alamat '   => $this->input->post('alamat'),
			'no_telp'   => $this->input->post('no_telp'),
            'diubah'    => date('Y-m-d')
		);

		$where = array ('id_auth'=>$id_auth);
		$where2 = array('id_admin'=>$id_admin);
		$hasi['res'] = $this->m_admin->update_admin($where,$data, 'auth');
		$hasil['res'] = $this->m_admin->update_admin($where2, $data2, 'admin');
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
				redirect('c_admin/daftar_admin');
	}
}

// function action untuk menambahkan admin
    public function insert_registrasi(){
				
		$this->form_validation->set_rules('nama','Nama','required|trim', array('required'=>'Masukkan nama pegawai...!'));
        $this->form_validation->set_rules('alamat','Alamat','required|trim', array('required'=>'Masukkan alamat pegawai...!'));
		$this->form_validation->set_rules('no_telp','No Telepon','required|trim', array('required'=>'Masukkan nomor telepon...!'));
		$this->form_validation->set_rules('email','Email','required|trim|valid_email', array('required'=>'Masukkan Email...!','valid_email'=>'Email anda tidak valid...!'));
		$this->form_validation->set_rules('hak_akses','Hak Akses','required', array('required'=>'Masukkan hak akses...!'));
		$this->form_validation->set_rules('bidang','idang','required', array('required'=>'Pilih bidang...!'));

		if (empty($_FILES['photo']['name'])){
			$this->form_validation->set_rules('photo','Photo','required|trim', array('required'=>'Lampirkan file...!'));
			}

			if ($this->form_validation->run() == false){
					$this->registrasi_admin();
			}else{

		$id_bidang = $this->input->post('id_bidang');
			if ($id_bidang == ''){
				$bidang = null;
			}else{
				$bidang = $id_bidang; 
			}

			$auth = array(
				'email'     => $this->input->post('email'),
				'password'  => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'hak_akses'  => $this->input->post('hak_akses'),
				'aktif'     => 1
			);
			$insert_auth['res'] = $this->m_login->registration($auth, 'auth');

			$id_auth = $this->db->insert_id();
			$config['upload_path']          = './photo/';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 2044070;
			$config['max_width']            = 1024;
			$config['max_height']           = 768;
					
			$this->load->library('upload', $config);

				if($this->upload->do_upload('photo')){
					$finfo = $this->upload->data();
					$nama_foto = $finfo['file_name'];

			$admin = array(
				'id_auth'   =>$id_auth,
				'nama'      =>ucwords(htmlspecialchars($this->input->post('nama'))),
				'alamat'    =>ucwords(htmlspecialchars($this->input->post('alamat'))),
				'no_telp'   =>htmlspecialchars($this->input->post('no_telp')),
				'id_bidang'	=> $bidang,
				'foto'      => $nama_foto,
				'dibuat'    => date('Y-m-d'),
				'diubah'    => date('Y-m-d')
			);

			$insert_admin['res2'] = $this->m_admin->registrasi($admin, 'admin');
				if ($insert_admin  and $insert_auth){
					echo $this->session->set_flashdata('pesan', 
						'<script>
						swal("Success !", "Sukses Tambah Admin !", "success"); 
						</script>');
				}else{
					echo $this->session->set_flashdata('pesan', 
						'<script>
							swal({
							title: "Failed",
							text: "Gagal Tambah Admin",
							type: "warning",
							});
						</script>');
				}

			}else{
				echo $this->session->set_flashdata('pesan', 
							'<script>
								swal({
								title: "Failed",
								text: "Format File Tidak Didukung",
								type: "warning",
								});
							</script>');
							}
        redirect ('c_admin/registrasi_admin');
	}
}

    public function daftar_pelanggan(){
        $data['pelanggan'] = $this->m_pelanggan->data_pelanggan()->result_array();
        $this->templates->utama('admin/v_daftar_pelanggan', $data);
    }

    public function detail_pelanggan(){
        $id_pelanggan = $this->input->post('rowid');
        $detail_pelanggan['pelanggan'] = $this->m_pelanggan->detail_pelanggan($id_pelanggan)->result_array();
        $this->load->view('admin/v_detail_pelanggan',$detail_pelanggan);
    }

    
    public function update_pelanggan(){
		$id_pelanggan   = $this->input->post('id_pelanggan');
		$id_auth 	    = $this->input->post('id_auth');
		
		if($this->input->post('ubah_photo')){
			$config['upload_path']          = './photo/';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 2044070;
			$config['max_width']            = 1024;
			$config['max_height']           = 768;
			$ambil_data = $this->m_pelanggan->ambil_pelanggan($id_pelanggan);
			
			if($ambil_data->num_rows() > 0){
				$pros=$ambil_data->row();
				$gambar=$pros->foto;
				
				  if(is_file($lok=FCPATH.'/photo/'.$gambar)){
					unlink($lok);
				}
			}

			$this->load->library('upload', $config);
			
			if($this->upload->do_upload('photo')){
				$finfo = $this->upload->data();
				$nama_foto = $finfo['file_name'];

		$data = array(
			'aktif' =>$this->input->post('aktif')
		);
		$data2 = array(
			'nama'              => $this->input->post('nama'),
			'alamat '           => $this->input->post('alamat'),
            'no_telp'           => $this->input->post('no_telp'),
            'instansi'          => $this->input->post('instansi'),
            'alamat_instansi'   => $this->input->post('alamat_instansi'),
            'foto'              =>$nama_foto,
            'diubah'            => date('Y-m-d')
		);

		$where = array ('id_auth'=>$id_auth);
		$where2 = array('id_pelanggan'=>$id_pelanggan);
		$hasil['res'] = $this->m_pelanggan->update_pelanggan($where,$data, 'auth');
		$hasil['res'] = $this->m_pelanggan->update_pelanggan($where2, $data2, 'pelanggan');
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
				redirect('c_admin/daftar_pelanggan');
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
				redirect('c_admin/daftar_pelanggan');
		}
	else{
		$data = array(
			'aktif' =>$this->input->post('aktif')
		);
		$data2 = array(
			'nama'              => $this->input->post('nama'),
			'alamat '           => $this->input->post('alamat'),
            'no_telp'           => $this->input->post('no_telp'),
            'instansi'          => $this->input->post('instansi'),
            'alamat_instansi'   => $this->input->post('alamat_instansi'),
            'diubah'            => date('Y-m-d')
		);

		$where = array ('id_auth'=>$id_auth);
		$where2 = array('id_pelanggan'=>$id_pelanggan);
		$hasil['res'] = $this->m_pelanggan->update_pelanggan($where,$data, 'auth');
		$hasil['res'] = $this->m_pelanggan->update_pelanggan($where2, $data2, 'pelanggan');
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
				redirect('c_admin/daftar_pelanggan');
	}
				
}

public function hapus_pelanggan($id_pelanggan){
    if ($this->session->userdata('hak_akses') != 1 ){
                echo $this->session->set_flashdata('pesan', 
                '<script>
                            swal({
                            title: "Access Deny",
                            text: " Akses Ditolak",
                            type: "warning",
                            });
                        </script>');
                        
        }else{
        $where = array('id_pelanggan' => $id_pelanggan);
        $hasil  = $this->m_pelanggan->hapus_pelanggan($where,'pelanggan');
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
        redirect('c_admin/daftar_pelanggan');
}

	

	public function form_editProfil(){
			$id_auth = $this->session->userdata('id_auth');
			$where = array('auth.id_auth'=> $id_auth); 

			$data['user'] = $this->m_admin->cari_adminAuth($where)->result();
			$data['action'] = base_url('c_admin/action_updateProfil_admin');
			$this->templates->utama('admin/v_form_editProfil', $data);
	}


	public function action_updateProfil_admin(){
		$id_auth   = $this->input->post('id_auth');
		$row = $this->m_admin->get_by_id('admin', 'id_auth', $id_auth);

		if ($this->input->post('ubah_photo')){
			$config['upload_path']          = './photo/';
			$config['allowed_types']        = 'jpg';
			$config['max_size']             = 2044070;

			$ambil_data = $this->m_admin->ambil_admin($id_admin);
			if($ambil_data->num_rows() > 0){
				$pros=$ambil_data->row();
				$gambar=$pros->foto;
				
				  if(is_file($lok=FCPATH.'/photo/'.$gambar)){
					unlink($lok);
				}
			}
			$this->load->library('upload', $config);
			if($this->upload->do_upload('photo')){
				$finfo = $this->upload->data();
				$nama_foto = $finfo['file_name'];

		$data = array(
			'nama'				=> ucwords($this->input->post('nama')),
			'no_telp'			=> $this->input->post('no_telp'),
			'alamat'			=> ucwords($this->input->post('alamat')),
			'diubah'			=> date('Y-m-d'),
			'foto'				=> $nama_foto
		);
		$hasil = $this->m_admin->update_admin(array('id_admin'=>$row->id_admin), $data, 'admin');

		$data2 = array(
			'email'			=> $this->input->post('email')
		);
		$hasil2 = $this->m_admin->update_admin(array('id_auth'=>$id_auth), $data2, 'auth');	
		if ($hasil = 1 and $hasil2 = 1){
			echo $this->session->set_flashdata('pesan', 
			'<script>
			swal("Success !", "Sukses perbarui profil !", "success"); 
			</script>');
		}else{
			echo $this->session->set_flashdata('pesan', 
			'<script>
						swal({
						title: "Failed",
						text: "Gagal perbarui profil",
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
		redirect('c_admin/form_editProfil');
		}else{
			$data = array(
				'nama'				=> ucwords($this->input->post('nama')),
				'no_telp'			=> $this->input->post('no_telp'),
				'alamat'			=> ucwords($this->input->post('alamat')),
				'diubah'			=> date('Y-m-d')
			);
			$hasil = $this->m_admin->update_admin(array('id_admin'=>$row->id_admin), $data, 'admin');
	
			$data2 = array(
				'email'			=> $this->input->post('email')
			);
			$hasil2 = $this->m_admin->update_admin(array('id_auth'=>$id_auth), $data2, 'auth');	
			}
				if ($hasil = 1 and $hasil2 = 1){
					echo $this->session->set_flashdata('pesan', 
					'<script>
					swal("Success !", "Sukses perbarui profil !", "success"); 
					</script>');
				}else{
					echo $this->session->set_flashdata('pesan', 
					'<script>
								swal({
								title: "Failed",
								text: "Gagal perbarui profil",
								type: "warning",
								});
							</script>');
						
				}
				redirect('c_admin/form_editProfil');
	}

	public function ubah_password(){
		$data['action'] = base_url('c_admin/action_ubahPassword_admin');
		$this->templates->utama('admin/v_form_ubahPassword', $data);
	}

	public function action_ubahPassword_admin(){
		
		$id_auth = $this->input->post('id_auth');
		$cari_pass = $this->db->query("SELECT * FROM auth WHERE id_auth = '$id_auth'")->row();
		$ambil_pass = $cari_pass->password; 
		$where = array ('id_auth'=> $id_auth);

		$this->form_validation->set_rules('password_lama','Password Lama','required|trim', array('required'=>'Masukkan password lama...!'));
		$this->form_validation->set_rules('password_baru','Password Baru','required|trim|min_length[6]',
		array('required'=>'Masukkan password baru...!','min_length'=>'Password min 6 karakter'));

		$this->form_validation->set_rules('konfirm_pass_baru','Konfirm Password Baru','required|trim|min_length[6]|matches[password_baru]',
		array('required'=>'Konfirmasi password baru...!','min_length'=>'Password min 6 karakter','matches'=>'Password Tidak Sesuai...!'));

		
		if ($this->form_validation->run () == false ){
			$this->ubah_password();
		}else{
			if (password_verify($this->input->post('password_lama'),$ambil_pass)){
				
				// lakukan update password

				$data = array(
					'password' => PASSWORD_HASH($this->input->post('konfirm_pass_baru'), PASSWORD_DEFAULT)
				);

			$update = $this->m_admin->update_admin($where, $data, 'auth');

			if ($update = 1){
				echo $this->session->set_flashdata('pesan', 
					'<script>
					swal("Success !", "Sukses perbarui password !", "success"); 
					</script>');
			}else{
				echo $this->session->set_flashdata('pesan', 
				'<script>
							swal({
							title: "Failed",
							text: "Gagal perbarui password",
							type: "warning",
							});
						</script>');
			}

			}else{
				echo $this->session->set_flashdata('pesan', 
					'<script>
								swal({
								title: "Failed",
								text: "Password lama tidak cocok",
								type: "warning",
								});
							</script>');
			
			}
			redirect('c_admin/ubah_password');
		}	
	}

}


?>