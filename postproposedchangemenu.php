<?php
  //Developed by elviscat (elviscat@gmail.com)
  //Mar 14, 2010 Sunday::New:: A navigation page
  //April 08, 2010 Thursday:: Modification::revision on layout editing
  //May 26, 2010 Wednesday:: Apply to new layout design
  // ./ current directory
  // ../ up level directory

  include('template0.php');
  
  //customized setup
  
  //Configuration of POST and GET Variables

  $view_date = htmlspecialchars($_GET['view_date'],ENT_QUOTES);
  //echo "Variable lv is view_date:: ".$view_date."<br>\n";

  //Configuration of POST and GET Variables
  
  
  /*
  !?!?
  $taxon_name = taxon_name($lv, $id); 

  $state_clause = "";
  if( $state == "" ){
    $state_clause = "AND pstate ='0'";   ;
  }elseif( $state == "all" ) {
    $state_clause = "";
  }else{
    $state_clause = "AND pstate ='".$state."'";
  }        
  !?!?
  */
  $caption = "Navigation Page for Posting Proposed Nomenclatural Changes<BR>\n";

  $sql = "SELECT * FROM namelist_chglog ORDER BY id DESC";

  if( $view_date != "" ){
    //find_last_six_months, $sql_find_last_six_months = "SELECT * FROM post WHERE pcredate > '".$view_date."' AND pstate='0'";
    $sql = "SELECT * FROM namelist_chglog WHERE chgdate > '".substr($view_date, 0, 10)."' ORDER BY id DESC";
    $caption = "View All Posts (< 6 mo): <BR>";
  }
  
  //customized setup  

  include('template1.php');
?>

		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
		<?php echo "<h2>".$caption."</h2><br>\n"; ?>
        <p>You can post proposed nomenclature changes for a single taxon or for multiple taxa.</p>
        <p>We provide three methods for posting proposed changes.</p>
        <p><li><a href="name_list.php">Single Taxon via traditional name list</a>
               <br>
               (Select this option --> Select classification level --> Select the taxon --> Click the post and input your proposed nomenclatural change)
           </li>
        </p>
        <p><li><a href="taxonsearch.php">Single Taxon via search result</a>
               <br>
               (Select this option --> Search by name --> Check the appropriate taxon --> Click the post and input your proposed nomenclatural change)
           </li>
        </p>
        <p><li><a href="tree_list.php">Multiple Taxa via biological classification</a>
               <br>
               (Select this option --> Select several taoxn --> Build the taxa list by selecting appropriate taxa for comment--> Click the post and input your proposed nomenclatural change)
           </li>
        </p>        


<?php
  include('template2.php'); 
?>


