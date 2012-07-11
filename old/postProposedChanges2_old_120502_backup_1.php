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
  $ptitle = htmlspecialchars($_POST['ptitle'],ENT_QUOTES);
  $ptype = htmlspecialchars($_POST['ptype'],ENT_QUOTES);
  
  $pcontent = htmlspecialchars($_POST['pcontent'],ENT_QUOTES);
  $pcontent = hexToAsciiToString($pcontent);//好像沒有需要耶...
  
  $attachment = htmlspecialchars($_POST['attachment'],ENT_QUOTES);
  $attachment_check = substr($attachment, -1);
  if( $attachment_check == ";"){
    $attachment = substr($attachment, 0, -1);
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
  //echo "maxLid is ".$maxPid."<br>";


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
    //Header("location:nullpost.php");
  }elseif ( $ptitle == "" || $pcontent == ""){
    //Header("location:nullpost.php");
    echo "You need to type title OR content in this post!<BR>\n";
  }else{
    //insert_sql statement
    $insert_sql = "INSERT INTO post (`pid`, `ptitle`, `pcontent`, `pcredate`, `prefuid`, `preflv`, `prefsid`, `ptype`, `pcount`, `ptag`, `pcategory`, `pstate`, `pexpiration`, `pattachment_id`) VALUES ";
    $insert_sql .= "('".$maxPid."', '".$ptitle."', '".html_entity_decode($pcontent)."', '".$date."', '".$prefuid."', '".$preflv."', '".$prefsid."', '".$ptype."', '0', '', '', '0', '".$expirationtime."', '".$attachment."')";
    //echo "insert_sql is ".$insert_sql."\n<BR>";
    
    
    $sql_duplicate_insert_check = "SELECT * FROM post WHERE ptitle ='".$ptitle."' AND pcontent ='".$pcontent."'";
    //echo "sql_duplicate_insert_check is :: ".$sql_duplicate_insert_check."<br>\n";
    $result_sql_duplicate_insert_check = mysql_query($sql_duplicate_insert_check);
    
    
    if(mysql_num_rows($result_sql_duplicate_insert_check) > 0){
      //while ( $nb_sql_duplicate_insert_check = mysql_fetch_array($result_sql_duplicate_insert_check) ) {
      //}
      echo "Duplicated Post! You can't post the same content again!<BR>\n";
    }elseif(!mysql_query($insert_sql)){
      echo "Post Fail!<BR>\n";
    }else{
      
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
    }
    
  }

  //announcement mechanism
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
  $eml_content .= "Content:".$pcontent."<br><br>";
  $eml_content .= "This post is also located in this link: <a href=\"".curPageURL()."viewpost.php?pid=".$maxPid."\">view it</a><br><br>";
  $eml_content .= "Agent of Nomenclature Application<br>";
  
  //remark this temp
  //email("slumailrelay.slu.edu", $from_email, $from_email_name, $eml_address, $eml_subject, $eml_content);
  //remark this temp
  
  //$email_result = email("slumailrelay.slu.edu", $from_email, $from_email_name, $eml_address, $eml_subject, $eml_content);
  //echo $email_result;
  $eml_address = "";
  
  //Step 3: Send this alert to members of names committee who are belong to this taxon entry

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

function test($preflv){
  echo $preflv;
}

// This function is not working right now!!
function announce($preflv, $prefsid, $prefuid){
  //announcement mechanism
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
  
  email("slumailrelay.slu.edu", $from_email, $from_email_name, $eml_address, $eml_subject, $eml_content);  
  $eml_address = "";
  
  //Step 2: Send this alert to system administrator
  //$eml_address = $admin_email;//"hwu5@slu.edu";
  $eml_address = "hwu5@slu.edu";
  
  $eml_subject = "You are receiving the new post of proposed change on this taxon entry :: ".$taxon_entry_title;
  $eml_content = "Hi, System Administrator<br><br>";
  $eml_content .= "The purpose of this email is that informing System Administrator that a new proposed change is posted by user <a href=\"".curPageURL()."viewUserProfile.php?uid=".$prefuid."\">".$poster_name."</a><br><br>";
  $eml_content .= "<b>Title:".$ptitle."</b><br><br>";
  $eml_content .= "Content:".$pcontent."<br><br>";
  $eml_content .= "This post is also located in this link: <a href=\"".curPageURL()."viewpost.php?pid=".$maxPid."\">view it</a><br><br>";
  $eml_content .= "Agent of Nomenclature Application<br>";
  
  email("slumailrelay.slu.edu", $from_email, $from_email_name, $eml_address, $eml_subject, $eml_content);
  //$email_result = email("slumailrelay.slu.edu", $from_email, $from_email_name, $eml_address, $eml_subject, $eml_content);
  //echo $email_result;
  $eml_address = "";
  
  //Step 3: Send this alert to members of names committee who are belong to this taxon entry

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
  
      email("slumailrelay.slu.edu", $from_email, $from_email_name, $nb_result_sql_names_committee_user[7], $eml_subject, $eml_content);
      $eml_subject = "";
      $eml_content = "";
      $eml_address = "";
      
    }
  } 
  
  
  
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

      email("slumailrelay.slu.edu", $from_email, $from_email_name, $nb_result_sql_general_user[7], $eml_subject, $eml_content);
      $eml_subject = "";
      $eml_content = "";
      $eml_address = "";
    }
  }   
}   
   
  
  mysql_close($link);
  
?>


<?php
/*
  //Developed by elviscat (elviscat@gmail.com)
  //March 15, 2009 Sunday:: post the proposed changes or suggestted name changes interface:: insert into the table-->post
  //March 15, 2009 Sunday:: add the column:: ptype to record these two types of post--> proposed changes or suggestted name changes
  // ./ current directory
  // ../ up level directory
  session_start();
  if( (!isset($_SESSION['is_login'])) ){
	  Header("location:authorizedFail.php");
	  exit();
  }

  
  $ptitle = htmlspecialchars($_POST['ptitle'],ENT_QUOTES);
  $ptype = htmlspecialchars($_POST['ptype'],ENT_QUOTES);
  $pcontent = htmlspecialchars($_POST['pcontent'],ENT_QUOTES);
  $prefsid = htmlspecialchars($_POST['prefsid'],ENT_QUOTES);  
  $prefuid = htmlspecialchars($_POST['prefuid'],ENT_QUOTES);
  //$ptag = htmlspecialchars($_POST['ptag'],ENT_QUOTES);
  //$pcategory = htmlspecialchars($_POST['pcategory'],ENT_QUOTES);
  //echo $prefuid."<BR>";
  //echo $title."<BR>";
  //echo $content."<BR>";
  
  include('template/dbsetup.php');
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  //sql statement
  //echo "Hello Elvis";
  
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
  //echo "maxLid is ".$maxPid."<br>";
  $date = date("Y-m-d H:i:s");//"2008-08-28 11:03:21"

  //select database
  mysql_select_db($dbname);
  //sql statement
  $sql = "INSERT INTO post (`pid`, `ptitle`, `pcontent`, `pcredate`, `prefuid`, `prefsid`, `ptype`, `pcount`, `ptag`, `pcategory`) VALUES ";
  $sql .= "('".$maxPid."', '".$ptitle."', '".$pcontent."', '".$date."', '".$prefuid."', '".$prefsid."', '".$ptype."', '0', '', '')";
  //echo $sql;
  mysql_query($sql);
  mysql_close($link);
  
  Header("location:postProposedChangesManage.php");
  exit();
  			
*/	
?>
