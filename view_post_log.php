<?php
  //Developed by elviscat (elviscat@gmail.com)
  //June 15, 2010 Tuesday:: NEW:: View post log history
  // ./ current directory
  // ../ up level directory

  session_start();

  //Access control by login status
  if( !isset($_SESSION['is_login']) ){
    Header("location:authorizedFail.php");
    exit();
  }
  //Access control by login status

  include('template0.php');

  
  //customized setup
  
  //Configuration of POST and GET Variables
  $pid = htmlspecialchars($_GET['pid'],ENT_QUOTES);
  //echo "Variable pid is :: ".$pid."<br>\n";
  $uid = htmlspecialchars($_GET['uid'],ENT_QUOTES);
  //echo "Variable uid is :: ".$uid."<br>\n";
  //Configuration of POST and GET Variables
  $caption = "";
  $content = "";
  
  if( $pid != "" && $uid != ""){
    //
    $user_name = user_name($uid);
    $caption = "Complete Log History for this post on user: ".$user_name."\n";
    
    //sql sample: SELECT * FROM post_view_log WHERE refpid =2 AND refuid =3 
    $sql_post_view_log = "SELECT * FROM post_view_log WHERE refuid = '".$uid."' AND refpid = '".$pid." 'ORDER BY id DESC"; 
    //echo "Variable sql_post_view_log is <b>".$sql_post_view_log."</b><br>\n";
    $result_post_view_log = mysql_query($sql_post_view_log);
    if(mysql_num_rows($result_post_view_log) > 0){
      $content .= "<table width=\"800\"><tr>\n";
      $content .= "<td>Series Number</td>\n";
      $content .= "<td>Lunch Date and Time</td>\n";
      $content .= "</tr>\n";
      while ( $nb_post_view_log = mysql_fetch_array($result_post_view_log) ) {
        $id = $nb_post_view_log[0];
        $lunch_datetime = $nb_post_view_log[1];

        $content .= "<tr>\n";
        $content .= "<td>".$id."</td>\n";//Series Number
        $content .= "<td>".$lunch_datetime."</td>\n";//Lunch Date and Time
        $content .= "</tr>\n";                
      }
      $content .= "</table>\n";
    }  
  }
  //customized setup  

  include('template1.php');
?>
      <?php echo "<h2>".$caption."</h2><br>\n"; ?>
      <?php echo $content; ?>

<?php
  include('template2.php'); 
?>
