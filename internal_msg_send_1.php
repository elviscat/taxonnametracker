<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Mar 14, 2010 Sunday:: Send the internal message to registered members:: Step 1
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
  $caption2 .= "<font color=\"Red\">STEP1: Select registered users</font><BR>";
  $caption2 .= "STEP2: Edit the message<BR>";
  $caption2 .= "STEP3: Send to users<BR>";
  $title = $application_caption."::".$caption2;
  //template  
  
  
  
  
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
          $sql = "SELECT * FROM user";
          //echo "sql is ".$sql."/n<br>";
          $result_sql = mysql_query($sql);
          
          echo "<form id=\"form\" action=\"internal_msg_send_2.php\" method=\"post\">";
          echo "<table>";
          echo "<tr>";
          echo "<td>Name</td>";
          echo "<td>Address</td>";
          echo "<td>Telephone Number</td>";
          echo "<td>Fax Number</td>";
          echo "<td>Email</td>";
          echo "<td>Check it to select</td>";
          echo "</tr>";
          if(mysql_num_rows($result_sql) > 0){
            while ( $nb_sql = mysql_fetch_array($result_sql) ) {
              echo "<tr>";
              echo "<td>".$nb_sql[3]."</td>";
              echo "<td>".$nb_sql[4]."</td>";
              echo "<td>".$nb_sql[5]."</td>";
              echo "<td>".$nb_sql[6]."</td>";
              echo "<td>".$nb_sql[7]."</td>";
              echo "<td><input id=\"users[]\" name=\"users[]\" type=\"checkbox\" value=\"".$nb_sql[0]."\"/></td>";
              echo "</tr>";
              //echo $nb[0]."<br>\n";
              //$select_box_text .= "<option value=\"".$nb_sql[0]."\">".$nb_sql[3]."</option>\n";
            }
          }
          echo "<tr>";
          echo "<td colspan=6><input name=\"submit_button\" id=\"submit_button\" type=\"submit\" value=\"Go to Step 2\" /></td>";
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