<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //April 05, 2010 Monday:: add template code section
  // ./ current directory
  // ../ up level directory
  //template
  session_start();
  include('template/dbsetup.php'); 
  require('inc/config.inc.php');
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);  

  //Configuration of POST and GET Variables
  //$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "Variable id is :: ".$id."<br>\n";
  $actkey = htmlspecialchars($_GET['key'],ENT_QUOTES);
  //echo "actkey is ".$actkey."\n<BR>";  
  //Configuration of POST and GET Variables
  $caption = $application_caption;
  $caption2 = "Email Validation Process";
  $title = $application_caption."::".$caption2;
  //template


  $actkey_check = "No";
  $actkey_check_sql = "SELECT username FROM user WHERE actkey ='".$actkey."'";
  //echo "actkey_check_sql is ".$actkey_check_sql."/n<br>";
  $result_actkey_check = mysql_query($actkey_check_sql);
  if(mysql_num_rows($result_actkey_check) > 0){
    //while ( $nb_actkey_check = mysql_fetch_array($result_actkey_check) ) {
      $actkey_check = "Yes";
    //}
  }
  
  $output_message = "";
  if( $actkey_check == "Yes" ){
    $output_message = "Your account has been activated!<br><br>You need to go to <a href=\"login.php\">login</a> page to log into Taxon Tracker application!<br>";
    $update_sql = "UPDATE user SET actlevel = '1'";
    mysql_query($update_sql);
  }else{
    $output_message = "Your activation key is not correct. Please make sure your activation key again or <a href=\"requestkey.php\">request the key again</a>.";
  }

  mysql_close($link); 

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
    <meta name="Description" content="Saint Louis University, tissue, species information" />
    <meta name="Keywords" content="Saint Louis University, tissue, information" />
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <!--<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />-->
    <meta name="Distribution" content="Global" />
    <meta name="Author" content="Richard Mayden - cypriniformes@gmail.com, Elvis Hsin-Hui Wu - hwu5@slu.edu" />
    <meta name="Robots" content="index,follow" />
    <link rel="stylesheet" href="edit.css" type="text/css" /><!--Does this file edit.css should be keep?-->	
    <!--<link rel="shortcut icon" type="image/ico" href="http://www.sprymedia.co.uk/media/images/favicon.ico" />-->
		<title><? echo $title; ?></title>
		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
	</head>
  <body id="dt_example">
		<div id="container">	
			<h1><? echo $caption; ?></h1>
      <?php
        include("menu.php");
      ?>
      <h2><?php echo $caption2; ?></h2>
      <div id="demo">
        <?php
          echo $output_message;
        ?>
      </div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
  </body>
</html>









