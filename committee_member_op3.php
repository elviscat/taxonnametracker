<?php
  //Developed by elviscat (elviscat@gmail.com)
  //June 09, 2010 Wednesday:: Add one or more than one users to this Names Committee Step 2
  //June 14, 2010 Monday:: logic modification
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
    
  //$caption = "Add, invite and email new registered user(s) to this Names Committee<br>Step 3";
  
  //customized setup  
  include('template1.php');


  require('phpmailer/class.phpmailer.php');

  $users = $_POST['users'];
  $committee_id = $_POST['committee_id'];
  $email_title = $_POST['email_title'];
  //$email_content = htmlspecialchars($_POST['email_content'],ENT_QUOTES);
  $email_content = $_POST['email_content'];
  $op_type = $_POST['op_type'];
  
  /*
  echo "users is ::".$users."</b><br>\n";
  echo "op_type is ::".$op_type."</b><br>\n";
  echo "email_title is <b>".$email_title."</b><br>\n";
  echo "email_content is <b>".$email_content."</b><br>\n";
  */

  $caption = "";
  $sql_operation = "";
  



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

          $invite_date = date("Y-m-d H:i:s");//"2008-08-28 11:03:21"
              
          $max_committee_member_id = 0;
          $sql_max_committee_member_id = "SELECT (Max(id)+1) FROM committee_member";
		      $result_max_committee_member_id = mysql_query($sql_max_committee_member_id);	  
          list($max_committee_member_id) = mysql_fetch_row($result_max_committee_member_id);
		      if($max_committee_member_id == 0){
		        $max_committee_member_id = 1;
		      }          
          
          for($i = 0; $i < sizeof($array_users);$i++){
          
            $uid = $array_users[$i];
             
            $user_name = user_name($uid);
            $user_email = user_email($uid);
            
            /*
            $sql = "SELECT * FROM user WHERE uid='".$send_to."'";
            //echo "sql is ".$sql."/n<br>";
            $result_sql = mysql_query($sql);
            if(mysql_num_rows($result_sql) > 0){
              while ( $nb_sql = mysql_fetch_array($result_sql) ) {
                $eml_address = $nb_sql[7];
              echo "</tr>";
              }
            }
            */
            $eml_address = $user_email;
            
            /*            
            $eml_subject = "You have been invited to join to this names committee in Taxon Tracker at ".date('l jS \of F Y h:i:s A');
            $eml_content = "Hi,<br>";
            $eml_content .= "Please login and go to your names committee management page to join to this names committee!<BR>";
            $eml_content .= "<br>\n";
            $eml_content .= "Sincerely,<br>";
            $eml_content .= "System Administrator of Taxon Tracker<br><br>";            
            $eml_content .= "Additional Message:<br>Title:".$msg_title."<br>Content:".$msg_content;
            */
            if( $op_type == "setdefault" ){
              $caption = "Set default member(s) in all names committee";
              
              $sql_already_in_check = "SELECT * FROM committee_member WHERE user_id='".$uid."' AND ref_c_id = '0'";
              $result_already_in_check = mysql_query($sql_already_in_check);
              if(mysql_num_rows($result_already_in_check) > 0){
                echo "Duplicated insertion! Exit!";
              }else{  
                $sql_operation = "INSERT INTO committee_member (id, user_id, ref_c_id,	invited_date,	join_status, rank_level)";
                $sql_operation .= " VALUES ('$max_committee_member_id','$uid','0','$invite_date','pending', 'member')";
              }
            }elseif( $op_type == "unsetdefault" ){
              $caption = "Unset default member(s) in all names committee";
              $sql_operation = "UPDATE committee_member SET join_status = 'removed' WHERE user_id ='".$uid."' and ref_c_id = '0'";
            }elseif( $op_type == "add" ){
              $caption = "Add, invite and email new registered user(s) to this Names Committee";
              
              $sql_already_in_check = "SELECT * FROM committee_member WHERE user_id='".$uid."' AND ref_c_id = '".$committee_id."'";
              $result_already_in_check = mysql_query($sql_already_in_check);
              if(mysql_num_rows($result_already_in_check) > 0){
                echo "Duplicated insertion! Exit!";
              }else{  
                $sql_operation = "INSERT INTO committee_member (id, user_id, ref_c_id,	invited_date,	join_status, rank_level)";
                $sql_operation .= " VALUES ('$max_committee_member_id','$uid','$committee_id','$invite_date','pending', 'member')";
              }              

            }elseif( $op_type == "remove" ){
              $caption = "Remove current committee member(s) in this names committee and email to inform them this decision";
              $sql_operation = "UPDATE committee_member SET join_status = 'removed' WHERE user_id ='".$uid."' and ref_c_id = '".$committee_id."'";
            }else{
              $caption = "No specific purpose on this function, exit!";
              echo $caption;
              exit;
            }
            //echo "Variable sql_operation is <b>".$sql_operation."</b><br>\n";
            
            
            $eml_subject = $email_title;
            $eml_content .= $email_content;
            
            
            if(email("slumailrelay.slu.edu", $from_email, $from_email_name, $eml_address, $eml_subject, $eml_content)){
              
		          
              $result_operation = mysql_query($sql_operation);
              $max_committee_member_id++;                


              echo "Your message has sent to ".$user_name."!<br>\n";



            }else{
              echo "Fail to send this message!";
            }
        
          }
          
          $pid = "";
          $sql_pid = "SELECT refpid FROM committee_grp WHERE id='".$committee_id."'";
          $result_pid = mysql_query($sql_pid);	  
          list($pid) = mysql_fetch_row($result_pid);
          if($pid != ""){
            echo "<a href=\"view_completelist_comm_mem.php?pid=".$pid."\">Back to this Names Committee</a><br>";
          }
          
        ?>

<?php
  include('template2.php'); 
?>



      
