<?php
	
	//Author Information
	//Developed by elviscat (elviscat@gmail.com)
	
	
	//Code Change Logs
	//Previous development records are lost
	//Start from now
	//July 06, 2012 Friday::
	
	
	// ./ current directory
	// ../ up level directory
	
	session_start();
	//Access control by role
	$role = $_SESSION['role'];
 	if( $role != "admin" && $_SESSION['is_login'] == True){
		Header("location:authorizedFail.php");
		exit();
	}
	
	
	
	include('template0.php');//DB Connetion and Configuration Setup
	
	

	
	//Customized Setup
	//Configuration of POST and GET Variables
	$pid = htmlspecialchars($_GET['pid'],ENT_QUOTES);
	//echo "\$pid is :: ".$pid."<br>\n";
	//Configuration of POST and GET Variables
	
	if($pid == ''){
		echo "Invalid \$pid\n";
		exit();
	}
	
	$sql_post = "SELECT * FROM post WHERE pid = ".$pid;
	//echo "\$sql_post is <b>".$sql_post."</b><br>\n";
  	$result_post = mysql_query($sql_post);
	if(mysql_num_rows($result_post) > 0){
		while ( $nb_post = mysql_fetch_array($result_post) ) {
			if($nb_post['pstate'] != 'Under Review'){
				echo "This proposal is not on \"Under Review\" status!\n";
				exit();
			}
		}
	}
	$caption = "Change this proposal from \"Under Review\" to \"Pending\"?";//Don't change the variable name
	
	//Put the code for this page HERE!
	
	//Put the code for this page HERE!
	//Customized Setup
	
	include('template1.php');//head, title, basic javascript, body, sidebar until "div:mainContent"
	
?>
	<!-- Put Extra Javascript References and Javascript Code Here! -->
	
	<!-- Put Extra Javascript References and Javascript Code Here! -->
	
	<?php echo "<h3>".$caption."</h3><br>\n"; ?>
	
	<!-- Put Actual Html Code and PHP code for this page Here! -->
	<form id="state_changing_form" action="change_to_pending2.php" method="post">
		<input name="pid" type="hidden" value="<?php print $pid; ?>" />
        <input name="submit_from_form" type="hidden" value="1" />
        <input class="text" type="radio" name="change" value="1">Change<br>
        <input class="text" type="radio" name="change" value="0" checked="checked">Don't change<br>
		<button  type="submit">Submit</button></td>
	</form>
	<!-- Put Actual Html Code and PHP code for this page Here! -->



<?php
	include('template2.php');//end of div:mainContent, footer, php mysql connection close
?>





