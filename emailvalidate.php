<?php
	
	//Author Information
	//Developed by elviscat (elviscat@gmail.com)
	
	
	//Code Change Logs
	//Previous development records are lost
	//Start from now
	//April 05, 2010 Monday:: add template code section
	//July 07, 2012 Saturday:: adopt to new template, check the logic
	
	// ./ current directory
	// ../ up level directory
	
	
	include('template0.php');//DB Connetion and Configuration Setup
	
	
	//Customized Setup
	//Configuration of POST and GET Variables
	$actkey = htmlspecialchars($_GET['key'],ENT_QUOTES);
	//echo "\$actkey is ".$actkey."<BR>\n";
	$q = htmlspecialchars($_GET['q'],ENT_QUOTES);
	//echo "\$q is ".$q."<BR>\n";
	//Configuration of POST and GET Variables
	
	$caption = "Email Validation";//Don't change the variable name
	

	//Put the code for this page HERE!

	$user_id = base64_decode($q);
	
	$is_activated;
	
	$sql_is_activated = "SELECT * FROM user WHERE uid = ".$user_id;
	//echo "\$sql_is_activated is ".$sql_is_activated."<br>\n";
	$result_is_activated = mysql_query($sql_is_activated);
	if(mysql_num_rows($result_is_activated) > 0){
		while ( $nb_is_activated = mysql_fetch_array($result_is_activated) ) {
			$is_activated = $nb_is_activated['actlevel'];
		}
	}
  
	$output_message = "";
	if( $is_activated == '1' ){
		$output_message = "Your account has been activated already!<br><br>You need to go to <a href=\"login.php\">login</a> page to log into Taxon Name Tracker!<br>";
	}else{
		$sql_check_act_key = "SELECT * FROM user WHERE uid = ".$user_id." AND actkey = '".$actkey."'";
		//echo "\$sql_check_act_key is ".$sql_check_act_key."<br>\n";
		$result_check_act_key = mysql_query($sql_check_act_key);
		if(mysql_num_rows($result_check_act_key) > 0){
			$sql_update = "UPDATE user SET actlevel = '1' WHERE uid =".$user_id;
			//echo "\$sql_update is ".$sql_update."<br>\n";
			//mysql_query($sql_update) or die("");
			if(mysql_query($sql_update)){
				$output_message = "Your account is activated now! Go to <a href=\"login.php\">login</a> page to log into Taxon Name Tracker!<br>";
			}else{
				$output_message = "Your activation key is not correct. Please make sure your activation key again or <a href=\"requestkey.php\">request the key again</a>.";
			}
		}else{
			$output_message = "Your activation key is not correct. Please make sure your activation key again or <a href=\"requestkey.php\">request the key again</a>.";
		}
	}
	
  	
  	
	//Put the code for this page HERE!
	//Customized Setup
	
	include('template1.php');//head, title, basic javascript, body, sidebar until "div:mainContent"
	
?>
	<!-- Put Extra Javascript References and Javascript Code Here! -->
	
	<!-- Put Extra Javascript References and Javascript Code Here! -->
	
	<?php echo "<h3>".$caption."</h3><br>\n"; ?>
	
	<!-- Put Actual Html Code and PHP code for this page Here! -->
	
	<?php
		echo $output_message;
	?>	
	<!-- Put Actual Html Code and PHP code for this page Here! -->



<?php
	include('template2.php');//end of div:mainContent, footer, php mysql connection close
?>
















