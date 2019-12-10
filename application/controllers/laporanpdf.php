<?php 

class Laporanpdf extends CI_Controller{
 
	function __construct(){
		parent::__construct();
		$this->load->library('pdf');
	}
	
public function index(){
  // intance object dan memberikan pengaturan halaman PDF
$pdf = new pdf('P','mm','A4');
$pdf->SetMargins(10,10,10);
$pdf->AliasNbPages();
// membuat halaman baru
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 16);
$pdf->Cell(188,2, 'INVOICE',0,1,'C');

$pdf->Cell(10,9,'',0,1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(5,5,'Harap Dikirim :',0,0,'L');
$pdf->Cell(20);
$pdf->Cell(5,5,'Bradika Dasantra R',0,1,'L');

$pdf->Output();
}
    }
  
?>
	