<?php
  //Developed by elviscat (elviscat@gmail.com)
  //June 04, 2010 Friday:: New:: View Pending Proposals List
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
  $caption = "View Pending Proposals: <BR>";

  $sql = "SELECT * FROM post WHERE pstate = 0 ORDER BY pid DESC";

  if( $view_date != "" ){
    //find_last_six_months, $sql_find_last_six_months = "SELECT * FROM post WHERE pcredate > '".$view_date."' AND pstate='0'";
    $sql = "SELECT * FROM post WHERE pcredate > '".substr($view_date, 0, 10)."' AND pstate = 0 ORDER BY pid DESC";
    $caption = "View Pending Proposals: (< 6 mo): <BR>";
    
  }
  
  //echo "Variable sql is <b>".$sql."</b><br>\n";
  
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
            echo "<table>\n";
            //echo "<table border=\"1\">\n";
            //echo "<table border=\"1\" frame=\"below\">\n";
            //echo "<tr border=\"1\" frame=\"below\">\n";
            echo "<tr>\n";
            echo "<td>Taxon</td>\n";
            echo "<td>Nomenclature Issue</td>\n";
            echo "<td>Original Posting Date</td>\n";
            echo "<td>Posted By</td>\n";
            echo "<td>Discussion On Topic</td>\n";
            echo "<td>Nomenclature Committee</td>\n";
            echo "<td>Status</td>\n";

            //echo "<td>View Detail</td>\n";
            echo "</tr>\n";
            
            while ( $nb_sql = mysql_fetch_array($result_sql) ) {
              echo "<tr>\n";
              $pid = $nb_sql[0];
              $taxon_lv = $nb_sql[5];
              $taxon_id = $nb_sql[6];
              $taxon_name = taxon_name_with_level($taxon_lv, $taxon_id); 
              
              $post_title = $nb_sql[1]; 
              $post_date = post_date($pid);
              $poster_uid = post_uid($pid);
              //echo "Variable poster_uid is <b>".$poster_uid."</b><br>\n";
              $poster_name = poster_name($poster_uid);
              $ref_c_id = get_ref_c_id_from_pid($pid);
              
              $status = "";
              if( $nb_sql[11] == "0" ){
                $status = "Under Reivew";
              }elseif( $nb_sql[11] == "1" ){
                $status = "Current Accepted";
              }elseif( $nb_sql[11] == "2" ){
                $status = "Old Accepted";
              }elseif( $nb_sql[11] == "3" ){
                $status = "Rejected";
              }
              
              echo "<td><a href=\"viewtaxon.php?lv=".$nb_sql[5]."&id=".$nb_sql[6]."\">".$taxon_name."</a></td>\n";//Taxon
              echo "<td><a href=\"viewpost.php?pid=".$nb_sql[0]."\">".$post_title."</a></td>\n";//Refer change proposal == Nomenclature Issue
              echo "<td>".substr($post_date, 0, 10)."</td>\n";//Original Posting Date
              echo "<td><a href=\"viewUserProfile.php?uid=".$poster_uid."\">".$poster_name."</a></td>\n";//Posted By
              
              echo "<td><a href=\"viewcommentlist.php?pid=".$pid."\">Select Here</a></td>\n";//Discussion On Topic
              
              if( $ref_c_id == ""){
                echo "<td>No Names Committee</td>\n";//Nomenclature Committee
              }else{
                echo "<td><a href=\"view_committee.php?id=".$ref_c_id."\">Select Here</a></td>\n";//Nomenclature Committee
              }
              
              echo "<td>".$status."</a></td>\n";//Status
              
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



