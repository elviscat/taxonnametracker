<?php
  //Developed by elviscat (elviscat@gmail.com)
  //March 17, 2009 Tuesday:: Logout Page:: Unregister the session!
  //July 13, 2009 Monday:: Logout Page:: Unregister the session!
  //Nov 10, 2009 Tuesday:: Modify the logout.php to logout_already.php
  //April 12, 2010 Monday:: Add the template code section into
  //May 03, 2012 Thursday:: Modification:: Minor change --> change the page_heading font zise from h2 to h3
  // ./ current directory
  // ../ up level directory
  session_start();
  if( isset($_SESSION['is_login']) ){
    Header("location:admin.php");
    exit();
  }
  include('template0.php');
    
  //customized setup
  //Configuration of POST and GET Variables
  //$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "Variable id is :: ".$id."<br>\n";
  //Configuration of POST and GET Variables
    
  $caption = "Logout Page";
  
  //customized setup  
  include('template1.php');

  session_destroy();
  $content = "You have already logged out from this system!";


?>
<!--
		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
-->
        <?php echo "<h3>".$caption."</h3><br>\n"; ?>
        <?php echo $content; ?>

<?php
  include('template2.php'); 
?>

