<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once APPPATH.'PHPWORD/autoload.php';
require_once dirname(__dir__).'../../PHPWORD/autoload.php';

class Home extends CI_Controller {   
    public function __construct(){    
         parent::__construct(); 
         $this->load->library('word');

    }

    public function index(){
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        /* Note: any element you append to a document must reside inside of a Section. */
        
        // Adding an empty Section to the document...
        $section = $phpWord->addSection();
        // Adding Text element to the Section having font styled by default...
        $section->addText(
            '"Learn from yesterday, live for today, hope for tomorrow. '
                . 'The important thing is not to stop questioning." '
                . '(Albert Einstein)'
        );
        
        /*
         * Note: it's possible to customize font style of the Text element you add in three ways:
         * - inline;
         * - using named font style (new font style object will be implicitly created);
         * - using explicitly created font style object.
         */
        
        // Adding Text element with font customized inline...
        $section->addText(
            '"Great achievement is usually born of great sacrifice, '
                . 'and is never the result of selfishness." '
                . '(Napoleon Hill)',
            array('name' => 'Tahoma', 'size' => 10)
        );
        
        // Adding Text element with font customized using named font style...
        $fontStyleName = 'oneUserDefinedStyle';
        $phpWord->addFontStyle(
            $fontStyleName,
            array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true)
        );
        $section->addText(
            '"The greatest accomplishment is not in never falling, '
                . 'but in rising again after you fall." '
                . '(Vince Lombardi)',
            $fontStyleName
        );
        
        // Adding Text element with font customized using explicitly created font style object...
        $fontStyle = new \PhpOffice\PhpWord\Style\Font();
        $fontStyle->setBold(true);
        $fontStyle->setName('Tahoma');
        $fontStyle->setSize(13);
        $myTextElement = $section->addText('"Believe you can and you\'re halfway there." (Theodor Roosevelt)');
        $myTextElement->setFontStyle($fontStyle);
        
        // Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('tampung/helloWorld.docx');
        
        // Saving the document as ODF file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
        $objWriter->save('tampung/helloWorl.odt');
        
        // Saving the document as HTML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        $objWriter->save('tampung/helloWord.html');
        
        /* Note: we skip RTF, because it's not XML-based and requires a different example. */
        /* Note: we skip PDF, because "HTML-to-PDF" approach is used to create PDF documents. */
       
    }

    public function ok(){
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $testWord = $phpWord->loadTemplate('Sample_23_TemplateBlock.docx');

        $testWord->cloneBlock('CLONEME', 3);
        // Everything between ${tag} and ${/tag}, will be deleted/erased.
        $testWord->deleteBlock('DELETEME');
        echo date('H:i:s'), ' Saving the result document...', EOL;
        $testWord->saveAs('ubah_Sample_23_TemplateBlock.docx');
            }

    public function on(){
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->createSection();
        $section->addText('Hello World!');
        $file = 'HelloWorld.docx';
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $xmlWriter->save("php://output");
            }


    public function pdf(){
    
        $objReader= \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
        $contents=$objReader->load("helloWorld.docx");

        $rendername= \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;

        $renderLibrary="TCPDF";
        $renderLibraryPath=''.$renderLibrary;
        if(!\PhpOffice\PhpWord\Settings::setPdfRenderer($rendername,$renderLibrary)){
            die("Provide Render Library And Path");
        }
        $renderLibraryPath=''.$renderLibrary;
        $objWriter= \PhpOffice\PhpWord\IOFactory::createWriter($contents,'PDF');
        $objWriter->save("test.pdf");
    }

    public function pdf_15(){
        $phpword= $this->word;
        $contents=$objReader->load("6_BAB_III_ANALISIS_SISTEM_SEDANG_BERJALAN_fara2.docx");

        $rendername= $phpword::PDF_RENDERER_TCPDF;

        $renderLibrary="TCPDF";
        $renderLibraryPath=''.$renderLibrary;
        if(!$phpword::setPdfRenderer($rendername,$renderLibrary)){
            die("Provide Render Library And Path");
        }
        $renderLibraryPath=''.$renderLibrary;
        $objWriter= $phpword::createWriter($contents,'PDF');
        $objWriter->save("test.pdf");
    }
}