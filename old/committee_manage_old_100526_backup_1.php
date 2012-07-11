<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 15, 2009 Sunday:: registered user view his belonging names committee 
  //Nov 17, 2009 Tuesday:: add function of editing names committees
  // ./ current directory
  // ../ up level directory
  header("Cache-control: private");
  session_cache_limiter("none");
  session_start();
  include('template/dbsetup.php');
  $caption = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes";
  $caption2 = "Names Committee Management";  
  $title = $caption."::".$caption2;
  $content = "Names Committee Management.";
  
  //$uid = htmlspecialchars($_SESSION['uid'],ENT_QUOTES);
  //echo "uid is :: ".$uid."<br>\n";
  
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  $role = $_SESSION['role'];
  if( $role != "admin"){
    Header("location:authorizedFail.php");
    exit();
  }


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
      <?php
        $sql_committee = "SELECT * FROM committee_grp"; 
        //echo "sql_committee_member is ::".$sql_committee."<br>\n";
        $result_sql_committee = mysql_query($sql_committee);
        if(mysql_num_rows($result_sql_committee) > 0){
          echo "<table border=\"1\"><tr><td>Id</td><td>Name</td><td>Note</td><td>Related Taxon Account</td><td>Users who is belonging to this Names Committee</td><td>Edit Names Committee</td></tr>";
          while ( $nb2 = mysql_fetch_array($result_sql_committee) ) {
            echo "<tr>";
            echo "<td>".$nb2[0]."</td>";//group_id
            echo "<td>".$nb2[1]."</td>";//committee_name
            echo "<td>".$nb2[2]."</td>";//misc_note
            //Related taxon acoount
            $sql_committee_table_account = "SELECT * FROM committee_account WHERE ref_c_id = ".$nb2[0];    
            $result_sql_committee_table_account = mysql_query($sql_committee_table_account);
            echo "<td>";
            if(mysql_num_rows($result_sql_committee_table_account) > 0){
              while ( $nb3 = mysql_fetch_array($result_sql_committee_table_account) ) {
                $sql_account_name = "";
                $lv = $nb3[1];
                $id = $nb3[2];
                if($nb3[1] == "family"){
                  $sql_account_name = "SELECT ffamily FROM flist WHERE fid =".$nb3[2];
                }elseif($nb3[1] == "genus"){
                  $sql_account_name = "SELECT ggenus FROM glist WHERE gid =".$nb3[2];
                }elseif($nb3[1] == "species"){
                  $sql_account_name = "SELECT sgenus,sspecies FROM slist WHERE sid =".$nb3[2];
                }
                $result_sql_account_name = mysql_query($sql_account_name);
                $account_name = "";
                if(mysql_num_rows($result_sql_account_name) > 0){
                  while ( $nb4 = mysql_fetch_array($result_sql_account_name) ) {
                    if($nb3[1] == "species"){
                      $account_name = "<i>".$nb4[0]." ".$nb4[1]."</i>";
                    }else{
                      $account_name = $nb4[0];
                    }
                  }
                }
                echo "Level: <a href=\"viewtaxon.php?lv=".$lv."&id=".$id."\">".$nb3[1].":".$account_name."</a><br>";
              }
            }
            echo "</td>";
            //Related user
            $sql_committee_table_user = "SELECT * FROM committee_member WHERE ref_c_id = ".$nb2[0];
            $result_sql_committee_table_user = mysql_query($sql_committee_table_user);
            echo "<td>";
            if(mysql_num_rows($result_sql_committee_table_user) > 0){
              while ( $nb5 = mysql_fetch_array($result_sql_committee_table_user) ) {
                $sql_user_name = "SELECT * FROM user WHERE uid =".$nb5[1];
                $result_sql_user_name = mysql_query($sql_user_name);
                if(mysql_num_rows($result_sql_user_name) > 0){
                  while ( $nb6 = mysql_fetch_array($result_sql_user_name) ) {
                    echo "<a href=\"viewUserProfile.php?uid=".$nb6[0]."\">".$nb6[3]."</a><br>\n";
                  }
                }
              }
            }
            echo "</td>";            
            echo "<td><a href=\"committee_chg.php?id=".$nb2[0]."\">Edit it</a></td>";
            echo "</tr>";
          }
          echo "</table>";
        }else{
          echo "There are no data in TABLE:: committee_grp!<br>\n";
        }
        echo "<a href=\"committee_create.php\">Create a new Names Committee?</a><br>\n"
      ?>
      </div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
  </body>
</html>