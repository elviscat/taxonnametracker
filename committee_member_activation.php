<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 03, 2009 Tuesday:: committee_member_activation.php
  //use this function to activate the invitation from invitation log and write this information to committee_grp, committee_member and committee_account 
  //Nov 15, 2009 Sunday::
  //Dec 28, 2009 Monday:: add the logic to prevent the duplicate insertation
  //Jan 26, 2010 Tuesday:: add template code section, and layout modification, logic check and change and test again
  // ./ current directory
  // ../ up level directory
  
  //template
  session_start();
  include('template/dbsetup.php'); 
  require('inc/config.inc.php');
  require('phpmailer/class.phpmailer.php');
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);  

  //Configuration of POST and GET Variables
    
  $act_code = htmlspecialchars($_GET['act_code'],ENT_QUOTES);
  //echo "Variable act_code is :: ".$act_code."<br>\n";
  $userid = htmlspecialchars($_GET['userid'],ENT_QUOTES);
  //echo "Variable userid is :: ".$userid."<br>\n";
  
  //Configuration of POST and GET Variables
    
  $caption = $application_caption;
  $caption2 = "Names Committee Member Activation<BR>";
  $caption2 .= "Activation Results.<BR>";
  $title = $application_caption."::".$caption2;
  //template

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
		<title><? echo $title; ?></title>
		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
		<script type="text/javascript" src="jquery/jquery-1.3.2.js"></script>
		<script type="text/javascript" src="jquery/jquery.doubleSelect.js"></script>
		<script type="text/JavaScript">
    $(document).ready(function(){

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
<?php
  //echo "act_code is :: ".$act_code."<br>\n";
  //echo "userid is :: ".$userid."<br>\n";
  $ref_accounts = "";
  $sql_activation = "SELECT * FROM invitation_log WHERE ref_user_id = '".$userid."' AND act_code = '".$act_code."' AND is_act = 0";
  //echo "Variable sql_activation is :: ".$sql_activation."<br>\n";
  $result_sql_activation = mysql_query($sql_activation);
  if(mysql_num_rows($result_sql_activation) > 0){    
    while ( $nb = mysql_fetch_array($result_sql_activation) ) {
       
      $id = $nb[0]; 
      $ref_user_id = $nb[1];
      //get the information from TABLE::invitation_log column::ref_account and write this information to committee_grp, committee_account and committee_member
      $ref_accounts = $nb[2];
      $inv_type = $nb[7];
      $inv_option = $nb[8];
      
      if( $inv_option == "option1"){
        //Just add this user to an existing names committee, insert this user into TABLE::committee_member
        
        /*
        $array_ref_accounts = explode(",", $ref_accounts);
        //echo "ref_accounts".$ref_accounts."<br>\n"; 
        for($i = 0; $i < sizeof($array_ref_accounts);$i++){
          $array_ref_accounts2 = explode(",", $array_ref_accounts[$i]);
          $sql_check_existing_account = "SELECT * FROM committee_account WHERE level ='".$array_ref_accounts2[0]."' AND account_id ='".$array_ref_accounts2[1]."' AND ref_c_id =(SELECT ref_c_id FROM committee_member WHERE user_id ='".$ref_user_id."')";
          echo "Variable sql_check_existing_account is :: ".$sql_check_existing_account."<br>\n";
          $result_sql_check_existing_account = mysql_query($sql_check_existing_account);
          if(mysql_num_rows($result_sql_check_existing_account) > 0){
            while ( $nb_sql_check_existing_account = mysql_fetch_array($result_sql_check_existing_account) ) {
              echo "Duplicated account activation!\n";
              exit;
            }
          }
          
        }
        */       
        
        //Find maximun id number in committee_member
        $maxid = 0;
        $max_id_sql = "SELECT (Max(id)+1) FROM committee_member";
		    $result_max_id = mysql_query($max_id_sql);	  
        list($maxid) = mysql_fetch_row($result_max_id);
		    if($maxid == 0){
		      $maxid = 1;
		    }
        
        $sql_insert1 = "INSERT INTO committee_member (`id`, `user_id`, `ref_c_id`, `level`) ";
        $sql_insert1 .= "VALUES ('$maxid','$ref_user_id','$ref_accounts','0')";
        //echo "sql_insert1 is ".$sql_insert1."\n<br>";
        mysql_query($sql_insert1);  
        
        /*
        for($i = 0; $i < sizeof($array_ref_accounts);$i++){
          //STEP1::make sure if there is already the same user in TABLE::committee_member!?!?
          //Have not been implementation
          //STEP2::INSERT it INTO This TABLE
          
          $sql_insert1 = "INSERT INTO committee_member (`id`, `user_id`, `ref_c_id`, `level`) ";
          $sql_insert1 .= "VALUES ('$maxid','$userid','$array_ref_accounts[$i]','0')";
          echo "sql_insert1 is ".$sql_insert1."\n<br>";
          $maxid++;
          //insert this information to this table!
          //$result=mysql_query($sql_insert1);                    
          
          //
        }
        */
        
      }else{
        //option 2: add this user into an new names committee
        //STEP1::Create new names committee in TABLE::committee_grp
        $maxid_committee_grp = 0;
        $maxid_committee_grp_sql = "SELECT (Max(id)+1) FROM committee_grp";
		    $result_maxid_committee_grp_sql = mysql_query($maxid_committee_grp_sql);	  
        list($maxid_committee_grp) = mysql_fetch_row($result_maxid_committee_grp_sql);
		    if($maxid_committee_grp == 0){
		      $maxid_committee_grp = 1;
		    }          
        $sql_insert1 = "INSERT INTO committee_grp (`id`, `committee_name`, `misc_note`) ";
        $sql_insert1 .= "VALUES ('$maxid_committee_grp','Default Name','Default Notes')";
        //echo "sql_insert1 is ".$sql_insert1."\n<br>";
        //insert this information to this table!
        mysql_query($sql_insert1);
        
        //STEP2:: insert this user information into TABLE::committee_member
        $maxid_committee_member = 0;
        $maxid_committee_member_sql = "SELECT (Max(id)+1) FROM committee_member";
		    $result_maxid_committee_member_sql = mysql_query($maxid_committee_member_sql);	  
        list($maxid_committee_member) = mysql_fetch_row($result_maxid_committee_member_sql);
		    if($maxid_committee_member == 0){
		      $maxid_committee_member = 1;
		    }          
        $sql_insert2 = "INSERT INTO committee_member (`id`, `user_id`, `ref_c_id`, `level`) ";
        $sql_insert2 .= "VALUES ('$maxid_committee_member','$ref_user_id', '$maxid_committee_grp','0')";
        //echo "sql_insert2 is ".$sql_insert2."\n<br>";
        //insert this information to this table!
        mysql_query($sql_insert2);
        
        $array_ref_accounts = explode(",", $ref_accounts);
        //echo "ref_accounts".$ref_accounts."<br>\n"; 
        
        $maxid_committee_account = 0;
        $maxid_committee_account_sql = "SELECT (Max(id)+1) FROM committee_account";
		    $result_maxid_committee_account_sql = mysql_query($maxid_committee_account_sql);	  
        list($maxid_committee_account) = mysql_fetch_row($result_maxid_committee_account_sql);
		    if($maxid_committee_account == 0){
		      $maxid_committee_account = 1;
		    }
        for($i = 0; $i < sizeof($array_ref_accounts);$i++){
          //STEP3::INSERT accounts information INTO TABLE::committee_account
          //Find maximun id number in committee_account
          $array_ref_accounts2 = explode(":", $array_ref_accounts[$i]);   
          $sql_insert3 = "INSERT INTO committee_account (`id`, `level`, `account_id`, `ref_c_id`) ";
          $sql_insert3 .= "VALUES ('$maxid_committee_account','$array_ref_accounts2[0]', '$array_ref_accounts2[1]','$maxid_committee_grp')";  
          //echo "sql_insert3 is ".$sql_insert3."\n<br>";
          $maxid_committee_account++;
          
          //insert this information to this table!
          mysql_query($sql_insert3);
        }
      }
      //
      //
      //In TABLE::invitation_log, change the column "is_act" from 0 to 1
      $sql_update_is_act = "UPDATE invitation_log SET `is_act` = '1' WHERE `id` =".$id." LIMIT 1";
      //echo "Variable sql_update_is_act is :: ".$sql_update_is_act."<br>\n";
      mysql_query($sql_update_is_act);
      //In TABLE::invitation_log, change the column "is_act" from 0 to 1
      echo "You have already activated to join into names committee!<br>\n";
      echo "Go to <a href=\"login.php\">Login</a> to access your accounts admin page to view names committee function.<br>\n";

    }
  }else{
    echo "Your information may not be coressponding to our records! Please try the correct information to activate!<br>\n";
  }
  mysql_close($link);
?>
      </div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
  </body>
</html>