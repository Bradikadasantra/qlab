<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_admin extends CI_Controller {

    public function __construct(){
		parent:: __construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('templates');
        $this->load->model('m_login');
        $this->load->model('m_admin');
		$this->load->model('m_pelanggan');
		$this->load->model('m_aset');
		$this->load->model('m_merk');
    }
    
    public function index(){
		$this->templates->utama('admin/v_dashboard_admin');
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
					swal("Success !", "Success Delete Data !", "success"); 
					</script>');
				}else
				{
					echo $this->session->set_flashdata('pesan', 
					'<script>
								swal({
								title: "Failed",
								text: "Failed Delete Data",
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
			'nama'      => $this->input->post('nama'),
			'alamat '   => $this->input->post('alamat'),
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
        'nama'      =>htmlspecialchars($this->input->post('nama')),
        'alamat'    =>htmlspecialchars($this->input->post('alamat')),
		'no_telp'   =>htmlspecialchars($this->input->post('no_telp')),
		'id_bidang'	=>htmlspecialchars($this->input->post('id_bidang')),
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
                redirect ('c_admin/daftar_admin', 'refresh');
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
                        text: "File Not Supported",
                        type: "warning",
                        });
                    </script>');
                    }
        redirect ('c_admin/registration', 'refresh');
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

	public function daftar_aset(){
		$data['aset'] = $this->m_aset->data_aset()->result_array();
		$this->templates->utama('admin/v_daftar_aset',$data);
	}

	public function registrasi_aset(){
		$data['merk'] = $this->m_merk->index()->result_array();
		$this->templates->utama('admin/v_registrasi_aset' ,$data);
	}

	public function insert_aset(){
		$data = array(
			'jenis_barang'	=> htmlspecialchars($this->input->post('jenis_barang')),
			'type'			=> htmlspecialchars($this->input->post('type')),
			'id_merk'		=> htmlspecialchars($this->input->post('merk')),
			'kodefikiasi'	=> htmlspecialchars($this->input->post('kodefikiasi')),
			'foto'			=> $nama_foto,
			'jumlah'		=> htmlspecialchars($this->input->post('jumlah')),
			'dibuat'		=> date('Y-m-d'),
			'diubah'		=> date('Y-m-d')		
		);
		$insert_aset['res'] = $this->m_aset->tambah_aset($data,'aset');
		if ($insert_aset){
			echo $this->session->set_flashdata('pesan', 
			'<script>
			swal("Success !", "Sukses Tambah Aset !", "success"); 
			</script>');
		}else{
			echo $this->session->set_flashdata('pesan', 
			'<script>
						swal({
						title: "Failed",
						text: "Gagal Hapus Data",
						type: "warning",
						});
					</script>');
		}
	redirect('c_admin/daftar_aset', 'refresh');
}

	public function detail_aset(){
		$id_aset = $this->input->post('rowid');
		$detail['aset'] = $this->m_aset->edit_aset($id_aset)->result_array();
		$detail['merk']	= $this->m_merk->index()->result_array();
		$this->load->view('admin/v_detail_aset', $detail);
	}

	public function update_aset(){
		$id_aset   = $this->input->post('id_aset');
		
		if($this->input->post('ubah_photo')){
			$config['upload_path']          = './photo_aset/';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 2044070;
			$config['max_width']            = 1024;
			$config['max_height']           = 768;
			$ambil_data = $this->m_aset->ambil_aset($id_aset);
			
			if($ambil_data->num_rows() > 0){
				$pros=$ambil_data->row();
				$gambar=$pros->foto;
				
				  if(is_file($lok=FCPATH.'/photo_aset/'.$gambar)){
					unlink($lok);
				}
			}

			$this->load->library('upload', $config);
			
			if($this->upload->do_upload('photo')){
				$finfo = $this->upload->data();
				$nama_foto = $finfo['file_name'];

		$data = array(
			'jenis_barang'		=> $this->input->post('jenis_barang'),
			'type'  			=> $this->input->post('type'),
			'id_merk'  			=> $this->input->post('merk'),
			'jumlah'  			=> $this->input->post('jumlah'),
			'kodefikiasi'  		=> $this->input->post('kodefikiasi'),
            'foto'              =>$nama_foto,
            'diubah'            => date('Y-m-d')
		);

		$where = array('id_aset'=>$id_aset);
		$hasil['res'] = $this->m_aset->update_aset($where,$data, 'aset');
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
				redirect('c_admin/daftar_aset');
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
				redirect('c_admin/daftar_aset');
		}
	else{

		$data = array(
			'jenis_barang'		=> $this->input->post('jenis_barang'),
			'type'  			=> $this->input->post('type'),
			'id_merk'  			=> $this->input->post('merk'),
			'jumlah'  			=> $this->input->post('jumlah'),
			'kodefikiasi'  		=> $this->input->post('kodefikiasi'),
            'diubah'            => date('Y-m-d')
		);

		$where = array ('id_aset'=>$id_aset);
		$hasil['res'] = $this->m_aset->update_aset($where,$data, 'aset');
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
				redirect('c_admin/daftar_aset');
	}
				
}

public function hapus_aset($id_aset){
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
		$where = array('id_aset' => $id_aset);
		$hasil  = $this->m_aset->hapus_aset($where,'aset');
			if($hasil){
				echo $this->session->set_flashdata('pesan', 
				'<script>
				swal("Success !", "Success Delete Data !", "success"); 
				</script>');
			}else
			{
				echo $this->session->set_flashdata('pesan', 
				'<script>
							swal({
							title: "Failed",
							text: "Failed Hapus Data",
							type: "warning",
							});
						</script>');
			}
		}
		redirect('c_admin/daftar_aset');	
	
}

	public function tampil_merk(){
		$data['merk'] = $this->m_merk->index()->result_array();
		$this->load->view('admin/v_hapus_merk', $data);
	}

	public function hapus_merk($id_merk){
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
			$where = array('id_merk' => $id_merk);
			$hasil  = $this->m_merk->hapus_merk($where,'merk');
				if($hasil){
					$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				 <b>Sukses...!</b> Sukses Tambah Merk </div>');
				}else
				{
					$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				 <b>Gagal...!</b> Gagal Tambah Merk </div>');
				}
			}
			redirect('c_admin/registrasi_aset');	
		
	}

	public function tambah_merk(){
		$data = array(
			'merk' => $this->input->post('merk')
		);
		$insert_merk['res'] = $this->m_merk->tambah_merk($data, 'merk');
			if($insert_merk){
				$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				 <b>Sukses...!</b> Sukses Tambah Merk </div>');
			}else{
				$this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				 <b>Gagal...!</b> Gagal Tambah Merk </div>');
			}
			redirect('c_admin/registrasi_aset');
	}


}


?>