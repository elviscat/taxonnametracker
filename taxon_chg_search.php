<?php
  //Developed by elviscat (elviscat@gmail.com)
  //June 02, 2010 Wednesday:: Taxon Change Search Initial
  // ./ current directory
  // ../ up level directory

  include('template0.php');
  
  //customized setup
  
  //Configuration of POST and GET Variables

  //$view_date = htmlspecialchars($_GET['view_date'],ENT_QUOTES);
  //echo "Variable lv is view_date:: ".$view_date."<br>\n";

  //Configuration of POST and GET Variables
  
  $array_data = "";
  
  $sql_taxon_change_search = "SELECT * From namelist_chglog";
  //echo "sql_taxon_change_search is ".$sql_taxon_change_search."<br>\n";
  $result_taxon_change_search = mysql_query($sql_taxon_change_search);
  if(mysql_num_rows($result_taxon_change_search) > 0 ){
    while ( $nb_taxon_change_search = mysql_fetch_array($result_taxon_change_search) ) {
      $taxon_level = $nb_taxon_change_search[1];
      $taxon_id = $nb_taxon_change_search[2];
      $ref_post_id = $nb_taxon_change_search[3];
      $taxon_name = taxon_name_without_level_for_taxon_chg_search($taxon_level, $taxon_id);
      $post_title = post_title_for_taxon_chg_search($ref_post_id);
      $array_data .= " ".$taxon_name;
      $array_data .= " ".$post_title;
      
    }
  }

  //echo $array_data;
  
  $caption = "<u>Taxon Change Search</u><BR>\n";
  
  //customized setup  

  include('template1.php');
?>

    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <link rel="stylesheet" href="http://dev.jquery.com/view/trunk/plugins/autocomplete/jquery.autocomplete.css" type="text/css" />
    <!--<script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/autocomplete/lib/jquery.bgiframe.min.js"></script>-->
    <!--<script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/autocomplete/lib/jquery.dimensions.js"></script>-->
    <script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/autocomplete/jquery.autocomplete.js"></script>
	  <!--
	  <link rel="stylesheet" type="text/css" href="autocomplete/jquery.autocomplete.css" />
	  <script type="text/javascript" src="autocomplete/jquery.autocomplete.js"></script>
	  <script type="text/javascript" src="autocomplete/jquery.autocomplete.js"></script>
	  -->
    <script>
      $(document).ready(function(){
        //alert('Hello!');
        <?php echo "var data = \"".$array_data."\".split(\" \");"; ?>
        //var data = "Core Selectors Attributes Traversing Manipulation CSS Events Effects Ajax Utilities".split(" ");
        //var data = ['台北市中正區','台北市大同區','台北市中山區','台北市松山區','台北市大安區'];
        //$("#search_word").autocomplete(data);
        $("#search_word").autocomplete(data, {matchContains: true});
        //$("#search_word").autocomplete('autocomplete.php');
      });
    </script>

    <?php echo "<h2>".$caption."</h2><br>\n"; ?>
        
        <p>Search for taxon change (Taxon Name, or Proposed Nomenclature Change Title)</p>
        <form name ="taxon_change_search" method ="post" action ="taxon_chg_search2.php">
          <!--<input type = "radio" name = "search_level" value = "family" >Family
          <input type = "radio" name = "search_level" value = "genus" checked>Genus
          <input type = "radio" name = "search_level" value = "species" >Species
          <input type = "radio" name = "search_level" value = "post_title" >Proposed Nomenclature Change Title
          -->
          <?php
            $array_array_data = explode(" ", $array_data);
            $search_default_keyword = $array_array_data[1];
          ?>
          
          <input type = "text" id = "search_word" name = "search_word" value = "<?php echo $search_default_keyword; ?>" />(type in Search Word)
          <br>
          <input type="submit" name="submit" value ="Search Taxon Change">
        </form>        



<?php
  include('template2.php'); 
?>



