<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //November 30, 2009 Monday:: Show the comment detail page
  // ./ current directory
  // ../ up level directory
  //!?!?
  session_start();
  //!?!?
  
  $caption = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes";
  $title = "Comment Detail";
  
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

  //$cid = $_GET['cid'];
  $cid = htmlspecialchars($_GET['cid'],ENT_QUOTES);
  //echo "Variable cid is :: ".$cid."<br>\n";

  $sql = "SELECT * FROM comment WHERE cid= '".$cid."'";  
  //echo "<BR>sql is ".$sql;
  
  $result = mysql_query($sql);
  
  //$sid = "";
  
  if( mysql_num_rows($result) > 0 ){  
    while ( $nb2 = mysql_fetch_array($result) ) {
		  //$sid = $nb2[5];
		  
      //$table .= "<p>Create Time:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$nb2[3]."</p>";//create time
      //$table .= "<p>Title:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>".$nb2[1]."</b></p>";//title
      //$replyTitle = $nb2[1];
      //$table .= "<p>Content:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$nb2[2]."</p>";// full content
      
      $table .= "<font color=\"gray\">".$nb2[3]."</font><BR>";//Time
      $table .= "<B><font size=\"3\" color=\"black\">".$nb2[1]."</font></B><BR>";//Title
      
      $post_author_name = "";
      /*
      if( $nb2[4] == 0){
        $post_author_name = "admin";
      }else{
        $sql2 = "SELECT name FROM user WHERE uid ='".$nb2[4]."'";
        $result2 = mysql_query($sql2);
        //echo "sql2 is ".$sql2;
        $post_author_name = mysql_result($result2, 0);
      }
      */

      $sql2 = "SELECT name FROM user WHERE uid ='".$nb2[4]."'";
      $result2 = mysql_query($sql2);
      //echo "sql2 is ".$sql2;
      $post_author_name = mysql_result($result2, 0);   
      //$table .= "<B><font color=\"blue\">".$post_author_name."</font></b><BR>";//Posted by Author
      $table .= "<font color=\"black\">".$nb2[2]."</font><BR>";//Post Content      
      $table .= "<a href=\"viewpost.php?pid=".$nb2[5]."\">View this post</a>";//Comment Counter
      //$table .= "<B>".$name."</B> at <B>".$nb2[3]."</B> Post | Comment (<B>".$commentCount."</B>)<BR><BR>";
      //$table .= "<hr NOSHADE>";      
	  }

	}else{
	  //echo $sql;
	  $table .= "<p>Currently, there are no comment right now.</p>"; //no records here
	  Header("location:authorizedFail.php");
  }
  
  mysql_close($link);
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
	    /*
      var answer = confirm("Delete it?")
	      if (answer){
		      alert("Ok, We will delete this post entry.")
		      window.location = "deletePost.php?pid=" + a;
	      }else{
		      alert("You are clever, not delete me!")
		      return false;
	      }
	    */  
      }
    //-->
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
	</body>
</html>


