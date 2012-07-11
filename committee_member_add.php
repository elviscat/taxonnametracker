<?php
  //Developed by elviscat (elviscat@gmail.com)
  //June 09, 2010 Wednesday:: Add one or more than one users to this Names Committee Step 1
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
  $committee_id = htmlspecialchars($_GET['committee_id'],ENT_QUOTES);
  //echo "Variable committee_id is :: ".$committee_id."<br>\n";
  //Configuration of POST and GET Variables
    
  $caption = "Add, invite and email new registered user(s) to this Names Committee";
  
  //customized setup  
  include('template1.php');

?>
<!--
		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
-->
    <script type="text/javascript" src="jquery/jquery-1.3.2.js"></script>
    <?php echo "<h2>".$caption."</h2><br>\n"; ?>
		
    <?php
      //sql example in this page: select * from user WHERE uid not in (select user_id from committee_member WHERE ref_c_id = 1); 
      $sql = "SELECT * FROM user WHERE uid not in (SELECT user_id from committee_member WHERE ref_c_id = '".$committee_id."')";
      //echo "sql is ".$sql."/n<br>";
      $result_sql = mysql_query($sql);
          
      echo "<form id=\"form\" action=\"committee_member_add2.php\" method=\"post\">";
      echo "<table>";
      echo "<tr>";
      echo "<td>Name</td>";
      echo "<td>Address</td>";
      echo "<td>Telephone Number</td>";
      echo "<td>Fax Number</td>";
      echo "<td>Email</td>";
      echo "<td>Check it to select</td>";
      echo "</tr>";
      if(mysql_num_rows($result_sql) > 0){
        while ( $nb_sql = mysql_fetch_array($result_sql) ) {
          echo "<tr>";
          echo "<td>".$nb_sql[3]."</td>";
          echo "<td>".$nb_sql[4]."</td>";
          echo "<td>".$nb_sql[5]."</td>";
          echo "<td>".$nb_sql[6]."</td>";
          echo "<td>".$nb_sql[7]."</td>";
          echo "<td><input id=\"users[]\" name=\"users[]\" type=\"checkbox\" value=\"".$nb_sql[0]."\"/></td>";
          echo "</tr>";
          //echo $nb[0]."<br>\n";
          //$select_box_text .= "<option value=\"".$nb_sql[0]."\">".$nb_sql[3]."</option>\n";
        }
      }
      echo "<tr>";
      echo "<td colspan=6><input name=\"submit_button\" id=\"submit_button\" type=\"submit\" value=\"Add and send email to invite them!\" /></td>";
      echo "</tr>";
      echo "</table>";
      echo "<input id=\"committee_id\" name=\"committee_id\" type=\"hidden\" value=\"".$committee_id."\"/>";
      echo "</form>";
      //echo $select_box_text;
    ?> 
    
<?php
  include('template2.php'); 
?>


     
