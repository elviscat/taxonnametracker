<?php
  //Developed by elviscat (elviscat@gmail.com)
  //May 25, 2010 Tuesday:: View all posts data
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
  $caption = "View All Changes: <BR>";

  $sql = "SELECT * FROM namelist_chglog ORDER BY id DESC";

  if( $view_date != "" ){
    //find_last_six_months, $sql_find_last_six_months = "SELECT * FROM post WHERE pcredate > '".$view_date."' AND pstate='0'";
    $sql = "SELECT * FROM namelist_chglog WHERE chgdate > '".substr($view_date, 0, 10)."' ORDER BY id DESC";
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
            echo "<td>On this taxon</td>\n";
            echo "<td>Refer change proposal</td>\n";
            echo "<td>Change Note</td>\n";
            echo "<td>Change Reason</td>\n";
            echo "<td>Final Decision</td>\n";
            echo "<td>Change Date and Time</td>\n";

            //echo "<td>View Detail</td>\n";
            echo "</tr>\n";
            
            while ( $nb_sql = mysql_fetch_array($result_sql) ) {
              echo "<tr>\n";
              
              $lv = $nb_sql[1];
              $id = $nb_sql[2];
              $taxon_name = taxon_name_with_level($lv, $id); 
              $pid = $nb_sql[3];
              $post_title = post_title($pid); 
              
              echo "<td><a href=\"viewtaxon.php?lv=".$nb_sql[1]."&id=".$nb_sql[2]."\">".$taxon_name."</a></td>\n";//On this taxon
              echo "<td><a href=\"viewpost.php?pid=".$nb_sql[3]."\">".$post_title."</a></td>\n";//Refer change proposal
              echo "<td>".$nb_sql[4]."</td>\n";//Change Note
              echo "<td>".$nb_sql[5]."</td>\n";//Change Reason
              echo "<td>".$nb_sql[6]."</td>\n";//Final Decision
              echo "<td>".$nb_sql[7].$nb_sql[8]."</td>\n";//Change Date and Time

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



