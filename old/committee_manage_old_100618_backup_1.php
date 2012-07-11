<?php
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 15, 2009 Sunday:: registered user view his belonging names committee 
  //Nov 17, 2009 Tuesday:: add function of editing names committees
  // ./ current directory
  // ../ up level directory

  include('template0.php');
  
  //customized setup
  
  //Configuration of POST and GET Variables

  //$view_date = htmlspecialchars($_GET['view_date'],ENT_QUOTES);
  //echo "Variable lv is view_date:: ".$view_date."<br>\n";

  //Configuration of POST and GET Variables
  
  $caption = "<u>Names Committee Management</u><BR>\n";
  
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
      <?php echo "<h2>".$caption."</h2><br>\n"; ?>
      <?php
        $sql_committee = "SELECT * FROM committee_grp"; 
        //echo "sql_committee_member is ::".$sql_committee."<br>\n";
        $result_sql_committee = mysql_query($sql_committee);
        if(mysql_num_rows($result_sql_committee) > 0){
          echo "<table border=\"1\"><tr>\n";
          echo "<td>Names Committee Series Number</td>\n";
          echo "<td>Name</td>\n";
          echo "<td>Note</td>\n";
          echo "<td>Related Taxon Account</td>\n";
          echo "<td>Users who are belonging to this Names Committee</td>\n";
          echo "<td>Users who are under invitation pending list</td>\n";
          echo "<td>Users who are under invitation reject list</td>\n";
          echo "<td>View Complete List of Committee Members on this Committee</td>\n";
          echo "<td>View Complete List of proposed nomenclature changes on this Committee</td>\n";
          echo "<td>Edit on Names Committee title and misc notes</td>\n";
          echo "</tr>\n";
          
          while ( $nb2 = mysql_fetch_array($result_sql_committee) ) {
            echo "<tr>";
            echo "<td>".$nb2[0]."</td>";//group_id
            echo "<td>".$nb2[1]."</td>";//committee_name
            echo "<td>".$nb2[2]."</td>";//misc_note
            //Related taxon acoount
            $sql_committee_table_account = "SELECT * FROM committee_account WHERE ref_c_id = ".$nb2[0];    
            $result_sql_committee_table_account = mysql_query($sql_committee_table_account);
            echo "<td>";
            if(mysql_num_rows($result_sql_committee_table_account) > 0){
              while ( $nb3 = mysql_fetch_array($result_sql_committee_table_account) ) {
                $sql_account_name = "";
                $lv = $nb3[1];
                $id = $nb3[2];
                if($nb3[1] == "family"){
                  $sql_account_name = "SELECT ffamily FROM flist WHERE fid =".$nb3[2];
                }elseif($nb3[1] == "genus"){
                  $sql_account_name = "SELECT ggenus FROM glist WHERE gid =".$nb3[2];
                }elseif($nb3[1] == "species"){
                  $sql_account_name = "SELECT sgenus,sspecies FROM slist WHERE sid =".$nb3[2];
                }
                $result_sql_account_name = mysql_query($sql_account_name);
                $account_name = "";
                if(mysql_num_rows($result_sql_account_name) > 0){
                  while ( $nb4 = mysql_fetch_array($result_sql_account_name) ) {
                    if($nb3[1] == "species"){
                      $account_name = "<i>".$nb4[0]." ".$nb4[1]."</i>";
                    }else{
                      $account_name = $nb4[0];
                    }
                  }
                }
                echo "<a href=\"viewtaxon.php?lv=".$lv."&id=".$id."\">".$account_name."(".ucwords($nb3[1]).")</a><br>";
              }
            }
            echo "</td>";
            //Related user
            $sql_committee_table_user = "SELECT * FROM committee_member WHERE ref_c_id = ".$nb2[0]." AND join_status = 'accept' ";
            $result_sql_committee_table_user = mysql_query($sql_committee_table_user);
            echo "<td>";
            if(mysql_num_rows($result_sql_committee_table_user) > 0){
              while ( $nb5 = mysql_fetch_array($result_sql_committee_table_user) ) {
                $sql_user_name = "SELECT * FROM user WHERE uid =".$nb5[1];
                $result_sql_user_name = mysql_query($sql_user_name);
                if(mysql_num_rows($result_sql_user_name) > 0){
                  while ( $nb6 = mysql_fetch_array($result_sql_user_name) ) {
                    echo "<a href=\"viewUserProfile.php?uid=".$nb6[0]."\">".$nb6[3]."</a><br>\n";
                  }
                }
              }
            }
            echo "</td>";
            
            //May 26, 2010 Wednesday:: Users who is under invitation pending list
            $sql_committee_table_user = "SELECT * FROM committee_member WHERE ref_c_id = ".$nb2[0]." AND join_status = 'pending' ";
            $result_sql_committee_table_user = mysql_query($sql_committee_table_user);
            echo "<td>";
            if(mysql_num_rows($result_sql_committee_table_user) > 0){
              while ( $nb5 = mysql_fetch_array($result_sql_committee_table_user) ) {
                $sql_user_name = "SELECT * FROM user WHERE uid =".$nb5[1];
                $result_sql_user_name = mysql_query($sql_user_name);
                if(mysql_num_rows($result_sql_user_name) > 0){
                  while ( $nb6 = mysql_fetch_array($result_sql_user_name) ) {
                    echo "<a href=\"viewUserProfile.php?uid=".$nb6[0]."\">".$nb6[3]."</a><br>\n";
                  }
                }
              }
            }            
            echo "</td>";

            //June 01, 2010 Tuesday:: Users who is under invitation reject list
            $sql_committee_table_user = "SELECT * FROM committee_member WHERE ref_c_id = ".$nb2[0]." AND join_status = 'reject' ";
            $result_sql_committee_table_user = mysql_query($sql_committee_table_user);
            echo "<td>";
            if(mysql_num_rows($result_sql_committee_table_user) > 0){
              while ( $nb5 = mysql_fetch_array($result_sql_committee_table_user) ) {
                $sql_user_name = "SELECT * FROM user WHERE uid =".$nb5[1];
                $result_sql_user_name = mysql_query($sql_user_name);
                if(mysql_num_rows($result_sql_user_name) > 0){
                  while ( $nb6 = mysql_fetch_array($result_sql_user_name) ) {
                    echo "<a href=\"viewUserProfile.php?uid=".$nb6[0]."\">".$nb6[3]."</a><br>\n";
                  }
                }
              }
            }            
            echo "</td>";

            //June 01, 2010 Tuesday:: Complete List of Committee Members
            echo "<td>";
            echo "<a href=\"view_completelist_comm_mem.php?cid=".$nb2[0]."\">View</a><br>\n";            
            echo "</td>";

            //June 01, 2010 Tuesday:: Complete List of Proposed nomenclature changes
            echo "<td>";
            echo "<a href=\"view_completelist_post.php?cid=".$nb2[0]."\">View</a><br>\n";            
            echo "</td>";            
            
            
                        
            echo "<td><a href=\"committee_chg.php?committee_id=".$nb2[0]."\">Edit it</a></td>";
            echo "</tr>";
          }
          echo "</table>";
        }else{
          echo "There are no data in TABLE:: committee_grp!<br>\n";
        }
        echo "<br>\n";
        echo "<br>\n";
        //echo "<br>\n";
        
        //echo "<a href=\"committee_create.php\">Create a new Names Committee?</a><br>\n"
        //echo "<br>\n";
        //echo "<br>\n";
        
      ?>


<?php
  include('template2.php'); 
?>
