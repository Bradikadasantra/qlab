
<?php 
 
class M_login extends CI_Model{
		
	public function registration($data,$table){
		$this->db->insert($table,$data);
	}

	public function cek_login_user($where, $table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->get();
	}
}
?>