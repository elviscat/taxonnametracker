<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //June 29, 2010 Tuesday::New::Use jQuery AJAX drag and drop function to examine this function:: invite, re-invite and email function
  //February 26, 2011 Saturday:: Code Logic modification
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


  //$committee_id = htmlspecialchars($_POST['committee_id'],ENT_QUOTES);//Marked on February 26, 2011 Saturday
  //echo "Variable committee_id is <b>".$committee_id."</b><br>\n";//Marked on February 26, 2011 Saturday
  $pid = htmlspecialchars($_POST['pid'],ENT_QUOTES);//New on February 26, 2011 Saturday
  //echo "Variable pid is <b>".$pid."</b><br>\n";//New on February 26, 2011 Saturday

  
  $email_title = $_POST['email_title'];
  //$email_content = htmlspecialchars($_POST['email_content'],ENT_QUOTES);
  $email_content = stripslashes($_POST['email_content']);

  
  $selected_users_output = htmlspecialchars($_POST['selected_users_output'],ENT_QUOTES);
  //echo "Variable selected_users_output is <b>".$selected_users_output."</b><br>\n";
  $unselected_users_output = htmlspecialchars($_POST['unselected_users_output'],ENT_QUOTES);
  //echo "Variable unselected_users_output is <b>".$unselected_users_output."</b><br>\n";

  $array_selected_users_output = explode(";", $selected_users_output);
  //echo "Variable array_selected_users_output is <b>".$array_selected_users_output."</b><br>\n"; 
  
  $max_committee_member_id = 0;
  $sql_max_committee_member_id = "SELECT (Max(cmid)+1) FROM committee_member";
  $result_max_committee_member_id = mysql_query($sql_max_committee_member_id);	  
  list($max_committee_member_id) = mysql_fetch_row($result_max_committee_member_id);
  if($max_committee_member_id == 0){
    $max_committee_member_id = 1;
  }  
  
  $invited_date = date("Y-m-d");//"2008-08-28"
  //$date = date("Y-m-d H:i:s");//"2008-08-28 11:03:21"
  
  $from_email = $admin_email;
  $from_email_name = $from_email_name;
  
  for($i = 0; $i < sizeof($array_selected_users_output);$i++){      
    //June 29, 2010 Tuesday::New::Use jQuery AJAX drag and drop function to examine this function:: invite, re-invite and email function
    //Check this user is in removed status in this names committee member(s) list?
    $uid = $array_selected_users_output[$i];
    $is_removed = 0;
    
    //$sql_is_removed = "SELECT * FROM committee_member WHERE ref_c_id = '".$committee_id."' AND user_id ='".$uid."'";//Marked on February 26, 2011 Saturday
    $sql_is_removed = "SELECT * FROM committee_member WHERE ref_pid = '".$pid."' AND ref_uid ='".$uid."'";//New on February 26, 2011 Saturday
    
    //echo "Variable sql_is_removed is <b>".$sql_is_removed."</b><br>\n";
    $result_is_removed = mysql_query($sql_is_removed);
    if(mysql_num_rows($result_is_removed) > 0){
      while ( $nb_is_removed = mysql_fetch_array($result_is_removed) ) {
        if( $nb_is_removed[4] == "Removed" ){
          $is_removed = 1;
        }
      }
    }
    if( $is_removed == 0 ){
      //$sql_set_to_com_mem =  "INSERT INTO committee_member (`id`,`user_id`,`ref_c_id`,`invited_date`,`join_status`,`rank_level`)";//Marked on February 26, 2011 Saturday
      $sql_set_to_com_mem =  "INSERT INTO committee_member (`cmid`,`ref_uid`,`ref_pid`,`invited_date`,`join_status`,`rank_level`)";//New on February 26, 2011 Saturday
      
      //$sql_set_to_com_mem .= " VALUES ('$max_committee_member_id','$array_selected_users_output[$i]','$committee_id','$invited_date','pending','member')";//Marked on February 26, 2011 Saturday
      $sql_set_to_com_mem .= " VALUES ('$max_committee_member_id','$array_selected_users_output[$i]','$pid','$invited_date','Pending','Member')";//New on February 26, 2011 Saturday
      
    }elseif( $is_removed == 1 ){
      //$sql_set_to_com_mem =  "UPDATE committee_member SET join_status = 'pending' WHERE ref_c_id = '".$committee_id."' AND user_id ='".$uid."'";//Marked on February 26, 2011 Saturday
      $sql_set_to_com_mem =  "UPDATE committee_member SET join_status = 'Pending' WHERE ref_pid = '".$pid."' AND ref_uid ='".$uid."'";//New on February 26, 2011 Saturday
      
    }    
    //echo "Variable sql_set_to_com_mem is <b>".$sql_set_to_com_mem."</b><br>\n";
    
    $uid = $array_selected_users_output[$i];
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
    
    
    //email("slumailrelay.slu.edu", $from_email, $from_email_name, $eml_address, $eml_subject, $eml_content);
    
    /*         
    if(email("slumailrelay.slu.edu", $from_email, $from_email_name, $eml_address, $eml_subject, $eml_content)){
      //$result = mysql_query($sql_set_to_com_mem);
      //$max_committee_member_id++;
      echo "Your message has sent to ".$user_name."!<br>\n";
    }else{
      echo "Fail to send this message!";
    }
    */
    
    //echo $sql_set_to_com_mem;
    //echo "pid is".$pid;
    //$result = mysql_query($sql_set_to_com_mem);
    mysql_query($sql_set_to_com_mem);
    $max_committee_member_id++;  
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
  //Header("Location:committee_manage.php")//Marked on February 26, 2011 Saturday
  Header("Location:view_completelist_comm_mem.php?pid=".$pid);//New on February 26, 2011 Saturday

?>