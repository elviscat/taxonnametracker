<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 19, 2009 Thursday:: default table page with page rows set up and page navigation
  //Jan 11, 2010 Monday:: layout modification
  // ./ current directory
  // ../ up level directory
  header("Cache-control: private");
  session_cache_limiter("none");
  session_start();
  if(!isset($_SESSION['rows_of_per_page'])){
    $_SESSION['rows_of_per_page'] = 10;
  }
  
  //$cur_page = htmlspecialchars($_GET['cur_page'],ENT_QUOTES);
  //echo "Variable cur_page is :: ".$cur_page."<br>\n";
  
  include('template/dbsetup.php');
  
  
  //Restrict admin to access to this page
  
  
  $role = $_SESSION['role'];
  if( $role != "user"){
    Header("location:authorizedFail.php");
    exit();
  }
  
  
  $caption = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes";
  $caption2 = "Browse Your Post Data";  
  $title = $caption."::".$caption2;
  $content = "Browse Your Post Data.";
  
  //$users = htmlspecialchars($_POST['users'],ENT_QUOTES);
  //echo "users is :: ".$users."<br>\n";
  
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  

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
		<script type="text/javascript" src="jquery/jquery.doubleSelect.js"></script>
		<script type="text/JavaScript">
        $(document).ready(function(){
		      //alert("Hello Elvis!");
          $("#selectRows").click(function(){
		        //alert("Select Rows is :: " + );
          });
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

        
        <?php
          echo "<table width=\"800\">\n";
          echo "<tr>\n";
          //echo "<td>ID</td>\n";
          //echo "<td>Title</td>\n";
          //echo "<td>Content</td>\n";
          //echo "<td>Level</td>\n";
          //echo "<td>Detail</td>\n"; 
          
          echo "<td>Title</td>\n";
          echo "<td>Date</td>\n";
          echo "<td>Poster</td>\n";
          echo "<td>Type</td>\n";
          echo "<td>State</td>\n";
          echo "<td>Expiration</td>\n";
          echo "<td>View Detail</td>\n";          
          
          $level_array = array("family","genus","species");          
          for ($i=0; $i< sizeof($level_array); $i++){
            //echo $level_array[$i];
            $table_name = "post";
            $where_clause = " WHERE prefuid = ".$_SESSION['uid']." AND preflv ='".$level_array[$i]."'";
            $sql_table = "SELECT distinct(prefsid) FROM ".$table_name.$where_clause;
            //echo "sql_table is ".$sql_table."/n<br>";
            $result_sql_table = mysql_query($sql_table);
            //echo "<table border=\"1\">\n";
            echo "<tr><td><b>Level: ".ucwords($level_array[$i])."</b></td></tr>\n";
            while ( $nb = mysql_fetch_array($result_sql_table) ) {
              $prefsid = $nb[0];
              if($level_array[$i] == "family"){
                $sql_account_name = "SELECT ffamily FROM flist WHERE fid =".$prefsid;
              }elseif($level_array[$i] == "genus"){
                $sql_account_name = "SELECT ggenus FROM glist WHERE gid =".$prefsid;
              }elseif($level_array[$i] == "species"){
                $sql_account_name = "SELECT sgenus,sspecies FROM slist WHERE sid =".$prefsid;
              }
              $result_sql_account_name = mysql_query($sql_account_name);
              $account_name = "";
              if(mysql_num_rows($result_sql_account_name) > 0){
                while ( $nb_sql_account_name = mysql_fetch_array($result_sql_account_name) ) {
                  if($level_array[$i] == "species"){
                    $account_name = "<i>".$nb_sql_account_name[0]." ".$nb_sql_account_name[1]."</i>";
                  }else{
                    $account_name = $nb_sql_account_name[0];
                  }
                }
              }
              //$temp = "Level: ".ucwords($lv).":".$account_name;
              //$temp = "Taxon: ".$account_name;              
              //echo $temp;
              echo "<tr><td><b>Taxon: ".$account_name."</b></td></tr>\n";  
                
              $sql_table2 = "SELECT * FROM ".$table_name." WHERE prefsid = '".$prefsid."' AND preflv ='".$level_array[$i]."' AND prefuid = ".$_SESSION['uid'];
              //echo "sql_table2 is ".$sql_table2."/n<br>";
              $result_sql_table2 = mysql_query($sql_table2);
              if(mysql_num_rows($result_sql_table2) > 0){              
                while ( $nb_sql_table2 = mysql_fetch_array($result_sql_table2) ) {              
                  $sql_table3 = "SELECT * FROM ".$table_name." WHERE pid = '".$nb_sql_table2[0]."'";
                  //echo "sql_table3 is ".$sql_table3."/n<br>";                  
                  $result_sql_table3 = mysql_query($sql_table3);
                  if(mysql_num_rows($result_sql_table3) > 0){              
                    while ( $nb_sql_table3 = mysql_fetch_array($result_sql_table3) ) {                  
                      echo "<tr>\n";
                      //echo "<td>".$nb_sql_table3[0]."</td>\n";
                      //echo "<td>".$nb_sql_table3[1]."</td>\n";
                      //echo "<td>".substr($nb_sql_table3[2], 0, 10)."...</td>\n";
                      //echo "<td>".$nb_sql_table3[5]."</td>\n";
                      //echo "<td><a href=\"viewpost.php?pid=".$nb_sql_table3[0]."\">View</a></td>\n";
                      echo "<td>".$nb_sql_table3[1]."</td>";//Title
                      echo "<td>".substr($nb_sql_table3[3], 0, 10)."</td>";//Post Date
                      $sql_user = "SELECT * FROM user WHERE uid='".$nb_sql_table3[4]."'";   
                      //echo "sql_user is ".$sql_user."<br>\n";
                      $result_sql_user = mysql_query($sql_user);
                      if(mysql_num_rows($result_sql_user) > 0){
                        while ( $nb_sql_user = mysql_fetch_array($result_sql_user) ) {              
                          //echo "<td>".$nb[4]."</td>";
                          echo "<td><a href=\"viewUserProfile.php?uid=".$nb_sql_user[0]."\">".$nb_sql_user[3]."</a></td>\n";//Poster
                        }
                      }
                      echo "<td>".$nb_sql_table3[7]."</td>\n";//Type
                      $state = "";
                      if( $nb_sql_table3[11] == "0"){
                        $state = "Under Review";
                      }elseif( $nb_sql_table3[11] == "1"){
                        $state = "Current Accepted";
                      }elseif( $nb_sql_table3[11] == "2"){
                        $state = "Old Accepted";
                      }elseif( $nb_sql_table3[11] == "3"){
                        $state = "Rejected";
                      }
                      //echo "<td>".$nb[11]."</td>\n";//State
                      echo "<td>".$state."</td>\n";//State
                      echo "<td>".$nb_sql_table3[12]."</td>\n";//Expiration
                      echo "<td><a href=\"viewpost.php?pid=".$nb_sql_table3[0]."\">Go</a></td>\n";//View detail                      
                      
                      echo "</tr>\n";
                    }
                  }
                //echo "</table>\n";
                }
              }
            //echo "</table>\n";
            }
            //echo "</table>\n";
          }
          echo "</table>\n";
          if(mysql_num_rows($result_sql_table) > 0){

            /*
            echo "<table border=\"1\">\n";
            echo "<tr><td>ID</td><td>Title</td><td>Content</td><td>Level</td><td>Detail</td>";
            while ( $nb = mysql_fetch_array($result_sql_table) ) {
              echo "<tr><td>".$nb[0]."</td><td>".$nb[1]."</td><td>".substr($nb[2], 0, 10)."...</td><td>".$nb[5]."</td>";
              echo "<td><a href=\"viewpost.php?pid=".$nb[0]."\">View</a></td>";
              echo "</tr>\n";
            }
            echo "</table>\n";
            */
          }

        ?>
      </div>
      <div class="spacer"></div>
			<div id="footer" style="text-align:center;">
        <?php include("footer.htm"); ?>
			</div>
		</div>
<?php
  mysql_close($link);
?>
  </body>
</html>