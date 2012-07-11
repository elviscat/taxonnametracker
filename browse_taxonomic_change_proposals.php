<?php
	
	//Author Information
	//Developed by elviscat (elviscat@gmail.com)
	
	
	//Code Change Logs
	//Previous development records are lost
	//Start from now
	//July 05, 2012 Thursday::new::browse user's taxonomic change proposals
	
	// ./ current directory
	// ../ up level directory
	
	
	
	include('template0.php');//DB Connetion and Configuration Setup
	
	
	//Customized Setup
	//Configuration of POST and GET Variables
	//$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	//echo "\$id is :: ".$id."<br>\n";
	//Configuration of POST and GET Variables
	
	$caption = "Browse Taxonomic Change Proposals";//Don't change the variable name
	
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
			//pid 	ptitle 	pcontent 	pcredate 	prefuid 	pref_taxa 	ptype 	pcount 	ptag 	pcategory 	pstate 	pexpiration 	pattachment_id 	p_operation_script 	p_final_decision
			echo "<table width=\"800\">\n";
			echo "<tr>\n";
			
			echo "<td>Title</td>\n";
			echo "<td>Create Date</td>\n";
			echo "<td>Related Taxon</td>\n";
			echo "<td>Submitted By</td>\n";
			echo "<td>State</td>\n";
			echo "</tr>\n";
			
			
			$sql_table = "SELECT * FROM post WHERE prefuid = ".$_SESSION['uid'];
			$result_table = mysql_query($sql_table);
			if(mysql_num_rows($result_table) > 0){   
				while ( $nb_table = mysql_fetch_array($result_table) ) {
					$pid = $nb_table['pid'];
					echo "<tr>\n";
					echo "<td><a href=\"viewpost.php?pid=".$nb_table['pid']."\">".$nb_table['ptitle']."</a></td>\n";
					echo "<td>".$nb_table['pcredate']."</td>\n";
					
					//echo "<td>Related Taxon</td>\n";
					echo "<td>".related_taxa_from_pid('species', 'slist', $pid)."</td>\n";

					$sql_user = "SELECT * FROM user WHERE uid='".$nb_table['prefuid']."'";
					//echo "\$sql_user is ".$sql_user."<br>\n";
					$result_user = mysql_query($sql_user);
					if(mysql_num_rows($result_user) > 0){
						while ( $nb_user = mysql_fetch_array($result_user) ) {
							echo "<td><a href=\"viewUserProfile.php?uid=".$nb_user['uid']."\">".$nb_user['name']."</a></td>\n";//Poster
						}
					}
					echo "<td>".$nb_table['pstate']."</td>\n";//State
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




