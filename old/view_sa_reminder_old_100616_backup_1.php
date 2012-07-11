<?php
  //Developed by elviscat (elviscat@gmail.com)
  //Jan 22, 2010 Friday:: New design
  //Jan 28, 2010 Thursday:: Finish the without Names Committee Member Layout 
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
  
  //Customized section of view_sa_reminder.php
  if( !isset($_SESSION['is_login']) ){
    Header("location:loginFail.php");
    exit();
  }
  //echo "Session of role is :: ".$_SESSION['role']."<br>\n";
  
  //!?!?
  //Get the session variable
  $role = $_SESSION['role'];
  $loginname = "";
  $real_name = "";
  //$role = "";
  if( $role == "admin"){
    //echo "Yes\n";
    $loginname = "Admin";
    $real_name = "System Administrator";
    $role = "admin";
  }else{
    $uid = $_SESSION['uid'];

    $check_level_sql = "SELECT username, name FROM user WHERE uid ='".$uid."'";
    //echo "check_level_sql is ".$check_level_sql."/n<br>";
    $result_check_level = mysql_query($check_level_sql);
    if(mysql_num_rows($result_check_level) > 0){
      while ( $nb_check_level = mysql_fetch_array($result_check_level) ) {
        $loginname = $nb_check_level[0];
        $real_name = $nb_check_level[1];
        $role = "user";
      }
    }  
  }
  //!?!?

  //Customized section of view_sa_reminder.php

  //Configuration of POST and GET Variables
  $pid = htmlspecialchars($_GET['pid'],ENT_QUOTES);
  //echo "Variable pid is :: ".$pid."<br>\n";
   
  //Configuration of POST and GET Variables
    
  $caption = $application_caption;
  $caption2 = "System Administrator Reminder";   
  $title = $caption."::".$caption2;
  //template


  
  $content = "";
  $type = htmlspecialchars($_GET['type'],ENT_QUOTES);
  //echo "Variable type is :: ".$type."<br>\n";
  if( $type == "newpost"){
    //
    //$content .= $type."<br>\n";
    $content .= "<h2>Recent 5 leatest accomplished Changes:</h2><br>\n";

    $sql = "SELECT * FROM namelist_chglog ORDER BY id DESC Limit 5";
    //echo "sql is ".$sql."<br>\n";
    $result_sql = mysql_query($sql);
    if(mysql_num_rows($result_sql) > 0){
    //echo "<table border=\"1\">\n";
    $content .= "<table>\n";
    $content .= "<tr>\n";
    $content .= "<td>On this taxon</td>\n";
    $content .= "<td>Refer change proposal</td>\n";
    $content .= "<td>Change Note</td>\n";
    $content .= "<td>Change Reason</td>\n";
    $content .= "<td>Final Decision</td>\n";
    $content .= "<td>Change Date and Time</td>\n";
    //echo "<td>View Detail</td>\n";
    $content .= "</tr>\n";
        
    while ( $nb_sql = mysql_fetch_array($result_sql) ) {
      $content .= "<tr>\n";
      $lv = $nb_sql[1];
      $id = $nb_sql[2];
      $taxon_name = taxon_name_with_level($lv, $id); 
      $pid = $nb_sql[3];
      $post_title = post_title($pid); 
              
      $content .= "<td><a href=\"viewtaxon.php?lv=".$nb_sql[1]."&id=".$nb_sql[2]."\">".$taxon_name."</a></td>\n";//On this taxon
      $content .= "<td><a href=\"viewpost.php?pid=".$nb_sql[3]."\">".$post_title."</a></td>\n";//Refer change proposal
      $content .= "<td>".substr($nb_sql[4], 0, 30)." ... </td>\n";//Change Note
      $content .= "<td>".substr($nb_sql[5], 0, 30)." ... </td>\n";//Change Reason
      $content .= "<td>".$nb_sql[6]."</td>\n";//Final Decision
      $content .= "<td>".$nb_sql[7].$nb_sql[8]."</td>\n";//Change Date and Time
      $content .= "</tr>\n";
    }
            
    $content .= "</table>\n";
  }else{
  $content .= "There is no recent changes on this name list!<br>\n";
  }


    $content .= "<h2>Deal with new posted proposed changes:</h2><br>\n";
    //Find the post which is under state == 'under_review'
    $sql_find_under_review = "SELECT * FROM post WHERE pstate = '0'";
    //echo "Variable sql_find_under_review is :: ".$sql_find_under_review."<br>\n";
    $result_sql_find_under_review = mysql_query($sql_find_under_review);

    if(mysql_num_rows($result_sql_find_under_review) > 0){
      $content .= "<table>\n";
      $content .= "<tr>\n";
      $content .= "<td>Title</td>\n";
      $content .= "<td>Date</td>\n";
      $content .= "<td>Poster</td>\n";
      $content .= "<td>Expiration Date</td>\n";
      $content .= "<td>Edit</td>\n";
      $content .= "</tr>\n";
      while ( $nb_sql_find_under_review = mysql_fetch_array($result_sql_find_under_review) ) {
        $pid = $nb_sql_find_under_review[0];
        $ptitle = $nb_sql_find_under_review[1];
        $pcredate = $nb_sql_find_under_review[3];
        $prefuid = $nb_sql_find_under_review[4];
        $preflv = $nb_sql_find_under_review[5];
        $prefsid = $nb_sql_find_under_review[6];
        $pexpiration = $nb_sql_find_under_review[12];
        $user_name = "";
        $sql_user_name = "SELECT * FROM user WHERE uid = '".$prefuid."'";
        $result_sql_user_name = mysql_query($sql_user_name);
        if(mysql_num_rows($result_sql_user_name) > 0){
          while ( $nb_sql_user_name = mysql_fetch_array($result_sql_user_name) ) {
            $user_name =  $nb_sql_user_name[3];
          }
        }
        
        $content .= "<tr>\n";
        $content .= "<td><a href=\"viewpost.php?pid=".$pid."\">".$ptitle."</a></td>\n";
        $content .= "<td>".substr($pcredate, 0, 10)."</td>\n";
        $content .= "<td><a href=\"viewUserProfile.php?uid=".$prefuid."\">".$user_name."</a></td>\n";
        $content .= "<td>".$pexpiration."</td>\n";
        $content .= "<td><a href=\"slist_chg.php?lv=".$preflv."&id=".$prefsid."&pid=".$pid."\">Edit</a></td>\n";
        
        $content .= "</tr>\n";
      }
      
      $content .= "</table>\n";
    }
    
  }elseif( $type == "expired"){
    //
    //$content .= $type."<br>\n";
    $content .= "Deal with expired posted proposed changes<br>\n";
    //Find the post which is expired
    $expired_date = date("Y-m-d");//"2010-01-22"
    $sql_find_expired = "SELECT * FROM post WHERE pexpiration < '".$expired_date."' AND pstate='0'";
    //echo "Variable sql_find_expired is :: ".$sql_find_expired."<br>\n";
    $result_sql_find_expired = mysql_query($sql_find_expired);
    if(mysql_num_rows($result_sql_find_expired) > 0){
      
      $content .= "<form id=\"submitForm\" action=\"extend_expiration.php\" method=\"post\">";
      
      $content .= "<table>\n";
      $content .= "<tr>\n";
      $content .= "<td>Check this</td>\n";
      $content .= "<td>Title</td>\n";
      $content .= "<td>Date</td>\n";
      $content .= "<td>Poster</td>\n";
      $content .= "<td>Expiration Date</td>\n";
      $content .= "<td>Select Extend Days</td>\n";
      $content .= "</tr>\n";
      $counter = 1;
      while ( $nb_sql_find_expired = mysql_fetch_array($result_sql_find_expired) ) {

        $pid = $nb_sql_find_expired[0];
        $ptitle = $nb_sql_find_expired[1];
        $pcredate = $nb_sql_find_expired[3];
        $prefuid = $nb_sql_find_expired[4];
        $preflv = $nb_sql_find_expired[5];
        $prefsid = $nb_sql_find_expired[6];
        $pexpiration = $nb_sql_find_expired[12];
        $user_name = "";
        $sql_user_name = "SELECT * FROM user WHERE uid = '".$prefuid."'";
        $result_sql_user_name = mysql_query($sql_user_name);
        if(mysql_num_rows($result_sql_user_name) > 0){
          while ( $nb_sql_user_name = mysql_fetch_array($result_sql_user_name) ) {
            $user_name =  $nb_sql_user_name[3];
          }
        }
        
        $content .= "<tr>\n";
        //checkbox
        //$content .= "<td><a href=\"viewpost.php?pid=".$pid."\">".$ptitle."</a></td>\n";
        $content .= "<td><input type=\"checkbox\" name=\"post_id\" id=\"post_id\" value=\"".$pid.",".$pexpiration."\"</td>\n";
        //checkbox
        $content .= "<td><a href=\"viewpost.php?pid=".$pid."\">".$ptitle."</a></td>\n";
        $content .= "<td>".substr($pcredate, 0, 10)."</td>\n";
        $content .= "<td><a href=\"viewUserProfile.php?uid=".$prefuid."\">".$user_name."</a></td>\n";
        $content .= "<td>".$pexpiration."</td>\n";
        //selectbox
        //$content .= "<td><a href=\"slist_chg.php?lv=".$preflv."&id=".$prefsid."&pid=".$pid."\">Edit</a></td>\n";
        $content .= "<td>\n";
        $content .= "<select id=\"extend_date_".$counter."\" name=\"extend_date_".$counter."\">";
        
        $counter++;
        
        $content .=    "<option value=\"30\">30 days</option>";
        $content .=    "<option value=\"60\">60 days</option>";
        $content .=    "<option value=\"90\">90 days</option>";
        $content .= "</select>";
        $content .= "</td>\n";
        //selectbox
        $content .= "</tr>\n";
      }
      $content .= "<tr>\n";
      $content .= "<td>\n";
      $content .= "<input id=\"selection\" name=\"selection\" type=\"hidden\" />";
      $content .= "<input id=\"selectListButton\" name=\"selectListButton\" type=\"submit\" value=\"Extend\" />";
      $content .= "</td>";
      $content .= "</tr>";
      $content .= "</table>\n";
      $content .= "</form>";
    }
  }elseif( $type == "without_names_committee"){
    //
    //$content .= $type."<br>\n";
    $content .= "Deal with posted proposed changes without Names Committee<br>\n";
    
    $sql_general_post = "SELECT * FROM post WHERE pexpiration > '".$expired_date."' AND pstate='0'";
    //echo "Variable sql_general_post is :: ".$sql_general_post."<br>\n";
    $result_sql_general_post = mysql_query($sql_general_post);
    
    $counter = 0;
    $array_taxon_list = array();
    $array_taxon_list_unique = array();
    
    if(mysql_num_rows($result_sql_general_post) > 0){
      
      
      while ( $nb_sql_general_post = mysql_fetch_array($result_sql_general_post) ) {
        $pid = $nb_sql_general_post[0];
        $preflv = $nb_sql_general_post[5];
        $prefsid = $nb_sql_general_post[6];

        $sql_post_with_names_committee = "SELECT * FROM committee_account WHERE `committee_account`.`level` = '".$preflv."' AND account_id ='".$prefsid."'";
        //echo "Variable sql_post_with_names_committee is :: ".$sql_post_with_names_committee."<br>\n";
        $result_sql_post_with_names_committee = mysql_query($sql_post_with_names_committee);
        if(mysql_num_rows($result_sql_post_with_names_committee) > 0){
          //$content .= "Yes\n";
          //$counter++;
        }else{
          //$content .= "No\n";
          //$counter++;
          $array_taxon_list[$counter] = $nb_sql_general_post[5].";".$nb_sql_general_post[6];
          $counter++;

        }
      }
      
      //print_r($array_taxon_list);
      //echo "<br><br>";
      $array_taxon_list_unique = array_unique($array_taxon_list);
      //print_r($array_taxon_list_unique);
      //echo sizeof($array_taxon_list)."<br>\n";
      //echo sizeof($array_taxon_list_unique)."<br>\n";
      

    }


    //$content .=  "You have <a href=\"view_sa_reminder.php?type=without_names_committee\">".$counter."</a> proposed changes without Names Committee.<br>\n";

  
    ////////////
    $content .= "<form id=\"submitForm\" action=\"add_to_nc.php\" method=\"post\">";
 
    $content .= "<table>\n";
    $content .= "<tr>\n";
    $content .= "<td>Check this</td>\n";
    $content .= "<td>Taxon Name</td>\n";
    $content .= "</tr>\n";
    
    for($i = 0; $i < sizeof($array_taxon_list_unique); $i++){
      if($array_taxon_list_unique[$i] != ""){
        $array_taxon_lv_id = explode(";", $array_taxon_list_unique[$i]);
        $lv = $array_taxon_lv_id[0];
        $id = $array_taxon_lv_id[1];
      
        $content .= "<tr>\n";
        //checkbox
        //$content .= "<td><a href=\"viewpost.php?pid=".$pid."\">".$ptitle."</a></td>\n";
        $content .= "<td><input type=\"checkbox\" name=\"taxon_id\" id=\"taxon_id\" value=\"".$array_taxon_list_unique[$i]."\"</td>\n";
        //checkbox
        $content .= "<td><a href=\"viewtaxon.php?lv=".$lv."&sid=".$id."\">".taxon_name($lv, $id)."</a></td>\n";
        $content .= "</tr>\n";
      }
    }      
    $content .= "<tr>\n";
    $content .= "<td>\n";
    $content .= "<input id=\"selection2\" name=\"selection2\" type=\"hidden\" />";
    $content .= "<input id=\"selectListButton2\" name=\"selectListButton2\" type=\"submit\" value=\"Add\" />";
    $content .= "</td>";
    $content .= "</tr>";
    $content .= "</table>\n";
    $content .= "</form>";

    
    
  }
  
  	  
  mysql_close($link);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
    <meta name="Description" content="Saint Louis University, tissue, species information" />
    <meta name="Keywords" content="Saint Louis University, tissue, information" />
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <!--<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />-->
    <meta name="Distribution" content="Global" />
    <meta name="Author" content="Richard Mayden - cypriniformes@gmail.com, Elvis Hsin-Hui Wu - hwu5@slu.edu" />
    <meta name="Robots" content="index,follow" />
    <link rel="stylesheet" href="edit.css" type="text/css" /><!--Does this file edit.css should be keep?-->	
    <!--<link rel="shortcut icon" type="image/ico" href="http://www.sprymedia.co.uk/media/images/favicon.ico" />-->
	<script type="text/javascript" src="jquery/jquery.js"></script>
    <script type="text/javascript" src="jquery/jquery.ui.js"></script>
		<title><? echo $title; ?></title>
		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
    
	<script type="text/javascript">
      
      $(document).ready(function() {
        $("#selectListButton").click(function(){
          var selection = "";
          var counter = 1;
          $("input[name='post_id']").each(function() {
            if(this.checked == true){
              //alert($(this).val());
              //alert($("#extend_date_"+ counter).val());
              selection += $(this).val() + ",";
              selection += $("#extend_date_"+ counter).val() + ";";
            }
            //alert($("#extend_date_"+ counter).val());
            counter++;
          });
          
          $('#selection').val(selection);
          //alert("Selection is :: " + selection);
        });

        $("#selectListButton2").click(function(){
          var selection2 = "";
          $("input[name='taxon_id']").each(function() {
            if(this.checked == true){
              selection2 += $(this).val() + ",";
            }
          });
          
          $('#selection2').val(selection2);
          //alert("Selection2 is :: " + selection2);
        });
        
      });
    </script>
		</head>
  <body id="dt_example">
		<div id="container">	
			<h1><? echo $caption; ?></h1>
      <?php
        include("menu.php");
      ?>
      <h2><?php echo $caption2; ?></h2>
      <div id="demo">
        <?php echo $content; ?>
      </div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
  </body>
</html>