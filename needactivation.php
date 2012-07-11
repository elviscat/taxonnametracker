<?php
	
	//Author Information
	//Developed by elviscat (elviscat@gmail.com)
	
	
	//Code Change Logs
	//Previous development records are lost
	//Start from now
	//July 07, 2012 Saturday::NEW:: adopt to new template, check the logic
	
	// ./ current directory
	// ../ up level directory
	
	
	include('template0.php');//DB Connetion and Configuration Setup
	
	
	//Customized Setup
	//Configuration of POST and GET Variables
	//$actkey = htmlspecialchars($_GET['key'],ENT_QUOTES);
	//echo "\$actkey is ".$actkey."<BR>\n";
	//$q = htmlspecialchars($_GET['q'],ENT_QUOTES);
	//echo "\$q is ".$q."<BR>\n";
	//Configuration of POST and GET Variables
	
	$caption = "Account Need to Be Activated";//Don't change the variable name
	

	//Put the code for this page HERE!

  	
	//Put the code for this page HERE!
	//Customized Setup
	
	include('template1.php');//head, title, basic javascript, body, sidebar until "div:mainContent"
	
?>
	<!-- Put Extra Javascript References and Javascript Code Here! -->
	
	<!-- Put Extra Javascript References and Javascript Code Here! -->
	
	<?php echo "<h3>".$caption."</h3><br>\n"; ?>
	
	<!-- Put Actual Html Code and PHP code for this page Here! -->
	
	<?php
		echo "Your account has not been activated, please look over your account confirmation email to proceed the activation process.<br />\n";
	?>	
	<!-- Put Actual Html Code and PHP code for this page Here! -->



<?php
	include('template2.php');//end of div:mainContent, footer, php mysql connection close
?>
















