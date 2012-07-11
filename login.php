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
    
  $caption = "Log In";
  
  //customized setup  
  include('template1.php');



?>
<!--
		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
-->
        <?php echo "<h3>".$caption."</h3><br>\n"; ?>
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

<?php
  include('template2.php'); 
?>


