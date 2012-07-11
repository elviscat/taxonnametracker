<?php
  //Developed by elviscat (elviscat@gmail.com)
  //June 16, 2010 Wednesday:: NEW:: SA write Nomenclature Proposal's  Summary and send email to Names Committee Memebr(s):: Step 1
  // ./ current directory
  // ../ up level directory

  session_start();

  //Access control by login status
  if( !isset($_SESSION['is_login']) ){
    Header("location:authorizedFail.php");
    exit();
  }
  //Access control by login status

  include('template0.php');

  
  //customized setup
  
  //Configuration of POST and GET Variables
  $pid = htmlspecialchars($_GET['pid'],ENT_QUOTES);
  //echo "Variable pid is <b>".$pid."</b><br>\n";
  $taxon_lv = htmlspecialchars($_GET['lv'],ENT_QUOTES);
  //echo "Variable taxon_lv is <b>".$taxon_lv."</b><br>\n";
  $taxon_id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "Variable taxon_id is <b>".$taxon_id."</b><br>\n";
  //Configuration of POST and GET Variables
  $caption = "SA write Nomenclature Proposal's  Summary and send email to Names Committee Memebr(s)";

  //customized setup  

  include('template1.php');
?>
		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>

    <?php echo "<h2>".$caption."</h2><br>\n"; ?>
    <form id="writeSummaryForm" action="sa_write_summary2.php" method="post">
    <input id="taxon_lv" name="taxon_lv" type="hidden" value="<?php echo $taxon_lv; ?>"/>
    <input id="taxon_id" name="taxon_id" type="hidden" value="<?php echo $taxon_id; ?>"/>
    <input id="pid" name="pid" type="hidden" value="<?php echo $pid; ?>"/>
    <!--<input name="id" type="hidden" value="<?php //echo $id; ?>"/>-->
    <table>
      <tr>
        <td colspan=2><p>Please fill out the following fields!</p></td>
      </tr>
      <tr>
        <td ><label>Your Summary</label></td>
        <td ><textarea name="nomenclature_summary" id="nomenclature_summary" rows="10" cols="60"></textarea></td>
      </tr>
      <tr>
        <td colspan=2><button id="submit_button" name="submit_button" type="submit" onclick="confirmation(); return false;">Write Summary and click this button to send this summary to Names Committee Memebrs</button></td>
      </tr>
    </table>
    </form>      

<?php
  include('template2.php'); 
?>



