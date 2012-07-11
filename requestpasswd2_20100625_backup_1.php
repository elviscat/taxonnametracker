<?php 
session_start();
include('template/dbsetup.php');
require('phpmailer/class.phpmailer.php');

//Developed by elviscat
//July 13, 2009 Monday

//$submitString = chr($submitString);
//echo "hexdec(\"40\") is ".dechex(%40)."<BR>\n";
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
$eml;

for ($i =0 ; $i < sizeof($submitStringArray); $i++){
  //echo "submitStringArray[".$i."] is ".$submitStringArray[$i]."\n<br>";
  $submitStringArray2 = explode("=", $submitStringArray[$i]);
  if($submitStringArray2[0] == 'loginname'){
    $loginname = $submitStringArray2[1];
    $loginname = hexToAsciiToString($loginname);
  }
  if($submitStringArray2[0] == 'eml'){
    $eml = $submitStringArray2[1];
    $eml = hexToAsciiToString($eml);
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

$account_check = "No";
$real_name = "";
$password = "";
$account_check_sql = "SELECT username, name, passwd FROM user WHERE username ='".$loginname."' AND eml ='".$eml."'";
//echo "account_check_sql is ".$account_check_sql."/n<br>";
$result_account_check = mysql_query($account_check_sql);
if(mysql_num_rows($result_account_check) > 0){
  while ( $nb_account_check = mysql_fetch_array($result_account_check) ) {
    $account_check = "Yes";
    $real_name = $nb_account_check[1];
    $password = $nb_account_check[2];
  }
}

if( $loginname == "" || $eml == "" ){
  echo "You need to fill out all fields.";
}else if($account_check == "No"){//check if this account is live or not 
  echo "Your account name or email address is not correct!.";
}else{

  $admin_email = "elviscat@gmail.com";
  $from_email_name = "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes System Administrator";
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
  $mail->Subject = "Your password for account: ".$loginname."!";
  //$mail->Body = "This is the <b>HTML body</b>";
  $mail->Body = "Hi ".$real_name.",<br>";
  $mail->Body .= "Here is your password: ".$password."<br>";
  $mail->Body .= "Sincerely,<br>";
  $mail->Body .= "Cyber Nomenclatorial Process Platform of North American Freshwater Fishes System Administrator";
  $mail->AltBody = "This is the text-only body";
  if(!$mail->Send()){
    echo "Your email seems not work!";
    //echo "Mailer Error: " . $mail->ErrorInfo;
    exit;
  }else{
    echo "We have emailed your password to you!";
  }
}
mysql_close($link); 

?>
