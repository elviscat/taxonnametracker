<?php 
  //created on Dec 03, 2009 Thursday
  //created by Elvis Hsin-Hui Wu
  //elviscat@gmail.com
  //
  //
  session_start();
  $target_page = htmlspecialchars($_POST['target_page'],ENT_QUOTES);
  $table_name = htmlspecialchars($_POST['table_name'],ENT_QUOTES);
  //echo "rows_of_table variable is :: ".$rows_of_table."<br>\n";
  $_SESSION['table_name'] = $table_name;
  //echo "Session variable table_name is :: ".$_SESSION['table_name']."<br>\n";
  Header("location:".$target_page);
?>
