<?php
  //Developed by elviscat (elviscat@gmail.com)
  //June 10, 2010 Wednesday:: NEW:: Names Committee Member Operation:: Add, Remove and Set as default
  //June 14, 2010 Monday:: NEW:: Some logic modification
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
  //echo "Variable committee_id is <b>".$committee_id."</b><br>\n";

  $op_type = htmlspecialchars($_GET['op_type'],ENT_QUOTES);// op_type == operation type
  //echo "Variable op_type is <b>".$op_type."</b><br>\n";
  
  //Configuration of POST and GET Variables
  
  $caption = "";
  $sql = "";
  $output = "";

  if( $op_type == "setdefault" ){
    $caption = "Set default member(s) in all names committee";
  }elseif( $op_type == "unsetdefault" ){
    $caption = "Unset default member(s) in all names committee";
  }elseif( $op_type == "add" ){
    $caption = "Add, invite and email new registered user(s) to this Names Committee";
  }elseif( $op_type == "remove" ){
    $caption = "Remove current committee member(s) in this names committee and email to inform them this decision";
  }else{
    $caption = "No specific purpose on this function, exit!";
    echo $caption;
    exit;
  }

  $sql_default_members = "SELECT * FROM user WHERE uid in (SELECT user_id from committee_member WHERE ref_c_id = '0')";
  $result_default_members = mysql_query($sql_default_members);
  if(mysql_num_rows($result_default_members) > 0){
    $output .= "<h3>Current Default Names Committee Member(s)</h3><br>";
    $output .= "<table width=\"640\">";
    $output .= "<tr>";
    $output .= "<td>Name</td>";
    $output .= "<td>Address</td>";
    $output .= "<td>Telephone Number</td>";
    $output .= "<td>Fax Number</td>";
    $output .= "<td>Email</td>";
    $output .= "</tr>";
    while ( $nb_default_members = mysql_fetch_array($result_default_members) ) {
      //
      //
      $output .= "<tr>";
      $output .= "<td>".$nb_default_members[3]."</td>";
      $output .= "<td>".$nb_default_members[4]."</td>";
      $output .= "<td>".$nb_default_members[5]."</td>";
      $output .= "<td>".$nb_default_members[6]."</td>";
      $output .= "<td>".$nb_default_members[7]."</td>";
      $output .= "</tr>";        
    }
    $output .= "</table>";
    $output .= "<br>";
    $output .= "<br>";
    $output .= "<br>";
  }else{
    $output .= "<br><br><b>There is no default names committee member(s) right now.</b><br><br>";
  }  

  $customized_caption = "";
  
  if( $op_type == "setdefault" ){
    $sql = "SELECT * FROM user WHERE uid not in (SELECT user_id from committee_member WHERE ref_c_id = '0')";
    $customized_caption .= "<h3>Select the registered user(s) below, and they will be set as default names committee member in each names committee.</h3>";
    $button_name = "Set default and invite them through email!";
  }elseif( $op_type == "unsetdefault" ){
    $sql = "SELECT * FROM user WHERE uid in (SELECT user_id from committee_member WHERE ref_c_id = '0')";
    $customized_caption .= "<h3>Select the default names committee member(s) below, and they will be unset from default names committee member in each names committee.</h3>";
    $button_name = "Unset default and inform them through email!";
  }elseif( $op_type == "add" ){
    //sql example in this page: select * from user WHERE uid not in (select user_id from committee_member WHERE ref_c_id = 1); 
    $sql = "SELECT * FROM user WHERE uid not in (SELECT user_id from committee_member WHERE ref_c_id = '".$committee_id."' OR ref_c_id = '0')";
    $customized_caption .= "<h3>You can invite them to serve as names committee member(s).</h3>";
    $button_name = "Add and invite them through email!";
  }elseif( $op_type == "remove" ){
    $sql = "SELECT * FROM user WHERE uid in (SELECT user_id from committee_member WHERE ref_c_id = '".$committee_id."')";
    $customized_caption .= "<h3>You can remove some of current names committee member(s) from this list.</h3>";
    $button_name = "Remove and inform them through email!";
  }
    
  //echo "Variable sql is <b>".$sql."</b><br>\n";
  $result_sql = mysql_query($sql);
  
  $output .= "<form id=\"form\" action=\"committee_member_op2.php\" method=\"post\">";

  if(mysql_num_rows($result_sql) > 0){
    $output .= $customized_caption;
    $output .= "<table width=\"640\">";
    $output .= "<tr>";
    $output .= "<td>Name</td>";
    $output .= "<td>Address</td>";
    $output .= "<td>Telephone Number</td>";
    $output .= "<td>Fax Number</td>";
    $output .= "<td>Email</td>";
    $output .= "<td>Check it to select</td>";
    $output .= "</tr>";

    while ( $nb_sql = mysql_fetch_array($result_sql) ) {
      $output .= "<tr>";
      $output .= "<td>".$nb_sql[3]."</td>";
      $output .= "<td>".$nb_sql[4]."</td>";
      $output .= "<td>".$nb_sql[5]."</td>";
      $output .= "<td>".$nb_sql[6]."</td>";
      $output .= "<td>".$nb_sql[7]."</td>";
      $output .= "<td><input id=\"users[]\" name=\"users[]\" type=\"checkbox\" value=\"".$nb_sql[0]."\"/></td>";
      $output .= "</tr>";
      //$output .= $nb[0]."<br>\n";
      //$select_box_text .= "<option value=\"".$nb_sql[0]."\">".$nb_sql[3]."</option>\n";
    }
  }
  $output .= "<tr>";
  $output .= "<td colspan=6><input name=\"submit_button\" id=\"submit_button\" type=\"submit\" value=\"".$button_name."\" /></td>";
  $output .= "</tr>";
  $output .= "</table>";
  $output .= "<input id=\"committee_id\" name=\"committee_id\" type=\"hidden\" value=\"".$committee_id."\"/>";
  $output .= "<input id=\"op_type\" name=\"op_type\" type=\"hidden\" value=\"".$op_type."\"/>";
  $output .= "</form>";
  //$output .= $select_box_text;
  $output .= "<br>";
  $output .= "<br>";
  $output .= "<br>";

  
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
		<?php echo $output; ?>
    
<?php
  include('template2.php'); 
?>


     
