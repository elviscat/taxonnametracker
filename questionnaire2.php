<?php
	//Developed by elviscat (elviscat@gmail.com)
	//April 12, 2010 Monday:: New:: questionnarie form step 2
	//May 12, 2012 Wednesday:: Modification:: Align the code
	
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
	$att1 = htmlspecialchars($_POST['att1'],ENT_QUOTES);
	//echo "\$att1 is :: ".$att1."<br>\n";
	$att2 = htmlspecialchars($_POST['att2'],ENT_QUOTES);
	//echo "\$att2 is :: ".$att2."<br>\n";
	$att3 = htmlspecialchars($_POST['att3'],ENT_QUOTES);
 	//echo "\$att3 is :: ".$att3."<br>\n";
	
	
	$att4 = $_POST['att4'];
	//$att4 = htmlspecialchars($_POST['att4'],ENT_QUOTES);
	//echo "\$att4 is :: ".$att4."<br>\n";
	$att4_2 = "";
	
	$count=count($att4);
	for($i = 0;$i < $count;$i++){
		$att4_2 .= $att4[$i].";";
	}
	$att4_3 = substr($att4_2, 0, -1);
	//echo "\$att4_3 is :: ".$att4_3."<br>\n";

	$att5 = htmlspecialchars($_POST['att5'],ENT_QUOTES);
	//echo "\$att5 is :: ".$att5."<br>\n";
	$att6 = htmlspecialchars($_POST['att6'],ENT_QUOTES);
	//echo "\$att6 is :: ".$att6."<br>\n";
	$att7 = htmlspecialchars($_POST['att7'],ENT_QUOTES);
	//echo "\$att7 is :: ".$att7."<br>\n";
	$att8 = htmlspecialchars($_POST['interest'],ENT_QUOTES);
	//echo "\$att8 is :: ".$att8."<br>\n";
	//Configuration of POST and GET Variables
	
	
	//template
	
	$sql_ref_uid = "SELECT uid FROM user WHERE username = '".$_SESSION['username']."'";
	$result_ref_uid = mysql_query ($sql_ref_uid);
	if(mysql_num_rows($result_ref_uid) > 0){
		while ( $nb_ref_uid = mysql_fetch_array($result_ref_uid) ) {
			$ref_uid = $nb_ref_uid[0];
		}
	}
	
	$sql_questionnaire = "SELECT * FROM user_questionnaire WHERE ref_uid = '".$ref_uid."'";
	//echo $sql_questionnaire;
	$result_questionnaire = mysql_query ($sql_questionnaire);
	if(mysql_num_rows($result_questionnaire) > 0){
		$update_sql =  "UPDATE user_questionnaire SET ";
		$update_sql .= " att1 = '".$att1."', att2 ='".$att2."', ";
		$update_sql .= " att3 = '".$att3."', att4 ='".$att4_3."', ";
		$update_sql .= " att5 = '".$att5."', att6 ='".$att6."', ";
		$update_sql .= " att7 = '".$att7."', att8 ='".$att8."' ";
		$update_sql .= " WHERE ref_uid ='".$ref_uid."'";
		//echo "\$update_sql is ".$update_sql."\n<br>";
		$result = mysql_query($update_sql);
	}else{
		$maxid = 0;
		$sql_maxid = "SELECT (Max(id)+1) FROM user_questionnaire";
		$result_maxid = mysql_query($sql_maxid);
		list($maxid) = mysql_fetch_row($result_maxid);
		if($maxid == 0){
			$maxid = 1;
		}
	$insert_sql = "INSERT INTO user_questionnaire (id,att1, att2, att3, att4, att5, att6, att7, ref_uid, att8)";
	$insert_sql .= " VALUES ('$maxid','$att1','$att2','$att3','$att4_3', '$att5', '$att6', '$att7', '$ref_uid', '$att8')";
	//echo "\$insert_sql is ".$insert_sql."\n<br>";
	$result=mysql_query($insert_sql);
	//echo "Yes, you can insert into database!";
	}
	mysql_close($link); 
	Header("location:questionnaire.php");
	
?>
