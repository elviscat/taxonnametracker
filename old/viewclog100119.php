<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 13, 2009 Friday:: View all change log
  // ./ current directory
  // ../ up level directory
  header("Cache-control: private");
  session_cache_limiter("none");
  session_start();
  if(!isset($_SESSION['rows_of_per_page'])){
    $_SESSION['rows_of_per_page'] = 10;
  }
  
  
  $pages = htmlspecialchars($_GET['pages'],ENT_QUOTES);
  //echo "Variable pages is :: ".$pages."<br>\n";
  
  include('template/dbsetup.php');
  
  //Restrict admin to access to this page
  //ÃƒÆ’Ã‚Â¤Ãƒâ€šÃ‚Â½Ãƒâ€šÃ‚Â ÃƒÆ’Ã‚Â¥Ãƒâ€šÃ‚Â¥Ãƒâ€šÃ‚Â½
  
  $caption = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes";
  $caption2 = "View All proposed changes";  
  $title = $caption."::".$caption2;
  $content = "View all proposed changes.";
  
  $lv = htmlspecialchars($_GET['lv'],ENT_QUOTES);
  //echo "Level is :: ".$users."<br>\n";
  $id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "ID is :: ".$."<br>\n";

  
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);


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
        <form id="form" action="viewapc_change_view_rows.php" method="post">
          <table>
            <tr>
              <td colspan=2>
                <select id="rows_of_table" name="rows_of_table">
                  <option value="20">20</option>
                  <option value="50">50</option>
                  <option value="100">100</option>
                  <option value="200">200</option>
                </select>
              </td>
            </tr>
            <tr>
              <td colspan=2><input type="submit" value="Change" /></td>
            </tr>                        
          </table>
        </form>
        <br>
        <br>
        <?php
          $rows = $_SESSION['rows_of_per_page'];
          //echo "Variable pages is :: ".$pages."<br>\n";
          $start = "";
          if($pages == ""){
            //echo "No Variable pages!<br>\n";
            //$pages = 0;
            $start = 0;
          }else{
            //echo "The Variable pages exists!<br>\n";
            //echo "variable pages is :: ".$pages."<br>\n";
            $start = ($pages-1)*$rows;
          }

          $counts = "";
          $sql_slist_table_counts = "SELECT COUNT(*) FROM post WHERE preflv='".$lv."' AND prefsid=".$id;
          $result_sql_slist_table_counts = mysql_query($sql_slist_table_counts);
          if(mysql_num_rows($result_sql_slist_table_counts) > 0){
            while ( $nb2 = mysql_fetch_array($result_sql_slist_table_counts) ) {
              //echo "Counts is :: ".$nb2[0]."<br>\n";
              $counts = $nb2[0];
            }
          }
          $total = $counts;
          $pagesize = $rows;
          $pages_link = ceil($total/$pagesize);//
          
          echo "You are now in page: ".$pages."/".$pages_link."<br>\n";
          $sql_slist_table = "SELECT * FROM namelist_chglog WHERE reflv='".$lv."' AND refid=".$id." LIMIT ".$start.",".$rows;   
          //echo "sql_slist_table is ".$sql_slist_table."<br>\n";
          $result_sql_slist_table = mysql_query($sql_slist_table);
          if(mysql_num_rows($result_sql_slist_table) > 0){
            echo "<table border=\"1\">\n";
            echo "<tr><td>ID</td><td>Level</td><td>Reference of taxon data id</td><td>Reference Post Id</td><td>Reason</td><td>Change date</td><td>Change time</td>\n";
            while ( $nb = mysql_fetch_array($result_sql_slist_table) ) {
              echo "<tr><td>".$nb[0]."</td><td>".$nb[1]."</td><td>".$nb[2]."</td><td>".$nb[3]."</td><td>".$nb[4]."</td><td>".$nb[5]."</td><td>".$nb[6]."</td>";
              //echo "<td>".$nb[2]."</td><td>".$nb[3]."</td>";
              echo "</tr>\n";
            }
            echo "</table>\n";
          }

          
          $current_page = "";
          if($pages == ""){
            $current_page = 1;
          }else{
            $current_page = $pages;
          }
          
          if( $current_apge > 1 ){
            echo "Your current page is :: ".$current_page."<br>\n";
          }
          
          echo "<a href=\"viewapc.php?pages=1\">Go to first page</a> ";
          
          
          for($i = $pages; $i< ($pages+5); $i++){
            $page = $i+1;
            if( $page <= $pages_link){
              echo "<a href=\"viewapc.php?pages=".$page."\">".$page."</a> ";
            }
          }         
          if( $current_page < $pages_link){
            echo "<a href=\"viewapc.php?pages=".($current_page+1)."\">Next Page</a> ";
          }
          
          echo "<a href=\"viewapc.php?pages=".$pages_link."\">Go to last page</a> ";
          
        ?>
      </div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
  </body>
</html>