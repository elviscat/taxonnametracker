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
  //echo "Variable id is :: ".$id."<br>\n";
  
  $users = $_POST['users'];
  $committee_id = $_POST['committee_id'];
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
  
  //Configuration of POST and GET Variables
    
  $caption = "Add, invite and email new registered user(s) to this Names Committee<br>Step 2";
  
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
          
          echo "<form id=\"form\" action=\"committee_member_add3.php\" method=\"post\">";
          echo "<table>";
          echo "<tr>";
          echo "<td colspan=\"2\">You can also add some additional message.</td>";
          echo "</tr>";
          echo "<tr>";
          echo "<td>Additional Message Title</td>";
          echo "<td><input id=\"msg_title\" name=\"msg_title\" type=\"text\" value=\"Title\" /></td>";
          echo "</tr>";
          echo "<tr>";
          echo "<td>Additional Message Content</td>";
          echo "<td><textarea id=\"msg_ccontent\" name=\"msg_content\" rows=\"10\" cols=\"50\"></textarea></td>";
          echo "</tr>";
          echo "<tr>";
          echo "<td colspan=2><input id=\"users\" name=\"users\" type=\"hidden\" value=\"".$selected_users."\" /><input name=\"submit_button\" id=\"submit_button\" type=\"submit\" value=\"Add, invite and email!\" /></td>";
          echo "</tr>";
          echo "</table>";
          echo "<input id=\"committee_id\" name=\"committee_id\" type=\"hidden\" value=\"".$committee_id."\"/>";
          echo "</form>";
          //echo $select_box_text;
        ?> 

<?php
  include('template2.php'); 
?>


