<?php
  //Developed by elviscat (elviscat@gmail.com)
  //March 17, 2009 Tuesday:: post the proposed changes or suggestted name changes management interface --> edit one entry
  // ./ current directory
  // ../ up level directory
  $tableName = "post";
  $serialNumberVar = "pid";
  $title = "Proposed Changes or Suggestted Name Changes Editor";
  
  session_start();
  if( (!isset($_SESSION['is_login'])) ){
	  Header("location:authorizedFail.php");
	  exit();
  }  
  //get the Getted values
  $pid = $_GET['pid'];
  //echo $pid;	

  include('template/dbsetup.php');
    
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  
  //select database
  mysql_select_db($dbname);
  
  $preSql = "SELECT prefuid FROM ".$tableName." WHERE ".$serialNumberVar." = '".$pid."'";
  $preResult = mysql_query($preSql);
  $tempPrefuid = mysql_result($preResult, 0);
  if( $tempPrefuid != $_SESSION['uid']){
    Header("location:authorizedFail.php");
	  exit();
  }
  
  //sql statement
  $sql = "SELECT * FROM ".$tableName." WHERE ".$serialNumberVar." = '".$pid."'";
  $result = mysql_query($sql);

  $columnData = array();
  $columnData2 = array();
  //echo "hello elvis";
  //echo $dbname;

  $i = 0;
  $numOfCol = mysql_num_fields($result);
  //$numOfCol = mysql_num_fields($result2);
  while ($i < $numOfCol) {
    //echo "Information for column $i:<br />\n";
    $meta = mysql_fetch_field($result, $i);
    if (!$meta) {
      echo "No information available<br />\n";
    }
    $columnData[$i] = $meta->name;
    $i++;
  }

  if(mysql_num_rows($result)>0){
    //echo $sql;
    while ( $nb = mysql_fetch_array($result) ) {
      for($j = 0; $j < sizeof($columnData); $j++){
        //echo "\$columnData[\$".$j."] is ".$columnData[$j]."<br>";
        //echo $nb[$j]."\n<br>";
        $columnData2[$j] = $nb[$j];
        //echo $columnData2[$j]."\n<br>";
      }
	  }
  }
  $_SESSION['post'] = $columnData;
  mysql_close($link);
?>
<!-->
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
<title><? echo $title; ?></title>
<link rel="stylesheet" href="edit.css" type="text/css" />
<script src="/jquery/jquery.js" type="text/javascript" language="javascript"></script>
<script src="/jquery/jquery.form.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
  // wait for the DOM to be loaded 
  $(document).ready(function() { 
    // bind 'speciesEditor' and provide a simple callback function 
    $(#collectionEditor').ajaxSubmit(function() {  
      return false; 
    });        
  });
</script>
</head>
<body>
			<div id="basic" class="myform">
      <h3><? echo $title; ?></h3>
		  <p>Editor</p>
      <form id="postEditor" action="postProposedChangesEdit2.php" method="post">
        <?php
          for($j = 0; $j < sizeof($columnData); $j++){
            //echo "\$columnData[\$".$j."] is ".$columnData[$j]."<br>";
            if( $j == 0){
              //echo $columnData2[$j]."<br><input name=\"".$columnData[$j]."\" type=\"hidden\" value=\"".$columnData2[$j]."\" />\n";
              //echo "<div align=\"center\"><p>Pid is ".$columnData2[$j]."</p></div>";
              
              echo "<br><input name=\"".$columnData[$j]."\" type=\"hidden\" value=\"".$columnData2[$j]."\" />\n";
            //}elseif( ($j == 1) ){
              //echo "<label>";
              //echo $columnData[$j]."\n";
              //echo "<span class=\"small\">Add ".$columnData[$j]."</span>";
              //echo "</label>";
              //echo "<input name=\"".$columnData[$j]."\" type=\"text\" value=\"".$columnData2[$j]."\" />\n";              
            }elseif( ($j == 1) || ($j == 2) ){
              echo "<label>";
              echo $columnData[$j]."\n";
              echo "<span class=\"small\">Add ".$columnData[$j]."</span>";
              echo "</label>";
              //echo "<input name=\"".$columnData[$j]."\" type=\"text\" value=\"".$columnData2[$j]."\" />\n";
              echo "<textarea name=\"".$columnData[$j]."\" rows=\"15\" cols=\"25\">".$columnData2[$j]."</textarea>";
            }else{
              echo "<br><input name=\"".$columnData[$j]."\" type=\"hidden\" value=\"".$columnData2[$j]."\" />\n";
            }
          }
        ?>        
        <button  type="submit">Update this information</button>
        <br>
        <div align="center"><a href="postProposedChangesManage.php">Back to Management Page</a></div>
        <div class="spacer"></div>
      </form>    
			</div>
</body>
</html>










