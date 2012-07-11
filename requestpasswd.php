<?php
	
	//Author Information
	//Developed by elviscat (elviscat@gmail.com)
	
	
	//Code Change Logs
	//Previous development records are lost
	//Start from now
	//May 02, 2012 Wednesday:: Apply to new template (template.php)
	
	// ./ current directory
	// ../ up level directory
	
	
	include('template0.php');//DB Connetion and Configuration Setup
	
	
	//Customized Setup
	//Configuration of POST and GET Variables
	//$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	//echo "\$id is :: ".$id."<br>\n";
	//Configuration of POST and GET Variables
	
	$page_title = "Request Password :: ";//Don't change the variable name
	$page_heading = "Request Password ::";//Don't change the variable name
	
	//Put the code for this page HERE!
	
	//Put the code for this page HERE!
	//Customized Setup
	
	include('template1.php');//head, title, basic javascript, body, sidebar until "div:mainContent"
	
?>
	<!-- Put Extra Javascript References and Javascript Code Here! -->
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
	
	
	
	<!-- Put Extra Javascript References and Javascript Code Here! -->
	<?php echo "<h3>".$page_heading."</h3><br>\n"; ?>
	<!-- Put Actual Html Code and PHP code for this page Here! -->
	
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
	
	<!-- Put Actual Html Code and PHP code for this page Here! -->



<?php
	include('template2.php');//end of div:mainContent, footer, php mysql connection close
?>






