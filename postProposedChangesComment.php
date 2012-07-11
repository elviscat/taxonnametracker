<?php
  //Developed by elviscat (elviscat@gmail.com)
  //March 17, 2009 Tuesday:: Post the Proposed Changes OR Suggestted Name Changes Comment Interface
  //Dec 09, 2009 Wednesday:: Modification:: Add the comment_type column in TABLE::comment and change insert sql statement
  //February 26, 2011 Saturday:: Code Logic modification
  // ./ current directory
  // ../ up level directory

  session_start();
  if( (!isset($_SESSION['is_login'])) ){
	  Header("location:authorizedFail.php");
	  exit();
  }
  if( (!isset($_SESSION['uid'])) ){
	  Header("location:authorizedFail.php");
	  exit();
  }  


  $crefpid = htmlspecialchars($_POST['crefpid'],ENT_QUOTES);
  //$ctitle = htmlspecialchars($_POST['ctitle'],ENT_QUOTES);
  $ctitle = $_POST['ctitle'];
  $ccontent = htmlspecialchars($_POST['ccontent'],ENT_QUOTES);
  $cname = htmlspecialchars($_POST['cname'],ENT_QUOTES);
  $cwebsite = htmlspecialchars($_POST['cwebsite'],ENT_QUOTES);
  $cmsn = htmlspecialchars($_POST['cmsn'],ENT_QUOTES);  
  //$comment_type = htmlspecialchars($_POST['comment_type'],ENT_QUOTES);
  
  //$review = htmlspecialchars($_POST['review'],ENT_QUOTES);
  
  $comment_type = htmlspecialchars($_POST['comment_type'],ENT_QUOTES);
  
  $comment_type_2 = htmlspecialchars($_POST['comment_type_2'],ENT_QUOTES);
  
  /*
  $comment_type = "";
  if( $review != "" ){
    if( $review == "1" ){
      $comment_type = "1";
    }elseif( $review == "2" ){
      $comment_type = "2";
    }
    //
    //echo "review is :: ".$review."<br>\n";
  }else{
    $comment_type = "0";
  }
  */
  //echo "comment_type is :: ".$comment_type."<br>\n";
  
  
  include('template/dbsetup.php');
  require('inc/config.inc.php');
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

  $maxCid = 0;
  $maxCidSql = "SELECT MAX(cid) FROM comment";
  $result = mysql_query ($maxCidSql) or die ("Invalid query");
  if( mysql_num_rows( $result) > 0 ){
	  while ( $nb = mysql_fetch_array($result)) {
		  $maxCid = $nb[0] + 1;
		  //echo "maxPid is ".$maxPid."<br>";
	  }
  }else{
    $maxPid = 1;
  }
  //echo "maxLid is ".$maxPid."<br>";
  $date = date("Y-m-d H:i:s");//"2008-08-28 11:03:21"
  
  //echo $_SESSION['uid'];
  
  if($comment_type_2 == "Review Opinion"){
    //echo "comment_type_2 is Review Opinion";
    $comment_type = $comment_type_2;
  }
  
  //sql statement
  //$sql = "INSERT INTO comment (`cid`, `ctitle`, `ccontent`, `ccredate`, `crefpid`, `cname`, `cwebsite`, `cmsn`) VALUES ";
  //$sql .= "('".$maxCid."', '".$ctitle."', '".$ccontent."', '".$date."', '".$crefpid."', '".$cname."', '".$cwebsite."', '".$cmsn."')";
  $sql = "INSERT INTO comment (`cid`, `ctitle`, `ccontent`, `ccredate`, `crefuid`, `crefpid`, `comment_type`, `cname`, `cwebsite`, `cmsn`) VALUES ";
  $sql .= "('".$maxCid."', '".$ctitle."', '".$ccontent."', '".$date."', '".$_SESSION['uid']."', '".$crefpid."', '".$comment_type."', '".$cname."', '".$cwebsite."', '".$cmsn."')";


  //echo "Variable sql is :: ".$sql."<br>\n";
  mysql_query($sql);

  
  //Marked on February 26, 2011 Saturday
  //Marked on February 26, 2011 Saturday
  /*
  //new function added on April 19, 2010 Monday:: send email to each committee members
  
  $sql_user_id_of_committee_members =  "SELECT user_id FROM committee_member WHERE ref_pid";
  
  //echo "sql_user_id_of_committee_members is :: ".$sql_user_id_of_committee_members."<br>\n";
  $result_user_id_of_committee_members = mysql_query($sql_user_id_of_committee_members);
  if( mysql_num_rows($result_user_id_of_committee_members) > 0 ){
    while ( $nb_user_id_of_committee_members = mysql_fetch_array($result_user_id_of_committee_members) ) {
      //
      //echo "user is ::".$nb_user_id_of_committee_members[0]."<br>\n";
      $sql_user_email =  "SELECT eml FROM user WHERE uid='".$nb_user_id_of_committee_members[0]."'";
      $result_user_email = mysql_query($sql_user_email);
      if( mysql_num_rows($result_user_email) > 0 ){
        while ( $nb__user_email = mysql_fetch_array($result_user_email) ) {
          //echo "user email  is ::".$nb__user_email[0]."<br>\n";
          $from_email = $admin_email;
          $from_email_name = $from_email_name;  
          $eml_address = $nb__user_email[0];
                       
          $eml_subject = "Review Opinions on: ".$ctitle;
          $eml_content = "Hi committee members,<br><b>Review Opinions is in the following:</b><br>".$ccontent."<br>Taxon Tracker";
          if(email("slumailrelay.slu.edu", $from_email, $from_email_name, $eml_address, $eml_subject, $eml_content)){
            //echo "Your message has sent to these users!";
          }else{
            //echo "Fail to send this message!";
          }             
        }
      }   
    }
  }
  */
  //Marked on February 26, 2011 Saturday
  //Marked on February 26, 2011 Saturday

  
  
  mysql_close($link);  
  Header("location:viewpost.php?pid=".$crefpid."");

  exit();
  			
?>