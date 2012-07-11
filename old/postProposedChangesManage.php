<?php
  //Developed by elviscat (elviscat@gmail.com)
  //March 17, 2009 Tuesday:: post the proposed changes or suggestted name changes management interface
  // ./ current directory
  // ../ up level directory
  session_start();
  if( (!isset($_SESSION['is_login'])) ){
	  Header("location:authorizedFail.php");
	  exit();
  }  
  
  $title = "Post Proposed Changes Management Interface";
  
  
  $table = "";
  include('template/dbsetup.php');

  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);

  $prefuid = $_SESSION['uid'];

  $preSql = "SELECT COUNT(*) FROM post WHERE prefuid= '".$prefuid."'";
  //echo $preSql;
  $preResult = mysql_query($preSql);
  $numOfCount = 0;
  while ( $nb = mysql_fetch_array($preResult) ) {
    $numOfCount = $nb[0];  
  }
  //echo "<BR>numOfCount is ".$numOfCount;
  $sql = "SELECT * FROM post WHERE prefuid= '".$prefuid."'";  
  //echo "<BR>sql is ".$sql;
  
  $result = mysql_query($sql);
  if( $numOfCount > 0 ){  

    $table .= "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"display\" id=\"example\" width=\"640\">\n";
    $table .= "<thead>\n";
	  $table .= "<tr>";
    $table .= "<th>Edit</th>";
    $table .= "<th>Delete</th>";
    
    $table .= "<th>Title</th>";//$nb[1]
    $table .= "<th>Content</th>";//$nb[2]
    $table .= "<th>Create Date</th>";//$nb[3]
    $table .= "<th>Species</th>";//$nb[5] sid --> match the species name
    $table .= "<th>Type</th>";//$nb[6]
    //$table .= "<th>Post Tag</th>";//$nb[6]
    //$table .= "<th>Post Category</th>";//$nb[7]

    $table .= "<th>Delete</th>";
    $table .= "<th>Edit</th>";
	  $table .= "</tr>\n";
    $table .= "</thead>\n";
    $table .= "<tbody>\n";
    while ( $nb2 = mysql_fetch_array($result) ) {
		  $table .= "<tr>";

      $table .= "<td><a href=\"postProposedChangesEdit.php?pid=".$nb2[0]."\">Edit</a></td>";
      $table .= "<td><a href=\"postProposedChangesDelete.php?pid=".$nb2[0]."\" onclick=\"confirmation(".$nb2[0]."); return false;\" value=\"Delete it!\" >Delete</a></td>";


		  $table .= "<td>".$nb2[1]."</td>";
		  $table .= "<td>".$nb2[2]."</td>";
		  $table .= "<td>".$nb2[3]."</td>";
		  
		  //
      //$table .= "<td>".$nb2[5]."</td>";
      //call back the species scientific name
      //echo $dbname;
      $scientificName = "";
      $tempQuerySql = "SELECT sgenus FROM slist WHERE sid ='".$nb2[5]."'";
      $tempQueryResult = mysql_query("$tempQuerySql") or die("Invalid query: " . mysql_error());
      $scientificName .= mysql_result($tempQueryResult, 0);
      $scientificName .= " "; 
      $tempQuerySql2 = "SELECT sspecies FROM slist WHERE sid ='".$nb2[5]."'";
      $tempQueryResult2 = mysql_query("$tempQuerySql2") or die("Invalid query: " . mysql_error());
      $scientificName .= mysql_result($tempQueryResult2, 0);
      $table .= "<td><i>".$scientificName."</i></td>";      
      //
      
		  $table .= "<td>".$nb2[6]."</td>";
		  //$table .= "<td>".$nb2[6]."</td>";
		  //$table .= "<td>".$nb2[7]."</td>";

      $table .= "<td><a href=\"postProposedChangesDelete.php?pid=".$nb2[0]."\" onclick=\"confirmation(".$nb2[0]."); return false;\" value=\"Delete it!\" >Delete</a></td>";
      $table .= "<td><a href=\"postProposedChangesEdit.php?pid=".$nb2[0]."\">Edit</a></td>";

		  $table .= "</tr>\n";
	  }
	  $table .= "</tbody>\n";
    
    /*
    $table .= "<tfoot>\n";
	  $table .= "<tr>";
	  $table .= "<th>Edit</th>";
    $table .= "<th>Delete</th>";

    $table .= "<th>Post ID</th>";//$nb[0]
    $table .= "<th>Post Tilte</th>";//$nb[1]
    $table .= "<th>Post Content</th>";//$nb[2]
    $table .= "<th>Post Create Date</th>";//$nb[3]
    $table .= "<th>Post Count</th>";//$nb[5]
    $table .= "<th>Post Tag</th>";//$nb[6]
    $table .= "<th>Post Category</th>";//$nb[7]
    
    $table .= "<th>Delete</th>";
    $table .= "<th>Edit</th>";
	  $table .= "</tr>\n";
    $table .= "</tfoot>\n";
    */
    
    $table .= "</table>\n";
	}else{
	  //echo $sql;
	  $table .= "<p>Currently, you haven't posted any blog enrties yet.</p>"; //Invalid Login
  }
  
  //add a new one post
  //$table .= "<BR><BR><a href=\"newPost.php\">Add a new one post!!</a>";
  $table .= "<BR><BR><a href=\"admin.php\">Back to Admin page</a>";
  $table .= "<BR><BR><a href=\"index.php\">Back to homepage</a>";
  
  mysql_close($link);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
    <meta name="Description" content="Saint Louis University, taxonomy and nomenclature platform based on social network" />
    <meta name="Keywords" content="Saint Louis University, taxonomy, nomenclature, social network" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="Distribution" content="Global" />
    <meta name="Author" content="Richard Mayden - cypriniformes@gmail.com, Elvis Hsin-Hui Wu - hwu5@slu.edu" />
    <meta name="Robots" content="index,follow" />
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
			<h1><? echo $title; ?> of "<? echo $_SESSION['username']; ?>"</h1>
      <?php
        if( !isset($_SESSION['is_login']) ){
          echo "<h2><a href=\"login.php\">Login</a>";
        }else{
          echo "<h2><a href=\"logout.php\">Logout</a>";
        }
			?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="admin.php">Administration Interface</a></h2>
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