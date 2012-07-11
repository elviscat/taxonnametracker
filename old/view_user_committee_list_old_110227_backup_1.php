<?php
  //Developed by elviscat (elviscat@gmail.com)
  //June 15, 2010 Tuesday:: NEW:: View registered user's names committee list and its member status
  //June 25, 2010 Friday:: Layout modification
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
  //$cid = htmlspecialchars($_GET['cid'],ENT_QUOTES);
  //echo "Variable cid is :: ".$cid."<br>\n";
  //Configuration of POST and GET Variables
  
  $uid = $_SESSION['uid'];
  
  $user_name = user_name($uid);
  
  $caption = "Complete List of Names Committee for user: ".$user_name."\n";


  
  //customized setup  

  include('template1.php');
?>
      <?php echo "<h2>".$caption."</h2><br>\n"; ?>
      <?php
        //sql sample: SELECT ref_c_id FROM `committee_member` WHERE user_id =2 LIMIT 0 , 30 
        
        $sql_committee_member = "SELECT * FROM committee_member WHERE user_id = '".$uid."' ORDER BY ref_c_id ASC"; 
        //echo "Variable sql_ref_c_id is <b>".$sql_committee_member."</b><br>\n";
        $result_committee_member = mysql_query($sql_committee_member);
        if(mysql_num_rows($result_committee_member) > 0){
          echo "<table width=\"640\"><tr>\n";
          echo "<td>Committee Name</td>\n";
          echo "<td>Committee Notes</td>\n";
          echo "<td>Invited Date</td>\n";
          echo "<td>Status</td>\n";
          echo "<td>Rank</td>\n";
          //echo "<td>Action</td>\n";
          echo "</tr>\n";
          while ( $nb_committee_member = mysql_fetch_array($result_committee_member) ) {
            $ref_c_id = $nb_committee_member[2];
            $member_id = $nb_committee_member[0];
            $member_invited_date = $nb_committee_member[3];
            $member_status = $nb_committee_member[4];
            $member_rank = $nb_committee_member[5];
            
            
            $sql_committee = "SELECT * FROM committee_grp WHERE id = '".$ref_c_id."'"; 
            //echo "Variable sql_committee is <b>".$sql_committee."</b><br>\n";
            $result_committee  = mysql_query($sql_committee);
            if(mysql_num_rows($result_committee) > 0){
              while ( $nb_committee = mysql_fetch_array($result_committee) ) {
                //
                echo "<tr>\n";
                echo "<td><a href=\"view_committee.php?id=".$nb_committee[0]."\">".$nb_committee[1]."</a></td>\n";//Committee name
                echo "<td>".$nb_committee[2]."</td>\n";//Misc
                
                echo "<td>".$member_invited_date."</td>\n";//Memebr Invited Date
                echo "<td>".ucwords($member_status)."</td>\n";//Memebr Status
                echo "<td>".ucwords($member_rank)."</td>\n";//Memebr Rank
                //June 25, 2010 Friday:: Layout modification
                //if( $member_status == "pending" ){
                //  echo "<td><a href=\"user_committee.php?action=join&id=".$member_id."\">Join</a> Or <a href=\"user_committee.php?action=reject&id=".$member_id."\">Reject</a></td>\n";//Action: Join or Reject?
                //}else{
                //  echo "<td> -- </td>\n";//No Actions?
                //}
                //June 25, 2010 Friday:: Layout modification
                
                echo "</tr>\n";                
              }
            }
          }
          echo "</table>\n";
        }
        
      ?>

<?php
  include('template2.php'); 
?>
