<?php
  //Developed by elviscat (elviscat@gmail.com)
  //June 01, 2010 Tuesday:: Complete List of Committee Memebrs on this specific Committee
  // ./ current directory
  // ../ up level directory

  include('template0.php');
  
  //customized setup
  
  //Configuration of POST and GET Variables

  $cid = htmlspecialchars($_GET['cid'],ENT_QUOTES);
  //echo "Variable cid is :: ".$cid."<br>\n";

  //Configuration of POST and GET Variables
  
  $caption = "Complete List of Proposed Nomenclature Changes on this specific Committee<BR>\n";

  $role = $_SESSION['role'];
  if( $role != "admin"){
    Header("location:authorizedFail.php");
    exit();
  }
  
  //customized setup  

  include('template1.php');
?>
      <?php echo "<h2>".$caption."</h2><br>\n"; ?>
      <?php
        $sql_committee = "SELECT * FROM committee_grp WHERE id = '".$cid."'"; 
        //echo "sql_committee_member is ::".$sql_committee."<br>\n";
        $result_sql_committee = mysql_query($sql_committee);
        if(mysql_num_rows($result_sql_committee) > 0){
          while ( $nb2 = mysql_fetch_array($result_sql_committee) ) {
            echo "Name: ".$nb2[1]."<br>";
          }
        }
        //Related Committee Taxon Accounts
        $sql_committee_account = "SELECT * FROM committee_account WHERE ref_c_id = ".$cid;    
        $result_committee_account = mysql_query($sql_committee_account);       
        if(mysql_num_rows($result_committee_account) > 0){
          //echo "<table border=\"1\"><tr>\n";
          echo "<table width=\"640\"><tr>\n";
          echo "<td>Taxon Name</td>\n";
          echo "<td>Posts List (Recent 5 posts)</td>\n";
          echo "<td>All Posts List on this Taxon</td>\n";
          echo "</tr>\n";
          while ( $nb_committee_account = mysql_fetch_array($result_committee_account) ) {        
            $lv = $nb_committee_account[1];
            $taxon_id = $nb_committee_account[2];
            $taxon_name = taxon_name_with_level($lv, $taxon_id);
            echo "<tr>\n";
            echo "<td><a href=\"viewtaxon.php?lv=".$lv."&id=".$taxon_id."\">".$taxon_name."</a></td>\n";
            
            
            $view_all_posts_text = "";
            
            echo "<td>";
            $sql_post = "SELECT * FROM post WHERE preflv = '".$lv."' AND prefsid = '".$taxon_id."' ORDER BY pcredate DESC Limit 5";
            //echo "Variable sql_post is ".$sql_post."<br>\n";

            $post_title = "";
            $result_post = mysql_query($sql_post);
            if(mysql_num_rows($result_post) > 0){
              
              while ( $nb_post = mysql_fetch_array($result_post) ) {
                $post_title = $nb_post[1];
                
                $user_name = user_name($nb_post[4]);
                //echo "<a href=\"viewpost.php?pid=".$nb_post[0]."\"><i>".$post_title."</i></a> ".substr($nb_post[3], 0, 10)." <B><a href=\"view_completelist_comm_mem.php?pid=".$nb_post[0]."\">Add Committee Memebr from Post</a></B><br>\n";
                echo "<a href=\"viewpost.php?pid=".$nb_post[0]."\"><i>".$post_title."</i></a> ".substr($nb_post[3], 0, 10)." <br><br>\n";
              }  
              $view_all_posts_text = "<a href=\"viewapc.php?from=view_complete_post&lv=".$lv."&id=".$taxon_id."\">View all posts</a>\n";
            }else{
              echo "<b>No proposed nomenclature changes right now!</b>";
              $view_all_posts_text = "No posts!\n";
            }
            echo "</td>\n";//Recent 5 posts and view all link            
            
            echo "<td>";
            echo $view_all_posts_text."\n";
            echo "</td>\n";//All Posts on this Taxon           
            
            
            echo "</tr>\n";
          }          
          echo "</table>";
        }else{
          echo "There are no data in this Names Committee!<br>\n";
        }
        echo "<br>\n";
        echo "<br>\n";
        echo "<a href=\"committee_manage.php\">Back to Names Committee Manage Interface</a><br>\n";
        //echo "<a href=\"committee_create.php\">Create a new Names Committee?</a><br>\n";
      ?>

<?php
  include('template2.php'); 
?>
