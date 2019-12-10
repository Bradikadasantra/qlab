<?php 
 
class M_registrasi_sampel extends CI_Model{

    public function insert($data, $table){
            $this->db->insert($table,$data);
    }

    public function insert_batch($data, $table){
        $this->db->insert_batch($table, $data);
    }

    public function delete($where, $table){
		$this->db->where($where);
		return $this->db->delete($table);
        }

    public function update($where,$data,$table){		
		$this->db->where($where);
		return $this->db->update($table,$data);
    }

    function get_by_id($table,$param,$id)
    {
        $this->db->where($param, $id);
        return $this->db->get($table)->row();
    }


    public function list_perNoOrder(){
        $this->db->select('order.no_order, id_pelanggan');
        $this->db->distinct();
        $this->db->from('order');  
        $this->db->order_by('tgl_order','desc');
        return $this->db->get();
    }

    public function order_orderDetail($where){
        $this->db->select('*');
        $this->db->from('order');
        $this->db->join('order_detail','order_detail.no_order = order.no_order');
        $this->db->where($where);
        return $this->db->get();
    }

    public function tampil_perbidang($id_bidang, $status){
        $this->db->select('order.no_order, id_pelanggan');
        $this->db->distinct();
        $this->db->from('order');
        $this->db->join('order_detail','order.no_order = order_detail.no_order');
        $this->db->join('sampel','sampel.id_order_detail = order_detail.id_order_detail');
        $this->db->where($id_bidang);
        $this->db->where($status);
        $this->db->order_by('tgl_order', 'desc');               
        return $this->db->get();
     }

    public function pengujian($kode_bidang){
        $this->db->select('*');
        $this->db->from('bidang');
        $this->db->join('pengujian','pengujian.id_bidang = bidang.id_bidang');
        $this->db->where('pengujian.id_bidang',$kode_bidang);
        return $this->db->get();
    }

    public function tampil_riwayat ($id_pelanggan){
        $this->db->select('*');
        $this->db->from('order');
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->order_by('tgl_order', 'DESC');
        return $this->db->get();

}
    public function invoice($no_order){
        $this->db->select('*');
        $this->db->from('order');
        $this->db->join('pelanggan', 'order.id_pelanggan = pelanggan.id_pelanggan');
        $this->db->where('no_order', $no_order);
        return $this->db->get();
    }

    public function detail_order($no_order){
        $this->db->select('*');
        $this->db->from('order_detail');
        $this->db->join('sampel','sampel.id_order_detail = order_detail.id_order_detail');
        $this->db->join('pemeriksaan','pemeriksaan.id_sampel = sampel.id_sampel');
        $this->db->where('no_order', $no_order);
        return  $this->db->get();
    }

    public function detail_order2($where, $where2, $where3){
        $this->db->select('*');
        $this->db->from('order_detail');
        $this->db->join('sampel','sampel.id_order_detail = order_detail.id_order_detail');
        $this->db->join('pemeriksaan', 'pemeriksaan.id_sampel = sampel.id_sampel');
        $this->db->where($where);
        $this->db->where($where2);
        $this->db->where($where3);
        return $this->db->get();
    }

    public function detail_order3($where, $where2, $where3){
        $this->db->select('hasil_pemeriksaan.id_pemeriksaan');
        $this->db->distinct();
        $this->db->from('order_detail');
        $this->db->join('sampel','sampel.id_order_detail = order_detail.id_order_detail');
        $this->db->join('pemeriksaan', 'pemeriksaan.id_sampel = sampel.id_sampel');
        $this->db->join('hasil_pemeriksaan', 'hasil_pemeriksaan.id_pemeriksaan = pemeriksaan.id_pemeriksaan');
        $this->db->where($where);
        $this->db->where($where2);
        $this->db->where($where3);
        return $this->db->get();
    }

    public function all_data_order($where){
        $this->db->select('*');
        $this->db->from('pelanggan');
        $this->db->join('order','pelanggan.id_pelanggan = order.id_pelanggan');
        $this->db->join('order_detail','order_detail.no_order = order.no_order');
        $this->db->join('sampel','sampel.id_order_detail = order_detail.id_order_detail');
        $this->db->where($where);
        return $this->db->get();
    }

    public function all_data_perbidang($where,$where2){
        
        $this->db->select('*');
        $this->db->from('order');
        $this->db->join('order_detail','order_detail.no_order = order.no_order');
        $this->db->join('sampel','sampel.id_order_detail = order_detail.id_order_detail');
        $this->db->where($where);
        $this->db->where($where2);
        return $this->db->get();
    }

    public function all_data_perbidang2($where, $where2, $where3){
        $this->db->select('*');
        $this->db->from('order');
        $this->db->join('order_detail','order_detail.no_order = order.no_order');
        $this->db->join('sampel','sampel.id_order_detail = order_detail.id_order_detail');
        $this->db->where($where);
        $this->db->where($where2);
        $this->db->where($where3);
        return $this->db->get();
    }

    public function all_data_perbidang3($where, $where2, $where3, $where4){
        $this->db->select('*');
        $this->db->from('order');
        $this->db->join('order_detail','order_detail.no_order = order.no_order');
        $this->db->join('sampel','sampel.id_order_detail = order_detail.id_order_detail');
        $this->db->where($where);
        $this->db->where($where2);
        $this->db->where($where3);
        $this->db->where($where4);
        return $this->db->get();
    }

    public function all_sampel($where){
        $this->db->select('*');
        $this->db->from('sampel');
        $this->db->where($where);
        return $this->db->get();
    }

    public function sampel_siap_uji($where){
        $this->db->select('*');
        $this->db->from('order');  
        $this->db->join('order_detail','order_detail.no_order = order.no_order');
        $this->db->join('sampel','sampel.id_order_detail = order_detail.id_order_detail');
        $this->db->where($where);
        return $this->db->get();
    }

    public function notif_navbar($id_bidang, $status, $tinjauan){
        $this->db->select('order.no_order');
        $this->db->distinct();
        $this->db->from('order');
        $this->db->join('order_detail','order.no_order = order_detail.no_order');
        $this->db->join('sampel','sampel.id_order_detail = order_detail.id_order_detail');
        $this->db->where($id_bidang);
        $this->db->where($status);
        $this->db->where($tinjauan);
        return $this->db->get();
    }

    public function tagihan_konfirmByr(){
        $this->db->select('*');
        $this->db->from('tagihan');
        $this->db->join('konfirmasi_byr','tagihan.no_tagihan = konfirmasi_byr.no_tagihan');
        return $this->db->get();
    }

    public function detail_KonfirmBayar($where){
        $this->db->select('*');
        $this->db->from('tagihan');
        $this->db->join('konfirmasi_byr','tagihan.no_tagihan = konfirmasi_byr.no_tagihan');
        $this->db->join('order','order.no_order = tagihan.no_order');
        $this->db->where($where);
        return $this->db->get();
    }













    //hapus dari sini 

    public function sampel_pemeriksaan_pengujian($where){
        $this->db->select('*');
        $this->db->from('sampel');
        $this->db->join('pemeriksaan','sampel.id_sampel = pemeriksaan.id_sampel');
        $this->db->join('pengujian','pengujian.id_pengujian = pemeriksaan.id_pengujian');
        $this->db->where('status_pemeriksaan',2);
        $this->db->where($where);
        return $this->db->get();
    }

    public function pemeriksaan_hasil($where){
        $this->db->select('*');
        $this->db->from('sampel');
        $this->db->join('hasil_pemeriksaan', 'hasil_pemeriksaan.id_pemeriksaan = pemeriksaan.id_pemeriksaan');
        $this->db->where($where);
        return $this->db->get();
    }

    public function pemeriksaan_hasilPemeriksaan($where){
        $this->db->select('*');
        $this->db->from('pemeriksaan');
        $this->db->join('hasil_pemeriksaan','pemeriksaan.id_pemeriksaan = hasil_pemeriksaan.id_pemeriksaan');
        $this->db->where($where);
        return $this->db->get();
    }

    public function sampel_pemeriksaan($where){
        $this->db->select('*');
        $this->db->from('sampel');
        $this->db->join('pemeriksaan', 'pemeriksaan.id_sampel = sampel.id_sampel');
        $this->db->where($where);
       return $this->db->get();
    }


    public function list_ApproveHasilPemeriksaan($id_bidang){
        $this->db->select('sampel.id_sampel, order.id_pelanggan');
        $this->db->distinct();
        $this->db->from('order');
        $this->db->join('order_detail','order_detail.no_order = order.no_order');
        $this->db->join('sampel','sampel.id_order_detail = order_detail.id_order_detail');
        $this->db->join('pemeriksaan','pemeriksaan.id_sampel = sampel.id_sampel');
        $this->db->where('id_bidang', $id_bidang);
        $this->db->where("(status_sertifikat = '1' OR status_sertifikat = '3')");
        return $this->db->get();
     }

     public function sampel_siap_approve($where){
         $this->db->select('*');
         $this->db->from('order');
         $this->db->join('pelanggan','order.id_pelanggan = pelanggan.id_pelanggan');
         $this->db->join('order_detail','order_detail.no_order = order.no_order');
         $this->db->join('sampel','sampel.id_order_detail = order_detail.id_order_detail');
         $this->db->where($where);
         return $this->db->get();
     }

     public function sorting_SampelPemeriksaan($where){
         $this->db->select('sampel.id_sampel');
         $this->db->distinct();
         $this->db->from('sampel');
         $this->db->join('pemeriksaan','pemeriksaan.id_sampel = sampel.id_sampel');
         $this->db->where($where);
         return $this->db->get();
     }

  

     public function status_tinjauan($id_bidang, $status, $tinjauan, $id_sampel){
        $this->db->select('order.no_order');
        $this->db->distinct();
        $this->db->from('order');
        $this->db->join('order_detail','order.no_order = order_detail.no_order');
        $this->db->join('sampel','sampel.id_order_detail = order_detail.id_order_detail');
        $this->db->where($id_bidang);
        $this->db->where($status);
        $this->db->where($tinjauan);
        $this->db->where($id_sampel);
        return $this->db->get();
    }


    public function status_sertifikat($no_order, $id_bidang){
        $this->db->select('status_sertifikat');
        $this->db->distinct();
        $this->db->from('order');
        $this->db->join('order_detail','order.no_order = order_detail.no_order');
        $this->db->join('sampel','sampel.id_order_detail = order_detail.id_order_detail');
        $this->db->where($no_order);
        $this->db->where($id_bidang);
        return $this->db->get();
    }
}


?>