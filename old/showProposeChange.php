<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //March 15, 2009 Friday:: show proposed change
  // ./ current directory
  // ../ up level directory
  //!?!?
  session_start();
  //!?!?
  $title = "Show Proposed Change";
  
  $table = "";
  include('template/dbsetup.php');

  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);

  $prefsid = $_GET['sid'];

  
  $preSql = "SELECT COUNT(*) FROM post";
  if( isset($_GET['sid']) ){
    $preSql .= " WHERE prefsid= '".$prefsid."'";
  }
  //echo $preSql;
  $preResult = mysql_query($preSql);
  $numOfCount = 0;
  while ( $nb = mysql_fetch_array($preResult) ) {
    //echo "nb[0] is ".$nb[0]."<BR>";
    $numOfCount = $nb[0];
    //echo "numOfCount is "."<BR>";
  }
  
  $sql = "SELECT * FROM post";  
  if( isset($_GET['sid']) ){
  
  //echo "<BR>numOfCount is ".$numOfCount;
  $sql .= " WHERE prefsid= '".$prefsid."'";
  //echo "<BR>sql is ".$sql;
    
  }
  
  $result = mysql_query($sql);
  if( $numOfCount > 0 ){  
    while ( $nb2 = mysql_fetch_array($result) ) {
		  $table .= "<p>".$nb2[3];//create time
      $table .= "<p><h2><b>".$nb2[1]."</b></h2></p>";//title
      
      $shortContent = substr($nb2[2], 0, 30);
      
      $table .= "<p>".$shortContent."</p>";// short content
      $table .= "<p><a href=\"detail.php?pid=".$nb2[0]."\">More</a></p>";
      
      $name = "";
      if( $nb2[4] == 0){
        $name = "admin";
      }else{
        $sql2 = "SELECT name FROM user WHERE uid ='".$nb2[4]."'";
        $result2 = mysql_query($sql2);
        //echo "sql2 is ".$sql2;
        $name = mysql_result($result2, 0);
      }
      
      $sql3 = "SELECT COUNT(*) FROM comment WHERE crefpid= '".$nb2[0]."'";
      //echo "sql3 is ".$sql3;
      $result3 = mysql_query($sql3);
      $commentCount = mysql_result($result3, 0);
      
      
      
      $table .= "<B>".$name."</B> at <B>".$nb2[3]."</B> Post | Comment (<B>".$commentCount."</B>)<BR><BR>";
      
      
      
      $table .= "<hr NOSHADE>";
	  }

	}else{
	  //echo $sql;
	  $table .= "<p>Currently, there are no entries under this blog.</p>"; //no records here
  }
  
  $table .= "<BR><BR><a href=\"../index.php\">Back to homepage</a>";
  
  mysql_close($link);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
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
	<body id="dt_example">
		<div id="container">	
			<h1><? echo $title; ?></h1>
			<?php
        //if( !isset($_SESSION['loginName']) || ($_SESSION['loginName'] != "admin") ){
        //  echo "<h2><a href=\"login.php\">Login</a></h2>";
        //}else{
        //  echo "<h2><a href=\"logout.php\">Logout</a></h2>";
        //}
			?>
      <div id="demo">
<!--Table is here!!-->
<?php 
  echo $table;
?>
<!--Table is here!!-->
			</div>
			<div class="spacer"></div>
			
			<div id="footer" style="text-align:center;">
				<!--
        <span style="font-size:10px;">
					DataTables &copy; Allan Jardine 2008-2009.<br>
					Information in the table &copy; <a href="http://www.u4eatech.com">U4EA Technologies</a> 2007-2009.</span>-->
			</div>
		</div>
	</body>
</html>


