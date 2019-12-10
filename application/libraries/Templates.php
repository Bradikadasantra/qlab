<?php 
class Templates{
	protected $_ci; 
	
	function __construct(){
			$this->_ci = &get_instance();
	}
	
function utama($content, $data = NULL){
	$data['topbar']	= $this->_ci->load->view('template/topbar', $data, TRUE);
	$data['sidebar'] = $this->_ci->load->view('template/sidebar', $data, TRUE);
	$data['header'] = $this->_ci->load->view('template/header',$data,TRUE);
	$data['content'] = $this->_ci->load->view($content,$data, TRUE);
	$data['footer'] = $this->_ci->load->view('template/footer',$data, TRUE);
	
	$this->_ci->load->view('template/index', $data);
	}
}

