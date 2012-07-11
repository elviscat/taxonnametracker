<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 19, 2009 Thursday:: default table page with page rows set up and page navigation
  // ./ current directory
  // ../ up level directory
  header("Cache-control: private");
  session_cache_limiter("none");
  session_start();
  if(!isset($_SESSION['rows_of_per_page'])){
    $_SESSION['rows_of_per_page'] = 10;
  }
  $cur_page = htmlspecialchars($_GET['cur_page'],ENT_QUOTES);
  //echo "Variable cur_page is :: ".$cur_page."<br>\n";
  
  include('template/dbsetup.php');
  
  
  //Restrict admin to access to this page
  //ÃƒÂ¤Ã‚Â½Ã‚Â ÃƒÂ¥Ã‚Â¥Ã‚Â½
  
  $role = $_SESSION['role'];
  if( $role != "user"){
    Header("location:authorizedFail.php");
    exit();
  }
  
  
  $caption = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes";
  $caption2 = "Browse User Information";  
  $title = $caption."::".$caption2;
  $content = "Browse User Information.";
  
  //$users = htmlspecialchars($_POST['users'],ENT_QUOTES);
  //echo "users is :: ".$users."<br>\n";
  
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  $target_page = "postProposedChangeManage.php";

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
              <td colspan=2><input type="submit" value="Change" /></td>
            </tr>                        
          </table>
        </form>
        
        <?php
          $table_name = "post";
          $where_clause = " WHERE prefuid = ".$_SESSION['uid']." ";
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
          $sql_slist_table_counts = "SELECT COUNT(*) FROM ".$table_name.$where_clause;
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
          
          $sql_table = "SELECT * FROM ".$table_name.$where_clause." LIMIT ".$start.",".$rows;
          //echo "sql_table is ".$sql_table."/n<br>";
          $result_sql_table = mysql_query($sql_table);
          if(mysql_num_rows($result_sql_table) > 0){
            echo "<table border=\"1\">\n";
            echo "<tr><td>ID</td><td>Title</td><td>Content</td><td>Level</td><td>Detail</td>";
            while ( $nb = mysql_fetch_array($result_sql_table) ) {
              echo "<tr><td>".$nb[0]."</td><td>".$nb[1]."</td><td>".substr($nb[2], 0, 10)."...</td><td>".$nb[5]."</td>";
              echo "<td><a href=\"viewpost.php?pid=".$nb[0]."\">View</a></td>";
              echo "</tr>\n";
            }
            echo "</table>\n";
          }
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
        ?>
      </div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
<?php
  mysql_close($link);
?>
  </body>
</html>