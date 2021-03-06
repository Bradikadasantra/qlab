<?php 
 
class M_dokumen extends CI_Model{

    public function insert($data,$table){
		$this->db->insert($table,$data);
    }

    public function update($where,$data,$table){		
		$this->db->where($where);
		return $this->db->update($table,$data);
  }

  public function hapus($where, $table){
    $this->db->where($where);
    return $this->db->delete($table);
    }

    function get_by_id($table,$param,$id)
    {
        $this->db->where($param, $id);
        return $this->db->get($table)->row();
    }

    public function akses_dokumen($where){
        $this->db->select('*');
        $this->db->from('dokumen_induk');
        $this->db->join('view_dokumen','dokumen_induk.id_dokumen_induk = view_dokumen.id_dokumen_induk');
        $this->db->where($where);
        return $this->db->get();
    }

    public function dokumen_induk(){
        $this->db->select('*');
        $this->db->from('dokumen_induk');
        return $this->db->get();
    }

    public function induk_jenis($where){
        $this->db->select('*');
        $this->db->from('dokumen_induk');
        $this->db->join('jenis_dokumen', 'jenis_dokumen.id_dokumen_induk = dokumen_induk.id_dokumen_induk');
        $this->db->where($where);
        return $this->db->get();
    }


    // INI JUGA DIHAPUS
    public function jenis_dokumen($where){
        $this->db->select('jenis_dokumen.id_jenis_dokumen, nama_dokumen');
        $this->db->distinct();
        $this->db->from('jenis_dokumen');
        $this->db->join('dokumen_akses', 'dokumen_akses.id_jenis_dokumen = jenis_dokumen.id_jenis_dokumen');
        $this->db->where($where);
        return $this->db->get();
    }
    //END

    public function get_pemeriksa($where){
        $this->db->select('*');
        $this->db->from('hak_akses');
        $this->db->join('dokumen_akses','dokumen_akses.hak_akses = hak_akses.id_hak_akses');
        $this->db->join('auth','auth.hak_akses = hak_akses.id_hak_akses');
       $this->db->join('admin','admin.id_auth = auth.id_auth');
        $this->db->where($where);
        return $this->db->get();
    }


    public function get_golongan(){
        $this->db->select('*');
        $this->db->from("hak_akses");
        $this->db->join('golongan','golongan.id_golongan = hak_akses.id_golongan');
    }

    public function all_dataDokumen($where, $where2){
        $this->db->select('*');
        $this->db->from('upload_dokumen');
        $this->db->join('approve_dokumen', 'upload_dokumen.no_dokumen = approve_dokumen.no_dokumen');
        $this->db->where($where);
        $this->db->where($where2);
        return $this->db->get();
    }

    public function upload_approve($where){
        $this->db->select('*');
        $this->db->from('upload_dokumen');
        $this->db->join('approve_dokumen','upload_dokumen.no_dokumen = approve_dokumen.no_dokumen');
        $this->db->where($where);
        return $this->db->get();
    }


    // dikaji lagi dihapus
    public function DokumenRevisi($where){
        $this->db->select('*');
        $this->db->from('upload_dokumen');
        $this->db->join('revisi','upload_dokumen.no_dokumen = revisi.no_dokumen');
        $this->db->where($where);
        return $this->db->get();
    }

    // end

    public function tmp_upload_dokumen($table){
        $this->db->select('*');
        $this->db->from($table);
        return $this->db->get();
    }


}

?>