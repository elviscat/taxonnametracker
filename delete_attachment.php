<?php
  //Developed by elviscat (elviscat@gmail.com)
  //March 17, 2009 Tuesday:: Show the Proposed Changes OR Suggestted Name Changes Detail
  //Dec 11, 2009 Friday:: Add the review opinion checkbox
  //Dec 21, 2009 Monday:: small revised
  //Jan 12, 2010 Tuesday:: Minor Modification
  //Jan 28, 2010 Thursday:: 1.Add a logic to lock comment form when the state of this post is no longer belonging to 'under_review'.
  //2.Add prevent unll comment javascript
  //3.Add taxon name on caption
  //Mar 10, 2010 Wednesday:: Add the link of uploaded files
  //Mar 12, 2010 Friday:: Add the link of delete attachment when this posted proposed change is still under review
  //February 26, 2011 Saturday:: Code Logic modification
  session_start();
  if( (!isset($_SESSION['is_login'])) ){
	Header("location:authorizedFail.php");
	exit();
  }
  $pid = htmlspecialchars($_GET['pid'],ENT_QUOTES);
  $id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  
  include('template/dbsetup.php'); 
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);  
  
  $username = $_SESSION['username'];
  $refuid = 0;
  $sql_find_uid = "SELECT uid from user WHERE username ='".$username."'";
  $result_sql_find_uid = mysql_query($sql_find_uid);  
  if(mysql_num_rows($result_sql_find_uid) > 0){
      while ( $nb_sql_find_uid = mysql_fetch_array($result_sql_find_uid) ) {
        $refuid = $nb_sql_find_uid[0];
      }
  }
  $refuid2 = 0;//the refuid in this upload file
  $sql_find_uid2 = "SELECT refuid from upload WHERE id ='".$id."'";
  $result_sql_find_uid2 = mysql_query($sql_find_uid2);  
  if(mysql_num_rows($result_sql_find_uid2) > 0){
      while ( $nb_sql_find_uid2 = mysql_fetch_array($result_sql_find_uid2) ) {
        $refuid2 = $nb_sql_find_uid2[0];
      }
  }
  $pstate = 1;//the refuid in this upload file
  $sql_find_pstate = "SELECT pstate from post WHERE pid ='".$pid."'";
  $result_sql_find_pstate = mysql_query($sql_find_pstate);  
  if(mysql_num_rows($result_sql_find_pstate) > 0){
      while ( $nb_sql_find_pstate = mysql_fetch_array($result_sql_find_pstate) ) {
        $pstate = $nb_sql_find_pstate[0];
      }
  }  
  
  //echo "refuid is ".$refuid."<br>\n";
  //echo "refuid2 is ".$refuid2."<br>\n";
  //echo "pstate is ".$pstate."<br>\n";
  
  
  if( ($refuid == $refuid2) && ($pstate != "Pending") && ($pstate != "Closed") && (isset($id)) ){
    // if id is set then get the file with the id from database
    if($id == 0){
      echo "There is no uploaded attached file here!";
      exit;  
    }else{

      $query = "DELETE FROM upload WHERE id = '$id'";
      $result = mysql_query($query) or die('Error, query failed');
      //list($name, $type, $size, $content) = mysql_fetch_array($result);
      mysql_close($link);
      Header("location:viewpost.php?pid=".$pid);
      exit;  
    }    
  }else{
    echo "You don't have the authority to delete this file!";
    exit;
  }
?>
