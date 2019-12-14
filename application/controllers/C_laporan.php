<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_laporan extends CI_Controller {

    public function __construct(){
		parent:: __construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('templates');
        $this->load->model('m_login');
        $this->load->model('m_admin');
        $this->load->model('m_pelanggan');
        $this->load->model('m_registrasi_sampel');
    }


    public function  keuangan(){
        $tgl1 = date('Y-m-d', strtotime($this->input->post('tgl1')));
        $tgl2 = date('Y-m-d', strtotime($this->input->post('tgl2')));
        $tahun = substr($this->input->post('tgl1'),6, 4);
    
        $dataWhere = "";

        if ($this->input->post('submit')){
            $dataWhere .= "WHERE tgl_order BETWEEN '$tgl1' AND '$tgl2' AND status_tagihan = '2'";
            $query = "SELECT * FROM tagihan JOIN `order` ON `order`.no_order = tagihan.no_order ".$dataWhere;
            $order['data']=$this->db->query($query)->result();
            $order['tahun'] = $tahun;
        }else { 
            $query = "SELECT * FROM tagihan JOIN `order` ON `order`.no_order = tagihan.no_order WHERE status_tagihan = '2'";
            $order['data']=$this->db->query($query)->result();
            $order['tahun'] = '2019';
        }
        $this->templates->utama('admin/v_laporan_keuangan', $order);
    }





}