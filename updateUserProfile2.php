<?php 
  session_start();
  include('template/dbsetup.php');
  require('phpmailer/class.phpmailer.php');
  require('inc/config.inc.php');
  
  //Developed by elviscat
  //July 13, 2009 Monday
  //Mar 14, 2010 Sunday:: add two column information
  //April 05, 2010 Monday:: add "require('inc/config.inc.php');"
  //April 07, 2010 Wednesday:: modify on jquery alert, remark it
  
  //$submitString = chr($submitString);
  //echo "hexdec(\"40\") is ".dechex(%40)."<BR>\n";


  //$test = "hwu5%40%39slu.edu%23ascfff%34FGH";
  //$test = hexToAsciiToString($test);
  //echo $test."<BR>\n";
  //get the posted values
  $submitString = htmlspecialchars($_POST['submitString'],ENT_QUOTES);
  //echo "utf8_encode(%40) is ".utf8_encode(%40)."<BR>\n";
  //echo "chr(%40) is ".chr(%40)."<br>";
  //echo "submitString is ::".$submitString."\n<BR>";

  $submitStringArray = explode("&amp;", $submitString);

  $loginname;
  $password;
  $password_new;
  $password_new_confirm;
  $real_name;
  $org;
  $tel;
  $fax;
  //$eml;
  $is_asih = 0;
  $is_afs = 0;

  for ($i =0 ; $i < sizeof($submitStringArray); $i++){
    //echo "submitStringArray[".$i."] is ".$submitStringArray[$i]."\n<br>";
    $submitStringArray2 = explode("=", $submitStringArray[$i]);
    if($submitStringArray2[0] == 'loginname'){
      $loginname = $submitStringArray2[1];
      $loginname = hexToAsciiToString($loginname);
    }
    if($submitStringArray2[0] == 'password'){
      $password = $submitStringArray2[1];
      $password = hexToAsciiToString($password);
    }
    if($submitStringArray2[0] == 'password_new'){
      $password_new = $submitStringArray2[1];
      $password_new = hexToAsciiToString($password_new);
    }
    if($submitStringArray2[0] == 'password_new_confirm'){
      $password_new_confirm = $submitStringArray2[1];
      $password_new_confirm = hexToAsciiToString($password_new_confirm);
    }
    if($submitStringArray2[0] == 'real_name'){
      $real_name = $submitStringArray2[1];
      $real_name = hexToAsciiToString($real_name);
      //echo "real_name is ".$real_name."\n<BR";
    }  
    if($submitStringArray2[0] == 'org'){
      $org = $submitStringArray2[1];
      $org = hexToAsciiToString($org);
    }
    if($submitStringArray2[0] == 'tel'){
      $tel = $submitStringArray2[1];
      $tel = hexToAsciiToString($tel);
    }
    if($submitStringArray2[0] == 'fax'){
      $fax = $submitStringArray2[1];
      $fax = hexToAsciiToString($fax);
    }
    //if($submitStringArray2[0] == 'eml'){
    //  $eml = $submitStringArray2[1];
    //  $eml = hexToAsciiToString($eml);
    //}      
    if($submitStringArray2[0] == 'is_asih'){
      $is_asih = $submitStringArray2[1];
      $is_asih = hexToAsciiToString($is_asih);
    }
    if($submitStringArray2[0] == 'is_afs'){
      $is_afs = $submitStringArray2[1];
      $is_afs = hexToAsciiToString($is_afs);
    }
    
    //echo "is_asih is ".$is_asih."<br>\n";
    //echo "is_afs is ".$is_afs."<br>\n";
    
    /*
    for ($j =0 ; $j < sizeof($submitStringArray2); $j++){
      echo "submitStringArray2[".$j."] is ".$submitStringArray2[$j]."\n<br>";
    }
    */ 
  }

  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  //if( $loginname == "" || $real_name == "" || $org == "" || $tel == "" || $fax == "" || $eml == "" ){
  if( $loginname == "" || $real_name == "" || $org == "" || $tel == "" || $fax == "" ){
    echo "You need to fill out all fields.\n";
  }else{
    if($password != ""){
      if($password_new == "" || $password_new_confirm == ""){
        echo "You need to fill out new password and its confirmation.";
      }else{
        if($password_new != $password_new_confirm){
          echo "New Password and New Password Again should be the same!";
        }else{
          echo "You can update the new password!";
          $update_sql =  "UPDATE user SET ";
          $update_sql .= " passwd = '".$password_new."' ";
          $update_sql .= " WHERE uid ='".$_SESSION['uid']."'";
          //echo "update_sql is ".$update_sql."\n<br>";
          $result = mysql_query($update_sql);
        }
      }
    }
    $update_sql =  "UPDATE user SET ";
    $update_sql .= " username = '".$loginname."', name ='".$real_name."', ";
    $update_sql .= " addr ='".$org."', tel='".$tel."', fax='".$fax."'";
    //$update_sql .= " addr ='".$org."', tel='".$tel."', fax='".$fax."', eml ='".$eml."'";
    $update_sql .= " WHERE uid ='".$_SESSION['uid']."'";
    //echo "update_sql is ".$update_sql."\n<br>";
    $result = mysql_query($update_sql);
    
    //if($is_asih == "1"){
      $update_sql =  "UPDATE user SET ";
      $update_sql .= " is_asih = '".$is_asih."'";
      $update_sql .= " WHERE uid ='".$_SESSION['uid']."'";
      //echo "update_sql is ".$update_sql."\n<br>";
      $result = mysql_query($update_sql);     
    //}

    //if($is_afs == "1"){
      $update_sql =  "UPDATE user SET ";
      $update_sql .= " is_afs = '".$is_afs."'";
      $update_sql .= " WHERE uid ='".$_SESSION['uid']."'";
      //echo "update_sql is ".$update_sql."\n<br>";
      $result = mysql_query($update_sql);     
    //}    
    
    
    
    echo "Your data has been updated!";        
  }
  mysql_close($link); 
?>
