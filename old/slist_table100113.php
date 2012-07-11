<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 07, 2009 Saturday:: slist table page
  //Nov 11, 2009 Wednesday:: 2nd version
  //Dec 15, 2009 Tuesday:: Modification for dynamic table selection and page navigation
  //Jan 13, 2010 Wednesday:: Modification for "edit" column link from causal editing to resticted editing situation which is marked as "post state == "0"  
  // ./ current directory
  // ../ up level directory
  header("Cache-control: private");
  session_cache_limiter("none");
  session_start();
  /*
  //old code
  if(!isset($_SESSION['rows_of_per_page'])){
    $_SESSION['rows_of_per_page'] = 10;
  } 
  $pages = htmlspecialchars($_GET['pages'],ENT_QUOTES);
  //echo "Variable pages is :: ".$pages."<br>\n";
  //old code
  */
  if(!isset($_SESSION['rows_of_per_page'])){
    $_SESSION['rows_of_per_page'] = 10;
  }
  $cur_page = htmlspecialchars($_GET['cur_page'],ENT_QUOTES);
  //echo "Variable cur_page is :: ".$cur_page."<br>\n";
  
  include('template/dbsetup.php');
  
  //Restrict admin to access to this page
  //Ã¤Â½Â Ã¥Â¥Â½
  
  $caption = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes";
  $caption2 = "Species name list table";  
  $title = $caption."::".$caption2;
  $content = "Species name list table.";
  
  //$users = htmlspecialchars($_POST['users'],ENT_QUOTES);
  //echo "users is :: ".$users."<br>\n";
  
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  $target_page = "slist_table.php";

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
    <meta name="Description" content="Saint Louis University, tissue, species information" />
    <meta name="Keywords" content="Saint Louis University, tissue, information" />
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <!--<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />-->
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
        <form id="form" action="change_table_name.php" method="post">
          <input id="target_page" name="target_page" type="hidden" value="<?php echo $target_page; ?>"/>
          <table>
            <tr>
              <td colspan=2>
                Go to another taxon level:<BR>
                <select id="table_name" name="table_name">
                  <option value="Family">Family</option>
                  <option value="Genus">Genus</option>
                  <option value="Species">Species</option>
                </select>
              </td>
            </tr>
            <tr>
              <td colspan=2><input type="submit" value="Go to this level" /></td>
            </tr>                        
          </table>
        </form>
        
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
        <!--Page Navigation Template Start!-->
        <?php
          $table_name = htmlspecialchars($_SESSION['table_name'],ENT_QUOTES);
          //echo "Variable table_name is :: ".$table_name."<br>\n";
          if( $table_name == "" ){
          //if( !isset( htmlspecialchars($_GET['table'],ENT_QUOTES) ) ){
            echo "You need specifiy a table!";
          }else{
            $sql_table_name = "";
            if( $table_name == "Family"){
              $sql_table_name = "flist";
            }elseif( $table_name == "Genus" ){
              $sql_table_name = "glist";
            }elseif( $table_name == "Species" ){
              $sql_table_name = "slist";
            }

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
            $sql_slist_table_counts = "SELECT COUNT(*) FROM ".$sql_table_name;
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

            /*
            //old code
            $rows = $_SESSION['rows_of_per_page'];
            //echo "Variable pages is :: ".$pages."<br>\n";
            $start = "";
            if($pages == ""){
              //echo "No Variable pages!<br>\n";
              $pages = 1;
              $start = 0;
            }else{
              //echo "The Variable pages exists!<br>\n";
              //echo "variable pages is :: ".$pages."<br>\n";
              $start = ($pages-1)*$rows;
            }
            
            $sql_table_name = "";
            if( $table_name == "Family"){
              $sql_table_name = "flist";
            }elseif( $table_name == "Genus" ){
              $sql_table_name = "glist";
            }elseif( $table_name == "Species" ){
              $sql_table_name = "slist";
            }
            
            $counts = "";
            $sql_slist_table_counts = "SELECT COUNT(*) FROM ".$sql_table_name;
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
            //old code
            */
            
            
            /*Customize the table*/
            $sql_slist_table = "SELECT * FROM ".$sql_table_name." LIMIT ".$start.",".$rows;   
            //echo "sql_slist_table is ".$sql_slist_table."/n<br>";
            $result_sql_slist_table = mysql_query($sql_slist_table);
            if(mysql_num_rows($result_sql_slist_table) > 0){              
              echo "<table border=\"1\">\n";
              
              if( $table_name == "Family"){
                $caption = "<tr>";
                $caption .= "<td>ID</td>";
                $caption .= "<td>Kingdon</td>";
                $caption .= "<td>Phylum</td>";
                $caption .= "<td>Superclass</td>";
                $caption .= "<td>Class</td>";
                $caption .= "<td>Subclass</td>";
                $caption .= "<td>Infraclass</td>";
                $caption .= "<td>Superorder</td>";
                $caption .= "<td>Order</td>";
                $caption .= "<td>Suboder</td>";
                $caption .= "<td>Superfamily</td>";
                $caption .= "<td>Family</td>";
                $caption .= "<td>Common name 1</td>";
                $caption .= "<td>Common name 2</td>";
                $caption .= "<td>Common name 3</td>";   
                //$table_content = "<tr><td>".$nb[0]."</td><td>".$nb[1]."</td><td>".$nb[2]."</td>";
                $taxon_level = "family";
                //$sql_table_name = "flist";
              }elseif( $table_name == "Genus" ){
                $caption = "<tr><td>ID</td><td>Family</td><td>Genus</td>";   
                //$table_content = "<tr><td>".$nb[0]."</td><td>".$nb[1]."</td><td>".$nb[2]."</td>";
                $taxon_level = "genus";                
                //$sql_table_name = "glist";
              }elseif( $table_name == "Species" ){
                $caption = "<tr><td>ID</td><td>Family</td><td>Genus</td><td>Species</td><td>Author</td><td>Locality</td><td>Common Name1</td><td>Common Name2</td><td>Common Name3</td>";   
                //$table_content = "<tr><td>".$nb[0]."</td><td>".$nb[1]."</td><td>".$nb[2]."</td><td>".$nb[3]."</td><td>".$nb[4]."</td><td>".$nb[5]."</td><td>".$nb[6]."</td><td>".$nb[7]."</td><td>".$nb[8]."</td>";
                $taxon_level = "species";
                //$sql_table_name = "slist";
              }

              
              
              //echo "<tr><td>ID</td><td>Family</td><td>Genus</td><td>Species</td><td>Author</td><td>Locality</td><td>Common Name1</td><td>Common Name2</td><td>Common Name3</td>";
              echo $caption."<BR>\n";
              echo "<td>View All Proposed Changes</td><td>View All Change Log</td><td>Edit</td><td>Turn on/Turn off</td></tr>\n";
              while ( $nb = mysql_fetch_array($result_sql_slist_table) ) {

                if( $table_name == "Family"){
                  //$caption = "<tr><td>ID</td><td>Kingdon</td><td>Phylum</td><td>Species</td>";   
                  $table_content = "<tr>";
                  $table_content .= "<td>".$nb[0]."</td>";
                  $table_content .= "<td>".$nb[1]."</td>";
                  $table_content .= "<td>".$nb[2]."</td>";
                  $table_content .= "<td>".$nb[3]."</td>";
                  $table_content .= "<td>".$nb[4]."</td>";
                  $table_content .= "<td>".$nb[5]."</td>";
                  $table_content .= "<td>".$nb[6]."</td>";
                  $table_content .= "<td>".$nb[7]."</td>";
                  $table_content .= "<td>".$nb[8]."</td>";
                  $table_content .= "<td>".$nb[9]."</td>";
                  $table_content .= "<td>".$nb[10]."</td>";
                  $table_content .= "<td>".$nb[11]."</td>";
                  $table_content .= "<td>".$nb[12]."</td>";
                  $table_content .= "<td>".$nb[13]."</td>";
                  $table_content .= "<td>".$nb[14]."</td>";
                  //$taxon_level = "species";
                  //$sql_table_name = "flist";
                }elseif( $table_name == "Genus" ){
                  //$caption = "<tr><td>ID</td><td>Family</td><td>Genus</td>";   
                  $table_content = "<tr><td>".$nb[0]."</td><td>".$nb[1]."</td><td>".$nb[2]."</td>";
                  //$taxon_level = "species";                
                  //$sql_table_name = "glist";
                }elseif( $table_name == "Species" ){
                  //$caption = "<tr><td>ID</td><td>Family</td><td>Genus</td><td>Species</td><td>Author</td><td>Locality</td><td>Common Name1</td><td>Common Name2</td><td>Common Name3</td>";   
                  $table_content = "<tr><td>".$nb[0]."</td><td>".$nb[1]."</td><td>".$nb[2]."</td><td>".$nb[3]."</td><td>".$nb[4]."</td><td>".$nb[5]."</td><td>".$nb[6]."</td><td>".$nb[7]."</td><td>".$nb[8]."</td>";
                  //$taxon_level = "species";
                  //$sql_table_name = "slist";
                }
                
                echo $table_content."\n";
                //echo "<tr><td>".$nb[0]."</td><td>".$nb[1]."</td><td>".$nb[2]."</td><td>".$nb[3]."</td><td>".$nb[4]."</td><td>".$nb[5]."</td><td>".$nb[6]."</td><td>".$nb[7]."</td><td>".$nb[8]."</td>";
                
                //count the times of the posted proposed change
                $post_counter = "";
                $sql_count_post = "SELECT COUNT(*) FROM post WHERE preflv = '".$taxon_level."' AND prefsid= ".$nb[0];
                //echo $sql_count_post;
                $result_sql_count_post = mysql_query($sql_count_post);
                if(mysql_num_rows($result_sql_count_post) > 0){
                  while ( $nb3 = mysql_fetch_array($result_sql_count_post) ) {
                    $post_counter = $nb3[0];
                  }
                }
                echo "<td>".$post_counter."&nbsp<a href=\"viewapc.php?lv=".$taxon_level."&id=".$nb[0]."\">View</a></td>";
                //count the times of change log
                $chglog_counter = "";
                $sql_count_chglog = "SELECT COUNT(*) FROM namelist_chglog WHERE reflv = '".$taxon_level."' AND refid= ".$nb[0];
                //echo $sql_count_chglog;
                $result_sql_count_chglog = mysql_query($sql_count_chglog);
                if(mysql_num_rows($result_sql_count_chglog) > 0){
                  while ( $nb4 = mysql_fetch_array($result_sql_count_chglog) ) {
                    $chglog_counter = $nb4[0];
                  }
                }
                echo "<td>".$chglog_counter."&nbsp<a href=\"viewclog.php?lv=".$taxon_level."&id=".$nb[0]."\">View</a></td>";
              
                echo "<td><a href=\"slist_chg.php?lv=".$taxon_level."&id=".$nb[0]."\">Edit</a></td>";
              
                $state = "";
                $state_int = "1";
                if( $nb[9] == "0"){
                  $state = "Turn Off";
                  $state_int = "0";
                }else{
              	  $state = "Turn On";
                }
                echo "<td><a href=\"slist_state_turn.php?lv=".$taxon_level."&id=".$nb[0]."\">".$state."</a></td>";
                //echo "<td>".$nb[2]."</td><td>".$nb[3]."</td>";
                echo "</tr>\n";
              }
              echo "</table>\n";
            }
            /*Customize the table*/
            
            /*Page Navigation Module*/
            //echo "cur_page is :: ".$cur_page."<br>\n";
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

            /*
            //old code
            
            $current_page = "";
            if($pages == ""){
              $current_page = 1;
            }else{
              $current_page = $pages;
            }
          
            if( $current_apge > 1 ){
              echo "Your current page is :: ".$current_page."<br>\n";
            }
          
            echo "<a href=\"slist_table.php?pages=1\">Go to first page</a> ";
          
          
            for($i = $pages; $i< ($pages+5); $i++){
              $page = $i+1;
              if( $page <= $pages_link){
                echo "<a href=\"slist_table.php?pages=".$page."\">".$page."</a> ";
              }
            }         
            if( $current_page < $pages_link){
              echo "<a href=\"slist_table.php?pages=".($current_page+1)."\">Next Page</a> ";
            }
          
            echo "<a href=\"slist_table.php?pages=".$pages_link."\">Go to last page</a> ";
            //old code
            */            
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