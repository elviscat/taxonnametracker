<?php

  //Developed by elviscat (elviscat@gmail.com)
  //Previous development records are lost
  //Start from now
  //Jan 14, 2010 Thursday:: Layout and logic modification
  //Jan 26, 2010 Tuesday:: Layout and logic modification
  // ./ current directory
  // ../ up level directory
  
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
  //$caption2 = "Homepage of Taxon Tracker";
  $caption2 = "";
  $title = $caption."::".$caption2;
  //template 
  

  
  $sql_1 = "SELECT * FROM post ORDER BY pcredate DESC Limit 5";
  $sql_2 = "SELECT * FROM user ORDER BY regtime DESC Limit 5";
  $sql_3 = "SELECT COUNT(*) FROM slist";
  $sql_4 = "SELECT COUNT(*) FROM user";
  //echo $sql_1;
  //echo $sql_2;
  //echo $sql_3;
  //echo $sql_4;
  
  $table_1 = "";
  $result_1 = mysql_query($sql_1);
  if(mysql_num_rows($result_1) > 0){
    $table_1 .= "<table>\n";
    while ( $nb_1 = mysql_fetch_array($result_1) ) {
      $lv = $nb_1[5];
      $id = $nb_1[6];
      
      //echo "id is :: ".$id."<br>\n";
      //echo "lv is :: ".$lv."<br>\n";
      $sql_account_name = "";
      if($lv == "family"){
        $sql_account_name = "SELECT ffamily FROM flist WHERE fid =".$id;
      }elseif($lv == "genus"){
        $sql_account_name = "SELECT ggenus FROM glist WHERE gid =".$id;
      }elseif($lv == "species"){
        $sql_account_name = "SELECT sgenus,sspecies FROM slist WHERE sid =".$id;
      }
      //echo "sql_account_name is :: ".$sql_account_name."<br>\n";
      $result_sql_account_name = mysql_query($sql_account_name);
      $account_name = "";
      if(mysql_num_rows($result_sql_account_name) > 0){
        while ( $nb = mysql_fetch_array($result_sql_account_name) ) {
          if($lv == "species"){
            $account_name = "<i>".$nb[0]." ".$nb[1]."</i>";
          }else{
            $account_name = $nb[0];
          }
        }
      }      
      $table_1 .= "<tr>\n";
      $sci_name = "";
      $user_name = "";
      //$sub_sql = "SELECT * FROM slist WHERE sid = '".$nb_1[5]."'";
      //$sub_result = mysql_query($sub_sql);
      //if(mysql_num_rows($sub_result) > 0){
        //while ( $sub_nb = mysql_fetch_array($sub_result) ) {
          //$sci_name =  $sub_nb[2]." ".$sub_nb[3];
        //}
      //}else{
        //$sci_name =  "No scientific name!";
      //}
      //$sci_name = $account_name."(Level:".ucwords($lv).")";
      $sci_name = $account_name;
      
      $sub_sql = "SELECT * FROM user WHERE uid = '".$nb_1[4]."'";
      $sub_result = mysql_query($sub_sql);
      if(mysql_num_rows($sub_result) > 0){
        while ( $sub_nb = mysql_fetch_array($sub_result) ) {
          $user_name =  $sub_nb[3];
        }
      }else{
        $user_name =  "No user name!";
      }      
      //$table_1 .= "<a href=\"viewpost.php?pid=".$nb_1[0]."\"><i>".$sci_name."</i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$nb_1[3]."&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"viewUserProfile.php?uid=".$nb_1[4]."\">".$user_name."</a><br>";
      $table_1 .= "<td><a href=\"viewpost.php?pid=".$nb_1[0]."\"><i>".$sci_name."</i></a></td>";
      //$table_1 .= "<td>".$nb_1[1]."</td>";
      $table_1 .= "<td>".substr($nb_1[3], 0, 10)."</td>";
      $table_1 .= "<td><a href=\"viewUserProfile.php?uid=".$nb_1[4]."\">".$user_name."</a></td>";
      $table_1 .= "</tr>\n";
      
    }
    $table_1 .= "</table>\n";
  }else{
      $table_1 = "There is no data right now!";
  }

  $table_2 = "";
  $result_2 = mysql_query($sql_2);
  if(mysql_num_rows($result_2) > 0){
    while ( $nb_2 = mysql_fetch_array($result_2) ) {
      $table_2 .= "<a href=\"viewUserProfile.php?uid=".$nb_2[0]."\">".$nb_2[3]."</a><br>";
    }
  }else{
      $table_2 = "There is no data right now!";
  }
  
  $numOfspecies = "";
  $result_3 = mysql_query($sql_3);
  if(mysql_num_rows($result_3) > 0){
    while ( $nb_3 = mysql_fetch_array($result_3) ) {
      $numOfspecies = $nb_3[0];
    }  
  }else{
      $numOfspecies = 0;
  }
  
  $numOfuser = "";
  $result_4 = mysql_query($sql_4);
  if(mysql_num_rows($result_4) > 0){
    while ( $nb_4 = mysql_fetch_array($result_4) ) {
      $numOfuser = $nb_4[0];
    }  
  }else{
      $numOfuser = 0;
  }
  mysql_close($link);
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>Taxon Tracker</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->

	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="/jquery/jquery.accordion.js"></script>

	<script type="text/javascript">
	jQuery().ready(function(){
		// simple accordion
		jQuery('#list1a').accordion();

	});
	</script>

<style type="text/css"> 
<!-- 
body  {
	/*font: 100% Verdana, Arial, Helvetica, sans-serif;*/
	font: 80%/1.45em "Lucida Grande", Verdana, Arial, Helvetica, sans-serif;
  background: #FFFFFF;
	margin: 0; /* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
	padding: 0;
	text-align: center; /* this centers the container in IE 5* browsers. The text is then set to the left aligned default in the #container selector */
	color: #000000;
}
.twoColLiqLtHdr #container { 
	width: 80%;  /* this will create a container 80% of the browser width */
	background: #FFFFFF;
	margin: 0 auto; /* the auto margins (in conjunction with a width) center the page */
	/*border: 1px solid #000000;*/
	text-align: left; /* this overrides the text-align: center on the body element. */
} 
.twoColLiqLtHdr #header {
	background: #FFFFFF;
	padding: 0 10px;  /* this padding matches the left alignment of the elements in the divs that appear beneath it. If an image is used in the #header instead of text, you may want to remove the padding. */
} 
.twoColLiqLtHdr #header h1 {
	margin: 0; /* zeroing the margin of the last element in the #header div will avoid margin collapse - an unexplainable space between divs. If the div has a border around it, this is not necessary as that also avoids the margin collapse */
	padding: 10px 0; /* using padding instead of margin will allow you to keep the element away from the edges of the div */
}

/* Tips for sidebar1:
1. since we are working in percentages, it's best not to use padding on the sidebar. It will be added to the width for standards compliant browsers creating an unknown actual width. 
2. Space between the side of the div and the elements within it can be created by placing a left and right margin on those elements as seen in the ".twoColLiqLtHdr #sidebar1 p" rule.
3. Since Explorer calculates widths after the parent element is rendered, you may occasionally run into unexplained bugs with percentage-based columns. If you need more predictable results, you may choose to change to pixel sized columns.
*/
.twoColLiqLtHdr #sidebar1 {
	float: left;
	width: 24%; /* since this element is floated, a width must be given */
	background: #FFFFFF; /* the background color will be displayed for the length of the content in the column, but no further */
	padding: 15px 0; /* top and bottom padding create visual space within this div  */
}
.twoColLiqLtHdr #sidebar1 h3, .twoColLiqLtHdr #sidebar1 p {
	margin-left: 10px; /* the left and right margin should be given to every element that will be placed in the side columns */
	margin-right: 10px;
}

/* Tips for mainContent:
1. the space between the mainContent and sidebar1 is created with the left margin on the mainContent div.  No matter how much content the sidebar1 div contains, the column space will remain. You can remove this left margin if you want the #mainContent div's text to fill the #sidebar1 space when the content in #sidebar1 ends.
2. to avoid float drop at a supported minimum 800 x 600 resolution, elements within the mainContent div should be 430px or smaller (this includes images).
3. in the Internet Explorer Conditional Comment below, the zoom property is used to give the mainContent "hasLayout." This avoids several IE-specific bugs.
*/
.twoColLiqLtHdr #mainContent { 
	margin: 0 20px 0 26%; /* the right margin can be given in percentages or pixels. It creates the space down the right side of the page. */
} 
.twoColLiqLtHdr #footer {
	padding: 0 10px; /* this padding matches the left alignment of the elements in the divs that appear above it. */
	background:#FFFFFF;
} 
.twoColLiqLtHdr #footer p {
	margin: 0; /* zeroing the margins of the first element in the footer will avoid the possibility of margin collapse - a space between divs */
	padding: 10px 0; /* padding on this element will create space, just as the the margin would have, without the margin collapse issue */
}

.twoColLiqLtHdr #container a {
	color: #0063DC;
	text-decoration: none;
}

.twoColLiqLtHdr #container a:hover {
	text-decoration: underline;
}

.twoColLiqLtHdr #container ul {
	color: #B0BED9;
}



/* Miscellaneous classes for reuse */
.fltrt { /* this class can be used to float an element right in your page. The floated element must precede the element it should be next to on the page. */
	float: right;
	margin-left: 8px;
}
.fltlft { /* this class can be used to float an element left in your page */
	float: left;
	margin-right: 8px;
}
.clearfloat { /* this class should be placed on a div or break element and should be the final element before the close of a container that should fully contain a float */
	clear:both;
    height:0;
    font-size: 1px;
    line-height: 0px;

/**/
.basic  {
	width: 260px;
	font-family: verdana;
	border: 1px solid black;
}
.basic div {
	background-color: #eee;
}

.basic p {
	margin-bottom : 10px;
	border: none;
	text-decoration: none;
	font-weight: bold;
	font-size: 10px;
	margin: 0px;
	padding: 10px;
}
.basic a {	
  cursor:pointer;
	display:block;
	padding:5px;
	margin-top: 0;
	text-decoration: none;
	font-weight: bold;
	font-size: 12px;
	color: black;
	background-color: #00a0c6;
	border-top: 1px solid #FFFFFF;
	border-bottom: 1px solid #999;
	
	background-image: url("AccordionTab0.gif");
	
}
.basic a:hover {
	
  background-color: white;
	background-image: url("AccordionTab2.gif");

}
.basic a.selected {
	
  color: black;
	background-color: #80cfe2;
	background-image: url("AccordionTab2.gif");
	
}
/**/

}
--> 
</style><!--[if IE]>
<style type="text/css"> 
/* place css fixes for all versions of IE in this conditional comment */
.twoColLiqLtHdr #sidebar1 { padding-top: 30px; }
.twoColLiqLtHdr #mainContent { zoom: 1; padding-top: 15px; }
/* the above proprietary zoom property gives IE the hasLayout it needs to avoid several bugs */
</style>
<![endif]--></head>

<body class="twoColLiqLtHdr">

<div id="container"> 
  <div id="header">
    <h1><img src="images/taxontracker.png" width="386" height="96" /></h1>
    <h1>North American Fishes & <i>Taxon Tracker</i></h1>
    <div align="center" ><?php
      include("menu.php");
    ?></div>
    <br>
    <br>
  <!-- end #header --></div>
  <div id="sidebar1">
    <div class="basic" style="float:left;" id="list1a">
      <p><a href="intro.php">- Introduction<a></p>
      <p><a href="using_tt.php">- Using Taxon Tracker</a></p>
      <p><a href="what_is_class.php">- What is a Classification?</a></p>
      <p><a href="what_is_sys.php">- What is Systematics?</a></p>
      <p><a href="what_is_taxonomy.php">- What is Taxonomy?</a></p>
      <hr>
      <p><a href="name_list.php">- Full Classification</a></p>
      <p><a href="taxonsearch.php">- Taxon Search</a></p>
      <p>- Search Taxon Changes</p>
      <p>- Recent Changes (&lt; 6 mo)</p>
      <p>- Recent Posts (&lt; 6 mo)</p>
      <p><a href="glossary.php">- Glossary</a></p>
      <p><a href="signup.php">- Register here</a></p>    
      <hr>
      <p>Recent proposed nomenclatural changes</p>
      <?php echo $table_1; ?>      
      <!--
      <a></a>
			<div>
				<p>
          <br/>
				</p>
			</div>
			-->
		</div>
  <!-- end #sidebar1 --></div>
  <div id="mainContent">
    <em>Taxon Tracker </em>is a  community resource offered to provide research and educational opportunities as  to the function of our biological classifications of biological diversity, how  these classifications are determined and developed, the rules underlying the  formation of scientific names and classifications, and a transparent forum for  researchers to announce and comment on new species descriptions, new  phylogenetic studies, and recent published recommended changes to a  classification.<br>
    Public  announcements of new evidence-based research and opinions regarding new species  and changes in nomenclature and biological classifications provides a  transparent arena for scientists to discuss and debate issues, if necessary,  and for others with a more limited understanding of the systematic and  taxonomic processes foundational to biological classifications to learn more  about the process by raising questions and following discussions.<br>
    <br>
    <em>Taxon Tracker</em> also  maintains a complete classification of the fishes of the Order Cypriniformes  and will eventually provide annotations for species as to the evidence, or lack  thereof, for our current classification of these fishes.
    Users are strongly encouraged use our  blogging capabilities to post new information on any taxonomic issues relating  to Cypriniformes fishes as well as raise comment on postings, raise questions  and provide opinions on taxa.
    All  postings are linked to one or more taxa to which the content applies, except in  cases where you report new species, new papers, and new findings relevant to  the taxonomy and classification of Cypriniformes fishes.
    Thus, users need to identify taxa in the  classification in advance of posting information.
    A full history of discussions is archived and  all evidenced based research recommending changes in the taxonomy are open for  public comment for six months.
    We also  provide a glossary of terms most frequently used in discussions, a resource  that will grow with time, and a link to the International Code of Zoological  Nomenclature.  We welcome your  participation in this research and educational effort, as well as feedback as  to how to make this resource more useful and user friendly.<br>
    <br>
    Please  register and complete the short survey that helps us learn more about your  level of expertise with fishes, systematics, taxonomy, and biological  classifications.  Only registered users  can provide posts and comments.</p>
    <!--??-->
    <!--
    <h1>&nbsp;</h1>
    -->
  <!-- end #mainContent --></div>
  <!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats --><br class="clearfloat" />
  <div id="footer">
    <div align="center" ><?php include("menu.php"); ?></div>
    <br>
    <div align="center" ><?php include("menu2.php"); ?></div> 
    <br>
    <div align="center" ><?php include("footer.htm"); ?></div>

  <!-- end #footer --></div>
<!-- end #container --></div>
</body>
</html>
