<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //March 19, 2009 Thursday:: species list management interface:: edit2
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
  
  //Update is here!!
  $tableName = "slist";
  $serialNumberVar = "sid";
  
  $varName = $_SESSION['varName'];
  
  $sid = htmlspecialchars($_POST[$varName[0]],ENT_QUOTES);
  
  //sql statement
  for ( $i = 0; $i < sizeof($varName); $i++){
    $sql = "Update ".$tableName." SET ".$varName[$i]." = '".htmlspecialchars($_POST[$varName[$i]],ENT_QUOTES)."' WHERE ".$serialNumberVar." = ".htmlspecialchars($_POST[$varName[0]],ENT_QUOTES)."";
    $datato .= ",Update ".$tableName." SET ".$varName[$i]." = ".htmlspecialchars($_POST[$varName[$i]],ENT_QUOTES)." WHERE ".$serialNumberVar." = ".htmlspecialchars($_POST[$varName[0]],ENT_QUOTES)."";
    //echo "sql is ".$sql."\n<BR>";
    mysql_query($sql);
  }  

  $datafromSQL = "SELECT * FROM ".$tableName." WHERE ".$serialNumberVar." = '".$sid."'"; 
  //echo "datafrom SQL is ".$datafromSQL."<BR>";
  $datafromResult = mysql_query("$datafromSQL");
  $datafromArray = mysql_fetch_row($datafromResult);
  $datafrom = "";
  for( $i = 0; $i < sizeof($datafromArray); $i++){
    if($i == sizeof($datafromArray)-1 ){
      $datafrom .= $datafromArray[$i];
    }else{
      $datafrom .= $datafromArray[$i]."#";
    }
  }

  
  $maxLid = 0;
  $maxLidSql = "SELECT MAX(lid) FROM loghistory";
  $result = mysql_query ($maxLidSql) or die ("Invalid query");
  if( mysql_num_rows( $result) > 0 ){
	  while ( $nb = mysql_fetch_array($result)) {
		  $maxLid = $nb[0] + 1;
		  //echo "maxLid is ".$maxLid."<br>";
	  }
  }else{
    $maxLid = 1;
  }
  $date = date("Y-m-d H:i:s");//"2008-08-28 11:03:21"
  $loghistorySql = "INSERT INTO loghistory (`lid`, `lrefuid`, `acttype`, `datafrom`, `datato`, `actdate`) VALUES ";
  $loghistorySql .= "('".$maxLid."', '".$uid."', 'UPDATE', '".$datafrom."', '".$datato."', '".$date."')";
  //echo $loghistorySql."\n<BR>";
  mysql_query($loghistorySql);

  
  
  //echo "sizeof(varName) is ".sizeof($varName)."\n<BR>";
  //echo "varName is ".$varName."\n<BR>";

  session_unregister($_SESSION['varName']);  
  
  //
  //
  //
  //$sid use the former $sid from $varName[0]
  //get the GET values
  //$sid = $_GET['sid'];
  //echo $sid;	
  
    //sql statement
  $sql = "SELECT * FROM ".$tableName." WHERE ".$serialNumberVar." = '".$sid."'";
  $result = mysql_query($sql);

  $columnValue = array();

  $i = 0;
  $numOfCol = mysql_num_fields($result);

  if(mysql_num_rows($result)>0){
    //echo $sql;
    while ( $nb = mysql_fetch_array($result) ) {
      for($j = 0; $j < $numOfCol; $j++){
        $columnValue[$j] = $nb[$j];
      }
	  }
  }
  
  mysql_close($link);
  
  $title = "North American Freshwater Fishes Edit Species: <BR>".$temp[1]." (".$temp[0].")";
  $subTitle = "The updated result";
  
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
    <form id="updatedResult" action="slistManage.php" method="post">
      <?php      
        $title = array( 0 => 'Sid', 1 => 'Family', 2 => 'Genus', 3 => 'Species', 4 => 'Author' , 5 => 'Location' , 6 => 'Common Name(English)' , 7 => 'Common Name(Spanish)' , 8 => 'Common Name(French)' );
        $subTitle = array( 0 => 'Add Sid', 1 => 'Add Family', 2 => 'Add Genus', 3 => 'Add Species', 4 => 'Add Author' , 5 => 'Add Location' , 6 => 'Add English' , 7 => 'Add Spanish' , 8 => 'Add French' );
        $varName = array( 0 => 'sid', 1 => 'sfamily', 2 => 'sgenus', 3 => 'sspecies', 4 => 'sauthor' , 5 => 'sloc' , 6 => 'scnam1' , 7 => 'scnam2' , 8 => 'scnam3' );

        for ( $i = 0; $i < sizeof($title); $i++){
          if( $i == 0 ){
            //echo "<input id=\"".$varName[$i]."\" name=\"".$varName[$i]."\" type=\"hidden\" value=\"".$columnValue[$i]."\" />\n";
          }else{
            echo "<label>".$title[$i]."\n";
            echo "<span class=\"small\">".$subTitle[$i]."</span>\n";
            echo "</label>\n";
            //echo "<input id=\"".$varName[$i]."\" name=\"".$varName[$i]."\" type=\"text\" size=\"60\" value=\"".$columnValue[$i]."\" />\n";
            echo "<input type=\"text\" value=\"".$columnValue[$i]."\" readonly>";
          }
        }
      ?>
      <button  type="submit">Back to Species List</button>        
    </form>
    <div align="center">
      <!--
      <a href="slistManage.php">Back to Species List</a>
      <BR>
      -->
      <a href="admin.php">Back to Admin Page</a>
    </div>
  </div>
</body>
</html>
