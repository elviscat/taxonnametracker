<?php 
  /**
  *  
  *  *
  */
  session_start();
  $title = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes";
  $caption = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes";

  include('template/dbsetup.php');
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  
  $sql_1 = "SELECT * FROM post ORDER BY pcredate DESC Limit 5";
  $sql_2 = "SELECT * FROM user ORDER BY regtime DESC Limit 5";
  $sql_3 = "SELECT COUNT(*) FROM slist";
  $sql_4 = "SELECT COUNT(*) FROM user";
  //echo $sql_1;
  //echo $sql_2;
  //echo $sql_3;
  //echo $sql_4;
  
  $table_1 = "";
  $result_1 = mysql_query($sql_1);
  if(mysql_num_rows($result_1) > 0){
    while ( $nb_1 = mysql_fetch_array($result_1) ) {
      $sci_name = "";
      $user_name = "";
      $sub_sql = "SELECT * FROM slist WHERE sid = '".$nb_1[5]."'";
      $sub_result = mysql_query($sub_sql);
      if(mysql_num_rows($sub_result) > 0){
        while ( $sub_nb = mysql_fetch_array($sub_result) ) {
          $sci_name =  $sub_nb[2]." ".$sub_nb[3];
        }
      }else{
        $sci_name =  "No scientific name!";
      }
      $sub_sql = "SELECT * FROM user WHERE uid = '".$nb_1[4]."'";
      $sub_result = mysql_query($sub_sql);
      if(mysql_num_rows($sub_result) > 0){
        while ( $sub_nb = mysql_fetch_array($sub_result) ) {
          $user_name =  $sub_nb[3];
        }
      }else{
        $user_name =  "No user name!";
      }      
      $table_1 .= "<a href=\"viewpost.php?pid=".$nb_1[0]."\"><i>".$sci_name."</i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$nb_1[3]."&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"viewuser.php?uid=".$nb_1[4]."\">".$user_name."</a><br>";
    }
  }else{
      $table_1 = "There is no data right now!";
  }

  $table_2 = "";
  $result_2 = mysql_query($sql_2);
  if(mysql_num_rows($result_2) > 0){
    while ( $nb_2 = mysql_fetch_array($result_2) ) {
      $table_2 .= "<a href=\"viewuser.php?uid=".$nb_2[0]."\">".$nb_2[3]."</a><br>";
    }
  }else{
      $table_2 = "There is no data right now!";
  }
  
  $numOfspecies = "";
  $result_3 = mysql_query($sql_3);
  if(mysql_num_rows($result_3) > 0){
    while ( $nb_3 = mysql_fetch_array($result_3) ) {
      $numOfspecies = $nb_3[0];
    }  
  }else{
      $numOfspecies = 0;
  }
  
  $numOfuser = "";
  $result_4 = mysql_query($sql_4);
  if(mysql_num_rows($result_4) > 0){
    while ( $nb_4 = mysql_fetch_array($result_4) ) {
      $numOfuser = $nb_4[0];
    }  
  }else{
      $numOfuser = 0;
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
		<script type="text/javascript" language="javascript" src="media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').dataTable( {
					//"aaSorting": [[ 4, "desc" ]]
					//"aaSorting": [[0,'asc'], [1,'desc'], [2,'desc']]
					//"aaSorting": [[0,'asc'], [1,'asc']]
					"aaSorting": [[1,'asc'], [2,'asc'], [3,'asc']]
				} );
			} );
		</script>
    <script type="text/javascript">
    <!--
      function confirmation(a) {
	    var answer = confirm("Delete it?")
	      if (answer){
		      alert("Ok, We will delete this post entry.")
		      window.location = "deletePost.php?pid=" + a;
	      }else{
		      alert("You are clever, not delete me!")
		      return false;
	      }
      }
    //-->
    </script>
	</head>
	<!--<body>-->
  <body id="dt_example">
  <!--<div id="dt_example">-->
		<div id="container">	
			<h1><? echo $caption; ?></h1>
      <?php
        include("menu.php");
      ?>
      <h2><?php echo $title; ?></h2>
      <div id="demo">
        <h2>Background</h2>
        Taxonomic nomemclature process is an important process in biology research.
        This application provide a platform for north America freshwater fish taxonists to collaborate with each other for the name list and relative information. 
        Dr. Richard Mayden is maintaining almost four hundred species name list of north America freshwater fish right now.
        We are welcome all of you participate with us on this great work.
        You can <a href="signup.php">register/sign up</a> an account in a easy way then start your
        contribution.       
			  <h2>Recent posted proposed change</h2>
        <?php echo $table_1; ?>
        <h2>Recent registered user</h2>
        <?php echo $table_2; ?>
        <h2># of species we current maintain: <?php echo "<B>".$numOfspecies."</B>"; ?></h2>
        <h2># of registered user this application have: <?php echo "<B>".$numOfuser."</B>"; ?></h2>
      </div>
			<div class="spacer">

      </div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
	<!--</div>-->
  </body>
</html>

