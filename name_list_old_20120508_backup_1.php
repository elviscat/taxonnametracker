<?php
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 07, 2009 Saturday:: slist table page
  //Nov 11, 2009 Wednesday:: 2nd version
  //April 12, 2010 Monday:: Add the template code section into
  //May 12, 2010 Wednesday:: New modification
  //May 25, 2010 Tuesday:: New modification
  //February 27, 2011 Sunday:: Code Logic modification
  //May 01, 2012 Tuesday:: Code Logic modification
  // ./ current directory
  // ../ up level directory

  include('template0.php');
    
  //customized setup
  //Configuration of POST and GET Variables
  //$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "Variable id is :: ".$id."<br>\n";
  //Configuration of POST and GET Variables
    
  $caption = "Biological Calssification Name List";
  
  //customized setup  
  include('template1.php');

  //header("Cache-control: private");
  session_cache_limiter("none");
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
  $lv = htmlspecialchars($_GET['lv'],ENT_QUOTES);
  //echo "\$lv is :: ".$lv."<br>\n";
  $name = htmlspecialchars($_GET['name'],ENT_QUOTES);
  //echo "\$name is :: ".$name."<br>\n";  
  
  $target_page = "name_list.php";

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
        <form id="form" action="change_table_name.php" method="post">
          <input id="target_page" name="target_page" type="hidden" value="<?php echo $target_page; ?>"/>
          <table>
            <tr>
              <td colspan=2>
                Select taxon level:<BR>
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
                Select number of rows of per page<BR>
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
        <?php
          $table_name = htmlspecialchars($_SESSION['table_name'],ENT_QUOTES);
          //echo "Variable table_name is :: ".$table_name."<br>\n";
          if( $table_name == "" ){
          //if( !isset( htmlspecialchars($_GET['table'],ENT_QUOTES) ) ){
            //echo "You need specifiy a table!";
          }else{
            $sql_table_name = "";
            if( $table_name == "Family"){
              $sql_table_name = "flist";
            }elseif( $table_name == "Genus" ){
              $sql_table_name = "glist";
            }elseif( $table_name == "Species" ){
              $sql_table_name = "slist";
            }

            $add_clause = "";
            if($lv != ""){
            	if($lv == "genus"){
            		$add_clause = "AND gfamily ='".$name."'";
            		$sql_table_name = "glist";
            		$table_name = "Genus";
            	}else if($lv == "species"){
            		$add_clause = "AND sgenus ='".$name."'";
            		$sql_table_name = "slist";
            		$table_name = "Species";
	            }
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
            //$sql_slist_table_counts = "SELECT COUNT(*) FROM ".$sql_table_name." ".;
            $sql_slist_table_counts = "SELECT COUNT(*) FROM ".$sql_table_name." WHERE is_valid = '1' ".$add_clause;
            //$sql_slist_table = "SELECT * FROM ".$sql_table_name." WHERE is_valid = '1' ".$add_clause." LIMIT ".$start.",".$rows;
            
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
            
            $sql_slist_table = "SELECT * FROM ".$sql_table_name." WHERE is_valid = '1' ".$add_clause." LIMIT ".$start.",".$rows;
            //echo "$sql_slist_table is ".$sql_slist_table."<br>\n";
            $result_sql_slist_table = mysql_query($sql_slist_table);
            if(mysql_num_rows($result_sql_slist_table) > 0){              
              echo "<table border=\"1\">\n";
              
              if( $table_name == "Family"){
                $caption = "<tr>";
                //$caption .= "<td>ID</td>";
                //$caption .= "<td>Kingdon</td>";
                //$caption .= "<td>Phylum</td>";
                //$caption .= "<td>Superclass</td>";
                
                //$caption .= "<td>Class</td>";
                //$caption .= "<td>Subclass</td>";
                //$caption .= "<td>Infraclass</td>";
                //$caption .= "<td>Superorder</td>";
                //$caption .= "<td>Order</td>";
                //$caption .= "<td>Suboder</td>";
                //$caption .= "<td>Superfamily</td>";
                $caption .= "<td>Family</td>";
                //$caption .= "<td>Common name 1</td>";
                ////$caption .= "<td>Common name 2</td>";
                //$caption .= "<td>Common name 3</td>";   
                //$table_content = "<tr><td>".$nb[0]."</td><td>".$nb[1]."</td><td>".$nb[2]."</td>";
                $taxon_level = "family";
                //$sql_table_name = "flist";
              }elseif( $table_name == "Genus" ){
                //$caption = "<tr><td>ID</td><br>\n";
                $caption .= "<td>Family</td>";
                $caption .= "<td>Genus</td>";   
                //$table_content = "<tr><td>".$nb[0]."</td><td>".$nb[1]."</td><td>".$nb[2]."</td>";
                $taxon_level = "genus";                
                //$sql_table_name = "glist";
              }elseif( $table_name == "Species" ){
                //$caption = "<tr><td>ID</td><br>\n";
                $caption .= "<td>Scientific Name</td>";
                $caption .= "<td>Family</td>";
                $caption .= "<td>Genus</td>";
                $caption .= "<td>Species</td>";
                $caption .= "<td>Author</td>";
                //$caption .= "<td>Locality</td>";
                //$caption .= "<td>Common Name1</td>";
                //$caption .= "<td>Common Name2</td>";
                //$caption .= "<td>Common Name3</td>";   
                //$table_content = "<tr><td>".$nb[0]."</td><td>".$nb[1]."</td><td>".$nb[2]."</td><td>".$nb[3]."</td><td>".$nb[4]."</td><td>".$nb[5]."</td><td>".$nb[6]."</td><td>".$nb[7]."</td><td>".$nb[8]."</td>";
                $taxon_level = "species";
                //$sql_table_name = "slist";
              }

              
              
              //echo "<tr><td>ID</td><td>Family</td><td>Genus</td><td>Species</td><td>Author</td><td>Locality</td><td>Common Name1</td><td>Common Name2</td><td>Common Name3</td>";
              echo $caption."<BR>\n";
              
              //http://maydenlab.slu.edu/~hwu5/jmih09/showProposedChanges.php?lv=species&id=1
              //http://maydenlab.slu.edu/~hwu5/jmih09/postProposedChanges.php?sid=1
              
              //echo "<td>View All Proposed Changes</td><td>Post Proposed Changes</td></tr>\n";//Marked on February 27, 2011 Sunday
              
              //Marked on May 01, 2012 Tuesday
              //echo "<td>View Synonyms</td><td>Post Proposed Changes</td></tr>\n";//New on February 27, 2011 Sunday
              //Marked on May 01, 2012 Tuesday
              
              while ( $nb = mysql_fetch_array($result_sql_slist_table) ) {
				$table_content = "<tr>";
                if( $table_name == "Family"){
                  //$caption = "<tr><td>ID</td><td>Kingdon</td><td>Phylum</td><td>Species</td>";   
                  
                  //$table_content .= "<td>".$nb[0]."</td>";
                  //$table_content .= "<td>".$nb[1]."</td>";
                  //$table_content .= "<td>".$nb[2]."</td>";
                  //$table_content .= "<td>".$nb[3]."</td>";
                  //$table_content .= "<td>".$nb[4]."</td>";
                  //$table_content .= "<td>".$nb[5]."</td>";
                  //$table_content .= "<td>".$nb[6]."</td>";
                  //$table_content .= "<td>".$nb[7]."</td>";
                  //$table_content .= "<td>".$nb[8]."</td>";
                  //$table_content .= "<td>".$nb[9]."</td>";
                  //$table_content .= "<td>".$nb[10]."</td>";
                  $table_content .= "<td><a href=\"name_list.php?lv=genus&name=".$nb[11]."\">".$nb[11]."</a></td>";//level: family name
                  //$table_content .= "<td>".$nb[12]."</td>";
                  //$table_content .= "<td>".$nb[13]."</td>";
                  //$table_content .= "<td>".$nb[14]."</td>";
                  //$taxon_level = "species";
                  //$sql_table_name = "flist";
                }elseif( $table_name == "Genus" ){
                  //$caption = "<tr><td>ID</td><td>Family</td><td>Genus</td>";   
                  //$table_content = "<tr><td>".$nb[0]."</td><br>\n";
                  $table_content .= "<td>".$nb[1]."</td>";
                  $table_content .= "<td><a href=\"name_list.php?lv=species&name=".$nb[2]."\">".$nb[2]."</a></td>";
                  //$taxon_level = "species";                
                  //$sql_table_name = "glist";
                }elseif( $table_name == "Species" ){
                  //$caption = "<tr><td>ID</td><td>Family</td><td>Genus</td><td>Species</td><td>Author</td><td>Locality</td><td>Common Name1</td><td>Common Name2</td><td>Common Name3</td>";   
                  //$table_content = "<tr><td>".$nb[0]."</td><br>\n";
                  $table_content .= "<td><i><a href=\"viewtaxon.php?lv=species&id=".$nb['sid']."\">".$nb['sgenus']." ".$nb['sspecies']."</a></i></td>\n";
                  $table_content .= "<td>".$nb['sfamily']."</td>";
                  $table_content .= "<td>".$nb['sgenus']."</td>";
                  $table_content .= "<td>".$nb['sspecies']."</td>";
                  $table_content .= "<td>".$nb['sauthor']."</td>";
                  //$table_content .= "<td>".$nb[5]."</td>";
                  //$table_content .= "<td>".$nb[6]."</td>";
                  //$table_content .= "<td>".$nb[7]."</td>";
                  //$table_content .= "<td>".$nb[8]."</td>";
                  //$taxon_level = "species";
                  //$sql_table_name = "slist";
                }
                $table_content .= "</tr>";
                
                echo $table_content."\n";
                //echo "<tr><td>".$nb[0]."</td><td>".$nb[1]."</td><td>".$nb[2]."</td><td>".$nb[3]."</td><td>".$nb[4]."</td><td>".$nb[5]."</td><td>".$nb[6]."</td><td>".$nb[7]."</td><td>".$nb[8]."</td>";
                
                
                //Marked on May 01, 2012 Tuesday
                /*
                //View Synonyms
                $synonyms = "";
                $sql_synonyms = "SELECT * FROM slist WHERE synonym_of = '".$nb[0]."'";
                //echo $sql_synonyms;
                $result_synonyms = mysql_query($sql_synonyms);
                if(mysql_num_rows($result_synonyms) > 0){
                  while ( $nb_synonyms = mysql_fetch_array($result_synonyms) ) {
                    $synonyms .= " ".$nb_synonyms[2]." ".$nb_synonyms[3]."<br>\n";//synonyms_of
                  }
                }
                echo "<td>".$synonyms."</td>";
                */
                //Marked on May 01, 2012 Tuesday
                
                
                //Marked on February 27, 2011 Sunday
                //Marked on February 27, 2011 Sunday
                
                /*
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
                
                */
                
                //Marked on February 27, 2011 Sunday
                //Marked on February 27, 2011 Sunday
              
                //echo "<td><a href=\"postProposedChanges.php?lv=".$taxon_level."&id=".$nb[0]."\">Post</a></td>";
              
                echo "</tr>\n";
              }
              echo "</table>\n";
            }
            /*Customize the table*/
            
            /*Page Navigation Module*/
            //echo "cur_page is :: ".$cur_page."<br>\n";
            echo "Page Navigation: ";


            $link_add_clause = "";
            if($lv != "" && $name != ""){
				$link_add_clause = "&lv=".$lv."&name=".$name;
            }


            if( $cur_page > 1 ){
              echo "<a href=\"".$target_page."?cur_page=1".$link_add_clause."\" ><<</a> ";//Go to first page
              echo "<a href=\"".$target_page."?cur_page=".($cur_page-1).$link_add_clause."\">Previous Page</a> ";
            }
            for($i = ($cur_page-3) ; $i< $cur_page; $i++){//3
              if( $i > $page_counts ){
                break;
              }else if($i < $cur_page && $i > 0){
                echo "<a href=\"".$target_page."?cur_page=".$i.$link_add_clause."\">".$i."</a> ";
              }else{
                //echo $i." ";
              }
            }
            for($i = $cur_page ; $i< ($cur_page+3); $i++){//3
              if( $i > $page_counts ){
                break;
              }else if($i > $cur_page){
                echo "<a href=\"".$target_page."?cur_page=".$i.$link_add_clause."\">".$i."</a> ";
              }else{
                echo $i." ";
              }
            }
            if( $cur_page < $page_counts ){
              echo "<a href=\"".$target_page."?cur_page=".($cur_page+1).$link_add_clause."\">Next Page</a> ";
              echo "<a href=\"".$target_page."?cur_page=".$page_counts.$link_add_clause."\" >>></a> ";//Go to last page
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

<?php
  include('template2.php'); 
?>



