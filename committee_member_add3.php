<?php
  //Developed by elviscat (elviscat@gmail.com)
  //June 09, 2010 Wednesday:: Add one or more than one users to this Names Committee Step 2
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
  //$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "Variable id is <b>".$id."</b><br>\n";
  
  $users = $_POST['users'];
  //echo "Variable users is <b>".$users."</b><br>\n";
  if($users == ""){
    echo "You need to select at least one user to send message!";
    exit;
  }else{
    /*
    // Note that $users will be an array.
    $selected_users = "";
    foreach ($users as $s) {
      $selected_users .= $s.";";
      //echo "$s<br />";
    }
    $selected_users = substr($selected_users, 0, -1);
    //echo $selected_users;
    */    
  }  
  
  //Configuration of POST and GET Variables
    
  $caption = "Add, invite and email new registered user(s) to this Names Committee<br>Step 3";
  
  //customized setup  
  include('template1.php');


  require('phpmailer/class.phpmailer.php');

  $users = $_POST['users'];
  $committee_id = $_POST['committee_id'];
  $msg_title = $_POST['msg_title'];
  $msg_content = htmlspecialchars($_POST['msg_content'],ENT_QUOTES);
  
  //echo "users is ::".$users."<br>\n";
  //echo "msg_title is ::".$msg_title."<br>\n";
  //echo "msg_content is ::".$msg_content."<br>\n";

?>
<!--
		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
-->
        <?php echo "<h2>".$caption."</h2><br>\n"; ?>
        <?php
          $array_users = explode(";", $users);
          
          $from_email = $admin_email;
          $from_email_name = $from_email_name;  
          $eml_address = "";

          $invite_date = date("Y-m-d");//"2008-08-28 11:03:21"
              
          $max_committee_member_id = 0;
          $sql_max_committee_member_id = "SELECT (Max(id)+1) FROM committee_member";
		      $result_max_committee_member_id = mysql_query($sql_max_committee_member_id);	  
          list($max_committee_member_id) = mysql_fetch_row($result_max_committee_member_id);
		      if($max_committee_member_id == 0){
		        $max_committee_member_id = 1;
		      }          
          
          for($i = 0; $i < sizeof($array_users);$i++){
          
            $send_to = $array_users[$i];
            
            
            $sql = "SELECT * FROM user WHERE uid='".$send_to."'";
            //echo "sql is ".$sql."/n<br>";
            $result_sql = mysql_query($sql);
            if(mysql_num_rows($result_sql) > 0){
              while ( $nb_sql = mysql_fetch_array($result_sql) ) {
                $eml_address = $nb_sql[7];
              echo "</tr>";
              }
            }
                        
            $eml_subject = "You have been invited to join to this names committee in Taxon Tracker at ".date('l jS \of F Y h:i:s A');
            $eml_content = "Hi,<br>";
            $eml_content .= "Please login and go to your names committee management page to join to this names committee!<BR>";
            $eml_content .= "<br>\n";
            $eml_content .= "Sincerely,<br>";
            $eml_content .= "System Administrator of Taxon Tracker<br><br>";            
            $eml_content .= "Additional Message:<br>Title:".$msg_title."<br>Content:".$msg_content;
            
            
            
            if(email("slumailrelay.slu.edu", $from_email, $from_email_name, $eml_address, $eml_subject, $eml_content)){
              
		          
              $sql_insert_to_committee_member = "INSERT INTO committee_member (id, user_id, ref_c_id,	invited_date,	join_status, rank_level)";
              $sql_insert_to_committee_member .= " VALUES ('$max_committee_member_id','$send_to','$committee_id','$invite_date','pending', 'member')";
              "Variable sql_insert_to_committee_member is <b>".$sql_insert_to_committee_member."</b><br>\n";
              $result=mysql_query($sql_insert_to_committee_member);
              $max_committee_member_id++;                


              echo "Your message has sent to these users!<br>\n";



            }else{
              echo "Fail to send this message!";
            }             
        
          }
        
          echo "<a href=\"view_completelist_comm_mem.php?cid=".$committee_id."\">Back to this Names Committee</a><br>";
        
        ?>

<?php
  include('template2.php'); 
?>



      
