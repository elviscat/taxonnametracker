<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 13, 2009 Friday:: Change with change log
  // ./ current directory
  // ../ up level directory
  header("Cache-control: private");
  session_cache_limiter("none");
  session_start();
  
  include('template/dbsetup.php');

  $reflv = htmlspecialchars($_POST['reflv'],ENT_QUOTES);
  //echo "reflv is :: ".$reflv."<br>\n";
  $id = htmlspecialchars($_POST['id'],ENT_QUOTES);
  //echo "id is :: ".$id."<br>\n";
  

  
  
  /*
  $sfamily = htmlspecialchars($_POST['sfamily'],ENT_QUOTES);
  //echo "sfamily is :: ".$sfamily."<br>\n";
  $sgenus = htmlspecialchars($_POST['sgenus'],ENT_QUOTES);
  //echo "sgenus is :: ".$sgenus."<br>\n";
  $sspecies = htmlspecialchars($_POST['sspecies'],ENT_QUOTES);
  //echo "sspecies is :: ".$sspecies."<br>\n";
  $sauthor = htmlspecialchars($_POST['sauthor'],ENT_QUOTES);
  //echo "sauthor is :: ".$sauthor."<br>\n";
  $sloc = htmlspecialchars($_POST['sloc'],ENT_QUOTES);
  //echo "sloc is :: ".$sloc."<br>\n";
  $scnam1 = htmlspecialchars($_POST['scnam1'],ENT_QUOTES);
  //echo "scnam1 is :: ".$scnam1."<br>\n";
  $scnam2 = htmlspecialchars($_POST['scnam2'],ENT_QUOTES);
  //echo "scnam1 is :: ".$scnam1."<br>\n";
  $scnam3 = htmlspecialchars($_POST['scnam3'],ENT_QUOTES);
  //echo "scnam3 is :: ".$scnam3."<br>\n";
  */
  $rea = htmlspecialchars($_POST['rea'],ENT_QUOTES);
  //echo "rea is :: ".$rea."<br>\n";
  $refpid = htmlspecialchars($_POST['refpid'],ENT_QUOTES);
  //echo "refpid is :: ".$refpid."<br>\n";
  
  
  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);
  
  $sizeof_form = htmlspecialchars($_POST['sizeof_form'],ENT_QUOTES);
  //echo "sizeof_form is :: ".$sizeof_form."<br>\n";
  
  $table_name = htmlspecialchars($_SESSION['table_name'],ENT_QUOTES);
  
  $id_column = "";
  $table = "";
  if( $table_name == "Family" ){
    $id_column = "fid";
    $table = "flist";
  }elseif( $table_name == "Genus" ){
    $id_column = "gid";
    $table = "glist";
  }elseif( $table_name == "Species" ){
    $id_column = "sid";
    $table = "slist";
  }  
  
  
  $sql = "SELECT * FROM ".$table;
  //echo "sql is ".$sql."\n<br>";
  $result = mysql_query($sql);
  
  
  for( $i = 1; $i < $sizeof_form; $i++){
    $post_para = htmlspecialchars($_POST['Post_'.$i],ENT_QUOTES);
    //echo $post_para."<br>\n";
    $column_name = mysql_field_name($result, $i);
    $update_sql =  "UPDATE ".$table." SET ".$column_name." = '".$post_para."' WHERE ".$id_column." ='".$id."'";
    //echo "update_sql is ".$update_sql."<br>\n";
    mysql_query($update_sql);
  }
  /*
  $update_sql =  "UPDATE slist SET ";
  $update_sql .= " sfamily = '".$sfamily."', sgenus ='".$sgenus."', ";
  $update_sql .= " sspecies ='".$sspecies."', sauthor='".$sauthor."', sloc='".$sloc."', scnam1 ='".$scnam1."',";
  $update_sql .= " scnam2 ='".$scnam2."', scnam3='".$scnam3."'";
  $update_sql .= " WHERE sid ='".$id."'";
  //echo "update_sql is ".$update_sql."<br>\n";
  $result = mysql_query($update_sql);
  */
  
  //
  $maxid = 0;
  $max_id_sql = "SELECT (Max(id)+1) FROM namelist_chglog";
  $result_max_id = mysql_query($max_id_sql);	  
  list($maxid) = mysql_fetch_row($result_max_id);
  if($maxid == 0){
    $maxid = 1;
  }          

  //
  
  $regdate = date('Y-m-d');
  $regtime = date('h:i:s');
  //date: 0000-00-00
  //time: 00:00:00 
  
  $insert_sql = "INSERT INTO namelist_chglog (`id`, `reflv`, `refid`, `refpid`, `rea`, `chgdate`, `chgtime`) ";
  $insert_sql .= "VALUES ('$maxid','$reflv','$id','$refpid','$rea', '$regdate', '$regtime')";
  //echo "insert_sql is ".$insert_sql."<br>\n";
  $result=mysql_query($insert_sql);

  
  mysql_close($link); 
  Header("Location:slist_table.php")

?>