<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 13, 2009 Friday:: Change with state
  // ./ current directory
  // ../ up level directory
  header("Cache-control: private");
  session_cache_limiter("none");
  session_start();
  
  include('template/dbsetup.php');

  $lv = htmlspecialchars($_GET['lv'],ENT_QUOTES);
  //echo "lv is :: ".$lv."<br>\n";
  $id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "id is :: ".$id."<br>\n";
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  $state = "1";
  $sql = "SELECT state FROM slist WHERE sid=".$id;
  //echo $sql;
  $result = mysql_query($sql);
  if(mysql_num_rows($result) > 0){
    while ( $nb = mysql_fetch_array($result) ) {
      if($nb[0] == $state){
      	$state = 0;
      }
    }
  }




  $update_sql =  "UPDATE slist SET ";
  $update_sql .= " state = '".$state."'";
  $update_sql .= " WHERE sid ='".$id."'";
  //echo "update_sql is ".$update_sql."<br>\n";
  $result = mysql_query($update_sql);
  


  
  mysql_close($link); 
  Header("Location:slist_table.php")

?>