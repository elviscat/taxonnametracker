<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //July 02, 2010 Friday:: NEW:: Names Committee Member Cast Vote
  //February 26, 2011 Saturday:: Code Logic modification
  // ./ current directory
  // ../ up level directory
  session_start();
 
  $uid = htmlspecialchars($_POST['uid'],ENT_QUOTES);
  //echo "Variable user_id is <b>".$user_id."</b><br>\n";
  $pid = htmlspecialchars($_POST['pid'],ENT_QUOTES);//New on February 26, 2011 Saturday
  //echo "Variable pid is <b>".$pid."</b><br>\n";//New on February 26, 2011 Saturday
  //$ref_c_id = htmlspecialchars($_POST['ref_c_id'],ENT_QUOTES);//Marked on February 26, 2011 Saturday
  //echo "Variable ref_c_id is <b>".$ref_c_id."</b><br>\n";//Marked on February 26, 2011 Saturday
  //$is_voted = htmlspecialchars($_POST['is_voted'],ENT_QUOTES);//Marked on February 26, 2011 Saturday
  //echo "Variable is_voted is <b>".$is_voted."</b><br>\n";//Marked on February 26, 2011 Saturday
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
  $sql_vote_update = "UPDATE committee_member SET vote_opinion ='".$vote_opinion."', vote_desc ='".$vote_desc."' WHERE ref_uid ='".$uid."' AND ref_pid = '".$pid."'";
  //echo "Variable sql_vote_update is <b>".$sql_vote_update."</b><br>\n";
  mysql_query($sql_vote_update);
  

  //$pid = get_pid_from_committee_id($ref_c_id);
  //July 02, 2010 Friday:: New Actions

  
  mysql_close($link); 
  Header("Location:viewpost.php?pid=".$pid."")

?>