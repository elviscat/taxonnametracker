<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Mar 14, 2010 Sunday:: Send the internal message to registered members:: Step 2
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

  //Configuration of POST and GET Variables
    
  $caption = $application_caption;
  $caption2 = "Send the internal message to registered members<BR>";
  $caption2 .= "STEP1: Select registered users<BR>";
  $caption2 .= "<font color=\"Red\">STEP2: Edit the message</font><BR>";
  $caption2 .= "STEP3: Send to users<BR>";
  $title = $application_caption."::".$caption2;
  //template  

  $users = $_POST['users'];
  if($users == ""){
    echo "You need to select at least one user to send message!";
    exit;
  }else{
    // Note that $users will be an array.
    $selected_users = "";
    foreach ($users as $s) {
      $selected_users .= $s.";";
      //echo "$s<br />";
    }
    $selected_users = substr($selected_users, 0, -1);
    //echo $selected_users;    
  }

  
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
		<script type="text/javascript" src="jquery/jquery-1.3.2.js"></script>
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

          
          echo "<form id=\"form\" action=\"internal_msg_send_3.php\" method=\"post\">";
          echo "<table>";
          echo "<tr>";
          echo "<td>Message title</td>";
          echo "<td><input id=\"msg_title\" name=\"msg_title\" type=\"text\" value=\"Title\" /></td>";
          echo "</tr>";
          echo "<tr>";
          echo "<td>Message Content</td>";
          echo "<td><textarea id=\"msg_ccontent\" name=\"msg_content\" rows=\"10\" cols=\"50\"></textarea></td>";
          echo "</tr>";
          echo "<tr>";
          echo "<td colspan=2><input id=\"users\" name=\"users\" type=\"hidden\" value=\"".$selected_users."\" /><input name=\"submit_button\" id=\"submit_button\" type=\"submit\" value=\"Go to Step 3\" /></td>";
          echo "</tr>";
          echo "</table>";
          echo "</form>";
          //echo $select_box_text;
        ?>      
      </div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
  </body>
</html>