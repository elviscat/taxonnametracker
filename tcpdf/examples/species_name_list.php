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

  echo "This is a sample that transfering the current maintained name list information into public viewed book.<br>Elvis<br>";
  echo "<br><a href=\"elvis_to_pdf.php\">Generate a PDF file!</a>";
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
  echo $html;
  //$html = "123";  
  echo "<br><a href=\"elvis_to_pdf.php\">Generate a PDF file!</a>";          
?>
