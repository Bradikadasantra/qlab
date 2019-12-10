<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_dashboard extends CI_Controller {


    public function __construct(){
		parent:: __construct();
        $this->load->library('templates');
    }

    public function index(){
        $this->templates->utama('auth/v_dashboard');
    }

}


?>