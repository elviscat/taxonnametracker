<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Oct 19, 2009 Monday:: system administrator invite registered users to names committee step 2
  //Jan 26, 2010 Tuesday:: add template code section, and add a javascript tp prevent to unll selection
  // ./ current directory
  // ../ up level directory
  
  //header("Cache-control: private");
  //session_cache_limiter("none");

  //template
  session_start();
  include('template/dbsetup.php'); 
  require('inc/config.inc.php');
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);  

  //Configuration of POST and GET Variables
  $users = htmlspecialchars($_POST['users'],ENT_QUOTES);
  //echo "Variable users is :: ".$users."<br>\n";
  //Configuration of POST and GET Variables
    
  $caption = $application_caption;
  $caption2 = "System Administrator Invite Registered Users to Names Committee Step 2<BR>";
  $caption2 .= "STEP1: Select user first<BR>";
  $caption2 .= "<font color=\"Red\">STEP2: Select Names Committee or Taxon Step 2: Select one or more nomenclature accounts</font><BR>";
  $caption2 .= "STEP3: Send Invitation to user<BR>";
  $caption2 .= "STEP4: Send invitation!<BR>";
  $title = $application_caption."::".$caption2;
  //template   




?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
    <meta name="Description" content="Saint Louis University, tissue, species information" />
    <meta name="Keywords" content="Saint Louis University, tissue, information" />
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <!--<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />-->
    <meta name="Distribution" content="Global" />
    <meta name="Author" content="Richard Mayden - cypriniformes@gmail.com, Elvis Hsin-Hui Wu - hwu5@slu.edu" />
    <meta name="Robots" content="index,follow" />
    <link rel="stylesheet" href="edit.css" type="text/css" /><!--Does this file edit.css should be keep?-->	
    <!--<link rel="shortcut icon" type="image/ico" href="http://www.sprymedia.co.uk/media/images/favicon.ico" />-->
		<title><? echo $title; ?></title>
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
          //alert($("input[@name='rdio']:checked").val());
          //option_a = $("input[@name='rdio']:checked").val();
          //alert("option_a is " + option_a);
          $("input[name='rdio']").each(function() {
            //$(this).attr("checked", true);
            //bb += $(this).attr("value", true);
            if(this.checked == true){
              //alert($(this).val());
              option_a = $(this).val();
            }
          });
          
          if(option_a == "option1"){
            //alert($("input[@name='test']:checked").val());
            //var option_b = $("input[@name='rdio2']:checked").val();
            
            
            var selected_committee_id = "";
            var selected_committee_text = "";
            $("input[name='check_account[]']").each(function() {
              //$(this).attr("checked", true);
              //bb += $(this).attr("value", true);
              if(this.checked == true){
                var temp_array1 = ($(this).val()).split(";");
                //selected_committee_id += $(this).val() + ",";
                //selected_committee_text += $(this).text() + ",";
                selected_committee_id += temp_array1[0] + ",";
                selected_committee_text += temp_array1[1] + ",";
              }
            });
            selected_committee_id = selected_committee_id.substring(0,(selected_committee_id.length)-1);
            selected_committee_text = selected_committee_text.substring(0,(selected_committee_text.length)-1); 
            var sendMessage_output = "<B>You have already selected this committee:</B><BR>"   
            $('#accounts').val(selected_committee_id);
            $('#sendMessageOutput').html(sendMessage_output + selected_committee_text);
            
          }else if(option_a == "option2"){
          
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
          }
          //alert(option_a);
          $('#option').val(option_a);
        });        
        //
        //
	      $("#submit_button").click(function(){
		      if( $('#users').val() =="" || $('#accounts').val() =="" ) {
            alert("You need to select at least one user or one taxon");
            return false;
          }
	      });
    });

    </script>
	</head>
  <body id="dt_example">
		<div id="container">	
			<h1><? echo $caption; ?></h1>
      <?php
        include("menu.php");
      ?>
      <h2><?php echo $caption2; ?></h2>
      <div id="demo">
        <input type="radio" name="rdio" value="option1" />
        Option 1: Select existing names committee.<br>
        <?php
          $sql_committee_table = "SELECT * FROM committee_grp";   
          //echo "Hello";
          //echo "sql_committee_table is ".$sql_committee_table."/n<br>";
          $result_sql_committee_table = mysql_query($sql_committee_table);
          if(mysql_num_rows($result_sql_committee_table) > 0){
            echo "<table border=\"1\">\n";
            echo "<tr><td>Name</td><td>Note</td><td>Selected Accounts</td><td>Select This!</td></tr>\n";
            while ( $nb = mysql_fetch_array($result_sql_committee_table) ) {
              echo "<tr><td>".$nb[1]."</td><td>".$nb[2]."</td>";
              $sql_committee_table_account = "SELECT * FROM committee_account WHERE ref_c_id = ".$nb[0];    
              $result_sql_committee_table_account = mysql_query($sql_committee_table_account);
              echo "<td>";
              if(mysql_num_rows($result_sql_committee_table_account) > 0){
                while ( $nb2 = mysql_fetch_array($result_sql_committee_table_account) ) {
                  $sql_account_name = "";
                  if($nb2[1] == "family"){
                    $sql_account_name = "SELECT ffamily FROM flist WHERE fid =".$nb2[2];
                  }elseif($nb2[1] == "genus"){
                    $sql_account_name = "SELECT ggenus FROM glist WHERE gid =".$nb2[2];
                  }elseif($nb2[1] == "species"){
                    $sql_account_name = "SELECT sgenus,sspecies FROM slist WHERE sid =".$nb2[2];
                  }
                  $result_sql_account_name = mysql_query($sql_account_name);
                  $account_name = "";
                  if(mysql_num_rows($result_sql_account_name) > 0){
                    while ( $nb3 = mysql_fetch_array($result_sql_account_name) ) {
                      if($nb2[1] == "species"){
                        $account_name = "<i>".$nb3[0]." ".$nb3[1]."</i>";
                      }else{
                        $account_name = $nb3[0];
                      }
                    }
                  }
                  echo "Level: ".$nb2[1].":".$account_name."<br>";
                }
              }
              echo "</td>";
              //echo "<td><input type=\"checkbox\" name=\"com_id_".$nb[0]."\" value=\"".$nb[0]."\"/></td>";
              
              //add rule to prevent the duplicate users on the same committee              
              $is_contained = false;
              $array_users = explode(",", $users);
              for($i = 0; $i < sizeof($array_users);$i++){
                //echo $array_users[$i]."<br>";
                $sql_committee_member_chk = "SELECT * FROM committee_member WHERE user_id = ".$array_users[$i]." AND ref_c_id = ".$nb[0];
                //echo "sql_committee_member_chk"."<br>\n";
                $result_sql_committee_member_chk = mysql_query($sql_committee_member_chk);
                if(mysql_num_rows($result_sql_committee_member_chk) > 0){
                  $is_contained = true;
                }
              }
              if($is_contained == true){
                echo "<td>Some users you selected have been in this committee!</td>";
              }else{
                echo "<td><input type=\"checkbox\" name=\"check_account[]\" value=\"".$nb[0].";".$nb[1]."\"></input></td>";
              }
              
              /*
              if($nb[0] == 1){
                //<input name="user_active_col[]" type="checkbox" value="1">
                echo "<td><input type=\"radio\" name=\"rdio_ccc\" value=\"".$nb[0]."\" checked=\"checked\" /></td>";
              }else{
                echo "<td><input type=\"radio\" name=\"rdio_ccc\" value=\"".$nb[0]."\" /></td>";
              }
              */
              echo "</tr>\n";
            }
            echo "</table>\n";
          }
        
        
        ?>

        
        <input type="radio" name="rdio" value="option2" checked="checked" />
        Option 2: Create a new names committee.<br>
        Select nomenclature level:&nbsp <select id="first" name="first" size="1"><option value="">--</option></select><br><br>
        Account name::&nbsp <select id="second" name="second" size="1"><option value="">--</option></select><br><br>
        <button id="selectListButton">Select this account</button>
        <div id="sendMessageOutput"></div>

        <form id="form" action="itcstep3.php" method="post">
          <table>
            <tr>
              <td colspan=2>
                <input id="users" name="users" type="hidden" value="<?php echo $users; ?>"/>
                <input id="accounts" name="accounts" type="hidden" />
                <input id="option" name="option" type="hidden" />
              </td>
            </tr>
            <tr>
              <td colspan=2><input name="submit_button" id="submit_button" type="submit" value="Go to Step 3" /></td>
            </tr>                        
          </table>
        </form>
      </div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
  </body>
</html>