<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_bahan_uji extends CI_Controller {
	
	public function __construct(){
		parent:: __construct();
		date_default_timezone_set('Asia/Jakarta');
        $this->load->library('templates');
        $this->load->model('m_bahan_uji');
    }

    public function index(){
        $data['bahan'] = $this->m_bahan_uji->daftar_bahan()->result_array();
        $this->templates->utama('bahan/v_daftar_bahan', $data);
    }
    
    public function tambah_bahan(){
        $data['jenis_bahan'] = $this->m_bahan_uji->jenis_bahan()->result_array();
        $this->templates->utama('bahan/v_form_bahan', $data);
    }


    public function insert_bahan(){
        $data = array(
            'nama_bahan' => $this->input->post('nama_bahan'),
            'pemasok'   => $this->input->post('pemasok'),
            'id_jenis_bahan'    => $this->input->post('jenis_bahan'),
            'exp_date'          => date('Y-m-d', strtotime($this->input->post('exp_date'))),
            'retest_date'       => date('Y-m-d', strtotime($this->input->post('retest_date'))),
            'penyimpanan'       => $this->input->post('penyimpanan')
        );

        $masukan ['res'] = $this->m_bahan_uji->insert($data, 'bahan_uji');
        
        if ($masukan){
            echo $this->session->set_flashdata('pesan', 
						'<script>
						swal("Success !", "Success Update Data !", "success"); 
						</script>');
        }else{
            echo $this->session->set_flashdata('pesan', 
            '<script>
                swal({
                title: "Failed",
                text: "Failed Update Data",
                type: "warning",
                });
            </script>');
        }
        redirect('c_bahan_uji');
    }

    public function detail_bahan(){
        $id_bahan_uji = $this->input->post('rowid');
        $data['bahan'] = $this->m_bahan_uji->detail_bahan($id_bahan_uji)->result_array();
        $data['jenis_bahan'] = $this->m_bahan_uji->jenis_bahan()->result_array();
        $this->load->view('bahan/v_detail_bahan',$data);
    }

    public function hapus_bahan($id_bahan){
		if ($this->session->userdata('hak_akses') !=  01 ){
					echo $this->session->set_flashdata('pesan', 
					'<script>
								swal({
								title: "Access Deny",
								text: " Akses Ditolak",
								type: "warning",
								});
							</script>');
							
			}else{
			$where = array('id_bahan_uji' => $id_bahan);
			$hasil  = $this->m_bahan_uji->hapus_bahan($where,'bahan_uji');
				if($hasil){
					echo $this->session->set_flashdata('pesan', 
					'<script>
					swal("Success !", "Success Delete Data !", "success"); 
					</script>');
				}else
				{
					echo $this->session->set_flashdata('pesan', 
					'<script>
								swal({
								title: "Failed",
								text: "Failed Delete Data",
								type: "warning",
								});
							</script>');
				}
			}
			redirect('c_bahan_uji');	
		
    }
    
    public function update_bahan(){
        $id_bahan = $this->input->post('id_bahan_uji');
        $tanggal_1 = $this->input->post('retest_date');
        $tanggal_2 = $this->input->post('exp_date');

        $data = array(
            'nama_bahan'    => $this->input->post('nama_bahan'),
            'pemasok'       => $this->input->post('pemasok'),
            'retest_date'    => date('Y-m-d', strtotime($tanggal_1)),
            'exp_date'      => date('Y-m-d', strtotime($tanggal_2)),
            'id_jenis_bahan'    => $this->input->post('jenis_bahan')
        );

        $where = array(
            'id_bahan_uji'  => $id_bahan
        );
        $hasil['res'] = $this->m_bahan_uji->update_bahan($where, $data, 'bahan_uji');
        if($hasil){
            echo $this->session->set_flashdata('pesan', 
            '<script>
            swal("Success !", "Success Delete Data !", "success"); 
            </script>');
        }else
        {
            echo $this->session->set_flashdata('pesan', 
            '<script>
                        swal({
                        title: "Failed",
                        text: "Failed Delete Data",
                        type: "warning",
                        });
                    </script>');
                    
        }
        redirect('c_bahan_uji');	
    }

}



?>