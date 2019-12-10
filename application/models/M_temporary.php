<?php 
 
 class M_temporary extends CI_Model{

    public function tampilkan_semua($id_pelanggan){
        $this->db->select('*');
        $this->db->from('tmp_order_detail');
        $this->db->join('tmp_pemeriksaan','tmp_pemeriksaan.id_order_detail = tmp_order_detail.id_order_detail');
        $this->db->join('pengujian','tmp_pemeriksaan.id_pengujian = pengujian.id_pengujian');
        $this->db->where('id_pelanggan', $id_pelanggan);
        return $this->db->get();
   }

 
  // public function tampilkan_semua($id_pelanggan){
    //   $query = "SELECT tmp_order_detail.id_order_detail, tmp_order_detail.nama_sampel, tmp_order_detail.id_pelanggan, tmp_order_detail.pemerian, 
      // tmp_order_detail.kode_batch, tmp_order_detail.jumlah, tmp_order_detail.kemasan, tmp_order_detail.transportasi_sampel, tmp_order_detail.tempat_penyimpanan,
       //tmp_order_detail.hal_lain,
       //GROUP_CONCAT(uji.nama_pengujian SEPARATOR ';  ') AS nama_uji FROM `tmp_order_detail` left JOIN
       //(SELECT tmp_pemeriksaan.id_pemeriksaan, tmp_pemeriksaan.id_order_detail, pengujian.nama_pengujian
       //FROM tmp_pemeriksaan JOIN pengujian ON tmp_pemeriksaan.id_pengujian = pengujian.id_pengujian)uji 
       //on uji.id_order_detail = tmp_order_detail.id_order_detail  where tmp_order_detail.id_pelanggan = '$id_pelanggan' GROUP BY tmp_order_detail.nama_sampel";

       //$run =  $this->db->query($query);
        //return $run; 
  //}
  

}
?>
