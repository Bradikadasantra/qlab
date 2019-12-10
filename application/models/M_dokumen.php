<?php 
 
class M_dokumen extends CI_Model{

    public function akses_dokumen($hak_akses){
        $this->db->select('*');
        $this->db->from('dokumen');
        $this->db->join('user_access_dokumen','user_access_dokumen.id_dokumen = dokumen.id_dokumen');
        $this->db->where('hak_akses',$hak_akses);
        return $this->db->get();
    }

    public function hapus_dokumen($where, $table){
		$this->db->where($where);
		return $this->db->delete($table);
		}

    public function all_dokumen($table){
        $this->db->select('*');
        $this->db->from($table);
        return $this->db->get();
    }


    public function dokumen(){
        $this->db->select('*');
        $this->db->from('dokumen');
        return $this->db->get();
    }

    public function insert_dokumen($data,$table){
		$this->db->insert($table,$data);
    }

    public function update_dokumen($where,$data,$table){		
		$this->db->where($where);
		return $this->db->update($table,$data);
  }

    public function revisi_dokumen($where, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        return $this->db->get();
    }

    public function detail_dokumen($where, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        return $this->db->get();
    }

    public function ambil_dokumen($where, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        return $this->db->get();
    }

}

?>