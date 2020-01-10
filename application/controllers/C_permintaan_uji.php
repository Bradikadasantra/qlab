<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_permintaan_uji extends MY_Controller {

    public function __construct(){
        parent:: __construct();
        $this->cekLogin();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('templates');
        $this->load->model('m_registrasi_sampel');
        $this->load->model('m_pelanggan');
        $this->load->model('m_admin');
    }


    // START AKSI BY ADMIN SAMPEL 
    public function approval_sa(){
        $data['permintaan']  = $this->m_registrasi_sampel->list_perNoOrder()->result();
        $this->templates->utama('admin/v_permintaan_uji_sa', $data);
    }

    public function terima_sampel($id_sampel){
    $field  = array('id_sampel'=> $id_sampel);
    $que    = $this->m_registrasi_sampel->all_sampel($field)->row();
    $row    = $this->m_registrasi_sampel->get_by_id('sampel','id_sampel', $id_sampel);
    $row2   = $this->m_registrasi_sampel->get_by_id('order_detail','id_order_detail', $row->id_order_detail);


    $data = array(  
      'status_sampel'   => 1
    );
    $run    = $this->m_registrasi_sampel->update(array('id_sampel'=> $id_sampel), $data, 'sampel');
    if ($run = 1){
      $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong><center> Sampel telah diterima </center></strong></div>');
      }else{
        $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong><center> Gagal terima sampel </center></strong></div>');
      }
      redirect('c_permintaan_uji/detail_permintaan/'.$row2->no_order);
    }

    public function terima_sa($no_order){
    $row  = $this->m_registrasi_sampel->get_by_id('order_detail','no_order', $no_order);   
    $search = $this->m_registrasi_sampel->all_data_perbidang(array('order.no_order'=> $no_order),array('id_sampel !='=> 6))->result();
      $data = array(
        'status'          => 1
      ); 

      foreach ($search as $baris){
        $dat = array(
          'terima_sampel'   => date('Y-m-d')
        );
        $run = $this->m_registrasi_sampel->update(array('id_order_detail' => $baris->id_order_detail), $dat, 'order_detail');
      }
      $run = $this->m_registrasi_sampel->update(array('no_order' => $no_order), $data, 'order');
    
        if ($run = 1){
          echo $this->session->set_flashdata('pesan', 
          '<script>
          swal("Success !", "Sukses terima sampel !", "success"); 
          </script>');
        }else{  
          echo $this->session->set_flashdata('pesan', 
          '<script>
              swal({
              title: "Failed",
              text: "Gagal terima sampel",
              type: "warning",
              });
          </script>');
        }
      redirect('c_permintaan_uji/detail_permintaan/'.$no_order); 
    }

    //END AKSI BY ADMIN SAMPEL 

    public function detail_permintaan($no_order){
        $hak_akses = $this->session->userdata('hak_akses');
        $where = array('order.no_order' => $no_order);
        $get = $this->m_registrasi_sampel->get_by_id('admin','id_auth', $this->session->userdata('id_auth'));
        $row = $this->m_registrasi_sampel->get_by_id('order','no_order',$no_order);

        if ($hak_akses == 1){
            $data['status']     = $row->status; 
            $data ['no_order']  = $no_order;
            $data['detail'] = $this->m_registrasi_sampel->all_data_order($where)->result();
            $this->templates->utama('admin/v_detail_permintaan_uji_sa', $data); 
        }
        else if ($hak_akses == 6 ){
            $data['status']     = $row->status; 
            $data ['no_order']  = $no_order;
            $data['detail']     = $this->m_registrasi_sampel->all_data_perbidang2($where, array('id_bidang'=> $get->id_bidang), array('status_sampel !='=> 6))->result();
            $this->templates->utama('admin/v_detail_permintaan_uji_mt', $data);
        }
        else if ($hak_akses == 5 ){
          $data['status']     = $row->status; 
          $data ['no_order']  = $no_order;
          $data['detail']     = $this->m_registrasi_sampel->order_orderDetail($where)->result();
          $this->templates->utama('admin/v_detail_manajer_opr', $data);
      }
        else {
            $data['status']     = $row->status; 
            $data ['no_order']  = $no_order;
            $data['detail'] = $this->m_registrasi_sampel->all_data_perbidang2($where, array('id_bidang' => $get->id_bidang), "(status_sampel != '3' and status_sampel != '6')")->result();
            $this->templates->utama('admin/v_detail_permintaan_uji_tek', $data);
        }
    }
    // START AKSI BY MANAJER TEKNIK 
    public function approval_mt(){
        $hak_akses  = $this->session->userdata ('hak_akses');
        $id_auth    = $this->session->userdata('id_auth');   
        $where      = array ('id_auth'=> $id_auth);
        $cari       = $this->m_admin->cari_admin($where)->row();
        $id_bidang  = $cari->id_bidang; 
        $where = "(status != '0' AND status_sampel != '6')";
        $where2 = "(status = '6' AND status_sampel = '5')";
        
        if ($hak_akses == 6 ){
              $data['id_bidang'] = $id_bidang;
              $data['list']   = $this->m_registrasi_sampel->tampil_perbidang(array('id_bidang' => $id_bidang), $where)->result();
              $data['list_2'] = $this->m_registrasi_sampel->tampil_perbidang(array('id_bidang' => $id_bidang), $where2)->result();
              $this->templates->utama('admin/v_permintaan_uji_mt', $data); 
          }
          else{
            redirect ('auth');
          }
    }

    public function tindak_lanjut_mt($id_sampel){
    $qry        = "SELECT id_bidang FROM sampel WHERE id_sampel = {$id_sampel}";
    $run        = $this->db->query($qry)->row();
    $id_bidang  = $run->id_bidang; 
    $ss = $this->m_admin->admin_auth(array('id_bidang'=> $id_bidang), array('hak_akses' => 6))->row();
    $hak_akses = $ss->hak_akses; 

    $row = $this->m_registrasi_sampel->get_by_id('sampel', 'id_sampel', $id_sampel);
    $row2 = $this->m_registrasi_sampel->get_by_id('order_detail', 'id_order_detail', $row->id_order_detail);


      if ($id_bidang == 'M' && $hak_akses == 6 ){
        $data = array(
          'id_sampel'           => $id_sampel,
          'hak_akses'           => $hak_akses,
          'id_admin'            => $ss->id_admin, 
          'nama'                => $ss->nama,
          'bidang'              => 'Mikrobiologi',
          'action'              => base_url('c_permintaan_uji/action_tinjauanMT'),
          'back'                => base_url('c_permintaan_uji/detail_permintaan/'.$row2->no_order)
        );
      }
      else if ($id_bidang == 'K' && $hak_akses == 6){
        $data = array(
          'id_sampel'            => $id_sampel,
          'id_admin'             => $ss->id_admin,
          'nama'                 => $ss->nama,
          'bidang'               => 'Kimia',
          'action'               => base_url('c_permintaan_uji/action_tinjauanMT'),
          'back'                 => base_url('c_permintaan_uji/detail_permintaan/'.$row2->no_order)
        );
      }
      else if ($id_bidang == 'F' && $hak_akses == 6){
        $data = array(
          'id_sampel'           => $id_sampel,
          'id_admin'            => $ss->id_admin,
          'nama'                => $ss->nama,
          'bidang'              => 'Farmakologi',
          'action'              => base_url('c_permintaan_uji/action_tinjauanMT'),
          'back'                => base_url('c_permintaan_uji/detail_permintaan/'.$row2->no_order)
        );
      }
     else{
        redirect('auth');
      }
      $this->templates->utama('admin/v_form_tinjauanMt', $data);
    }

  public function action_tinjauanMT(){
    $id_sampel = $this->input->post('id_sampel'); 
    $row = $this->m_registrasi_sampel->get_by_id('sampel', 'id_sampel', $id_sampel);
    $row2 = $this->m_registrasi_sampel->get_by_id('order_detail', 'id_order_detail', $row->id_order_detail);
    $row3 = $this->m_registrasi_sampel->get_by_id('tinjauan_mt', 'id_tinjauan_mt', $id_sampel);
  
      // rules validasi form sebelum submit
      $this->form_validation->set_rules('kesiapan_teknik[]','Kesiapan Teknik','required|trim', array('required'=>'Kesiapan Teknik harus diisi...!'));
      $this->form_validation->set_rules('kesimpulan','Kesimpulan','required|trim', array('required'=>'Pilih salah satu...!'));

    if ($this->input->post('submit')){
      if ($this->form_validation->run() == false){
        $this->tindak_lanjut_mt($id_sampel);
      }else{  
        if ($this->session->userdata('hak_akses') == 6){
            $kesiapan_teknik = $this->input->post('kesiapan_teknik[]');
            $diubah = serialize($kesiapan_teknik);
                $data = array(
                  'id_sampel'             => $id_sampel, 
                  'kesiapan_teknik'       => $diubah,
                  'kesimpulan'            => $this->input->post('kesimpulan'),
                  'status_tinjauan'       => 'Sudah Validasi',
                  'catatan'               => $this->input->post('catatan'),
                  'konfirmasi_pelanggan'  => "",
                  'id_admin'              => $this->input->post('id_admin'),
                  'tgl_ditinjau'          => date('Y-m-d')
                );
                if ($this->input->post('kesimpulan') == 'Tidak dapat dilaksanakan'){
                  $data2 = array(
                    'status_sampel'       => 3,
                    'status_tinjauan_mt'  => 1
                  );
                    $kueri = $this->db->query("SELECT * FROM pemeriksaan WHERE id_sampel = '$id_sampel'")->result();
                    foreach ($kueri as $k){
                      $biaya_pemeriksaan = array(
                        'biaya_pemeriksaan' => 0
                      ); 
                      $update = $this->m_registrasi_sampel->update(array('id_pemeriksaan'=> $k->id_pemeriksaan), $biaya_pemeriksaan, 'pemeriksaan');
                    }
                    $tag = array(
                      'jumlah_tagihan' => getJumlah($row2->no_order)
                    );
                    $s = $this->m_registrasi_sampel->update(array('no_order'=> $row2->no_order), $tag, 'tagihan');

                }else if($this->input->post('kesimpulan') == 'Dapat dilaksanakan dengan'){
                  $data2 = array(
                    'status_sampel'     => 4,
                    'status_tinjauan_mt'  => 1
                  );
                }else{
                  $data2 = array(
                    'status_sampel'     => 2,
                    'status_tinjauan_mt'  => 1
                  );
                }
              
                $result = $this->m_registrasi_sampel->update(array('id_sampel'=> $id_sampel),$data2, 'sampel');
                $result = $this->m_registrasi_sampel->insert($data, 'tinjauan_mt');
               
                if ($result = 1){
                  $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong><center> Tinjauan berhasil dibuat </center></strong></div>');
                }else{
                  $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong><center> Tinjauan gagal dibuat </center></strong></div>');
                }
              }
       else{
          redirect ('auth');
        }
        redirect('c_permintaan_uji/detail_permintaan/'.$row2->no_order);
      }
    }else{
      redirect('auth');
    }
  }

   
    public function mt_selesai2($no_order, $id_bidang){

      $where = array('order.no_order'=> $no_order);
      $default  = $this->m_registrasi_sampel->all_data_perbidang2(array('order.no_order' => $no_order),array('id_bidang'=> $id_bidang), array('status_sampel != '=> 6))->result();
      $cek_1 = $this->m_registrasi_sampel->all_data_perbidang($where, array('status_sampel !=' => 6))->result();
      $cek_2 = $this->m_registrasi_sampel->all_data_perbidang2($where, array('id_bidang' => $id_bidang),"(status_tinjauan_mt = '1' AND status_sampel != '6')")->result();
      
      $check  = count($this->m_registrasi_sampel->all_data_perbidang($where, array('status_sampel !=' => 6))->result());
      $check_1= count($this->m_registrasi_sampel->all_data_perbidang($where, array('status_sampel' => 2))->result());
      $check_3= count($this->m_registrasi_sampel->all_data_perbidang($where, array('status_sampel' => 3))->result());
     
      if (count($cek_1) == count($cek_2)){
        if ($check == $check_1){
          $data = array(
            'status'    => 2
          );
        }else if ($check == $check_3 ){
        $data = array(
          'status'      => 3
        );
      }else{
            $data = array(
              'status'    => 4
            );
          } 
        foreach ($default as $baris){
          $t = array('status_tinjauan_mt' => 2);
          $run = $this->m_registrasi_sampel->update(array('id_sampel' => $baris->id_sampel), $t, 'sampel');
        }
        $run = $this->m_registrasi_sampel->update(array('no_order' => $no_order),$data, 'order');

      }else{
            $kueri =  $this->m_registrasi_sampel->all_data_perbidang2($where, "(id_bidang != '$id_bidang' AND status_sampel != '6')", "(status_tinjauan_mt = '1' OR status_tinjauan_mt = '0')");
            if ($kueri->num_rows() > 0){
            
                $cari_idsampel = $this->m_registrasi_sampel->all_data_perbidang2($where, array('id_bidang'=>$id_bidang), array('id_bidang !=' => 6))->result();
                  foreach ($cari_idsampel as $row){
                    $t = array('status_tinjauan_mt' => 2);
                    $run = $this->m_registrasi_sampel->update(array('id_sampel' => $row->id_sampel), $t, 'sampel');
                  }
            }else{
              if ($check == $check_1){
                $data = array(
                  'status'    => 2
                );
              }else if ($check == $check_3 ){
              $data = array(
                'status'      => 3
              );
              }else{
                  $data = array(
                    'status'    => 4
                  );
                } 
              foreach ($cek_1 as $baris){
                $t = array('status_tinjauan_mt' => 2);
                $run = $this->m_registrasi_sampel->update(array('id_sampel' => $baris->id_sampel), $t, 'sampel');
              }
              $run = $this->m_registrasi_sampel->update(array('no_order' => $no_order),$data, 'order');
            }
      }
        if ($run = 1){
          echo $this->session->set_flashdata('pesan', 
          '<script>
          swal("Success !", "Sukses !", "success"); 
          </script>');
        }else{
          echo $this->session->set_flashdata('pesan', 
        '<script>
            swal({
            title: "Failed",
            text: "Gagal",
            type: "warning",
            });
        </script>');
        }
        redirect('c_permintaan_uji/detail_permintaan/'.$no_order);
    }


    // function yang digunakan untuk mengkonfirmasi pelanggan, apakah mau lanjut pengujian atau tidak jika ada sampel yang perlu ditunjau
  public function hasilTinjauan_mt($id_sampel){
    $query = "SELECT * FROM sampel JOIN (tinjauan_mt JOIN `admin` ON tinjauan_mt.id_admin = `admin`.id_admin) ON sampel.id_sampel = tinjauan_mt.id_sampel WHERE sampel.id_sampel = '$id_sampel'";
    $run   = $this->db->query($query)->row();
    $row = $this->m_registrasi_sampel->get_by_id('sampel', 'id_sampel', $id_sampel);
    $row2 = $this->m_registrasi_sampel->get_by_id('order_detail', 'id_order_detail', $row->id_order_detail);
    $hak_akses = $this->session->userdata('hak_akses');


    if ($hak_akses == 6){
      $data = array (
        'id_sampel'       => $id_sampel,
        'bidang'          => $run->id_bidang,
        'disabled_mt'     => 'disabled',
        'nama'            => $run->nama,  
        'cek'             => unserialize($run->kesiapan_teknik),
        'cek_kesimpulan'  => $run->kesimpulan,
        'catatan'         => $run->catatan,
        'konfirmasi_pelanggan' => $run->konfirmasi_pelanggan, 
        'submit_button'   => '',
        'disabled_textarea'   => 'disabled', 
        'action'          => '',
        'back'            => base_url('c_permintaan_uji/detail_permintaan/'.$row2->no_order)
        );
    }else if ($hak_akses == 12){
      $data = array (
        'id_sampel'       => $id_sampel,
        'bidang'          => $run->id_bidang,
        'disabled_mt'     => 'disabled',
        'nama'            => $run->nama,  
        'cek'             => unserialize($run->kesiapan_teknik),  
        'cek_kesimpulan'  => $run->kesimpulan, 
        'catatan'         => $run->catatan,
        'konfirmasi_pelanggan' => $run->konfirmasi_pelanggan, 
        'disabled_textarea'   => '', 
        'submit_button'   => '<input type="submit" class="btn btn-success btn-sm" value="submit" name="submit">',
        'action'          => base_url('c_permintaan_uji/action_konfirmasiPelanggan'),
        'back'            => base_url('c_pelanggan/tampil_riwayat')
        );
    }else if ($hak_akses == 7){
      $data = array (
        'id_sampel'       => $id_sampel,
        'bidang'          => $run->id_bidang,
        'disabled_mt'     => 'disabled',
        'nama'            => $run->nama,  
        'cek'             => unserialize($run->kesiapan_teknik),
        'cek_kesimpulan'  => $run->kesimpulan,
        'catatan'         => $run->catatan,
        'konfirmasi_pelanggan' => $run->konfirmasi_pelanggan, 
        'submit_button'   => '',
        'disabled_textarea'   => 'disabled', 
        'action'          => '',
        'back'            => base_url('c_permintaan_uji/detail_permintaan/'.$row2->no_order)
        );
  }else{
        redirect('auth');
    }
    $this->templates->utama('admin/v_hasilTinjauan_mt', $data);
  }

  public function action_konfirmasiPelanggan(){
    $id_sampel = $this->input->post('id_sampel');
    $this->form_validation->set_rules('konfirmasi_pelanggan','Konfirmasi Pelanggan','required|trim', array('required'=>'Konfirmasi Pelanggan tidak boleh kosong...!'));

    if ($this->input->post('submit')){
      if ($this->form_validation->run() == false){
        $this->hasilTinjauan_mt($id_sampel);
      }else{  
        $data = array(
          'konfirmasi_pelanggan'  => $this->input->post('konfirmasi_pelanggan'),
        );
        $data_2 = array(
          'status_sampel'    => 5
        );
        $run = $this->m_registrasi_sampel->update(array('id_sampel' => $id_sampel), $data, 'tinjauan_mt');
        $ruin = $this->m_registrasi_sampel->update(array('id_sampel' => $id_sampel), $data_2, 'sampel');
          if ($run = 1 AND $ruin = 1){
            echo $this->session->set_flashdata('pesan', 
            '<script>
            swal("Success !", "Konfirmasi Sampel Berhasil !", "success"); 
            </script>');
          }else{
            echo $this->session->set_flashdata('pesan', 
            '<script>
                swal({
                title: "Failed",
                text: "Konfirmasi Sampel Gagal",
                type: "warning",
                });
            </script>');
        }
        redirect('c_pelanggan/tampil_riwayat');
      }
    }else{
        redirect('auth');
    }
  }


  public function jika_ya($no_order){
    $cek_5  = $this->m_registrasi_sampel->all_data_perbidang(array('order.no_order' => $no_order), array('status_sampel' => 5))->num_rows();
    $cek_3  = $this->m_registrasi_sampel->all_data_perbidang(array('order.no_order' => $no_order), array('status_sampel'=> 3))->num_rows();


    if ($cek_5 > 0){
      $data = array(
        'status'    => 6
      ); 
      $where  = array('order.no_order' => $no_order); 
      $run = $this->m_registrasi_sampel->update($where, $data, 'order');
    }else{
      $data = array('status' => 2);
      $lanjut = $this->m_registrasi_sampel->update(array('order.no_order'=> $no_order), $data, 'order');
    }
        if ($run = 1 or $lanjut = 1){
          echo $this->session->set_flashdata('pesan', 
          '<script>
          swal("Success !", "Konfirmasi Sampel Berhasil !", "success"); 
          </script>');
        }else{
          echo $this->session->set_flashdata('pesan', 
          '<script>
              swal({
              title: "Failed",
              text: "Gagal konfrimasi sampel",
              type: "warning",
              });
          </script>');
            }
        redirect('c_pelanggan/tampil_riwayat');
    }

    public function jika_tidak($no_order){
      $data = array(
        'status'    => 3
      ); 
      $run = $this->m_registrasi_sampel->update(array('order.no_order' => $no_order), $data, 'order');

      if ($run = 1){
        echo $this->session->set_flashdata('pesan', 
        '<script>
        swal("Success !", "Pengujian sampel berhasil dibatalkan!", "success"); 
        </script>');
      }else{
        echo $this->session->set_flashdata('pesan', 
        '<script>
            swal({
            title: "Failed",
            text: "Pengujian sampel gagal dibatalkan",
            type: "warning",
            });
        </script>');
          }
          redirect ('c_pelanggan/tampil_riwayat');
    }

    public function tindakLanjut_konfirmPelanggan($no_order){
      $data = array(
        'status'    => 2
      );
      $where = array('order.no_order' => $no_order); 
      $run = $this->m_registrasi_sampel->update($where, $data, 'order'); 

        if($run = 1){
          echo $this->session->set_flashdata('pesan', 
          '<script>
          swal("Success !", "Pengujian sampel berhasil dilanjutkan !", "success"); 
          </script>');
        }else{
          echo $this->session->set_flashdata('pesan', 
          '<script>
              swal({
              title: "Failed",
              text: "Pengujian sampel gagal dilanjutkan !",
              type: "warning",
              });
          </script>');
        }
      redirect('c_permintaan_uji/detail_permintaan/'.$no_order); 
    }

  public function approval_tek(){
      $hak_akses  = $this->session->userdata ('hak_akses');
      $id_auth    = $this->session->userdata('id_auth');   
      $where      = array ('id_auth'=> $id_auth);
      $cari       = $this->m_admin->cari_admin($where)->row();
      $id_bidang  = $cari->id_bidang;
      $where = "(status = '2' AND status_sampel != '3' AND status_sampel != '6' AND status_tinjauan_anl = '0')"; 
      $where2 = "(status = '2' OR status = '8' OR status = '9' OR status = '10')";
      $where3 = "(status = '9' AND status_sertifikat = '3')";

      if ($hak_akses == 7){
          $data['id_bidang'] = $id_bidang; 
          $data['permintaan'] = $this->m_registrasi_sampel->tampil_perbidang(array('id_bidang' => $id_bidang), $where)->result();
          $data['permintaan_2'] = $this->m_registrasi_sampel->tampil_perbidang("(id_bidang = '$id_bidang' AND status_sampel != '3' AND status_sampel != '6')", $where2)->result();
          $data['permintaan_3'] = $this->m_registrasi_sampel->tampil_perbidang(array('id_bidang' => $id_bidang), $where3)->result();
          $this->templates->utama('admin/v_permintaan_uji_tek', $data); 
      }else{
        redirect ('auth');
      }
    }

    public function kerjakan_sampel($no_order, $id_bidang){
      
      $where = array('order.no_order' => $no_order);
      $kueri = $this->m_registrasi_sampel->all_data_perbidang2($where, array('id_bidang'=> $id_bidang), "(status_sampel != '3' AND status_sampel != '6' AND status_tinjauan_anl = '0')");
          foreach ($kueri->result() as $baris){
            $data = array(
              'status_tinjauan_anl' => 1
            );
            $run = $this->m_registrasi_sampel->update(array('id_sampel'=> $baris->id_sampel), $data, 'sampel');
          }    
        if ($run = 1){
          echo $this->session->set_flashdata('pesan', 
          '<script>
          swal("Success !", "Sampel dikerjakan !", "success"); 
          </script>');
        }else{
          echo $this->session->set_flashdata('pesan', 
          '<script>
              swal({
              title: "Failed",
              text: "Sampel gagal dikerjakan !",
              type: "warning",
              });
          </script>'); 
        }
        redirect('c_permintaan_uji/detail_permintaan/'.$no_order);
    } 

  public function input_hasilpemeriksaan($no_order, $kode){
    $hak_akses  = $this->session->userdata ('hak_akses');
    $id_auth    = $this->session->userdata('id_auth');   
    $where      = array ('id_auth'=> $id_auth);
    $cari       = $this->m_admin->cari_admin($where)->row();
    $id_bidang  = $cari->id_bidang;

    $where  = array('order.no_order' => $no_order);
    $where2 = array('id_bidang' => $id_bidang);
    $where3 = "(status_sampel != '3' AND status_sampel != '6')"; 
    $where4 = 'status_sertifikat = 3';    
  
        if ($hak_akses == 7 ){
            if ($kode == 'input_hasil'){
              $data['detail']  = $this->m_registrasi_sampel->all_data_perbidang2($where, $where2, $where3)->result();
              $data['no_order'] = $no_order; 
              $data['id_bidang'] = $id_bidang;
              $data['action']    = base_url('c_permintaan_uji/ajukan_sertifikasi/'.$no_order.'/'.$id_bidang);
            

            }else if ($kode == 'uji_ulang'){
              $data['detail']  = $this->m_registrasi_sampel->all_data_perbidang2($where, $where2, $where4)->result();
              $data['no_order'] = $no_order; 
              $data['id_bidang'] = $id_bidang;
              $data['action'] = base_url('c_permintaan_uji/ajukan_sertifikasi_ulang/'.$no_order.'/'.$id_bidang);
            }
            $this->templates->utama('admin/v_form_hasil_pemeriksaan', $data);
        }else{
          redirect ('auth');
        }
     
    }

    public function modal_inputHasil($kode){
      $id_sampel = $this->input->post('rowid');
      $row = $this->m_registrasi_sampel->get_by_id('sampel', 'id_sampel', $id_sampel);
      $row2 = $this->m_registrasi_sampel->get_by_id('order_detail', 'id_order_detail', $row->id_order_detail);
      $row3 = $this->m_registrasi_sampel->get_by_id('order','no_order', $row2->no_order);
      
      $data['tgl_order'] = $row3->tgl_order; 
      $data['no_sampel'] = $row->no_sampel; 
      $data['kode'] = $kode;
      $data['id_sampel']  = $id_sampel;
      $data['data'] = $this->db->query("SELECT * FROM pemeriksaan WHERE id_sampel = ' $id_sampel'")->result();

      $this->load->view('admin/v_modal_inputHasil', $data); 
    }

    public function modal_editHasil($kode){
      $id_hasil_pemeriksaan =$this->input->post('rowid');
      $search = $this->m_registrasi_sampel->get_by_id('hasil_pemeriksaan', 'id_hasil_pemeriksaan',$id_hasil_pemeriksaan);
      $row = $this->m_registrasi_sampel->get_by_id('pemeriksaan', 'id_pemeriksaan', $search->id_pemeriksaan);
      $pengujian = getName('pengujian', 'id_pengujian', $row->id_pengujian, 'nama_pengujian');
    
      $data = array(
        'kode'                    => $kode, 
        'id_hasil_pemeriksaan'    => $id_hasil_pemeriksaan, 
        'id_sampel'               => $row->id_sampel, 
        'hasil_pemeriksaan'       => $search->hasil_pemeriksaan, 
        'pengujian'               => $pengujian, 
        'keterangan'              => $search->keterangan, 
        'status'                  => $search->status
      ); 
      $this->load->view('admin/v_modal_editHasil', $data); 
    }

    public function action_inputHasilPemeriksaan(){    
      $id_pemeriksaan = $this->input->post('id_pemeriksaan'); 
      $row = $this->m_registrasi_sampel->get_by_id('sampel', 'id_sampel', $this->input->post('id_sampel'));
      $row2 = $this->m_registrasi_sampel->get_by_id('order_detail', 'id_order_detail', $row->id_order_detail);
    
      $kode = $this->input->post('kode'); 
      $hasil_pemeriksaan =  $this->input->post('hasil_pemeriksaan');
      $data = array();
      $index = 0; 

        foreach ($hasil_pemeriksaan as $baris){
          array_push($data, array(
            'id_pemeriksaan'    => $id_pemeriksaan,
            'hasil_pemeriksaan' =>$baris, 
            'keterangan'        => '',
            'status'            => 1,
          ));
          $index++;     
        }
       $run = $this->m_registrasi_sampel->insert_batch($data, 'hasil_pemeriksaan');
          if ($run = 1){
            $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong><center> Hasil pemeriksaan berhasil dibuat </center></strong></div>');
          }else{
            $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong><center> Hasil pemeriksaan gagal dibuat </center></strong></div>');
          }
          if ($kode == 'input_hasil'){
              redirect('c_permintaan_uji/input_hasilpemeriksaan/'.$row2->no_order.'/'.'input_hasil');
          }else if ($kode == 'uji_ulang'){
             redirect('c_permintaan_uji/input_hasilpemeriksaan/'.$row2->no_order.'/'.'uji_ulang');
          }
    }

    public function action_editHasilPemeriksaan(){
      $id_hasil_pemeriksaan  = $this->input->post('id_hasil_pemeriksaan');
      $id_sampel = $this->input->post('id_sampel');
      $kode = $this->input->post('kode');

      $row = $this->m_registrasi_sampel->get_by_id('sampel','id_sampel', $id_sampel);
      $row2 = $this->m_registrasi_sampel->get_by_id('order_detail', 'id_order_detail', $row->id_order_detail);

      $data = array(
        'hasil_pemeriksaan' => trim(htmlspecialchars($this->input->post('hasil_pemeriksaan'))),
        'keterangan'        => '',
        'status'            => 1      
      ); 

      $run = $this->m_registrasi_sampel->update(array('id_hasil_pemeriksaan' => $id_hasil_pemeriksaan), $data, 'hasil_pemeriksaan');

      if ($run = 1){
        echo $this->session->set_flashdata('pesan', 
        '<script>
        swal("Success !", "Sukses Update Data !", "success"); 
       </script>');
      }else{
        echo $this->session->set_flashdata('pesan', 
        '<script>
           swal({
           title: "Failed",
           text: "Gagal Update Data !",
          type: "warning",
       });
       </script>');
      }
      if ($kode == 'input_hasil'){
      redirect('c_permintaan_uji/input_hasilpemeriksaan/'.$row2->no_order.'/'.'input_hasil');
      }else if ($kode == 'uji_ulang'){
        redirect('c_permintaan_uji/input_hasilpemeriksaan/'.$row2->no_order.'/'.'uji_ulang');
      }
  }

  public function hapus_hasilUji($id_hasil_pemeriksaan, $kode){;
    $row  = $this->m_registrasi_sampel->get_by_id('hasil_pemeriksaan', 'id_hasil_pemeriksaan', $id_hasil_pemeriksaan);
    $row2 = $this->m_registrasi_sampel->get_by_id('pemeriksaan', 'id_pemeriksaan', $row->id_pemeriksaan);
    $row3 = $this->m_registrasi_sampel->get_by_id('sampel', 'id_sampel', $row2->id_sampel);
    $row4 = $this->m_registrasi_sampel->get_by_id('order_detail', 'id_order_detail', $row3->id_order_detail);

    $run = $this->m_registrasi_sampel->delete(array('id_hasil_pemeriksaan' => $id_hasil_pemeriksaan), 'hasil_pemeriksaan');

      if ($run = 1){
        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong><center> 1 hasil pemeriksaan berhasi dihapus </center></strong></div>');
       
      }else{
        $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong><center> hasil pemeriksaan gagal dihapus </center></strong></div>');
      }
      if ($kode == 'input_hasil'){
          redirect('c_permintaan_uji/input_hasilpemeriksaan/'.$row4->no_order.'/'.'input_hasil');
      }else if ($kode == 'uji_ulang'){
         redirect('c_permintaan_uji/input_hasilpemeriksaan/'.$row4->no_order.'/'.'uji_ulang');
      }
  }

  public function ajukan_sertifikasi($no_order, $id_bidang){

      $cek    = $this->m_registrasi_sampel->all_data_perbidang2(array('order.no_order'=> $no_order), array('id_bidang !='=> $id_bidang), "status_sertifikat = 0 AND status_sampel != 3 AND status_sampel != '6'")->num_rows();
      $search = $this->m_registrasi_sampel->all_data_perbidang2(array('order.no_order' => $no_order), array('id_bidang'=> $id_bidang), "(status_sampel != '3' AND status_sampel != '6')")->result();
      if ($cek > 0){
        foreach ($search as $baris){
          $data  = array(
            'status_sertifikat' => 1,
            'status_tinjauan_anl' => 2
          );
        $run = $this->m_registrasi_sampel->update(array('id_sampel' => $baris->id_sampel), $data, 'sampel');
        } 
      }else{
        foreach ($search as $baris){
          $data  = array(
            'status_sertifikat' => 1,
            'status_tinjauan_anl' => 2
          );
        $run = $this->m_registrasi_sampel->update(array('id_sampel' => $baris->id_sampel), $data, 'sampel');
      }
      $dataku = array('status' => 8);
      $kuy = $this->m_registrasi_sampel->update(array('order.no_order'=> $no_order), $dataku, 'order');
    }
        if ($run = 1){
          echo $this->session->set_flashdata('pesan', 
          '<script>
          swal("Success !", "Sertikasi diajukan !", "success");
          </script>');
        }else{
          echo $this->session->set_flashdata('pesan', 
          '<script>
             swal({
             title: "Failed",
             text: "Sertifikasi gagal diajukan !",
            type: "warning",
         });
         </script>');
        }
    redirect('c_permintaan_uji/input_hasilpemeriksaan/'.$no_order.'/'.'input_hasil');
  }

  public function ajukan_sertifikasi_ulang($no_order, $id_bidang){
      $search =$this->m_registrasi_sampel->all_data_perbidang2(array('order.no_order'=>$no_order), array('id_bidang'=> $id_bidang), 'status_sertifikat = 3');

      foreach ($search->result() as $baris){
        $data = array(
          'status_tinjauan_anl' => 2,
          'status_sertifikat'   => 4,
          'status_tinjauan_mt'   => 5
        );
        $run = $this->m_registrasi_sampel->update(array('id_sampel'=> $baris->id_sampel), $data, 'sampel');
      }
          if ($run = 1){
            echo $this->session->set_flashdata('pesan', 
            '<script>
            swal("Success !", "Sertikasi diajukan ulang !", "success"); 
            </script>');
          }else{
            echo $this->session->set_flashdata('pesan', 
            '<script>
               swal({
               title: "Failed",
               text: "Sertifikasi gagal diajukan ulang !",
              type: "warning",
           });
           </script>');
          }
      redirect('c_permintaan_uji/input_hasilpemeriksaan/'.$no_order.'/'.'input_hasil');
  }

    public function approve_HasilPemeriksaan(){
      $hak_akses  = $this->session->userdata ('hak_akses');
      $id_auth    = $this->session->userdata('id_auth');   
      $where      = array ('id_auth'=> $id_auth);
      $cari       = $this->m_admin->cari_admin($where)->row();
      $id_bidang  = $cari->id_bidang;

      if ($hak_akses == 6){

        $data['id_bidang'] = $id_bidang; 
        $data['detail'] = $this->m_registrasi_sampel->tampil_perbidang( "(id_bidang = '$id_bidang' AND status_sampel != '3')", "(status = '8' OR status = '9' OR status = '10')")->result();
        $data['detail2'] = $this->m_registrasi_sampel->tampil_perbidang("(id_bidang = '$id_bidang' AND status_sampel != '3')", "(status = '9' AND status_tinjauan_mt = '5')")->result();
        $this->templates->utama('admin/v_permintaan_approve_hasil', $data);
      }else{
        redirect('c_auth');
      }
    }

    public function detail_HasilPemeriksaan($no_order, $kode){
      $hak_akses = $this->session->userdata('hak_akses');
      $id_auth    = $this->session->userdata('id_auth');   
      $where      = array ('id_auth'=> $id_auth);
      $cari       = $this->m_admin->cari_admin($where)->row();
      $id_bidang  = $cari->id_bidang;

        if ($hak_akses == 6){
            if ($kode == 'approve'){
              $data['no_order'] = $no_order; 
              $data['id_bidang'] = $id_bidang; 
              $data['detail']  = $this->m_registrasi_sampel->all_data_perbidang2(array('order.no_order'=> $no_order), array('id_bidang'=> $id_bidang), 'status_sertifikat  != 0')->result();
            
            }else if ($kode == 'approve_ulang'){
              $data['no_order'] = $no_order; 
              $data['id_bidang'] = $id_bidang; 
              $data['detail']  = $this->m_registrasi_sampel->all_data_perbidang2(array('order.no_order'=> $no_order), array('id_bidang'=> $id_bidang),"(status = '9' AND status_tinjauan_mt = '5')")->result();
            }
            $this->templates->utama('admin/v_detail_HasilPemeriksaan', $data);
        }else {
          redirect('auth');
        }
    }

    public function setujui($id_sampel, $kode){
      $row = $this->m_registrasi_sampel->get_by_id('sampel', 'id_sampel', $id_sampel);
      $row2 = $this->m_registrasi_sampel->get_by_id('order_detail', 'id_order_detail', $row->id_order_detail);
        if ($kode =='approve'){
          $data = array(
            'status_tinjauan_mt' => 3,
            'status_sertifikat'  => 2
          );
        }else {
          $data = array(
            'status_sertifikat'  => 2
          );
        }
    
          $run = $this->m_registrasi_sampel->update(array('id_sampel'=> $id_sampel), $data, 'sampel');
        if ($run = 1){
          $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong><center> Hasil pemeriksaan berhasil disetujui </center></strong></div>');
        }else{
        $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong><center> Hasil pemeriksaan gagal disetujui </center></strong></div>');
        }
        if ($kode == 'approve'){
          redirect('c_permintaan_uji/detail_HasilPemeriksaan/'.$row2->no_order.'/'.'approve');
        }else{
          redirect('c_permintaan_uji/detail_HasilPemeriksaan/'.$row2->no_order.'/'.'approve_ulang');
        }
    }

    public function modal_uji_ulang($kode){
      $id_sampel = $this->input->post('rowid');
      $data['kode'] = $kode; 
      $data['id_sampel'] = $id_sampel;
      $data['action'] = base_url('c_permintaan_uji/action_uji_ulang');
      $this->load->view('admin/v_modal_catatanPenolakan', $data);
    }

    public function action_uji_ulang(){
      $id_sampel = $this->input->post('id_sampel');
      $row = $this->m_registrasi_sampel->get_by_id('sampel', 'id_sampel', $id_sampel);
      $row2 = $this->m_registrasi_sampel->get_by_id('order_detail', 'id_order_detail', $row->id_order_detail); 
      $kode = $this->input->post('kode');
        if ($kode == 'approve'){
        $data = array(
          'status_sertifikat' => 3,
          'status_tinjauan_mt' => 3,
          'status_tinjauan_anl' => 3
        );
        $dataku = array(
          'id_sampel'         => $id_sampel, 
          'catatan_penolakan' => $this->input->post('catatan_penolakan'),
          'tgl_dibuat'        => date('Y-m-d')
        );
        $ruin = $this->m_registrasi_sampel->insert($dataku, 'penolakan');
        $run = $this->m_registrasi_sampel->update(array('id_sampel'=> $id_sampel), $data, 'sampel');
      }else{
        $data = array(
          'status_sertifikat' => 3,
          'status_tinjauan_anl' => 3
        );
        $dataku = array(
          'id_sampel'         => $id_sampel, 
          'catatan_penolakan' => $this->input->post('catatan_penolakan'),
          'tgl_dibuat'        => date('Y-m-d')
        );
        $ruin = $this->m_registrasi_sampel->insert($dataku, 'penolakan');
        $run = $this->m_registrasi_sampel->update(array('id_sampel'=> $id_sampel), $data, 'sampel');
      }
        if ($run = 1 AND $ruin = 1){
          $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong><center> Hasil pemeriksaan diuji ulang </center></strong></div>');
        }else{
          $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong><center> Hasil pemeriksaan gagal diuji ulang </center></strong></div>');
        }

        if ($kode == 'approve'){
         redirect('c_permintaan_uji/detail_HasilPemeriksaan/'.$row2->no_order.'/'.'approve');
        }else{
          redirect('c_permintaan_uji/detail_HasilPemeriksaan/'.$row2->no_order.'/'.'approve_ulang');
        }
    }

    public function selesai_setujuHasilPemeriksaan($no_order, $id_bidang){
        $_no_order = array('order.no_order'=> $no_order);
      
        $cek = $this->m_registrasi_sampel->all_data_perbidang2($_no_order, array('status_sertifikat' => 3), "(status_sampel != '3' AND status_sampel != '6')")->num_rows();
        $default = $this->m_registrasi_sampel->all_data_perbidang2($_no_order, array('id_bidang'=> $id_bidang), "(status_sampel != '3' AND status_sampel != '6')")->result();
       
        $cel  = $this->m_registrasi_sampel->all_data_perbidang($_no_order, "(status_sampel != '3' AND status_sampel != '6')")->result(); 
        $cell = $this->m_registrasi_sampel->all_data_perbidang($_no_order,array('status_sertifikat'=> 2))->result();

        if ($cek > 0){
              foreach ($default as $baris){
                $d = array ('status_tinjauan_mt'=> 4);
                $run = $this->m_registrasi_sampel->update(array('id_sampel'=> $baris->id_sampel), $d, 'sampel');
              }
              $data = array('status'=> 9);
              $hasil = $this->m_registrasi_sampel->update($_no_order, $data, 'order');
          }else{
        //pertama cek apakahh semua sertifikat memiliki status 2 atau tidak ?
        if (count($cel) == count($cell)){
            foreach ($default as $baris){
              $d = array('status_tinjauan_mt'=> 4);
              $run = $this->m_registrasi_sampel->update(array('id_sampel'=> $baris->id_sampel), $d, 'sampel');
            }
            foreach ($cell as $j){
              $h = array('selesai_sampel' => date('Y-m-d'));
              $fix = $this->m_registrasi_sampel->update(array('id_order_detail'=>$j->id_order_detail), $h, 'order_detail');
            }
          $data = array('status'=> 10);
          $hasil = $this->m_registrasi_sampel->update($_no_order, $data, 'order');
        }else{
          foreach ($default as $baris){
            $d = array('status_tinjauan_mt'=> 4);
            $run = $this->m_registrasi_sampel->update(array('id_sampel'=> $baris->id_sampel), $d, 'sampel');
          }
        }
      }
      if ($run  = 1){
        echo $this->session->set_flashdata('pesan', 
        '<script>
        swal("Success !", "Selesai!", "success"); 
        </script>');
      }else{
        echo $this->session->set_flashdata('pesan', 
        '<script>
           swal({
           title: "Failed",
           text: "Gagal !",
          type: "warning",
       });
       </script>');
      }
      redirect('c_permintaan_uji/detail_HasilPemeriksaan/'.$no_order.'/'.'approve');
    }


    public function approve_konfirmasiBayar(){
      $data['data']  = $this->m_registrasi_sampel->tagihan_konfirmByr()->result();
      $this->templates->utama('admin/v_approve_konfirmasiBayar', $data);
    }

    public function detail_konfirmBayar(){
      $no_tagihan = $this->input->post('rowid');
      $data['data'] = $this->m_registrasi_sampel->detail_KonfirmBayar(array('tagihan.no_tagihan'=> $no_tagihan))->result();
      $this->load->view('admin/v_detail_konfirmBayar', $data);
    }


    public function konfirmasiBayar($no_tagihan){
        
        $data = array('status_tagihan'=> 2);
        $run = $this->m_registrasi_sampel->update(array('no_tagihan'=> $no_tagihan), $data, 'tagihan');
        if ($run = 1){
          echo $this->session->set_flashdata('pesan', 
          '<script>
          swal("Success !", "Konfirmasi Pembayaran Berhasil !", "success"); 
          </script>');
        }else{
          echo $this->session->set_flashdata('pesan', 
          '<script>
             swal({
             title: "Failed",
             text: " Konfirmasi Pembayaran Gagal !",
            type: "warning",
         });
         </script>');
        }

        redirect('c_permintaan_uji/approve_konfirmasiBayar');
    }

    //function rekap registrasi sampel 
  public function rekap_registrasiSampel(){
    if ($this->input->post('submit')){
      $id_bidang = $this->input->post('bidang');
      $data['detail'] = $this->m_registrasi_sampel->rekap_regist(array('id_bidang'=> $id_bidang), array('status_sampel !=' => 0))->result();
      $data['action'] = " "; 
    }
    else{
      $data['action'] = " "; 
      $data['detail'] = $this->m_registrasi_sampel->rekap_regist(array('id_bidang'=> 'M'), array('status_sampel !=' => 0))->result();
      
    }
    $this->templates->utama('admin/v_rekap_registrasi_sampel', $data);
    }

    public function view_sertfikat(){
      $this->templates->utama('sertifikat/admin dan akan kita baas');
    }


    public function rincian_penolakan(){
      $id_sampel = $this->input->post('rowid');
      $data['data'] = $this->db->query("SELECT * FROM penolakan WHERE id_sampel ='$id_sampel'")->result();

      $this->load->view('admin/v_rincian_penolakan', $data);
    }

    public function list_sertifikat(){
      $data['data'] = $this->m_registrasi_sampel->view_sertifikat(array('status_tagihan'=>2), array('status_sampel !=' => 3))->result();
      $this->templates->utama('admin/v_list_sertifikat', $data);
    }

    public function view_manajer_opr(){
      $data['list']  = $this->m_registrasi_sampel->list_perNoOrder()->result();
      $this->templates->utama('admin/v_view_manajer_opr', $data);
    }

  }
?>


