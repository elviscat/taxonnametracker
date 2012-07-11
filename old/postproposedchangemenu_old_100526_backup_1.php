<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Mar 14, 2010 Sunday::New::a navigation page
  //April 08, 2010 Thursday::Modification::revision on layout editing
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
  $caption2 = "Navigation Page for Posting Proposed Nomenclatural Changes<BR>\n";
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
	</head>
  <body id="dt_example">
		<div id="container">	
			<h1><? echo $caption; ?></h1>
      <?php
        include("menu.php");
      ?>
      <h2><?php echo $caption2; ?></h2>
      <div id="demo">
        <p>You can post proposed nomenclature changes for a single taxon or for multiple taxa.</p>
        <p>We provide three methods for posting proposed changes.</p>
        <p><li><a href="name_list.php">Single Taxon via traditional name list</a>
               <br>
               (Select this option --> Select classification level --> Select the taxon --> Click the post and input your proposed nomenclatural change)
           </li>
        </p>
        <p><li><a href="taxonsearch.php">Single Taxon via search result</a>
               <br>
               (Select this option --> Search by name --> Check the appropriate taxon --> Click the post and input your proposed nomenclatural change)
           </li>
        </p>
        <p><li><a href="tree_list.php">Multiple Taxa via biological classification</a>
               <br>
               (Select this option --> Select several taoxn --> Build the taxa list by selecting appropriate taxa for comment--> Click the post and input your proposed nomenclatural change)
           </li>
        </p>        
      </div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
  </body>
</html>
