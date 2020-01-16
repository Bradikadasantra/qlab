<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_laporan extends MY_Controller {

    public function __construct(){
        parent:: __construct();
        $this->cekLogin();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('templates');
        $this->load->model('m_login');
        $this->load->model('m_admin');
        $this->load->model('m_pelanggan');
        $this->load->model('m_dokumen');
        $this->load->model('m_registrasi_sampel');
        $this->load->library('pdf');
    }


    public function  keuangan(){
        $tgl1 = date('Y-m-d', strtotime($this->input->post('tgl1')));
        $tgl2 = date('Y-m-d', strtotime($this->input->post('tgl2')));
        $tahun = substr($this->input->post('tgl1'),6, 4);
    
        $dataWhere = "";

        if ($this->input->post('submit')){
            $dataWhere .= "WHERE tgl_order BETWEEN '$tgl1' AND '$tgl2' AND status_tagihan = '2'";
            $query = "SELECT * FROM tagihan JOIN `order` ON `order`.no_order = tagihan.no_order ".$dataWhere;
            $order['data']=$this->db->query($query)->result();
            $order['tahun'] = $tahun;
        }else { 
            $query = "SELECT * FROM tagihan JOIN `order` ON `order`.no_order = tagihan.no_order WHERE status_tagihan = '2'";
            $order['data']=$this->db->query($query)->result();
            $order['tahun'] = date('Y');
        }
        $this->templates->utama('admin/v_laporan_keuangan', $order);
    }


    public function print_rekapRegistrasiSampel($param, $param2){
        $pdf = new pdf('L','mm','A4');
        $pdf->SetMargins(10,10,10);
        $pdf->AliasNbPages();
        // membuat halaman baru
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(35,10,'No sampel',1,0,'C');
        $pdf->Cell(50,10,'Pengirim Sampel',1,0,'C');
        $pdf->Cell(30,10,'Kode Batch',1,0,'C');
        $pdf->Cell(40,10,'Jenis Pemeriksaan',1,0,'C');
        $pdf->Cell(20,10,'Pemerian',1,0,'C');
        $pdf->Cell(40,5,'Tanggal',1,0,'C');
        $pdf->Cell(25,10,'No Invoice',1,0,'C');
        $pdf->Cell(20,10,'Status Bayar',1,0,'C');
        $pdf->Cell(15,10,'Ket',1,0,'C');
        $pdf->Cell(0,5,'',0,1,'C');

        //line row
        $pdf->Cell(175,5,'',0,0,'C');
        $pdf->Cell(20,5,'Terima',1,0,'C');
        $pdf->Cell(20,5,'Selesai',1,0,'C');
        $pdf->Cell(0,5,'',0,1,'C');

        $pdf->SetFont('Arial','',10);
        $data = $this->m_registrasi_sampel->laporan_rekap_regist("(sampel.id_bidang = '$param')", array('status_sampel !=' => 0))->result();


        //multicell method
        foreach ($data as $baris){
            $row = $this->m_registrasi_sampel->get_by_id('pelanggan', 'id_pelanggan', $baris->id_pelanggan);
            $pengirim = $row->nama;   
            $row2 = $this->m_registrasi_sampel->get_by_id('pemerian', 'id_pemerian', $baris->pemerian);
            $pemerian = $row2->pemerian;   
            
            
            $cellWidth = 40; //wrapped cell
            $cellHeight = 7; // normal one line cell height

            //check wether the text is overflowing
            if ($pdf->GetStringWidth($baris->nama_pengujian) < $cellWidth){
                // if not, then do nothing; 
                $line = 1; 
            }else{
                // if it is, then calculate the heigh needed for wrapped cell
                // by splitting the tet to fit the cell width
                //then count homem many lines are needed for the text to fit the cell
                $textLength = strlen($baris->nama_pengujian);
                $errMargin = 10; 
                $starChar = 0; 
                $maxChar = 0; 
                $textArray = array();
                $tmpString = '';
                
                while ($starChar < $textLength){
                    while ($pdf->GetStringWidth($tmpString) < ($cellWidth-$errMargin) && ($starChar+$maxChar) < $textLength ){
                            $maxChar++;
                            $tmpString= substr($baris->nama_pengujian, $starChar, $maxChar);
                        }
                    $starChar = $starChar+$maxChar;
                    array_push($textArray, $tmpString);
                    $maxChar = 0; 
                    $tmpString = '';
                }
                $line = count($textArray);
            }

            $pdf->Cell(35,($line * $cellHeight), setNoSampel($baris->no_sampel, $baris->tgl_order), 1, 0, 'C');
            $pdf->Cell(50,($line * $cellHeight), $pengirim, 1, 0, 'C');
            $pdf->Cell(30,($line * $cellHeight), $baris->kode_batch, 1, 0, 'C');
            $xPos = $pdf->GetX();
            $yPos = $pdf->GetY();
            $pdf->MultiCell($cellWidth, $cellHeight, $baris->nama_pengujian,1, 'C');
            $pdf->SetXY($xPos + $cellWidth, $yPos);
            $pdf->Cell(20,($line * $cellHeight),$pemerian, 1, 0, 'C');
            $pdf->Cell(20,($line * $cellHeight),  date('d/m/Y', strtotime($baris->terima_sampel)), 1, 0, 'C');
            $pdf->Cell(20,($line * $cellHeight),  date('d/m/Y', strtotime($baris->selesai_sampel)), 1, 0, 'C');
            $pdf->Cell(25,($line * $cellHeight),$baris->no_tagihan,1,0,'C');

            $tagihan = '';
            if ($baris->status_sampel != '3'){
                $tagihan =  StatusTagihan($baris->status_tagihan);
            }else{
                $tagihan = "-";
            }
            $pdf->Cell(20,($line * $cellHeight),$tagihan,1,0,'C');

            $ket = '';
            if ($baris->status_sampel == 6){
                $ket = "cancel";
            }else if ($baris->status_sampel == 3){
                $ket = 'ditolak';
            }
            else {
                $ket = "-";
            }
            $pdf->Cell(15,($line * $cellHeight),$ket,1,1,'C');
        }
        $pdf->Output(date('ymd').'_Rekap Sampel_'.$param2,'I');
    }

    
    public function print_dokumen($param,$param2){

        if ($param2 == 'all_doc'){
            $row = $this->m_dokumen->get_by_id('dokumen_induk', 'id_dokumen_induk', $param);
            $kueri = $this->db->query("SELECT * FROM upload_dokumen WHERE id_dokumen_induk = '$param'")->result();
            $jenis = $row->dokumen;
        }else{
            $row = $this->m_dokumen->get_by_id('jenis_dokumen', 'id_jenis_dokumen', $param);
            $kueri = $this->db->query("SELECT * FROM upload_dokumen WHERE id_jenis_dokumen = '$param'")->result();
            $jenis = $row->nama_dokumen;
        }

        $pdf = new pdf('L','mm','A4');
        $pdf->SetMargins(10,10,10);
        $pdf->AliasNbPages();
        // membuat halaman baru
        $pdf->AddPage();
        $pdf->Cell(10,1,'',0,1); 
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(276,7,' Daftar Induk Dokumen ',0,1,'C');
        $pdf->Cell(0,7,'',0,1);

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(0,2,$jenis,0,1,'L');
        $pdf->Cell(0,2,'',0,1);

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(10,10,'No',1,0,'C');
        $pdf->Cell(80,10,'Nama Dokumen',1,0,'C');
        $pdf->Cell(40,10,'Nomor Dokumen',1,0,'C');
        $pdf->Cell(30,10,'Lokasi',1,0,'C');
        $pdf->Cell(115,5,'Tanggal',1,0,'C');
        $pdf->Cell(0,5,'',0,1,'C');

        //second line row
        $pdf->Cell(160,5,'',0,0,'C');
        $pdf->Cell(23,5,'Revisi 0',1,0,'C');
        $pdf->Cell(23,5,'Revisi 1',1,0,'C');
        $pdf->Cell(23,5,'Revisi 2',1,0,'C');
        $pdf->Cell(23,5,'Revisi 3',1,0,'C');
        $pdf->Cell(23,5,'Revisi 4',1,0,'C');


        $pdf->Cell(0,5,'',0,1,'C');
        $pdf->SetFont('Arial','',10);

        $no = 1;         
        foreach ($kueri as $baris):
            $pdf->Cell(10,7,$no++,1,0,'C');
            $pdf->Cell(80,7,$baris->nama_dok,1,0,'C');
            $pdf->Cell(40,7,$baris->no_dokumen,1,0,'C');
            $pdf->Cell(30,7,$baris->lokasi,1,0,'C');
            
            // apakah ada dokumen yang telah direvisi ?
           // $kue = $this->db->query("SELECT * FROM revisi WHERE no_dokumen = '$baris->no_dokumen'")->result_array();
           // $result = array();
            //foreach ($kue as $row => $v){
              //      array_push($result, $v);
           // }

            for($i=0; $i<5; $i++){
                //if (!empty($result[$i]['no_dokumen'])){
                  //  $pdf->Cell(23,7,date('d-m-Y', strtotime($result[$i]['tgl_revisi'])),1,0,'C');
                //}else{
             $pdf->Cell(23,7,'-',1,0,'C');
                //}
            }
            $pdf->Cell(0,7,'',0,1,'C');
            endforeach; 
        $pdf->Output((date('dmY')."_".$jenis),'I');
    } 

}