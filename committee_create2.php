<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 17, 2009 Tuesday:: Change or edit content of names committee
  // ./ current directory
  // ../ up level directory
  session_start();
 
  $accounts = htmlspecialchars($_POST['accounts'],ENT_QUOTES);
  //echo "accounts is :: ".$accounts."<br>\n";
  $committee_name = htmlspecialchars($_POST['committee_name'],ENT_QUOTES);
  //echo "committee_name is :: ".$committee_name."<br>\n";
  $committee_note = htmlspecialchars($_POST['committee_note'],ENT_QUOTES);
  //echo "committee_note  is :: ".$committee_note ."<br>\n";
  
  /*
  header("Cache-control: private");
  session_cache_limiter("none");
  */
  
  
  include('template/dbsetup.php');

  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  
  mysql_query("SET NAMES 'utf8'");
  mysql_query("SET CHARACTER_SET_CLIENT=utf8");
  mysql_query("SET CHARACTER_SET_RESULTS=utf8");
  
  //include('template0.php');

  //
  $maxid = 0;
  $max_id_sql = "SELECT (Max(id)+1) FROM committee_grp";
  $result_max_id = mysql_query($max_id_sql);	  
  list($maxid) = mysql_fetch_row($result_max_id);
  if($maxid == 0){
    $maxid = 1;
  }          

  //
  
  $regdate = date('Y-m-d');
  $regtime = date('H:i:s');
  //date: 0000-00-00
  //time: 00:00:00 
  
  $insert_sql = "INSERT INTO committee_grp (`id`, `committee_name`, `misc_note`) ";
  $insert_sql .= "VALUES ('$maxid','$committee_name','$committee_note')";
  //echo "Variabie insert_sql is <b>".$insert_sql."</b><br>\n";
  $result=mysql_query($insert_sql);
  
  $max_committee_account_id = 0;
  $sql_max_committee_account_id = "SELECT (Max(id)+1) FROM committee_account";
  $result_max_committee_account_id = mysql_query($sql_max_committee_account_id);	  
  list($max_committee_account_id) = mysql_fetch_row($result_max_committee_account_id);
  if($max_committee_account_id == 0){
    $max_committee_account_id = 1;
  }
  
  $array_accounts = explode(",", $accounts);
  //echo "Variable accounts is <b>".$accounts."</b><br>\n"; 
  for($i = 0; $i < sizeof($array_accounts);$i++){
    
    $array_accounts2 = explode(":", $array_accounts[$i]);
    $sql_insert_committee_account = "INSERT INTO committee_account (`id`, `level`, `account_id`, `ref_c_id`)";
    $sql_insert_committee_account .= "VALUES ('$max_committee_account_id','$array_accounts2[0]','$array_accounts2[1]','$maxid')";
    //echo "Variabie sql_insert_committee_account is <b>".$sql_insert_committee_account."</b><br>\n";
    $result_insert_committee_account = mysql_query($sql_insert_committee_account);
    $max_committee_account_id++;          
  }
  
  
  
  mysql_close($link); 
  Header("Location:committee_manage.php")

?>