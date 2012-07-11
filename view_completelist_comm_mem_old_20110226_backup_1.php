<?php
  //Developed by elviscat (elviscat@gmail.com)
  //June 01, 2010 Tuesday:: Complete List of Committee Memebrs on this specific Committee
  //June 09, 2010 Wednesday:: Some layout modification
  //June 15, 2010 Tuesday:: Add the column of "Examined Case" date
  //June 25, 2010 Friday:: Logic and layout modification
  //February 25, 2011 Friday:: Layout modification
  //February 26, 2011 Saturday:: Layout modification
  // ./ current directory
  // ../ up level directory

  session_start();
  //Access control by role
  $role = $_SESSION['role'];
  if( $role != "admin"){
    Header("location:authorizedFail.php");
    exit();
  }
  //Access control by role
  include('template0.php');
  
  //customized setup
  
  //Configuration of POST and GET Variables

  //$cid = htmlspecialchars($_GET['cid'],ENT_QUOTES);
  //echo "Variable cid is :: ".$cid."<br>\n";
  
  $pid = htmlspecialchars($_GET['pid'],ENT_QUOTES);//post id --> pid
  //echo "Variable pid is :: ".$pid."<br>\n";

  //Configuration of POST and GET Variables
  
  //$caption = "Complete List of Committee Memebrs in this Names Committee<BR>\n";//February 26, 2011 Saturday:: Layout modification
  $caption = "List of Committee Memebrs in this Names Committee";

  
  //customized setup  

  include('template1.php');
?>
      <?php //echo "<h2>".$caption."</h2><br>\n";//February 26, 2011 Saturday:: Layout modification ?>
      <?php echo "<h3>".$caption."</h3><br>\n"; ?>
      <?php
      
        
        //February 26, 2011 Saturday:: Layout modification
        //February 26, 2011 Saturday:: Layout modification
        
        $sql_list_committee_members = "SELECT * FROM committee_member WHERE ref_pid = ".$pid;
        $result_list_committee_members = mysql_query($sql_list_committee_members);       
        if(mysql_num_rows($result_list_committee_members) > 0){
          //echo "<table border=\"1\"><tr>\n";
          echo "<table width=\"640\"><tr>\n";
          echo "<td>Memebr Name</td>\n";
          echo "<td>Invitation Date</td>\n";
          echo "<td>Status</td>\n";
          echo "<td>Rank</td>\n";
          
          //from pid view
          if( $pid != ""){
            echo "<td>Examined Case</td>\n";
            echo "<td>Contributed to Comments</td>\n";
          }
          //from pid view
          
          echo "</tr>\n";
          while ( $nb_list_committee_members = mysql_fetch_array($result_list_committee_members) ) {        
            $uid = $nb_list_committee_members[1];
            $username = user_name($uid);
            echo "<tr>\n";
            echo "<td><a href=\"viewUserProfile.php?uid=".$uid."\">".$username."</a></td>\n";
            echo "<td>".$nb_list_committee_members[3]."</td>\n";//Invitation Date
            echo "<td>".ucwords($nb_list_committee_members[4])."</td>\n";//Join Status
            
            if( $nb_list_committee_members[4] == "Accept" ){
            
              if($nb_list_committee_members[5] == "Member" ){
                echo "<td>".ucwords($nb_list_committee_members[5])." <a href=\"change_nc_member_lev.php?cid=".$cid."&uid=".$uid."&chg_lev=to_chair\">Make this person as Chair?</a></td>\n";//Join Level
              }else{
                echo "<td>".ucwords($nb_list_committee_members[5])." <a href=\"change_nc_member_lev.php?cid=".$cid."&uid=".$uid."&chg_lev=to_member\">Make this person as Member?</a></td>\n";//Join Level
              }
            }else{
              echo "<td>Not Joined</td>\n";//Join Level
            }


            //from pid view
            if( $pid != ""){
              //June 15, 2010 Tuesday:: Add the column of "Examined Case" date
              //echo "<td>Sample: 2010-04-12</td>\n";
              echo "<td>";
              $first_date_examined_case = "No Data";
              $sql_first_date_examined_case = "SELECT * FROM post_view_log WHERE refuid = '".$uid."' AND refpid='".$pid."' ORDER BY log_datetime DESC Limit 1 ";
              //echo "Variable sql_first_date_examined_case is <b>".$sql_first_date_examined_case."</b><br>\n";
              $result_first_date_examined_case = mysql_query($sql_first_date_examined_case);
              if(mysql_num_rows($result_first_date_examined_case) > 0){
                while ( $nb_first_date_examined_case = mysql_fetch_array($result_first_date_examined_case) ) {
                  $first_date_examined_case = $nb_first_date_examined_case[1];
                }
              }
              echo substr($first_date_examined_case, 0, 10);
              echo " <a href=\"view_post_log.php?pid=".$pid."&uid=".$uid."\">View all log history</a></td>\n";                          
              //June 15, 2010 Tuesday:: Add the column of "Examined Case" date


              echo "<td>";
              $first_date_comment = "No Data";
              $sql_first_date_comment = "SELECT * FROM comment WHERE crefuid = '".$uid."' AND crefpid='".$pid."' ORDER BY ccredate DESC Limit 1 ";
              //echo "sql_first_date_comment is ".$sql_first_date_comment."<br>\n";
              $result_first_date_comment = mysql_query($sql_first_date_comment);
              if(mysql_num_rows($result_first_date_comment) > 0){
                while ( $nb_first_date_comment = mysql_fetch_array($result_first_date_comment) ) {
                  $first_date_comment = $nb_first_date_comment[3];
                }
              }
              echo $first_date_comment;
              echo "</td>\n";
            }
            //from pid view            
            
            
            
            echo "</tr>\n";
          }          
          echo "</table>";
          
          echo "<br>\n";
          echo "<a href=\"set_com_mem_invite.php?pid=".$pid."\">Add and invite new user(s) to this commiittee</a><br>\n";

          echo "<br>\n";
          echo "<a href=\"set_com_mem_remove.php?pid=".$pid."\">Remove current member(s) from this commiittee</a><br>\n";
        
        }else{
          //echo "There are no data in this Names Committee!<br>\n";//February 26, 2011 Saturday:: Layout modification
          echo "Names Committee is not initilized, please go to following link to set up:<br>\n";
          echo "<br>\n";
          echo "<a href=\"set_com_mem_init.php?pid=".$pid."\">Set up this Names Committee.</a><br>\n";
             
        }
        
        //February 26, 2011 Saturday:: Layout modification
        //February 26, 2011 Saturday:: Layout modification
        
        
        //Marked on February 26, 2011 Saturday
        //Marked on February 26, 2011 Saturday
        /*
        
        //Related Committee Members
        $sql_committee_member = "SELECT * FROM committee_member WHERE ref_pid = ".$pid;
        $result_committee_member = mysql_query($sql_committee_member);       
        if(mysql_num_rows($result_committee_member) > 0){
          //echo "<table border=\"1\"><tr>\n";
          echo "<table width=\"640\"><tr>\n";
          echo "<td>Memebr Name</td>\n";
          echo "<td>Invitation</td>\n";
          echo "<td>Status</td>\n";
          echo "<td>Rank</td>\n";
          
          //from pid view
          if( $pid != ""){
            echo "<td>Examined Case</td>\n";
            echo "<td>Contributed to Comments</td>\n";
          }
          //from pid view
          
          echo "</tr>\n";
          while ( $nb_committee_member = mysql_fetch_array($result_committee_member) ) {        
            $uid = $nb_committee_member[1];
            $username = user_name($uid);
            echo "<tr>\n";
            echo "<td><a href=\"viewUserProfile.php?uid=".$uid."\">".$username."</a></td>\n";
            echo "<td>".$nb_committee_member[3]."</td>\n";//Invitation Date
            echo "<td>".ucwords($nb_committee_member[4])."</td>\n";//Join Status
            
            if( $nb_committee_member[4] == "accept" ){
            
              if($nb_committee_member[5] == "member" ){
                echo "<td>".ucwords($nb_committee_member[5])." <a href=\"change_nc_member_lev.php?cid=".$cid."&uid=".$uid."&chg_lev=to_chair\">Make this person as Chair?</a></td>\n";//Join Level
              }else{
                echo "<td>".ucwords($nb_committee_member[5])." <a href=\"change_nc_member_lev.php?cid=".$cid."&uid=".$uid."&chg_lev=to_member\">Make this person as Member?</a></td>\n";//Join Level
              }
            }else{
              echo "<td>Not Joined</td>\n";//Join Level
            }


            //from pid view
            if( $pid != ""){
              //June 15, 2010 Tuesday:: Add the column of "Examined Case" date
              //echo "<td>Sample: 2010-04-12</td>\n";
              echo "<td>";
              $first_date_examined_case = "No Data";
              $sql_first_date_examined_case = "SELECT * FROM post_view_log WHERE refuid = '".$uid."' AND refpid='".$pid."' ORDER BY log_datetime DESC Limit 1 ";
              //echo "Variable sql_first_date_examined_case is <b>".$sql_first_date_examined_case."</b><br>\n";
              $result_first_date_examined_case = mysql_query($sql_first_date_examined_case);
              if(mysql_num_rows($result_first_date_examined_case) > 0){
                while ( $nb_first_date_examined_case = mysql_fetch_array($result_first_date_examined_case) ) {
                  $first_date_examined_case = $nb_first_date_examined_case[1];
                }
              }
              echo substr($first_date_examined_case, 0, 10);
              echo " <a href=\"view_post_log.php?pid=".$pid."&uid=".$uid."\">View all log history</a></td>\n";                          
              //June 15, 2010 Tuesday:: Add the column of "Examined Case" date


              echo "<td>";
              $first_date_comment = "No Data";
              $sql_first_date_comment = "SELECT * FROM comment WHERE crefuid = '".$uid."' AND crefpid='".$pid."' ORDER BY ccredate DESC Limit 1 ";
              //echo "sql_first_date_comment is ".$sql_first_date_comment."<br>\n";
              $result_first_date_comment = mysql_query($sql_first_date_comment);
              if(mysql_num_rows($result_first_date_comment) > 0){
                while ( $nb_first_date_comment = mysql_fetch_array($result_first_date_comment) ) {
                  $first_date_comment = $nb_first_date_comment[3];
                }
              }
              echo $first_date_comment;
              echo "</td>\n";
            }
            //from pid view            
            
            
            
            echo "</tr>\n";
          }          
          echo "</table>";
          
          echo "<br>\n";
          echo "<a href=\"set_com_mem_invite.php?committee_id=".$cid."\">Add and invite new user(s) to this commiittee</a><br>\n";

          echo "<br>\n";
          echo "<a href=\"set_com_mem_remove.php?committee_id=".$cid."\">Remove current member(s) from this commiittee</a><br>\n";
        
        }else{
          echo "There are no data in this Names Committee!<br>\n";

          echo "<br>\n";
          echo "<a href=\"set_com_mem_init.php?committee_id=".$cid."\">Edit this names committee list first.</a><br>\n";
             
        }
        
        */
        //Marked on February 26, 2011 Saturday
        //Marked on February 26, 2011 Saturday
        
        
        //June 25, 2010 Friday:: Logic and layout modification
        //echo "<br>\n";
        //echo "<a href=\"committee_member_op1.php?op_type=setdefault\">Go to default names committee member(s) setting page</a><br>\n";

        //echo "<br>\n";
        //echo "<a href=\"committee_member_op1.php?op_type=unsetdefault\">Go to default names committee member(s) unsetting page</a><br>\n";
        //June 25, 2010 Friday:: Logic and layout modification

        echo "<br>\n";
        //echo "<a href=\"committee_manage.php\">Back to Names Committee Manage Interface</a><br>\n";
        echo "<a href=\"admin_proposal_management.php\">Back to Nomenclature Change Proposals List</a><br>\n";
        
        
        //echo "<a href=\"committee_create.php\">Create a new Names Committee?</a><br>\n";
      ?>

<?php
  include('template2.php'); 
?>
