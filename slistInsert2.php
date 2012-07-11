<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //March 19, 2009 Thursday:: species list management interface:: insert2
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

  //Insert is here!!
  $maxSid = 0;
  $maxSidSql = "SELECT MAX(".$serialNumberVar.") FROM ".$tableName;
  $result = mysql_query ($maxSidSql) or die ("Invalid query");
  if( mysql_num_rows( $result) > 0 ){
	  while ( $nb = mysql_fetch_array($result)) {
		  $maxSid = $nb[0] + 1;
		  //echo "maxSid is ".$maxSid."<br>";
	  }
  }else{
    $maxSid = 1;
  }
  
  //echo "maxSid is ".$maxSid."<br>";
  $varName = $_SESSION['varName'];

  //sql statement
  $sql = "INSERT INTO ".$tableName." (`sid`, ";
  $datato = "INSERT INTO ".$tableName." (sid, ";

  for ( $i = 0; $i < sizeof($varName); $i++){

    if($i == sizeof($varName)-1){
      $sql .= "`".$varName[$i]."` ";
      $datato .= "".$varName[$i]." ";
    }else{
      $sql .= "`".$varName[$i]."`, ";
      $datato .= "".$varName[$i].", ";
    }
  }  
  $sql .= ") VALUES ('".$maxSid."', ";
  $datato .= ") VALUES (".$maxSid.", ";
  for ( $i = 0; $i < sizeof($varName); $i++){

    if($i == sizeof($varName)-1){
      $sql .= "'".htmlspecialchars($_POST[$varName[$i]],ENT_QUOTES)."' ";
      $datato .= "".htmlspecialchars($_POST[$varName[$i]],ENT_QUOTES)." ";
    }else{
      $sql .= "'".htmlspecialchars($_POST[$varName[$i]],ENT_QUOTES)."', ";
      $datato .= "".htmlspecialchars($_POST[$varName[$i]],ENT_QUOTES).", ";
    }

  }
  $sql .= ")";
  $datato .= ")";

  $datafrom = "";
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
  $loghistorySql .= "('".$maxLid."', '".$uid."', 'INSERT', '".$datafrom."', '".$datato."', '".$date."')";
  //echo $loghistorySql;
  mysql_query($loghistorySql);
  
  
  //echo $sql;
  mysql_query($sql);
  
  
  //echo "sizeof(varName) is ".sizeof($varName)."\n<BR>";
  //echo "varName is ".$varName."\n<BR>";

  session_unregister($_SESSION['varName']);
  //session_destroy();
  //echo "_SESSION['varName'] is ".$_SESSION['varName']."\n<BR>";
  //echo "sizeof(varName) is ".sizeof($_SESSION['varName'])."\n<BR>";
  //echo "varName is ".$_SESSION['varName']."\n<BR>";
  //for ( $i = 0; $i < sizeof($_SESSION['varName']); $i++){
    //echo "_SESSION['varName'][i] is ".$_SESSION['varName'][$i]."\n<BR>";
  //}
  
  mysql_close($link);
  
  
  Header("location:slistManage.php");
  exit();
  
  
  
  
  
  
  
?>
