<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Mar 14, 2010 Sunday:: Send the internal message to registered members:: Step 3
  // ./ current directory
  // ../ up level directory
  
  //template
  session_start();
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

  //Configuration of POST and GET Variables

  //Configuration of POST and GET Variables
    
  $caption = $application_caption;
  $caption2 = "Send the internal message to registered members<BR>";
  $caption2 .= "STEP1: Select registered users<BR>";
  $caption2 .= "STEP2: Edit the message<BR>";
  $caption2 .= "<font color=\"Red\">STEP3: Send to users</font><BR>";
  $title = $application_caption."::".$caption2;
  //template  

  $users = $_POST['users'];
  $msg_title = $_POST['msg_title'];
  $msg_content = htmlspecialchars($_POST['msg_content'],ENT_QUOTES);
  
  //echo "users is ::".$users."<br>\n";
  //echo "msg_title is ::".$msg_title."<br>\n";
  //echo "msg_content is ::".$msg_content."<br>\n";
  
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
          $array_users = explode(";", $users);
          
          $from_email = $admin_email;
          $from_email_name = $from_email_name;  
          $eml_address = "";
          
          for($i = 0; $i < sizeof($array_users);$i++){
            $send_to = $array_users[$i];
            
            $sql = "SELECT * FROM user WHERE uid='".$send_to."'";
            //echo "sql is ".$sql."/n<br>";
            $result_sql = mysql_query($sql);
            if(mysql_num_rows($result_sql) > 0){
              while ( $nb_sql = mysql_fetch_array($result_sql) ) {
                $eml_address = $nb_sql[7];
              echo "</tr>";
              }
            }
                        
            $eml_subject = $msg_title;
            $eml_content = $msg_content;
            if(email("slumailrelay.slu.edu", $from_email, $from_email_name, $eml_address, $eml_subject, $eml_content)){
              echo "Your message has sent to these users!";
            }else{
              echo "Fail to send this message!";
            }             
          }
        ?>      
      </div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
  </body>
</html>