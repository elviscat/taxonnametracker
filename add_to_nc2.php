<?php
  //Developed by elviscat (elviscat@gmail.com)
  //Jan 28, 2010 Friday::New design
  //./ current directory
  // ../ up level directory
  //!?!?

  //template
  session_start();
  include('template/dbsetup.php'); 
  require('inc/config.inc.php');
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);  
  
  //Customized section of view_sa_reminder.php
  if( !isset($_SESSION['is_login']) ){
    Header("location:loginFail.php");
    exit();
  }
  //echo "Session of role is :: ".$_SESSION['role']."<br>\n";
  

  //Customized section of view_sa_reminder.php
  //Customized section of view_sa_reminder.php

  //Configuration of POST and GET Variables

  $selection2 = htmlspecialchars($_POST['selection2'],ENT_QUOTES);
  //echo "Variable selection2 is :: ".$selection2."<br>\n";

  $option = htmlspecialchars($_POST['option'],ENT_QUOTES);
  //echo "Variable option is :: ".$option."<br>\n";

  $committee_id = htmlspecialchars($_POST['committee_id'],ENT_QUOTES);
  //echo "Variable committee_id is :: ".$committee_id."<br>\n";

  $committee_name = htmlspecialchars($_POST['committee_name'],ENT_QUOTES);
  //echo "Variable committee_name is :: ".$committee_name."<br>\n";

  $committee_note = htmlspecialchars($_POST['committee_note'],ENT_QUOTES);
  //echo "Variable committee_note is :: ".$committee_note."<br>\n";
     
  //Configuration of POST and GET Variables
    

  //template

  if ($option == '1'){
    $array_selection2 = explode(",", $selection2);
    //Find maximun id number in committee_account
    $maxid = 0;
    $max_id_sql = "SELECT (Max(id)+1) FROM committee_account";
		$result_max_id = mysql_query($max_id_sql);	  
    list($maxid) = mysql_fetch_row($result_max_id);
		if($maxid == 0){
		  $maxid = 1;
		}
    for($i = 0; $i < sizeof($array_selection2); $i++){
      $array_selection2_2 = explode(";", $array_selection2[$i]);
      $lv = $array_selection2_2[0];
      $id = $array_selection2_2[1];  

      $sql_insert1 = "INSERT INTO committee_account (`id`, `level`, `account_id`, `ref_c_id`) ";
      $sql_insert1 .= "VALUES ('$maxid','$lv','$id','$committee_id')";
      //echo "sql_insert1 is ".$sql_insert1."<br>\n";
      mysql_query($sql_insert1);
      $maxid++;
    }
    
  }elseif( $option == '2'){
    //Find maximun id number in committee_grp
    $maxid = 0;
    $max_id_sql = "SELECT (Max(id)+1) FROM committee_grp";
		$result_max_id = mysql_query($max_id_sql);	  
    list($maxid) = mysql_fetch_row($result_max_id);
		if($maxid == 0){
		  $maxid = 1;
		}
    $sql_insert1 = "INSERT INTO committee_grp (`id`, `committee_name`, `misc_note`) ";
    $sql_insert1 .= "VALUES ('$maxid','$committee_name','$committee_note')";
    //echo "sql_insert1 is ".$sql_insert1."<br>\n";
    mysql_query($sql_insert1);


    //Find maximun id number in committee_account
    $maxid2 = 0;
    $max_id_sql = "SELECT (Max(id)+1) FROM committee_account";
		$result_max_id = mysql_query($max_id_sql);	  
    list($maxid2) = mysql_fetch_row($result_max_id);
		if($maxid2 == 0){
		  $maxid2 = 1;
		}    
    $ref_c_id = $maxid;  
    $array_selection2 = explode(",", $selection2);
    for($i = 0; $i < sizeof($array_selection2); $i++){
      $array_selection2_2 = explode(";", $array_selection2[$i]);
      $lv = $array_selection2_2[0];
      $id = $array_selection2_2[1];
      

      $sql_insert2 = "INSERT INTO committee_account (`id`, `level`, `account_id`, `ref_c_id`) ";
      $sql_insert2 .= "VALUES ('$maxid2','$lv','$id','$ref_c_id')";
      //echo "sql_insert2 is ".$sql_insert2."<br>\n";
      mysql_query($sql_insert2);
      $maxid2++;
    }    
  }
  Header("location:view_sa_reminder.php?type=without_names_committee");
?>









