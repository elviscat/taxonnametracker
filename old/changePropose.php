<?PHP
  //Developed by elviscat (elviscat@gmail.com)
  //March 15, 2009 Friday:: propose change post interface
  // ./ current directory
  // ../ up level directory
  session_start();
  if( (!isset($_SESSION['is_login'])) ){
	  Header("location:authorizedFail.php");
	  exit();
  }  
  $prefsid = $_GET['sid'];
  $prefuid = $_SESSION['uid'];
  
  $title = "North American Freshwater Fishes Propose Change or Name Change";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
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
    <p><? echo $title; ?></p>
    <form id="newPost" action="changePropose2.php" method="post">
        <!--<input id="ptitle" name="ptitle" type="text" size="100" value="" /><p>-->
	  <label>Category
        <span class="small"></span>
      </label>
        <input id="category" name="pcategory" type="text" size="100" value="" />
	  <label>Tag
        <span class="small"></span>
      </label>
        <input id="ptag" name="ptag" type="text" size="100" value="" />
	  <label>Content
        <span class="small"></span>
      </label>
        <!--<span class="small">--><textarea name="pcontent" rows="30" cols="30"></textarea><!--</span><p>-->
      
    <label>Type
        <span class="small">Choose one</span>
    </label>
      <input id="prefuid" name="prefuid" type="hidden" value="<? echo $prefuid; ?>" />
      <input id="prefsid" name="prefsid" type="hidden" value="<? echo $prefsid; ?>" />
      <select id="ptitle" name="ptitle">
        <option value="Propose Main change" selected>Propose Main change</option>
        <option value="Propose Name Change">Propose Name Change</option>
      </select>   
      <BR>
      <button  type="submit">Post it!</button>
    </form>
    <br><br>
    <div align="center"><p><a href="index.php">Back to Index</a></p> </div>
    <!--<div align="center"><a href="../index.php">Return to index</a><br></div>-->

  </div>
</body>
</html>
