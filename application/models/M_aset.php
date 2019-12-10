<?php 
 
class M_aset extends CI_Model{

    public function index(){
        $this->db->select('*');
        $this->db->from('aset');
        $this->db->join('merk','aset.merk=merk.id_merk');
        return $this->db->get();
    }

    public function tambah_aset($data,$table){
		$this->db->insert($table,$data);
    }

    public function edit_aset($id){
		$this->db->select('*');
    $this->db->from('aset');
    $this->db->join('merk', 'aset.id_merk=merk.id_merk');
		$this->db->where('id_aset',$id);
		return $this->db->get();
  }
  
  public function data_aset(){
    $this->db->select('*');
    $this->db->from('aset');
    $this->db->join('merk', 'aset.id_merk = merk.id_merk');
    return $this->db->get();
  }

  public function ambil_aset($id_aset){
    $this->db->select('*');
    $this->db->from('aset');
    $this->db->where('id_aset', $id_aset);
    return $this->db->get();  
  }

  public function update_aset($where,$data,$table){		
		$this->db->where($where);
		return $this->db->update($table,$data);
  }
  
  public function hapus_aset($where, $table){
		$this->db->where($where);
		return $this->db->delete($table);
		}


}