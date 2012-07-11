<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 17, 2009 Tuesday:: Change or edit content of names committee
  // ./ current directory
  // ../ up level directory
  header("Cache-control: private");
  session_cache_limiter("none");
  session_start();
  
  include('template/dbsetup.php');
  
  //Restrict admin to access to this page
  // 
  
  $caption = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes";
  $caption2 = "Edit Names Committee Information";  
  $title = $caption."::".$caption2;
  $content = "Edit Names Committee Information.";
  

  $id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "ID is :: ".$id."<br>\n";

  
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  
  $sql = "SELECT * FROM committee_grp WHERE id ='".$id."'";
  //echo "sql is ".$sql."/n<br>";
  $result = mysql_query($sql);
  if(mysql_num_rows($result) > 0){
    while ( $nb = mysql_fetch_array($result) ) {
      $committee_name = $nb[1];
      $committee_note = $nb[2];
    }
  }

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
    <meta name="Description" content="Saint Louis University, tissue, species information" />
    <meta name="Keywords" content="Saint Louis University, tissue, information" />
    <!--<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
		<script type="text/javascript" src="jquery/jquery.doubleSelect.js"></script>
		<script type="text/JavaScript">
        $(document).ready(function(){
		  //alert("Hello Elvis!");
          $("#selectRows").click(function(){
		    //alert("Select Rows is :: " + );
          });
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
        <form id="updateForm" action="committee_chg2.php" method="post">
          <input name="id" type="hidden" value="<?php echo $id; ?>"/>
          <table>
            <tr>
              <td colspan=2><p>Please change it!</p></td>
            </tr>
            <tr>
              <td ><label>Names Committee Name</label></td>
              <td ><input name="committee_name" type="text" value="<?php echo $committee_name; ?>"/></td>
            </tr>
            <tr>
              <td ><label>Notes</label></td>
              <td ><input name="committee_note" type="text" value="<?php echo $committee_note; ?>" /><br></td>
            </tr>
            <tr>
              <td colspan=2><button  type="submit" onclick="confirmation(); return false;">Update</button></td>
            </tr>
          </table>
        </form>
      </div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
  </body>
</html>