<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //March 19, 2009 Thursday:: species list management interface:: insert
  // ./ current directory
  // ../ up level directory
  
  session_start();

  if( !isset($_SESSION['is_login']) ){
    Header("location:authorizedFail.php");
    exit();
  }
  
  $tableName = "slist";
  $serialNumberVar = "sid";
  
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
  mysql_close($link);
  
  $title = "North American Freshwater Fishes Add A New Species: <BR>".$temp[1]." (".$temp[0].")";
  $subTitle = "Add a new species";
  
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
    <h1><? echo $title; ?></h1>
    <p><? echo $subTitle; ?></p>
    <form id="newInert" action="slistInsert2.php" method="post">
      <?php      
        $title = array( 0 => 'Family', 1 => 'Genus', 2 => 'Species', 3 => 'Author' , 4 => 'Location' , 5 => 'Common Name(English)' , 6 => 'Common Name(Spanish)' , 7 => 'Common Name(French)' );
        $subTitle = array( 0 => 'Add Family', 1 => 'Add Genus', 2 => 'Add Species', 3 => 'Add Author' , 4 => 'Add Location' , 5 => 'Add English' , 6 => 'Add Spanish' , 7 => 'Add French' );
        $varName = array( 0 => 'sfamily', 1 => 'sgenus', 2 => 'sspecies', 3 => 'sauthor' , 4 => 'sloc' , 5 => 'scnam1' , 6 => 'scnam2' , 7 => 'scnam3' );

        for ( $i = 0; $i < sizeof($title); $i++){
          echo "<label>".$title[$i]."\n";
          echo "<span class=\"small\">".$subTitle[$i]."</span>\n";
          echo "</label>\n";
          echo "<input id=\"".$varName[$i]."\" name=\"".$varName[$i]."\" type=\"text\" size=\"60\" value=\"\" />\n";
        }
        
        $_SESSION['varName'] = $varName;    
      ?>
      <button  type="submit">Post it!</button>
    </form>
    <div align="center">
      <a href="slistManage.php">Back to Species List</a>
      <BR>
      <a href="admin.php">Back to Admin Page</a>
    </div>
  </div>
</body>
</html>

