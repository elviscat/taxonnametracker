<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 12, 2009 Thursday:: View all proposed changes
  //Jan 05, 2010 Tuesday:: Layout modification
  //Jan 11, 2010 Monday: Layout modification
  //Jan 14, 2010 Thursday: Layout and logic modification
  //Jan 19, 2010 Tuesday: Layout and logic modification
  //Jan 26, 2010 Tuesday: Add statistic information on the Layout
  //Feb 04, 2010 Thursday: Minor modification on typo
  // ./ current directory
  // ../ up level directory
  
  //header("Cache-control: private");
  //session_cache_limiter("none");
  //session_start();
  
  //if(!isset($_SESSION['rows_of_per_page'])){
  //  $_SESSION['rows_of_per_page'] = 10;
  //}

  //template
  session_start();
  include('template/dbsetup.php'); 
  require('inc/config.inc.php');
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);  

  //Configuration of POST and GET Variables
  $lv = htmlspecialchars($_GET['lv'],ENT_QUOTES);
  //echo "Variable lv is :: ".$lv."<br>\n";
  $id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "Variable id is :: ".$id."<br>\n";
  $state = htmlspecialchars($_GET['state'],ENT_QUOTES);
  //echo "Variable state is :: ".$state."<br>\n";
  //the default layout of this page would be restricted for the state == 0 //under review 
  //  
  //Configuration of POST and GET Variables
  $taxon_name = taxon_name($lv, $id); 

  $state_clause = "";
  if( $state == "" ){
    $state_clause = "AND pstate ='0'";   ;
  }elseif( $state == "all" ) {
    $state_clause = "";
  }else{
    $state_clause = "AND pstate ='".$state."'";
  }
    
  $caption = $application_caption;
  $caption2 = "View All proposed changes on this taxon: <BR>";
  $caption2 .= " Or Proposed Changes or Suggested Name Changes List on:<BR>";
  $caption2 .= $taxon_name;
  $title = $caption."::".$caption2;
  //template 


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
    <meta name="Description" content="Saint Louis University, tissue, species information" />
    <meta name="Keywords" content="Saint Louis University, tissue, information" />
    <!--<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="Distribution" content="Global" />
    <meta name="Author" content="Richard Mayden - cypriniformes@gmail.com, Elvis Hsin-Hui Wu - hwu5@slu.edu" />
    <meta name="Robots" content="index,follow" />
    <link rel="stylesheet" href="edit.css" type="text/css" /><!--Does this file edit.css should be keep?-->	
    <!--<link rel="shortcut icon" type="image/ico" href="http://www.sprymedia.co.uk/media/images/favicon.ico" />-->
		<title><? echo $title; ?></title>
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
	</head>
  <body id="dt_example">
		<div id="container">	
			<h1><? echo $caption; ?></h1>
      <?php
        include("menu.php");
      ?>
      <h2><?php echo $caption2; ?></h2>
      <div id="demo">
        <?php
          
          //echo curPageURL2()."<br>\n";
          //echo $_SERVER["REQUEST_URI"]."<br>\n";
          $other_view_option = "<a href=\"".curPageURL2()."&state=all\">View All</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          $other_view_option .= "<a href=\"".curPageURL2()."&state=1\">View Current Accepted</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          $other_view_option .= "<a href=\"".curPageURL2()."&state=2\">View Older Accepted</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          $other_view_option .= "<a href=\"".curPageURL2()."&state=3\">View Rejected</a>";
          echo $other_view_option."<br>\n";
          
          $sql_slist_table = "SELECT * FROM post WHERE preflv='".$lv."' AND prefsid='".$id."'".$state_clause;
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
        ?>
      </div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
  </body>
</html>