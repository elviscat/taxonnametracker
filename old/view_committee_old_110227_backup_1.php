<?php
  //Developed by elviscat (elviscat@gmail.com)
  //June 04, 2010 Friday:: View single taxon change
  // ./ current directory
  // ../ up level directory

  include('template0.php');
    
  //customized setup
  //Configuration of POST and GET Variables
  
  $committee_id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "Variable id  is <b>".$id."</b><br>\n";
  $view_date = htmlspecialchars($_GET['view_date'],ENT_QUOTES);
  //echo "Variable view_date  is <b>".$view_date."</b><br>\n";  

  //Configuration of POST and GET Variables
    
  $caption = "View Names Committee Information";
  
  //customized setup  

  include('template1.php');
?>

  <?php echo "<h2>".$caption."</h2><br>\n"; ?>
  <?php
  
  
  
  $committee_name = "";
  $committee_misc_note = "";

  if( $committee_id != ""){
  
    $ref_c_id = $committee_id;

  
    //Render the names committee basic information
    $sql_committee_name = "SELECT * FROM committee_grp WHERE id='".$committee_id."'";   
    //echo "Variable sql_committee_name is <b>".$sql_committee_name."</b><br>\n";
    $result_committee_name = mysql_query($sql_committee_name);
    if(mysql_num_rows($result_committee_name) > 0){

      while ( $nb_committee_name = mysql_fetch_array($result_committee_name) ) {
        $committee_name = $nb_committee_name[1];
        $committee_misc_note = $nb_committee_name[2];
      }
    }
    echo "<b>Names Committee Name:</b><br> ".$committee_name."<br><br>\n";
    echo "<b>Names Committee Misc Note:</b><br> <font color=\"black\">".$committee_misc_note."</font><BR>\n";
  
    echo "<b>Taxon in this Names Committee:</b><br><br>\n";
    //Render taxon account information in this names committee
    $sql_committee_taxon_account = "SELECT * FROM committee_account WHERE ref_c_id='".$ref_c_id."'";   
    //echo "Variable sql_committee_taxon_account is <b>".$sql_committee_taxon_account."</b><br>\n";
    $result_committee_taxon_account = mysql_query($sql_committee_taxon_account);
    if(mysql_num_rows($result_committee_taxon_account) > 0){

      while ( $nb_committee_taxon_account = mysql_fetch_array($result_committee_taxon_account) ) {
        $taxon_lv = $nb_committee_taxon_account[1];
        $taxon_id = $nb_committee_taxon_account[2];
        $taxon_name = taxon_name_with_level($taxon_lv, $taxon_id);
        echo "<a href=\"viewtaxon.php?lv=".$taxon_lv."&id=".$taxon_id."\">".$taxon_name."</a><br>\n";
      }
    }  
  
    echo "<b>Member in this Names Committee:</b><br><br>\n";
    //Render member information in this names committee
    $sql_committee_taxon_member = "SELECT * FROM committee_member WHERE ref_c_id='".$ref_c_id."'";   
    //echo "Variable sql_committee_taxon_member is <b>".$sql_committee_taxon_member."</b><br>\n";
    $result_committee_taxon_member = mysql_query($sql_committee_taxon_member);
    if(mysql_num_rows($result_committee_taxon_member) > 0){
      echo "<table width=\"800\">\n";
      echo "<tr>\n";
      echo "<td>Memebr Name</td>\n";
      echo "<td>Invitation</td>\n";
      echo "<td>Rnak</td>\n";
      echo "<td>Status</td>\n";
      echo "</tr>\n";

      while ( $nb_committee_taxon_member = mysql_fetch_array($result_committee_taxon_member) ) {
        $user_id = $nb_committee_taxon_member[1];
        $user_name = user_name($user_id);
      
        $invitation_date = $nb_committee_taxon_member[3];
        $rank = $nb_committee_taxon_member[4];
        $status = $nb_committee_taxon_member[5];
        //$rank = taxon_name_wiht_level($taxon_lv, %taxon_id);
        echo "<tr>\n";
        echo "<td><a href=\"viewUserProfile.php?uid=".$user_id."\">".$user_name."</a></td>\n";
        echo "<td>".$invitation_date."</td>\n";
        echo "<td>".ucwords($rank)."</td>\n";
        echo "<td>".ucwords($status)."</td>\n";
        echo "</tr>\n";
      }
      echo "</table>\n";
    }
    
    //June 25, 2010 Friday:: Layout modification
    $ref_c_id = $committee_id;
    $uid = $_SESSION[uid];
    $sql_com_mem = "SELECT * FROM committee_member WHERE user_id = '".$uid."' and ref_c_id = '".$ref_c_id."'"; 
    //echo "Variable sql_com_mem is <b>".$sql_com_mem."</b><br>\n";
    $result_com_mem = mysql_query($sql_com_mem);
    if(mysql_num_rows($result_com_mem) > 0){
      while ( $nb_com_mem = mysql_fetch_array($result_com_mem) ) {
        $member_id = $nb_com_mem[0];
        $join_status = $nb_com_mem[4];
        //
        if( $join_status == "pending" ){
          echo "<br><b>Action:</b><br><br>\n";
          echo "<a href=\"user_committee.php?action=join&id=".$member_id."\">Join</a> Or <a href=\"user_committee.php?action=reject&id=".$member_id."\">Reject</a></td>\n";//Action: Join or Reject?
        }else{
          //Do nothing
        }
      }          
    }            
    //June 25, 2010 Friday:: Layout modification
    
    if( $view_date != "" ){
      echo "<a href=\"view_final_decisions_list.php?view_date=".$view_date."\">Back to View Final Decisions</a><br>\n";
    }
  }else{
    echo "There is no data in this page!";
  }
  
    ?>



<?php
  include('template2.php'); 
?>
 
