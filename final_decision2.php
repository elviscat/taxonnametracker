<?php 
	//Developed by elviscat (elviscat@gmail.com)
	//February 26, 2011 Saturday::NEW::Final Decision
	//July 06, 2012 Friday::Logic Modification
	// ./ current directory
	// ../ up level directory
	
	session_start();
	
	//$uid = htmlspecialchars($_POST['uid'],ENT_QUOTES);
	//echo "\$user_id is <b>".$user_id."</b><br>\n";
	
	
	
	$pid = htmlspecialchars($_POST['pid'],ENT_QUOTES);//New on February 26, 2011 Saturday
	//echo "\$pid is <b>".$pid."</b><br>\n";//New on February 26, 2011 Saturday
	//$ref_c_id = htmlspecialchars($_POST['ref_c_id'],ENT_QUOTES);//Marked on February 26, 2011 Saturday
	//echo "\$ref_c_id is <b>".$ref_c_id."</b><br>\n";//Marked on February 26, 2011 Saturday
	//$is_voted = htmlspecialchars($_POST['is_voted'],ENT_QUOTES);//Marked on February 26, 2011 Saturday
	//echo "\$is_voted is <b>".$is_voted."</b><br>\n";//Marked on February 26, 2011 Saturday
	$final_decision = htmlspecialchars($_POST['final_decision'],ENT_QUOTES);
	//echo "\$vote_opinion is <b>".$vote_opinion."</b><br>\n";
	$decision_summary = htmlspecialchars($_POST['decision_summary'],ENT_QUOTES);
	//echo "\$vote_desc is <b>".$vote_desc."</b><br>\n";

	/*
	header("Cache-control: private");
	session_cache_limiter("none");
	*/
	include('inc/config.inc.php');
	include('template/dbsetup.php');
	require('phpmailer/class.phpmailer.php');
	
	//Connect to database
	$link = mysql_connect($host , $dbuser ,$dbpasswd); 
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	//select database
	mysql_select_db($dbname);
	
	mysql_query("SET NAMES 'utf8'");
	mysql_query("SET CHARACTER_SET_CLIENT=utf8");
	mysql_query("SET CHARACTER_SET_RESULTS=utf8");
	
	
	
	//February 26, 2011 Saturday::Final Decision Logic
	$maxcmid = 0;
	$sql_maxcmid = "SELECT MAX(cmid) FROM committee_member";
	$result_maxcmid = mysql_query ($sql_maxcmid) or die ("Invalid query");
	if( mysql_num_rows( $result_maxcmid) > 0 ){
		while ( $nb_maxcmid = mysql_fetch_array($result_maxcmid)) {
			$maxcmid = $nb_maxcmid[0] + 1;
			//echo "maxcmid is ".$maxcmid."<br>";
		}
	}else{
		$maxcmid = 1;
	}
	
	
	//echo "maxLid is ".$maxPid."<br>";
	$date = date("Y-m-d H:i:s");//"2008-08-28 11:03:21"
	
	//Step 1:: insert this final decision into committee_member
	$sql = "INSERT INTO `taxon_name_tracker`.`committee_member` (`cmid` ,`ref_uid` ,`ref_pid` ,`invited_date` ,`join_status` ,`rank_level` ,`vote_opinion` ,`vote_desc`) VALUES ";
 	$sql .= "('".$maxcmid."', '0', '".$pid."', '".$date."', 'Accept', 'Admin', '".$final_decision."', '".$decision_summary."')";
	//echo "\$sql is <b>".$sql."</b><br>\n";
	
	mysql_query($sql) or die ("Invalid query:: \$sql");
	
	
	//Step 2: make TABLE::post--> pstate=="Closed"
	$sql_update_pstate_p_final_decision = "UPDATE post SET pstate ='Closed', p_final_decision = '".$final_decision."' WHERE pid =".$pid;
	//echo "\$sql_update_pstate_p_final_decision is <b>".$sql_update_pstate_p_final_decision."</b><br>\n";
	
	mysql_query($sql_update_pstate_p_final_decision) or die ("Invalid query:: \$sql_update_pstate_p_final_decision");
	
	
	
	
	/**
	Marked on July 06, 2012 Friday, Replaced by new logic
	*/
	//Step 3: Execute operation script in this post
  	
  	/*
	$ptype = "";
	$p_operation_script = "";
	$sql_p_operation_script = "SELECT ptype, p_operation_script FROM post WHERE pid='".$pid."'";
	$result_p_operation_script = mysql_query ($sql_p_operation_script) or die ("Invalid query");
	if( mysql_num_rows( $result_p_operation_script) > 0 ){
		while ( $nb_p_operation_script = mysql_fetch_array($result_p_operation_script)) {
			//echo $nb_p_operation_script[0];
			//echo $nb_p_operation_script[1];
			$ptype = $nb_p_operation_script[0];
			$p_operation_script = $nb_p_operation_script[1];
		}
	}
	
	$array_p_operation_script = explode(":", $p_operation_script);
	
	if($ptype == "type1"){
		$maxsid = 0;
		$sql_maxsid = "SELECT MAX(sid) FROM slist";
		$result_maxsid = mysql_query ($sql_maxsid) or die ("Invalid query");
		if( mysql_num_rows( $result_maxsid) > 0 ){
			while ( $nb_maxsid = mysql_fetch_array($result_maxsid)) {
				$maxsid = $nb_maxsid[0] + 1;
				//echo "maxsid is ".$maxsid."<br>";
			}
		}else{
			$maxsid = 1;
		}
		
		$execute_p_operation_script = "";
		if( $final_decision == "Yes" ){
			//echo $array_p_operation_script[0]."<br>\n";
			$execute_p_operation_script = $array_p_operation_script[0]; 
		}else{
			//echo $array_p_operation_script[1]."<br>\n";
			$execute_p_operation_script = $array_p_operation_script[1]; 
		}
		$execute_p_operation_script = str_replace("'1'", "'".$maxsid."'", $execute_p_operation_script);
		//echo "111 :: ".$execute_p_operation_script."<br>\n";
		mysql_query($execute_p_operation_script);
		
	}
	//$pid = get_pid_from_committee_id($ref_c_id);
	//July 02, 2010 Friday:: New Actions
	*/
	/**
	Marked on July 06, 2012 Friday, Replaced by new logic
	*/
	
	
	
	
	
	//Step 3: Execute operation script in this post
	
	//echo "\$uid is ".$uid."<br />\n";
	
	//echo "\$pid is ".$pid."<br />\n";
	//echo "\$final_decision is ".$final_decision."<br />\n";
	//echo "\$decision_summary is ".$decision_summary."<br />\n";
	$ptype;
	$p_operation_script;
	
	$sql_post = "SELECT * FROM post WHERE pid='".$pid."'";
	$result_post = mysql_query ($sql_post) or die ("Invalid query:: \$sql_post");
	if( mysql_num_rows( $result_post) > 0 ){
		while ( $nb_post = mysql_fetch_array($result_post)) {
			$ptype = $nb_post['ptype'];
			$p_operation_script = $nb_post['p_operation_script'];
		}
	}
	
	if($ptype == "type1"){
		if($final_decision == "Approve"){
			//echo "\$p_operation_script is ".$p_operation_script."<br />\n";
			mysql_query($p_operation_script) or die ("Invalid query:: \$p_operation_script");
		}
	}else if($ptype == "type2"){
		if($final_decision == "Approve"){
			//echo "\$p_operation_script is ".$p_operation_script."<br />\n";
			mysql_query($p_operation_script) or die ("Invalid query:: \$p_operation_script");
		}
	}
	
	
	mysql_close($link); 
	Header("Location:viewpost.php?pid=".$pid."")
	
?>
