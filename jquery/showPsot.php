<?php 
session_start();
include('../template/dbsetup.php');
//Developed by elviscat

//get the posted values
$refsid = htmlspecialchars($_POST['refsid'],ENT_QUOTES);
//echo $refsid;

?>
