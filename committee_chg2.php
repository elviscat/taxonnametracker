<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 17, 2009 Tuesday:: Change or edit content of names committee
  //June 09, 2010 Tuesday:: modifiy to UTF-8 character setting
  // ./ current directory
  // ../ up level directory

  /*
  header("Cache-control: private");
  session_cache_limiter("none");
  session_start();
  */

  
  
  /* No need anymore
  //Access control by role  
  $role = $_SESSION['role'];
  if( $role != "admin"){
    Header("location:authorizedFail.php");
    exit();
  }
  //Access control by role  
  No need anymore
  */    
  
  
  // Old setting before June 09, 2010 Tuesday
  
  include('template/dbsetup.php');
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  
  mysql_query("SET NAMES 'utf8'");
  mysql_query("SET CHARACTER_SET_CLIENT=utf8");
  mysql_query("SET CHARACTER_SET_RESULTS=utf8");
  //Old setting before June 09, 2010 Tuesday
  
  //include('template0.php');


  $committee_id = htmlspecialchars($_POST['committee_id'],ENT_QUOTES);
  //echo "committee_id is <b>".$committee_id."</b><br>\n";
  $committee_name = htmlspecialchars($_POST['committee_name'],ENT_QUOTES);
  //echo "committee_name is :: ".$committee_name."<br>\n";
  $committee_note = htmlspecialchars($_POST['committee_note'],ENT_QUOTES);
  //echo "committee_note  is :: ".$committee_note ."<br>\n";  
  
  $update_sql =  "UPDATE committee_grp SET ";
  $update_sql .= " committee_name = '".$committee_name."', misc_note ='".$committee_note."' ";
  $update_sql .= " WHERE id ='".$committee_id."'";
  //echo "update_sql is ".$update_sql."<br>\n";
  $result = mysql_query($update_sql);
  

  
  mysql_close($link); 
  Header("Location:committee_manage.php")

?>