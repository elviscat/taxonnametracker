<?php
  //Developed by elviscat (elviscat@gmail.com)
  //March 17, 2009 Tuesday:: post the proposed changes or suggestted name changes management interface --> edit one entry --> updated
  // ./ current directory
  // ../ up level directory
  $tableName = "post";
  $serialNumberVar = "pid";
  $title = "Proposed Changes or Suggestted Name Changes Updated Result";
  
  session_start();
  
  if( (!isset($_SESSION['is_login'])) ){
	  Header("location:authorizedFail.php");
	  exit();
  }
  
  $columnData = array();//Array for column variable
  $columnData2 = array();//Array for post variable  
  for($j = 0; $j < sizeof($_SESSION['post']); $j++){
    //echo "\$columnData[\$".$j."] is ".$columnData[$j]."<br>";
    //echo $nb[$j]."\n<br>";
    $columnData[$j] = $_SESSION['post'][$j];
    //echo "column::".$columnData[$j]."\n<br>";
    //echo "Session::".$_SESSION['post'][$j]."\n<br>";
    //echo "Session::".$_POST[($columnData[$j])]."\n<br>";
    $columnData2[$j] = $_POST[($columnData[$j])];
  }  
  
  session_unregister($_SESSION['post']);
  
  include('template/dbsetup.php');
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  //sql statement
  
  $pid = "";
  for($j = 0; $j < sizeof($columnData); $j++){  
    if( $j == 0){
      $pid = $columnData2[$j];
    }else{
      $updateSql = "UPDATE ".$tableName." SET ".$columnData[$j]." ='".$columnData2[$j]."'";
      $updateSql .= " WHERE ".$serialNumberVar." = '".$pid."'";
      //echo $updateSql." ForTest!!<br>";
      mysql_query($updateSql);
    }
  }

  //sql statement
  $sql = "SELECT * FROM ".$tableName." WHERE ".$serialNumberVar." = '".$pid."'";
  $result = mysql_query($sql);

  $columnData3 = array();
  $columnData4 = array();

  $i = 0;
  $numOfCol = mysql_num_fields($result);
  
  while ($i < $numOfCol) {    
    $meta = mysql_fetch_field($result, $i);
    $columnData3[$i] = $meta->name;
    $i++;
  }
  
  if(mysql_num_rows($result)>0){
    while ( $nb = mysql_fetch_array($result) ) {
      for($j = 0; $j < sizeof($columnData3); $j++){
        $columnData4[$j] = $nb[$j];
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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="Distribution" content="Global" />
<meta name="Author" content="Richard Mayden - cypriniformes@gmail.com, Elvis Hsin-Hui Wu - hwu5@slu.edu" />
<meta name="Robots" content="index,follow" />
<link rel="stylesheet" href="edit.css" type="text/css" />
<title><? echo $title; ?></title>
</head>
<body>
			<div id="basic" class="myform">
      <h3><? echo $title; ?></h3>
      <p>Updated Results</p>
			<form id="collectionEditor" action="" method="post">   
        <!--<p>Information for species: <? echo "<i>".$columnData2[4]." ".$columnData2[6]."</i>"; ?></p>-->
        <?php
          for($j = 0; $j < sizeof($columnData3); $j++){
            if( $j > 0 && $j <3){
              echo "<label>";
              echo $columnData3[$j]."\n";
              echo "</label>";
            //echo "<input name=\"".$columnData3[$j]."\" type=\"text\" value=\"".$columnData4[$j]."\" />\n";
              //echo "<input type=\"text\" value=\"".$columnData4[$j]."\" readonly>";
              echo "<textarea rows=\"15\" cols=\"25\" readonly>".$columnData4[$j]."</textarea>";
            }
          }
        ?>        
        <div class="spacer"></div>
      </form>
      <div align="center"><a href="postProposedChangesManage.php">Back to Management Page</a></div>   
			</div>
</body>
</html>
