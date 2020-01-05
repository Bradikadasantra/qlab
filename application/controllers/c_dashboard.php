<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_dashboard extends MY_Controller {


    public function __construct(){
        parent:: __construct();
        $this->cekLogin();
        $this->load->library('templates');
        $this->load->model('m_admin');
        $this->load->model('m_registrasi_sampel');
    }

    public function index(){
        $id_auth = $this->session->userdata('id_auth');        
        $cek = $this->db->query("SELECT * FROM pelanggan WHERE id_auth = '$id_auth' AND alamat = '' AND no_telp = '' ");
        if ($cek->num_rows() > 0){
            $this->load->view('template/header');
            $this->load->view('template/topbar');
			$this->load->view('auth/v_lengkapi_data');
			$this->load->view('template/login_footer');
        }else{
            $this->templates->utama('auth/v_dashboard');
        }
       
    }

    public function action_lengkapi_data(){

        $row = $this->m_admin->get_by_id('pelanggan', 'id_auth', $this->session->userdata('id_auth'));

        $this->form_validation->set_rules('alamat','Alamat','required|trim', array('required'=>'Masukkan alamat anda...!'));
        $this->form_validation->set_rules('no_telp','No Telepon','required|trim|numeric', array('required'=>'Masukkan no telepon anda...!', 'numeric'=> 'Masukkan angka yang valid...!'));
        $this->form_validation->set_rules('instansi','Instansi','required|trim', array('required'=>'Masukkan nama instansi...!'));
        $this->form_validation->set_rules('alamat_instansi','Alamat Instansi','required|trim', array('required'=>'Masukkan alamat instansi anda...!'));
      
        if($this->form_validation->run() == false){
            $this->index();
        }else{
            $data = array(
                'alamat'            => ucwords($this->input->post('alamat')),
                'no_telp'           => $this->input->post('no_telp'),
                'instansi'           => ucwords( $this->input->post('instansi')),
                'alamat_instansi'   => ucwords($this->input->post('alamat_instansi'))
            );

        $res = $this->m_admin->update_admin(array('id_pelanggan'=> $row->id_pelanggan), $data, 'pelanggan');
            if ($res = 1){
                echo $this->session->set_flashdata('pesan', 
                '<script>
                swal("Success !", "Sukses melengkapi data diri", "success"); 
                </script>');
            }else{
                echo $this->session->set_flashdata('pesan', 
                '<script>
                   swal({
                   title: "Failed",
                   text: "Gagal melengkapi data diri",
                  type: "warning",
               });
               </script>');
            }
            $this->templates->utama('auth/v_dashboard');
      }

    }

}


?>