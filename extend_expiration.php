<?php
  //Developed by elviscat (elviscat@gmail.com)
  //Jan 22, 2010 Friday::New design
  //./ current directory
  // ../ up level directory
  //!?!?
  session_start();
  
  $selection = htmlspecialchars($_POST['selection'],ENT_QUOTES);
  $selection = substr($selection, 0, -1);
  //echo "Variable selection is :: ".$selection."<br>\n";

  include('template/dbsetup.php');
  require('inc/config.inc.php');

  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  
  $array_selection = explode(";", $selection);
  for($i = 0; $i < sizeof($array_selection); $i++){
  	$array_selection2 = explode(",", $array_selection[$i]);
    //echo "The first in ".$i." is :: ".$array_selection2[0]."<br>\n";
    //echo "The second in ".$i." is :: ".$array_selection2[1]."<br>\n";
    //echo "The third in ".$i." is :: ".$array_selection2[2]."<br>\n";
    
    $pid = $array_selection2[0];
    $pexpiration = $array_selection2[1];
    $extend_days = $array_selection2[2];
    
    $timestamp_pexpiration = strtotime($pexpiration);
    //$timestamp_pexpiration = strtotime('2010-01-22');
    //echo "1::".$timestamp_pexpiration."<br>\n";
    //echo "2::".strtotime('2010-01-10');
    
    //$today = strtotime("2010-01-22");
    $date_time_array = getdate($timestamp_pexpiration);
    $hours = $date_time_array["hours"];
    $minutes = $date_time_array["minutes"];
    $seconds = $date_time_array["seconds"];
    $month = $date_time_array["mon"];
    $day = $date_time_array["mday"];
    $year = $date_time_array["year"];
    // 用mktime()函數重新產生Unix時間戳值
    // 增加19小時
    //$timestamp = mktime($hours + 19, $minutes,$seconds ,$month, $day,$year);
    //echo strftime( "%Hh%M %A %d %b",$timestamp);
    //echo "br~E after adding 19 hours";
    $timestamp = mktime($hours, $minutes,$seconds ,$month, $day + $extend_days, $year);
    //echo strftime("%Y-%m-%d %H:%i:%s",$timestamp);
    $new_expiration = date("Y-m-d",$timestamp);    
    
    
    $update_sql = "UPDATE post SET pexpiration ='".$new_expiration."' WHERE pid ='".$pid."'";
    //echo "Variable update_sql is :: ".$update_sql."<br>\n";
    mysql_query($update_sql);
    Header("location:view_sa_reminder.php?type=expired");
  }

?>











