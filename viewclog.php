<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 13, 2009 Friday:: View all change log
  //Jan 26, 2010 Tuesday:: Layout and Logic modification
  // ./ current directory
  // ../ up level directory
  
  //eader("Cache-control: private");
  //session_cache_limiter("none");
  //session_start();
  //if(!isset($_SESSION['rows_of_per_page'])){
  //  $_SESSION['rows_of_per_page'] = 10;
  //}
  
  //$pages = htmlspecialchars($_GET['pages'],ENT_QUOTES);
  //echo "Variable pages is :: ".$pages."<br>\n";
  
  //include('template/dbsetup.php');
  
  //Restrict admin to access to this page
  //  
  //$caption = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes";
  //$caption2 = "View All proposed changes";
  //$title = $caption."::".$caption2;
  //$content = "View all proposed changes.";
    
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
  //echo "Level is :: ".$users."<br>\n";
  $id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "ID is :: ".$."<br>\n";
  //Configuration of POST and GET Variables
  $taxon_name = taxon_name($lv, $id); 
    
  $caption = $application_caption;
  $caption2 = "View All Change Log associated with  this taxon: <BR>".$taxon_name."<br>You can edit the change note and reason if you typo in previous decision and view its reference proposed change post entry";
  $title = $application_caption."::".$caption2;
  //template  


  
  


  


  /*Page Navigation Module*/
  if(!isset($_SESSION['rows_of_per_page'])){
    $_SESSION['rows_of_per_page'] = 10;
  }
  $cur_page = htmlspecialchars($_GET['cur_page'],ENT_QUOTES);
  //echo "Variable cur_page is :: ".$cur_page."<br>\n";
  
  //$target_page = "viewclog.php";
  $target_page = curPageURL2();
  //echo curPageURL2();
  /*Page Navigation Module*/

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
        <!--Page Navigation Template Start!-->
        
        <form id="form" action="change_view_rows.php" method="post">
          <input id="target_page" name="target_page" type="hidden" value="<?php echo $target_page; ?>"/>
          <table>
            <tr>
              <td colspan=2>
                Set rows of per page<BR>
                <select id="rows_of_table" name="rows_of_table">
                  <option value="10">10</option>
                  <option value="20">20</option>
                  <option value="50">50</option>
                  <option value="100">100</option>
                  <option value="200">200</option>
                </select>
              </td>
            </tr>
            <tr>
              <td colspan=2><input type="submit" value="Change rows" /></td>
            </tr>                        
          </table>
        </form>
        <br>
        <br>
        <!--Page Navigation Template End!-->
        <?php
          /*TABLE NAME set up module*/
          $sql_table_name = "namelist_chglog";
          //echo "Variable table_name is :: ".$table_name."<br>\n";
          $where_clause = " WHERE reflv='".$lv."' AND refid=".$id;
          //echo "Variable where_clause is :: ".$where_clause."<br>\n";
          /*TABLE NAME set up module*/          
          
          
          /*Page set up module*/
          $rows = $_SESSION['rows_of_per_page'];
          echo "You are viewing ".$rows." rows per page!<br>\n";
          //echo "Variable pages is :: ".$pages."<br>\n";
          $start = "";
          if($cur_page == ""){
            //echo "No Variable pages!<br>\n";
            $cur_page = 1;
            $start = 0;
          }else{
            //echo "The Variable pages exists!<br>\n";
            //echo "variable pages is :: ".$pages."<br>\n";
            $start = ($cur_page-1)*$rows;
          }
          $counts = "";
          $sql_slist_table_counts = "SELECT COUNT(*) FROM ".$sql_table_name.$where_clause;
          //echo "Variable sql_slist_table_counts is :: ".$sql_slist_table_counts."<br>\n";
          $result_sql_slist_table_counts = mysql_query($sql_slist_table_counts);
          if(mysql_num_rows($result_sql_slist_table_counts) > 0){
            while ( $nb2 = mysql_fetch_array($result_sql_slist_table_counts) ) {
              //echo "Counts is :: ".$nb2[0]."<br>\n";
              $counts = $nb2[0];
            }
          }
          $total = $counts;
          $pagesize = $rows;
          $page_counts = ceil($total/$pagesize);//
          echo "You are now in page: ".$cur_page."/".$page_counts."<br>\n";
          /*Page set up module*/
          
          /*Customize the table*/  
          $sql_slist_table = "SELECT * FROM ".$sql_table_name." WHERE reflv='".$lv."' AND refid=".$id." LIMIT ".$start.",".$rows;   
          //echo "sql_slist_table is ".$sql_slist_table."<br>\n";
          $result_sql_slist_table = mysql_query($sql_slist_table);
          if(mysql_num_rows($result_sql_slist_table) > 0){
            //echo "<table border=\"1\">\n";
            echo "<table>\n";
            echo "<tr>\n";
            echo "<td><b>Change Note</b></td>\n";
            echo "<td><b>Reason</b></td>\n";
            echo "<td><b>Reference Post</b></td>\n";
            echo "<td><b>Change Date and Time</b></td>\n";
            echo "<td><b>Decision</b></td>\n";
            echo "<td><b>Edit</b></td>\n";
            echo "</tr>\n";
            //echo "<tr><td>ID</td><td>Level</td><td>Reference of taxon data id</td><td>Reference Post Id</td><td>Reason</td><td>Change date</td><td>Change time</td>\n";
            while ( $nb = mysql_fetch_array($result_sql_slist_table) ) {
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
            }
            echo "</table>\n";
          }
          /*Customize the table*/
          
          /*Page Navigation Module*/
          //echo "cur_page is :: ".$cur_page."<br>\n";
          echo "<br>\n";
          echo "Page Navigation: ";
          if( $cur_page > 1 ){
            echo "<a href=\"".$target_page."?cur_page=1\" ><<</a> ";//Go to first page
            echo "<a href=\"".$target_page."?cur_page=".($cur_page-1)."\">Previous Page</a> ";
          }
          for($i = $cur_page ; $i< ($cur_page+5); $i++){
            if( $i > $page_counts ){
              break;
            }
            if($i > $cur_page){
              echo "<a href=\"".$target_page."?cur_page=".$i."\">".$i."</a> ";
            }else{
              echo $i." ";
            }
          }
          if( $cur_page < $page_counts ){
            echo "<a href=\"".$target_page."?cur_page=".($cur_page+1)."\">Next Page</a> ";
            echo "<a href=\"".$target_page."?cur_page=".$page_counts."\" >>></a> ";//Go to last page
          }
          /*Page Navigation Module*/
          
        ?>
      </div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
  </body>
</html>