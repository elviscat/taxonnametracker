<?php


  session_start();
  include('../../template/dbsetup.php'); 
  require('../../inc/config.inc.php');
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);  
  //set the character set as utf-8
  mysql_query("SET NAMES 'utf8'");
  mysql_query("SET CHARACTER_SET_CLIENT=utf8");
  mysql_query("SET CHARACTER_SET_RESULTS=utf8");



  $html = "";  

  $sql_slist_table = "SELECT * FROM slist";   
  //echo "sql_slist_table is ".$sql_slist_table."/n<br>";
  $result_sql_slist_table = mysql_query($sql_slist_table);
  $html .= "<table border=\"1\">\n";
  $html .= "<tr>";
  $html .= "<td>Family</td>";
  $html .= "<td>Genus</td>";
  $html .= "<td>Species</td>";
  $html .= "<td>Author</td>";
  $html .= "<td>Locality</td>";
  $html .= "<td>Common Name1</td>";
  $html .= "<td>Common Name2</td>";
  $html .= "<td>Common Name3</td>";   
  $html .= "</tr>";
  
  if(mysql_num_rows($result_sql_slist_table) > 0){              
    while ( $nb = mysql_fetch_array($result_sql_slist_table) ) {
      $html .= "<tr>";
      $html .=  "<td>".$nb[1]."</td>";
      $html .= "<td>".$nb[2]."</td>";
      $html .= "<td>".$nb[3]."</td>";
      $html .= "<td>".$nb[4]."</td>";
      $html .= "<td>".$nb[5]."</td>";
      $html .= "<td>".$nb[6]."</td>";
      $html .= "<td>".$nb[7]."</td>";
      $html .= "<td>".$nb[8]."</td>";
      $html .= "</tr>\n";
    }
  }
  $html .= "</table>\n";
  //echo $html;
  //$html = "123";  
            




//============================================================+
// File name   : example_006.php
// Begin       : 2008-03-04
// Last Update : 2010-05-20
//
// Description : Example 006 for TCPDF class
//               WriteHTML and RTL support
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com s.r.l.
//               Via Della Pace, 11
//               09044 Quartucciu (CA)
//               ITALY
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @copyright 2004-2009 Nicola Asuni - Tecnick.com S.r.l (www.tecnick.com) Via Della Pace, 11 - 09044 - Quartucciu (CA) - ITALY - www.tecnick.com - info@tecnick.com
 * @link http://tcpdf.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 * @since 2008-03-04
 */

require_once('../config/lang/eng.php');
require_once('../tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information

//$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor('Nicola Asuni');
//$pdf->SetTitle('TCPDF Example 006');
//$pdf->SetSubject('TCPDF Tutorial');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data

//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)



// create some HTML content
//$html = "123";

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();


// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('taxon_tracker_year_book.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
?>
