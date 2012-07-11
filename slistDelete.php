<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //March 19, 2009 Thursday:: species list management interface:: delete
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

  
  $sid = htmlspecialchars($_GET['sid'],ENT_QUOTES);
  
  include('template/dbsetup.php');
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  //sql statement
  //echo "Hello Elvis";

  //sql statement
  $deleteSql = "DELETE FROM ".$tableName." WHERE ".$serialNumberVar." = '".$sid."'";
  
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
  //echo "datafrom is ".$datafrom."<BR>";
  
  $datato ="DELETE FROM ".$tableName." WHERE ".$serialNumberVar." = ".$sid."";
  
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
  $loghistorySql .= "('".$maxLid."', '".$uid."', 'DELETE', '".$datafrom."', '".$datato."', '".$date."')";
  //echo $loghistorySql;
  mysql_query($loghistorySql);
  
  
  //echo $sql;
  mysql_query($deleteSql);
  mysql_close($link);
  Header("location:slistManage.php");
  exit();
  			
	
?>