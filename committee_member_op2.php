<?php
  //Developed by elviscat (elviscat@gmail.com)
  //June 09, 2010 Wednesday:: Add one or more than one users to this Names Committee Step 2
  //June 14, 2010 Monday:: some logic modification
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
  $committee_id = $_POST['committee_id'];
  $op_type = $_POST['op_type'];

  
  if($users == ""){
    echo "You need to select at least one user to send message!";
    exit;
  }else{
    // Note that $users will be an array.
    $selected_users = "";
    foreach ($users as $s) {
      $selected_users .= $s.";";
      //echo "$s<br />";
    }
    $selected_users = substr($selected_users, 0, -1);
    //echo $selected_users;    
  }  
  
  //for testing
  /*
  echo "Variable users is <b>".$selected_users."</b><br>\n";
  echo "Variable committee_id is <b>".$committee_id."</b><br>\n";
  echo "Variable op_type is <b>".$op_type."</b><br>\n";
  */
  //for testing
  
  //Configuration of POST and GET Variables
  
  $caption = "";
  $email_title = "";
  $email_content = "";
  $button_name = "";
  
  if( $op_type == "setdefault" ){
    $caption = "Set default member(s) in all names committee";
    $email_title = "You have been invited to join to default names committee member in Taxon Tracker at ".date('l jS \of F Y h:i:s A');
    $email_content = "Hi,<br>This email is informing you that you have been invited to serve as default names committee member in Taxon Tracker.<br>Please login and go to your names committee management page to join!<br>Sincerely,<br>System Administrator of Taxon Tracker<br><br>";
    $button_name = "Set, invite and email!";
        
  }elseif( $op_type == "unsetdefault" ){
    $caption = "Unset default member(s) in all names committee";
    $email_title = "You have been informed to be removed from default names committee member in Taxon Tracker at ".date('l jS \of F Y h:i:s A');
    $email_content = "Hi,<br>This email is informing you that your member role has been removed from default names committee member in Taxon Tracker.<br>Sincerely,<br>System Administrator of Taxon Tracker<br><br>";
    $button_name = "Unset, inform and email!";
    
  }elseif( $op_type == "add" ){
    $caption = "Add, invite and email new registered user(s) to this Names Committee";
    $email_title = "You have been invited to join to this names committee in Taxon Tracker at ".date('l jS \of F Y h:i:s A');
    $email_content = "Hi,<br>This email is informing you that you have been invited to serve as names committee member in Taxon Tracker.<br>Please login and go to your names committee management page to join!<br>Sincerely,<br>System Administrator of Taxon Tracker<br><br>";
    $button_name = "Add, invite and email!";
        
  }elseif( $op_type == "remove" ){
    $caption = "Remove current committee member(s) in this names committee and email to inform them this decision";
    $email_title = "You have been informed to be removed from this names committee in Taxon Tracker at ".date('l jS \of F Y h:i:s A');    
    $email_content = "Hi,<br>This email is informing you that your member role has been removed from one or some names committee(s) in Taxon Tracker.<br>Please login and go to your names committee management page to join!<br>Sincerely,<br>System Administrator of Taxon Tracker<br><br>";
    $button_name = "Remove, inform and email!";
        
  }else{
    $caption = "No specific purpose on this function, exit!";
    echo $caption;
    exit;
  }
    
  
  //customized setup  
  include('template1.php');


?>
<!--
		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
-->
        <?php echo "<h2>".$caption."</h2><br>\n"; ?>
        <?php
          
          $array_users = explode(";", $selected_users);
          $selected_users_output = "Your selected user(s): ";
          
          for($i = 0; $i < sizeof($array_users);$i++){
            $uid = $array_users[$i];                  
            //echo "uid:".$uid;
            $user_name = user_name($uid);
            $selected_users_output .= "<a href=\"viewUserProfile.php?uid=".$uid."\">".$user_name."</a>, ";                             
          }                               
          $selected_users_output = substr($selected_users_output, 0, -2);
          echo $selected_users_output;
          
          echo "<form id=\"form\" action=\"committee_member_op3.php\" method=\"post\">";
          echo "<table>";
          echo "<tr>";
          echo "<td colspan=\"2\">You can edit the title and content if you have additional message for them. Please note that this interface is under plain text. You need to insert html tag if you want to have format on this informing email.</td>";
          echo "</tr>";
          echo "<tr>";
          echo "<td>Email Title</td>";
          echo "<td><input id=\"email_title\" name=\"email_title\" type=\"text\" value=\"".$email_title."\" size=\"150\"  /></td>";
          echo "</tr>";
          echo "<tr>";
          echo "<td>Email Content</td>";
          echo "<td><textarea id=\"email_ccontent\" name=\"email_content\" rows=\"20\" cols=\"100\">".$email_content."</textarea></td>";
          echo "</tr>";
          echo "<tr>";
          echo "<td colspan=2><input id=\"users\" name=\"users\" type=\"hidden\" value=\"".$selected_users."\" />";
          echo "<input name=\"submit_button\" id=\"submit_button\" type=\"submit\" value=\"".$button_name."\" /></td>";
          echo "</tr>";
          echo "</table>";
          echo "<input id=\"committee_id\" name=\"committee_id\" type=\"hidden\" value=\"".$committee_id."\"/>";
          echo "<input id=\"op_type\" name=\"op_type\" type=\"hidden\" value=\"".$op_type."\"/>";
          echo "</form>";
          //echo $select_box_text;
        ?> 

<?php
  include('template2.php'); 
?>


