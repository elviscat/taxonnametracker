<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //June 16, 2010 Wednesday:: NEW:: SA write Nomenclature Proposal's  Summary and send email to Names Committee Memebr(s):: Step 2
  // ./ current directory
  // ../ up level directory
  session_start();
 
  $taxon_lv = htmlspecialchars($_POST['taxon_lv'],ENT_QUOTES);
  //echo "Variable taxon_lv is <b>".$taxon_lv."</b><br>\n";
  $taxon_id = htmlspecialchars($_POST['taxon_id'],ENT_QUOTES);
  //echo "Variable taxon_id is <b>".$taxon_id."</b><br>\n";
  $pid = htmlspecialchars($_POST['pid'],ENT_QUOTES);
  //echo "Variable pid is <b>".$pid."</b><br>\n";
  $nomenclature_summary = htmlspecialchars($_POST['nomenclature_summary'],ENT_QUOTES);
  //echo "Variable nomenclature_summary is <b>".$nomenclature_summary."</b><br>\n";
  
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
  
  //include('template0.php');

  //
  $max_cid = 0;
  $sql_max_cid = "SELECT (Max(cid)+1) FROM comment";
  $result_max_cid = mysql_query($sql_max_cid);
  list($max_cid) = mysql_fetch_row($result_max_cid);
  if($max_cid == 0){
    $max_cid = 1;
  }          

  //
  
  $create_date = date('Y-m-d h:i:s');

  //date: 0000-00-00
  //time: 00:00:00

  $taxon_name = taxon_name_with_level($taxon_lv, $taxon_id);
  $ref_c_id = get_ref_c_id_from_pid($pid);
  
  
  
  $insert_sql = "INSERT INTO committee_grp (`cid`, `ctitle`, `ccontent`,	`ccredate`, `crefuid`, `crefpid`, `comment_type`) ";
  $insert_sql .= "VALUES ('$max_cid','Summary for this taxon".$taxon_name."','$create_date','0', ,'$pid', ,'SA_Summary')";
  //echo "Variabie insert_sql is <b>".$insert_sql."</b><br>\n";
  $result=mysql_query($insert_sql);



  $from_email = $admin_email;
  $from_email_name = $from_email_name;  
  $eml_address = "";

  //Send email to names committee member(s)
  $sql_committee_member = "SELECT * FROM committee_member WHERE ref_c_id ='".$ref_c_id."'";
  //echo $sql_committee_member;
  $result_committee_member = mysql_query($sql_committee_member);	  
  if(mysql_num_rows($result_committee_member) > 0){
    while ( $nb_committee_member = mysql_fetch_array($result_committee_member) ) {  
      //
      $uid = $nb_committee_member[1];       
      $user_name = user_name($uid);
      $user_email = user_email($uid);
      $eml_address = $user_email;
      
      $eml_subject = "Summary for this taxon".$taxon_name;
      $eml_content = $nomenclature_summary;
            
      if(email("slumailrelay.slu.edu", $from_email, $from_email_name, $eml_address, $eml_subject, $eml_content)){
        //echo "Your message has sent to ".$user_name."!<br>\n";
      }else{
        //echo "Fail to send this message!";
      }       
    }
  }else{
    //
  }  
  //Send email to names committee member(s)

  //July 02, 2010 Friday:: New Actions
  //1.Change pstate from 1 to 2
  $sql_post_pstate_update = "UPDATE post SET pstate ='2' WHERE pid ='".$pid."'";
  mysql_query($sql_post_pstate_update);
  
  
  //2.Change TABLE::committee_grp is_closed from 0 to 1
  $sql_committee_grp_is_closed_update = "UPDATE committee_grp SET is_closed ='1' WHERE refpid ='".$pid."'";
  mysql_query($sql_committee_grp_is_closed_update);


  //3.Change TABLE::committee_grp is_closed from 0 to 1
  

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
  $timestamp = mktime($hours, $minutes,$seconds ,$month, $day + 7,$year);
  //echo strftime("%Y-%m-%d %H:%i:%s",$timestamp);

  /**Test*/
  //echo date("Y-m-d H:i:s",$timestamp);
  /**Test*/

  /**Time Drift*/
  //$expirationtime = date("Y-m-d H:i:s",$timestamp);
  $expirationtime = date("Y-m-d",$timestamp);  
  
  $sql_committee_grp_vote_expiration_update = "UPDATE committee_grp SET vote_expiration ='".$expirationtime."' WHERE refpid ='".$pid."'";
  //echo $sql_committee_grp_vote_expiration_update;
  mysql_query($sql_committee_grp_vote_expiration_update);
  
  //July 02, 2010 Friday:: New Actions

  
  mysql_close($link); 
  Header("Location:view_sa_reminder.php?type=newpost")

?>