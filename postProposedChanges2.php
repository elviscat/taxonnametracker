<?php 
  session_start();
  include('template/dbsetup.php');
  require('phpmailer/class.phpmailer.php');
  require('inc/config.inc.php');

  //Developed by elviscat (elviscat@gmail.com)
  //March 15, 2009 Sunday:: post the proposed changes or suggestted name changes interface:: insert into the table-->post
  //March 15, 2009 Sunday:: add the column:: ptype to record these two types of post--> proposed changes or suggestted name changes
  //July 16, 2009 Thursday::
  //Jan 13, Wednesday:: Testing and modification
  //Jan 26, 2010 Tuesday:: logic modification and add javascript to prevent null selection
  //Mar 10, 2010 Wednesday:: add new upload module into this page
  //Mar 17, 2010 Wednesday:: refactoring
  //June 18, 2010 Friday:: Integration with names committee
  //June 25, 2010 Friday:: Modification on integration with names committee
  //July 01, 2010 Thursday:: Refactoring
  //February 23, 2010 Wednesday:: NEW:: New Test on Specific Nomenclature Changes Proposal
  //May 02, 2012 Wednesday:: Modification
  //July 05, 2012 Thursday:: Change the logic!
  //July 06, 2012 Friday:: Change the logic!
  
  
  // ./ current directory
  // ../ up level directory

  //$submitString = chr($submitString);
  //echo "hexdec(\"40\") is ".dechex(%40)."<BR>\n";



  //$test = "hwu5%40%39slu.edu%23ascfff%34FGH";
  //$test = hexToAsciiToString($test);
  //echo $test."<BR>\n";
  //get the posted values
  //$submitString = htmlspecialchars($_POST['submitString'],ENT_QUOTES);
  //echo "utf8_encode(%40) is ".utf8_encode(%40)."<BR>\n";
  //echo "chr(%40) is ".chr(%40)."<br>";
  //echo "submitString is ::".$submitString."\n<BR>";

  //$submitStringArray = explode("&amp;", $submitString);

  $prefuid = htmlspecialchars($_POST['prefuid'],ENT_QUOTES);
  $preflv = htmlspecialchars($_POST['preflv'],ENT_QUOTES);
  $prefsid = htmlspecialchars($_POST['prefsid'],ENT_QUOTES);
  //$ptitle = htmlspecialchars($_POST['ptitle'],ENT_QUOTES);
  $ptitle = "";
  $ptype = htmlspecialchars($_POST['ptype'],ENT_QUOTES);

  $pcontent = htmlspecialchars($_POST['pcontent'],ENT_QUOTES);
  $pcontent = stripslashes($pcontent);  
  $pcontent = hexToAsciiToString($pcontent);//好像沒有需要耶...  
  
  
  
  //$test = htmlspecialchars($_POST['test'],ENT_QUOTES);
  //echo $test;
  
  
  /*
  $hide_script = htmlspecialchars($_POST['hide_script'],ENT_QUOTES);  
  $hide_script = stripslashes($hide_script);
  $hide_script = base64_encode($hide_script);
  */

  $attachment = htmlspecialchars($_POST['attachment'],ENT_QUOTES);
  $attachment_check = substr($attachment, -1);
  if( $attachment_check == ";"){
    $attachment = substr($attachment, 0, -1);
  }

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

  $maxPid = 0;
  $maxPidSql = "SELECT MAX(pid) FROM post";
  $result = mysql_query ($maxPidSql) or die ("Invalid query");
  if( mysql_num_rows( $result) > 0 ){
	  while ( $nb2 = mysql_fetch_array($result)) {
		  $maxPid = $nb2[0] + 1;
		  //echo "maxPid is ".$maxPid."<br>";
	  }
  }else{
    $maxPid = 1;
  }

  $maxSid = 0;
  $maxSidSql = "SELECT MAX(sid) FROM slist";
  $result = mysql_query ($maxSidSql) or die ("Invalid query:: \$maxSidSql");
  if( mysql_num_rows( $result) > 0 ){
    while ( $nb = mysql_fetch_array($result)) {
     $maxSid = $nb[0] + 1;
     //echo "maxSid is ".$maxSid."<br>";
	}
  }else{
    $maxSid = 1;
  }
  
  
  
  $sfamily = htmlspecialchars($_POST['sfamily'],ENT_QUOTES);
  $sgenus = htmlspecialchars($_POST['sgenus'],ENT_QUOTES);
  $sspecies = htmlspecialchars($_POST['sspecies'],ENT_QUOTES);
  $sauthor = htmlspecialchars($_POST['sauthor'],ENT_QUOTES);
  $scommon_name = htmlspecialchars($_POST['scommon_name'],ENT_QUOTES);
  
  
  
  
  
  
  
  
  
  
  
  if( $ptype == "type1" ){//If ptype equal "type1", then include all new species information in the following...

	$new_footnote_list = "";
	$footnote_list = footnote('species', $prefsid);
	if($footnote_list != ""){
		$new_footnote_list = $footnote_list.";".$maxPid;
	}else{
		$new_footnote_list = $maxPid;
	}
	$sql_update_footnote_to_original_taxon = "UPDATE `taxon_name_tracker`.`slist` SET `footnote` ='".$new_footnote_list."' WHERE sid='".$prefsid."'";
	//echo "\$sql_update_footnote_to_original_taxon is :: ".$sql_update_footnote_to_original_taxon."<BR>\n";
	
	
	mysql_query($sql_update_footnote_to_original_taxon);
    
    
    

    
    
    //$ori_species_name = htmlspecialchars($_POST['ori_species_name'],ENT_QUOTES);
    
    $ori_species_name = $_POST['ori_species_name'];
    //echo "ori_species_name ".$ori_species_name."<br>\n";
    
    $ptitle = "New Species <i>".$sgenus." ".$sspecies."</i> is described out of <i>".$ori_species_name."</i>.";
    
    //echo "\$ptitle is : ".$ptitle."<br />\n";
    //exit();
    //echo $sgenus;
    //echo $sspecies."<br>\n";
    

    
    //$p_operation_script_1 = "INSERT INTO `taxon_name_tracker`.`slist` (`sid` ,`sfamily` ,`sgenus` ,`sspecies` ,`sauthor` ,`sloc` ,`scommon_name` ,`scnam1` ,`scnam2` ,`scnam3` ,`is_valid` ,`synonym_of`, `footnote`) VALUES ";
    //$p_operation_script_1 .= "(\'$maxSid\', \'".$sfamily."\', \'".$sgenus."\', \'".$sspecies."\', \'".$sauthor."\', \'\', \'".$scommon_name."\', \'\', \'\', \'\', \'Yes\', \'0\', \'$maxPid\')";
    //('391', '1', '2', '3', '4', '5', 'abc;def', '7', '8', '9', '10', '11');
    //echo "\$p_operation_script_1 is <b>".$p_operation_script_1."</b><br />\n";
    //$p_operation_script_2 = "INSERT INTO `taxon_name_tracker`.`slist` (`sid` ,`sfamily` ,`sgenus` ,`sspecies` ,`sauthor` ,`sloc` ,`scommon_name` ,`scnam1` ,`scnam2` ,`scnam3` ,`is_valid` ,`synonym_of`, `footnote`) VALUES ";
    //$p_operation_script_2 .= "(\'$maxSid\', \'".$sfamily."\', \'".$sgenus."\', \'".$sspecies."\', \'".$sauthor."\', \'\', \'".$scommon_name."\', \'\', \'\', \'\', \'No\', \'".$prefsid."\', \'$maxPid\')";
    //echo "\$p_operation_script_2 is <b>".$p_operation_script_2."</b><br />\n";
    //exit();
    $sql_insert_new = "INSERT INTO `taxon_name_tracker`.`slist` (`sid` ,`comes_from` ,`goes_to` ,`sfamily` ,`sgenus` ,`sspecies` ,`sauthor` ,`sloc` ,`scommon_name` ,`scnam1` ,`scnam2` ,`scnam3` ,`synonym_of` ,`is_valid` ,`footnote`) VALUES ";
    //$sql_insert_new .= "(\'$maxSid\', \'$prefsid\', \'".$sfamily."\', \'".$sgenus."\', \'".$sspecies."\', \'".$sauthor."\', \'\', \'".$scommon_name."\', \'\', \'\', \'\', \'1\', \'0\', \'$maxPid\')";
	//$sql_insert_new .= "('$maxSid', '$prefsid', '".$sfamily."', '".$sgenus."', '".$sspecies."', '".$sauthor."', '', '".$scommon_name."', '', '', '', '1', '0', '$maxPid')";
	
	$sql_insert_new .= "('$maxSid', '0', '0', '".$sfamily."', '".$sgenus."', '".$sspecies."', '".$sauthor."', '', '".$scommon_name."', '', '', '', '".$prefsid."', '0', '$maxPid')";
	
	//echo "\$sql_insert_new is <b>".$sql_insert_new."</b><br />\n";
	
	
    $p_operation_script = "UPDATE `taxon_name_tracker`.`slist` SET synonym_of = 0, is_valid = 1 WHERE sid =".$maxSid;
    //echo "\$p_operation_script is <b>".$p_operation_script."</b><br />\n";	
	
	
	mysql_query($sql_insert_new);
	
	
	
	
	
  }elseif( $ptype == "type2" ){ 
    
	
    //$test = $_POST['test'];
    //echo "\$test is : ".$test."<br />\n";
    $target_species_id = $_POST['target_species_id'];
    
    
    
    //echo "\$target_species_id is : ".$target_species_id."<br />\n";
    
    
    
    
    
    
    
    
	$new_footnote_list = "";
	$footnote_list = footnote('species', $target_species_id);
	if($footnote_list != ""){
		$new_footnote_list = $footnote_list.";".$maxPid;
	}else{
		$new_footnote_list = $maxPid;
	}
	$sql_update_footnote_to_target_taxon = "UPDATE `taxon_name_tracker`.`slist` SET `footnote` ='".$new_footnote_list."' WHERE sid='".$target_species_id."'";
	//echo "\$sql_update_footnote_to_target_taxon is :: ".$sql_update_footnote_to_target_taxon."<BR>\n";
	
	mysql_query($sql_update_footnote_to_target_taxon);
	
	
	
	
	$new_footnote_list = "";
	$footnote_list = footnote('species', $prefsid);
	if($footnote_list != ""){
		$new_footnote_list = $footnote_list.";".$maxPid;
	}else{
		$new_footnote_list = $maxPid;
	}
	$sql_update_footnote_to_original_taxon = "UPDATE `taxon_name_tracker`.`slist` SET `footnote` ='".$new_footnote_list."' WHERE sid='".$prefsid."'";
	//echo "\$sql_update_footnote_to_original_taxon is :: ".$sql_update_footnote_to_original_taxon."<BR>\n";
    
    
    mysql_query($sql_update_footnote_to_original_taxon);
    
    
    
 
    
    
    
    
    
    
    $ptitle = "This Species <i>".taxon_name_without_level('species', $prefsid)."</i> is synonymized with <i>".taxon_name_without_level('species', $target_species_id)."</i>";
    //echo "\$title is : ".$ptitle."<BR />\n";
    //exit();
	
	
	
	
	//sid 	comes_from 	goes_to 	sfamily 	sgenus 	sspecies 	sauthor 	sloc 	scommon_name 	scnam1 	scnam2 	scnam3 	synonym_of 	is_valid 	footnote
    $sfamily;
    $sgenus;
    $sspecies;
    $sauthor;
    $sloc;
    $scommon_name;
    $scnam1;
    $scnam2;
    $scnam3;
    $synonym_of;
    $is_valid;
    $footnote;
	
    $sql_row_copy = "SELECT * FROM slist WHERE sid = ".$prefsid;
    //echo "\$sql_row_copy is ".$sql_row_copy."<br />\n";
    $result_row_copy = mysql_query ($sql_row_copy) or die ("Invalid query:: \$sql_row_copy");
  	if( mysql_num_rows( $result_row_copy) > 0 ){
		while ( $nb_row_copy = mysql_fetch_array($result_row_copy)) {
    		$sfamily = $nb_row_copy['sfamily'];
    		$sgenus = $nb_row_copy['sgenus'];
    		$sspecies = $nb_row_copy['sspecies'];
    		$sauthor = $nb_row_copy['sauthor'];
    		$sloc = $nb_row_copy['sloc'];
    		$scommon_name = $nb_row_copy['scommon_name'];
    		$scnam1 = $nb_row_copy['scnam1'];
    		$scnam2 = $nb_row_copy['scnam2'];
    		$scnam3 = $nb_row_copy['scnam3'];
    		$synonym_of = $nb_row_copy['synonym_of'];
    		$is_valid = $nb_row_copy['is_valid'];
    		$footnote = $nb_row_copy['footnote'];
		}
	}
    
    
    
    $sql_insert_new = "INSERT INTO `taxon_name_tracker`.`slist` (`sid` ,`comes_from` ,`goes_to` ,`sfamily` ,`sgenus` ,`sspecies` ,`sauthor` ,`sloc` ,`scommon_name` ,`scnam1` ,`scnam2` ,`scnam3` ,`synonym_of` ,`is_valid` ,`footnote`) VALUES ";
    //$sql_insert_new .= "(\'$maxSid\', \'$prefsid\', \'".$sfamily."\', \'".$sgenus."\', \'".$sspecies."\', \'".$sauthor."\', \'\', \'".$scommon_name."\', \'\', \'\', \'\', \'1\', \'0\', \'$maxPid\')";
	//$sql_insert_new .= "('$maxSid', '$prefsid', '".$sfamily."', '".$sgenus."', '".$sspecies."', '".$sauthor."', '', '".$scommon_name."', '', '', '', '1', '0', '$maxPid')";
	
	$sql_insert_new .= "('$maxSid', '".$prefsid."', '0', '".$sfamily."', '".$sgenus."', '".$sspecies."', '".$sauthor."', '".$sloc."', '".$scommon_name."', '".$scnam1."', '".$scnam2."', '".$scnam3."', '".$synonym_of."', '".$is_valid."', '".$footnote."')";
	
	//echo "\$sql_insert_new is <b>".$sql_insert_new."</b><br />\n";
	
	
	
    $p_operation_script = "UPDATE `taxon_name_tracker`.`slist` SET synonym_of = ".$target_species_id.", is_valid = 0 WHERE sid =".$maxSid;
    //echo "\$p_operation_script is <b>".$p_operation_script."</b><br />\n";
	
	
	
	
	mysql_query($sql_insert_new);



	$sql_update_goes_to_to_original_taxon = "UPDATE slist SET goes_to = '".$maxSid."' WHERE sid= '".$prefsid."'";
    //echo "\$sql_update_goes_to_to_original_taxon is <b>".$sql_update_goes_to_to_original_taxon."</b><br />\n";
    mysql_query($sql_update_goes_to_to_original_taxon);
    
    
    
  }
  
  
  //echo "the ptitle is ".$ptitle."<br>\n";
  //echo "the pcontent is ".$pcontent."<br>\n";
  //echo "the pattchment is ".$attachment."<br>\n";
  
  /*
  for ($i =0 ; $i < sizeof($submitStringArray); $i++){
    //echo "submitStringArray[".$i."] is ".$submitStringArray[$i]."\n<br>";
    $submitStringArray2 = explode("=", $submitStringArray[$i]);
    if($submitStringArray2[0] == 'prefuid'){
      $prefuid = $submitStringArray2[1];
      $prefuid = hexToAsciiToString($prefuid);
    }
    if($submitStringArray2[0] == 'prefsid'){
      $prefsid = $submitStringArray2[1];
      $prefsid = hexToAsciiToString($prefsid);
    }
    if($submitStringArray2[0] == 'preflv'){
      $preflv = $submitStringArray2[1];
      $preflv = hexToAsciiToString($preflv);
    }
    if($submitStringArray2[0] == 'ptitle'){
      $ptitle = $submitStringArray2[1];
      $ptitle = hexToAsciiToString($ptitle);
    }
    if($submitStringArray2[0] == 'ptype'){
      $ptype = $submitStringArray2[1];
      $ptype = hexToAsciiToString($ptype);
    }
    if($submitStringArray2[0] == 'dsrte_text'){
      $dsrte_text = $submitStringArray2[1];
      $dsrte_text = urldecode($dsrte_text);
      $dsrte_text = hexToAsciiToString($dsrte_text);
      //echo "real_name is ".$real_name."\n<BR";
    }        
    if($submitStringArray2[0] == 'attachment'){
      $attachment = $submitStringArray2[1];
      $attachment = hexToAsciiToString($ptype);
    }
    //
    //for ($j =0 ; $j < sizeof($submitStringArray2); $j++){
    //  echo "submitStringArray2[".$j."] is ".$submitStringArray2[$j]."\n<br>";
    //}
    //
  }
  */


  //echo "maxLid is ".$maxPid."<br>";
  /*
  $pcontent;
  if ( isset($dsrte_text) ){
    //$dsrte_text = str_replace('\\', '', $dsrte_text);
    //$dsrte_text = str_replace('"', "", $dsrte_text);
    //echo "<div style=\"border:1px dotted black\">";
    //echo "Generated HTML:<pre>".htmlentities( $_POST['dsrte_text'])."</pre>";
    //echo "Generated HTML:<pre>".$_POST['dsrte_text']."</pre>";
    //echo "</div>";
    //$pcontent =  htmlentities($dsrte_text);
    $pcontent =  $dsrte_text;
  }
  */
  



  $date = date("Y-m-d H:i:s");//"2008-08-28 11:03:21"

  /**Time Drift*/
  $timestamp = time();
  //echo strftime( "%Hh%M %A %d %b",$timestamp);
  //echo "p";
  //echo strftime("%Y-%m-%d %H:%i:%s",$timestamp);

  /**Test*/
  //echo $initime;
  //echo "<BR>";
  /**Test*/

  $date_time_array = getdate($timestamp);
  $hours = $date_time_array["hours"];
  $minutes = $date_time_array["minutes"];
  $seconds = $date_time_array["seconds"];
  $month = $date_time_array["mon"];
  $day = $date_time_array["mday"];
  $year = $date_time_array["year"];
  // 用mktime()函數重新產生Unix時間戳值Using mktime() function regenerate UNIX timestamp value
  // 增加19小時increase 19 hours
  //$timestamp = mktime($hours + 19, $minutes,$seconds ,$month, $day,$year);
  //echo strftime( "%Hh%M %A %d %b",$timestamp);
  //echo "br~E after adding 19 hours";
  $timestamp = mktime($hours, $minutes,$seconds ,$month, $day + 180,$year);
  //echo strftime("%Y-%m-%d %H:%i:%s",$timestamp);

  /**Test*/
  //echo date("Y-m-d H:i:s",$timestamp);
  /**Test*/

  /**Time Drift*/
  $expirationtime = date("Y-m-d H:i:s",$timestamp);



  if( $preflv == "" && $prefsid == ""){
    echo "This post doesn't belong any taxon entry/account. Please back to name list to select a taxon entry/account!<BR>\n";
    exit();
    //Header("location:nullpost.php");
  }elseif ( $ptitle == "" || $pcontent == ""){
    //Header("location:nullpost.php");
    echo "You need to type title OR content in this post!<BR>\n";
    exit();
  }else{
    //insert_sql statement
    $insert_post_sql = "INSERT INTO post (`pid` ,`ptitle` ,`pcontent` ,`pcredate` ,`prefuid` ,`pref_taxa` ,`ptype` ,`pcount` ,`ptag` ,`pcategory` ,`pstate` ,`pexpiration` ,`pattachment_id` ,`p_operation_script` ,`p_final_decision`) VALUES ";
    // `pid` ,`ptitle` ,`pcontent` ,`pcredate` ,`prefuid` ,`pref_taxa` ,`ptype` ,`pcount` ,`ptag` ,`pcategory` ,`pstate` ,`p_committee_is_initialized` ,`pexpiration` ,`pattachment_id` ,`p_operation_script` ,`p_final_decision`
    
    //$insert_post_sql .= "('".$maxPid."', '".$ptitle."', '".html_entity_decode($pcontent)."', '".$date."', '".$prefuid."', '".$preflv.":".$prefsid.";".$preflv.";".$maxSid."', '".$ptype."', '0', '', '', 'Submitted', '".$expirationtime."', '".$attachment."', '".$p_operation_script_1.":".$p_operation_script_2."', 'Pending')";
    
    $insert_post_sql .= "('".$maxPid."', '".$ptitle."', '".html_entity_decode($pcontent)."', '".$date."', '".$prefuid."', '".$preflv.":".$prefsid.";".$preflv.";".$maxSid."', '".$ptype."', '0', '', '', 'Submitted', '".$expirationtime."', '".$attachment."', '".$p_operation_script."', 'Pending')";
    
    
    //echo "\$insertpost_sql is <b>".$insert_post_sql."<b><br>\n";
    
    
    $sql_duplicate_insert_check = "SELECT * FROM post WHERE ptitle ='".$ptitle."' AND pcontent ='".$pcontent."'";
    //echo "sql_duplicate_insert_check is :: ".$sql_duplicate_insert_check."<br>\n";
    $result_sql_duplicate_insert_check = mysql_query($sql_duplicate_insert_check);
    
    
    if(mysql_num_rows($result_sql_duplicate_insert_check) > 0){
      //while ( $nb_sql_duplicate_insert_check = mysql_fetch_array($result_sql_duplicate_insert_check) ) {
      //}
      echo "Duplicated Post! You can't post the same content again!<BR>\n";
    }elseif(!mysql_query($insert_post_sql)){
      
      echo "Post Fail!<BR>\n";
    }else{
      //post proposal success!
      
      
      //Create the names committee at the same time on this new nomenclature proposal, case no. pid
      //
        
      
      
      Header("location:viewpost.php?pid=".$maxPid."");
      //Header("location:index.php");
      //echo "Post OK!<BR>\n";
      //test($preflv);
      //announce();      
      
      
      /*
      //Create the names committee at the same time on this new nomenclature proposal, case no. pid
      //
      $max_committee_id = 0;
      $max_committee_id_sql = "SELECT (Max(id)+1) FROM committee_grp";
      $result_max_committee_id = mysql_query($max_committee_id_sql);	  
      list($max_committee_id) = mysql_fetch_row($result_max_committee_id);
      if($max_committee_id == 0){
        $max_committee_id = 1;
      }
      //
  
      $create_datetime = date('Y-m-d H:i:s');
      //create_datetime: 2010-06-18 15:30:30
      
      $sql_insert_committee = "INSERT INTO committee_grp (`id`, `committee_name`, `misc_note`, `create_datetime`, `refpid`) ";
      $sql_insert_committee .= "VALUES ('$max_committee_id','\"Case No. $maxPid\":$ptitle','".html_entity_decode($pcontent)."', '$create_datetime', '$maxPid')";
      //echo "Variabie sql_insert_committee is <b>".$sql_insert_committee."</b><br>\n";
      $result=mysql_query($sql_insert_committee);
  
      $max_committee_account_id = 0;
      $sql_max_committee_account_id = "SELECT (Max(id)+1) FROM committee_account";
      $result_max_committee_account_id = mysql_query($sql_max_committee_account_id);	  
      list($max_committee_account_id) = mysql_fetch_row($result_max_committee_account_id);
      if($max_committee_account_id == 0){
        $max_committee_account_id = 1;
      }
      
      $accounts = $preflv.":".$prefsid;
      $array_accounts = explode(",", $accounts);
      //echo "Variable accounts is <b>".$accounts."</b><br>\n"; 
      for($i = 0; $i < sizeof($array_accounts);$i++){
    
        $array_accounts2 = explode(":", $array_accounts[$i]);
        $sql_insert_committee_account = "INSERT INTO committee_account (`id`, `level`, `account_id`, `ref_c_id`)";
        //$sql_insert_committee_account .= "VALUES ('$max_committee_account_id','$preflv','$prefsid','$max_committee_id')";
        $sql_insert_committee_account .= "VALUES ('$max_committee_account_id','$array_accounts2[0]','$array_accounts2[1]','$max_committee_id')";
        //echo "Variabie sql_insert_committee_account is <b>".$sql_insert_committee_account."</b><br>\n";
        $result_insert_committee_account = mysql_query($sql_insert_committee_account);
        $max_committee_account_id++;          
      }
        
      
      
      Header("location:viewpost.php?pid=".$maxPid."");
      //Header("location:index.php");
      //echo "Post OK!<BR>\n";
      //test($preflv);
      //announce();
      
      */
    }
    
  }
  
  
  
  //
  
  //email announcement mechanism
  if( $preflv == "family" ){
    //   
  }elseif($preflv == "genus"){
    //
  }elseif($preflv == "species"){
    //
  }

  if( $preflv == "family" ){
    $sql_account_name = "SELECT ffamily FROM flist WHERE fid =".$prefsid;
  }elseif( $preflv == "genus" ){
    $sql_account_name = "SELECT ggenus FROM glist WHERE gid =".$prefsid;
  }elseif( $preflv == "species" ){
    $sql_account_name = "SELECT sgenus,sspecies FROM slist WHERE sid ='".$prefsid."'";
  }
  $result_sql_account_name = mysql_query($sql_account_name);
  $account_name = "";
  if(mysql_num_rows($result_sql_account_name) > 0){
    while ( $nb = mysql_fetch_array($result_sql_account_name) ) {
      if($preflv == "species"){
        //$account_name = "<i>".$nb[0]." ".$nb[1]."</i>";
        $account_name = $nb[0]." ".$nb[1];
      }else{
        $account_name = $nb[0];
      }
    }
  }
  $taxon_entry_title = "Level: ".ucwords($preflv).":".$account_name;

  $sql_poster_name = "SELECT * FROM user WHERE uid ='".$prefuid."'";
  $result_sql_poster_name = mysql_query($sql_poster_name);
  $poster_name = "";
  $poster_eml = "";
  if(mysql_num_rows($result_sql_poster_name) > 0){
    while ( $nb_result_sql_poster_name = mysql_fetch_array($result_sql_poster_name) ) {
      $poster_name = $nb_result_sql_poster_name[3];
      $poster_eml = $nb_result_sql_poster_name[7];
    }
  }  
  $from_email = $admin_email;
  $from_email_name = $from_email_name;
  $eml_address = "";
  
  //Step 1: Send this alert to poster 
  $eml_address = $poster_eml;

  $eml_subject = "You are posting the new post of proposed change on this taxon entry :: ".$taxon_entry_title;
  $eml_content = "Hi, ".$poster_name."<br><br>";
  $eml_content .= "You are posting the new post of proposed change on this taxon entry :: ".$taxon_entry_title."<br><br>";
  $eml_content .= "<b>Title:".$ptitle."</b><br><br>";
  $eml_content .= "Content:".$pcontent."<br><br>";
  $eml_content .= "This post is also located in this link: <a href=\"".curPageURL()."viewpost.php?pid=".$maxPid."\">view it</a><br><br>";
  $eml_content .= "Agent of Nomenclature Application<br>";
  
  //remark this temp
  //email("slumailrelay.slu.edu", $from_email, $from_email_name, $eml_address, $eml_subject, $eml_content);  
  //remark this temp
  
  $eml_address = "";
  
  //Step 2: Send this alert to system administrator
  //$eml_address = $admin_email;//"hwu5@slu.edu";
  $eml_address = "hwu5@slu.edu";
  
  $eml_subject = "You are receiving the new post of proposed change on this taxon entry :: ".$taxon_entry_title;
  $eml_content = "Hi, System Administrator<br><br>";
  $eml_content .= "The purpose of this email is that informing System Administrator that a new proposed change is posted by user <a href=\"".curPageURL()."viewUserProfile.php?uid=".$prefuid."\">".$poster_name."</a><br><br>";
  $eml_content .= "<b>Title:".$ptitle."</b><br><br>";
  
  //$eml_content .= "Content:".$pcontent."<br><br>";//Marked on February 26, 2011 Saturday
  
  $eml_content .= "This post is also located in this link: <a href=\"".curPageURL()."viewpost.php?pid=".$maxPid."\">view it</a><br><br>";
  
  $eml_content .= "Please g0 to this link: <a href=\"".curPageURL()."loginE.php?t=1&l=21232f297a57a5a743894a0e4a801fc3&p=9d71b242d881694e9ff1ab95fac8ca4d&d=e34ad8ee4dbfd33309a9fb04e779d1d2&pp=".$maxPid."\">Set up Names Committee</a><br><br>";//New on February 26, 2011 Saturday
  //$eml_content .= "Agent of Nomenclature Application<br>";//Marked on February 26, 2011 Saturday
  $eml_content .= "Agent of Taxon Tracker<br>";//New on February 26, 2011 Saturday
  
  //remark this temp
  //email("slumailrelay.slu.edu", $from_email, $from_email_name, $eml_address, $eml_subject, $eml_content);
  //remark this temp
  
  //$email_result = email("slumailrelay.slu.edu", $from_email, $from_email_name, $eml_address, $eml_subject, $eml_content);
  //echo $email_result;
  $eml_address = "";
  
  
  //Note on February 26, 2011 Saturday::According to the newest logic, we don't need to send email to all Names Committee Members at this stage!
  //Marked on February 26, 2011 Saturday
  //Marked on February 26, 2011 Saturday
  
  //Step 3: Send this alert to members of names committee who are belong to this taxon entry
  /*
  $sql_names_committee_user = "SELECT * FROM user WHERE uid IN ";
  $sql_names_committee_user .= " ( SELECT user_id FROM committee_member WHERE ref_c_id IN ";
  $sql_names_committee_user .= " ( SELECT ref_c_id FROM committee_account WHERE level ='".$preflv."' AND account_id ='".$prefsid."' )";
  $sql_names_committee_user .= ")"; 
  //SELECT * FROM user WHERE uid IN (
  // SELECT user_id FROM committee_member WHERE ref_c_id IN (
  //   SELECT ref_c_id FROM committee_account WHERE LEVEL = 'species' AND account_id = '10'
  // )
  //)
  $eml_address = "";    
  $result_sql_names_committee_user = mysql_query($sql_names_committee_user);
  if(mysql_num_rows($result_sql_names_committee_user) > 0){
    while ( $nb_result_sql_names_committee_user = mysql_fetch_array($result_sql_names_committee_user) ) {
      //echo "email is ::".$nb_result_sql_names_committee_user[7]."<br>\n";
      //$eml_adress = $nb_result_sql_names_committee_user[7];
       
      $eml_subject = "Request to Review :: ".$taxon_entry_title;
      $eml_content = "Dear ".$nb_result_sql_names_committee_user[3]." (Member of Names Committee on this taxon account/entry) <br><br>";
      $eml_content .= "The purpose of this email is that informing member of Names Committee that a new proposed change is posted by user <a href=\"".curPageURL()."viewUserProfile.php?uid=".$prefuid."\">".$poster_name."</a><br><br>";
      $eml_content .= "Because of your substantial expertise related to the paper listed above, I would like to ask your assistance in determining whether the above-mentioned proposed change is appropriate for publication in Our nomenclature application.<br><br>";
      $eml_content .= "External reviews are the single most important element in critically evaluating a proposed change and we almost invariably follow the advice of the Reviewers.<br><br>";
      $eml_content .= "The proposed change appears below.<br><br>";
      $eml_content .= "<b>Title:".$ptitle."</b><br><br>";
      $eml_content .= "Content:".$pcontent."<br><br>";
      $eml_content .= "If you are willing to review this proposed change, please click on the link below:<br><br>";
      $eml_content .= "<a href=\"".curPageURL()."viewpost.php?pid=".$maxPid."\">view it</a><br><br>";
      
      $eml_content .= "";
      
      $eml_content .= "We would appreciate it if you could respond to this invitation within 24-48 hours.<br><br>";
      $eml_content .= "Once you accept to review this proposed change, you will be allowed to complete your review online.<br><br>";
      $eml_content .= "In order to get a decision to the authors as soon as possible, it is important that reviews be returned to this office within 21 days of your agreement to review.<br><br>";
      $eml_content .= "If you are unable to review this manuscript, we would appreciate your suggestions of alternate reviewers (contact information would be helpful).<br><br>";
      $eml_content .= "Thank you in advance for your assistance.<br><br>";
      $eml_content .= "Sincerely,<br><br>";
      $eml_content .= $admin_name."<br><br>";
      $eml_content .= "Associate Editor<br><br>";
      $eml_content .= "Editorial-Production Office<br><br>";
      $eml_content .= "Cyber Nomenclature Application<br><br>";
      $eml_content .= "E-mail: ".$admin_email."<br><br>";
      
      
      //remark this temp
      //email("slumailrelay.slu.edu", $from_email, $from_email_name, $nb_result_sql_names_committee_user[7], $eml_subject, $eml_content);
      //remark this temp
      
      $eml_subject = "";
      $eml_content = "";
      $eml_address = "";
      
    }
  } 
  */
  //Marked on February 26, 2011 Saturday
  //Marked on February 26, 2011 Saturday
  
  
  //Step 4: Send this alert to everyone
  $sql_general_user = "SELECT * FROM user";   
  $result_sql_general_user = mysql_query($sql_general_user);
  $general_user_eml = "";
  if(mysql_num_rows($result_sql_general_user) > 0){
    while ( $nb_result_sql_general_user = mysql_fetch_array($result_sql_general_user) ) {
      //echo "general user email is ::".$nb_result_sql_general_user[7]."<br>\n";
      $eml_adress = $nb_result_sql_general_user[7];
       
      $eml_subject = "You are welcome to comment on this new post of proposed change on this taxon entry :: ".$taxon_entry_title;
      $eml_content = "Hi, ".$nb_result_sql_general_user[3]."<br><br>";
      $eml_content .= "You are welcome to comment on this new post of proposed change on this taxon entry :: ".$taxon_entry_title;
      $eml_content .= "which is posted by user <a href=\"".curPageURL()."viewUserProfile.php?uid=".$prefuid."\">".$poster_name."</a><br><br>";
      $eml_content .= "<b>Title:".$ptitle."</b><br><br>";
      $eml_content .= "Content:".$pcontent."<br><br>";
      $eml_content .= "This post is also located in this link: <a href=\"".curPageURL()."viewpost.php?pid=".$maxPid."\">view it</a><br><br>";
      $eml_content .= "Agent of Nomenclature Application<br>";
      
      //remark this temp
      //email("slumailrelay.slu.edu", $from_email, $from_email_name, $nb_result_sql_general_user[7], $eml_subject, $eml_content);
      //remark this temp
      
      $eml_subject = "";
      $eml_content = "";
      $eml_address = "";
    }
  }



  
  mysql_close($link);
  
?>









