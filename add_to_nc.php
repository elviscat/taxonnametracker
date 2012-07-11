<?php
  //Developed by elviscat (elviscat@gmail.com)
  //Jan 28, 2010 Friday::New design
  //./ current directory
  // ../ up level directory
  //!?!?

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
  
  //Customized section of view_sa_reminder.php
  if( !isset($_SESSION['is_login']) ){
    Header("location:loginFail.php");
    exit();
  }
  //echo "Session of role is :: ".$_SESSION['role']."<br>\n";
  

  //Customized section of view_sa_reminder.php
  //Customized section of view_sa_reminder.php

  //Configuration of POST and GET Variables
  $selection2 = htmlspecialchars($_POST['selection2'],ENT_QUOTES);
  $selection2 = substr($selection2, 0, -1);
  //echo "Variable selection2 is :: ".$selection2."<br>\n";
   
  //Configuration of POST and GET Variables
    
  $caption = $application_caption;
  $caption2 = "Add Selected Taxa to a Names Committee:<BR>";
  $caption2 .= taxa_name($selection2);   
  $title = $caption."::".$caption2;
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
        //
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
        <form id="form" action="add_to_nc2.php" method="post">
        
        <input type="hidden" id="selection2" name="selection2" value="<?php echo $selection2; ?>" />
        
        <input type="radio" id="option" name="option" value="1" />
        Option 1: Add to existing names committee.<br>
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
              if( $nb[0] == '1'){
                echo "<td><input type=\"radio\" id=\"committee_id\" name=\"committee_id\" value=\"".$nb[0]."\"  checked=\"checked\"></input></td>";
              }else{
                echo "<td><input type=\"radio\" id=\"committee_id\" name=\"committee_id\" value=\"".$nb[0]."\"></input></td>";
              }

              echo "</tr>\n";
            }
            echo "</table>\n";
          }else{
            echo "<b>Now, there is no existing names committee.</b><br>\n";
          }
        
        
        ?>

        
        <input type="radio" id="option" name="option" value="2" checked="checked" />
        Option 2: Create a new Names Committee and Add Taxa to.<br>
          <table>
            <tr>
              <td>Names Committee Name</td>
              <td><input id="committee_name" name="committee_name" type="text"/></td>
            </tr>
            <tr>
              <td>Names Committee Note</td>
              <td><input id="committee_note" name="committee_note" type="text" /></td>
            </tr>
            <tr>
              <td colspan=2><input name="submit_button" id="submit_button" type="submit" value="Submit" /></td>
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










