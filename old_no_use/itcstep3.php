<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Oct 27, 2009 Tuesday:: system administrator invite registered users to names committee step 3
  //Jan 26, 2010 Tuesday:: add template code section, and layout modification
  //Modified on Nov 03, 2009 Tuesday
  // ./ current directory
  // ../ up level directory
  
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
  $caption2 = "System Administrator Invite Registered Users to Names Committee Step 3<BR>";
  $caption2 .= "STEP1: Select user first<BR>";
  $caption2 .= "STEP2: Select Names Committee or Taxon Step 2: Select one or more nomenclature accounts<BR>";
  $caption2 .= "<font color=\"Red\">STEP3: Send Invitation to user Step 3: Select one or more nomenclature accounts</font><BR>";
  $caption2 .= "STEP4: Send invitation!<BR>";
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
	    $("#submit_button").click(function(){
		    alert("Are you sure you want to send invitation?")
        if( $('#users').val() =="" || $('#accounts').val() =="" || $('#option').val() =="") {
          alert("You need to select at least one user or one taxon");
          return false;
        }
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
        <?php
          //echo "Your option is ::"." ".$option."<br>\n";
          $user_name = "";
          //$account_name = "";
          //$is_contained = false;
          $array_users = explode(",", $users);
                    
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
            
            for($j = 0; $j < sizeof($array_accounts);$j++){
              if( $option == "option1" ){
                //$account_name .= $array_accounts[$j].",";
                $sql_account_name = "";
                $sql_account_name .= "SELECT * FROM committee_grp WHERE id = ".$array_accounts[$j];
                $result_sql_account_name = mysql_query($sql_account_name);
                //echo "sql_account_name is ::".$sql_account_name."<br>\n";
                if(mysql_num_rows($result_sql_account_name) > 0){
                  while ( $nb2 = mysql_fetch_array($result_sql_account_name) ) {
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
                  $sql_account_name .= "SELECT ffamily FROM flist WHERE fid = ".$array_accounts2[1];
                }elseif($array_accounts2[0] == "genus"){
                  //
                  $sql_account_name .= "SELECT ggenus FROM glist WHERE gid = ".$array_accounts2[1];
                }elseif($array_accounts2[0] == "species"){
                  //
                  $sql_account_name .= "SELECT sgenus, sspecies FROM slist WHERE sid = ".$array_accounts2[1];
                }
                $result_sql_account_name = mysql_query($sql_account_name);
                //echo "sql_account_name is ::".$sql_account_name."<br>\n";
                if(mysql_num_rows($result_sql_account_name) > 0){
                  while ( $nb2 = mysql_fetch_array($result_sql_account_name) ) {              
                    //
                    if($array_accounts2[0] == "species"){
                      $account_name .= $array_accounts2[0].":".$nb2[0]." ".$nb2[1].",";
                    }else{
                      $account_name .= $array_accounts2[0].":".$nb2[0].",";
                    }
                  }
                }
              }
            }  
            $account_name = substr($account_name, 0, -1);
            echo "You have already selected user: ".$user_name." on account: ".$account_name."<BR>";
            //the insert sql to table:invitation_log

            
            //*/
          }                    
          
        ?>
<?php
mysql_close($link); 
?>

        <form id="form" action="itcstep4.php" method="post">
          <table>
            <tr>
              <td colspan=2>
                <input id="users" name="users" type="hidden" value="<?php echo $users; ?>" />
                <input id="accounts" name="accounts" type="hidden" value="<?php echo $accounts; ?>" />
                <input id="option" name="option" type="hidden" value="<?php echo $option; ?>" />
              </td>
            </tr>
            <tr>
              <td colspan=2><input name="submit_button" id="submit_button" type="submit" value="Save and send the message!" /></td>
            </tr>                        
          </table>
        </form>
        <!--<br><a href="itcstep2.php">Back to Step 2</a>-->

      
      </div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
  </body>
</html>