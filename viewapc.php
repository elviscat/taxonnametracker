<?php
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 12, 2009 Thursday:: View all proposed changes
  //Jan 05, 2010 Tuesday:: Layout modification
  //Jan 11, 2010 Monday:: Layout modification
  //Jan 14, 2010 Thursday:: Layout and logic modification
  //Jan 19, 2010 Tuesday:: Layout and logic modification
  //Jan 26, 2010 Tuesday:: Add statistic information on the Layout
  //Feb 04, 2010 Thursday:: Minor modification on typo
  //June 01, 2010 Tuesday:: Debug
  // ./ current directory
  // ../ up level directory

  include('template0.php');
  
  //customized setup
  //Configuration of POST and GET Variables
  //$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "Variable id is :: ".$id."<br>\n";
  //Configuration of POST and GET Variables
  //Configuration of POST and GET Variables
  $taxon_lv = htmlspecialchars($_GET['lv'],ENT_QUOTES);
  //echo "Variable taxon_lv is :: ".$lv."<br>\n";
  $taxon_id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "Variable taxon_id is :: ".$id."<br>\n";
  $taxon_state = htmlspecialchars($_GET['state'],ENT_QUOTES);
  //echo "Variable taxon_state is :: ".$state."<br>\n";
  $from = htmlspecialchars($_GET['from'],ENT_QUOTES);
  //echo "Variable from is :: ".$from."<br>\n";
  //the default layout of this page would be restricted for the state == 0 //under review 
  //  
  //Configuration of POST and GET Variables
  $taxon_name = taxon_name($taxon_lv, $taxon_id); 

  $state_clause = "";
  if( $taxon_state == "" ){
    $state_clause = "AND pstate ='0'";   ;
  }elseif( $taxon_state == "all" ) {
    $state_clause = "";
  }else{
    $state_clause = "AND pstate ='".$taxon_state."'";
  }        
  $caption = $application_caption;
  $caption = "View All proposed changes on this taxon: <BR>";
  $caption .= " Or Proposed Changes or Suggested Name Changes List on:<BR>";
  $caption .= $taxon_name;

  //customized setup  

  include('template1.php');

?>

		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
		<script type="text/javascript" src="jquery/jquery-1.3.2.js"></script>
		<script type="text/javascript" src="jquery/jquery.doubleSelect.js"></script>
		<script type="text/JavaScript">
        $(document).ready(function(){
		      //alert("Hello Elvis!");
          $("#selectRows").click(function(){
		        //alert("Select Rows is :: " + );
          });
        });
    </script>
        <?php echo "<h2>".$caption."</h2><br>\n"; ?>
        <?php
          //echo curPageURL2()."<br>\n";
          //echo $_SERVER["REQUEST_URI"]."<br>\n";
          
          $temp = "";
          if( $from != ""){
            $temp = "from=".$from."&";  
          }
          
          $other_view_option = "<a href=\"".curPageURL2()."?".$temp."lv=".$taxon_lv."&id=".$taxon_id."&state=all\">View All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          $other_view_option .= "<a href=\"".curPageURL2()."?".$temp."lv=".$taxon_lv."&id=".$taxon_id."&state=1\">View Current Accepted</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          $other_view_option .= "<a href=\"".curPageURL2()."?".$temp."lv=".$taxon_lv."&id=".$taxon_id."&state=2\">View Older Accepted</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          $other_view_option .= "<a href=\"".curPageURL2()."?".$temp."lv=".$taxon_lv."&id=".$taxon_id."&state=3\">View Rejected</a>";
          
          
          echo $other_view_option."<br>\n";
                   
          $sql_slist_table = "SELECT * FROM post WHERE preflv='".$taxon_lv."' AND prefsid='".$taxon_id."' ".$state_clause;
          //echo "sql_slist_table is ".$sql_slist_table."<br>\n";
          
          $result_sql_slist_table = mysql_query($sql_slist_table);
          if(mysql_num_rows($result_sql_slist_table) > 0){
            //echo "<table border=\"1\">\n";
            echo "<table>\n";
            echo "<tr>\n";
            echo "<td>Title</td>\n";
            //echo "<td>Statistic Information</td>\n";
            echo "<td>Date</td>\n";
            echo "<td>Poster</td>\n";
            echo "<td>Type</td>\n";
            echo "<td>State</td>\n";
            echo "<td>Expiration</td>\n";
            echo "<td align=\"right\">General Comments</td>\n";
            echo "<td align=\"right\">Review Opinions</td>\n";
            echo "<td align=\"right\">Recommended Decisions</td>\n";
            //echo "<td>View Detail</td>\n";
            echo "</tr>\n";
            
            while ( $nb = mysql_fetch_array($result_sql_slist_table) ) {
              echo "<tr>\n";
              
              $comments = 0;
              $review_opinions = 0;
              $recommended_decisions = 0;
              $sql_comments_statistic = "SELECT * FROM comment WHERE crefpid ='".$nb[0]."'";
              //echo "Variable sql_comments_statistic is :: ".$sql_comments_statistic."<br>\n";
              $result_sql_comments_statistic = mysql_query($sql_comments_statistic);
              if(mysql_num_rows($result_sql_comments_statistic) > 0){
                while ( $nb_sql_comments_statistic = mysql_fetch_array($result_sql_comments_statistic) ) {
                  $comment_type = $nb_sql_comments_statistic[6];
                  if( $comment_type == "0" ){
                    $comments++;
                  }elseif( $comment_type == "1" ){
                    $review_opinions++;
                  }elseif( $comment_type == "2" ){
                    $recommended_decisions++;
                  }
                }
              }
              
              echo "<td><a href=\"viewpost.php?pid=".$nb[0]."\">".$nb[1]."</a></td>\n";//Title
              //echo "<td>Comments: ".$comments.", Review Opinions: ".$review_opinions.", Recommended Decisions: ".$recommended_decisions."</td>\n";//Statistic Information
              //echo "<td>".$nb[1]."</td>";//Title
              echo "<td>".substr($nb[3], 0, 10)."</td>";//Post Date
              $sql_user = "SELECT * FROM user WHERE uid='".$nb[4]."'";   
              //echo "sql_user is ".$sql_user."<br>\n";
              $result_sql_user = mysql_query($sql_user);
              if(mysql_num_rows($result_sql_user) > 0){
                while ( $nb_sql_user = mysql_fetch_array($result_sql_user) ) {              
                  //echo "<td>".$nb[4]."</td>";
                  echo "<td><a href=\"viewUserProfile.php?uid=".$nb_sql_user[0]."\">".$nb_sql_user[3]."</a></td>\n";//Poster
                }
              }
              echo "<td>".$nb[7]."</td>\n";//Type
              $state = "";
              if( $nb[11] == "0"){
                $state = "Under Review";
              }elseif( $nb[11] == "1"){
                $state = "Current Accepted";
              }elseif( $nb[11] == "2"){
                $state = "Old Accepted";
              }elseif( $nb[11] == "3"){
                $state = "Rejected";
              }
              //echo "<td>".$nb[11]."</td>\n";//State
              echo "<td>".$state."</td>\n";//State
              echo "<td>".$nb[12]."</td>\n";//Expiration
              echo "<td align=\"right\">".$comments."</td>\n";//General Comments
              echo "<td align=\"right\">".$review_opinions."</td>\n";//Review Opinions
              echo "<td align=\"right\">".$recommended_decisions."</td>\n";//Recommended Decisions
              //echo "<td><a href=\"viewpost.php?pid=".$nb[0]."\">Go</a></td>\n";//View detail
              //echo "<td>".$nb[7]."</td>";
              //echo "<td>".$nb[8]."</td>";
              //echo "<td>".$nb[2]."</td><td>".$nb[3]."</td>";
              echo "</tr>\n";
            }
            
            echo "</table>\n";
          }else{
            echo "There is no post data in this query!<br>\n";
          }
          
          echo "<br>\n";
          echo "<br>\n";
          if( $from != ""){
            $sql_cid = "SELECT * FROM committee_account WHERE level='".$taxon_lv."' AND account_id='".$taxon_id."'";
            //echo "sql_cid is ".$sql_cid."<br>\n";
            $result_cid = mysql_query($sql_cid);
            if(mysql_num_rows($result_cid) > 0){
              while ( $nb_cid = mysql_fetch_array($result_cid) ) {
                $cid = $nb_cid[3];
              }
            }
            echo "<a href=\"view_completelist_post.php?cid=".$cid."\">Back to Complete List of Proposed Nomenclature Changes on this specific Committee</a><br>\n";
          }
          
        ?>

<?php
  include('template2.php'); 
?>



