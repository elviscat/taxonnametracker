<?php
  //Developed by elviscat (elviscat@gmail.com)
  //April 12, 2010 Monday:: New:: questionnarie form
  //May 02, 2012 Wednesday:: Modification:: apply to new template
  // ./ current directory
  // ../ up level directory


  session_start();

  if( (!isset($_SESSION['is_login'])) ){
	Header("location:authorizedFail.php");
	exit();
  }
  if( (!isset($_SESSION['uid'])) ){
	Header("location:authorizedFail.php");
	exit();
  }
  if( $_SESSION['role'] == "admin" ){
	echo "System Administrator can not post proposed change!!";
	exit();
  }

  //Access control by login status
  if( !isset($_SESSION['is_login']) ){
    Header("location:authorizedFail.php");
    exit();
  }
  //Access control by login status

  include('template0.php');



  //customized setup
  
  //Configuration of POST and GET Variables
  //$taxon_lv = htmlspecialchars($_GET['lv'],ENT_QUOTES);
  //echo "\$lv is <b>".$taxon_lv."</b><br />\n";
  //$taxon_id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "\$id is <b>".$taxon_id."</b><br />\n";

  //Configuration of POST and GET Variables
  
  $page_title = "Questionnaire :: ";
  $page_heading = "Questionnaire :: ";
  
  //$prefsid = $_GET['sid'];
  $prefuid = $_SESSION['uid'];  
  
  $att1 = "";//
  $att2 = "";//
  $att3 = "";//
  $att4 = "";//
  $att5 = "";//
  $att6 = "";//
  $att7 = "";//
  $att8 = "";//
  
  /*
  $ref_uid = "";
  $sql_ref_uid = "SELECT uid FROM user WHERE username = '".$_SESSION['username']."'";
  $result_ref_uid = mysql_query ($sql_ref_uid);
  if(mysql_num_rows($result_ref_uid) > 0){
    while ( $nb_ref_uid = mysql_fetch_array($result_ref_uid) ) {
      $ref_uid = $nb_ref_uid[0];
    }
  }
  */
  $ref_uid = $prefuid;
  
  $filled = "yes";
  $sql_questionnaire = "SELECT * FROM user_questionnaire WHERE ref_uid = '".$ref_uid."'";
  //echo $sql_questionnaire;
  $result_questionnaire = mysql_query ($sql_questionnaire);
  if(mysql_num_rows($result_questionnaire) > 0){
    while ( $nb_questionnaire = mysql_fetch_array($result_questionnaire) ) {
      $att1 = $nb_questionnaire[1];
      $att2 = $nb_questionnaire[2];
      $att3 = $nb_questionnaire[3];
      $att4 = $nb_questionnaire[4];
      $att5 = $nb_questionnaire[5];
      $att6 = $nb_questionnaire[6];
      $att7 = $nb_questionnaire[7];
      $att8 = $nb_questionnaire[9];
    }
  }else{
    $filled = "false";
  }
  
  $interest = "";
  $sql_interest = "SELECT * FROM user_questionnaire";
  //echo $sql_interest;
  $result_interest = mysql_query ($sql_interest);
  if(mysql_num_rows($result_interest) > 0){
    while ( $nb_interest = mysql_fetch_array($result_interest) ) {
      $interest .= ", ".$nb_interest[9];
    }
  }

  $array_data = "";
  $array_interest = explode(",", $interest);
  for ( $i= 0; $i < sizeof($array_interest); $i++){
    $array_data .= " ".$array_interest[$i];
  }

  //customized setup  

  include('template1.php');
?>

    <script type="text/javascript" src="jquery/jquery-1.3.2.js"></script>
    <script type="text/javascript" src="jquery/jquery.form.js"></script>
	<script type="text/javascript" src="autocomplete/jquery.autocomplete.js"></script>
    <style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
	</style>
		
    <script type="text/javascript">
      $(document).ready(function() {
        <?php echo "var data = \"".$array_data."\".split(\" \");"; ?>
        //var data = "Core Selectors Attributes Traversing Manipulation CSS Events Effects Ajax Utilities".split(" ");
        //var data = ['å°åŒ—å¸‚ä¸­æ­£å€','å°åŒ—å¸‚å¤§åŒå€','å°åŒ—å¸‚ä¸­å±±å€','å°åŒ—å¸‚æ¾å±±å€','å°åŒ—å¸‚å¤§å®‰å€'];
        //$("#search_word").autocomplete(data);
        $("#interest").autocomplete(data, {multiple: true, matchContains: true});
        //$("#search_word").autocomplete('autocomplete.php');



        $("#Submit").click(function(){
          //Question 1
          var att1 = "";
          $("input[name='att1']").each(function() {
            if(this.checked == true){
              att1 += $(this).val();
            }
          });
          //alert('att1 is' + att1);
          if(att1.length > 1){
            alert('Question 1 is single choice question!Please just choose one selection!');
            return false;
          }
          //Question 2
          var att2 = "";
          $("input[name='att2']").each(function() {
            if(this.checked == true){
              att2 += $(this).val();
            }
          });
          //alert('att2 is' + att2);
          if(att2.length > 1){
            alert('Question 2 is single choice question!Please just choose one selection!');
            return false;
          }
          //Question 3
          var att3 = "";
          $("input[name='att3']").each(function() {
            if(this.checked == true){
              att3 += $(this).val();
            }
          });
          //alert('att3 is' + att3);
          if(att3.length > 1){
            alert('Question 3 is single choice question!Please just choose one selection!');
            return false;
          }          
          //Question 5
          var att5 = "";
          $("input[name='att5']").each(function() {
            if(this.checked == true){
              att5 += $(this).val();
            }
          });
          //alert('att5 is' + att5);
          if(att5.length > 1){
            alert('Question 5 is single choice question!Please just choose one selection!');
            return false;
          }          
          //Question 6
          var att6 = "";
          $("input[name='att6']").each(function() {
            if(this.checked == true){
              att6 += $(this).val();
            }
          });
          //alert('att6 is' + att6);
          if(att6.length > 1){
            alert('Question 6 is single choice question!Please just choose one selection!');
            return false;
          }          
          //Question 7
          var att7 = "";
          $("input[name='att7']").each(function() {
            if(this.checked == true){
              att7 += $(this).val();
            }
          });
          //alert('att7 is' + att7);
          if(att7.length > 1){
            alert('Question 7 is single choice question!Please just choose one selection!');
            return false;
          }          
          
          
        });
      });
    </script>


      <?php echo "<h3>".$page_heading."</h3><br>\n"; ?>
      <div id="demo">
        <form id="questionnaireForm" action="questionnaire2.php" method="post">
          <table>
            <tr>
              <td colspan=2><?php
                              if($filled  == "false"){
                                echo "<p>Please fill out the following questions!</p>";
                              }else{
                                echo  "<p>Please update the following questions!</p>";
                              }
                            ?>
              </td>
            </tr>
            <tr>
              <td ><label>Question 1 (Single Choice): Highest academic degree completed:</label></td>
              <td >
              <?php
                //First, set up the att1 format
					      $att1_format = array("High School","Bachelor's","Master's/Graduate Advisor","Ph.D. / Graduate Advisor");
                for($i = 0; $i < sizeof($att1_format);$i++){
						      //echo "Variable att1 is ::".$att1;
						      $checked = "";
						      $temp = explode(";", $att1);
						      //echo $temp[2];
						      //echo sizeof($temp);
						      for($j = 0; $j < sizeof($temp);$j++){
							      if( $temp[$j] == ($i+1) ){
								      $checked = "checked=\"checked\"";
							      }
						      }
							    echo "<br>";
						      echo "<input name=\"att1\" type=\"checkbox\" id=\"att1\" value=\"".($i+1)."\" ".$checked."/>&nbsp;&nbsp;".$att1_format[$i]."&nbsp;&nbsp;";
					      }					
              ?>
              </td>
            </tr>
            <tr>
              <td ><label>Question 2 (Single Choice): Current Position (or last position prior to retirement)</label></td>
              <td >
              <?php
                //First, set up the att2 format
					      $att2_format = array("University Professor", "University Staff", "Museum Curator", "Museum Collections Manager", "Undergraduate Student", "Graduate Student / focus of research?", "Government Agency / Agency Name", "Aquarist/Hobbyist");
                for($i = 0; $i < sizeof($att2_format);$i++){
						      //echo "Variable att1 is ::".$att2;
						      $checked = "";
						      $temp = explode(";", $att2);
						      //echo $temp[2];
						      //echo sizeof($temp);
						      for($j = 0; $j < sizeof($temp);$j++){
							      if( $temp[$j] == ($i+1) ){
								      $checked = "checked=\"checked\"";
							      }
						      }
							    echo "<br>";
						      echo "<input name=\"att2\" type=\"checkbox\" id=\"att2\" value=\"".($i+1)."\" ".$checked."/>&nbsp;&nbsp;".$att2_format[$i]."&nbsp;&nbsp;";
					      }					
              ?>
              </td>
            </tr>
            <tr>
              <td ><label>Question 3 (Single Choice): Primary Interests in</label></td>
              <td >
              <?php
                //First, set up the att3 format
					      $att3_format = array("Freshwater Fishes", "Marine Fishes", "Both");
                for($i = 0; $i < sizeof($att3_format);$i++){
						      //echo "Variable att3 is ::".$att3;
						      $checked = "";
						      $temp = explode(";", $att3);
						      //echo $temp[2];
						      //echo sizeof($temp);
						      for($j = 0; $j < sizeof($temp);$j++){
							      if( $temp[$j] == ($i+1) ){
								      $checked = "checked=\"checked\"";
							      }
						      }
							    echo "<br>";
						      echo "<input name=\"att3\" type=\"checkbox\" id=\"att3\" value=\"".($i+1)."\" ".$checked."/>&nbsp;&nbsp;".$att3_format[$i]."&nbsp;&nbsp;";
					      }					
              ?>
              </td>
            </tr>
            
            <tr>
              <td ><label>Question 4 (Multiple Choice): Primary Interests with North American fishes? (may select multiple)</label></td>
              <td >
              <?php
                //First, set up the att4 format
					      $att4_format = array("Anatomy", "Biogeography", "Ecology", "Evolution", "Fisheries", "Life History", "Molecular Biology", "Physiology", "Systematics", "Taxonomy", "Other");
                for($i = 0; $i < sizeof($att4_format);$i++){
						      //echo "Variable att4 is ::".$att4;
						      $checked = "";
						      $temp = explode(";", $att4);
						      //echo $temp[2];
						      //echo sizeof($temp);
						      for($j = 0; $j < sizeof($temp);$j++){
							      if( $temp[$j] == ($i+1) ){
								      $checked = "checked=\"checked\"";
							      }
						      }
							    echo "<br>";
						      echo "<input name=\"att4[]\" type=\"checkbox\" id=\"att4[]\" value=\"".($i+1)."\" ".$checked."/>&nbsp;&nbsp;".$att4_format[$i]."&nbsp;&nbsp;";
					      }					
              ?>
              </td>
            </tr>
            
            
            <tr>
              <td ><label>Question 5 (Single Choice): Level of Familiarity with North American Fish Diversity? (only one)</label></td>
              <td >
              <?php
                //First, set up the att5 format
					      $att5_format = array("Not very familiar", "Somewhat familiar", "Very Familiar", "Expert");
                for($i = 0; $i < sizeof($att5_format);$i++){
						      //echo "Variable att5 is ::".$att5;
						      $checked = "";
						      $temp = explode(";", $att5);
						      //echo $temp[2];
						      //echo sizeof($temp);
						      for($j = 0; $j < sizeof($temp);$j++){
							      if( $temp[$j] == ($i+1) ){
								      $checked = "checked=\"checked\"";
							      }
						      }
							    echo "<br>";
						      echo "<input name=\"att5\" type=\"checkbox\" id=\"att5\" value=\"".($i+1)."\" ".$checked."/>&nbsp;&nbsp;".$att5_format[$i]."&nbsp;&nbsp;";
					      }					
              ?>
              </td>
            </tr>
            
            <tr>
              <td ><label>Question 6 (Single Choice): Level of Familiarity of Rules of Zoological Nomenclature, ICZN? (only one)</label></td>
              <td >
              <?php
                //First, set up the att6 format
					      $att6_format = array("Not very familiar", "Somewhat familiar", "Very Familiar", "Expert");
                for($i = 0; $i < sizeof($att6_format);$i++){
						      //echo "Variable att5 is ::".$att5;
						      $checked = "";
						      $temp = explode(";", $att6);
						      //echo $temp[2];
						      //echo sizeof($temp);
						      for($j = 0; $j < sizeof($temp);$j++){
							      if( $temp[$j] == ($i+1) ){
								      $checked = "checked=\"checked\"";
							      }
						      }
							    echo "<br>";
						      echo "<input name=\"att6\" type=\"checkbox\" id=\"att6\" value=\"".($i+1)."\" ".$checked."/>&nbsp;&nbsp;".$att6_format[$i]."&nbsp;&nbsp;";
					      }					
              ?>
              </td>
            </tr>            
            
            <tr>
              <td ><label>Question 7 (Single Choice): Level of Familiarity with North American Fish Taxonomy? (only one)</label></td>
              <td >
              <?php
                //First, set up the att7 format
					      $att7_format = array("Not very familiar", "Somewhat familiar", "Very Familiar", "Expert");
                for($i = 0; $i < sizeof($att7_format);$i++){
						      //echo "Variable att5 is ::".$att5;
						      $checked = "";
						      $temp = explode(";", $att7);
						      //echo $temp[2];
						      //echo sizeof($temp);
						      for($j = 0; $j < sizeof($temp);$j++){
							      if( $temp[$j] == ($i+1) ){
								      $checked = "checked=\"checked\"";
							      }
						      }
							    echo "<br>";
						      echo "<input name=\"att7\" type=\"checkbox\" id=\"att7\" value=\"".($i+1)."\" ".$checked."/>&nbsp;&nbsp;".$att7_format[$i]."&nbsp;&nbsp;";
					      }					
              ?>
              </td>
            </tr>            

            <tr>
              <td ><label>Collect other expertise or interest on taxonomy<br>Which North American taxa (e.g., Order, Family, Genus) are you most familiar with or interested in?
</label></td>
              <td >
                <textarea id='interest' name='interest' cols='50' rows='20'><?php if( $att8 == ""){echo "type taxonomic names separated by commas";}else{echo $att8;} ?></textarea>
              </td>
            </tr>
            
            

            <tr>
              <td colspan=2><button  type="submit" id="Submit" name="Submit">Submit</button></td>
            </tr>
            
          </table>
        </form>
      </div>
      <!--<div id="msg"></div>-->
      <!--<div class="spacer"></div>-->

<?php
  include('template2.php'); 
?>













