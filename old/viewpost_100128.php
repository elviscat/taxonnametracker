<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //March 17, 2009 Tuesday:: Show the Proposed Changes OR Suggestted Name Changes Detail
  //Dec 11, 2009 Friday:: Add the review opinion checkbox
  //Dec 21, 2009 Monday:: small revised
  //Jan 12, 2010 Tuesday:: Minor Modification
  // ./ current directory
  // ../ up level directory
  //!?!?
  session_start();
  //!?!?
  require('inc/config.inc.php');
  
  
  //$caption = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes";
  $caption = $application_caption;
  $title = "Proposed Changes or Suggestted Name Changes List Detail";
  
  $table = "";
  $replyTitle = "";
  include('template/dbsetup.php');

  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);

  $pid = htmlspecialchars($_GET['pid'],ENT_QUOTES);
  //echo "pid is :: ".$pid."<br>\n";
  //$pid = $_GET['pid'];
  //$username = htmlspecialchars($_GET['username'],ENT_QUOTES);
  //echo "username is :: ".$username."<br>\n";
  
  $sql = "";
  if($pid != ""){
    //
    $sql = "SELECT * FROM post WHERE pid= '".$pid."'";
  }else{
    echo "Null Pointer!\n";
    exit;
  }
  /*
  elseif($username != ""){
    //
    $sql_get_uid = "SELECT uid FROM user WHERE username ='".$username."'";
    $result_sql_get_uid = mysql_query($sql_get_uid);
    //echo "sql_get_uid is ".$sql_get_uid;
    $uid = mysql_result($result_sql_get_uid, 0);    
    $sql = "SELECT * FROM post WHERE prefuid= '".$uid."'";
  }
  */
  
    
  //echo "<BR>sql is ".$sql;
  
  $result = mysql_query($sql);
  
  //$sid = "";
  $prefsid = "";
  $prreflv = "";
  
  if( mysql_num_rows($result) > 0 ){  
    while ( $nb2 = mysql_fetch_array($result) ) {
		  //$sid = $nb2[6];
		  $prefsid = $nb2[6];
		  $preflv = $nb2[5];
		  
		  
      //$table .= "<p>Create Time:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$nb2[3]."</p>";//create time
      //$table .= "<p>Title:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>".$nb2[1]."</b></p>";//title
      $replyTitle = $nb2[1];
      //$table .= "<p>Content:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$nb2[2]."</p>";// full content
      
      $table .= "<font color=\"gray\">".$nb2[3]."</font><BR>";//Time
      $table .= "<h3><B><font color=\"black\">Topic: ".$nb2[1]."</font></B></h3>";//Title
      
      //$post_author_name = "";
      /*
      if( $nb2[4] == 0){
        $post_author_name = "admin";
      }else{
        $sql2 = "SELECT name FROM user WHERE uid ='".$nb2[4]."'";
        $result2 = mysql_query($sql2);
        //echo "sql2 is ".$sql2;
        $post_author_name = mysql_result($result2, 0);
      }
      */

      $sql_post_author_username = "SELECT username FROM user WHERE uid ='".$nb2[4]."'";
      $result_sql_post_author_username = mysql_query($sql_post_author_username);
      //echo "sql_post_author_username is ".$sql_post_author_username;
      $post_author_username = mysql_result($result_sql_post_author_username, 0);
      
      $sql_post_author_name = "SELECT name FROM user WHERE uid ='".$nb2[4]."'";
      $result_sql_post_author_name = mysql_query($sql_post_author_name);
      //echo "sql_post_author_name is ".$sql_post_author_name;
      $post_author_name = mysql_result($result_sql_post_author_name, 0);
      
      
      
      $sql3 = "SELECT COUNT(*) FROM comment WHERE crefpid= '".$nb2[0]."'";
      //echo "sql3 is ".$sql3;
      $result3 = mysql_query($sql3);
      $commentCount = mysql_result($result3, 0);
      
      $table .= "<B><font color=\"blue\"><a href=\"viewpostlist.php?username=".$post_author_username."\">".$post_author_name."</a></font></b><BR>";//Posted by Author
      $table .= "<font color=\"black\">".$nb2[2]."</font><BR>";//Post Content      
      $table .= "<h3><B>Comments: <font color=\"blue\">".$commentCount."</font></B></h3>";//Comment Counter
      //$table .= "<B>".$name."</B> at <B>".$nb2[3]."</B> Post | Comment (<B>".$commentCount."</B>)<BR><BR>";
      //$table .= "<hr NOSHADE>";      
	  }

	}else{
	  //echo $sql;
	  $table .= "<p>Currently, there are no post right now.</p>"; //no records here
	  //Header("location:authorizedFail.php");
  }
  
  $sql = "SELECT * FROM comment WHERE crefpid= '".$pid."' AND comment_type = '0'"; 
  //echo "<BR>sql is ".$sql;
  
  $result = mysql_query($sql);
  
  //$table .= "<h2><p>Comment</p></h2>";
  
  if( mysql_num_rows($result) > 0 ){  
    $commentCounter = 0;
    while ( $nb2 = mysql_fetch_array($result) ) {
		  $commentCounter += 1;
      
      $commentor_username = "";
      $commentor_name = "";
      $sql_select_user_name = "SELECT * FROM user WHERE uid='".$nb2[4]."'";
      $result_sql_select_user_name = mysql_query($sql_select_user_name);
      if( mysql_num_rows($result_sql_select_user_name) > 0 ){
        while ( $nb3 = mysql_fetch_array($result_sql_select_user_name) ) {
          //
          //$user_name = $nb3[3];
          $commentator_username = $nb3[1];
          $commentator_name = $nb3[3];
        }
      }
      $table .= "<font color=\"blue\"><a href=\"viewpostlist.php?username=".$commentator_username."\">".$commentator_name."</a></font> commented on: <BR>";//Posted by Author
      
      $table .= "<b><font color=\"black\">".$nb2[1]."</font></b><br>";//Title
      $table .= "<font color=\"black\">".$nb2[2]."</font><BR>";//Post Content
      $table .= "<font color=\"gray\">".$nb2[3]."</font><BR><BR>";//Time
      
      /*
      $table .= "<p><b>".$nb2[1]."</b></p>";//ctitle
      $table .= "<p>".$nb2[2]."</p>";// full ccontent
      //$table .= "<p><a href=\detail.php?pid=".$nb2[0]."\">More</a><BR><BR>";
      $table .= "<B>".$nb2[5]."</B> at <B>".$nb2[3]."</B> Comment<BR><BR>";
      //$table .= "<hr NOSHADE>";
      */
	  }
	}else{
	  //echo $sql;
	  //$table .= "<p>Currently, there are no comments at this post.</p>"; //no records here
  }  
  //$table .= "<BR><BR><a href=\"showProposedChanges.php?sid=".$sid."\">Back to Proposed Changes OR Suggestted Name Changes List</a>";
  //$table .= "<BR><BR><a href=\"index.php\">Back to homepage</a>";
  
  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<!--<link rel="shortcut icon" type="image/ico" href="http://www.sprymedia.co.uk/media/images/favicon.ico" />-->
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" href="edit.css" type="text/css" />
    <style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
		<script type="text/javascript" language="javascript" src="media/js/jquery.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function(){
        //alert('review_opinion :: '+ $('#review_opinion').val());			  
      });
		</script>
    <script type="text/javascript">
    <!--
      function check() {
	      //alert('Hello Elvis');
        /*
        $("input[name='review_opinion']").each(function() {
          if(this.checked == true){
            //alert('review_opinion exists!');
            $("input[name='decision_suggestion']").each(function() {
              if(this.checked == true){
                //alert('decision_suggestion exists!');
                alert('You just can choose one selection!');
                return false;
              }
            });
            //return false;
          }
        });
        */
      }
    //-->
    </script>
	</head>
	<body id="dt_example">
		<div id="container">	
			<h1><?php echo $caption; ?></h1>
      <?php
        include("menu.php");
      ?>
      <h2><?php echo $title; ?></h2>
      <div id="demo">
        <!--Table is here!!-->
        <?php 
          echo $table;
        ?>
        <!--Table is here!!-->
        <form id="commentPost" action="postProposedChangesComment.php" method="post">
          <input id="crefpid" name="crefpid" type="hidden" value="<? echo $pid; ?>" />
          <table>
            <!--
            <tr>
              <td colspan=2><h3><b>Add a new comment</b></h3></td>
            </tr>
            -->
            <tr>
              <td colspan=2><b>Please post your comment here</b></td>
            </tr>
            <tr>
              <td ><label>Topic: </label></td>
              <td ><input id="ctitle" name="ctitle" type="text" size="50" value="<? echo "RE:".$replyTitle; ?>" /></td>
            </tr>
            <tr>
              <td ><label>Comment: </label></td>
              <td ><textarea name="ccontent" rows="10" cols="50"></textarea></td>
            </tr>
            <?php
              $sql_names_committee_member = "SELECT user_id FROM committee_member WHERE ref_c_id IN (";
              $sql_names_committee_member .= "SELECT ref_c_id FROM committee_account WHERE level= '".$preflv."' AND account_id ='".$prefsid."'";
              $sql_names_committee_member .= ")";
              //echo "sql_names_committee_member is :: ".$sql_names_committee_member."<br>\n";
              $result_sql_names_committee_member = mysql_query($sql_names_committee_member);
              if( mysql_num_rows($result_sql_names_committee_member) > 0 ){
                while ( $nb3 = mysql_fetch_array($result_sql_names_committee_member) ) {
                  $uid = htmlspecialchars($_SESSION['uid'],ENT_QUOTES); 
                  if( $uid == $nb3[0]){
                    echo "<tr>\n";
                    echo "<td ><label>Post this comment as a review opinion?: </label></td>\n";
                    echo "<td ><input id=\"review\" name=\"review\" type=\"radio\" value=\"is_review_opinion\"></td>\n";
                    echo "</tr>\n";
                    //echo "Yes<br>\n";
                  }
                  //echo "nb3 is :: ".$nb3[0]."<br>\n";
                  //echo "uid is :: ".$uid."<br>\n";
                }
              }

            ?>
            <?php
              $sql_names_committee_member_chair = "SELECT user_id FROM committee_member WHERE ref_c_id IN (";
              $sql_names_committee_member_chair .= "SELECT ref_c_id FROM committee_account WHERE level= '".$preflv."' AND account_id ='".$prefsid."'";
              $sql_names_committee_member_chair .= ") AND level = '1'";
              //echo "sql_names_committee_member_chair is :: ".$sql_names_committee_member_chair."<br>\n";
              $result_sql_names_committee_member_chair = mysql_query($sql_names_committee_member_chair);
              if( mysql_num_rows($result_sql_names_committee_member_chair) > 0 ){
                while ( $nb_result_sql_names_committee_member_chair = mysql_fetch_array($result_sql_names_committee_member_chair) ) {
                  if( $uid == $nb_result_sql_names_committee_member_chair[0]){
                    echo "<tr>\n";
                    echo "<td ><label>Post this comment as a decision suggestion?: </label></td>\n";
                    echo "<td ><input id=\"review\" name=\"review\" type=\"radio\" value=\"is_decision_suggestion\"></td>\n";
                    echo "</tr>\n";
                    //echo "Yes<br>\n";
                  }
                  //echo "nb3 is :: ".$nb3[0]."<br>\n";
                  //echo "uid is :: ".$uid."<br>\n";
                }
              }

            ?>
            <tr>
              <td colspan=2>
                <button type="submit">Submit</button>
              </td>
            </tr>
          </table>
        </form>
      </div>  
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>      
<?php
  mysql_close($link);
?>
	</body>
</html>


