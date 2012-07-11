<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //March 17, 2009 Tuesday:: Show the Proposed Changes OR Suggestted Name Changes Detail
  //Dec 11, 2009 Friday:: Add the review opinion checkbox
  // ./ current directory
  // ../ up level directory
  //!?!?
  session_start();
  //!?!?
  
  $caption = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes";
  $title = "Review Opinion Detail";
  
  $table = "";
  $replyTitle = "";
  include('template/dbsetup.php');

  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);

  $cid = $_GET['cid'];

  $sql = "SELECT * FROM comment WHERE cid= '".$cid."'";  
  //echo "Variable sql is ".$sql."<br>\n";
  $result = mysql_query($sql);
  $table .= "<h2><p>Review Opinion</p></h2>";
  
  if( mysql_num_rows($result) > 0 ){  
    while ( $nb = mysql_fetch_array($result) ) {
      
      $user_name = "";
      $sql_select_user_name = "SELECT * FROM user WHERE uid='".$nb[4]."'";
      $result_sql_select_user_name = mysql_query($sql_select_user_name);
      if( mysql_num_rows($result_sql_select_user_name) > 0 ){
        while ( $nb2 = mysql_fetch_array($result_sql_select_user_name) ) {
          //
          $user_name = $nb2[3];
        }
      }
      $table .= "<font color=\"blue\">".$user_name."</font> mentioned that ...<BR>";//Posted by Author
      
      $table .= "<b><font color=\"black\">".$nb[1]."</font></b><br>";//Title
      $table .= "<font color=\"black\">".$nb[2]."</font><BR>";//Post Content
      $table .= "<font color=\"gray\">".$nb[3]."</font><BR><BR>";//Time
      
      /*
      $table .= "<p><b>".$nb2[1]."</b></p>";//ctitle
      $table .= "<p>".$nb2[2]."</p>";// full ccontent
      //$table .= "<p><a href=\detail.php?pid=".$nb2[0]."\">More</a><BR><BR>";
      $table .= "<B>".$nb2[5]."</B> at <B>".$nb2[3]."</B> Comment<BR><BR>";
      //$table .= "<hr NOSHADE>";
      */
	  }
	}else{
	  //echo $sql;
	  $table .= "<p>Currently, there are no comments at this post.</p>"; //no records here
  }  
  //$table .= "<BR><BR><a href=\"showProposedChanges.php?sid=".$sid."\">Back to Proposed Changes OR Suggestted Name Changes List</a>";
  //$table .= "<BR><BR><a href=\"index.php\">Back to homepage</a>";
  
  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<!--<link rel="shortcut icon" type="image/ico" href="http://www.sprymedia.co.uk/media/images/favicon.ico" />-->
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" href="edit.css" type="text/css" />
    <style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
		<script type="text/javascript" language="javascript" src="media/js/jquery.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function(){
        //alert('review_opinion :: '+ $('#review_opinion').val());			  
      });
		</script>
    <script type="text/javascript">

    </script>
	</head>
	<body id="dt_example">
		<div id="container">	
			<h1><?php echo $caption; ?></h1>
      <?php
        include("menu.php");
      ?>
      <h2><?php echo $title; ?></h2>
      <div id="demo">
        <!--Table is here!!-->
        <?php 
          echo $table;
        ?>
        <!--Table is here!!-->
      </div>  
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>      
<?php
  mysql_close($link);
?>
	</body>
</html>


