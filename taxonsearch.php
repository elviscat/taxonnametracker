<?php
  //Developed by elviscat (elviscat@gmail.com)
  //March 19, 2010 Friday::New::Taxon search interface
  //May 26, 2010 Wednesday:: Apply to new layout design
  // ./ current directory
  // ../ up level directory

  include('template0.php');
  
  //customized setup
  
  //Configuration of POST and GET Variables

  //$view_date = htmlspecialchars($_GET['view_date'],ENT_QUOTES);
  //echo "Variable lv is view_date:: ".$view_date."<br>\n";

  //Configuration of POST and GET Variables
  
  $family_array_data = "";
  $genus_array_data = "";
  $species_array_data = "";
  $sql_taxon_search = "SELECT * From flist";
  //echo "sql_taxon_search is ".$sql_taxon_search."<br>\n";
  $result_taxon_search = mysql_query($sql_taxon_search);
  if(mysql_num_rows($result_taxon_search) > 0 ){
    while ( $nb_taxon_search = mysql_fetch_array($result_taxon_search) ) {
      //echo $nb_taxon_search[0];
      $family_array_data .= " ".$nb_taxon_search['ffamily'];
    }
  }
  $sql_taxon_search = "SELECT * From glist";
  //echo "sql_taxon_search is ".$sql_taxon_search."<br>\n";
  $result_taxon_search = mysql_query($sql_taxon_search);
  if(mysql_num_rows($result_taxon_search) > 0 ){
    while ( $nb_taxon_search = mysql_fetch_array($result_taxon_search) ) {
      //echo $nb_taxon_search[0];
      $genus_array_data .= " ".$nb_taxon_search['ggenus'];
    }
  }
  
  $sql_taxon_search = "SELECT * From slist";
  //echo "sql_taxon_search is ".$sql_taxon_search."<br>\n";
  $result_taxon_search = mysql_query($sql_taxon_search);
  if(mysql_num_rows($result_taxon_search) > 0 ){
    while ( $nb_taxon_search = mysql_fetch_array($result_taxon_search) ) {
      //echo $nb_taxon_search[0];
      $species_array_data .= $nb_taxon_search['sgenus']." ".$nb_taxon_search['sspecies'].";";
    }
  }
  
  //echo $array_data;
  
  $caption = "<u>Taxon Search</u><BR>\n";
  
  //customized setup  

  include('template1.php');
?>

    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <!--
    <link rel="stylesheet" href="http://dev.jquery.com/view/trunk/plugins/autocomplete/jquery.autocomplete.css" type="text/css" />
    <script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/autocomplete/lib/jquery.bgiframe.min.js"></script>
    <script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/autocomplete/lib/jquery.dimensions.js"></script>
    <script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/autocomplete/jquery.autocomplete.js"></script>-->
    
    
    <!--
    <link rel="stylesheet" href="http://view.jquery.com/trunk/plugins/autocomplete/jquery.autocomplete.css" type="text/css" />
    <script type="text/javascript" src="http://view.jquery.com/trunk/plugins/autocomplete/jquery.autocomplete.js"></script>
	  -->
    
	  <link rel="stylesheet" type="text/css" href="autocomplete/jquery.autocomplete.css" />
	  <script type="text/javascript" src="autocomplete/jquery.autocomplete.js"></script>
	  
    <script>
      $(document).ready(function(){
        
        var radio_content = "";
        var data = "";
        
        $("input[name='search_level']:radio").change(function() {
        //$("#search_level").change(function() {//fail
          //alert("Option changed!");
          //alert('Hello Elvis, this is radio change event!');
                    
          if ($("input[@name='search_level']:checked").val() == 'family'){
            // Code for handling value 'family'
            //alert('Radio Button change to family!');
            //radio_content = "Core Selectors Attributes Traversing Manipulation CSS Events Effects Ajax Utilities";
            <?php echo "radio_content = \"".$family_array_data."\".split(\" \");"; ?>
            //var data_family = radio_content.split(" ");
            //$("#search_word").autocomplete(data_family, {selectFirst: true});
            //data_family = "";
            //$('#output').html("<input type = \"text\" id = \"family\" name = \"family\" value = \"family\" />);
            $("#search_word").autocomplete(radio_content, {selectFirst: true});
            $("#search_word").flushCache();
          }
          if ($("input[@name='search_level']:checked").val() == 'genus'){
            // Code for handling value 'genus'
            //alert('Radio Button change to genus!');
            //radio_content = "Oracle Java";
            <?php echo "radio_content = \"".$genus_array_data."\".split(\" \");"; ?>
            //var data_genus = radio_content.split(" ");
            //$("#search_word").autocomplete(data_genus, {selectFirst: true});
            //data_genus = "";
            //$('#output').html("<input type = \"text\" id = \"genus\" name = \"genus\" value = \"genus\" />);
            $("#search_word").autocomplete(radio_content, {selectFirst: true});
            $("#search_word").flushCache();
          }
          if ($("input[@name='search_level']:checked").val() == 'species'){
            // Code for handling 'species'
            //alert('Radio Button change to species!');
            //radio_content = "Radio Check";
            <?php echo "radio_content = \"".$species_array_data."\".split(\";\");"; ?>
            //data_species = radio_content.split(" ");
            //$("#search_word").autocomplete(data_species, {selectFirst: true});
            //data_species = "";
            //$('#output').html("<input type = \"text\" id = \"species\" name = \"species\" value = \"species\" />);
            $("#search_word").autocomplete(radio_content, {matchContains: true});
            $("#search_word").flushCache();
          }
          //else{
            //
            //alert('Nothing happen!');          
          //}
          //alert(radio_content);


          //$("#search_word").autocomplete(radio_content, {selectFirst: true});
          //$("#search_word").flushCache();


          //$("#search_word").autocomplete(data, {selectFirst: true});
          //$("#search_word").autocomplete(radio_content, {selectFirst: true, cacheLength: 0, noCache: true});
          //$("#search_word").autocomplete(radio_content, {matchContains: true});
          //$("#search_word").autocomplete(data, {selectFirst: true});
          //$("#search_word").autocomplete(data, {matchContains: true});
          
          
        });

        

        
        
        
        //alert('Hello!');
        
        <?php //echo "var data = \"".$array_data."\".split(\" \");"; ?>
        
        //var data = "Core Selectors Attributes Traversing Manipulation CSS Events Effects Ajax Utilities".split(" ");
        //var data = ['台北市中正區','台北市大同區','台北市中山區','台北市松山區','台北市大安區'];
        //$("#search_word").autocomplete(data);
        //$("#search_word").autocomplete(data, {matchContains: true});
        //$("#search_word").autocomplete('autocomplete.php');
      });
    </script>

    <?php echo "<h2>".$caption."</h2><br>\n"; ?>

        <p>Search for taxon of interest (Family, Genus, or Species)</p>
        <form name ="taxonsearch" method ="post" action ="taxonsearch2.php">
          <input type = "radio" name = "search_level" id = "search_level" value = "family" >Family
          <input type = "radio" name = "search_level" id = "search_level" value = "genus" >Genus
          <input type = "radio" name = "search_level" id = "search_level" value = "species" >Species
          <!--<div id="output"></div>-->
          <input type = "text" id = "search_word" name = "search_word" value = "Campostoma" />(Example: Check the Radio Button to Genus and Type in Campostoma)
          <br>
          <input type="submit" name="submit" value ="Search">
        </form>        



<?php
  include('template2.php'); 
?>



