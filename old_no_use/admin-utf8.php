<?php
  //Developed by elviscat (elviscat@gmail.com)
  //March 19, 2009 Thursday:: The administration interface (hub) :: link to other functions via the following hyperlink 
  //Nov 10, 2009 Tuesday:: Redesign the layout
  //Nov 15, 2009 Sunday: Redesign the registered user's layout
  // ./ current directory
  // ../ up level directory
  include('template/dbsetup.php');
  session_start();
  if( !isset($_SESSION['is_login']) ){
    Header("location:loginFail.php");
    exit();
  }
  //echo "Session of role is :: ".$_SESSION['role']."<br>\n";
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);

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

  $title = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes";
  $caption = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes";
  $caption2 = "Administration Management Page For User ".$real_name."(".$loginname.")";   
  $content = "";
  if( $role == "user" ){
	$content .= "<li><h2>On Names Committee</h2></li>";
    $content .= "1.<a href=\"view_committee.php\">View your Names Committee</a><br>";
    $content .= "2.<b>View review taxon account (You have right to post review opinion or decision suggestion on the following post):</b><br>";
    
    //SELECT ref_c_id FROM committee_member WHERE user_id ='".$uid."'
    //SELECT level, account_id FROM committee_account WHERE ref_c_id ='".$ref_c_id."'
    //SELECT pid FROM post WHERE preflv ='".$preflv."' AND prefsid ='".$prefsid."'
    //SELECT * FROM comment WHERE crefpid ='".$crefpid."' AND crefuid ='".$uid."'
    $sql_ref_c_id = "SELECT ref_c_id FROM committee_member WHERE user_id ='".$uid."'";
    //echo "sql_ref_c_id is ".$sql_ref_c_id."<br>\n";
    $result_sql_ref_c_id = mysql_query($sql_ref_c_id);
    if(mysql_num_rows($result_sql_ref_c_id) > 0){
      while ( $nb_sql_ref_c_id = mysql_fetch_array($result_sql_ref_c_id) ) {
        $ref_c_id = $nb_sql_ref_c_id[0];
        $sql_lv_sid = "SELECT level, account_id FROM committee_account WHERE ref_c_id ='".$ref_c_id."'";
        //echo "sql_lv_sid is ".$sql_lv_sid."<br>\n";
        $result_sql_lv_sid = mysql_query($sql_lv_sid);
        if(mysql_num_rows($result_sql_lv_sid) > 0){
          while ( $nb_sql_lv_sid = mysql_fetch_array($result_sql_lv_sid) ) {
            $preflv = $nb_sql_lv_sid[0];
            $prefsid = $nb_sql_lv_sid[1];
            
            $sql_pid = "SELECT pid FROM post WHERE preflv ='".$preflv."' AND prefsid ='".$prefsid."'";
            //echo "sql_pid is ".$sql_pid."<br>\n";
            $result_sql_pid = mysql_query($sql_pid);
            if(mysql_num_rows($result_sql_pid) > 0){
              while ( $nb_sql_pid = mysql_fetch_array($result_sql_pid) ) {
                $pid = $nb_sql_pid[0];
                
                $sql_comment = "SELECT * FROM comment WHERE crefpid ='".$pid."' AND crefuid ='".$uid."'";
                //echo "sql_comment is ".$sql_comment."<br>\n";
                $result_sql_comment = mysql_query($sql_comment);
                //$content .= "You have right to post review on this post!".$pid." <a href=\"viewpost.php?pid=".$pid."\">Go to post</a><br>\n";
                if(mysql_num_rows($result_sql_comment) > 0){
                  while ( $nb_sql_comment = mysql_fetch_array($result_sql_comment) ) {
                    $cid = $nb_sql_comment[0];
                    $comment_type = $nb_sql_comment[6];
                    if( $comment_type == "1" ){
                      $content .= "You have a review opinion!! <a href=\"view_ro.php?cid=".$cid."\">view</a><br>\n";
                    }elseif($comment_type == "2"){
                      $content .= "You have a decision suggestion!!  <a href=\"view_ds.php?cid=".$cid."\">view</a><br>\n";
                    }else{
                      //$content .= "cid is :: ".$cid."<br>\n";
                    }
                  }
                }else{
                  
                  $content .= "Go to <a href=\"viewpost.php?pid=".$pid."\">".$pid."</a> to post<br>\n";
                }
              }
            }
            
 
          }
        }    
      }
    }
	$content .= "<li><h2>Your Post and Comment Data</h2></li>";
    $content .= "<a href=\"postProposedChangesManage.php\">View your proposed changes or suggestted name changes data</a><br>";
    //$content .= "<a href=\"postProposedChangesManage.php\">Manage your proposed changes or suggestted name changes data</a><br>";
    //link to user function 1:: manage your post proposed changes or suggestted name changes
    $content .= "<a href=\"commentProposedChangesManage.php\">View your comment data</a><br>";
    //$content .= "<a href=\"commentProposedChangesManage.php\">Manage your comment data</a><br>";
    //link to user function 2:: manage your post comments

    $content .= "<li><h2>Personal profile and </h2></li>";
	$content .= "<a href=\"updateUserProfile.php\">Update your user profile</a><br>";
	$content .= "<a href=\"requestkey.php\">Request new email activation key</a><br>";
	

  }else if($role == "admin"){

	$content .= "<li><h2>Name List/Biological classification Management</h2></li>";
    $content .= "<a href=\"slist_table.php\">Species Browser</a><br>"; //link to administrator function 3:: manage family list data
    //$content .= "<a href=\"slistManage.php\">Manage species data</a><br>"; //link to administrator function 4:: manage species list data   
    $content .= "<li><h2>Names Committee Management</h2></li>";
    $content .= "<a href=\"itcstep1.php\">Invitation of registered user to Names Committee</a><br>"; //link to administrator function 1:: browse user information
    $content .= "<a href=\"committee_manage.php\">Names Committee Management</a><br>"; //link to administrator function 1:: browse user information
    $content .= "<li><h2>View Registered User</h2></li>";
    $content .= "<a href=\"browseUsers.php\">Browse registered user information</a><br>"; //link to administrator function 1:: browse user information
    //$content .= "<a href=\"browseLogs.php\">Browse Users Log History</a><br>"; //link to administrator function 2:: browse log information
  }
  mysql_close($link);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
    <meta name="Description" content="Saint Louis University, tissue, species information" />
    <meta name="Keywords" content="Saint Louis University, tissue, information" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
    <meta name="Distribution" content="Global" />
    <meta name="Author" content="Richard Mayden - cypriniformes@gmail.com, Elvis Hsin-Hui Wu - hwu5@slu.edu" />
    <meta name="Robots" content="index,follow" />
    <link rel="stylesheet" href="edit.css" type="text/css" /><!--Does this file edit.css should be keep?-->	
    <!--<link rel="shortcut icon" type="image/ico" href="http://www.sprymedia.co.uk/media/images/favicon.ico" />-->
		<title><? echo $title; ?></title>
		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
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