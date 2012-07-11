<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //April 05, 2010 Monday:: add template code section
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
  $caption2 = "Register/Sign Up";
  $title = $application_caption."::".$caption2;
  //template


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
    
    <script type="text/javascript" src="jquery/jquery-1.3.2.js"></script>
    <script type="text/javascript" src="jquery/jquery.form.js"></script>
    <script>
    function submit() {
      var submitString = $('#signupForm').formSerialize();
      $.post("signup2.php",
      {submitString:submitString},
	    function(data){//do something
	      if( data == "You need to fill out all fields." || data == "You need to type the same password in password and password again field." || data == "You need to type another liginame since your loginame has been registered by another user."){
	        alert(data);
	      }else{
	        alert(data);
            //$('#msg').html(data);
	        document.location='index.php';
	      }
	    });
	  }
    $(document).ready(function(e){
      $('#signupForm').ajaxForm(submit);	
    });
    </script>
 
	</head>
  <body id="dt_example">
		<div id="container">	
			<h1><? echo $caption; ?></h1>
      <?php
        include("menu.php");
      ?>
      <h2><?php echo $caption2; ?></h2>
      <div id="demo">
        <form id="signupForm" action="#" method="post">
          <table>
            <tr>
              <td colspan=2><p>Please fill out the following information</p></td>
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
              <td ><label>Password Again</label></td>
              <td ><input name="password_confirm" type="password" /><br></td>
            </tr>
            <tr>
              <td ><label>Name</label></td>
              <td ><input name="real_name" type="text" /><br></td>
            </tr>
            <tr>
              <td ><label>Organization</label></td>
              <td ><input name="org" type="text" /><br></td>
            </tr>
            <tr>
              <td ><label>Telephone Number</label></td>
              <td ><input name="tel" type="text" /><br></td>
            </tr>
            <tr>
              <td ><label>Fax Number</label></td>
              <td ><input name="fax" type="text" /><br></td>
            </tr>                                                
            <tr>
              <td ><label>E-mail Address</label></td>
              <td ><input name="eml" type="text" /><br></td>
            </tr>
            <tr>
              <td ><label>Is American Society of Ichthyology and Herpetology Member?</label></td>
              <td ><input name="is_asih" type="checkbox" value="1" <?php if($is_asih == "1"){ echo "checked"; }?>/><br></td>
            </tr>
            <tr>
              <td ><label>Is American Fisheries Society Member?</label></td>
              <td ><input name="is_afs" type="checkbox" value="1" <?php if($is_afs == "1"){ echo "checked"; }?>/><br></td>
            </tr>
            <tr>
              <td colspan=2><button  type="submit" onclick="confirmation(); return false;">Sign Up</button></td>
            </tr>
          </table>
        </form>
      </div>
			<div id="msg"></div>
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










