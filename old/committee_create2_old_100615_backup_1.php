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

  //
  $maxid = 0;
  $max_id_sql = "SELECT (Max(id)+1) FROM committee_grp";
  $result_max_id = mysql_query($max_id_sql);	  
  list($maxid) = mysql_fetch_row($result_max_id);
  if($maxid == 0){
    $maxid = 1;
  }          

  //
  
  $regdate = date('Y-m-d');
  $regtime = date('h:i:s');
  //date: 0000-00-00
  //time: 00:00:00 
  
  $insert_sql = "INSERT INTO committee_grp (`id`, `committee_name`, `misc_note`) ";
  $insert_sql .= "VALUES ('$maxid','$committee_name','$committee_note')";
  //echo "insert_sql is ".$insert_sql."<br>\n";
  $result=mysql_query($insert_sql);

  
  mysql_close($link); 
  Header("Location:committee_manage.php")

?>