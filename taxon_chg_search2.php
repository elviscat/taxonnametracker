<?php
  //Developed by elviscat (elviscat@gmail.com)
  //June 02, 2010 Wednesday:: Taxon Change Search Initial
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
  
  $caption = "<u>Taxon Change Search Result</u><BR>\n";

  //customized setup  

  include('template1.php');
?>

		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
		<?php echo "<h2>".$caption."</h2><br>\n"; ?>
        <p>Search Results:</p>
        <?php
          $sql_namelist_chg_log = "SELECT * FROM namelist_chglog";
          //echo "sql_namelist_chg_log is ".$sql_namelist_chg_log."<br>\n";
          $result_namelist_chg_log = mysql_query($sql_namelist_chg_log);
          //$table_caption = "No Search Result!";
          $table_caption = "";
          if(mysql_num_rows($result_namelist_chg_log) > 0 ){
            while ( $nb_namelist_chg_log = mysql_fetch_array($result_namelist_chg_log) ) {
              $taxon_level = $nb_namelist_chg_log[1];
              $taxon_id = $nb_namelist_chg_log[2];
              $ref_post_id = $nb_namelist_chg_log[3];
              $taxon_name = taxon_name_without_level_for_taxon_chg_search($taxon_level, $taxon_id);
              $post_title = post_title_for_taxon_chg_search($ref_post_id);
              
              /*
              echo "search_word is ".$search_word."<br>\n";
              echo "taxon_name is ".$taxon_name."<br>\n";
              echo "post_title is ".$post_title."<br>\n";
              
              $domain = strstr($taxon_name, $search_word);
              print $domain."<br>\n";
              $domain2 = strstr($post_title, $search_word);
              print $domain2."<br>\n";
              */
              
              if( strstr($taxon_name, $search_word) != "" || strstr($post_title, $search_word) != "" ){
                $table_caption .= "<table border=\"1\">";    
                $table_caption .= "<tr>";
                $table_caption .= "<td>Taxon Name</td>";
                $table_caption .= "<td>Change Note</td>";
                $table_caption .= "<td>Change Reason</td>";
                $table_caption .= "<td>Status</td>";
                $table_caption .= "</tr>";
                $table_caption .= "<tr>";
                $table_caption .= "<td>".$taxon_name."</td>";
                $table_caption .= "<td>".$nb_namelist_chg_log[4]."</td>";
                $table_caption .= "<td>".$nb_namelist_chg_log[5]."</td>";
                $table_caption .= "<td>".$nb_namelist_chg_log[6]."</td>";
                $table_caption .= "</tr>";                
                $table_caption .= "</table>";    
              }else{
                //$table_caption = "No Search Results Here!";
              }
            }
          }
          echo $table_caption;
          echo "<a href=\"taxon_chg_search.php\">Back to Taxon Change Search</a>\n";
        ?>
<?php
  include('template2.php'); 
?>
