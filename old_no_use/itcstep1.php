<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Oct 19, 2009 Monday:: system administrator invite registered users to names committee step 1
  //Jan 26, 2010 Tuesday:: add template code section, and add a javascript tp prevent to unll selection
  // ./ current directory
  // ../ up level directory
  
  //header("Cache-control: private");
  //session_cache_limiter("none");

  //$content = "Step 1: Select one or more users.";
    
  //$uid = htmlspecialchars($_GET['uid'],ENT_QUOTES);
  
  //$loginname;
  //$password;
  //$real_name;
  //$org;
  //$tel;
  //$fax;
  //$eml;

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
  //$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "ID is :: ".$."<br>\n";
  //Configuration of POST and GET Variables
    
  $caption = $application_caption;
  $caption2 = "System Administrator Invite Registered Users to Names Committee Step 1<BR>";
  $caption2 .= "<font color=\"Red\">STEP1: Select user first</font><BR>";
  $caption2 .= "STEP2: Select Names Committee or Taxon<BR>";
  $caption2 .= "STEP3: Send Invitation to user<BR>";
  $caption2 .= "STEP4: Send invitation!<BR>";
  $title = $application_caption."::".$caption2;
  //template  
  

  $sql = "SELECT * FROM user";
  //echo "sql is ".$sql."/n<br>";
  $result_sql = mysql_query($sql);
  $select_box_text = "";
  if(mysql_num_rows($result_sql) > 0){
    while ( $nb_sql = mysql_fetch_array($result_sql) ) {
      //echo $nb[0]."<br>\n";
      $select_box_text .= "<option value=\"".$nb_sql[0]."\">".$nb_sql[3]."</option>\n";
    }
  }
  //echo $select_box_text;
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
	</head>
  <body id="dt_example">
		<div id="container">	
			<h1><? echo $caption; ?></h1>
      <?php
        include("menu.php");
      ?>
      <h2><?php echo $caption2; ?></h2>
      <div id="demo">
<select id="selectList">
<?php
  echo $select_box_text;
?>
</select>
<button id="selectListButton1">Select this User</button>
<button id="selectListButton2">View User Profile</button></p>
<script type="text/javascript">
$(document).ready(function(){
  <?php
    echo "var profile_array = new Array();\n";
    echo "var profile_name_array = new Array();\n";
    echo "var profile_id_array = new Array();\n";
    
    $sql2 = "SELECT * FROM user";
    //echo "sql2 is ".$sql2."/n<br>";
    $result_sql2 = mysql_query($sql2);
    $profile_text = "";
    $counter = 0;
    if(mysql_num_rows($result_sql2) > 0){
      while ( $nb_sql2 = mysql_fetch_array($result_sql2) ) {
        echo "profile_id_array[$counter] = \"".$nb_sql2[0]."\";\n";
        echo "profile_name_array[$counter] = \"".$nb_sql2[3]."\";\n";
        echo "profile_array[$counter] = \"<B>Name: </B>".$nb_sql2[3]."<br><B>Address: </B>".$nb_sql2[4]."<br><B>Tel: </B>".$nb_sql2[5]."<br><B>Fax: </B>".$nb_sql2[6]."<br><B>Email: </B>".$nb_sql2[7]."<br><B>Web: </B>".$nb_sql2[8]."<br><B>Region: </B>".$nb_sql2[9]."\";\n";
        $counter++;
      }
    }
    echo "var profile_length = ".$counter.";\n";
  ?>


	var a = "";
  //var a = new Array();
  $("#selectListButton1").click(function(){
		//alert(a.length);
    if(a.length == 0 ){
      //a[0] = $('#selectList').val()+",";
      a += $('#selectList').val();
    }else{
      //a[a.length+1] = $('#selectList').val();
      var splitResult = a.split(",");
      //alert(splitResult.length);
      ///*
      var match = $('#selectList').val();
      var isNew = true;
      for (var i =0; i< (splitResult.length); i++){
        //alert("splitResult[i] is " + splitResult[i]);
        //alert("$('#selectList').val() is " + $('#selectList').val());
        if(match == splitResult[i]){
          isNew = false;
        }
      }
      if( isNew == true){
        a += "," + $('#selectList').val();
      }
    }
		//a = a.substring(0,(a.length)-1); 
    
    var output_selected = "";
    var split_selected_array = a.split(",");
    ///*
    for(var i=0; i<split_selected_array.length; i++){
      for(var j=0; j<profile_id_array.length; j++){
        if(split_selected_array[i] == profile_id_array[j]){
          if(i == 0){
            output_selected += profile_name_array[j];
          }else{
            output_selected += "," + profile_name_array[j];
          }
          
        }
      }
    }
    //*/
    
    var sendMessage_output = "<B>You have already selected the following users:</B><BR>"
    //$('#sendMessage').html(sendMessage_output + a + "<BR>" + output_selected);
    //$('#sendMessage').html("<input name=\"users\" type=\"hidden\" value=\"" + a + "\"/>");
    
    /* set input valuse via jQuery AJAX behavior*/
    //$("#users").attr("value", a);
    $('#users').val(a);
    /* set input valuse via jQuery AJAX behavior*/

    $('#sendMessageOutput').html(sendMessage_output + output_selected);
	});
	$("#selectListButton2").click(function(){
		//alert( 'Text is: ' + $('#selectList :selected').text() );

    var output_profile = "";
    for(var j=0; j<profile_length; j++){
      //alert("profile_name_array[i] is " + profile_name_array[i]);
      //alert("$('#selectList :selected').text() is " + $('#selectList :selected').text());
      if(profile_name_array[j] == $('#selectList :selected').text()){
        output_profile += profile_array[j];
      }
    }
    //$('#viewUserProfile').html($('#selectList :selected').text());
    $('#viewUserProfile').html("<hr><B>View User Profile: </B><br>" + output_profile);
	});

	$("#submit_button").click(function(){
		if( $('#users').val() =="" ) {
      alert("You need to select at least one user");
      return false;
    }

	});
	
});
</script>
        <form id="form" action="itcstep2.php" method="post">
          <table>
            <tr>
              <td colspan=2><input id="users" name="users" type="hidden" /></td>
            </tr>
            <tr>
              <td colspan=2><input name="submit_button" id="submit_button" type="submit" value="Go to Step 2" /></td>
            </tr>                        
          </table>
        </form>
        <div id="sendMessageOutput"></div>
        <div id="viewUserProfile"></div>
      </div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
  </body>
</html>