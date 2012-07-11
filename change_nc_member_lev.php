<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //June 01, 2010 Tuesday:: Change the level of Names Committee Member
  // ./ current directory
  // ../ up level directory

  session_start();
 
  $role = $_SESSION['role'];
  if( $role != "admin"){
    Header("location:authorizedFail.php");
    exit();
  }
  
   
  include('template/dbsetup.php');
  require('inc/config.inc.php');



  $cid = htmlspecialchars($_GET['cid'],ENT_QUOTES);
  //echo "Variable cid is :: ".$cid."<br>\n";
  $uid = htmlspecialchars($_GET['uid'],ENT_QUOTES);
  //echo "Variable uid is :: ".$uid."<br>\n";
  $chg_lev = htmlspecialchars($_GET['chg_lev'],ENT_QUOTES);
  //echo "Variable chg_lev is :: ".$chg_lev."<br>\n";  

  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  
  $update_sql ="";
  if( $chg_lev == "to_chair" ){
    $update_sql = "UPDATE committee_member SET rank_level ='chair' WHERE user_id ='".$uid."' AND ref_c_id = '".$cid."'";
  }else{
    $update_sql = "UPDATE committee_member SET rank_level ='member' WHERE user_id ='".$uid."' AND ref_c_id = '".$cid."'";
  }

  //echo "update_sql is ".$update_sql."<br>\n";
  $result = mysql_query($update_sql);
  
  $pid = get_pid_from_committee_id($cid);


  mysql_close($link);
  //Header("Location:slist_table.php")
  //Header("Location:view_completelist_comm_mem.php?cid=".$cid."");
  Header("Location:view_completelist_comm_mem.php?pid=".$pid."");

?>