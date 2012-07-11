<?php 
session_start();
include('../template/dbsetup.php');
//Developed by elviscat

//get the posted values
$keyword=htmlspecialchars($_POST['keyword'],ENT_QUOTES);
/*************************************/
$Genus_name=htmlspecialchars($_POST['Genus_name'],ENT_QUOTES);

$Species_name=htmlspecialchars($_POST['Species_name'],ENT_QUOTES);

/************************************/
//echo $keyword;

//Connect to database
$link = mysql_connect($host , $dbuser ,$dbpasswd); 
if (!$link) {
   	die('Could not connect: ' . mysql_error());
}
//select database
mysql_select_db($dbname);
//sql statement
$scientific_name = explode(" ", $keyword);

//$sql = "SELECT * FROM biglonglist WHERE mspecies = '".$scientific_name[1]."'";
$sql = "SELECT * FROM biglonglist WHERE mgenus = '".$scientific_name[0]."' AND mspecies = '".$scientific_name[1]."'";
/*
$sql = "SELECT * FROM biglonglist WHERE mfamily like '%".$keyword."%'";
$sql .= " or mgenus like '%".$keyword."%'";
$sql .= " or mspecies like '%".$keyword."%'";
$sql .= " or mauthor like '%".$keyword."%'";
$sql .= " or mtypelocal like '%".$keyword."%'";
$sql .= " or mccode like '%".$keyword."%'";
$sql .= " or mpaese like '%".$keyword."%'";
*/
$result=mysql_query($sql);

//$row=mysql_fetch_array($result);
//if the result exists
//loop it!!

if(mysql_num_rows($result)>0){
    echo $sql;
    $sid =0;
	//while ($nb=mysql_fetch_array($result)) {
	//	$sid +=1;
	//}    
	//echo "<p>There are ".$sid." results.</p>";
	echo "<table>";
	echo "<tr><td align=\"center\">Family</td><td align=\"center\">Genus</td><td align=\"center\">Species</td><td align=\"center\">Holder</td>";
	while ($nb2=mysql_fetch_array($result)) {
		echo "<tr bgcolor=\"#FDDC99\">";
		echo "<td align=\"center\"><a href=\"genus.php?family=".$nb2[1]."\">".$nb2[1]."</a>(Change?)</td>";
		echo "<td align=\"center\"><a href=\"genus.php?family=".$nb2[2]."\">".$nb2[2]."</a></td>";
		echo "<td align=\"center\"><a href=\"genus.php?family=".$nb2[3]."\">".$nb2[3]."</a></td>";
		echo "<td align=\"center\">elviscat</td>";
		echo "</tr>";
	}
	echo "</table>";
	
	
	//echo $row[0]."<BR>";
	//echo $row[1]."<BR>";
	//echo $row[2]."<BR>";
	//echo $row[3]."<BR>";
	//echo $row[4]."<BR>";
	//echo $row[5]."<BR>";
	//echo $row[6]."<BR>";
}else{
	echo $sql;
	echo "<p>There is no match result.</p>"; //Invalid Login
}








/***************************************************************/
$sql = "SELECT * FROM biglonglist WHERE mgenus = '".$Genus_name."'";
$result=mysql_query($sql);
if(mysql_num_rows($result)>0){
    echo $sql;
    $sid =0;
	//while ($nb=mysql_fetch_array($result)) {
	//	$sid +=1;
	//}    
	//echo "<p>There are ".$sid." results.</p>";
	echo "<table>";
	echo "<tr><td align=\"center\">Family</td><td align=\"center\">Genus</td><td align=\"center\">Species</td><td align=\"center\">Holder</td>";
	while ($nb2=mysql_fetch_array($result)) {
		echo "<tr bgcolor=\"#FDDC99\">";
		echo "<td align=\"center\"><a href=\"genus.php?family=".$nb2[1]."\">".$nb2[1]."</a>(Change?)</td>";
		echo "<td align=\"center\"><a href=\"genus.php?family=".$nb2[2]."\">".$nb2[2]."</a></td>";
		echo "<td align=\"center\"><a href=\"genus.php?family=".$nb2[3]."\">".$nb2[3]."</a></td>";
		echo "<td align=\"center\">elviscat</td>";
		echo "</tr>";
	}
	echo "</table>";
	
	
	//echo $row[0]."<BR>";
	//echo $row[1]."<BR>";
	//echo $row[2]."<BR>";
	//echo $row[3]."<BR>";
	//echo $row[4]."<BR>";
	//echo $row[5]."<BR>";
	//echo $row[6]."<BR>";
}else{
	echo $sql;
	echo "<p>There is no match result.</p>"; //Invalid Login
}


$sql = "SELECT * FROM biglonglist WHERE mspecies = '".$Species_name."'";
$result=mysql_query($sql);

//$row=mysql_fetch_array($result);
//if the result exists
//loop it!!

if(mysql_num_rows($result)>0){
    echo $sql;
    $sid =0;
	//while ($nb=mysql_fetch_array($result)) {
	//	$sid +=1;
	//}    
	//echo "<p>There are ".$sid." results.</p>";
	echo "<table>";
	echo "<tr><td align=\"center\">Family</td><td align=\"center\">Genus</td><td align=\"center\">Species</td><td align=\"center\">Holder</td>";
	while ($nb2=mysql_fetch_array($result)) {
		echo "<tr bgcolor=\"#FDDC99\">";
		echo "<td align=\"center\"><a href=\"genus.php?family=".$nb2[1]."\">".$nb2[1]."</a>(Change?)</td>";
		echo "<td align=\"center\"><a href=\"genus.php?family=".$nb2[2]."\">".$nb2[2]."</a></td>";
		echo "<td align=\"center\"><a href=\"genus.php?family=".$nb2[3]."\">".$nb2[3]."</a></td>";
		echo "<td align=\"center\">elviscat</td>";
		echo "</tr>";
	}
	echo "</table>";
	
	
	//echo $row[0]."<BR>";
	//echo $row[1]."<BR>";
	//echo $row[2]."<BR>";
	//echo $row[3]."<BR>";
	//echo $row[4]."<BR>";
	//echo $row[5]."<BR>";
	//echo $row[6]."<BR>";
}else{
	echo $sql;
	echo "<p>There is no match result.</p>"; //Invalid Login
}


mysql_close($link);
?>