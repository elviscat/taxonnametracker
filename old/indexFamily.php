<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //March 15, 2009 Friday:: mexico meeting demo indexSpecies page
  // ./ current directory
  // ../ up level directory
  //!?!?
  session_start();
  //!?!?
  $tableName = "slist";
  $title = "North American Freshwater Fishes";

  $table = "";
  include('../template/dbsetup.php');

  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  // pre sql to check the table is empty or not?
  $preSql = "SELECT COUNT(*) FROM flist";
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
    //$table .= "<th>Edit</th>";
    //$table .= "<th>Delete</th>";
    
    //fkingdom` ,`fphylum` ,`fsuperclass` ,`fclass` ,`fsubclass` ,`finfraclass` ,`fsuperorder` ,`forder` ,`fsuborder` , `fsuperfamily` ,`ffamily` ,`fcnam1` ,`fcnam2` ,`fcnam3`
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
    $table .= "</thead>\n";
    $table .= "<tbody>\n";
    while ( $nb2 = mysql_fetch_array($result) ) {
		  $table .= "<tr>";

      //$table .= "<td><a href=\"editPost.php?pid=".$nb2[0]."\">Edit</a></td>";
      //$table .= "<td><a href=\"deletePost.php?pid=".$nb2[0]."\" onclick=\"confirmation(".$nb2[0]."); return false;\" value=\"Delete it!\" >Delete</a></td>";
      

		  $table .= "<td>".$nb2[1]."</td>";
		  $table .= "<td>".$nb2[2]."</td>";
		  $table .= "<td>".$nb2[3]."</td>";
		  $table .= "<td>".$nb2[4]."</td>";
		  $table .= "<td>".$nb2[5]."</td>";
		  $table .= "<td>".$nb2[6]."</td>";
		  $table .= "<td>".$nb2[7]."</td>";
      $table .= "<td>".$nb2[8]."</td>";		  
      $table .= "<td>".$nb2[9]."</td>";
      $table .= "<td>".$nb2[10]."</td>";
      //$table .= "<td>".$nb2[11]."</td>";
      $table .= "<td><a href=\"indexFamily.php?family=".$nb2[11]."\">".$nb2[11]."</a></td>";
      $table .= "<td>".$nb2[12]."</td>";
      $table .= "<td>".$nb2[13]."</td>";
      $table .= "<td>".$nb2[14]."</td>";

      //$table .= "<td><a href=\"deletePost.php?pid=".$nb2[0]."\">Delete</a></td>";
      //$table .= "<td><a href=\"editPost.php?pid=".$nb2[0]."\">Edit</a></td>";

		  $table .= "</tr>\n";
	  }
	  $table .= "</tbody>\n";
    
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
    $table .= "</table>\n";
	}else{
	  //echo $sql;
	  $table .= "<p>Currently, you haven't posted any blog enrties yet.</p>"; //Invalid Login
  }
  
  //add a new one post
  //$table .= "<BR><BR><a href=\"newPost.php\">Add a new one post!!</a>";
  
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


