<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //July 15, 2009 Wednesday:: View the user profile
  //Mar 14, 2010 Sunday:: add two column information
  //Mar 17, 2010 Wednesday:: modification on updating new template part code
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
  $uid = htmlspecialchars($_GET['uid'],ENT_QUOTES);
  //Configuration of POST and GET Variables  
  
  $caption = $application_caption;
  $caption2 = "View User Profile<BR>\n";
  $title = $application_caption."::".$caption2;
  //template  
  
  $loginname;
  $password;
  $real_name;
  $org;
  $tel;
  $fax;
  $eml;
  $is_asih;
  $is_afs;
  


  $data_check = "No";
  $data_check_sql = "SELECT * FROM user WHERE uid ='".$uid."'";
  //echo "data_check_sql is ".$data_check_sql."/n<br>";
  $result_data_check = mysql_query($data_check_sql);
  if(mysql_num_rows($result_data_check) > 0){
    while ( $nb_data_check = mysql_fetch_array($result_data_check) ) {
      $data_check = "Yes";
      $loginname = $nb_data_check[1];
      $password = $nb_data_check[2];
      $real_name = $nb_data_check[3];
      $org = $nb_data_check[4];
      $tel = $nb_data_check[5];
      $fax = $nb_data_check[6];
      $eml = $nb_data_check[7];
      $is_asih = $nb_data_check[15];
      $is_afs = $nb_data_check[16];
    }
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
        <form id="updateForm" action="#" method="post">
          <table>
            <tr>
              <td colspan=2><p>User Information</p></td>
            </tr>
            <tr>
              <td ><label>Login Name</label></td>
              <td ><input name="loginname" type="text" value="<?php echo $loginname; ?>" readonly /></td>
            </tr>
            <tr>
              <td ><label>Name</label></td>
              <td ><input name="real_name" type="text" value="<?php echo $real_name; ?>" readonly /><br></td>
            </tr>
            <tr>
              <td ><label>Organization</label></td>
              <td ><input name="org" type="text" value="<?php echo $org; ?>" readonly /><br></td>
            </tr>
            <tr>
              <td ><label>Telephone Number</label></td>
              <td ><input name="tel" type="text" value="<?php echo $tel; ?>" readonly /><br></td>
            </tr>
            <tr>
              <td ><label>Fax Number</label></td>
              <td ><input name="fax" type="text" value="<?php echo $fax; ?>" readonly /><br></td>
            </tr>                                                
            <tr>
              <td ><label>E-mail Address</label></td>
              <td ><input name="eml" type="text" value="<?php echo $eml; ?>" readonly /><br></td>
            </tr>            
            <tr>
              <td ><label>Is American Society of Ichthyology and Herpetology Member?</label></td>
              <td ><input name="is_asih" type="checkbox" value="1" <?php if($is_asih == "1"){ echo "checked"; }?>/><br></td>
            </tr>
            <tr>
              <td ><label>Is American Fisheries Society Member?</label></td>
              <td ><input name="is_afs" type="checkbox" value="1" <?php if($is_afs == "1"){ echo "checked"; }?>/><br></td>
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










