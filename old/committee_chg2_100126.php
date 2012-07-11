<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 17, 2009 Tuesday:: Change or edit content of names committee
  // ./ current directory
  // ../ up level directory
  header("Cache-control: private");
  session_cache_limiter("none");
  session_start();
  
  include('template/dbsetup.php');

  $id = htmlspecialchars($_POST['id'],ENT_QUOTES);
  //echo "id is :: ".$id."<br>\n";
  $committee_name = htmlspecialchars($_POST['committee_name'],ENT_QUOTES);
  //echo "committee_name is :: ".$committee_name."<br>\n";
  $committee_note = htmlspecialchars($_POST['committee_note'],ENT_QUOTES);
  //echo "committee_note  is :: ".$committee_note ."<br>\n";


  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);

  $update_sql =  "UPDATE committee_grp SET ";
  $update_sql .= " committee_name = '".$committee_name."', misc_note ='".$committee_note."' ";
  $update_sql .= " WHERE id ='".$id."'";
  //echo "update_sql is ".$update_sql."<br>\n";
  $result = mysql_query($update_sql);
  

  
  mysql_close($link); 
  Header("Location:committee_manage.php")

?>