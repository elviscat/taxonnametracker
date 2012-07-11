<?php  
  //Developed by elviscat (elviscat@gmail.com)
  //April 05, 2010 Monday:: auto complete taxon array
  // ./ current directory
  // ../ up level directory
 
  //template
  session_start();
  include('template/dbsetup.php'); 
  require('inc/config.inc.php');
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  
  //Configuration of POST and GET Variables
  //$search_level = htmlspecialchars($_POST['search_level'],ENT_QUOTES);
  //Configuration of POST and GET Variables  
  
  //$caption = $application_caption;
  //$caption2 = "<u>Taxon Search</u><BR>\n";
  //$title = $application_caption."::".$caption2;
  //template  
  
  $q = $_GET["q"];  
  if (!$q) return;  
  
  /*
  $data = array('Cyp', 'Cyp2');
  
  //$array_data = "";
  
  $sql_taxon_search = "SELECT ffamily From flist";
  //echo "sql_taxon_search is ".$sql_taxon_search."<br>\n";
  $result_taxon_search = mysql_query($sql_taxon_search);
  if(mysql_num_rows($result_taxon_search) > 0 ){
    while ( $nb_taxon_search = mysql_fetch_array($result_taxon_search) ) {
      array_push($data, $nb_taxon_search[0]);
      //$array_data += 
    }
  }
  */
  
  //echo $data;
  $data = array('Cyp1','Cyp2','台北市中山區','台北市松山區','台北市大安區');
  
  foreach ($data as $value) {
    if (strpos($value, $q) !== false) {
    echo $value."\n";
    }
  }

?>