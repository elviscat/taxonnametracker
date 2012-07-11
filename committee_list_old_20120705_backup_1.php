<?php
  //Developed by elviscat (elviscat@gmail.com)
  //July 05, 2012 Thursday:: Code Logic Modification
  // ./ current directory
  // ../ up level directory

  include('template0.php');
  
  //customized setup
  
  //Configuration of POST and GET Variables

  //$view_date = htmlspecialchars($_GET['view_date'],ENT_QUOTES);
  //echo "Variable lv is view_date:: ".$view_date."<br>\n";

  //Configuration of POST and GET Variables
  
  $caption = "Names Committee List";
  
  //Access control by role
  $role = $_SESSION['role'];
  if( $role != "admin"){
    Header("location:authorizedFail.php");
    exit();
  }
  //Access control by role
  
  //customized setup  

  include('template1.php');
?>
      <?php echo "<h3>".$caption."</h3><br>\n"; ?>
      <?php
        
        $sql_committee_list = "SELECT * FROM post ORDER BY pid ASC"; 
        //echo "\$sql_committee_list is <b>".$sql_committee_list."</b><br>\n";
        $result_committee_list = mysql_query($sql_committee_list);
        if(mysql_num_rows($result_committee_list) > 0){
          echo "<table width=\"640\"><tr>\n";
          echo "<td>Committee Name</td>\n";
          echo "<td># of Joined Member</td>\n";//SELECT count(*) FROM `committee_member` WHERE ref_pid = 10 AND join_status = 'accept'
          //echo "<td>Status</td>\n";
          //echo "<td>Rank</td>\n";
          //echo "<td>Action</td>\n";
          echo "</tr>\n";
          
          while ( $nb_committee_list = mysql_fetch_array($result_committee_list) ) {
            $pid = $nb_committee_list['pid'];//ref_pid
            
            $member_invited_date = $nb_committee_member[3];
            $member_status = $nb_committee_member[4];
            $member_rank = $nb_committee_member[5];
        	
        	$number_of_joined_member;
        	
        	$sql_number_of_joined_member = "SELECT count(*) FROM `committee_member` WHERE ref_pid = ".$pid." AND join_status = 'accept'"; 
        	//echo "\$sql_number_of_joined_member is <b>".$sql_number_of_joined_member."</b><br>\n";
        	$result_number_of_joined_member = mysql_query($sql_number_of_joined_member);
        	if(mysql_num_rows($result_number_of_joined_member) > 0){
				while ( $nb_number_of_joined_member = mysql_fetch_array($result_number_of_joined_member) ) {
					$number_of_joined_member = $nb_number_of_joined_member[0];
				}
			}
			
            //
            echo "<tr>\n";
            echo "<td><a href=\"view_committee.php?pid=".$pid."\">Case No. ".$pid."</a></td>\n";//Case No.
            echo "<td>".$number_of_joined_member."</td>\n";//# of Joined Member
            
            //echo "<td>".$member_invited_date."</td>\n";//Memebr Invited Date
            //echo "<td>".ucwords($member_status)."</td>\n";//Memebr Status
            //echo "<td>".ucwords($member_rank)."</td>\n";//Memebr Rank
            echo "</tr>\n";                
          }
          echo "</table>\n";
        }
        echo "<br /><br /><a href=\"admin.php\">Back to Admin</a><BR>\n";
        
      ?>


<?php
  include('template2.php'); 
?>
