<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {
	
	public function __construct(){
		parent:: __construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('m_login');
		$this->load->model('m_pelanggan');
	}
	
	public function index() {
		
		$this->form_validation->set_rules('email','Email','required|trim|valid_email', array('required'=>'Masukkan Email Anda...!','valid_email'=>'Email anda tidak valid...!'));
		$this->form_validation->set_rules('password','Password','required|trim', array('required'=>'Masukkan Password Anda...!'));
		
	if ($this->form_validation->run() == false){
		$data['title'] = "Qlab Login";
		$this->load->view('template/login_header',$data);
		$this->load->view('auth/v_login');
		$this->load->view('template/login_footer');
		
	}else{
		// validasi sukses
		$this->_login();
	
		}
	}

	//buat sebuah funsi lagi agar tidak panjang
	private function _login(){
		$email 		= $this->input->post('email');
		$password	= $this->input->post('password');
		
		$where = array(
			'email'=>$email
		);
		$auth	= $this->m_login->cek_login_user($where,'auth')->row_array();
		//jika ada usernya maka;
		if($auth){
			//jika user aktif
			if($auth['aktif'] == 1){
					//cek password
					if(password_verify($password,$auth['password'])){
						
					$where = array('email' => $email);
					$hasil = $this->m_login->cek_login_user($where,'auth')->row();
					$baris_data['id_auth'] = $hasil->id_auth;
					$baris_data['email'] = $hasil->email;
					$baris_data['hak_akses'] = $hasil->hak_akses;
					$this->session->set_userdata($baris_data);
						
					$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<b>Failed...!</b> Password anda salah</div>');
							redirect('c_dashboard');
					}else{
					$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<b>Failed...!</b> Password anda salah</div>');
							redirect('auth');
					}
		
			}
			else{
					$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<b>Erorr...!</b> Akun tidak aktif </div>');
							redirect('auth');
			}
		}
		$this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<b>Erorr...!</b> Email dan Password Belum Terdaftar </div>');
							redirect('auth');
	}

	public function registration(){
		
		$this->form_validation->set_rules('name','Name','required|trim', array('required'=>'Isikan Nama Anda...!'));
		$this->form_validation->set_rules('email','Email','required|trim|valid_email|is_unique[auth.email]', 
		array('required'=>'Isikan Alamat Email Anda...!','valid_email'=>'Email tidak valid...!','is_unique'=>'Email sudah terdaftar...!'));
		
		$this->form_validation->set_rules('password1','Password','required|trim|min_length[6]|matches[password2]}',
		array('required'=>'Isikan Password...!','min_length'=>'Password min 6 karakter','matches'=>'Password Tidak Sesuai...!'));
		
		$this->form_validation->set_rules('password2','Password','required|trim|matches[password1]',
		array('required'=>'Isikan Password...!'));

		if ($this->form_validation->run() == false){
			$data['title'] = "Qlab Registration";
			$this->load->view('template/login_header',$data);
			$this->load->view('auth/v_register');
			$this->load->view('template/login_footer');
		}
		else{
		$data = array(
			'email' => htmlspecialchars($this->input->post('email',true)),
			'password' => password_hash($this->input->post('password1'),PASSWORD_DEFAULT),
			'hak_akses' => "pelanggan",
			'aktif' =>1,
		);
		
		$insert = $this->m_login->registration($data,'auth');

		$id_auth = $this->db->insert_id();
		
		$pelanggan = array(
			'id_auth' 	=> $id_auth,
			'nama'	  	=> htmlspecialchars($this->input->post('name', true)),
			'no_telp'	=> " ",
			'alamat'	=> " ",
			'alamat'	=> " ",
			'instansi'	=> " ",
			'alamat_instansi'	=>" ",
			'dibuat'	=> date('Y-m-d'),
			'diubah'	=> date('Y-m-d'),
			'foto'		=> "Default.jpg"
		);
		$insert_tb_pelanggan  = $this->m_pelanggan->registration($pelanggan, 'pelanggan');

		$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<b>Sukses...!</b> Akun Berhasil Dibuat
			</div>');
		redirect('auth');
		}
	}
	

//method logout
public function logout(){

	$this->session->unset_userdata('id_auth');
	$this->session->unset_userdata('email');
	$this->session->unset_userdata('hak_akses');
	
	$this->session->set_flashdata('message','<div class="alert alert-success alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<b>Sukses...!</b> Anda sudah keluar</div>');
		redirect('auth');
}

}
?>