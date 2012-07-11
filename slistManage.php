<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //March 19, 2009 Thursday:: species list management interface
  // ./ current directory
  // ../ up level directory
  
  session_start();

  if( !isset($_SESSION['is_login']) ){
    Header("location:authorizedFail.php");
    exit();
  }
  
  $tableName = "slist";
  //$title = "North American Freshwater Fishes Family List Management Interface";
  //$subTitle = "North American Freshwater Fishes Family List Management Interface";

  $table = "";
  include('template/dbsetup.php');

  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  // pre sql to check the table is empty or not?
  
  /*
  //Get the session variable
  $uid = $_SESSION['uid'];
  //Pre Query
  //$temp = "";
  $tempQuerySql = "SELECT username, name, role FROM user WHERE uid ='".$uid."'";
  $tempQueryResult = mysql_query("$tempQuerySql") or die("Invalid query: " . mysql_error());
  $temp = mysql_fetch_row($tempQueryResult);

  $title = "North American Freshwater Fishes Species List Management Interface: <BR>".$temp[1]." (".$temp[0].")";
  $table = "";
  if( $temp[2] != "admin" ){
    Header("location:authorizedFail.php");
    exit();  
  }
  */
  

  $preSql = "SELECT COUNT(*) FROM ".$tableName;
  //echo $preSql;
  $preResult = mysql_query($preSql);
  $numOfCount = 0;
  while ( $nb = mysql_fetch_array($preResult) ) {
    //echo "nb[0] is ".$nb[0]."<BR>";
    $numOfCount = $nb[0];
    //echo "numOfCount is "."<BR>";
  }  
  //echo "Elvis";  
  $sql = "SELECT * FROM ".$tableName."";  
  //echo "sql statement is ".$sql."\n<BR>";
  $result = mysql_query($sql);
  
  if( $numOfCount > 0 ){  

    $table .= "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"display\" id=\"example\" width=\"640\">\n";
    $table .= "<thead>\n";
	  $table .= "<tr>";
    $table .= "<th>Edit</th>";
    $table .= "<th>Delete</th>";
    
    //$table .= "<th>Serial Number</th>";//$nb[0]
    $table .= "<th>Family</th>";//$nb[1]
    $table .= "<th>Genus</th>";//$nb[2]
    $table .= "<th>Species</th>";//$nb[3]
    //$table .= "<th>Email</th>";//$nb[7]
    //$table .= "<th>Web</th>";//$nb[8]
    //$table .= "<th>Region</th>";//$nb[9]
    //$table .= "<th>Education</th>";//$nb[10]
    //$table .= "<th>Role Level</th>";//$nb[12]
    //$table .= "<th>Register Time</th>";//$nb[13]

    $table .= "<th>Delete</th>";
    $table .= "<th>Edit</th>";
	  $table .= "</tr>\n";
    $table .= "</thead>\n";
    $table .= "<tbody>\n";
    while ( $nb2 = mysql_fetch_array($result) ) {
		  $table .= "<tr>";

      $table .= "<td><a href=\"slistEdit.php?sid=".$nb2[0]."\">Edit</a></td>";
      $table .= "<td><a href=\"slistDelete.php?sid=".$nb2[0]."\" onclick=\"confirmation(".$nb2[0]."); return false;\" value=\"Delete it!\" >Delete</a></td>";
      

		  //$table .= "<td><a href=\"browseUsersDetail.php?uid=".$nb2[0]."\">".$nb2[0]."</a></td>";
		  $table .= "<td>".$nb2[1]."</td>";
		  $table .= "<td><i>".$nb2[2]."</i></td>";
		  $table .= "<td><i>".$nb2[3]."</i></td>";
		  //$table .= "<td>".$nb2[4]."</td>";
		  //$table .= "<td>".$nb2[5]."</td>";
		  //$table .= "<td>".$nb2[6]."</td>";
      //$table .= "<td>".$nb2[7]."</td>";		  
      //$table .= "<td>".$nb2[8]."</td>";
      //$table .= "<td>".$nb2[9]."</td>";

      $table .= "<td><a href=\"slistDelete.php?sid=".$nb2[0]."\">Delete</a></td>";
      $table .= "<td><a href=\"slistEdit.php?sid=".$nb2[0]."\">Edit</a></td>";

		  $table .= "</tr>\n";
	  }
	  $table .= "</tbody>\n";
    
    /*
    $table .= "<tfoot>\n";
	  $table .= "<tr>";
	  
    //$table .= "<th>Edit</th>";
    //$table .= "<th>Delete</th>";

    $table .= "<th>Kingdom</th>";//$nb[1]
    $table .= "<th>Phylum</th>";//$nb[2]
    $table .= "<th>Super Class</th>";//$nb[3]
    $table .= "<th>Class</th>";//$nb[4]
    $table .= "<th>Sub Class</th>";//$nb[5]
    $table .= "<th>Infra Calss</th>";//$nb[6]
    $table .= "<th>Super Order</th>";//$nb[7]
    $table .= "<th>Order</th>";//$nb[8]
    $table .= "<th>Sub Order</th>";//$nb[9]
    $table .= "<th>Super Family</th>";//$nb[10]
    $table .= "<th>Family</th>";//$nb[11]
    $table .= "<th>Common Name (English)</th>";//$nb[12]
    $table .= "<th>Common Name (Sapnish)</th>";//$nb[13]
    $table .= "<th>Common Name (French)</th>";//$nb[14]
        
    //$table .= "<th>Delete</th>";
    //$table .= "<th>Edit</th>";
	  
    $table .= "</tr>\n";
    $table .= "</tfoot>\n";
    */
    $table .= "</table>\n";
	}else{
	  //echo $sql;
	  $table .= "<p>Currently, you haven't posted any blog enrties yet.</p>"; //Invalid Login
  }
  
  //add a new species
  $table .= "<BR><a href=\"slistInsert.php\">Add a new species!</a><BR>";
  $table .= "<BR><a href=\"admin.php\">Back to Admin page</a>";
  $table .= "<BR><a href=\"index.php\">Back to Homepage</a>";  
  
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
					"aaSorting": [[2,'asc'], [3,'asc'], [4,'asc']]
				} );
			} );
		</script>
    <script type="text/javascript">
    <!--
      function confirmation(a) {
	    var answer = confirm("Delete it?")
	      if (answer){
		      alert("Ok, We will delete this post entry.")
		      window.location = "slistDelete.php?sid=" + a;
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
			<!--<h1><? //echo $subTitle; ?></h1>-->
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


