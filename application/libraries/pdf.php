<?php 

require_once dirname(__FILE__).'/fpdf/fpdf.php';
class Pdf Extends FPDF{
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
  // setting jenis font yang akan digunakan
$this->SetFont('Arial','B',6);
$this->Cell(20,0,'Srengseng Sawah, Jagakarsa Jakarta 12640',0,0,'L');
$this->Cell(235);
$this->Cell(20,0,'Srengseng Sawah, Jagakarsa Jakarta 12640',0,1,'R');

$this->SetFont('Arial','B',6);
$this->Cell(20,7,'Telp (021) 64747499',0,0,'L');
$this->Cell(235); 
$this->Cell(20,7,'Telp (021) 64747499',0,1,'R');

$this->SetLineWidth(0.5);
$this->Line(10,17,285,17);
$this->Ln(6);

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