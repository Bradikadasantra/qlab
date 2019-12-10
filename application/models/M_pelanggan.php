<?php 
 
class M_pelanggan extends CI_Model{
		
	public function registration($data,$table){
		$this->db->insert($table,$data);
	}

	public function data_pelanggan(){
		$this->db->select('*');
		$this->db->from('pelanggan');
		$this->db->join('auth','auth.id_auth = pelanggan.id_auth');
		return $this->db->get();
	}

	public function detail_pelanggan($id_pelanggan){
		$this->db->select('*');
		$this->db->from('pelanggan');
		$this->db->join('auth','auth.id_auth = pelanggan.id_auth');
		$this->db->where('id_pelanggan', $id_pelanggan);
		return $this->db->get();
	}

	public function ambil_pelanggan($id_pelanggan){
		$this->db->select('*');
		$this->db->from('pelanggan');
		$this->db->where('id_pelanggan', $id_pelanggan);
		return $this->db->get();
	}

	public function update_pelanggan($where,$data,$table){		
		$this->db->where($where);
		return $this->db->update($table,$data);
	}

	public function hapus_pelanggan($where, $table){
		$this->db->where($where);
		return $this->db->delete($table);
		}

	public function ambil_info_pelanggan($id_auth){
		$this->db->select('*');
		$this->db->from('pelanggan');
		$this->db->join('auth','auth.id_auth = pelanggan.id_auth');
		$this->db->where('pelanggan.id_auth', $id_auth);
		return $this->db->get();
	}


}
?>