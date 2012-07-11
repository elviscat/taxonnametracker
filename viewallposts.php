<?php
  //Developed by elviscat (elviscat@gmail.com)
  //May 25, 2010 Tuesday:: View all posts data
  //February 25, 2011 Friday:: Code change
  // ./ current directory
  // ../ up level directory

  include('template0.php');
  
  //customized setup
  
  //Configuration of POST and GET Variables

  $view_date = htmlspecialchars($_GET['view_date'],ENT_QUOTES);
  //echo "Variable lv is view_date:: ".$view_date."<br>\n";

  //Configuration of POST and GET Variables
  
  
  /*
  !?!?
  $taxon_name = taxon_name($lv, $id); 

  $state_clause = "";
  if( $state == "" ){
    $state_clause = "AND pstate ='0'";   ;
  }elseif( $state == "all" ) {
    $state_clause = "";
  }else{
    $state_clause = "AND pstate ='".$state."'";
  }        
  !?!?
  */
  $caption = "View All Posts: <BR>";

  //$sql = "SELECT * FROM post WHERE pstate='0' ORDER BY pcredate DESC";
  $sql = "SELECT * FROM post ORDER BY pcredate DESC";

  if( $view_date != "" ){
    //find_last_six_months, $sql_find_last_six_months = "SELECT * FROM post WHERE pcredate > '".$view_date."' AND pstate='0'";
    $sql = "SELECT * FROM post WHERE pcredate > '".$view_date."' ORDER BY pcredate DESC";
    $caption = "View All Posts (< 6 mo): <BR>";
  }
  
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
          //echo "sql is ".$sql."<br>\n";
          $result_sql = mysql_query($sql);
          if(mysql_num_rows($result_sql) > 0){
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
            
            while ( $nb_sql = mysql_fetch_array($result_sql) ) {
              echo "<tr>\n";
              
              $comments = 0;
              $review_opinions = 0;
              $recommended_decisions = 0;
              $sql_comments_statistic = "SELECT * FROM comment WHERE crefpid ='".$nb_sql[0]."'";
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
              
              echo "<td><a href=\"viewpost.php?pid=".$nb_sql[0]."\">".$nb_sql[1]."</a></td>\n";//Title
              //echo "<td>Comments: ".$comments.", Review Opinions: ".$review_opinions.", Recommended Decisions: ".$recommended_decisions."</td>\n";//Statistic Information
              //echo "<td>".$nb_sql[1]."</td>";//Title
              echo "<td>".substr($nb_sql[3], 0, 10)."</td>";//Post Date
              $sql_user = "SELECT * FROM user WHERE uid='".$nb_sql[4]."'";   
              //echo "sql_user is ".$sql_user."<br>\n";
              $result_sql_user = mysql_query($sql_user);
              if(mysql_num_rows($result_sql_user) > 0){
                while ( $nb_sql_user = mysql_fetch_array($result_sql_user) ) {              
                  //echo "<td>".$nb_sql[4]."</td>";
                  echo "<td><a href=\"viewUserProfile.php?uid=".$nb_sql_user[0]."\">".$nb_sql_user[3]."</a></td>\n";//Poster
                }
              }
              echo "<td>".$nb_sql[7]."</td>\n";//Type

              echo "<td>".$nb_sql[11]."</td>\n";//State

              echo "<td>".$nb_sql[12]."</td>\n";//Expiration
              echo "<td align=\"right\">".$comments."</td>\n";//General Comments
              echo "<td align=\"right\">".$review_opinions."</td>\n";//Review Opinions
              echo "<td align=\"right\">".$recommended_decisions."</td>\n";//Recommended Decisions
              //echo "<td><a href=\"viewpost.php?pid=".$nb_sql[0]."\">Go</a></td>\n";//View detail
              //echo "<td>".$nb_sql[7]."</td>";
              //echo "<td>".$nb_sql[8]."</td>";
              //echo "<td>".$nb_sql[2]."</td><td>".$nb_sql[3]."</td>";
              echo "</tr>\n";
            }
            
            echo "</table>\n";
          }else{
            echo "There is no post data in this query!<br>\n";
          }
        ?>

<?php
  include('template2.php'); 
?>



