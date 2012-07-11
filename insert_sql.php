<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Oct 22, 2009 Thursday:: sql insert execute
  // ./ current directory
  // ../ up level directory
  session_start();
  include('template/dbsetup.php');

  
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);

  $sql = "SELECT distinct(sgenus) FROM slist";
  //echo "sql is ".$sql."/n<br>";
  $result_sql = mysql_query($sql);
  
  $counter0 = 0;
  $counter1 = 0;
  if(mysql_num_rows($result_sql) > 0){
    while ( $nb = mysql_fetch_array($result_sql) ) {
      $counter0++;
      //echo $nb[0]."<br>\n";
      $sql2 = "SELECT distinct(sfamily) FROM slist WHERE sgenus = '".$nb[0]."'";
      //echo $counter0." :: sql2 is ".$sql2."\n<br>";
      $result_sql2 = mysql_query($sql2);
      if(mysql_num_rows($result_sql2) > 0){
        while ( $nb2 = mysql_fetch_array($result_sql2) ) {
          $counter1++;
          //echo $counter1." is ".$nb2[0]."<br>\n";
          $sql3 = "SELECT distinct(fid) FROM flist WHERE ffamily = '".$nb2[0]."'";
          $result_sql3 = mysql_query($sql3);
          if(mysql_num_rows($result_sql3) > 0){
            while ( $nb3 = mysql_fetch_array($result_sql3) ) {
              $insert_sql = "INSERT INTO glist (gid,gfamily,ggenus,refid )";
              $insert_sql .= " VALUES ('$counter1','$nb2[0]','$nb[0]','$nb3[0]')";
              //echo "insert_sql is ".$insert_sql."\n<br>";
              $result=mysql_query($insert_sql);
            }
          }
        }
      }
    }
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
        <?php ?>
      </div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
  </body>
</html>


