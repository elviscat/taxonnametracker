<?php
  //Developed by elviscat (elviscat@gmail.com)
  //June 04, 2010 Friday:: View single taxon change
  // ./ current directory
  // ../ up level directory

  include('template0.php');
    
  //customized setup
  //Configuration of POST and GET Variables
  
  $change_log_id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "Variable id  is <b>".$id."</b><br>\n";
  $view_date = htmlspecialchars($_GET['view_date'],ENT_QUOTES);
  //echo "Variable view_date  is <b>".$view_date."</b><br>\n";  

  //Configuration of POST and GET Variables
    
  $caption = "View Final Decision";
  
  //customized setup  

  include('template1.php');
?>

  <?php echo "<h2>".$caption."</h2><br>\n"; ?>
  <?php
  
  
  
  $taxon_name = "";
  $post_title = "";
  
  $post_id = "";
  $chg_note = "";
  $chg_reason = "";
  $chg_decision = "";
  $chgdate_time = "";
  
  
  $sql_change_log = "SELECT * FROM namelist_chglog WHERE id='".$change_log_id."'";   
  //echo "Variable sql is <b>".$sql."</b><br>\n";
  $result_change_log = mysql_query($sql_change_log);
  if(mysql_num_rows($result_change_log) > 0){
    //echo "<table border=\"1\">\n";
    
    /*
    echo "<table>\n";
    echo "<tr>\n";
    echo "<td><b>Change Note</b></td>\n";
    echo "<td><b>Reason</b></td>\n";
    echo "<td><b>Reference Post</b></td>\n";
    echo "<td><b>Change Date and Time</b></td>\n";
    echo "<td><b>Decision</b></td>\n";
    echo "<td><b>Edit</b></td>\n";
    echo "</tr>\n";
    */
    //echo "<tr><td>ID</td><td>Level</td><td>Reference of taxon data id</td><td>Reference Post Id</td><td>Reason</td><td>Change date</td><td>Change time</td>\n";
    while ( $nb_change_log = mysql_fetch_array($result_change_log) ) {
      $taxon_name = taxon_name_with_level($nb_change_log[1], $nb_change_log[2]);
      $post_id = $nb_change_log[3];
      $post_title = post_title($post_id);
      $chg_note = $nb_change_log[4];
      $chg_reason = $nb_change_log[5];
      $chg_decision = $nb_change_log[6];
      $chgdate_time = $nb_change_log[7]." ".$nb_change_log[8];      
      /*
      echo "<tr>\n";
      echo "<td>".$nb[4]."</td>\n";
      echo "<td>".$nb[5]."</td>\n";
      echo "<td><a href=\"viewpost.php?pid=".$nb[3]."\">View</a></td>\n";
      echo "<td>".$nb[7]." ".$nb[8]."</td>\n";
      echo "<td>".$nb[6]."</td>\n";
      echo "<td><a href=\"clog_chg.php?id=".$nb[0]."\">Edit</a></td>\n";
      //echo "<td>".$nb[0]."</td><td>".$nb[1]."</td><td>".$nb[2]."</td><td>".$nb[3]."</td><td>".$nb[4]."</td><td>".$nb[5]."</td><td>".$nb[6]."</td>";
      //echo "<td>".$nb[2]."</td><td>".$nb[3]."</td>";
      echo "</tr>\n";
      */
    }
    //echo "</table>\n";
  }
  
  echo "<b>Taxon:</b><br> ".$taxon_name."<br>\n";
  echo "<b>Nomenclature Issue:</b><br> <a href=\"viewpost.php?pid=".$post_id."\">".$post_title."</a><br>\n";
  echo "<b>Change Note:</b><br> ".$chg_note."<br><br>\n";
  echo "<b>Change Reason:</b><br> ".$chg_reason."<br><br>\n";
  echo "<b>Final Decision:</b><br> ".$chg_decision."<br><br>\n";
  echo "<b>Decision Date and Implemented:</b><br> ".$chgdate_time."<br><br>\n";
  
  echo "<a href=\"view_final_decisions_list.php?view_date=".$view_date."\">Back to View Final Decisions</a><br>\n";
  
  ?>



<?php
  include('template2.php'); 
?>
 
 


  



