<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
class MY_Controller extends CI_Controller 
{
  public function cekLogin()
  {
    if (!$this->session->userdata('id_auth')) {
      redirect('auth');
    }
  }
  
}