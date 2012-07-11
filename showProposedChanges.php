<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //March 17, 2009 Tuesday:: Show the Proposed Changes OR Suggestted Name Changes Detail
  //Jan 14, 2010 Thursday: Layout and logic modification
  // ./ current directory
  // ../ up level directory
  //!?!?
  session_start();
  //!?!?




  $lv = htmlspecialchars($_GET['lv'],ENT_QUOTES);
  //echo "Level is :: ".$users."<br>\n";
  $id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "ID is :: ".$."<br>\n";
  include('template/dbsetup.php');  
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname); 
  
  $table = "";//!?!?
  $replyTitle = "";//!?!?
  
  if($lv == "family"){
    $sql_account_name = "SELECT ffamily FROM flist WHERE fid =".$id;
  }elseif($lv == "genus"){
    $sql_account_name = "SELECT ggenus FROM glist WHERE gid =".$id;
  }elseif($lv == "species"){
    $sql_account_name = "SELECT sgenus,sspecies FROM slist WHERE sid =".$id;
  }
  $result_sql_account_name = mysql_query($sql_account_name);
  $account_name = "";
  if(mysql_num_rows($result_sql_account_name) > 0){
    while ( $nb = mysql_fetch_array($result_sql_account_name) ) {
      if($lv == "species"){
        $account_name = "<i>".$nb[0]." ".$nb[1]."</i>";
      }else{
        $account_name = $nb[0];
      }
    }
  }
  $temp = "Level: ".ucwords($lv).":".$account_name;
  $caption = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes";
  $title = "Proposed Changes or Suggestted Name Changes List on ".$temp;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<!--<link rel="shortcut icon" type="image/ico" href="http://www.sprymedia.co.uk/media/images/favicon.ico" />-->
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" href="edit.css" type="text/css" /><!--Does this file edit.css should be keep?-->	
    <link rel="stylesheet" href="edit.css" type="text/css" />
    <style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
		<script type="text/javascript" language="javascript" src="media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
		</script>
    <script type="text/javascript">
    <!--
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

  $sql_slist_table = "SELECT * FROM post WHERE preflv='".$lv."' AND prefsid=".$id;   
  //echo "sql_slist_table is ".$sql_slist_table."<br>\n";
  $result_sql_slist_table = mysql_query($sql_slist_table);
  if(mysql_num_rows($result_sql_slist_table) > 0){
    echo "<table border=\"0\" cellspacing=\"1\" bgcolor=\"black\">\n";
    //echo "<table border=\"0\" cellspacing=\"1\" bgcolor=\"#8080ff\">\n";
    //echo "<table>\n";
    echo "<tr bgcolor=\"white\"><th>Title</th><th>Content</th><th>Posted Time</th><th>Type</th><th>State</th><th>View Detail</th>\n";
    while ( $nb2 = mysql_fetch_array($result_sql_slist_table) ) {
      //echo $nb2[0]."&nbsp;&nbsp;".$nb2[1]."<br>\n";
      echo "<tr bgcolor=\"white\"><td>".$nb2[1]."</td><td>".substr($nb2[2], 0, 10)."..."."</td><td>".$nb2[3]."</td><td>".$nb2[7]."</td>";
      echo "<td>Not implemented</td>";
      //echo "<td><a href=\"viewpost.php?lv=".$lv."&pid=".$id."\">View</a></td>";
      echo "<td><a href=\"viewpost.php?pid=".$nb2[0]."\">View</a></td>";
      //<td>".$nb2[6]."</td><td>".$nb2[7]."</td><td>".$nb2[8]."</td><td>".$nb2[9]."</td><td>".$nb2[10]."</td>";
      //echo "<td>".$nb2[11]."</td><td>".$nb2[12]."</td>";
      echo "</tr>\n";
    }
    echo "</table>\n";
  }

?>
      <!--Table is here!!-->
		<!--Comment Post Form-->
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






