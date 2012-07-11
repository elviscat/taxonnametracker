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
  $cur_page = htmlspecialchars($_GET['cur_page'],ENT_QUOTES);
  //echo "Variable cur_page is :: ".$cur_page."<br>\n";
  
  include('template/dbsetup.php');
  
  
  //Restrict admin to access to this page
  
  
  $role = $_SESSION['role'];
  if( $role != "user"){
    Header("location:authorizedFail.php");
    exit();
  }
  
  
  $caption = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes";
  $caption2 = "Browse Comment Information";  
  $title = $caption."::".$caption2;
  $content = "Browse Comment Information.";
  
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
         
          echo "<td>Title</td>\n";
          echo "<td>Date</td>\n";
          //echo "<td>Poster</td>\n";
          echo "<td>Type</td>\n";
          //echo "<td>State</td>\n";
          //echo "<td>Expiration</td>\n";
          echo "<td>View Detail</td>\n";          
          
          //SELECT A.cid, A.ctitle, A.ccredate, A.comment_type, B.preflv, B.prefsid FROM comment AS A, post AS B WHERE A.crefpid = B.pid AND A.crefuid = 3 ORDER BY B.preflv          
          $table_name = "comment AS A, post AS B";
          $where_clause = " WHERE A.crefpid = B.pid AND A.crefuid = ".$_SESSION['uid'];
          $orderby_clause = " ORDER BY B.preflv";
          $sql_table = "SELECT A.cid, A.ctitle, A.ccredate, A.comment_type, B.preflv, B.prefsid FROM ".$table_name.$where_clause.$orderby_clause;
          //echo "sql_table is ".$sql_table."/n<br>";
          $result_sql_table = mysql_query($sql_table);          
          
          $level = "";
          $taxon_name_id = "";
          if(mysql_num_rows($result_sql_table) > 0){
                        
            while ( $nb_sql_table = mysql_fetch_array($result_sql_table) ) {          
              if($level != $nb_sql_table[4]){
                $level = $nb_sql_table[4];
                echo "<tr><td><b>Level: ".ucwords($nb_sql_table[4])."</b></td></tr>";
              }
              if($taxon_name_id != $nb_sql_table[5]){
                $taxon_name_id = $nb_sql_table[5];
                $prefsid = $taxon_name_id;
                
                if($level == "family"){
                  $sql_account_name = "SELECT ffamily FROM flist WHERE fid =".$prefsid;
                }elseif($level == "genus"){
                  $sql_account_name = "SELECT ggenus FROM glist WHERE gid =".$prefsid;
                }elseif($level == "species"){
                  $sql_account_name = "SELECT sgenus,sspecies FROM slist WHERE sid =".$prefsid;
                }
                $result_sql_account_name = mysql_query($sql_account_name);
                $account_name = "";
                if(mysql_num_rows($result_sql_account_name) > 0){
                  while ( $nb_sql_account_name = mysql_fetch_array($result_sql_account_name) ) {
                    if($level == "species"){
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
                
                
                //echo "<tr><td><b>Taxon: ".$nb_sql_table[5]."</b></td></tr>";
              }
              //echo "<tr><td>".$nb_sql_table[0]." ".$nb_sql_table[1]."</td></tr>\n";
              //
              echo "<tr>\n";
              echo "<td>".$nb_sql_table[1]."</td>";//Title
              echo "<td>".substr($nb_sql_table[2], 0, 10)."</td>";//Date
              //echo "<td>".substr($nb_sql_table[2], 0, 10)."</td>";
              
              
              $type = "";
              if( $nb_sql_table[3] == "0"){
                $type = "General Comment";
              }elseif( $nb_sql_table[3] == "1"){
                $type = "Review Opinion";
              }elseif( $nb_sql_table[3] == "2"){
                $type = "Decision Suggestion";
              }
              //echo "<td>".$nb_sql_table[3]."</td>";//Type
              echo "<td>".$type."</td>\n";//Type    
              
              echo "<td><a href=\"viewcomment.php?cid=".$nb_sql_table[0]."\">Go</a></td>\n";//View detail                     
              echo "</tr>\n";
                
            }
          }
          
          echo "</table>\n";

          /*
          $table_name = "comment";
          $where_clause = " WHERE crefuid = ".$_SESSION['uid']." ";

          //Customize the table
          
          $sql_table = "SELECT * FROM ".$table_name.$where_clause." LIMIT ".$start.",".$rows;
          //echo "sql_table is ".$sql_table."/n<br>";
          $result_sql_table = mysql_query($sql_table);
          if(mysql_num_rows($result_sql_table) > 0){
            echo "<table border=\"1\">\n";
            echo "<tr><td>ID</td><td>Title</td><td>Content</td><td>Detail</td>";
            while ( $nb = mysql_fetch_array($result_sql_table) ) {
              echo "<tr><td>".$nb[0]."</td><td>".$nb[1]."</td><td>".$nb[2]."</td>";
              echo "<td><a href=\"viewcomment.php?cid=".$nb[0]."\">View</a></td>";
              echo "</tr>\n";
            }
            echo "</table>\n";
          }
          */
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