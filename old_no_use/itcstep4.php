<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 03, 2009 Tuesday:: system administrator invite registered users to names committee step 4
  //Jan 26, 2010 Tuesday:: add template code section, and layout modification
  //April 07, 2010 Wednesday:: modify the email function, change from_email and from_email_name to new variable, it refer from the configuration file
  // ./ current directory
  // ../ up level directory
  
  //header("Cache-control: private");
  //session_cache_limiter("none");
  
  //header("Cache-control: private");
  //session_cache_limiter("none");
  
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
  $users = htmlspecialchars($_POST['users'],ENT_QUOTES);
  //echo "Variable users is :: ".$users."<br>\n";
  $accounts = htmlspecialchars($_POST['accounts'],ENT_QUOTES);
  //echo "Variable accounts is :: ".$accounts."<br>\n";
  $option = htmlspecialchars($_POST['option'],ENT_QUOTES);
  //echo "Variable option is :: ".$option."<br>\n";
  //Configuration of POST and GET Variables
    
  $caption = $application_caption;
  $caption2 = "System Administrator Invite Registered Users to Names Committee Step 4<BR>";
  $caption2 .= "STEP1: Select user first<BR>";
  $caption2 .= "STEP2: Select Names Committee or Taxon Step 2: Select one or more nomenclature accounts<BR>";
  $caption2 .= "<font color=\"Red\">STEP3: Send Invitation to user Step 3: Select one or more nomenclature accounts</font><BR>";
  $caption2 .= "STEP4: Send invitation! Step 4: Results<BR>";
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
          //echo "Your option is ::"." ".$option."<br>\n";
          $user_name = "";
          //$account_name = "";
          //$is_contained = false;
          $array_users = explode(",", $users);
          
          //
            $maxid = 0;
            $max_id_sql = "SELECT (Max(id)+1) FROM invitation_log";
		        $result_max_id = mysql_query($max_id_sql);	  
            list($maxid) = mysql_fetch_row($result_max_id);
		        if($maxid == 0){
		          $maxid = 1;
		        }          
          
          //
          
          for($i = 0; $i < sizeof($array_users);$i++){
            //echo $array_users[$i]."<br>";
            $sql_user_name = "SELECT * FROM user WHERE uid = ".$array_users[$i];
            $result_sql_user_name = mysql_query($sql_user_name);
            if(mysql_num_rows($result_sql_user_name) > 0){
              while ( $nb = mysql_fetch_array($result_sql_user_name) ) {
                $user_name = $nb[3];
              }
            }            
            $array_accounts = explode(",", $accounts);
            //echo $accounts."<br>\n"; 
            $account_name = "";
            $account_id = "";
            
            for($j = 0; $j < sizeof($array_accounts);$j++){
              if( $option == "option1" ){
                //$account_name .= $array_accounts[$j].",";
                $sql_account_name = "";
                $sql_account_name .= "SELECT * FROM committee_grp WHERE id = ".$array_accounts[$j];
                $result_sql_account_name = mysql_query($sql_account_name);
                //echo "sql_account_name is ::".$sql_account_name."<br>\n";
                if(mysql_num_rows($result_sql_account_name) > 0){
                  while ( $nb2 = mysql_fetch_array($result_sql_account_name) ) {
                    $account_id .= $nb2[0].",";
                    $account_name .= $nb2[1].",";
                  }
                }
                 
              }else{
                //echo $array_accounts[$j]."<br>";
                $array_accounts2 = explode(":", $array_accounts[$j]); 
                $sql_account_name = "";
                //$sql_account_name = "";
                if($array_accounts2[0] == "family"){
                  //
                  $sql_account_name .= "SELECT fid, ffamily FROM flist WHERE fid = ".$array_accounts2[1];
                }elseif($array_accounts2[0] == "genus"){
                  //
                  $sql_account_name .= "SELECT gid, ggenus FROM glist WHERE gid = ".$array_accounts2[1];
                }elseif($array_accounts2[0] == "species"){
                  //
                  $sql_account_name .= "SELECT sid, sgenus, sspecies FROM slist WHERE sid = ".$array_accounts2[1];
                }
                $result_sql_account_name = mysql_query($sql_account_name);
                //echo "sql_account_name is ::".$sql_account_name."<br>\n";
                if(mysql_num_rows($result_sql_account_name) > 0){
                  while ( $nb2 = mysql_fetch_array($result_sql_account_name) ) {              
                    //
                    $account_id .= $array_accounts2[0].":".$nb2[0].",";
                    if($array_accounts2[0] == "species"){
                      
                      $account_name .= $array_accounts2[0].":".$nb2[1]." ".$nb2[2].",";
                    }else{
                      $account_name .= $array_accounts2[0].":".$nb2[1].",";
                    }
                  }
                }
              }
            }  
            $account_name = substr($account_name, 0, -1);
            $account_id = substr($account_id, 0, -1);
            echo "You have already selected user: ".$user_name." on account: ".$account_name."<BR>";
            //the insert sql to table:invitation_log

            $regdatetime = date('Y-m-d h:i:s');
            $regdate = date('Y-m-d');
            $regtime = date('h:i:s');
            //date: 0000-00-00
            //time: 00:00:00 
            $act_code = md5($array_users[$i].$regdatetime);

            $insert_sql = "INSERT INTO invitation_log (`id`, `ref_user_id`, `ref_account`, `act_code`, `is_act`, `inv_date`, `inv_time`, `inv_type`, `inv_option`) ";
            $insert_sql .= "VALUES ('$maxid','$array_users[$i]','$account_id','$act_code','0', '$regdate', '$regtime', '1', '$option')";
            $maxid++;
            //echo "insert_sql is ".$insert_sql."\n<br>";
            $result=mysql_query($insert_sql);
            
            $eml = "";
            $sql_get_user_eml = "SELECT eml FROM user WHERE uid = '".$array_users[$i]."'";
            //echo "sql_get_user_eml is ::".$sql_get_user_eml."<br>\n";
            $result_sql_get_user_eml = mysql_query($sql_get_user_eml);
            if(mysql_num_rows($result_sql_get_user_eml) > 0){
              while ( $nb3 = mysql_fetch_array($result_sql_get_user_eml) ) {              
                $eml = $nb3[0];
              }
            }
            ///*
  //$admin_email = "elviscat@gmail.com";
  //$from_email_name = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes System Administrator";
  $from_email = $admin_email;
  $from_email_name = $from_email_name;
  
  //check the email address is okay or not
  $mail = new PHPMailer();
  $mail->IsSMTP(); // send via SMTP
  $mail->Host = "slumailrelay.slu.edu"; // SMTP servers
  $mail->SMTPAuth = false; // turn on SMTP authentication
  $mail->Username = ""; // SMTP username
  $mail->Password = ""; // SMTP password
  $mail->From = $from_email;
  $mail->FromName = $from_email_name;
  // åŸ·è¡Œ $mail->AddAddress() åŠ å…¥æ”¶ä»¶è€…ï¼Œå¯ä»¥å¤šå€‹æ”¶ä»¶è€…
  $mail->AddAddress($eml);
  //$mail->AddAddress("elviscat@gmail.com","elviscat2@gmail.com"); // optional name
  $mail->AddReplyTo($from_email,$from_email_name);
  $mail->WordWrap = 50; // set word wrap
  // åŸ·è¡Œ $mail->AddAttachment() åŠ å…¥é™„ä»¶ï¼Œå¯ä»¥å¤šå€‹é™„ä»¶
  //$mail->AddAttachment("path_to/file"); // attachment
  //$mail->AddAttachment("path_to_file2", "INF");
  // é›»éƒµå…§å®¹ï¼Œä»¥ä¸‹ç‚ºç™¼é€ HTML æ ¼å¼çš„éƒµä»¶
  
  $mail->IsHTML(true); // send as HTML
  $mail->Subject = "You have been invitated to join to this names committee in Cyber Nomenclatorial Process Platform of North American Freshwater Fishes at ".date('l jS \of F Y h:i:s A');
  //$mail->Body = "This is the <b>HTML body</b>";
  $mail->Body = "Hi ".$user_name.",<br>";
  $mail->Body .= "Please go to this link to activate your account to join into this names committee ".$account_name.":<BR>";
  $mail->Body .= "<a href=\"".curPageURL()."committee_member_activation.php?act_code=".$act_code."&userid=".$array_users[$i]."\">".curPageURL()."committee_member_activation.php?act_code=".$act_code."&userid=".$array_users[$i]."</a><br>";
  $mail->Body .= "<br>\n";
  $mail->Body .= "Sincerely,<br>";
  $mail->Body .= "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes System Administrator";
  $mail->AltBody = "This is the text-only body";
  if(!$mail->Send()){
    //echo "Your email is not valid, please type correct email again!";
    //echo "Mailer Error: " . $mail->ErrorInfo;
    exit;
  }else{
    echo "Hi System Administrator, you have already sent this invitation to user(s)!<br>\n";
    //echo "Go to <a href=\"login.php\">Login</a> to access your accounts on names committee<br>\n";
    //echo "Your email seems correct but need to validate again. Then the account would be activated! ";
  }
            
            //*/
          }                    
          
        ?>
<?php
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