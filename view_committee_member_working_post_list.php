<?php
  //Developed by elviscat (elviscat@gmail.com)
  //June 15, 2010 Tuesday:: NEW:: View committee member's working posts list
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
  include('template1.php');

  $caption = "";
  $content = "";
  
  $uid = $_SESSION['uid'];
  if( $uid != ""){
    //
    $caption = "View and review the following recommended nomenclatorial changes (You may post a review opinion or suggestion on the following proposed nomenclatural changes):</b><br>\n";

    
    //Here is the layout of review opinion counter and edit interface
        
    //SELECT ref_c_id FROM committee_member WHERE user_id ='".$uid."'
    //SELECT level, account_id FROM committee_account WHERE ref_c_id ='".$ref_c_id."'
    //SELECT pid FROM post WHERE preflv ='".$preflv."' AND prefsid ='".$prefsid."'
    //SELECT * FROM comment WHERE crefpid ='".$crefpid."' AND crefuid ='".$uid."'
    
    //Find out this user belong which names committee
    
    
    //$sql_ref_c_id = "SELECT ref_c_id FROM committee_member WHERE user_id ='".$uid."' AND join_status = 'accept' ORDER BY ref_c_id asc";
    
    $sql_ref_c_id = "SELECT ref_c_id FROM committee_member WHERE user_id ='".$uid."' ORDER BY ref_c_id asc";
    
    
    
    //echo "sql_ref_c_id is ".$sql_ref_c_id."<br>\n";
    $result_sql_ref_c_id = mysql_query($sql_ref_c_id);
    if(mysql_num_rows($result_sql_ref_c_id) > 0){
      
      //$display_counter = 0;
      
      while ( $nb_sql_ref_c_id = mysql_fetch_array($result_sql_ref_c_id) ) {
        $ref_c_id = $nb_sql_ref_c_id[0];
        
        
        //echo names committee first
        //
        $sql_names_coommittee = "SELECT * FROM committee_grp WHERE id ='".$ref_c_id."'";
        //echo "sql_names_coommittee is ".$sql_names_coommittee."<br>\n";
        $result_sql_names_coommittee = mysql_query($sql_names_coommittee);
        if(mysql_num_rows($result_sql_names_coommittee) > 0){
          while ( $nb_sql_names_coommittee = mysql_fetch_array($result_sql_names_coommittee) ) {
            $content .= "Names Committee: ".$nb_sql_names_coommittee[1]."<br>\n";
          }
        }
        //echo names committee first
        
        
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
            
            //if( $display_counter <4 ){
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
               
                
                    /*
                    while ( $nb_sql_comment = mysql_fetch_array($result_sql_comment) ) {
                      $cid = $nb_sql_comment[0];
                      $comment_type = $nb_sql_comment[6];
                  
                      if( $comment_type == "1" ){
                        $content .= "<a href=\"viewpost.php?pid=".$pid."\">".taxon_name_by_pid2($pid)."</a> : <a href=\"view_ops_decs.php?pid=".$pid."\">view Review Opinions and Recommended Decision</a><br>\n";
                        //$content .= "<a href=\"viewpost.php?pid=".$pid."\">".taxon_name_by_pid2($pid)."</a> : <a href=\"view_ro.php?cid=".$cid."\">view Review Opinions</a><br>\n";
                      }elseif($comment_type == "2"){
                        $content .= "<a href=\"viewpost.php?pid=".$pid."\">".taxon_name_by_pid2($pid)."</a> : <a href=\"view_ops_decs.php?pid=".$pid."\">view Review Opinions and Recommended Decision</a><br>\n";
                        //$content .= "<a href=\"viewpost.php?pid=".$pid."\">".taxon_name_by_pid2($pid)."</a> : <a href=\"view_ds.php?cid=".$cid."\">view Recommended Decision</a><br>\n";
                      }else{
                        //This is general comment, do not need to show it up
                        //$content .= "cid is :: ".$cid."<br>\n";
                      }           
                    }
                    */
                  }else{
                  
                    //No review opinions and recommended decisions
                    if( $pstate == "0" && $pexpiration > $today ){
                      //$content .= "<a href=\"viewpost.php?pid=".$pid."\">Contribute to review</a><br>\n";
                      $display_counter++;
                      $content .= "(".$display_counter.")Topic: <a href=\"viewpost.php?pid=".$pid."\">".$ptitle."</a> <a href=\"viewUserProfile.php?uid=".$prefuid."\">".$user_name."</a> ".$pcredate." Need your contribution!<br>\n"; 
                    }
                    /* 
                    $sql_can_post_review = "SELECT pid FROM post WHERE preflv ='".$preflv."' AND prefsid ='".$prefsid."' AND pstate='0' AND pexpiration > '".$pexpiration."'";
                    
                    echo "sql_can_post_review is ".$sql_can_post_review."<br>\n";
                    $result_sql_can_post_review = mysql_query($sql_can_post_review);
                    if(mysql_num_rows($result_sql_can_post_review) > 0){
                      while ( $nb_sql_can_post_review = mysql_fetch_array($result_sql_can_post_review) ) {
                        $content .= "<a href=\"viewpost.php?pid=".$nb_sql_can_post_review[0]."\">Contribute to review</a><br>\n";
                      }
                    }
                    */
                  }  
                }          
              }
            //}
          }
        }    
      }
    }
  }else{
    $content .= "There is no data here!";
  }
  




?>
<!--
		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
-->
        <?php echo "<h2>".$caption."</h2><br>\n"; ?>
        <?php echo $content; ?>


<?php
  include('template2.php'); 
?>


        
