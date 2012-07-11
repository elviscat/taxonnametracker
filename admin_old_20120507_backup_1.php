<?php
	
	//Author Information
	//Developed by elviscat (elviscat@gmail.com)
	
	
	//Code Change Logs
	//March 19, 2009 Thursday:: The administration interface (hub) :: link to other functions via the following hyperlink 
	//Nov 10, 2009 Tuesday:: Redesign the layout
	//Nov 15, 2009 Sunday::Redesign the registered user's layout
	//Jan 22, 2010 Friday::Modifiy the layout of review opinion and system administrator interface (reminder interface)
	//Jan 28, 2010 Thursday:: Layout modification on reminder of contribute some of your review opinion of Member of Names Committee 
	//June 09, 2010 Wednesday:: Apply to new layout
	//June 15, 2010 Tuesday:: Access control logic modification
	//June 25, 2010 Friday:: Layout modification
	//February 25, 2011 Friday:: Layout modification
	//May 02, 2012 Wednesday:: Apply to new template, template.php and align code again!
	
	// ./ current directory
	// ../ up level directory
	
	
	include('template0.php');//DB Connetion and Configuration Setup
	
	
	//Customized Setup
	//Configuration of POST and GET Variables
	//$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	//echo "\$id is :: ".$id."<br>\n";
	//Configuration of POST and GET Variables
	
	$page_title = "Administration Management Page For User ::";//Don't change the variable name
	$page_heading = "Administration Management Page For User ::";//Don't change the variable name
	
	//Put the code for this page HERE!
	
	
	session_start();
	
	//June 15, 2010 Tuesday:: Access control logic modification  
	//Access control by login status
	if( !isset($_SESSION['is_login']) ){
		Header("location:authorizedFail.php");
		exit();
	}
	//Access control by login status
	
	/*
	if( !isset($_SESSION['is_login']) ){
		Header("location:loginFail.php");
		exit();
	}
	*/
	//June 15, 2010 Tuesday:: Access control logic modification
	
	
	
	
	
	
	
	//echo "Session of role is :: ".$_SESSION['role']."<br>\n";
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
	
	$content = "";
    $content .= "Hi, ".$real_name." (".$loginname.") <BR />\n";
	
	if( $role == "user" ){
		$content .= "<li><h3>Your Assignments with the Names Committee</h3></li>";
		//$content .= "1.<a href=\"view_user_committee_list.php\">View your assigned Names Committees</a><br>";
		$content .= "<a href=\"view_user_committee_list.php\">View your assigned Names Committees</a><br>";
		
    
    //$content .= "2.<b>View and review the following recommended nomenclatorial changes (You may post a review opinion or suggestion on the following proposed nomenclatural changes):</b><br>";
    //$content .= "Recent 5 posts: <br>\n";
    
    //Here is the layout of review opinion counter and edit interface
    
    
    //SELECT ref_c_id FROM committee_member WHERE user_id ='".$uid."'
    //SELECT level, account_id FROM committee_account WHERE ref_c_id ='".$ref_c_id."'
    //SELECT pid FROM post WHERE preflv ='".$preflv."' AND prefsid ='".$prefsid."'
    //SELECT * FROM comment WHERE crefpid ='".$crefpid."' AND crefuid ='".$uid."'
    
    //Find out this user belong which names committee
    
    
    //$sql_ref_c_id = "SELECT ref_c_id FROM committee_member WHERE user_id ='".$uid."' AND join_status = 'accept' ORDER BY ref_c_id asc";
    
    /*
    $sql_ref_c_id = "SELECT ref_c_id FROM committee_member WHERE user_id ='".$uid."' ORDER BY ref_c_id asc";
    
    
    
    //echo "sql_ref_c_id is ".$sql_ref_c_id."<br>\n";
    $result_sql_ref_c_id = mysql_query($sql_ref_c_id);
    if(mysql_num_rows($result_sql_ref_c_id) > 0){
      
      $display_counter = 0;
      
      while ( $nb_sql_ref_c_id = mysql_fetch_array($result_sql_ref_c_id) ) {
        $ref_c_id = $nb_sql_ref_c_id[0];
        
        //
        //echo names committee first
        //
        //$sql_names_coommittee = "SELECT * FROM committee_grp WHERE id ='".$ref_c_id."'";
        //echo "sql_names_coommittee is ".$sql_names_coommittee."<br>\n";
        //$result_sql_names_coommittee = mysql_query($sql_names_coommittee);
        //if(mysql_num_rows($result_sql_names_coommittee) > 0){
        //  while ( $nb_sql_names_coommittee = mysql_fetch_array($result_sql_names_coommittee) ) {
        //    $content .= "Names Committee: ".$nb_sql_names_coommittee[1]."<br>\n";
        //  }
        //}
        //echo names committee first
        //
        
        //Find out the the related taxon entry/account
        $sql_lv_sid = "SELECT level, account_id FROM committee_account WHERE ref_c_id ='".$ref_c_id."'";
        $sql_lv_sid .= " ORDER BY `committee_account`.`level` ASC";
        //echo "sql_lv_sid is ".$sql_lv_sid."<br>\n";
        $result_sql_lv_sid = mysql_query($sql_lv_sid);
        if(mysql_num_rows($result_sql_lv_sid) > 0){
          
          while ( $nb_sql_lv_sid = mysql_fetch_array($result_sql_lv_sid) ) {
            $preflv = $nb_sql_lv_sid[0];
            $prefsid = $nb_sql_lv_sid[1];
            
            $today = date("Y-m-d");//"2010-01-22"
            
            //Find out the post entry which is still open and not expired
            //$sql_pid = "SELECT pid FROM post WHERE preflv ='".$preflv."' AND prefsid ='".$prefsid."' AND pstate='0' AND pexpiration > '".$pexpiration."'";
            //$sql_pid .= " Order By preflv and prefsid";
            $sql_pid = "SELECT * FROM post WHERE preflv ='".$preflv."' AND prefsid ='".$prefsid."'";
            //echo "sql_pid is ".$sql_pid."<br>\n";
            $result_sql_pid = mysql_query($sql_pid);
                     
            //counter to post which you need to contribute to review
            
            if( $display_counter <4 ){
            //Just list the first five records
            
              if(mysql_num_rows($result_sql_pid) > 0){
                while ( $nb_sql_pid = mysql_fetch_array($result_sql_pid) ) {
                  $pid = $nb_sql_pid[0];
                  $ptitle = $nb_sql_pid[1];
                  $pstate = $nb_sql_pid[11];
                  $pexpiration = $nb_sql_pid[12];
              
                  $pcredate = $nb_sql_pid[3];
                  $prefuid = $nb_sql_pid[4];
                
                  //echo "Hello".$pid." Level=".preflv." AND Taxon ID=".$prefsid."<br>\n";
                  //echo "Hello".$ptitle." Level=".preflv." AND Taxon name=".$prefsid."<br>\n";
                
                  //Find out comments which is belong to this taxon entry/account
                  $sql_comment = "SELECT * FROM comment WHERE crefpid ='".$pid."' AND crefuid ='".$uid."' AND comment_type != '0' ";             
                  //echo "sql_comment is ".$sql_comment."<br>\n";
                  $result_sql_comment = mysql_query($sql_comment);
                  //$content .= "You have right to post review on this post!".$pid." <a href=\"viewpost.php?pid=".$pid."\">Go to post</a><br>\n";
                  $user_name = user_name($prefuid);
                
                  //$content .= "(".$display_counter.")";
                
                  if(mysql_num_rows($result_sql_comment) > 0){//View your review opinion and decision suggestion
                    $display_counter++;
                    $content .= "(".$display_counter.")Topic: <a href=\"viewpost.php?pid=".$pid."\">".$ptitle."</a> <a href=\"viewUserProfile.php?uid=".$prefuid."\">".$user_name."</a> ".$pcredate."<a href=\"view_ops_decs.php?pid=".$pid."\"> View Review Opinions and Recommended Decision</a><br>\n";
                  
                    //$content .= "<a href=\"viewpost.php?pid=".$pid."\">".taxon_name_by_pid2($pid)."</a> : <a href=\"view_ops_decs.php?pid=".$pid."\">view Review Opinions and Recommended Decision</a><br>\n";
               
                
                    //
                    //while ( $nb_sql_comment = mysql_fetch_array($result_sql_comment) ) {
                    //  $cid = $nb_sql_comment[0];
                    //  $comment_type = $nb_sql_comment[6];
                    //
                    //  if( $comment_type == "1" ){
                    //    $content .= "<a href=\"viewpost.php?pid=".$pid."\">".taxon_name_by_pid2($pid)."</a> : <a href=\"view_ops_decs.php?pid=".$pid."\">view Review Opinions and Recommended Decision</a><br>\n";
                    //    //$content .= "<a href=\"viewpost.php?pid=".$pid."\">".taxon_name_by_pid2($pid)."</a> : <a href=\"view_ro.php?cid=".$cid."\">view Review Opinions</a><br>\n";
                    //  }elseif($comment_type == "2"){
                    //    $content .= "<a href=\"viewpost.php?pid=".$pid."\">".taxon_name_by_pid2($pid)."</a> : <a href=\"view_ops_decs.php?pid=".$pid."\">view Review Opinions and Recommended Decision</a><br>\n";
                    //    //$content .= "<a href=\"viewpost.php?pid=".$pid."\">".taxon_name_by_pid2($pid)."</a> : <a href=\"view_ds.php?cid=".$cid."\">view Recommended Decision</a><br>\n";
                    //  }else{
                    //    //This is general comment, do not need to show it up
                    //    //$content .= "cid is :: ".$cid."<br>\n";
                    //  }           
                    //}
                    //
                  }else{
                  
                    //No review opinions and recommended decisions
                    if( $pstate == "0" && $pexpiration > $today ){
                      //$content .= "<a href=\"viewpost.php?pid=".$pid."\">Contribute to review</a><br>\n";
                      $display_counter++;
                      $content .= "(".$display_counter.")Topic: <a href=\"viewpost.php?pid=".$pid."\">".$ptitle."</a> <a href=\"viewUserProfile.php?uid=".$prefuid."\">".$user_name."</a> ".$pcredate." Need your contribution!<br>\n"; 
                    }
                    //
                    //$sql_can_post_review = "SELECT pid FROM post WHERE preflv ='".$preflv."' AND prefsid ='".$prefsid."' AND pstate='0' AND pexpiration > '".$pexpiration."'";
                    //
                    //echo "sql_can_post_review is ".$sql_can_post_review."<br>\n";
                    //$result_sql_can_post_review = mysql_query($sql_can_post_review);
                    //if(mysql_num_rows($result_sql_can_post_review) > 0){
                    //  while ( $nb_sql_can_post_review = mysql_fetch_array($result_sql_can_post_review) ) {
                    //    $content .= "<a href=\"viewpost.php?pid=".$nb_sql_can_post_review[0]."\">Contribute to review</a><br>\n";
                    //  }
                    //}
                    //
                  }  
                }          
              }
            }
          }
        }    
      }
    }
    $content .= "<a href=\"view_committee_member_working_post_list.php\">View All</a>\n";
    */
    
    
	  $content .= "<li><h3>Your Posts and Comments</h3></li>";
    $content .= "<a href=\"postProposedChangesManage.php\">View your proposed nomenclatural changes</a><br>";
    //$content .= "<a href=\"postProposedChangesManage.php\">Manage your proposed changes or suggestted name changes data</a><br>";
    //link to user function 1:: manage your post proposed changes or suggestted name changes
    $content .= "<a href=\"commentProposedChangesManage.php\">View your comment data</a><br>";
    //$content .= "<a href=\"commentProposedChangesManage.php\">Manage your comment data</a><br>";
    //link to user function 2:: manage your post comments

    $content .= "<li><h3>Personal Profile and Email Management</h3></li>";
    $content .= "<a href=\"questionnaire.php\">Questionnaire</a><br>";
	  $content .= "<a href=\"updateUserProfile.php\">Update your user profile</a><br>";
	  $content .= "<a href=\"requestkey.php\">Request new email activation key (e.g., your email address is changing)</a><br>";
	

  }else if($role == "admin"){

	$content .= "<li><h3>Name List/Biological classification Management</h3></li>";
	$content .= "<a href=\"name_list.php\">Taxon Browser</a><br>"; //link to administrator function 3:: manage family list data
    //$content .= "<a href=\"slist_table.php\">Species Browser</a><br>"; //link to administrator function 3:: manage family list data
    //$content .= "<a href=\"slistManage.php\">Manage species data</a><br>"; //link to administrator function 4:: manage species list data   
    
    
    
    //Function 2: Nomenclature Change Proposals Management
    //$content .= "<li><h3>Your Reminders</h3></li>";
    $content .= "<li><h3>Nomenclature Change Proposals Management</h3></li>";
    $content .=  "<a href=\"admin_proposal_management.php\">Nomenclature Change Proposals List</a><br>\n";
    //Find the post which is under state == 'under_review'
    
    //Marked on February 25, 2011 Friday
    /*
    
    $sql_find_under_review = "SELECT * FROM post WHERE pstate = '0'";
    //echo "Variable sql_find_under_review is :: ".$sql_find_under_review."<br>\n";
    $result_sql_find_under_review = mysql_query($sql_find_under_review);
    $counter = 0;
    if(mysql_num_rows($result_sql_find_under_review) > 0){
      //echo "<table><br>\n";
      //echo "<tr>\n";
      //echo "<td>\n";
      while ( $nb_sql_find_under_review = mysql_fetch_array($result_sql_find_under_review) ) {
        //echo "<a href=\"slist_chg.php?lv=".$taxon_level."&id=".$nb[0]."&pid=".$nb_sql_find_under_review[0]."\">Edit</a><br>\n";
        $counter++;
      }
      //echo "</td>\n";
      //echo "</tr>\n";
      //echo "</table>\n";
    }
    $content .=  "You have <a href=\"view_sa_reminder.php?type=newpost\">".$counter."</a> new cases of proposed changes to handle.<br>\n";
    
    //Find the post which is expired
    $expired_date = date("Y-m-d");//"2010-01-22"
    $sql_find_expired = "SELECT * FROM post WHERE pexpiration < '".$expired_date."' AND pstate='0'";
    //echo "Variable sql_find_expired is :: ".$sql_find_expired."<br>\n";
    $result_sql_find_expired = mysql_query($sql_find_expired);
    $counter = 0;
    if(mysql_num_rows($result_sql_find_expired) > 0){
      while ( $nb_sql_find_expired = mysql_fetch_array($result_sql_find_expired) ) {
        $counter++;
      }
    }
    $content .=  "You have <a href=\"view_sa_reminder.php?type=expired\">".$counter."</a> expired cases of proposed changes.<br>\n";
    */
    
     
    //Mark and hide this, June 25, 2010 Friday
    
    //Find the post which is not belong to any names committee
    //$sql_general_post = "SELECT * FROM post WHERE pexpiration > '".$expired_date."' AND pstate='0'";
    //echo "Variable sql_general_post is :: ".$sql_general_post."<br>\n";
    //$result_sql_general_post = mysql_query($sql_general_post);
    //$counter = 0;
    //if(mysql_num_rows($result_sql_general_post) > 0){
    //  while ( $nb_sql_general_post = mysql_fetch_array($result_sql_general_post) ) {
    //    $pid = $nb_sql_general_post[0];
    //    $preflv = $nb_sql_general_post[5];
    //    $prefsid = $nb_sql_general_post[6];

    //    $sql_post_with_names_committee = "SELECT * FROM committee_account WHERE `committee_account`.`level` = '".$preflv."' AND account_id ='".$prefsid."'";
    //    //echo "Variable sql_post_with_names_committee is :: ".$sql_post_with_names_committee."<br>\n";
    //    $result_sql_post_with_names_committee = mysql_query($sql_post_with_names_committee);
    //    if(mysql_num_rows($result_sql_post_with_names_committee) > 0){
    //      //$content .= "Yes\n";
    //     //$counter++;
    //    }else{
    //      //$content .= "No\n";
    //      //$content .= $pid."\n";
    //      $counter++;
    //    }
    //  }
    //}
    //$content .=  "You have <a href=\"view_sa_reminder.php?type=without_names_committee\">".$counter."</a> proposed changes without Names Committee.<br>\n";
    //Mark and hidw this, June 25, 2010 Friday



    //Layout modification, June 25, 2010 Friday

    $content .= "<li><h3>Names Committee Management</h3></li>";
    //$content .= "<a href=\"itcstep1.php\">Invitation of registered user to Names Committee</a><br>"; //link to administrator function 1:: browse user information
    $content .= "<a href=\"committee_manage.php\">Names Committee List</a><br>"; //View names committee list
    $content .= "<a href=\"set_default_com_mem.php\">Set and Unset Default Names Committee Member(s)</a><br>"; //Set up and unset the default names comiittee member(s) 
    //$content .= "<a href=\"committee_create.php\">Create a new Names Committee and its Taxon/Taxa accounts</a><br>"; //link to System administrator function ?:: Create a new Names Committee
    //$content .= "Add Taxon/Taxa account(s) to current Names Committee?<br>"; //link to System administrator function ?:: View Names Committee Memebr(s)
    //$content .= "View Names Committee Memebr(s) by Nomenclature Proposal Case?<br>"; //link to System administrator function ?:: View Names Committee Memebr(s)
    
    //Layout modification, June 25, 2010 Friday    
    
    
    $content .= "<li><h3>View Registered User</h3></li>";
    $content .= "<a href=\"browseUsers.php\">Browse registered user information</a><br>"; //link to administrator function 1:: browse user information
    //$content .= "<a href=\"browseLogs.php\">Browse Users Log History</a><br>"; //link to administrator function 2:: browse log information

    $content .= "<li><h3>Send internal message to registered users</h3></li>";
    $content .= "<a href=\"internal_msg_send_1.php\">Send Message</a><br>"; //link to send internal message function


  }
	
	
	
	
	//Put the code for this page HERE!
	//Customized Setup
	
	include('template1.php');//head, title, basic javascript, body, sidebar until "div:mainContent"
	
?>
    <!-- Put Extra Javascript References and Javascript Code Here! -->
    <!-- Put Extra Javascript References and Javascript Code Here! -->
    <?php echo "<h3>".$page_heading."</h3><br>\n"; ?>
    <!-- Put Actual Html Code and PHP code for this page Here! -->
    <?php echo $content; ?>
    
    <!-- Put Actual Html Code and PHP code for this page Here! -->



<?php
	include('template2.php');//end of div:mainContent, footer, php mysql connection close
?>






