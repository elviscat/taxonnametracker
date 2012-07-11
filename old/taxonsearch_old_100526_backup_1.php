<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Mar 19, 2010 Friday::New::Taxon search interface
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
  $caption2 = "<u>Taxon Search</u><BR>\n";
  $title = $application_caption."::".$caption2;
  //template  
  
  $array_data = "";
  $sql_taxon_search = "SELECT ffamily From flist";
  //echo "sql_taxon_search is ".$sql_taxon_search."<br>\n";
  $result_taxon_search = mysql_query($sql_taxon_search);
  if(mysql_num_rows($result_taxon_search) > 0 ){
    while ( $nb_taxon_search = mysql_fetch_array($result_taxon_search) ) {
      //echo $nb_taxon_search[0];
      $array_data .= " ".$nb_taxon_search[0];
    }
  }
  $sql_taxon_search = "SELECT ggenus From glist";
  //echo "sql_taxon_search is ".$sql_taxon_search."<br>\n";
  $result_taxon_search = mysql_query($sql_taxon_search);
  if(mysql_num_rows($result_taxon_search) > 0 ){
    while ( $nb_taxon_search = mysql_fetch_array($result_taxon_search) ) {
      //echo $nb_taxon_search[0];
      $array_data .= " ".$nb_taxon_search[0];
    }
  }
  
  $sql_taxon_search = "SELECT sspecies From slist";
  //echo "sql_taxon_search is ".$sql_taxon_search."<br>\n";
  $result_taxon_search = mysql_query($sql_taxon_search);
  if(mysql_num_rows($result_taxon_search) > 0 ){
    while ( $nb_taxon_search = mysql_fetch_array($result_taxon_search) ) {
      //echo $nb_taxon_search[0];
      $array_data .= " ".$nb_taxon_search[0];
    }
  }

  //echo $array_data;

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

    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <link rel="stylesheet" href="http://dev.jquery.com/view/trunk/plugins/autocomplete/jquery.autocomplete.css" type="text/css" />
    <!--<script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/autocomplete/lib/jquery.bgiframe.min.js"></script>-->
    <!--<script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/autocomplete/lib/jquery.dimensions.js"></script>-->
    <script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/autocomplete/jquery.autocomplete.js"></script>
	<!--
	<link rel="stylesheet" type="text/css" href="autocomplete/jquery.autocomplete.css" />
	<script type="text/javascript" src="autocomplete/jquery.autocomplete.js"></script>
	<script type="text/javascript" src="autocomplete/jquery.autocomplete.js"></script>
	-->
    <script>
      $(document).ready(function(){
        //alert('Hello!');
        <?php echo "var data = \"".$array_data."\".split(\" \");"; ?>
        //var data = "Core Selectors Attributes Traversing Manipulation CSS Events Effects Ajax Utilities".split(" ");
        //var data = ['å°åŒ—å¸‚ä¸­æ­£å€','å°åŒ—å¸‚å¤§åŒå€','å°åŒ—å¸‚ä¸­å±±å€','å°åŒ—å¸‚æ¾å±±å€','å°åŒ—å¸‚å¤§å®‰å€'];
        //$("#search_word").autocomplete(data);
        $("#search_word").autocomplete(data, {matchContains: true});
        //$("#search_word").autocomplete('autocomplete.php');
      });
    </script>

	</head>
  <body id="dt_example">
		<div id="container">	
			<h1><? echo $caption; ?></h1>
      <?php
        include("menu.php");
      ?>
      <h2><?php echo $caption2; ?></h2>
      <div id="demo">
        <p>Search for taxon of interest (Family, Genus, or Species)</p>
        <form name ="taxonsearch" method ="post" action ="taxonsearch2.php">
          <input type = "radio" name = "search_level" value = "family" >Family
          <input type = "radio" name = "search_level" value = "genus" checked>Genus
          <input type = "radio" name = "search_level" value = "species" >Species
          <input type = "text" id = "search_word" name = "search_word" value = "Campostoma" />(type in Campostoma)
          <br>
          <input type="submit" name="submit" value ="Search">
        </form>        
      </div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
  </body>
</html>
