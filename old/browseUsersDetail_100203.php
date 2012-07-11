<?php
  //Developed by elviscat (elviscat@gmail.com)
  //March 19, 2009 Friday:: browse the user information:: detail
  // ./ current directory
  // ../ up level directory  
  session_start();
  //echo $_SESSION['is_login'];
  if( !isset($_SESSION['is_login']) ){
    Header("location:authorizedFail.php");
    exit();
  }
  
  $tableName = "user";
  $serialNumberVar = "uid";

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

  //Get the GET variable
  $uid = $_GET['uid'];
  //Pre Query
  //$temp = "";
  $tempQuerySql = "SELECT username, name, role FROM user WHERE uid ='".$uid."'";
  $tempQueryResult = mysql_query("$tempQuerySql") or die("Invalid query: " . mysql_error());
  $temp = mysql_fetch_row($tempQueryResult);

  $title = "North American Freshwater Fishes Browse User Information Detail: <BR>".$temp[1]." (".$temp[0].")";
  $table = "";
  if( $temp[2] != "admin" ){
    Header("location:authorizedFail.php");
    exit();  
  }
  
  //sql statement
  $sql = "SELECT * FROM ".$tableName." WHERE ".$serialNumberVar." = '".$uid."'";
  $result = mysql_query($sql);

  $columnData = array();
  $columnDataValue = array();

  $i = 0;
  $numOfCol = mysql_num_fields($result);
  
  while ($i < $numOfCol) {    
    $meta = mysql_fetch_field($result, $i);
    $columnData[$i] = $meta->name;
    $i++;
  }
  if(mysql_num_rows($result)>0){
    while ( $nb = mysql_fetch_array($result) ) {
      for($j = 0; $j < sizeof($columnData); $j++){
        $columnDataValue[$j] = $nb[$j];
      }
	  }
  }
  mysql_close($link);
?>
<!--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Description" content="Saint Louis University, taxonomy and nomenclature platform based on social network" />
<meta name="Keywords" content="Saint Louis University, taxonomy, nomenclature, social network" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Distribution" content="Global" />
<meta name="Author" content="Richard Mayden - cypriniformes@gmail.com, Elvis Hsin-Hui Wu - hwu5@slu.edu" />
<meta name="Robots" content="index,follow" />
<link rel="stylesheet" href="edit.css" type="text/css" />
<title><? echo $title; ?></title>
</head>
<body>
			<div id="basic" class="myform">
      <h3><? echo $title; ?></h3>
      <p>Detail Information</p>
			<form id="userDetail" action="" method="post">   
        <?php
          for($j = 0; $j < sizeof($columnDataValue); $j++){
            if( $j != 0 && $j != 2){
              echo "<label>";
              echo $columnData[$j]."\n";
              echo "</label>";
            //echo "<input name=\"".$columnData3[$j]."\" type=\"text\" value=\"".$columnData4[$j]."\" />\n";
              echo "<input type=\"text\" value=\"".$columnDataValue[$j]."\" readonly>";
              //echo "<textarea rows=\"15\" cols=\"25\" readonly>".$columnDataValue[$j]."</textarea>";
            }
          }
        ?>        
        <div class="spacer"></div>
      </form>
      <div align="center"><a href="admin.php">Back to Admin Page</a>
      <BR>
      <a href="index.php">Back to Homepage</a>
      </div>   
			</div>
</body>
</html>
