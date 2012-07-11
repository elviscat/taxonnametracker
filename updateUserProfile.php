<?php
	
	//Author Information
	//Developed by elviscat (elviscat@gmail.com)
	
	
	//Code Change Logs
	//July 13, 2009 Monday:: Update the user profile using AJAX
	//July 15, 2009 Wednesday:: Minor modification, text editing
	//March 14, 2010 Sunday:: add two column information
	//May 02, 2012 Wednesday:: Apply this page to new template
	
	// ./ current directory
	// ../ up level directory
	
	
	include('template0.php');//DB Connetion and Configuration Setup
	
	
	//Customized Setup
	//Configuration of POST and GET Variables
	//$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	//echo "\$id is :: ".$id."<br>\n";
	//Configuration of POST and GET Variables
	
	$page_title = "Update Your Profile :: ";//Don't change the variable name
	$page_heading = "Update Your Profile :: ";//Don't change the variable name
	
	//Put the code for this page HERE!
	
	session_start();
	
	if( (!isset($_SESSION['is_login'])) ){
		Header("location:authorizedFail.php");
		exit();
	}
	if( (!isset($_SESSION['uid'])) ){
		Header("location:authorizedFail.php");
		exit();
	}
	
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
	$data_check_sql = "SELECT * FROM user WHERE uid ='".$_SESSION['uid']."'";
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
	
	
	//Put the code for this page HERE!
	//Customized Setup
	
	include('template1.php');//head, title, basic javascript, body, sidebar until "div:mainContent"
	
?>
    <!-- Put Extra Javascript References and Javascript Code Here! -->
    <script type="text/javascript" src="jquery/jquery-1.3.2.js"></script>
    <script type="text/javascript" src="jquery/jquery.form.js"></script>
    <script>
    function submit() {
      var submitString = $('#updateForm').formSerialize();
      $.post("updateUserProfile2.php",
      {submitString:submitString},
	    function(data){//do something
	    alert(data);
      //$('#msg').html(data);
	    //new behavior
      });
	  }
    $(document).ready(function(e){
      $('#updateForm').ajaxForm(submit);	
    });
    </script>    
    <!-- Put Extra Javascript References and Javascript Code Here! -->
    <?php echo "<h3>".$page_heading."</h3><br>\n"; ?>
    <!-- Put Actual Html Code and PHP code for this page Here! -->
    
    <div id="demo">
    	<form id="updateForm" action="#" method="post">
        <table>
        	<tr>
        		<td colspan=2><p>Please fill out the following information</p></td>
        	</tr>
            <tr>
        		<td ><label>Login Name</label></td>
        		<td ><input name="loginname" type="text" value="<?php echo $loginname; ?>" readonly /></td>
        	</tr>
        	<tr>
        		<td ><label>Name</label></td>
        		<td ><input name="real_name" type="text" value="<?php echo $real_name; ?>" /><br></td>
        	</tr>
        	<tr>
        		<td ><label>Organization</label></td>
        		<td ><input name="org" type="text" value="<?php echo $org; ?>" /><br></td>
        	</tr>
        	<tr>
        		<td ><label>Telephone Number</label></td>
        		<td ><input name="tel" type="text" value="<?php echo $tel; ?>" /><br></td>
        	</tr>
        	<tr>
        		<td ><label>Fax Number</label></td>
        		<td ><input name="fax" type="text" value="<?php echo $fax; ?>" /><br></td>
        	</tr>
        	<!--
        	<tr>
        		<td ><label>E-mail Address</label></td>
        		<td ><input name="eml" type="text" value="<?php echo $eml; ?>" /><br></td>
        	</tr>
        	-->
        	<tr>
        		<td ><label>Is American Society of Ichthyology and Herpetology Member?</label></td>
        		<td ><input name="is_asih" type="checkbox" value="1" <?php if($is_asih == "1"){ echo "checked"; }?>/><br></td>
        	</tr>
        	<tr>
        		<td ><label>Is American Fisheries Society Member?</label></td>
        		<td ><input name="is_afs" type="checkbox" value="1" <?php if($is_afs == "1"){ echo "checked"; }?>/><br></td>
        	</tr>
        	<tr>
        		<td colspan=2>Change your password</td>
        		</tr>
        	<tr>
        		<td ><label>Password</label></td>
        		<td ><input name="password" type="password" /><br></td>
        	</tr>
        	<tr>
        		<td ><label>New Password</label></td>
        		<td ><input name="password_new" type="password" /><br></td>
        	</tr>
        	<tr>
        		<td ><label>New Password Again</label></td>
        		<td ><input name="password_new_confirm" type="password" /><br></td>
        	</tr>
        	<tr>
        		<td colspan=2><button  type="submit" onclick="confirmation(); return false;">Update</button></td>
        	</tr>
        </table>
        </form>
	</div>
	<div class="spacer"></div>
    
    <!-- Put Actual Html Code and PHP code for this page Here! -->

<?php
	include('template2.php');//end of div:mainContent, footer, php mysql connection close
?>




