<?php
  //Developed by elviscat (elviscat@gmail.com)
  //March 17, 2009 Tuesday:: Show the Proposed Changes OR Suggestted Name Changes Detail
  //Dec 11, 2009 Friday:: Add the review opinion checkbox
  //Dec 21, 2009 Monday:: small revised
  //Jan 12, 2010 Tuesday:: Minor Modification
  //Jan 28, 2010 Thursday:: 1.Add a logic to lock comment form when the state of this post is no longer belonging to 'under_review'.
  //2.Add prevent unll comment javascript
  //3.Add taxon name on caption
  //Mar 10, 2010 Wednesday:: Add the link of uploaded files
  //Mar 12, 2010 Friday:: Add the link of delete attachment when this posted proposed change is still under review
  //April 12, 2010 Monday:: Modify the comment interface from radio button to checkbox
  //April 19, 2010 Monday:: Modification from Rick's new demand
  //June 03, 2010 Thursday:: Debug and apply to new layout
  //June 15, 2010 Tuesday:: Function of recording the log history on each post
  //July 01, 2010 Thursday:: Modification 
  //July 02, 2010 Friday:: pstate = 2 layout, cast the vote
  //July 03, 2010 Saturday:: add vote_desc column
  //February 26, 2011 Saturday:: Code Logic modification
  //./ current directory
  // ../ up level directory

  include('template0.php');
  
  session_start();
  $role = $_SESSION['role'];
  //echo "Role is ".$role."<br>\n";
  
  //customized setup
  
  //Configuration of POST and GET Variables

  $pid = htmlspecialchars($_GET['pid'],ENT_QUOTES);
  //echo "Variable pid is :: ".$pid."<br>\n";

  //Configuration of POST and GET Variables
  
  //$taxon_name = taxon_name_by_pid($pid);//Marked on February 26, 2011 Saturday
  $table = "";
  $replyTitle = "";

  
  $sql = "";
  if($pid != ""){
    //
    $sql = "SELECT * FROM post WHERE pid= '".$pid."'";
  }else{
    echo "There is data here, exit!\n";
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
  
  //$prefsid = "";//Marked on February 26, 2011 Saturday
  //$prreflv = "";//Marked on February 26, 2011 Saturday
  
  $pstate = "";
  
  if( mysql_num_rows($result) > 0 ){  
    while ( $nb2 = mysql_fetch_array($result) ) {
		  //$sid = $nb2[6];
		  $pref_taxa = $nb2[5];
		  
      //$array_pref_taxa = explode(";", $pref_taxa);
		  
		  //$prefsid = $nb2[6];
		  //$preflv = $nb2[5];
		  
      $pattachment_id = $nb2[12];//Attachment ID
		  
		  $prefuid = $nb2[4];
		  $pstate = $nb2[10];//pstate
		  
      //$table .= "<p>Create Time:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$nb2[3]."</p>";//create time
      //$table .= "<p>Title:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>".$nb2[1]."</b></p>";//title
      $replyTitle = $nb2[1];//title
      //$table .= "<p>Content:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$nb2[2]."</p>";// full content
      
      $table .= "<font color=\"gray\">".$nb2[3]."</font><BR>";//Time
      $table .= "<h3><B><font color=\"black\">Topic: ".$nb2[1]."</font></B></h3>";//Title
      
  //$uid is here!
  $uid = htmlspecialchars($_SESSION['uid'],ENT_QUOTES);
  //$uid is here!
  
  
  //record this log into the table::post_log
  $log_datetime = date("Y-m-d H:i:s");//"2008-08-28 11:03:21"

  $max_post_view_log_id = 0;
  $sql_max_post_view_log_id = "SELECT (Max(id)+1) FROM post_view_log";
	$result_max_post_view_log_id = mysql_query($sql_max_post_view_log_id);	  
  list($max_post_view_log_id) = mysql_fetch_row($result_max_post_view_log_id);
	if($max_post_view_log_id == 0){
	  $max_post_view_log_id = 1;
	}
  $sql_operation = "INSERT INTO post_view_log (id, log_datetime, refuid,	refpid)";
  $sql_operation .= " VALUES ('$max_post_view_log_id','$log_datetime','$uid','$pid')";
  $result_operation = mysql_query($sql_operation);

  //record this log into the table::post_log 
  


  //July 01, 2010 Thursday:: New Logic of Comment Interface

  //$ref_c_id = get_ref_c_id_from_pid($pid);

  //Here added on April 12, 2010 Monday refactoring the code
  $is_names_committee_member = False;
  $is_names_committee_member_chair = False;  
  $sql_committee_member = "SELECT * FROM committee_member WHERE ref_pid = '".$pid."' AND ref_uid ='".$uid."'";
  //echo "Variable sql_committee_member is <b>".$sql_committee_member."</b><br>\n";
  $result_committee_member = mysql_query($sql_committee_member);
  if( mysql_num_rows($result_committee_member) > 0 ){
    while ( $nb_committee_member = mysql_fetch_array($result_committee_member) ) {
      //
      $join_status = $nb_committee_member[4];
      $rank_level = $nb_committee_member[5];
    }
  }
  if( $join_status == "Accept" ){
    if( $rank_level == "Member" ){
      //show review opinion interface
      $is_names_committee_member = True;
    }
    if( $rank_level == "Chair" ){
      //show review opinion interface
      //show recommended decision interface
      $is_names_committee_member = True;
      $is_names_committee_member_chair = True;
    }
  }  

  /*
  if( $uid != "" ){
    $sql_names_committee_member = "SELECT user_id, rank_level FROM committee_member WHERE ref_c_id IN (";
    $sql_names_committee_member .= "SELECT ref_c_id FROM committee_account WHERE level= '".$preflv."' AND account_id ='".$prefsid."'";
    $sql_names_committee_member .= ") AND user_id = '".$uid."'";
    //echo "sql_names_committee_member is :: ".$sql_names_committee_member."<br>\n";
    $result_names_committee_member = mysql_query($sql_names_committee_member);
    if( mysql_num_rows($result_names_committee_member) > 0 ){
      $is_names_committee_member = True;
      while ( $nb_names_committee_member = mysql_fetch_array($result_names_committee_member) ) {
        //
        //if( $uid == $nb_names_committee_member[0]){
          //$sql_comment_where_clause = "AND ( comment_type = '0' OR comment_type = '1')";
        //}
        //
        if( $nb_names_committee_member[1] == "chair"){
          $is_names_committee_member_chair = True;
          //$sql_comment_where_clause = "AND ( comment_type = '0' OR comment_type = '1' OR comment_type = '2')";
        }      
      }
    }
  }
  */
  //
  //July 01, 2010 Thursday:: New Logic of Comment Interface
  
  //Here added on April 12, 2010 Monday refactoring the code




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
      
      

      
      $table .= "<B><font color=\"blue\"><a href=\"viewpostlist.php?username=".$post_author_username."\">".$post_author_name."</a></font></b><BR>";//Posted by Author
      $table .= "<font color=\"black\">".$nb2[2]."</font><BR>";//Post Content
      
      //Add the link of attachment, Mar 10, 2010 Wednesday
      if($pattachment_id != ""){
      	$table .= "<b>Attachments:</b><br>";
      	//echo "Attachment id is ".$pattachment_id."<br>\n";
        $pattachment_id_array = explode(";", $pattachment_id);
      	for($i = 0; $i < sizeof($pattachment_id_array); $i++){
      	  //echo "Attachment_id is ".$pattachment_id_array[$i]."<br>\n";
      	  $sql_attachment = "SELECT * FROM upload WHERE id ='".$pattachment_id_array[$i]."'";
          $result_sql_attachment = mysql_query($sql_attachment);
          if(mysql_num_rows($result_sql_attachment) > 0){
            while ( $nb_sql_attachment = mysql_fetch_array($result_sql_attachment) ) {
              $table .= "<a href=\"download.php?id=".$nb_sql_attachment[0]."\">".$nb_sql_attachment[1]."</a>";
              //$table .= "<a href=\"download.php?id=".$nb_sql_attachment[0]."\">".$nb_sql_attachment[1]."</a><br>";
              //$table .= $_SESSION['username']."</a><br>";
              
              
              $sql_uid_check = "SELECT * FROM user WHERE uid ='".$prefuid."'";
              $result_sql_uid_check = mysql_query($sql_uid_check);
              if(mysql_num_rows($result_sql_uid_check) > 0 && $pstate != "Pending" && $pstate != "Closed" ){
                while ( $nb_sql_uid_check = mysql_fetch_array($result_sql_uid_check) ) {
                  if( $nb_sql_uid_check[1] == $_SESSION['username']){
                    $table .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"images/delete.gif\" /><a href=\"delete_attachment.php?id=".$nb_sql_attachment[0]."&pid=".$pid."\">Delete the attachment</a>";  
                  }
                  //$table .= "<a href=\"download.php?id=".$nb_sql_attachment[0]."\">".$nb_sql_attachment[1]."</a><br>";
                  //$table .= $_SESSION['username']."</a><br>";
                }
              }
              $table .= "<br>\n";
            }
          }
      	}
      	
      }
      
      $sql_comment_where_clause = "AND ( comment_type = 'General Commnet')";
      $sql3 = "SELECT COUNT(*) FROM comment WHERE crefpid= '".$nb2[0]."' ".$sql_comment_where_clause;
      //echo "sql3 is ".$sql3;
      $result3 = mysql_query($sql3);
      $commentCount = mysql_result($result3, 0);      
      $table .= "<h3><B>Comments: <font color=\"blue\">".$commentCount."</font></B></h3>";//Comment Counter
      //$table .= "<B>".$name."</B> at <B>".$nb2[3]."</B> Post | Comment (<B>".$commentCount."</B>)<BR><BR>";
      //$table .= "<hr NOSHADE>";      
	  }

	}else{
	  //echo $sql;
	  //$table .= "<p>Currently, there are no post right now.</p>"; //no records here
	  $table .= "<p>No post.</p>"; //no records here
	  //Header("location:authorizedFail.php");
  }
  

  /*
  if( $is_names_committee_member == True ){
    echo "The True/False of Variable is_names_committee_member is :: True<br>\n";
  }else{
    echo "The True/False of Variable is_names_committee_member is :: False<br>\n";
  }
  //echo "The True/False of Variable is_names_committee_member is ::".$is_names_committee_member."<br>\n";
  if( $is_names_committee_member_chair == True ){
    echo "The True/False of Variable is_names_committee_member_chair is :: True<br>\n";
  }else{
    echo "The True/False of Variable is_names_committee_member_chair is :: False<br>\n";
  }
  */
  
  
  //List the general comments, April 19, 2010 Monday
  $sql_comment_where_clause = "AND ( comment_type = 'General Commnet')";
  $sql = "SELECT * FROM comment WHERE crefpid= '".$pid."' ".$sql_comment_where_clause;
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
      //Label of review opinion ans decision suggestion
      $comment_type = $nb2[6];
      if( $comment_type == "1" ){
        $table .= "<font color=\"red\">Review Opinion</font>";
      }elseif( $comment_type == "2" ){
        $table .= "<font color=\"red\">Decision Suggestion</font>";
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
	}
  //else{
	  //echo $sql;
	  //$table .= "<p>Currently, there are no comments at this post.</p>"; //no records here
  //}
  
  //List the general comments, April 19, 2010 Monday
  if($is_names_committee_member == True || $role == "admin"){
    $sql_comment_where_clause = "AND ( comment_type = 'Review Opinion')";
    $sql3 = "SELECT COUNT(*) FROM comment WHERE crefpid= '".$pid."' ".$sql_comment_where_clause;
    //echo "sql3 is ".$sql3;
    $result3 = mysql_query($sql3);
    $commentCount = mysql_result($result3, 0);      
    $table .= "<h3><B>Review Opinions: <font color=\"blue\">".$commentCount."</font></B></h3>";//Comment Counter
    //$table .= "<B>".$name."</B> at <B>".$nb2[3]."</B> Post | Comment (<B>".$commentCount."</B>)<BR><BR>";
    //$table .= "<hr NOSHADE>"; 

    $sql = "SELECT * FROM comment WHERE crefpid= '".$pid."' ".$sql_comment_where_clause;
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
        //Label of review opinion ans decision suggestion
        $comment_type = $nb2[6];
        if( $comment_type == "1" ){
          $table .= "<font color=\"red\">Review Opinion</font>";
        }elseif( $comment_type == "2" ){
          $table .= "<font color=\"red\">Decision Suggestion</font>";
        }
      
        $table .= "<font color=\"blue\"><a href=\"viewpostlist.php?username=".$commentator_username."\">".$commentator_name."</a></font> commented on: <BR>";//Posted by Author
      
        $table .= "<b><font color=\"black\">".$nb2[1]."</font></b><br>";//Title
        $table .= "<font color=\"black\">".$nb2[2]."</font><BR>";//Post Content
        $table .= "<font color=\"gray\">".$nb2[3]."</font><BR><BR>";//Time
	    }
	  }    
    
  }

    
  //$table .= "<BR><BR><a href=\"showProposedChanges.php?sid=".$sid."\">Back to Proposed Changes OR Suggestted Name Changes List</a>";
  //$table .= "<BR><BR><a href=\"index.php\">Back to homepage</a>";
  
  
  //$caption = "Post Proposed Change on Taxon: <BR>\n".$taxon_name."<BR>\nProposed Changes or Suggested Name Changes Detail and Conversation";//Marked on February 26, 2011 Saturday
  $caption = "";//New on February 26, 2011 Saturday
  //customized setup  

  include('template1.php');
?>



    <?php echo "<h2>".$caption."</h2><br>\n"; ?>
    
    <!--???CSS???-->
    <!--    
		<link rel="stylesheet" href="edit.css" type="text/css" />
    <style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
		-->
		<!--???CSS???-->
    <script type="text/javascript" language="javascript" src="media/js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="jquery/jquery.expander.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {

      // simple example, using all default options
      //$('div.expandable p').expander();
      //$('div.expandable').expander();
      // *** OR ***
  
      // override some default options
      /*
      $('div.expandable p').expander({
        slicePoint:       80,  // default is 100
        expandText:         '[...]', // default is 'read more...'
        collapseTimer:    5000, // re-collapses after 5 seconds; default is 0, so no re-collapsing
        userCollapseText: '[^]'  // default is '[collapse expanded text]'
      });
      */
      $('div.general_comment').expander({
        slicePoint:       80,  // default is 100
        expandText:         'Please post your comment here', // default is 'read more...'
        //collapseTimer:    5000, // re-collapses after 5 seconds; default is 0, so no re-collapsing
        userCollapseText: 'Collapse'  // default is '[collapse expanded text]'
      });

      $('div.review_opinion').expander({
        slicePoint:       80,  // default is 100
        expandText:         'Decision written here by Committee Chairperson or Admin of list to be sent to committee members', // default is 'read more...'
        //collapseTimer:    5000, // re-collapses after 5 seconds; default is 0, so no re-collapsing
        userCollapseText: 'Collapse'  // default is '[collapse expanded text]'
      });

      $('div.recommended_decision').expander({
        slicePoint:       80,  // default is 100
        expandText:         'Final decision written here by Committee Chairperson or Admin of list to be posted on line and Chairperson or Admin needs to be reminded to make changes in list or these need to be automated', // default is 'read more...'
        //collapseTimer:    5000, // re-collapses after 5 seconds; default is 0, so no re-collapsing
        userCollapseText: 'Collapse'  // default is '[collapse expanded text]'
      });

    });
    </script>



        <!--Table is here!!-->
        <?php 
          echo $table;
        ?>
        <!--Table is here!!-->
        <?php
          //July 01, 2010 Thursday:: New Logic of Comment Interface
          if( $pstate == "Submitted" ){//Just show up the general Comment Interface
            //echo "pstate is \"Submitted\"!";
            echo "<div class=\"general_comment\">";
            echo "<form id=\"commentPost\" action=\"postProposedChangesComment.php\" method=\"post\">\n";
            echo "<input id=\"comment_type\" name=\"comment_type\" type=\"hidden\" value=\"General Commnet\" />\n";
            echo "<input id=\"crefpid\" name=\"crefpid\" type=\"hidden\" value=\"".$pid."\" />\n";
              echo "<table>\n";
                echo "<tr>\n";
                  echo "<td colspan=\"2\"><b>Please post your comment here</b></td>\n";
                echo "</tr>\n";
                echo "<tr>\n";
                  echo "<td ><label>Topic: </label></td>\n";
                  echo "<td ><input id=\"ctitle\" name=\"ctitle\" type=\"text\" size=\"50\" value=\"RE:".$replyTitle."\" /></td>\n";
                echo "</tr>\n";
                echo "<tr>\n";
                  echo "<td ><label>Comment: </label></td>\n";
                  echo "<td ><textarea id=\"ccontent\" name=\"ccontent\" rows=\"10\" cols=\"50\"></textarea></td>\n";
                echo "</tr>\n";
                echo "<tr>\n";
                  echo "<td colspan=\"2\">\n";
                    echo "<button id=\"submit_button\" name=\"submit_button\" type=\"submit\">Submit</button>\n";
                  echo "</td>\n";
                echo "</tr>\n";
              echo "</table>\n";
            echo "</form></div>\n";          
          
          }elseif( $pstate == "Under Review" ){//Open Names Committee Member(s) Comment Interface (Review Opinions + Vote)
            
            //echo "pstate is 1!";
             
            echo "<div class=\"general_comment\">";
            echo "<form id=\"commentPost\" action=\"postProposedChangesComment.php\" method=\"post\">\n";
            echo "<input id=\"comment_type\" name=\"comment_type\" type=\"hidden\" value=\"General Commnet\" />\n";
            echo "<input id=\"crefpid\" name=\"crefpid\" type=\"hidden\" value=\"".$pid."\" />\n";
              echo "<table>\n";
                echo "<tr>\n";
                  echo "<td colspan=\"2\"><b>Please post your comment here</b></td>\n";
                echo "</tr>\n";
                echo "<tr>\n";
                  echo "<td ><label>Topic: </label></td>\n";
                  echo "<td ><input id=\"ctitle\" name=\"ctitle\" type=\"text\" size=\"50\" value=\"RE:".$replyTitle."\" /></td>\n";
                echo "</tr>\n";
                echo "<tr>\n";
                  echo "<td ><label>Comment: </label></td>\n";
                  echo "<td ><textarea id=\"ccontent\" name=\"ccontent\" rows=\"10\" cols=\"50\"></textarea></td>\n";
                echo "</tr>\n";
                if( $is_names_committee_member == True ){
                  echo "<tr>\n";
                  echo "<td colspan=\"2\"><input type=\"checkbox\" id=\"comment_type_2\" name=\"comment_type_2\" value=\"Review Opinion\">Check this if you want to make this comment as \"Review Opinion\"</td>\n";
                echo "</tr>\n";
                }
                echo "<tr>\n";
                  echo "<td colspan=\"2\">\n";
                    echo "<button id=\"submit_button\" name=\"submit_button\" type=\"submit\">Submit</button>\n";
                  echo "</td>\n";
                echo "</tr>\n";
              echo "</table>\n";
            echo "</form></div>\n";

            
            
            //Marked on February 26, 2011 Saturday
            //Marked on February 26, 2011 Saturday
            /*
            //show review opinion interface
            //show recommended decision interface
            if( $is_names_committee_member == True ){
              //show review opinion interface
              //echo "show review opinion interface";

            echo "<div class=\"review_opinion\">";
            echo "<form id=\"commentPost\" action=\"postProposedChangesComment.php\" method=\"post\">\n";
            echo "<input id=\"comment_type\" name=\"comment_type\" type=\"hidden\" value=\"1\" />\n";
            echo "<input id=\"crefpid\" name=\"crefpid\" type=\"hidden\" value=\"".$pid."\" />\n";
              echo "<table>\n";
                echo "<tr>\n";
                  echo "<td colspan=\"2\"><b>Please post your comment here</b></td>\n";
                echo "</tr>\n";
                echo "<tr>\n";
                  echo "<td ><label>Topic: </label></td>\n";
                  echo "<td ><input id=\"ctitle\" name=\"ctitle\" type=\"text\" size=\"50\" value=\"RE:".$replyTitle."\" /></td>\n";
                echo "</tr>\n";
                echo "<tr>\n";
                  echo "<td ><label>Comment: </label></td>\n";
                  echo "<td ><textarea id=\"ccontent\" name=\"ccontent\" rows=\"10\" cols=\"50\"></textarea></td>\n";
                echo "</tr>\n";
                echo "<tr>\n";
                  echo "<td colspan=\"2\">\n";
                    echo "<button id=\"submit_button\" name=\"submit_button\" type=\"submit\">Submit to committee members</button>\n";
                  echo "</td>\n";
                echo "</tr>\n";
              echo "</table>\n";
            echo "</form></div>\n";            
            
            }
            if( $is_names_committee_member_chair == True ){
              //show recommended decision interface
              //echo "show recommended decision interface";
            echo "<div class=\"recommended_decision\">";
            echo "<form id=\"commentPost\" action=\"postProposedChangesComment.php\" method=\"post\">\n";
            echo "<input id=\"comment_type\" name=\"comment_type\" type=\"hidden\" value=\"2\" />\n";
            echo "<input id=\"crefpid\" name=\"crefpid\" type=\"hidden\" value=\"".$pid."\" />\n";
              echo "<table>\n";
                echo "<tr>\n";
                  echo "<td colspan=\"2\"><b>Please post your comment here</b></td>\n";
                echo "</tr>\n";
                echo "<tr>\n";
                  echo "<td ><label>Topic: </label></td>\n";
                  echo "<td ><input id=\"ctitle\" name=\"ctitle\" type=\"text\" size=\"50\" value=\"RE:".$replyTitle."\" /></td>\n";
                echo "</tr>\n";
                echo "<tr>\n";
                  echo "<td ><label>Comment: </label></td>\n";
                  echo "<td ><textarea id=\"ccontent\" name=\"ccontent\" rows=\"10\" cols=\"50\"></textarea></td>\n";
                echo "</tr>\n";
                echo "<tr>\n";
                  echo "<td colspan=\"2\">\n";
                    echo "<button id=\"submit_button\" name=\"submit_button\" type=\"submit\">Final Submission to Close out Case: ".$replyTitle."</button>\n";
                  echo "</td>\n";
                echo "</tr>\n";
              echo "</table>\n";
            echo "</form></div>\n";            
            
            }            
            */
            //Marked on February 26, 2011 Saturday
            //Marked on February 26, 2011 Saturday
            


            //Marked on February 26, 2011 Saturday
            //Marked on February 26, 2011 Saturday
            
            /*
            //July 02, 2010 Friday:: pstate = 2 layout
            //$date = date("Y-m-d H:i:s");//"2008-08-28 13:03:21"
            $date = date("Y-m-d");//"2008-08-28 "
            $vote_expiration = "";
            
            $sql_vote_expiration = "SELECT * FROM committee_grp WHERE refpid='".$pid."'";
            //echo "Variable sql_vote_expiration is <b>".$sql_vote_expiration."</b><br>\n";
            $result_vote_expiration = mysql_query($sql_vote_expiration);
            if(mysql_num_rows($result_vote_expiration) > 0){
              while ( $nb_vote_expiration = mysql_fetch_array($result_vote_expiration) ) {
                //
                $vote_expiration = $nb_vote_expiration[8];
              }
            } 
            */ 
            //Marked on February 26, 2011 Saturday
            //Marked on February 26, 2011 Saturday

            $is_user_auth = False;
            $is_voted = False;
            $sql_user_auth = "SELECT * FROM committee_member WHERE ref_uid='".$uid."' AND ref_pid ='".$pid."' AND join_status ='Accept'";
            //echo "Variable sql_user_auth is <b>".$sql_user_auth."</b><br>\n";
            $result_user_auth = mysql_query($sql_user_auth);
            if(mysql_num_rows($result_user_auth) > 0){
              while ( $nb_user_auth = mysql_fetch_array($result_user_auth) ) {
                //
                $is_user_auth = True;
                if($nb_user_auth[6] != "Empty"){//$nb_user_auth[6] --> vote_opinion: Empty, Yes, No, Abstain
                  $is_voted = True;
                }
              }
            }
            
            //Marked on February 26, 2011 Saturday
            //Marked on February 26, 2011 Saturday
            /*
            if( $date < $vote_expiration && $is_user_auth == True ){
              if( $is_voted == False ){
                echo "<b>User can cast their vote!</b><br>\n";
                $vote_form = "<form name =\"vote\" method =\"post\" action =\"names_com_vote2.php\">";
                $vote_form .= "<input type = \"hidden\" name = \"is_voted\" id = \"is_voted\" value = \"1\" />";
                $vote_form .= "<input type = \"hidden\" name = \"ref_c_id\" id = \"ref_c_id\" value = \"".$ref_c_id."\" />";
                $vote_form .= "<input type = \"hidden\" name = \"user_id\" id = \"user_id\" value = \"".$uid."\" />";
                $vote_form .= "<input type = \"radio\" name = \"vote_opinion\" id = \"vote_opinion\" value = \"1\" >Yes";
                $vote_form .= "<input type = \"radio\" name = \"vote_opinion\" id = \"vote_opinion\" value = \"2\" >No";
                $vote_form .= "<input type = \"radio\" name = \"vote_opinion\" id = \"vote_opinion\" value = \"3\" >Abstain";
                //$vote_form .= "<br>\n";
                //$vote_form .= "Write down your reason: <textarea name = \"vote_desc\" id = \"vote_desc\" rows=\"20\" col=\"20\">Vote Description</textarea>";
                $vote_form .= "<br>";
                $vote_form .= "<input type=\"submit\" name=\"submit\" value =\"Cast Your Vote\">";
                $vote_form .= "</form>";
              
                echo $vote_form;
              }else{
                echo "<b>User can not cast their vote but can see their vote result!</b><br>\n";
                
                $sql_vote_opinion = "SELECT * FROM committee_member WHERE user_id='".$uid."' AND ref_c_id ='".$ref_c_id."'";
                //echo "Variable sql_vote_opinion is <b>".$sql_vote_opinion."</b><br>\n";
                $result_vote_opinion = mysql_query($sql_vote_opinion);
                if(mysql_num_rows($result_vote_opinion) > 0){
                  while ( $nb_vote_opinion = mysql_fetch_array($result_vote_opinion) ) {
                    //
                    $vote_opinion = "";
                    if( $nb_vote_opinion[7] == 1){
                      $vote_opinion = "Yes";
                    }elseif( $nb_vote_opinion[7] == 2){
                      $vote_opinion = "No";
                    }elseif( $nb_vote_opinion[7] == 3){
                      $vote_opinion = "Abstain";
                    }
                    
                    echo "Your vote is <b>".$vote_opinion."</b><br>\n";
                    
                    echo "<font color=\"red\">Do we need Statistic Information?</font><br>\n";
                  }
                }
              }
            }else{
              echo "<b>User can not cast their vote!</b><br>\n";
            }
            */
            //July 02, 2010 Friday:: pstate = 2 layout   
            //Marked on February 26, 2011 Saturday
            //Marked on February 26, 2011 Saturday
            //Open Vote Interface (Vote + Reason)
            if( $is_user_auth == True && $is_voted == False ){
              echo "<h3><b>Vote Interface</b></h3><br>\n";
              echo "<b>User can cast their vote!</b><br>\n";
              $vote_form = "<form name =\"vote\" method =\"post\" action =\"names_com_vote2.php\">";
              //$vote_form .= "<input type = \"hidden\" name = \"is_voted\" id = \"is_voted\" value = \"1\" />";
              $vote_form .= "<input type = \"hidden\" name = \"pid\" id = \"pid\" value = \"".$pid."\" />";
              $vote_form .= "<input type = \"hidden\" name = \"uid\" id = \"uid\" value = \"".$uid."\" />";
              $vote_form .= "<input type = \"radio\" name = \"vote_opinion\" id = \"vote_opinion\" value = \"Yes\" >Yes";
              $vote_form .= "<input type = \"radio\" name = \"vote_opinion\" id = \"vote_opinion\" value = \"No\" >No";
              $vote_form .= "<input type = \"radio\" name = \"vote_opinion\" id = \"vote_opinion\" value = \"Abstain\" >Abstain";
              $vote_form .= "<br>\n";
              $vote_form .= "Write down your reason:<br> <textarea name = \"vote_desc\" id = \"vote_desc\" rows=\"10\" col=\"200\">Vote Description</textarea>";
              $vote_form .= "<br>";
              $vote_form .= "<input type=\"submit\" name=\"submit\" value =\"Cast Your Vote\">";
              $vote_form .= "</form>";
              echo $vote_form;
            }elseif( $is_user_auth == True && $is_voted == True ){
              echo "<b>User can not cast their vote but can see their vote result!</b><br>\n";
              $sql_vote_opinion = "SELECT * FROM committee_member WHERE ref_uid='".$uid."' AND ref_pid ='".$pid."'";
              //echo "Variable sql_vote_opinion is <b>".$sql_vote_opinion."</b><br>\n";
              $result_vote_opinion = mysql_query($sql_vote_opinion);
              if(mysql_num_rows($result_vote_opinion) > 0){
                while ( $nb_vote_opinion = mysql_fetch_array($result_vote_opinion) ) {
                  //
                  $vote_opinion = $nb_vote_opinion[6];
                  $vote_desc = $nb_vote_opinion[7];
                  echo "Your vote is <b>".$vote_opinion."</b><br>\n";
                  echo "Your vote opinion is <b>".$vote_desc."</b><br>\n";
                  echo "<font color=\"red\">Do we need Statistic Information?</font><br>\n";
                }
              }
            }else{
              //echo "<b>User can not cast their vote!</b><br>\n";
            }            
                   
          }elseif( $pstate == "Pending" ){
            //The same as vote interface         
            if( $role == "admin"){
              //echo "Admin can see this interface!";
              
              
              
              echo "<h3><b>Administrator's final decision</b></h3><br>\n";
              
              echo "<b>Statistics Information</b><br>\n";
              
              $total_members = 0;
              $total_yes = 0;
              $total_no = 0;
              $total_abstain = 0;
              
              
              $sql_vote = "SELECT * FROM committee_member WHERE join_status = 'Accept' AND ref_pid ='".$pid."'";
              //echo "Variable sql_vote  is <b>".$sql_vote ."</b><br>\n";
              $result_vote  = mysql_query($sql_vote );
              if(mysql_num_rows($result_vote ) > 0){
                while ( $nb_vote  = mysql_fetch_array($result_vote ) ) {
                  //
                  $total_members++;
                  if( $nb_vote[6] == "Yes" ){
                    $total_yes++;
                  }elseif( $nb_vote[6] == "No" ){
                    $total_no++;
                  }elseif( $nb_vote[6] == "Abstain" ){
                    $total_abstain++;
                  }else{
                    //
                  }
                }
              }
              echo "# of Names Committee Members is <b>".$total_members."</b><br>\n";
              echo "# of Vote \"Yes\" is <b>".$total_yes."</b><br>\n";
              echo "# of Vote \"No\" is <b>".$total_no."</b><br>\n";
              echo "# of Vote \"Abstain\" is <b>".$total_abstain."</b><br>\n";
              
              
              
              $vote_form = "<form name =\"final_decision\" method =\"post\" action =\"final_decision2.php\">";
              $vote_form .= "<input type = \"hidden\" name = \"pid\" id = \"pid\" value = \"".$pid."\" />";
              $vote_form .= "<input type = \"hidden\" name = \"uid\" id = \"uid\" value = \"".$uid."\" />";
              $vote_form .= "<input type = \"radio\" name = \"final_decision\" id = \"final_decision\" value = \"Yes\" >Yes";
              $vote_form .= "<input type = \"radio\" name = \"final_decision\" id = \"final_decision\" value = \"No\" >No";
              
              $vote_form .= "<br>\n";
              $vote_form .= "Write down your decision summary:<br> <textarea name = \"decision_summary\" id = \"decision_summary\" rows=\"10\" col=\"200\">Decision Summary</textarea>";
              $vote_form .= "<br>";
              $vote_form .= "<input type=\"submit\" name=\"submit\" value =\"Make this decision\">"; 
              $vote_form .= "</form>";
              echo $vote_form;
              
              
              
            }else{
              echo "<h3>This taxonomic nomenclature change proposal is in \"Pending\" state right now, comment interface is closed right now.</h3>"; 
            }
          
          
          }elseif( $pstate == "Closed" ){//Close all interfaaces            
            echo "<b>This posted proposed change has been closed and end its conversation now!</b><br>\n";
            echo "Administrator's Decision Summary:<br>\n";
            $sql_final_decision = "SELECT * FROM committee_member WHERE ref_uid='0' AND ref_pid ='".$pid."'";
            //echo "Variable sql_final_decision  is <b>".$sql_final_decision ."</b><br>\n";
            $result_final_decision  = mysql_query($sql_final_decision );
            if(mysql_num_rows($result_final_decision ) > 0){
              while ( $nb_final_decision  = mysql_fetch_array($result_final_decision ) ) {
                //
                $final_decision = $nb_final_decision [6];
                $decision_summary = $nb_final_decision [7];
                echo "Final decision is <b>".$final_decision."</b><br>\n";
                echo "Decision summary is <b>".$decision_summary."</b><br>\n";
              }
            }
            
          }
          //July 01, 2010 Thursday:: New Logic of Comment Interface          
        
        
          echo "<br><br><br><br><br>\n"
        ?>


<?php
  include('template2.php'); 
?>








