<?php
  //Developed by elviscat (elviscat@gmail.com)
  //March 17, 2009 Tuesday:: post the proposed changes or suggestted name changes interface
  // ./ current directory
  // ../ up level directory
  session_start();
  if( (!isset($_SESSION['is_login'])) ){
	  Header("location:authorizedFail.php");
	  exit();
  }  
  $prefsid = $_GET['sid'];
  $prefuid = $_SESSION['uid'];
  
  $title = "Post your Proposed Changes or Suggestted Name Changes";
  
  include('template/dbsetup.php');
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
 
?>
<!--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Description" content="Saint Louis University, taxonomy and nomenclature platform based on social network" />
<meta name="Keywords" content="Saint Louis University, taxonomy, nomenclature, social network" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="Distribution" content="Global" />
<meta name="Author" content="Richard Mayden - cypriniformes@gmail.com, Elvis Hsin-Hui Wu - hwu5@slu.edu" />
<meta name="Robots" content="index,follow" />
<link rel="stylesheet" href="edit.css" type="text/css" />
<script src="../jquery/jquery.js" type="text/javascript" language="javascript"></script>
<script src="../jquery/jquery.form.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
  // wait for the DOM to be loaded 
  $(document).ready(function() { 
    // bind 'speciesEditor' and provide a simple callback function 
    $(#geocodingEditor').ajaxSubmit(function() {  
      return false; 
    });        
  });
</script>
<title><? echo $title; ?></title>
</head>
<body>
  <div id="basic" class="myform">
    <h3><? echo $title; ?></h3>
      <p><? echo $detailDesc; ?></p>
      <form id="postProposedChanges" action="postProposedChanges2.php" method="post">
        <label>Title
          <span class="small"></span>
        </label>
          <input id="ptitle" name="ptitle" type="text" size="100" value="" />
        <BR><BR><BR>
        <label>Type
          <span class="small">Choose one</span>
        </label>
          <select id="ptype" name="ptype">
            <option value="Proposed Changes" selected>Proposed Changes</option>
            <option value="Suggestted Name Changes">Suggestted Name Changes</option>
          </select>
        <BR><BR><BR>    
	      <label>Content
          <span class="small"></span>
        </label>
          <textarea name="pcontent" rows="15" cols="25"></textarea>
   
        <input id="prefsid" name="prefsid" type="hidden" value="<?php echo $prefsid; ?>" />
        <input id="prefuid" name="prefuid" type="hidden" value="<?php echo $prefuid; ?>" />
        <button  type="submit">Post it!</button>
      </form>
      <br>
      <br>
      <div align="center">
        <?php
          //call back the family name
          //echo $dbname;
          $sfamily = "";
          $tempQuerySql = "SELECT sfamily FROM slist WHERE sid ='".$prefsid."'";
          $tempQueryResult = mysql_query("$tempQuerySql") or die("Invalid query: " . mysql_error());
          $sfamily = mysql_result($tempQueryResult, 0); 
        ?>
        <a href="indexSpecies.php?sfamily=<? echo $sfamily; ?>">Back to Species List</a>
        <BR>
        <a href="index.php">Back to homepage</a>
        <BR>
      </div>
		</div>
</body>
</html>


