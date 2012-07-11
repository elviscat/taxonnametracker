<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //June 23, 2010 Wednesday::New::Use jQuery AJAX drag and drop function to examine this function
  // ./ current directory
  // ../ up level directory

  session_start();
  //Access control by role
  $role = $_SESSION['role'];
  if( $role != "admin"){
    Header("location:authorizedFail.php");
    exit();
  }
  //Access control by role    
  
  
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



  $selected_users_output = htmlspecialchars($_POST['selected_users_output'],ENT_QUOTES);
  //echo "Variable selected_users_output is <b>".$selected_users_output."</b><br>\n";
  $unselected_users_output = htmlspecialchars($_POST['unselected_users_output'],ENT_QUOTES);
  //echo "Variable unselected_users_output is <b>".$unselected_users_output."</b><br>\n";

  $array_selected_users_output = explode(";", $selected_users_output);
  //echo "Variable array_selected_users_output is <b>".$array_selected_users_output."</b><br>\n"; 
  for($i = 0; $i < sizeof($array_selected_users_output);$i++){  
    $sql_set_to_default_com_mem =  "UPDATE user SET ";
    $sql_set_to_default_com_mem .= " is_def_com_mem = '1' ";
    $sql_set_to_default_com_mem .= " WHERE uid ='".$array_selected_users_output[$i]."'";
    //echo "Variable sql_set_to_default_com_mem is <b>".$sql_set_to_default_com_mem."</b><br>\n";
    $result = mysql_query($sql_set_to_default_com_mem);        
  }
 
  $array_unselected_users_output = explode(";", $unselected_users_output);
  //echo "Variable array_unselected_users_output is <b>".$array_unselected_users_output."</b><br>\n"; 
  for($i = 0; $i < sizeof($array_unselected_users_output);$i++){  
    $sql_unset_to_default_com_mem =  "UPDATE user SET ";
    $sql_unset_to_default_com_mem .= " is_def_com_mem = '0' ";
    $sql_unset_to_default_com_mem .= " WHERE uid ='".$array_unselected_users_output[$i]."'";
    //echo "Variable sql_unset_to_default_com_mem is <b>".$sql_unset_to_default_com_mem."</b><br>\n";
    $result = mysql_query($sql_unset_to_default_com_mem);      
  }  
  mysql_close($link); 
  Header("Location:set_default_com_mem.php")

?>