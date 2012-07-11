<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 13, 2009 Friday:: Change with change log
  //Jan 13, 2010 Wednesday:: Big modification on name list manipulation
  // ./ current directory
  // ../ up level directory
  header("Cache-control: private");
  session_cache_limiter("none");
  session_start();
  if(!isset($_SESSION['rows_of_per_page'])){
    $_SESSION['rows_of_per_page'] = 10;
  }
  
  include('template/dbsetup.php');
  require('inc/config.inc.php');
  //Restrict admin to access to this page
  // 
  $lv = htmlspecialchars($_GET['lv'],ENT_QUOTES);
  //echo "Level is :: ".$users."<br>\n";
  $id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "ID is :: ".$id."<br>\n";
  $pid = htmlspecialchars($_GET['pid'],ENT_QUOTES);
  //echo "pid is :: ".$id."<br>\n";

  if( $lv == "" && $id == "" && $pid == "" ){
    echo "Null Pointer!\n";
    exit;
  }
  
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);

  $taxon_name = taxon_name($lv, $id);
  //echo $taxon_name;
  
  $caption = $application_caption;
  $caption2 = "Name List Manipulation on Taxon: ".$taxon_name;  
  $title = $caption."::".$caption2;
  $content = "Edit the Taxon Data.";
  

  
  $table_name = $_SESSION['table_name'];
  //echo $_SESSION['table_name'];
  
  $form_1 = array();
  $form_2 = array();
  $sql = "";
  if( $table_name == "Family" ){
    $sql = "SELECT * FROM flist WHERE fid ='".$id."'";
    $form_2 = array("ID", "Kingdon",	"Phylum",	"Superclass",	"Class", "Subclass",	"Infraclass",	"Superorder",	"Order",	"Suboder",	"Superfamily",	"Family",	"Common name 1",	"Common name 2",	"Common name 3");
    //$form_2 = array('Kingdon',	'Phylum',	'Superclass',	'Class',	'Subclass',	'Infraclass',	'Superorder',	'Order',	'Suboder',	'Superfamily',	'Family',	'Common name 1',	'Common name 2',	'Common name 3');
  }elseif( $table_name == "Genus" ){
    $sql = "SELECT * FROM glist WHERE gid ='".$id."'";
    $form_2 = array("ID", "Family", "Genus", "ReferenceID");
  }elseif( $table_name == "Species" ){
    $sql = "SELECT * FROM slist WHERE sid ='".$id."'";
    $form_2 = array("ID", "Family", "Genus", "Species", "Author", "Locality", "Common Name1", "Common Name2", "Common Name3", "State");
    //sid 	sfamily 	sgenus 	sspecies 	sauthor 	sloc 	scnam1 	scnam2 	scnam3 	state
  }
  //echo "sql is ".$sql."/n<br>";
  $result = mysql_query($sql);
  
  
  if(mysql_num_rows($result) > 0){
    while ( $nb = mysql_fetch_array($result) ) {
      //echo "Size of Array nb is :: ".sizeof($nb)."<br>\n";
      for($i=0; $i < (sizeof($nb)/2); $i++){
        //echo $i." is ".$nb[$i]."<br>\n";
        $form_1[$i] = $nb[$i];
      }
      
      /*
      if( $table_name == "family" ){


      }elseif( $table_name == "genus" ){
        $gfamily = $nb[1];
        $ggenus = $nb[2];
        $grefid = $nb[3];
      }elseif( $table_name == "species" ){
        $sfamily = $nb[1];
        $sgenus = $nb[2];
        $sspecies = $nb[3];
        $sauthor = $nb[4];
        $sloc = $nb[5];
        $scnam1 = $nb[6];
        $scnam2 = $nb[7];
        $scnam3 = $nb[8];
      }
      */
    }
  }

  //List the post information here!
  //List the post information here!
  $sql = "";
  if($pid != ""){
    //
    $sql = "SELECT * FROM post WHERE pid= '".$pid."'";
  }else{
    echo "Null Pointer!\n";
    exit;
  }
  /*
  elseif($username != ""){
    //
    $sql_get_uid = "SELECT uid FROM user WHERE username ='".$username."'";
    $result_sql_get_uid = mysql_query($sql_get_uid);
    //echo "sql_get_uid is ".$sql_get_uid;
    $uid = mysql_result($result_sql_get_uid, 0);    
    $sql = "SELECT * FROM post WHERE prefuid= '".$uid."'";
  }
  */
  
    
  //echo "<BR>sql is ".$sql;
  
  $result = mysql_query($sql);
  
  //$sid = "";
  $prefsid = "";
  $prreflv = "";
  
  if( mysql_num_rows($result) > 0 ){  
    while ( $nb2 = mysql_fetch_array($result) ) {
		  //$sid = $nb2[6];
		  $prefsid = $nb2[6];
		  $preflv = $nb2[5];
		  
		  
      //$table .= "<p>Create Time:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$nb2[3]."</p>";//create time
      //$table .= "<p>Title:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>".$nb2[1]."</b></p>";//title
      $replyTitle = $nb2[1];
      //$table .= "<p>Content:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$nb2[2]."</p>";// full content
      
      $table .= "<font color=\"gray\">".$nb2[3]."</font><BR>";//Time
      $table .= "<h3><B><font color=\"black\">Topic: ".$nb2[1]."</font></B></h3>";//Title
      
      //$post_author_name = "";
      /*
      if( $nb2[4] == 0){
        $post_author_name = "admin";
      }else{
        $sql2 = "SELECT name FROM user WHERE uid ='".$nb2[4]."'";
        $result2 = mysql_query($sql2);
        //echo "sql2 is ".$sql2;
        $post_author_name = mysql_result($result2, 0);
      }
      */

      $sql_post_author_username = "SELECT username FROM user WHERE uid ='".$nb2[4]."'";
      $result_sql_post_author_username = mysql_query($sql_post_author_username);
      //echo "sql_post_author_username is ".$sql_post_author_username;
      $post_author_username = mysql_result($result_sql_post_author_username, 0);
      
      $sql_post_author_name = "SELECT name FROM user WHERE uid ='".$nb2[4]."'";
      $result_sql_post_author_name = mysql_query($sql_post_author_name);
      //echo "sql_post_author_name is ".$sql_post_author_name;
      $post_author_name = mysql_result($result_sql_post_author_name, 0);

      $table .= "<B><font color=\"blue\"><a href=\"viewpostlist.php?username=".$post_author_username."\">".$post_author_name."</a></font></b><BR>";//Posted by Author
      $table .= "<font color=\"black\">".$nb2[2]."</font><BR>";//Post Content            
	  }

	}else{
	  //echo $sql;
	  $table .= "<p>Currently, there are no post right now.</p>"; //no records here
	  //Header("location:authorizedFail.php");
  }
  
  //Comments

  $sql_counter = "SELECT COUNT(*) FROM comment WHERE crefpid= '".$nb2[0]."' AND comment_type = '0'";
  //echo "sql_counter is ".$sql_counter;
  $result_sql_counter = mysql_query($sql_counter);
  $commentCount = mysql_result($result_sql_counter, 0);
      
  $table .= "<h3><B>Comments: <font color=\"blue\">".$commentCount."</font></B></h3>";//Comment Counter
  //$table .= "<B>".$name."</B> at <B>".$nb2[3]."</B> Post | Comment (<B>".$commentCount."</B>)<BR><BR>";
  //$table .= "<hr NOSHADE>"; 
  
  $sql = "SELECT * FROM comment WHERE crefpid= '".$pid."' AND comment_type ='0'";  
  //echo "<BR>sql is ".$sql;
  
  $result = mysql_query($sql);
  
  //$table .= "<h2><p>Comment</p></h2>";
  
  if( mysql_num_rows($result) > 0 ){  
    $commentCounter = 0;
    while ( $nb2 = mysql_fetch_array($result) ) {
		  $commentCounter += 1;
      
      $commentor_username = "";
      $commentor_name = "";
      $sql_select_user_name = "SELECT * FROM user WHERE uid='".$nb2[4]."'";
      $result_sql_select_user_name = mysql_query($sql_select_user_name);
      if( mysql_num_rows($result_sql_select_user_name) > 0 ){
        while ( $nb3 = mysql_fetch_array($result_sql_select_user_name) ) {
          //
          //$user_name = $nb3[3];
          $commentator_username = $nb3[1];
          $commentator_name = $nb3[3];
        }
      }
      $table .= "<font color=\"blue\"><a href=\"viewpostlist.php?username=".$commentator_username."\">".$commentator_name."</a></font> commented on: <BR>";//Posted by Author
      
      $table .= "<b><font color=\"black\">".$nb2[1]."</font></b><br>";//Title
      $table .= "<font color=\"black\">".$nb2[2]."</font><BR>";//Post Content
      $table .= "<font color=\"gray\">".$nb2[3]."</font><BR><BR>";//Time
      
      /*
      $table .= "<p><b>".$nb2[1]."</b></p>";//ctitle
      $table .= "<p>".$nb2[2]."</p>";// full ccontent
      //$table .= "<p><a href=\detail.php?pid=".$nb2[0]."\">More</a><BR><BR>";
      $table .= "<B>".$nb2[5]."</B> at <B>".$nb2[3]."</B> Comment<BR><BR>";
      //$table .= "<hr NOSHADE>";
      */
	  }
	}else{
	  //echo $sql;
	  //$table .= "<p>Currently, there are no comments at this post.</p>"; //no records here
  }
  
  //Review Opinions

  $sql_counter = "SELECT COUNT(*) FROM comment WHERE crefpid= '".$nb2[0]."' AND comment_type = '1'";
  //echo "sql_counter is ".$sql_counter;
  $result_sql_counter = mysql_query($sql_counter);
  $commentCount = mysql_result($result_sql_counter, 0);
      
  $table .= "<h3><B>Review Opinions: <font color=\"blue\">".$commentCount."</font></B></h3>";//Comment Counter
  //$table .= "<B>".$name."</B> at <B>".$nb2[3]."</B> Post | Comment (<B>".$commentCount."</B>)<BR><BR>";
  //$table .= "<hr NOSHADE>"; 
  
  $sql = "SELECT * FROM comment WHERE crefpid= '".$pid."' AND comment_type ='1'";  
  //echo "<BR>sql is ".$sql;
  
  $result = mysql_query($sql);
  
  //$table .= "<h2><p>Comment</p></h2>";
  
  if( mysql_num_rows($result) > 0 ){  
    $commentCounter = 0;
    while ( $nb2 = mysql_fetch_array($result) ) {
		  $commentCounter += 1;
      
      $commentor_username = "";
      $commentor_name = "";
      $sql_select_user_name = "SELECT * FROM user WHERE uid='".$nb2[4]."'";
      $result_sql_select_user_name = mysql_query($sql_select_user_name);
      if( mysql_num_rows($result_sql_select_user_name) > 0 ){
        while ( $nb3 = mysql_fetch_array($result_sql_select_user_name) ) {
          //
          //$user_name = $nb3[3];
          $commentator_username = $nb3[1];
          $commentator_name = $nb3[3];
        }
      }
      $table .= "<font color=\"blue\"><a href=\"viewpostlist.php?username=".$commentator_username."\">".$commentator_name."</a></font> commented on: <BR>";//Posted by Author
      
      $table .= "<b><font color=\"black\">".$nb2[1]."</font></b><br>";//Title
      $table .= "<font color=\"black\">".$nb2[2]."</font><BR>";//Post Content
      $table .= "<font color=\"gray\">".$nb2[3]."</font><BR><BR>";//Time
      
      /*
      $table .= "<p><b>".$nb2[1]."</b></p>";//ctitle
      $table .= "<p>".$nb2[2]."</p>";// full ccontent
      //$table .= "<p><a href=\detail.php?pid=".$nb2[0]."\">More</a><BR><BR>";
      $table .= "<B>".$nb2[5]."</B> at <B>".$nb2[3]."</B> Comment<BR><BR>";
      //$table .= "<hr NOSHADE>";
      */
	  }
	}else{
	  //echo $sql;
	  //$table .= "<p>Currently, there are no comments at this post.</p>"; //no records here
  }

  
  //Decision Suggestions

  $sql_counter = "SELECT COUNT(*) FROM comment WHERE crefpid= '".$nb2[0]."' AND comment_type = '1'";
  //echo "sql_counter is ".$sql_counter;
  $result_sql_counter = mysql_query($sql_counter);
  $commentCount = mysql_result($result_sql_counter, 0);
      
  $table .= "<h3><B>Decision Suggestions: <font color=\"blue\">".$commentCount."</font></B></h3>";//Comment Counter
  //$table .= "<B>".$name."</B> at <B>".$nb2[3]."</B> Post | Comment (<B>".$commentCount."</B>)<BR><BR>";
  //$table .= "<hr NOSHADE>"; 
  
  $sql = "SELECT * FROM comment WHERE crefpid= '".$pid."' AND comment_type ='2'";  
  //echo "<BR>sql is ".$sql;
  
  $result = mysql_query($sql);
  
  //$table .= "<h2><p>Comment</p></h2>";
  
  if( mysql_num_rows($result) > 0 ){  
    $commentCounter = 0;
    while ( $nb2 = mysql_fetch_array($result) ) {
		  $commentCounter += 1;
      
      $commentor_username = "";
      $commentor_name = "";
      $sql_select_user_name = "SELECT * FROM user WHERE uid='".$nb2[4]."'";
      $result_sql_select_user_name = mysql_query($sql_select_user_name);
      if( mysql_num_rows($result_sql_select_user_name) > 0 ){
        while ( $nb3 = mysql_fetch_array($result_sql_select_user_name) ) {
          //
          //$user_name = $nb3[3];
          $commentator_username = $nb3[1];
          $commentator_name = $nb3[3];
        }
      }
      $table .= "<font color=\"blue\"><a href=\"viewpostlist.php?username=".$commentator_username."\">".$commentator_name."</a></font> commented on: <BR>";//Posted by Author
      
      $table .= "<b><font color=\"black\">".$nb2[1]."</font></b><br>";//Title
      $table .= "<font color=\"black\">".$nb2[2]."</font><BR>";//Post Content
      $table .= "<font color=\"gray\">".$nb2[3]."</font><BR><BR>";//Time
      
      /*
      $table .= "<p><b>".$nb2[1]."</b></p>";//ctitle
      $table .= "<p>".$nb2[2]."</p>";// full ccontent
      //$table .= "<p><a href=\detail.php?pid=".$nb2[0]."\">More</a><BR><BR>";
      $table .= "<B>".$nb2[5]."</B> at <B>".$nb2[3]."</B> Comment<BR><BR>";
      //$table .= "<hr NOSHADE>";
      */
	  }
	}else{
	  //echo $sql;
	  //$table .= "<p>Currently, there are no comments at this post.</p>"; //no records here
  }
      
  //$table .= "<BR><BR><a href=\"showProposedChanges.php?sid=".$sid."\">Back to Proposed Changes OR Suggestted Name Changes List</a>";
  //$table .= "<BR><BR><a href=\"index.php\">Back to homepage</a>";  
    
  //List the post information here!
  //List the post information here!


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
    <meta name="Description" content="Saint Louis University, tissue, species information" />
    <meta name="Keywords" content="Saint Louis University, tissue, information" />
    <!--<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
		    //alert("Hello Elvis!");
        //$("#selectRows").click(function(){
		      //alert("Select Rows is :: " + );
        //});
        $("#selectListButton").click(function(){
          //alert("Hello Elvis!");
          var a = "";
          a = $('#post_id').val();
          //alert(a);
          <?php
            echo "var post_array = new Array();\n";
            echo "var post_array2 = new Array();\n";
            $sql_post_id = "SELECT * FROM post WHERE preflv='".$lv."' AND prefsid='".$id."'";
            //echo "sql_post_id is ".$sql_post_id."/n<br>";
            $result_sql_post_id = mysql_query($sql_post_id);
            $counter = 1;
            if(mysql_num_rows($result_sql_post_id) > 0){
              while ( $nb_sql_post_id = mysql_fetch_array($result_sql_post_id) ) {
                echo "post_array[$counter] = \"<a href=viewpost.php?pid=".$nb_sql_post_id[0].">".$nb_sql_post_id[1]."</a>\";\n";
                //echo "post_array[$counter] = \"Title:".$nb_sql_post_id[1]."\";\n";
                //echo "post_array2[$counter] = \"Content:".$nb_sql_post_id[1]."\";\n";
                $counter++;
              }
            }    
          ?>
          //var output_of_selected_taxon = "<B>The taxon entry/account you have already selected:</B><BR>"   
          //$('#selected_taxon').val(selected_taxon_account);
          
          //$('#post_detail').html(post_array[a]+ '<br>' + post_array2[a]);
          $('#post_detail').html(post_array[a]);
          
          //alert("Hello Elvis");
          //alert(output_of_selected_taxon + selected_taxon_account);
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
        <form id="updateForm" action="slist_chg2.php" method="post">
          <input name="id" type="hidden" value="<?php echo $id; ?>"/>
          <input name="reflv" type="hidden" value="<?php echo $lv; ?>"/>
          <table width="600">
            <tr>
              <td colspan=2><p>Name List</p></td>
            </tr>
<?php
  //echo "Size of Array form_1 is :: ".sizeof($form_1);
  
  for( $i = 1; $i < sizeof($form_1); $i++){
    echo "<tr>\n";
    echo "<td><label>".$form_2[$i]."</label></td>\n";
    echo "<td><input name=\"Post_".$i."\" type=\"text\" value=\"".$form_1[$i]."\"/></td>\n";
    echo "</tr>\n";
    //echo $form_2[$i]." = ".$form_1[$i]."<br>\n";
  }
  echo "<input name=\"sizeof_form\" type=\"hidden\" value=\"".sizeof($form_1)."\"/><br>\n"; 
?>
<!--
            <tr>
              <td ><label>Family</label></td>
              <td ><input name="sfamily" type="text" value="<?php echo $sfamily; ?>"/></td>
            </tr>
            <tr>
              <td ><label>Genus</label></td>
              <td ><input name="sgenus" type="text" value="<?php echo $sgenus; ?>" /><br></td>
            </tr>
            <tr>
              <td ><label>Species</label></td>
              <td ><input name="sspecies" type="text" value="<?php echo $sspecies; ?>" /><br></td>
            </tr>
            <tr>
              <td ><label>Author</label></td>
              <td ><input name="sauthor" type="text" value="<?php echo $sauthor; ?>" /><br></td>
            </tr>
            <tr>
              <td ><label>Locality</label></td>
              <td ><input name="sloc" type="text" value="<?php echo $sloc; ?>" /><br></td>
            </tr>                                                
            <tr>
              <td ><label>Common Name1</label></td>
              <td ><input name="scnam1" type="text" value="<?php echo $scnam1; ?>" /><br></td>
            </tr>
            <tr>
              <td ><label>Common Name</label></td>
              <td ><input name="scnam2" type="text" value="<?php echo $scnam2; ?>" /><br></td>
            </tr>
            <tr>
              <td ><label>Common Name3</label></td>
              <td ><input name="scnam3" type="text" value="<?php echo $scnam3; ?>" /><br></td>
            </tr>
-->
            <tr>
              <td colspan="2" align="left"><label><b>Change Log</b></label></td>
            </tr>
            <tr>
              <td ><label>Change Note</label></td>
              <td ><textarea name="chg_note" col="100" row="100"></textarea><br></td>
            </tr>
            <tr>
              <td ><label>Reason</label></td>
              <td ><textarea name="rea" col="100" row="100"></textarea><br></td>
            </tr>
            <tr>
              <td ><label>Refer Post Id</label></td>
              <td ><input name="refpid" type="text" value="<?php echo $pid; ?>" readonly/><br></td>
            </tr>
            <tr>
              <td ><label>System Administrator Decision</label></td>
              <td >
                <select id="decision" name="decision">
                  <option value="Accept">Accept</option>
                  <option value="Reject">Reject</option>
                </select>              
              </td>
            </tr>           
            <tr>
              <td colspan=2><input type="submit" value="Change it!" /></td>
            </tr>
          </table>
        </form>
        <table>
          <tr>
            <td colspan=2>
              <select id="post_id" name="post_id">
              <?php
                $sql_post_id = "SELECT * FROM post WHERE preflv='".$lv."' AND prefsid='".$id."'";
                //echo "sql_post_id is ".$sql_post_id."/n<br>";
                $result_sql_post_id = mysql_query($sql_post_id);
                $counter = 1;
                if(mysql_num_rows($result_sql_post_id) > 0){
                  while ( $nb_sql_post_id = mysql_fetch_array($result_sql_post_id) ) {
                    echo "<option value=\"".$counter."\">".$nb_sql_post_id[0]."</option>\n";
                    $counter++;
                  }
                }                
              ?>
              </select>
              <button id="selectListButton"><font color="Red">View Other Posted Proposed Changes</font></button>
              <div id="post_detail"></div>
            </td>
          </tr> 
        </table>
        <hr>
        <B>The following are the posted proposed change and its comments and other review opinions and decision suggestions for System Administrator</B><BR> 
        <?php 
          echo $table;
        ?>              
      </div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
  </body>
</html>