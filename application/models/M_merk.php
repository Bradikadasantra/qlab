<?php 
 
class M_merk extends CI_Model{

public function index(){
    return $this->db->get('merk');
}

public function hapus_merk($where, $table){
    $this->db->where($where);
    return $this->db->delete($table);
    }

    public function tambah_merk($data,$table){
		$this->db->insert($table,$data);
    }





}

?>