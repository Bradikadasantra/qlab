<?php 
 
class M_bahan_uji extends CI_Model{
		
	public function registrasi($data,$table){
		$this->db->insert($table,$data);
    }

    public function daftar_bahan(){
        $this->db->select('*');
        $this->db->from('bahan_uji');
        $this->db->join('jenis_bahan','jenis_bahan.id = bahan_uji.id_jenis_bahan');
        return $this->db->get();
    }

    public function jenis_bahan(){
        $this->db->select('*');
        $this->db->from('jenis_bahan');
        return $this->db->get();
    }
    
    public function insert($data,$table){
		$this->db->insert($table,$data);
    }
    
    public function detail_bahan($id_bahan){
		$this->db->select('*');
		$this->db->from('bahan_uji');
		$this->db->join('jenis_bahan','jenis_bahan.id = bahan_uji.id_jenis_bahan');
		$this->db->where('id_bahan_uji', $id_bahan);
		return $this->db->get();
  }
  

  public function hapus_bahan($where, $table){
		$this->db->where($where);
		return $this->db->delete($table);
    }
    
    public function update_bahan($where,$data,$table){		
			$this->db->where($where);
			return $this->db->update($table,$data);
		}


}

?>