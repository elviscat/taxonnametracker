<?php
  //Developed by elviscat (elviscat@gmail.com)
  //Jan 26, 2010 Tuesday:: add template code section
  //June 09, 2010 Wednesday:: Apply to new layout
  //February 26, 2011 Saturday::NEW::Login modification
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
    
  $caption = "Log Error";
  
  //customized setup  
  include('template1.php');



?>
<!--
		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
-->
        <?php echo "<h3>".$caption."</h3><br>\n"; ?>
        <?php echo "You need to use the right login name and password to login!<br>\n"; ?>

<?php
  include('template2.php'); 
?>


