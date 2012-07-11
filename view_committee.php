<?php
  //Developed by elviscat (elviscat@gmail.com)
  //June 04, 2010 Friday:: View single taxon change
  //February 27, 2011 Sunday:: Code Logic modification
  //July, 2012 Friday:: Code Logic modification
  // ./ current directory
  // ../ up level directory



  session_start();

  //Access control by login status
  if( !isset($_SESSION['is_login']) ){
    Header("location:authorizedFail.php");
    exit();
  }
  //Access control by login status


  include('template0.php');
    
  //customized setup
  //Configuration of POST and GET Variables
  
  $pid = htmlspecialchars($_GET['pid'],ENT_QUOTES);
  //echo "Variable pid  is <b>".$pid."</b><br>\n";
  $view_date = htmlspecialchars($_GET['view_date'],ENT_QUOTES);
  //echo "Variable view_date  is <b>".$view_date."</b><br>\n";  

  //Configuration of POST and GET Variables
    
  $caption = "View Review Committee Information";
  
  //customized setup  

  include('template1.php');
?>

  <?php echo "<h3>".$caption."</h3><br>\n"; ?>
  <?php
  
  
  
  $committee_name = "";
  

  if( $pid != ""){
    
	$sql_post = "SELECT * FROM post WHERE pid = ".$pid;
	//echo "\$sql_post is <b>".$sql_post."</b><br>\n";
	$result_post = mysql_query($sql_post);
	if(mysql_num_rows($result_post) > 0){
		while ( $nb_post = mysql_fetch_array($result_post) ) {
    		echo "Proposal: <a href=\"viewpost.php?pid=".$pid."\">".$nb_post['ptitle']."</a><br />Status: ".$nb_post['pstate']."<br />\n";
    	}
    }
    
    echo "<b>Member in this Names Committee:</b><br><br>\n";
    //Render member information in this names committee
    $sql_committee_taxon_member = "SELECT * FROM committee_member WHERE ref_pid='".$pid."' AND rank_level !='Admin'";   
    //echo "Variable sql_committee_taxon_member is <b>".$sql_committee_taxon_member."</b><br>\n";
    $result_committee_taxon_member = mysql_query($sql_committee_taxon_member);
    if(mysql_num_rows($result_committee_taxon_member) > 0){
      echo "<table width=\"800\">\n";
      echo "<tr>\n";
      echo "<td>Memebr Name</td>\n";
      echo "<td>Invitation</td>\n";
      echo "<td>Rnak</td>\n";
      echo "<td>Status</td>\n";
      echo "</tr>\n";

      while ( $nb_committee_taxon_member = mysql_fetch_array($result_committee_taxon_member) ) {
        $user_id = $nb_committee_taxon_member[1];
        $user_name = user_name($user_id);
      
        $invitation_date = $nb_committee_taxon_member[3];
        $rank = $nb_committee_taxon_member[4];
        $status = $nb_committee_taxon_member[5];
        //$rank = taxon_name_wiht_level($taxon_lv, %taxon_id);
        echo "<tr>\n";
        echo "<td><a href=\"viewUserProfile.php?uid=".$user_id."\">".$user_name."</a></td>\n";
        echo "<td>".$invitation_date."</td>\n";
        echo "<td>".ucwords($rank)."</td>\n";
        echo "<td>".ucwords($status)."</td>\n";
        echo "</tr>\n";
      }
      echo "</table>\n";
    }
    
    //June 25, 2010 Friday:: Layout modification
    $uid = $_SESSION[uid];
    $sql_com_mem = "SELECT * FROM committee_member WHERE ref_uid = '".$uid."' and ref_pid = '".$pid."'"; 
    //echo "Variable sql_com_mem is <b>".$sql_com_mem."</b><br>\n";
    $result_com_mem = mysql_query($sql_com_mem);
    if(mysql_num_rows($result_com_mem) > 0){
      while ( $nb_com_mem = mysql_fetch_array($result_com_mem) ) {
        $member_id = $nb_com_mem[0];
        $join_status = $nb_com_mem[4];
        //
        if( $join_status == "Pending" ){
          echo "<br><b>Action:</b><br><br>\n";
          echo "<a href=\"user_committee.php?action=join&cmid=".$member_id."\">Join</a> Or <a href=\"user_committee.php?action=reject&cmid=".$member_id."\">Reject</a></td>\n";//Action: Join or Reject?
        }else{
          //Do nothing
        }
      }          
    }            
    //June 25, 2010 Friday:: Layout modification
    
    if( $view_date != "" ){
      echo "<a href=\"view_final_decisions_list.php?view_date=".$view_date."\">Back to View Final Decisions</a><br>\n";
    }
  }else{
    echo "There is no data in this page!";
  
  
  }
  
  
  if($_SESSION['role'] == "admin"){
  	  //view_completelist_comm_mem.php?pid=10
  	  echo "<br /><br /><a href=\"view_completelist_comm_mem.php?pid=".$pid."\">More Detail Function?</a><br \>\n";
  	  echo "<br /><br /><a href=\"committee_list.php\">Back to Committee List</a><br \>\n";
  }else{
  	  echo "<br /><br /><a href=\"view_user_committee_list.php\">Back to Committee List</a><br \>\n";
  }
  
  
  echo "<br /><br /><a href=\"admin.php\">Back to Admin</a><BR>\n";
  
  
  
  ?>



<?php
  include('template2.php'); 
?>
 
