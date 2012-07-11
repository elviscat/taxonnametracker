<?php
if(isset($_GET['id'])){// if id is set then get the file with the id from database
  if($_GET['id'] == 0){
    echo "There is no uploaded attached file here!";
    exit;  
  }else{
    include('template/dbsetup.php');
    //Connect to database
    $link = mysql_connect($host , $dbuser ,$dbpasswd); 
    if (!$link) {
      die('Could not connect: ' . mysql_error());
    }
    //select database
    mysql_select_db($dbname);

    $id = $_GET['id'];
    $query = "SELECT name, type, size, content " .
             "FROM upload WHERE id = '$id'";

    $result = mysql_query($query) or die('Error, query failed');
    list($name, $type, $size, $content) =                                  mysql_fetch_array($result);

    header("Content-length: $size");
    header("Content-type: $type");
    header("Content-Disposition: attachment; filename=$name");
    echo $content;

    mysql_close($link);
    exit;  
  }
}
?>
