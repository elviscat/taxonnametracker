<?php
	
	//Author Information
	//Developed by elviscat (elviscat@gmail.com)
	
	
	//Code Change Logs
	//Previous development records are lost
	//Start from now
	//Jan 14, 2010 Thursday:: Layout and logic modification
	//Jan 26, 2010 Tuesday:: Layout and logic modification
	//May 25, 2010 Tuesday:: New Layout
	
	// ./ current directory
	// ../ up level directory
	
	
	include('template0.php');//DB Connetion and Configuration Setup
	
	
	//Customized Setup
	//Configuration of POST and GET Variables
	//$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	//echo "\$id is :: ".$id."<br>\n";
	//Configuration of POST and GET Variables
	
	
	$caption = "Here is the caption of the page";//Don't change the variable name
	
	//Put the code for this page HERE!
	
	//Put the code for this page HERE!
	//Customized Setup
	
	include('template1.php');//head, title, basic javascript, body, sidebar until "div:mainContent"
	
?>
	<!-- Put Extra Javascript References and Javascript Code Here! -->
	
	<!-- Put Extra Javascript References and Javascript Code Here! -->
	
	<?php echo "<h3>".$caption."</h3><br>\n"; ?>
	
	<!-- Put Actual Html Code and PHP code for this page Here! -->
	
	
	<!-- Put Actual Html Code and PHP code for this page Here! -->



<?php
	include('template2.php');//end of div:mainContent, footer, php mysql connection close
?>





