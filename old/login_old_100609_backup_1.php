<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Jan 26, 2010 Tuesday:: add template code section
  // ./ current directory
  // ../ up level directory
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

  //Configuration of POST and GET Variables
  //$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "Variable id is :: ".$id."<br>\n";
  //Configuration of POST and GET Variables
    
  $caption = $application_caption;
  $caption2 = "Log In";
  $title = $application_caption."::".$caption2;
  //template

  //Developed by elviscat
  //March 11, 2009 Tues
  //echo "session[aaa] is ".$_SESSION['aaa']."<BR>";
  
  //echo "session[isLogin] is ".$_SESSION['isLogin']."<BR>";
  
  //if ($_SESSION['lsLogin'] == True) {
  //  echo "TRUE";
  //}else{
  //  echo "FALSE";
  //}
  
  //echo "Hello<BR>";
  //echo "session[username] is ".$_SESSION['username']."<BR>";
  //echo "session[uid] is ".$_SESSION['uid']."<BR>";
        /*
        if( !isset($_SESSION['is_login']) ){
          //echo "<h2><a href=\"login.php\">Login</a></h2>";
        }else{
          //echo "<h2><a href=\"logout.php\">Logout</a></h2>";
          Header("location:admin.php");
          exit();
        }
        */
  /*
  if( !isset($_SESSION['is_login']) ){
    //do nothing
  }else{
    echo "You don't need go to this page!!";
    Header("location:admin.php");
    exit();
  }
  */
  
  if( isset($_SESSION['is_login']) ){
    Header("location:admin.php");
    exit();
  }
  
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
    <meta name="Description" content="Saint Louis University, tissue, species information" />
    <meta name="Keywords" content="Saint Louis University, tissue, information" />
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <!--<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />-->
    <meta name="Distribution" content="Global" />
    <meta name="Author" content="Richard Mayden - cypriniformes@gmail.com, Elvis Hsin-Hui Wu - hwu5@slu.edu" />
    <meta name="Robots" content="index,follow" />
    <link rel="stylesheet" href="edit.css" type="text/css" /><!--Does this file edit.css should be keep?-->	
    <!--<link rel="shortcut icon" type="image/ico" href="http://www.sprymedia.co.uk/media/images/favicon.ico" />-->
		<title><? echo $title; ?></title>
		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
	</head>
  <body id="dt_example">
		<div id="container">	
			<h1><? echo $caption; ?></h1>
      <?php
        include("menu.php");
      ?>
      <h2><?php echo $caption2; ?></h2>
      <div id="demo">
        <form id="loginForm" action="login2.php" method="post">
          <table>
            <tr>
              <td colspan=2><p>Please type your login name and password!</p></td>
            </tr>
            <tr>
              <td ><label>Login Name</label></td>
              <td ><input name="loginname" type="text" /></td>
            </tr>
            <tr>
              <td ><label>Password</label></td>
              <td ><input name="password" type="password" /><br></td>
            </tr>
            <tr>
              <td colspan=2><button  type="submit">Submit</button></td>
            </tr>
            <tr>
              <td colspan=2>New user? <a href="signup.php">Sign Up</a></td>
            </tr>
            <tr>
              <td colspan=2>Forgot password? <a href="requestpasswd.php">Request Password</a></td>
            </tr>            
          </table>
        </form>
      </div>
			<div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
  </body>
</html>

<!--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Description" content="Saint Louis University, tissue, species information" />
<meta name="Keywords" content="Saint Louis University, tissue, information" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="Distribution" content="Global" />
<meta name="Author" content="Richard Mayden - cypriniformes@gmail.com, Elvis Hsin-Hui Wu - hwu5@slu.edu" />
<meta name="Robots" content="index,follow" />
<link rel="stylesheet" href="edit.css" type="text/css" />-->

<!--
<script src="/jquery/jquery.js" type="text/javascript" language="javascript"></script>
<script src="/jquery/jquery.form.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
  // wait for the DOM to be loaded 
  /*
  $(document).ready(function() { 
    // bind 'speciesEditor' and provide a simple callback function 
    $(#loginForm').ajaxSubmit(function() {  
      return false; 
    });        
  });
  */
</script>-->
<!--<title><? //echo $title; ?></title>
</head>
<body>
  <div id="basic" class="myform">
    <h3><? //echo $title; ?></h3>

    <div align="center"><a href="index.php">Back to Homepage</a></div>      
  </div>
</body>
</html>-->










