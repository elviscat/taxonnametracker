<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //March 14, 2009 Saturday:: dynamic navigation based on different levels of users 
  // ./ current directory
  // ../ up level directory
  
  $dirPath = "";
  $loginOrout = "";
  if($_SESSION['is_login']==true){
	  if( $_SESSION['role'] == "admin"){
      $dirPath = "../";    
    }
    $loginOrout = "<a href=\"".$dirPath."logout.php\">Logout</a>";
	}else{
	  if( $_SESSION['role'] == "admin"){
      $dirPath = "../";    
    }
    $loginOrout = "<a href=\"".$dirPath."login.php\">Login</a>";
	}


?>
    <div id="header">			
		<h1 id="logo-text"><a href="index.php">Cypriniformes Commons</a></h1>		
		<p id="slogan">BETA</p>		
			
		<div id="header-links">
			<p>
			  <a href="<? echo $dirPath; ?>index.php">Home</a> | 
			  <a href="<? echo $dirPath; ?>recommendation.php">Recommendations</a> | 
			  <!--<a href="login.html">Login</a>//Original Setting-->
      <? echo $loginOrout; ?>
      </p>		
		</div>				
	</div>