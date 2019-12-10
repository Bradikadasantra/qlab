<?php 
 
class M_admin extends CI_Model{
		
	public function registrasi($data,$table){
		$this->db->insert($table,$data);
	}

	public function data_admin(){
		$this->db->select('*');
		$this->db->from('admin');
		$this->db->join('auth','auth.id_auth = admin.id_auth');
		return $this->db->get();
	}

	public function detail_admin($id_admin){
		$this->db->select('*');
		$this->db->from('admin');
		$this->db->join('auth','auth.id_auth = admin.id_auth');
		$this->db->where('id_admin', $id_admin);
		return $this->db->get();
	}

	public function ambil_admin($id_admin){
		$this->db->select('*');
		$this->db->from('admin');
		$this->db->where('id_admin', $id_admin);
		return $this->db->get();
	}

	public function hapus_admin($where, $table){
		$this->db->where($where);
		return $this->db->delete($table);
		}


	public function update_admin($where,$data,$table){		
			$this->db->where($where);
			return $this->db->update($table,$data);
		}

	public function cari_admin($where){
		$this->db->select('*');
		$this->db->from('admin');
		$this->db->where($where);
		return $this->db->get();
	}

	public function cari_adminAuth($where){
		$this->db->select('*');
		$this->db->from('admin');
		$this->db->join('auth','auth.id_auth = admin.id_auth');
		$this->db->where($where);
		return $this->db->get();
	}

	public function admin_auth ($where, $where_2){
		$this->db->select('*');
		$this->db->from('admin');
		$this->db->join('auth','admin.id_auth = auth.id_auth');
		$this->db->where($where);
		$this->db->where($where_2);
		return $this->db->get();
	}

}
?>