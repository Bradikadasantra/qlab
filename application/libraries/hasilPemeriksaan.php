<?php 

require_once dirname(__FILE__).'/fpdf/fpdf.php';
class HasilPemeriksaan Extends FPDF{
  protected $B = 0;
  protected $I = 0;
  protected $U = 0;
  protected $HREF = '';
  
  function WriteHTML($html)
  {
      // HTML parser
      $html = str_replace("\n",' ',$html);
      $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
      foreach($a as $i=>$e)
      {
          if($i%2==0)
          {
              // Text
              if($this->HREF)
                  $this->PutLink($this->HREF,$e);
              else
                  $this->Write(5,$e);
          }
          else
          {
              // Tag
              if($e[0]=='/')
                  $this->CloseTag(strtoupper(substr($e,1)));
              else
              {
                  // Extract attributes
                  $a2 = explode(' ',$e);
                  $tag = strtoupper(array_shift($a2));
                  $attr = array();
                  foreach($a2 as $v)
                  {
                      if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                          $attr[strtoupper($a3[1])] = $a3[2];
                  }
                  $this->OpenTag($tag,$attr);
              }
          }
      }
  }
  
  function OpenTag($tag, $attr)
  {
      // Opening tag
      if($tag=='B' || $tag=='I' || $tag=='U')
          $this->SetStyle($tag,true);
      if($tag=='A')
          $this->HREF = $attr['HREF'];
      if($tag=='BR')
          $this->Ln(5);
  }
  
  function CloseTag($tag)
  {
      // Closing tag
      if($tag=='B' || $tag=='I' || $tag=='U')
          $this->SetStyle($tag,false);
      if($tag=='A')
          $this->HREF = '';
  }
  
  function SetStyle($tag, $enable)
  {
      // Modify style and select corresponding font
      $this->$tag += ($enable ? 1 : -1);
      $style = '';
      foreach(array('B', 'I', 'U') as $s)
      {
          if($this->$s>0)
              $style .= $s;
      }
      $this->SetFont('',$style);
  }
  
  function PutLink($URL, $txt)
  {
      // Put a hyperlink
      $this->SetTextColor(0,0,255);
      $this->SetStyle('U',true);
      $this->Write(5,$txt,$URL);
      $this->SetStyle('U',false);
      $this->SetTextColor(0);
  }
Function header(){
    $this->SetFont('Arial','B',11);
    // mencetak string
    $this->Image(base_url().'assets/img/qlab.jpg',20,10,23,15);
    $this->Cell(200,4,'Laboratorium Jasa Pengujian dan Penelitian (QLab)',0,1,'C');
    $this->Cell(200,7,'Fakultas Farmasi Universitas Pancasila',0,1,'C');
    $this->SetFont('Arial','I',8);
    $this->Cell(200,4,'Srengseng Sawah, Jagakarsa, Jakarta 12640 Telp 021-7864727/28 ext : 549, Fax 021-78894282',0,1,'C');
    $this->Cell(200,4,'Website: http://www.qlab.ffup.org, E-mail:qlab.ffup@univpancasila.ac.id, qlab.ffup@gmail.com',0,1,'C');
    $this->SetLineWidth(0.4);
    $this->Line(200,35,10,35);
    $this->Ln(10);

}
function Footer()
  { 
      // mengatur posisi 1,5 cm ke bawah
      $this->SetY(-15);
      // arial italic 8
      $this->SetFont('Arial','I',9);
      $this->Cell(20,15,('Printed '.date('d-m-Y')),0,0,'L');
      // penomoran halaman
      $this->Cell(230);
      $this->SetFont('Arial','I',9);
      $this->Cell(20,15,'Page '.$this->PageNo(),0,0,'C');

  }

}