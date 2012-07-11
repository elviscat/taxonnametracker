<?php
  //Developed by elviscat (elviscat@gmail.com)
  //July 05, 2012 Thursday:: Code Logic Modification
  //July 06, 2012 Friday:: Code Logic modification
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
          //echo "<table width=\"640\"><tr>\n";
          echo "<table>\n";
          echo "<tr>\n";
          echo "<td>Committee Name</td>\n";
          echo "<td>Proposal</td>\n";
          echo "<td>Number of Invited Member</td>\n";//SELECT count(*) FROM `committee_member` WHERE ref_pid = 10
          echo "<td>Number of Joined Member</td>\n";//SELECT count(*) FROM `committee_member` WHERE ref_pid = 10 AND join_status = 'accept'
          echo "<td>Vote Statistics</td>\n";//vote_opinion
          
          //echo "<td>Status</td>\n";
          //echo "<td>Rank</td>\n";
          //echo "<td>Action</td>\n";
          echo "</tr>\n";
          
          while ( $nb_committee_list = mysql_fetch_array($result_committee_list) ) {
            $pid = $nb_committee_list['pid'];//ref_pid
            
            $number_of_invited_member;
            
        	$sql_number_of_invited_member = "SELECT count(*) FROM `committee_member` WHERE ref_pid = ".$pid; 
        	//echo "\$sql_number_of_invited_member is <b>".$sql_number_of_invited_member."</b><br>\n";
        	$result_number_of_invited_member = mysql_query($sql_number_of_invited_member);
        	if(mysql_num_rows($result_number_of_invited_member) > 0){
				while ( $nb_number_of_invited_member = mysql_fetch_array($result_number_of_invited_member) ) {
					$number_of_invited_member = $nb_number_of_invited_member[0];
				}
			}





        	
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
            echo "<td><a href=\"viewpost.php?pid=".$pid."\">".$nb_committee_list['ptitle']."</a></td>\n";//Post::Taxonomic Change Proposal
            echo "<td>".$number_of_invited_member."</td>\n";//Number of Invited Member
            echo "<td>".$number_of_joined_member."</td>\n";//Number of Joined Member
            
            
        	$vote_opinion;
        	$vote_approve_count = 0;
        	$vote_disapprove_count = 0;
        	$vote_abstain_count = 0;
        	
        	$sql_vote_opinion = "SELECT * FROM `committee_member` WHERE ref_pid = ".$pid." AND join_status = 'accept'"; 
        	//echo "\$sql_vote_opinion is <b>".$sql_vote_opinion."</b><br>\n";
        	$result_vote_opinion = mysql_query($sql_vote_opinion);
        	if(mysql_num_rows($result_vote_opinion) > 0){
				while ( $nb_vote_opinion = mysql_fetch_array($result_vote_opinion) ) {
					$vote_opinion = $nb_vote_opinion['vote_opinion'];
					if( $vote_opinion == 'Approve'){
						$vote_approve_count +=1;
					}else if( $vote_opinion == 'Disapprove' ){
						$vote_disapprove_count +=1;
					}else if( $vote_opinion == 'Abstain' ){
						$vote_abstain_count +=1;
					}
				}
			}
            echo "<td>Approve:".$vote_approve_count."<br />Disapprove:".$vote_disapprove_count."<br />Abstain:".$vote_abstain_count."<br /></td>\n";//Vote Result
            
            
            
            //echo "<td>".$member_invited_date."</td>\n";//Memebr Invited Date
            //echo "<td>".ucwords($member_status)."</td>\n";//Memebr Status
            //echo "<td>".ucwords($member_rank)."</td>\n";//Memebr Rank
            echo "</tr>\n";                
          }
          echo "</table>\n";
        }else{
        	echo "This is no assigned review committee right now!<br />\n";
        }
        echo "<br /><br /><a href=\"admin.php\">Back to Admin</a><br /><br />\n";
        
      ?>


<?php
  include('template2.php'); 
?>
