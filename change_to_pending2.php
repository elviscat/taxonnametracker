<?php
	session_start();
	
	session_start();
	//Access control by role
	$role = $_SESSION['role'];
 	if( $role != "admin" && $_SESSION['is_login'] == True){
		Header("location:authorizedFail.php");
		exit();
	}
	
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
	$pid = htmlspecialchars($_POST['pid'],ENT_QUOTES);
	//echo "\$pid is :: ".$pid."<br>\n";
	$sumbit_from_form = htmlspecialchars($_POST['submit_from_form'],ENT_QUOTES);
	//echo "\$sumbit_from_form is :: ".$sumbit_from_form."<br>\n";
	$change = htmlspecialchars($_POST['change'],ENT_QUOTES);
	//echo "\$change is :: ".$change."<br>\n";  
	//Configuration of POST and GET Variables
	
	
	if($pid != '' && $sumbit_from_form == '1'){
		if($change == '1'){
			$sql_update =  "UPDATE post SET pstate ='Pending' WHERE pid = ".$pid." and pstate = 'Under Review'";
			//echo "\$sql_update is ".$sql_update."<br>\n";
			$result = mysql_query($sql_update) or die("Invalid query:: \$sql_update");
		}else{
			//Not change the state
			Header("Location:admin_proposal_management.php");
		}
	}else{
		echo "Invalid Access!";
		exit();
	}
	mysql_close($link);
	Header("Location:admin_proposal_management.php");
	
 	
	
?>


