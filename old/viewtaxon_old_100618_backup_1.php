<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //July 15, 2009 Wednesday:: View the user profile
  //Mar 17, 2010 Wednesday:: modification on updating new template part code
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
  $lv = htmlspecialchars($_GET['lv'],ENT_QUOTES);
  //echo "Variable lv is :: ".$lv."<br>\n";
  $id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "Variable id is :: ".$id."<br>\n";  //Configuration of POST and GET Variables  
  
  $caption = $application_caption;
  $caption2 = "View Taxon Entry/Account Information";
  $title = $application_caption."::".$caption2;
  //template
  


  
  $form_1 = array();
  $form_2 = array();  
  if($lv == "" || $id == ""){
    echo "Null Pointer!\n";
    exit;
  }else{
    //
    $sql_taxon_account = "";
    if($lv == "family"){
      $sql_taxon_account = "SELECT * FROM flist WHERE fid ='".$id."'";
      $form_2 = array("ID", "Kingdon",	"Phylum",	"Superclass",	"Class", "Subclass",	"Infraclass",	"Superorder",	"Order",	"Suboder",	"Superfamily",	"Family",	"Common name 1",	"Common name 2",	"Common name 3");
    }elseif($lv == "genus"){
      $sql_taxon_account = "SELECT * FROM glist WHERE gid ='".$id."'";
      $form_2 = array("ID", "Family", "Genus", "ReferenceID");
    }elseif($lv == "species"){
      $sql_taxon_account = "SELECT * FROM slist WHERE sid ='".$id."'";
      $form_2 = array("ID", "Family", "Genus", "Species", "Author", "Locality", "Common Name1", "Common Name2", "Common Name3", "State");
    }
  }
  

  //echo "sql_taxon_account is ".$sql_taxon_account."/n<br>";  
  $result_sql_taxon_account = mysql_query($sql_taxon_account);  

  if(mysql_num_rows($result_sql_taxon_account) > 0){
    while ( $nb_sql_taxon_account = mysql_fetch_array($result_sql_taxon_account) ) {
      //echo "Size of Array nb is :: ".sizeof($nb)."<br>\n";
      for($i=0; $i < (sizeof($nb_sql_taxon_account)/2); $i++){
        //echo $i." is ".$nb[$i]."<br>\n";
        $form_1[$i] = $nb_sql_taxon_account[$i];
      }
    }
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
	</head>
  <body id="dt_example">
		<div id="container">	
			<h1><? echo $caption; ?></h1>
      <?php
        include("menu.php");
      ?>
      <h2><?php echo $caption2; ?></h2>
      <div id="demo">
        <form id="viewTaxonEntryForm" action="" method="post">
          <table>
            <tr>
              <td colspan=2><p>Taxon Entry/Account Information</p></td>
            </tr>
<?php
  //echo "Size of Array form_1 is :: ".sizeof($form_1);
  
  for( $i = 1; $i < sizeof($form_1); $i++){
    echo "<tr>\n";
    echo "<td><label>".$form_2[$i]."</label></td>\n";
    echo "<td><input name=\"Post_".$i."\" type=\"text\" value=\"".$form_1[$i]."\" readonly/></td>\n";
    echo "</tr>\n";
    //echo $form_2[$i]." = ".$form_1[$i]."<br>\n";
  }
   
?>            
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

<!--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Description" content="Saint Louis University, tissue, species information" />
<meta name="Keywords" content="Saint Louis University, tissue, information" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="Distribution" content="Global" />
<meta name="Author" content="Richard Mayden - cypriniformes@gmail.com, Elvis Hsin-Hui Wu - hwu5@slu.edu" />
<meta name="Robots" content="index,follow" />
<link rel="stylesheet" href="edit.css" type="text/css" />-->

<!--
<script src="/jquery/jquery.js" type="text/javascript" language="javascript"></script>
<script src="/jquery/jquery.form.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
  // wait for the DOM to be loaded 
  /*
  $(document).ready(function() { 
    // bind 'speciesEditor' and provide a simple callback function 
    $(#loginForm').ajaxSubmit(function() {  
      return false; 
    });        
  });
  */
</script>-->
<!--<title><? //echo $title; ?></title>
</head>
<body>
  <div id="basic" class="myform">
    <h3><? //echo $title; ?></h3>

    <div align="center"><a href="index.php">Back to Homepage</a></div>      
  </div>
</body>
</html>-->










