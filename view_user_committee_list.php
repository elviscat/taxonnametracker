<?php
  //Developed by elviscat (elviscat@gmail.com)
  //June 15, 2010 Tuesday:: NEW:: View registered user's names committee list and its member status
  //June 25, 2010 Friday:: Layout modification
  //February 27, 2011 Sunday:: Code Logic modification
  //February 27, 2011 Sunday:: Code Logic modification
  //February 27, 2011 Sunday:: Code Logic modification
  
  //July 05, 2012 Thursday:: Code logic and layout modification
  //July 08, 2012 Sunday:: Code logic and layout modification
  
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
  
  $caption = "Complete List of Review Committee for user: ".$user_name."\n";


  
  //customized setup  

  include('template1.php');
?>
      <?php echo "<h3>".$caption."</h3><br>\n"; ?>
      <?php
        //sql sample: SELECT ref_c_id FROM `committee_member` WHERE user_id =2 LIMIT 0 , 30 
        
        $sql_committee_member = "SELECT * FROM committee_member WHERE ref_uid = '".$uid."' ORDER BY ref_pid ASC"; 
        //echo "Variable sql_ref_c_id is <b>".$sql_committee_member."</b><br>\n";
        $result_committee_member = mysql_query($sql_committee_member);
        if(mysql_num_rows($result_committee_member) > 0){
          echo "<table width=\"640\"><tr>\n";
          echo "<td>Committee Name</td>\n";
          echo "<td>Invited Date</td>\n";
          echo "<td>Status</td>\n";
          echo "<td>Rank</td>\n";
          //echo "<td>Action</td>\n";
          echo "</tr>\n";
          while ( $nb_committee_member = mysql_fetch_array($result_committee_member) ) {
            $pid = $nb_committee_member[2];//ref_pid
            
            $member_invited_date = $nb_committee_member[3];
            $member_status = $nb_committee_member[4];
            $member_rank = $nb_committee_member[5];
            //
            echo "<tr>\n";
            echo "<td><a href=\"view_committee.php?pid=".$pid."\">Case No. ".$pid."</a></td>\n";//Case No.
            echo "<td>".$member_invited_date."</td>\n";//Memebr Invited Date
            echo "<td>".ucwords($member_status)."</td>\n";//Memebr Status
            echo "<td>".ucwords($member_rank)."</td>\n";//Memebr Rank
            echo "</tr>\n";                
          }
          echo "</table>\n";
        }
        echo "<br /><br /><a href=\"admin.php\">Back to Admin</a><BR>\n";
      ?>

<?php
  include('template2.php'); 
?>
