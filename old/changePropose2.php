<?php
  //Developed by elviscat (elviscat@gmail.com)
  //March 15, 2009 Sunday:: new propose change post::insert into the table::post
  // ./ current directory
  // ../ up level directory
  session_start();
  if( (!isset($_SESSION['is_login'])) ){
	  Header("location:authorizedFail.php");
	  exit();
  }

  $prefuid = htmlspecialchars($_POST['prefuid'],ENT_QUOTES);
  $ptitle = htmlspecialchars($_POST['ptitle'],ENT_QUOTES);
  $pcontent = htmlspecialchars($_POST['pcontent'],ENT_QUOTES);
  $ptag = htmlspecialchars($_POST['ptag'],ENT_QUOTES);
  $pcategory = htmlspecialchars($_POST['pcategory'],ENT_QUOTES);
  $prefsid = htmlspecialchars($_POST['prefsid'],ENT_QUOTES);  
  //echo $prefuid."<BR>";
  //echo $title."<BR>";
  //echo $content."<BR>";
  
  include('template/dbsetup.php');
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  //sql statement
  //echo "Hello Elvis";
  
  $maxPid = 0;
  $maxPidSql = "SELECT MAX(pid) FROM post";
  $result = mysql_query ($maxPidSql) or die ("Invalid query");
  if( mysql_num_rows( $result) > 0 ){
	  while ( $nb2 = mysql_fetch_array($result)) {
		  $maxPid = $nb2[0] + 1;
		  //echo "maxPid is ".$maxPid."<br>";
	  }
  }else{
    $maxPid = 1;
  }
  //echo "maxLid is ".$maxPid."<br>";
  $date = date("Y-m-d H:i:s");//"2008-08-28 11:03:21"

  //select database
  mysql_select_db($dbname);
  //sql statement
  $sql = "INSERT INTO post (`pid`, `ptitle`, `pcontent`, `pcredate`, `prefuid`, `prefsid`, `pcount`, `ptag`, `pcategory`) VALUES ";
  $sql .= "('".$maxPid."', '".$ptitle."', '".$pcontent."', '".$date."', '".$prefuid."', '".$prefsid."', '0', '".$ptag."', '".$pcategory."')";
  //echo $sql;
  mysql_query($sql);
  mysql_close($link);
  
  Header("location:postProposedChangesManage.php");
  exit();
  			
	
?>
