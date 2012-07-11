<?php 
session_start();
include('template/dbsetup.php');
require('phpmailer/class.phpmailer.php');
require('inc/config.inc.php');

//Developed by elviscat
//July 08, 2009 Wednesday
//April 05, 2010 Monday

//$submitString = chr($submitString);
//echo "hexdec(\"40\") is ".dechex(%40)."<BR>\n";
/*
function hexToAsciiToString($hex){
  $strLength = strlen($hex);
  for( $i = 0; $i < $strLength; $i++ ){
		if( substr($hex, $i, 1) == "%"){
      //echo "hex code is ".substr($hex, $i, 3)."\n";
      //echo "str is ".chr(hexdec(substr($hex, $i, 3)))."\n";
      $temp_str = chr(hexdec(substr($hex, $i, 3)));
      $hex = substr_replace ($hex, $temp_str, $i, 3);
    }
    if( substr($hex, $i, 1) == "+"){
      $temp_str = " ";
      $hex = substr_replace ($hex, $temp_str, $i, 1);
    }     
  }
  //echo $hex."\n";
  return $hex;
}
*/

/*
function curPageURL() {
 
 $requestURI = $_SERVER["REQUEST_URI"];
 $requestURI2 = "";
 $array_requestURI = explode("/", $requestURI);
 for( $i = 0; $i < (sizeof($array_requestURI)-1); $i++){
   $requestURI2 .= $array_requestURI[$i]."/";
 }
 
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$requestURI2;
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$requestURI2;
 }
 return $pageURL;

}
*/

//$test = "hwu5%40%39slu.edu%23ascfff%34FGH";
//$test = hexToAsciiToString($test);
//echo $test."<BR>\n";
//get the posted values

$submitString = htmlspecialchars($_POST['submitString'],ENT_QUOTES);


//echo "utf8_encode(%40) is ".utf8_encode(%40)."<BR>\n";
//echo "chr(%40) is ".chr(%40)."<br>";
//echo "submitString is ::".$submitString."\n<BR>";

$submitStringArray = explode("&amp;", $submitString);

$loginname;
$password;
$password_confirm;
$real_name;
$org;
$tel;
$fax;
$eml;
  $is_asih = 0;
  $is_afs = 0;

for ($i =0 ; $i < sizeof($submitStringArray); $i++){
  //echo "submitStringArray[".$i."] is ".$submitStringArray[$i]."\n<br>";
  $submitStringArray2 = explode("=", $submitStringArray[$i]);
  if($submitStringArray2[0] == 'loginname'){
    $loginname = $submitStringArray2[1];
    $loginname = hexToAsciiToString($loginname);
  }
  if($submitStringArray2[0] == 'password'){
    $password = $submitStringArray2[1];
    $password = hexToAsciiToString($password);
  }
  if($submitStringArray2[0] == 'password_confirm'){
    $password_confirm = $submitStringArray2[1];
    $password_confirm = hexToAsciiToString($password_confirm);
  }
  if($submitStringArray2[0] == 'real_name'){
    $real_name = $submitStringArray2[1];
    $real_name = hexToAsciiToString($real_name);
    //echo "real_name is ".$real_name."\n<BR";
  }  
  if($submitStringArray2[0] == 'org'){
    $org = $submitStringArray2[1];
    $org = hexToAsciiToString($org);
  }
  if($submitStringArray2[0] == 'tel'){
    $tel = $submitStringArray2[1];
    $tel = hexToAsciiToString($tel);
  }
  if($submitStringArray2[0] == 'fax'){
    $fax = $submitStringArray2[1];
    $fax = hexToAsciiToString($fax);
  }
  if($submitStringArray2[0] == 'eml'){
    $eml = $submitStringArray2[1];
    $eml = hexToAsciiToString($eml);
  }
    if($submitStringArray2[0] == 'is_asih'){
      $is_asih = $submitStringArray2[1];
      $is_asih = hexToAsciiToString($is_asih);
    }
    if($submitStringArray2[0] == 'is_afs'){
      $is_afs = $submitStringArray2[1];
      $is_afs = hexToAsciiToString($is_afs);
    }

  /*
  for ($j =0 ; $j < sizeof($submitStringArray2); $j++){
    echo "submitStringArray2[".$j."] is ".$submitStringArray2[$j]."\n<br>";
  }
  */ 
}

//Connect to database
$link = mysql_connect($host , $dbuser ,$dbpasswd); 
if (!$link) {
  die('Could not connect: ' . mysql_error());
}
//select database
mysql_select_db($dbname);

$loginname_check = "No";
$loginname_check_sql = "SELECT username FROM user WHERE username ='".$loginname."'";
//echo "loginname_check_sql is ".$loginname_check_sql."/n<br>";
$result_loginname_check = mysql_query($loginname_check_sql);
if(mysql_num_rows($result_loginname_check) > 0){
  while ( $nb_loginname_check = mysql_fetch_array($result_loginname_check) ) {
    $loginname_check = "Yes";
  }
}

$regtime = date('Y-m-d h:i:s');
//Step 1:: check if password and password_confirm match
//Step 2:: cheeck email is okay
//Step 3:: insert this sign up information into database
if( $loginname == "" || $password == "" || $password_confirm == "" || $real_name == "" || $org == "" || $tel == "" || $fax == "" || $eml == "" ){
  echo "You need to fill out all fields.";
}else if($password != $password_confirm){
  echo "You need to type the same password in password and password again field.";
}else if($loginname_check == "Yes"){//check for the duplicated user ligin name 
  echo "You need to type another liginame since your loginame has been registered by another user.";
}else{
  //echo "eml is ".$eml."\n<br>";
  $activationkey = md5($loginname).md5(date('l jS \of F Y h:i:s A'));
  
  
  //$admin_email = "elviscat@gmail.com";
  //$from_email_name = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes System Administrator";
  $from_email = $admin_email;
  $from_email_name = $from_email_name;
  
  //check the email address is okay or not
  $mail = new PHPMailer();
  $mail->IsSMTP(); // send via SMTP
  $mail->Host = "slumailrelay.slu.edu"; // SMTP servers
  $mail->SMTPAuth = false; // turn on SMTP authentication
  $mail->Username = ""; // SMTP username
  $mail->Password = ""; // SMTP password
  $mail->From = $admin_email;
  $mail->FromName = $from_email_name;
  // 執行 $mail->AddAddress() 加入收件者，可以多個收件者
  $mail->AddAddress($eml);
  //$mail->AddAddress("elviscat@gmail.com","elviscat2@gmail.com"); // optional name
  $mail->AddReplyTo($admin_email,$from_email_name);
  $mail->WordWrap = 50; // set word wrap
  // 執行 $mail->AddAttachment() 加入附件，可以多個附件
  //$mail->AddAttachment("path_to/file"); // attachment
  //$mail->AddAttachment("path_to_file2", "INF");
  // 電郵內容，以下為發送 HTML 格式的郵件
  $mail->IsHTML(true); // send as HTML
  $mail->Subject = "You have signed up an account in Cyber Nomenclatorial Process Platform of North American Freshwater Fishes at ".date('l jS \of F Y h:i:s A');
  //$mail->Body = "This is the <b>HTML body</b>";
  $mail->Body = "Hi ".$real_name.",<br>";
  $mail->Body .= "Please go to this link to activate your account: <a href=\"".curPageURL()."emailvalidate.php?key=".$activationkey."\">".curPageURL()."emailvalidate.php?key=".$activationkey."</a><br>";
  $mail->Body .= "Sincerely,<br>";
  $mail->Body .= $from_email_name."System Administrator";
  $mail->AltBody = "This is the text-only body";
  if(!$mail->Send()){
    echo "Your email is not valid, please type correct email again!";
    //echo "Mailer Error: " . $mail->ErrorInfo;
    exit;
  }else{
    $maxuid = 0;
    //echo "Your recommendation has been sent.";
    //okay, insert the sign up information into database
		$max_uid_sql = "SELECT (Max(uid)+1) FROM user";
		$result_max_uid = mysql_query($max_uid_sql);	  
    list($maxuid) = mysql_fetch_row($result_max_uid);
		if($maxuid == 0){
		  $maxuid = 1;
		}
    $insert_sql = "INSERT INTO user (uid,username,passwd,eml,actlevel, actkey, role, regtime, name, addr, tel, fax, is_asih, is_afs )";
    $insert_sql .= " VALUES ('$maxuid','$loginname','$password','$eml','0', '$activationkey', 'user', '$regtime', '$real_name', '$org', '$tel', '$fax', '$is_asih', '$is_afs')";
    //echo "insert_sql is ".$insert_sql."\n<br>";
    $result=mysql_query($insert_sql);
    //echo "Yes, you can insert into database!";
    
    //echo "Your email seems correct but need to validate again. Then the account would be activated! ";//need to modified
    //Modified on April 05, 2010 Monday
    echo "Thanks for your interest in Taxon Tracker. An e-mail has been sent to the e-mail address provided to confirm it is valid.";
    //Modified on April 05, 2010 Monday
  }
}
mysql_close($link); 

?>
