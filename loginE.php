<?php
  //Developed by elviscat (elviscat@gmail.com)
  //February 26, 2011 Saturday::NEW::Login via email attached link
  // ./ current directory
  // ../ up level directory

  session_start();
  
  include('template/dbsetup.php');
  require('inc/config.inc.php');  
  
  $t = htmlspecialchars($_GET['t'],ENT_QUOTES);//Type
  //New on February 26, 2011 Saturday
  //echo "Variable t is <b>".$t."</b><br>\n";//New on February 26, 2011 Saturday  
  $l = htmlspecialchars($_GET['l'],ENT_QUOTES);//Login Name
  //New on February 26, 2011 Saturday
  //echo "Variable l is <b>".$l."</b><br>\n";//New on February 26, 2011 Saturday
  $p = htmlspecialchars($_GET['p'],ENT_QUOTES);//Login Password
  //New on February 26, 2011 Saturday
  //echo "Variable p is <b>".$p."</b><br>\n";//New on February 26, 2011 Saturday  
  $d = htmlspecialchars($_GET['d'],ENT_QUOTES);//Destination
  //New on February 26, 2011 Saturday
  //echo "Variable d is <b>".$d."</b><br>\n";//New on February 26, 2011 Saturday
  $pp = htmlspecialchars($_GET['pp'],ENT_QUOTES);//Pointer
  //New on February 26, 2011 Saturday
  //echo "Variable pp is <b>".$pp."</b><br>\n";//New on February 26, 2011 Saturday    
  
  //Type Definition:: Here we define type as different login way to login into Taxon Tracker via email attached link
  //Type1::to "view_completelist_comm_mem.php" w/(with) pid
  
  $destination = "";
  if ($t == "1"){
    $destination = "view_completelist_comm_mem.php?pid=";
  }
  
  $match_l = md5($admin_login_name);
  $match_p = md5($admin_password);
  $match_d = md5($destination);
  
  //echo "match_l is".$match_l."<br>\n";
  //echo "match_p is".$match_p."<br>\n";
  //echo "match_d is".$match_d."<br>\n";

  //http://maydenlab.slu.edu/~hwu5/taxonnametracker/loginE.php?t=1&l=21232f297a57a5a743894a0e4a801fc3&p=9d71b242d881694e9ff1ab95fac8ca4d&d=e34ad8ee4dbfd33309a9fb04e779d1d2&pp=1

  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  if( $l == $match_l ){
    //Administrator validation
    //echo "l match match_l";
    
    if( $p == $match_p ){
      //echo "p match match_p";
      //Admin login success
      //now set the session from here if needed
      $_SESSION['username'] = $userName;
		  $_SESSION['role'] = "admin"; 
		  $_SESSION['is_login'] = true;
      if( $d == $match_d ){
        //echo "Success";
        Header("location:".$destination.$pp);
      }else{
        //Admin login fail
        //echo "Fail";
        Header("location:loginFail.php");        
      }
    }else{
      //Admin login fail
      //echo "Fail";
      Header("location:loginFail.php");
    }
  }else{
    //Admin login fail
    //echo "Fail";
    Header("location:loginFail.php");  
    //General user validation
    
    
    /*
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
    */
	}
  
  
?>
