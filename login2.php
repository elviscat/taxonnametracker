<?php
  //Developed by elviscat (elviscat@gmail.com)
  //March 17, 2009 Tuesday:: Login check for mexico meeting demo system
  //Nov 10, 2009 Tuesday:: modified on the admin login
  //./ current directory
  // ../ up level directory
  //!?!?
  session_start();
  
  $userName = $_POST['loginname'];
  $password = $_POST['password'];
  
  include('template/dbsetup.php');
  require('inc/config.inc.php');

  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
    if( $userName == $admin_login_name ){
      //
      if( $password == $admin_password){
        //Admin login success
        //now set the session from here if needed
        $_SESSION['username'] = $userName;
		    $_SESSION['role'] = "admin"; 
		    $_SESSION['is_login'] = true;
        Header("location:admin.php");
      }else{
        //Admin login fail
        Header("location:loginFail.php");
      }
    }else{
      //now validating the username and password
      $sql = "SELECT uid, username, passwd, actlevel FROM user WHERE username='".$userName."'";
      $result = mysql_query($sql);
      $row = mysql_fetch_array($result);
      //if username exists
      if( mysql_num_rows($result) > 0){
        //compare the user_name and password
		    if( strcmp($row['passwd'],$password ) == 0){
	        if( $row[actlevel] == 0){
              Header("location:needactivation.php");
              exit;
          }else{
			      //now set the session from here if needed
            $_SESSION['username'] = $userName;
			      $_SESSION['role'] = "user"; 
			      $_SESSION['is_login'] = true;
			      //$_SESSION['aaa'] = "YES";
            $_SESSION['uid'] = $row['uid'];
            //
            if( !isset($_SESSION['sid']) ){
              Header("location:admin.php");
            }else{
              Header("location:changePropose.php?gid=".$_SESSION['gid']."");
	          }
          }
		    }else{
		      Header("location:loginFail.php");
		    }
      }else{
        Header("location:loginFail.php");
      }
	  }
?>











