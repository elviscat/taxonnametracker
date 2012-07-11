<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //March 14, 2009 Saturday:: dynamic navigation based on different levels of users 
  // ./ current directory
  // ../ up level directory
  $dirPath = "";
  if( $_SESSION['role'] == "admin"){
    $dirPath = "../";
  }else{
    //do nothing
  }
?>



    <div  id="menu">
		<ul>
			<li id="current"><a href="index.php">Home</a></li>
			<li><a href="<? echo $dirPath; ?>blog">Taxonomic Blog</a></li>
			<li><a href="<? echo $dirPath; ?>searchspecies.php">Search Species</a></li>
			<li><a href="<? echo $dirPath; ?>updatetotaxa.html">Update to Taxa</a></li>
			<li><a href="<? echo $dirPath; ?>aboutus.php">About Us</a></li>		
		</ul>
	</div>