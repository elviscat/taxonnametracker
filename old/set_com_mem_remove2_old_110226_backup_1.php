<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //June 30, 2010 Wednesday::New::Use jQuery AJAX drag and drop function to examine this function:: remove user(s) from names committee member list and email function
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

  require('phpmailer/class.phpmailer.php');
  require('inc/config.inc.php');


  $committee_id = htmlspecialchars($_POST['committee_id'],ENT_QUOTES);
  //echo "Variable committee_id is <b>".$committee_id."</b><br>\n";

  
  $email_title = $_POST['email_title'];
  //$email_content = htmlspecialchars($_POST['email_content'],ENT_QUOTES);
  $email_content = stripslashes($_POST['email_content']);

  
  $selected_users_output = htmlspecialchars($_POST['selected_users_output'],ENT_QUOTES);
  //echo "Variable selected_users_output is <b>".$selected_users_output."</b><br>\n";
  $unselected_users_output = htmlspecialchars($_POST['unselected_users_output'],ENT_QUOTES);
  //echo "Variable unselected_users_output is <b>".$unselected_users_output."</b><br>\n";

  $array_unselected_users_output = explode(";", $unselected_users_output);
  //echo "Variable array_unselected_users_output is <b>".$array_unselected_users_output."</b><br>\n"; 
  
  /*
  $max_committee_member_id = 0;
  $sql_max_committee_member_id = "SELECT (Max(id)+1) FROM committee_member";
  $result_max_committee_member_id = mysql_query($sql_max_committee_member_id);	  
  list($max_committee_member_id) = mysql_fetch_row($result_max_committee_member_id);
  if($max_committee_member_id == 0){
    $max_committee_member_id = 1;
  }  
  
  $invited_date = date("Y-m-d");//"2008-08-28"
  //$date = date("Y-m-d H:i:s");//"2008-08-28 11:03:21"
  */
  
  $from_email = $admin_email;
  $from_email_name = $from_email_name;
  
  for($i = 0; $i < sizeof($array_unselected_users_output);$i++){      
    //June 30, 2010 Wednesday::New::Use jQuery AJAX drag and drop function to examine this function:: remove user(s) from names committee member list and email function
    $uid = $array_unselected_users_output[$i];

    $sql_set_to_com_mem =  "UPDATE committee_member SET join_status = 'removed' WHERE ref_c_id = '".$committee_id."' AND user_id ='".$uid."'"; 
    
    //echo "Variable sql_set_to_com_mem is <b>".$sql_set_to_com_mem."</b><br>\n";
    
    $uid = $array_unselected_users_output[$i];
    $user_name = user_name($uid);
    $user_email = user_email($uid);
    
    $eml_address = $user_email;
    $eml_subject = $email_title;
    $eml_content = $email_content;    
    
    //echo $user_name."<br>\n";
    //echo $user_email."<br>\n";
    //echo $eml_address."<br>\n";
    //echo $eml_subject."<br>\n";
    //echo $eml_content."<br>\n";
    
    
    email("slumailrelay.slu.edu", $from_email, $from_email_name, $eml_address, $eml_subject, $eml_content);
    
    /*         
    if(email("slumailrelay.slu.edu", $from_email, $from_email_name, $eml_address, $eml_subject, $eml_content)){
      //$result = mysql_query($sql_set_to_com_mem);
      //$max_committee_member_id++;
      echo "Your message has sent to ".$user_name."!<br>\n";
    }else{
      echo "Fail to send this message!";
    }
    */
    
    $result = mysql_query($sql_set_to_com_mem);
    
    //$max_committee_member_id++;  
  }
  

  
  /*
  $array_unselected_users_output = explode(";", $unselected_users_output);
  //echo "Variable array_unselected_users_output is <b>".$array_unselected_users_output."</b><br>\n"; 
  for($i = 0; $i < sizeof($array_unselected_users_output);$i++){  
    $sql_unset_to_default_com_mem =  "UPDATE user SET ";
    $sql_unset_to_default_com_mem .= " is_def_com_mem = '0' ";
    $sql_unset_to_default_com_mem .= " WHERE uid ='".$array_unselected_users_output[$i]."'";
    //echo "Variable sql_unset_to_default_com_mem is <b>".$sql_unset_to_default_com_mem."</b><br>\n";
    $result = mysql_query($sql_unset_to_default_com_mem);      
  }
  */ 
  mysql_close($link); 
  Header("Location:committee_manage.php")

?>