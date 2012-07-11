<?php 
  session_start();
  $rows_of_table = htmlspecialchars($_POST['rows_of_table'],ENT_QUOTES);
  //echo "rows_of_table variable is :: ".$rows_of_table."<br>\n";
  $_SESSION['rows_of_per_page'] = $rows_of_table;
  //echo "Session variable is :: ".$_SESSION['rows_of_per_page']."<br>\n";
  Header("location:slist_table.php");
?>
