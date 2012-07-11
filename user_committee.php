<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //June 15, 2010 Tuesday:: NEW:: User Committee actions --> Join or Reject
  // ./ current directory
  // ../ up level directory

  session_start();

  //Access control by login status
  if( !isset($_SESSION['is_login']) ){
    Header("location:authorizedFail.php");
    exit();
  }
  //Access control by login status
     
  include('template/dbsetup.php');

  $cmid = htmlspecialchars($_GET['cmid'],ENT_QUOTES);
  //echo "Variable id is :: ".$id."<br>\n";
  $action = htmlspecialchars($_GET['action'],ENT_QUOTES);
  //echo "Variable action is :: ".$action."<br>\n";


  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);  


  $update_sql ="";
  
  if( $cmid != "" && $action != "" ){

    if( $action == "join" ){
      $update_sql = "UPDATE committee_member SET join_status ='Accept' WHERE cmid ='".$cmid."'";
    }elseif( $action == "reject" ){
      $update_sql = "UPDATE committee_member SET join_status ='Reject' WHERE cmid ='".$cmid."'";
    }else{
      echo "Wrong action! Exit";
    }
    //echo "Variable update_sql is <b>".$update_sql."</b><br>\n";
    $result = mysql_query($update_sql);
    mysql_close($link);
    //Header("Location:slist_table.php")
    Header("Location:view_user_committee_list.php");

  }else{
    echo "Wrong action! Exit";
  }

?>