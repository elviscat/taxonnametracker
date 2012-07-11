<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //July 02, 2010 Friday:: NEW:: Names Committee Member Cast Vote
  // ./ current directory
  // ../ up level directory
  session_start();
 
  $user_id = htmlspecialchars($_POST['user_id'],ENT_QUOTES);
  //echo "Variable user_id is <b>".$user_id."</b><br>\n";
  $ref_c_id = htmlspecialchars($_POST['ref_c_id'],ENT_QUOTES);
  //echo "Variable ref_c_id is <b>".$ref_c_id."</b><br>\n";
  $is_voted = htmlspecialchars($_POST['is_voted'],ENT_QUOTES);
  //echo "Variable is_voted is <b>".$is_voted."</b><br>\n";
  $vote_opinion = htmlspecialchars($_POST['vote_opinion'],ENT_QUOTES);
  //echo "Variable vote_opinion is <b>".$vote_opinion."</b><br>\n";
  $vote_desc = htmlspecialchars($_POST['vote_desc'],ENT_QUOTES);
  //echo "Variable vote_desc is <b>".$vote_desc."</b><br>\n";

  
  /*
  header("Cache-control: private");
  session_cache_limiter("none");
  */
  
  include('inc/config.inc.php');
  include('template/dbsetup.php');
  require('phpmailer/class.phpmailer.php');
  
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
  
  //include('template0.php');



  //July 02, 2010 Friday:: New Actions
  //1.Change pstate from 1 to 2
  $sql_vote_update = "UPDATE committee_member SET vote_opinion ='".$vote_opinion."', is_voted ='1', vote_desc ='".$vote_desc."' WHERE user_id ='".$user_id."' AND ref_c_id = '".$ref_c_id."'";
  //echo "Variable sql_vote_update is <b>".$sql_vote_update."</b><br>\n";
  mysql_query($sql_vote_update);
  

  $pid = get_pid_from_committee_id($ref_c_id);
  //July 02, 2010 Friday:: New Actions

  
  mysql_close($link); 
  Header("Location:viewpost.php?pid=".$pid."")

?>