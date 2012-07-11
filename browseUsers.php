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
  //echo "\$cur_page is :: ".$cur_page."<br>\n";
  
  include('template/dbsetup.php');
  
  
  
  

  include('template0.php');
    
  //customized setup
  //Configuration of POST and GET Variables
  
  //$pid = htmlspecialchars($_GET['pid'],ENT_QUOTES);
  //echo "\$pid  is <b>".$pid."</b><br>\n";
  $view_date = htmlspecialchars($_GET['view_date'],ENT_QUOTES);
  //echo "\$view_date  is <b>".$view_date."</b><br>\n";  

  //Configuration of POST and GET Variables
    
  $caption = "Browse User Information";
  
  //customized setup
  
  $target_page = "browseUsers.php";
  
  include('template1.php');
?>
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
  <?php echo "<h3>".$caption."</h3><br>\n"; ?>
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
          $table_name = "user";
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
          $sql_slist_table_counts = "SELECT COUNT(*) FROM ".$table_name;
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
          
          $sql_table = "SELECT * FROM ".$table_name." LIMIT ".$start.",".$rows;
          //echo "sql_table is ".$sql_table."/n<br>";
          $result_sql_table = mysql_query($sql_table);
          if(mysql_num_rows($result_sql_table) > 0){
            echo "<table border=\"1\">\n";
            echo "<tr><td>ID</td><td>Name</td><td>Address</td><td>Email</td><td>Detail</td>";
            while ( $nb = mysql_fetch_array($result_sql_table) ) {
              echo "<tr><td>".$nb[0]."</td><td>".$nb[3]."</td><td>".$nb[4]."</td><td>".$nb[7]."</td>";
              echo "<td><a href=\"viewUserProfile.php?uid=".$nb[0]."\">View</a></td>";
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
        echo "<br /><br /><a href=\"admin.php\">Back to Admin</a><BR>\n";
        ?>



<?php
  include('template2.php'); 
?>
 






