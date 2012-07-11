<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 13, 2009 Friday:: Change with change log
  // ./ current directory
  // ../ up level directory
  header("Cache-control: private");
  session_cache_limiter("none");
  session_start();
  if(!isset($_SESSION['rows_of_per_page'])){
    $_SESSION['rows_of_per_page'] = 10;
  }
  
  include('template/dbsetup.php');
  
  //Restrict admin to access to this page
  // 
  
  $caption = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes";
  $caption2 = "Edit the Taxon Data";  
  $title = $caption."::".$caption2;
  $content = "Edit the Taxon Data.";
  
  $lv = htmlspecialchars($_GET['lv'],ENT_QUOTES);
  //echo "Level is :: ".$users."<br>\n";
  $id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "ID is :: ".$id."<br>\n";

  if( $lv == "" && $id == ""){
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
                echo "post_array[$counter] = \"Title:".$nb_sql_post_id[1]."\";\n";
                echo "post_array2[$counter] = \"Content:".$nb_sql_post_id[1]."\";\n";
                $counter++;
              }
            }    
          ?>
          //var output_of_selected_taxon = "<B>The taxon entry/account you have already selected:</B><BR>"   
          //$('#selected_taxon').val(selected_taxon_account);
          $('#post_detail').html(post_array[a]+ '<br>' + post_array2[a]);
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
          <table>
            <tr>
              <td colspan=2><p>Please fill out the following information</p></td>
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
              <td colspan="2" align="center"><label>Change Log</label></td>
            </tr>
            <tr>
              <td ><label>Reason</label></td>
              <td ><textarea name="rea" col="25" row="10"></textarea><br></td>
            </tr>
            <tr>
              <td ><label>Refer Post Id</label></td>
              <td ><input name="refpid" type="text" /><br></td>
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
              <button id="selectListButton">View Post Detail</button>
              <div id="post_detail"></div>
            </td>
          </tr> 
        </table>      
      </div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
  </body>
</html>