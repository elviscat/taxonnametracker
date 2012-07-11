<?php 
  session_start();
  $title = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes";
  $caption = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes";
  $caption2 = "Request Password";  
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
    <script type="text/javascript" src="jquery/jquery.form.js"></script>
    <script>
    function submit() {
      var submitString = $('#requestpasswdForm').formSerialize();
      $.post("requestpasswd2.php",
      {submitString:submitString},
	    function(data){//do something
	    //alert(data);
      $('#msg').html(data);
	    });
	  }
    $(document).ready(function(e){
      $('#requestpasswdForm').ajaxForm(submit);	
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
        <form id="requestpasswdForm" action="#" method="post">
          <table>
            <tr>
              <td colspan=2><p>Please fill out the following information</p></td>
            </tr>
            <tr>
              <td ><label>Login name</label></td>
              <td ><input name="loginname" type="text" /></td>
            </tr>
            <tr>
              <td ><label>Email address</label></td>
              <td ><input name="eml" type="text" /></td>
            </tr>            
            <tr>
              <td colspan=2><button  type="submit" onclick="confirmation(); return false;">Request</button></td>
            </tr>
          </table>
        </form>
      </div>
			<div id="msg"></div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
  </body>
</html>

