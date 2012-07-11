<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Jan 26, 2010 Tuesday:: Layout and Logic modification
  // ./ current directory
  // ../ up level directory
  
  //header("Cache-control: private");
  //session_cache_limiter("none");
  
  session_start();
  
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
  $id = htmlspecialchars($_POST['id'],ENT_QUOTES);
  //echo "ID is :: ".$id."<br>\n";
  $chg_note = htmlspecialchars($_POST['chg_note'],ENT_QUOTES);
  //echo "chg_note is :: ".$chg_note."<br>\n";
  $chg_reason = htmlspecialchars($_POST['chg_reason'],ENT_QUOTES);
  //echo "chg_reason  is :: ".$chg_reason ."<br>\n";  
  //Configuration of POST and GET Variables

    
  //$caption = $application_caption;
  //$caption2 = "Editor Interface on Change Log TABLE";
  //$title = $application_caption."::".$caption2;
  
  //template
  
  $reflv = "";
  $refid = "";
  $sql = "SELECT * FROM namelist_chglog WHERE id ='".$id."'";
  //echo "sql is ".$sql."/n<br>";
  $result_sql = mysql_query($sql);
  if(mysql_num_rows($result_sql) > 0){
    while ( $nb_sql = mysql_fetch_array($result_sql) ) {
      $reflv = $nb_sql[1];
      $refid = $nb_sql[2];
    }
  }
  
  $update_sql =  "UPDATE namelist_chglog SET ";
  $update_sql .= " chg_note = '".$chg_note."', rea ='".$chg_reason."' ";
  $update_sql .= " WHERE id ='".$id."'";
  //echo "update_sql is ".$update_sql."<br>\n";
  $result = mysql_query($update_sql);
  
  mysql_close($link); 
  Header("Location:viewclog.php?lv=".$reflv."&id=".$refid);

?>