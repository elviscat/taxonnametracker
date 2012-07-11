<?php
  //Developed by elviscat (elviscat@gmail.com)
  //April 05, 2010 Monday:: add template code section
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
    
  $caption = "Register/Sign Up";
  
  //customized setup  
  include('template1.php');



?>
<!--
		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
-->

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


        <?php echo "<h2>".$caption."</h2><br>\n"; ?>
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

<?php
  include('template2.php'); 
?>


