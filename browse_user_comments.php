<?php
	
	//Author Information
	//Developed by elviscat (elviscat@gmail.com)
	
	
	//Code Change Logs
	//Previous development records are lost
	//Start from now
	//July 05, 2012 Thursday::new::browse user's comments
	
	// ./ current directory
	// ../ up level directory
	
	
	
	include('template0.php');//DB Connetion and Configuration Setup
	
	
	//Customized Setup
	//Configuration of POST and GET Variables
	//$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	//echo "\$id is :: ".$id."<br>\n";
	//Configuration of POST and GET Variables
	
	$caption = "Browse Comments";//Don't change the variable name
	
	//Put the code for this page HERE!


	//header("Cache-control: private");
	//session_cache_limiter("none");
	session_start();
	if(!isset($_SESSION['rows_of_per_page'])){
		$_SESSION['rows_of_per_page'] = 10;
	}

	$role = $_SESSION['role'];
	if( $role != "user"){
		Header("location:authorizedFail.php");
		exit();
	}
	
	//Put the code for this page HERE!
	//Customized Setup
	
	include('template1.php');//head, title, basic javascript, body, sidebar until "div:mainContent"
	
?>
	<!-- Put Extra Javascript References and Javascript Code Here! -->

		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
		<script type="text/javascript" src="jquery/jquery-1.3.2.js"></script>
		<script type="text/javascript" src="jquery/jquery.doubleSelect.js"></script>
		<script type="text/JavaScript">
        $(document).ready(function(){
		      //alert("Hello Elvis!");
          $("#selectRows").click(function(){
		        //alert("Select Rows is :: " + );
          });
        });
        </script>	
	<!-- Put Extra Javascript References and Javascript Code Here! -->
	
	<?php echo "<h2>".$caption."</h2><br>\n"; ?>
	
	<!-- Put Actual Html Code and PHP code for this page Here! -->
		
        <?php
			//cid 	ctitle 	ccontent 	ccredate 	crefuid 	crefpid 	comment_type 	cname 	cwebsite 	cmsn
			echo "<table width=\"800\">\n";
			echo "<tr>\n";
			
			echo "<td>Title</td>\n";
			echo "<td>Create Date</td>\n";
			//echo "<td>Related Proposal</td>\n";
			echo "<td>Comment Type</td>\n";
			echo "</tr>\n";
			
			
			$sql_table = "SELECT * FROM comment WHERE crefuid = ".$_SESSION['uid'];
			$result_table = mysql_query($sql_table);
			if(mysql_num_rows($result_table) > 0){   
				while ( $nb_table = mysql_fetch_array($result_table) ) {
					$cid = $nb_table['cid'];
					echo "<tr>\n";
					echo "<td><a href=\"viewpost.php?pid=".$nb_table['crefpid']."\">".$nb_table['ctitle']."</a></td>\n";
					echo "<td>".$nb_table['ccredate']."</td>\n";
					

					echo "<td>".$nb_table['comment_type']."</td>\n";//State
					echo "</tr>\n";
				}
			}
			echo "</table>\n";
			echo "<br /><br /><a href=\"javascript:history.go(-1)\">GO BACK</a><BR>\n";

        ?>
	
	<!-- Put Actual Html Code and PHP code for this page Here! -->



<?php
	include('template2.php');//end of div:mainContent, footer, php mysql connection close
?>




