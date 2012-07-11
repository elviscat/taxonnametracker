<?php
  //Developed by elviscat (elviscat@gmail.com)
  //Mar 19, 2010 Friday::New::Taxon search interface
  //May 26, 2010 Wednesday:: Apply to new layout design
  // ./ current directory
  // ../ up level directory

  include('template0.php');
  
  //customized setup
  
  //Configuration of POST and GET Variables

  $search_level = htmlspecialchars($_POST['search_level'],ENT_QUOTES);
  $search_word = htmlspecialchars($_POST['search_word'],ENT_QUOTES);
  $special_level = htmlspecialchars($_GET['special_level'],ENT_QUOTES);
  $taxon_name = htmlspecialchars($_GET['taxon_name'],ENT_QUOTES);

  //$view_date = htmlspecialchars($_GET['view_date'],ENT_QUOTES);
  //echo "Variable lv is view_date:: ".$view_date."<br>\n";

  //Configuration of POST and GET Variables
  
  $caption = "<u>Taxon Search Result</u><BR>\n";

  //customized setup  

  include('template1.php');
?>

		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
		<?php echo "<h2>".$caption."</h2><br>\n"; ?>
        <p>Search Results:</p>
        <?php
          //
          //
          if( $special_level == "" ){
            //echo "special_level is ".$special_level."<br>\n";
            $sql_taxon_search = "";
            if($search_level == "family"){
              $sql_taxon_search = "SELECT * From flist WHERE ffamily ='".$search_word."'";
            }elseif($search_level == "genus"){
              $sql_taxon_search = "SELECT * From glist WHERE ggenus ='".$search_word."'";
            }elseif($search_level == "species"){
              $sql_taxon_search = "SELECT * From slist WHERE sspecies ='".$search_word."'";
            }
            //echo "sql_taxon_search is ".$sql_taxon_search."<br>\n";
            $result_taxon_search = mysql_query($sql_taxon_search);
            if(mysql_num_rows($result_taxon_search) > 0 ){
            echo "<table border=\"1\">\n";    
              if( $search_level == "family"){
                $table_caption = "<tr>";
                $table_caption .= "<td>ID</td>";
                $table_caption .= "<td>Kingdon</td>";
                $table_caption .= "<td>Phylum</td>";
                $table_caption .= "<td>Superclass</td>";
                $table_caption .= "<td>Class</td>";
                $table_caption .= "<td>Subclass</td>";
                $table_caption .= "<td>Infraclass</td>";
                $table_caption .= "<td>Superorder</td>";
                $table_caption .= "<td>Order</td>";
                $table_caption .= "<td>Suboder</td>";
                $table_caption .= "<td>Superfamily</td>";
                $table_caption .= "<td>Family</td>";
                $table_caption .= "<td>Common name 1</td>";
                $table_caption .= "<td>Common name 2</td>";
                $table_caption .= "<td>Common name 3</td>";
              }elseif( $search_level == "genus" ){
                $table_caption = "<tr><td>ID</td><td>Family</td><td>Genus</td>";
              }elseif( $search_level == "species" ){
                $table_caption = "<tr><td>ID</td><td>Family</td><td>Genus</td><td>Species</td><td>Author</td><td>Locality</td><td>Common Name1</td><td>Common Name2</td><td>Common Name3</td>";
              }

              echo $table_caption."<BR>\n";
            
              echo "<td>View All Proposed Changes</td><td>Post Proposed Changes</td>\n";
              
              echo "</tr>\n";
              while ( $nb_taxon_search = mysql_fetch_array($result_taxon_search) ) {
                if( $search_level == "family"){
                  $table_content = "<tr>";
                  $table_content .= "<td>".$nb_taxon_search[0]."</td>";
                  $table_content .= "<td>".$nb_taxon_search[1]."</td>";
                  $table_content .= "<td>".$nb_taxon_search[2]."</td>";
                  $table_content .= "<td>".$nb_taxon_search[3]."</td>";
                  $table_content .= "<td>".$nb_taxon_search[4]."</td>";
                  $table_content .= "<td>".$nb_taxon_search[5]."</td>";
                  $table_content .= "<td>".$nb_taxon_search[6]."</td>";
                  $table_content .= "<td>".$nb_taxon_search[7]."</td>";
                  $table_content .= "<td>".$nb_taxon_search[8]."</td>";
                  $table_content .= "<td>".$nb_taxon_search[9]."</td>";
                  $table_content .= "<td>".$nb_taxon_search[10]."</td>";
                  $table_content .= "<td><a href=\"taxonsearch2.php?special_level=family&taxon_name=".$search_word."\">".$nb_taxon_search[11]."</a></td>";//family name
                  $table_content .= "<td>".$nb_taxon_search[12]."</td>";
                  $table_content .= "<td>".$nb_taxon_search[13]."</td>";
                  $table_content .= "<td>".$nb_taxon_search[14]."</td>";
                }elseif( $search_level == "genus" ){
                  $table_content = "<tr><td>".$nb_taxon_search[0]."</td><td>".$nb_taxon_search[1]."</td><td><a href=\"taxonsearch2.php?special_level=genus&taxon_name=".$search_word."\">".$nb_taxon_search[2]."</a></td>";
                }elseif( $search_level == "species" ){
                  $table_content = "<tr><td>".$nb_taxon_search[0]."</td><td>".$nb_taxon_search[1]."</td><td>".$nb_taxon_search[2]."</td><td>".$nb_taxon_search[3]."</td><td>".$nb_taxon_search[4]."</td><td>".$nb_taxon_search[5]."</td><td>".$nb_taxon_search[6]."</td><td>".$nb_taxon_search[7]."</td><td>".$nb_taxon_search[8]."</td>";
                }                
                echo $table_content."\n";
                
                //count the times of the posted proposed change
                $post_counter = "";
                $sql_count_post = "SELECT COUNT(*) FROM post WHERE preflv = '".$search_level."' AND prefsid= ".$nb_taxon_search[0];
                //echo $sql_count_post;
                $result_sql_count_post = mysql_query($sql_count_post);
                if(mysql_num_rows($result_sql_count_post) > 0){
                  while ( $nb_sql_count_post = mysql_fetch_array($result_sql_count_post) ) {
                    $post_counter = $nb_sql_count_post[0];
                  }
                }
                echo "<td>".$post_counter."&nbsp<a href=\"viewapc.php?lv=".$search_level."&id=".$nb_taxon_search[0]."\">View</a></td>";
                echo "<td><a href=\"postProposedChanges.php?lv=".$search_level."&id=".$nb_taxon_search[0]."\">Post</a></td>\n";
              }              
              echo "</table>\n";
            }else{
              echo "<b>There is not matching results!</b><br>\n";
            }
          }else{
            
            $sql_taxon_search = "";
            if($special_level == "family"){
              $sql_taxon_search = "SELECT * From slist WHERE sfamily ='".$taxon_name."'";
            }elseif($special_level == "genus"){
              $sql_taxon_search = "SELECT * From slist WHERE sgenus ='".$taxon_name."'";
            }
            //echo "sql_taxon_search is ".$sql_taxon_search."<br>\n";
            $result_taxon_search = mysql_query($sql_taxon_search);
            if(mysql_num_rows($result_taxon_search) > 0 ){
              //echo "<table border=\"1\">\n";
              echo "<table>\n";   
              $table_caption = "<tr><td>ID</td><td>Family</td><td>Genus</td><td>Species</td><td>Author</td><td>Locality</td><td>Common Name1</td><td>Common Name2</td><td>Common Name3</td>";              echo $table_caption."<BR>\n";
              echo "<td>View All Proposed Changes</td><td>Post Proposed Changes</td>\n";
              echo "</tr>\n";
              while ( $nb_taxon_search = mysql_fetch_array($result_taxon_search) ) {
                $table_content = "<tr><td>".$nb_taxon_search[0]."</td><td>".$nb_taxon_search[1]."</td><td>".$nb_taxon_search[2]."</td><td>".$nb_taxon_search[3]."</td><td>".$nb_taxon_search[4]."</td><td>".$nb_taxon_search[5]."</td><td>".$nb_taxon_search[6]."</td><td>".$nb_taxon_search[7]."</td><td>".$nb_taxon_search[8]."</td>";
                echo $table_content."\n";
                
                //count the times of the posted proposed change
                $post_counter = "";
                $sql_count_post = "SELECT COUNT(*) FROM post WHERE preflv = 'species' AND prefsid= ".$nb_taxon_search[0];
                //echo $sql_count_post;
                $result_sql_count_post = mysql_query($sql_count_post);
                if(mysql_num_rows($result_sql_count_post) > 0){
                  while ( $nb_sql_count_post = mysql_fetch_array($result_sql_count_post) ) {
                    $post_counter = $nb_sql_count_post[0];
                  }
                }
                echo "<td>".$post_counter."&nbsp<a href=\"viewapc.php?lv=species&id=".$nb_taxon_search[0]."\">View</a></td>";
                echo "<td><a href=\"postProposedChanges.php?lv=speceis&id=".$nb_taxon_search[0]."\">Post</a></td>\n";
              }              
              echo "</table>\n";            
            }
          }
          echo "<a href=\"taxonsearch.php\">Back to search</a>\n";
        ?>
<?php
  include('template2.php'); 
?>
