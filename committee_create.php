<?php
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 17, 2009 Tuesday:: Create a new names committee
  //June 15, 2010 Tuesday:: Modification on new applied layout and logic
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
  //$pid = htmlspecialchars($_GET['pid'],ENT_QUOTES);
  //echo "Variable pid is :: ".$pid."<br>\n";
  //$uid = htmlspecialchars($_GET['uid'],ENT_QUOTES);
  //echo "Variable uid is :: ".$uid."<br>\n";
  //Configuration of POST and GET Variables
  
  $caption = "Create a new Names Committee";

  

  //customized setup  

  include('template1.php');
?>
		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
    <script type="text/javascript" src="jquery/jquery-1.3.2.js"></script>
		<script type="text/javascript" src="jquery/jquery.doubleSelect.js"></script>
		<script type="text/JavaScript">
    $(document).ready(function(){
		      //alert($("input[@name='rdio']:checked").val());
		      /*
          if ($("input[@name='rdio']:checked").val() == '1'){
            // Code for handling value '1'
            alert("1");
          }else if ($("input[@name='rdio']:checked").val() == '2'){
            // Code for handling value '2'
            alter("2");
          }
          */
        <?php
             $sql = "SELECT * FROM flist";
             //echo "sql is ".$sql."/n<br>";
             $result_sql = mysql_query($sql);
             $family_array = "";
             echo "var family_array_for_comparison = new Array();\n";
             echo "var family_id_array_for_comparison = new Array();\n";
             $counter_family_array_for_comparison = 0;
             if(mysql_num_rows($result_sql) > 0){
               while ( $nb = mysql_fetch_array($result_sql) ) {
                 //echo $nb[0]."<br>\n";
                 $family_array .= "\"".$nb[11]."\": ".$nb[0].",";
                 echo "family_id_array_for_comparison[$counter_family_array_for_comparison] = \"".$nb[0]."\";\n";
                 echo "family_array_for_comparison[$counter_family_array_for_comparison] = \"".$nb[11]."\";\n";
                 $counter_family_array_for_comparison++;
               }
             }
             $family_array = substr($family_array, 0, -1);
             echo "var family_array_for_comparison_length = ".$counter_family_array_for_comparison.";\n";

             $sql2 = "SELECT * FROM glist";
             //echo "sql2 is ".$sql2."/n<br>";
             $result_sql2 = mysql_query($sql2);
             $genus_array = "";

             echo "var genus_array_for_comparison = new Array();\n";
             echo "var genus_id_array_for_comparison = new Array();\n";
             $counter_genus_array_for_comparison = 0;


             if(mysql_num_rows($result_sql2) > 0){
               while ( $nb2 = mysql_fetch_array($result_sql2) ) {
                 //echo $nb2[0]."<br>\n";
                 $genus_array .= "\"".$nb2[2]."\": ".$nb2[0].",";

                 echo "genus_id_array_for_comparison[$counter_genus_array_for_comparison] = \"".$nb2[0]."\";\n";
                 echo "genus_array_for_comparison[$counter_genus_array_for_comparison] = \"".$nb2[2]."\";\n";
                 $counter_genus_array_for_comparison++;

               }
             }
             $genus_array = substr($genus_array, 0, -1);
             echo "var genus_array_for_comparison_length = ".$counter_genus_array_for_comparison.";\n";
             
             
             
             $sql3 = "SELECT * FROM slist";
             //echo "sql3 is ".$sql3."/n<br>";
             $result_sql3 = mysql_query($sql3);
             $species_array = "";

             echo "var species_array_for_comparison = new Array();\n";
             echo "var species_id_array_for_comparison = new Array();\n";
             $counter_species_array_for_comparison = 0;

             if(mysql_num_rows($result_sql3) > 0){
               while ( $nb3 = mysql_fetch_array($result_sql3) ) {
                 //echo $nb3[0]."<br>\n";
                 $species_array .= "\"".$nb3[2]." ".$nb3[3]."\": ".$nb3[0].",";

                 echo "species_id_array_for_comparison[$counter_species_array_for_comparison] = \"".$nb3[0]."\";\n";
                 echo "species_array_for_comparison[$counter_species_array_for_comparison] = \"".$nb3[2]." ".$nb3[3]."\";\n";
                 $counter_species_array_for_comparison++;                 
                 
               }
             }
             $species_array = substr($species_array, 0, -1);             
             echo "var species_array_for_comparison_length = ".$counter_species_array_for_comparison.";\n";

        ?>
        
        var selectoptions = {
            "Family": {"key" : 1,"defaultvalue" : 1,"values" : {<?php echo $family_array; ?>}},
            "Genus": {"key" : 2,"defaultvalue" : 1,"values" : {<?php echo $genus_array; ?>}},
            "Species": {"key" : 3,"defaultvalue" : 1,"values" : {<?php echo $species_array; ?>}}
        
        };
        $('#first').doubleSelect('second', selectoptions);      


        //
        //
        <?php
          echo "var account_array = new Array();\n";
          $sql4 = "SELECT * FROM committee_account";
          //echo "sql4 is ".$sql4."/n<br>";
          $result_sql4 = mysql_query($sql4);
          $profile_text = "";
          $counter = 0;
          if(mysql_num_rows($result_sql4) > 0){
            while ( $nb4 = mysql_fetch_array($result_sql4) ) {
              echo "account_array[$counter] = \"".$nb4[1].":".$nb4[2]."\";\n";
              $counter++;
            }
          }
          echo "var account_array_length = ".$counter.";\n";
        ?>

        
        
        //
	      var a = "";
	      
	      var lv_str = "";
        var option_a = "";
        //var a = new Array();
        $("#selectListButton").click(function(){
          //alert("Hello Elvis!");
                    
          var lv_num = $('#first').val();
          if(lv_num == 1){
            lv_str = "family";
          }else if(lv_num == 2){
            lv_str = "genus";
          }else if(lv_num == 3){
            lv_str = "species";
          }

          //step 1: check if this account has been selected
          var match = lv_str + ":" + $('#second').val();
          var isSelected = false;
          for (var i =0; i< account_array_length; i++){
            if(match == account_array[i]){
              isSelected = true;
            }
          }
          if( isSelected == true){
            alert("This account has been selected in other Names Committee!\nPlease selelct other accounts!");
          }else{
            //alert(a.length);
            if(a.length == 0 ){
              //a[0] = $('#selectList').val()+",";
              a += lv_str + ":" + $('#second').val();
            }else{
              //a[a.length+1] = $('#selectList').val();
              var splitResult = a.split(",");
              //alert(splitResult.length);
              ///*
              //var match = lv_str + ":" + $('#second').val();
              var isNew = true;
              for (var i =0; i< (splitResult.length); i++){
                //alert("splitResult[i] is " + splitResult[i]);
                //alert("$('#selectList').val() is " + $('#selectList').val());
                if(match == splitResult[i]){
                  isNew = false;
                }
              }
              if( isNew == true){
                a += "," + lv_str + ":" +  $('#second').val();
                //alert($('#second').text());
              }
            }
          }
		      //a = a.substring(0,(a.length)-1); 
          var output_selected = "";
          var split_selected_array = a.split(",");          
          ///*
          for(var i=0; i<split_selected_array.length; i++){
            //alert(split_selected_array[i]);
            var split_selected_array2 = split_selected_array[i].split(":");
            var compare_array = new Array();
            var level = "";
            //alert(split_selected_array2[0]);
            //alert(split_selected_array2[1]);
            if(split_selected_array2[0] == "family"){
              //
              compare_array = family_id_array_for_comparison;
              compare_outout_array = family_array_for_comparison;
              level = "Level: Family";
            }else if(split_selected_array2[0] == "genus"){
              //
              compare_array = genus_id_array_for_comparison;
              compare_outout_array = genus_array_for_comparison;
              level = "Level: Genus";
            }else if(split_selected_array2[0] == "species"){
              //
              compare_array = species_id_array_for_comparison;
              compare_outout_array = species_array_for_comparison;
              level = "Level: Species";
            }
            for(var j=0; j<compare_array.length; j++){
              //alert("split_selected_array2[1] is " + split_selected_array2[1]);
              //alert("compare_array[j] is " + compare_array[j]);
              if(split_selected_array2[1] == compare_array[j]){
                if(i == 0){
                  output_selected += level + compare_outout_array[j];
                }else{
                  output_selected += "," + level + compare_outout_array[j];
                }  
              }
            }
          }
          //*/    
          var sendMessage_output = "<B>You have already selected the following accounts:</B><BR>"                    
                  
          /* set input valuse via jQuery AJAX behavior*/
          //$("#users").attr("value", a);
          $('#accounts').val(a);
          //alert(option_a);
          $('#option').val(option_a);
          /* set input valuse via jQuery AJAX behavior*/
          //$('#sendMessageOutput').html(a);
          //$('#sendMessageOutput').html(a + "\n<BR>" + sendMessage_output + output_selected);
          $('#sendMessageOutput').html(sendMessage_output + output_selected);
          

          
        });        
        //
        //
	      $("#submit_button").click(function(){
		      if( $('#accounts').val() =="" ) {
            alert("You need to select at least one taxon");
            return false;
          }
	      });
    });

    </script>

        <?php echo "<h2>".$caption."</h2><br>\n"; ?>
        Select nomenclature level:&nbsp <select id="first" name="first" size="1"><option value="">--</option></select><br><br>
        Account name::&nbsp <select id="second" name="second" size="1"><option value="">--</option></select><br><br>
        <button id="selectListButton">Step 1: Build the Taxon/Taxa List then go to Step 2</button>
        <div id="sendMessageOutput"></div>
          
          <form id="updateForm" action="committee_create2.php" method="post">
          <input id="accounts" name="accounts" type="hidden" />
          
          <!--<input name="id" type="hidden" value="<?php //echo $id; ?>"/>-->
          <table>
            <tr>
              <td colspan=2><p>Please fill out the following fields!</p></td>
            </tr>
            <tr>
              <td ><label>Names Committee Name</label></td>
              <td ><textarea name="committee_name" id="committee_name" rows="10" cols="60"><?php echo $committee_name; ?></textarea></td>
              <!--<td ><input name="committee_name" type="text" /></td>-->
            </tr>
            <tr>
              <td ><label>Notes</label></td>
              <td ><textarea name="committee_note" id="committee_note" rows="10" cols="60"><?php echo $committee_note; ?></textarea></td>
              <!--<td ><input name="committee_note" type="text" /><br></td>-->
            </tr>
            <tr>
              <td colspan=2><button id="submit_button" name="submit_button" type="submit" onclick="confirmation(); return false;">Step 2: Fill out the above information and click this button to create a new names committee</button></td>
            </tr>
          </table>
        </form>      

<?php
  include('template2.php'); 
?>



