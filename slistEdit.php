<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //March 19, 2009 Thursday:: species list management interface:: edit
  // ./ current directory
  // ../ up level directory
  
  session_start();

  if( !isset($_SESSION['is_login']) ){
    Header("location:authorizedFail.php");
    exit();
  }

  include('template/dbsetup.php');

  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  // pre sql to check the table is empty or not?

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
  
  $tableName = "slist";
  $serialNumberVar = "sid";
  //get the GET values
  $sid = $_GET['sid'];
  //echo $sid;	
  
    //sql statement
  $sql = "SELECT * FROM ".$tableName." WHERE ".$serialNumberVar." = '".$sid."'";
  $result = mysql_query($sql);

  $columnValue = array();

  $i = 0;
  $numOfCol = mysql_num_fields($result);
  //echo "numOfCol is ".$numOfCol."\n<BR>";
  
  if(mysql_num_rows($result) > 0){
    //echo "sql is ".$sql."\n<BR>";
    while ( $nb = mysql_fetch_array($result) ) {
      //for($j = 0; $j < 9; $j++){
      for($j = 0; $j < $numOfCol; $j++){
        $columnValue[$j] = $nb[$j];
        //echo "columnValue[j] is ".$columnValue[$j]."\n<BR>";
        //echo "nb[j] is ".$nb[$j]."\n<BR>";
      }
	  }
  }
  
  mysql_close($link);
  
  $title = "North American Freshwater Fishes Edit Species: <BR>".$temp[1]." (".$temp[0].")";
  $subTitle = "Edit a current species";
  
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!--<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />-->
<meta name="Distribution" content="Global" />
<meta name="Author" content="Richard Mayden - cypriniformes@gmail.com, Elvis Hsin-Hui Wu - hwu5@slu.edu" />
<meta name="Robots" content="index,follow" />
<link rel="stylesheet" href="edit.css" type="text/css" />
<title><? echo $title; ?></title>
</head>
<body>
  <div id="basic" class="myform">
    <h1><? echo $title; ?></h1>
    <p><? echo $subTitle; ?></p>
    <form id="newEdit" action="slistEdit2.php" method="post">
      <?php      
        $title = array( 0 => 'Sid', 1 => 'Family', 2 => 'Genus', 3 => 'Species', 4 => 'Author' , 5 => 'Location' , 6 => 'Common Name(English)' , 7 => 'Common Name(Spanish)' , 8 => 'Common Name(French)' );
        $subTitle = array( 0 => 'Add Sid', 1 => 'Add Family', 2 => 'Add Genus', 3 => 'Add Species', 4 => 'Add Author' , 5 => 'Add Location' , 6 => 'Add English' , 7 => 'Add Spanish' , 8 => 'Add French' );
        $varName = array( 0 => 'sid', 1 => 'sfamily', 2 => 'sgenus', 3 => 'sspecies', 4 => 'sauthor' , 5 => 'sloc' , 6 => 'scnam1' , 7 => 'scnam2' , 8 => 'scnam3' );

        for ( $i = 0; $i < sizeof($title); $i++){
          if( $i == 0 ){
            echo "<input id=\"".$varName[$i]."\" name=\"".$varName[$i]."\" type=\"hidden\" value=\"".$columnValue[$i]."\" />\n";
          }else{
            echo "<label>".$title[$i]."\n";
            echo "<span class=\"small\">".$subTitle[$i]."</span>\n";
            echo "</label>\n";
            echo "<input id=\"".$varName[$i]."\" name=\"".$varName[$i]."\" type=\"text\" size=\"60\" value=\"".$columnValue[$i]."\" />\n";
          }
        }
        
        $_SESSION['varName'] = $varName;    
      ?>
      <button  type="submit">Update this data</button>
    </form>
    <div align="center">
      <a href="slistManage.php">Back to Species List</a>
      <BR>
      <a href="admin.php">Back to Admin Page</a>
    </div>
  </div>
</body>
</html>

