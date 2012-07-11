<?php
  //Developed by elviscat (elviscat@gmail.com)
  //Previous development records are lost
  //May 01, 2012 Tuesday:: View taxon information
  // ./ current directory
  // ../ up level directory


  include('template0.php');
    
  //customized setup
  //Configuration of POST and GET Variables
  $lv = htmlspecialchars($_GET['lv'],ENT_QUOTES);
  //echo "\$lv is :: ".$lv."<br>\n";
  $id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "\$id is :: ".$id."<br>\n";  //Configuration of POST and GET Variables  
  
  $page_title = "View Taxon :: ".taxon_name_without_level($lv, $id);
  $page_heading = "View Taxon :: <i>".taxon_name_without_level($lv, $id)."</i>";
  
  //template
  
  //$form_1 = array();
  //$form_2 = array();  
  if($lv != "species" || $id == ""){
    //echo "Null Pointer!\n";
    Header("location:error.php?error_msg=Invalid access!");
    exit;
  }else{
    //
    
    //$sql_taxon_account = "";
    //if($lv == "family"){
    //  $sql_taxon_account = "SELECT * FROM flist WHERE fid ='".$id."'";
    //  $form_2 = array("ID", "Kingdon",	"Phylum",	"Superclass",	"Class", "Subclass",	"Infraclass",	"Superorder",	"Order",	"Suboder",	"Superfamily",	"Family",	"Common name 1",	"Common name 2",	"Common name 3");
    //}elseif($lv == "genus"){
    //  $sql_taxon_account = "SELECT * FROM glist WHERE gid ='".$id."'";
    //  $form_2 = array("ID", "Family", "Genus", "ReferenceID");
    //}elseif($lv == "species"){
    //  $sql_taxon_account = "SELECT * FROM slist WHERE sid ='".$id."'";
    //  $form_2 = array("ID", "Family", "Genus", "Species", "Author", "Locality", "Common Name1", "Common Name2", "Common Name3", "State");
    //}
    
    //echo "sql_taxon_account is ".$sql_taxon_account."/n<br>";  
  	$sql_taxon_info = "SELECT * FROM slist WHERE sid ='".$id."' AND goes_to = 0";
  	$result_taxon_info = mysql_query($sql_taxon_info);  

	$layout = "";
	
	$footnote = "";
	
	
	
  	if(mysql_num_rows($result_taxon_info) > 0){
  		$layout .= "<h3>Basic Taxonomic Information:</h3>\n";
    	
    	
    	while ( $nb_taxon_info = mysql_fetch_array($result_taxon_info) ) {
			//$layout .= "\tScientific Name: <i>".$nb_taxon_info['sgenus']." ".$nb_taxon_info['sspecies']."<br />\n";
      		//$layout .= "\t".$nb_taxon_info['sauthor']."<br />\n";
      		$layout .= "\t<i>".$nb_taxon_info['sgenus']." ".$nb_taxon_info['sspecies']."</i> ".$nb_taxon_info['sauthor']."<br />\n";
      		$footnote = $nb_taxon_info['footnote'];
    	}
    	
		$layout .= "<h3>Synonym Name:</h3>\n";
		$sql_synonym_info = "SELECT * FROM slist WHERE synonym_of ='".$id."'";
		$result_synonym_info = mysql_query($sql_synonym_info);  
		if(mysql_num_rows($result_synonym_info) > 0){
			while ( $nb_synonym_info = mysql_fetch_array($result_synonym_info) ) {
				$layout .= "\t<i><a href=\"viewtaxon.php?lv=species&id=".$nb_synonym_info['sid']."\">".$nb_synonym_info['sgenus']." ".$nb_synonym_info['sspecies']."</a></i><br />\n";
			}
		}else{
			$layout .= "No synonym for this taxon right now!\n";
		}
		$layout .= "<h3>Change Footnotes/Change Logs:</h3>\n";
		if($footnote != ""){
			$footnote_array = explode(';', $footnote);
			$layout .= "<table>\n";
			$layout .= "\t<tr><td><b>Proposal Title</b></td><td><b>Status</b></td><td><b>Final Decision</b></td></tr>\n";
			for($i = 0; $i < sizeof($footnote_array); $i++){
				//$layout .= $footnote_array[$i]."<BR />\n";
				$pid = $footnote_array[$i];
				$sql_post = "SELECT * FROM post WHERE pid ='".$pid."'";
  				$result_post = mysql_query($sql_post);  
				
				if(mysql_num_rows($result_post) > 0){
					
					while ( $nb_post = mysql_fetch_array($result_post) ) {
						$layout .= "\t<tr>\n\t\t<td><a href=\"viewpost.php?lv=species&pid=".$nb_post['pid']."\">".$nb_post['ptitle']."</a></td>";
						$layout .= "\t\t<td>".$nb_post['pstate']."</td>\n";
						$layout .= "\t\t<td>".$nb_post['p_final_decision']."</td>\n\t</tr>\n";
					}
				}
			}
			$layout .= "</table>\n";
		}else{
			$layout .= "No Change Footnotes/Change Logs right now!\n";
		}
		$layout .= "<h3>Submit Taxonomic Revision:</h3>\n";
    	
  	}else{
  		
  		$layout .= "<h3>No taxon data/information here!</h3>\n";
  	}
  	
	
	
	
  }
  




  
  //customized setup  
  include('template1.php');

?>

	<?php echo "<h2>".$page_heading."</h2><br>\n"; ?>
	<?php
		echo $layout;
	?>
        <form id="submitForm" action="postProposedChanges.php" method="post">
          <table>
            <tr>
              <td>
                <input id="lv" name="lv" type="hidden" value="<?php echo $lv; ?>"/>
            	<input id="id" name="id" type="hidden" value="<?php echo $id; ?>"/>
				<input id="submit" name="submit" type="submit" value="Submit a taxonomic revision" />
              </td>
            </tr>
          </table>
        </form>

<?php
  include('template2.php'); 
?>




