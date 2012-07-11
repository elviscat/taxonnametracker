<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //March 17, 2009 Tuesday:: Show the Proposed Changes OR Suggestted Name Changes Detail
  // ./ current directory
  // ../ up level directory
  //!?!?
  session_start();
  //!?!?
  
  $title = "Proposed Changes or Suggestted Name Changes List Detail";
  
  $table = "";
  $replyTitle = "";
  include('template/dbsetup.php');

  //Connect to database
  $link = mysql_connect($host , $dbuser ,$dbpasswd); 
  if (!$link) {
    die('Could not connect: ' . mysql_error());
  }
  //select database
  mysql_select_db($dbname);

  $pid = $_GET['pid'];

  $sql = "SELECT * FROM post WHERE pid= '".$pid."'";  
  //echo "<BR>sql is ".$sql;
  
  $result = mysql_query($sql);
  
  $sid = "";
  
  if( mysql_num_rows($result) > 0 ){  
    while ( $nb2 = mysql_fetch_array($result) ) {
		  $sid = $nb2[5];
		  
      $table .= "<p>".$nb2[3];//create time
      $table .= "<p><h2><b>".$nb2[1]."</b></h2></p>";//title
      
      $replyTitle = $nb2[1];
      
      
      $table .= "<p>".$nb2[2]."</p><BR>";// full content
      //$table .= "<p><a href=\detail.php?pid=".$nb2[0]."\">More</a><BR><BR>";
      
      $name = "";
      if( $nb2[4] == 0){
        $name = "admin";
      }else{
        $sql2 = "SELECT name FROM user WHERE uid ='".$nb2[4]."'";
        $result2 = mysql_query($sql2);
        //echo "sql2 is ".$sql2;
        $name = mysql_result($result2, 0);
      }
      
      $sql3 = "SELECT COUNT(*) FROM comment WHERE crefpid= '".$nb2[0]."'";
      //echo "sql3 is ".$sql3;
      $result3 = mysql_query($sql3);
      $commentCount = mysql_result($result3, 0);
      
      
      
      $table .= "<B>".$name."</B> at <B>".$nb2[3]."</B> Post | Comment (<B>".$commentCount."</B>)<BR><BR>";
      
      
      
      $table .= "<hr NOSHADE>";
      
      
      
      
	  }

	}else{
	  //echo $sql;
	  $table .= "<p>Currently, there are no entries under this blog.</p>"; //no records here
	  
	  Header("location:authorizedFail.php");
	  
	  
  }
  
  $table .= "<BR><BR><a href=\"showProposedChanges.php?sid=".$sid."\">Back to Proposed Changes OR Suggestted Name Changes List</a>";
  $table .= "<BR><BR><a href=\"index.php\">Back to homepage</a>";
  
  
  $sql = "SELECT * FROM comment WHERE crefpid= '".$pid."'";  
  //echo "<BR>sql is ".$sql;
  
  $result = mysql_query($sql);
  
  $table .= "<h1><p>Comment</p></h1>";
  
  if( mysql_num_rows($result) > 0 ){  
    $commentCounter = 0;
    while ( $nb2 = mysql_fetch_array($result) ) {
		  $commentCounter += 1;
      
      $table .= "<p><h2><b>".$nb2[1]."</b></h2></p>";//ctitle
      $table .= "<p>".$nb2[2]."</p><BR>";// full ccontent
      //$table .= "<p><a href=\detail.php?pid=".$nb2[0]."\">More</a><BR><BR>";
            
      
      
      $table .= "<B>".$nb2[5]."</B> at <B>".$nb2[3]."</B> Comment<BR><BR>";
      
      
      
      $table .= "<hr NOSHADE>";
      
      
      
      
	  }

	}else{
	  //echo $sql;
	  $table .= "<p>Currently, there are no entries under this blog.</p>"; //no records here
	  
  }  
  
  
  
  
  
  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<!--<link rel="shortcut icon" type="image/ico" href="http://www.sprymedia.co.uk/media/images/favicon.ico" />-->
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" href="edit.css" type="text/css" />
    <style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
		<script type="text/javascript" language="javascript" src="media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').dataTable( {
					//"aaSorting": [[ 4, "desc" ]]
					//"aaSorting": [[0,'asc'], [1,'desc'], [2,'desc']]
					//"aaSorting": [[0,'asc'], [1,'asc']]
					"aaSorting": [[1,'asc'], [2,'asc'], [3,'asc']]
				} );
			} );
		</script>
    <script type="text/javascript">
    <!--
      function confirmation(a) {
	    var answer = confirm("Delete it?")
	      if (answer){
		      alert("Ok, We will delete this post entry.")
		      window.location = "deletePost.php?pid=" + a;
	      }else{
		      alert("You are clever, not delete me!")
		      return false;
	      }
      }
    //-->
    </script>
	</head>
	<body id="dt_example">
		<div id="container">	
			<h1><?php echo $title; ?></h1>
			<?php
        //if( !isset($_SESSION['loginName']) || ($_SESSION['loginName'] != "admin") ){
        //  echo "<h2><a href=\"login.php\">Login</a></h2>";
        //}else{
        //  echo "<h2><a href=\"logout.php\">Logout</a></h2>";
        //}
			?>
      <div id="demo">
      <!--Table is here!!-->
      <?php 
        echo $table;
      ?>
      <!--Table is here!!-->
			</div>
      <div class="spacer"></div>
      
			<div id="footer" style="text-align:center;">
				<!--
        <span style="font-size:10px;">
					DataTables &copy; Allan Jardine 2008-2009.<br>
					Information in the table &copy; <a href="http://www.u4eatech.com">U4EA Technologies</a> 2007-2009.</span>-->
			</div>
		</div>
		<!--Comment Post Form-->
    <div id="basic" class="myform">
      <h1>Add a new comment!</h1>
      <p>Please leave you comment here.</p>
      <form id="commentPost" action="postProposedChangesComment.php" method="post">
        <label>Title
          <span class="small">Add title</span>
        </label>
          <input id="crefpid" name="crefpid" type="hidden" value="<? echo $pid; ?>" />
          <input id="ctitle" name="ctitle" type="text" size="100" value="<? echo "RE:".$replyTitle; ?>" />
	    <label>Name
          <span class="small">Add your name</span>
        </label>
          <input id="cname" name="cname" type="text" size="100" value="<? echo $_SESSION['username']; ?>" />
	    <label>Web Site
          <span class="small">Add your website</span>
        </label>
          <input id="cwebsite" name="cwebsite" type="text" size="100" value="" />
	    <label>Msn
          <span class="small">Add your msn</span>
        </label>
          <input id="cmsn" name="cmsn" type="text" size="100" value="" />
	    <label>Comment
          <span class="small">Add your comment</span>
        </label>
          <!--<span class="small">--><textarea name="ccontent" rows="25" cols="25"></textarea><!--</span><p>-->
	    
	    <?php
          $sql_post = "SELECT * FROM post WHERE pid = ".$pid; 
          //echo "sql_post is ::".$sql_post."<br>\n";
          $result_sql_post = mysql_query($sql_post);
          if(mysql_num_rows($result_sql_post) > 0){
            while ( $nbb = mysql_fetch_array($result_sql_post) ) {
              $level = $nbb[5];
              $account_id = $nbb[6];
              $sql_committee_account = "SELECT * FROM committee_account WHERE level = '".$level."' AND account_id ='".$account_id."'"; 
              //echo "sql_committee_account is ::".$sql_committee_account."<br>\n";
              $result_sql_committee_account = mysql_query($sql_committee_account);
              if(mysql_num_rows($result_sql_committee_account) > 0){
                while ( $nbb2 = mysql_fetch_array($result_sql_committee_account) ) {
                  $committee_grp_id = $nbb2[3];
                  $sql_committee_member = "SELECT * FROM committee_member WHERE user_id = '".$_SESSION['uid']."' AND ref_c_id ='".$committee_grp_id."'"; 
                  //echo "sql_committee_member is ::".$sql_committee_member."<br>\n";
                  $result_sql_committee_member = mysql_query($sql_committee_member);
                  if(mysql_num_rows($result_sql_committee_member) > 0){
                    while ( $nbb3 = mysql_fetch_array($result_sql_committee_member) ) {
                      echo "<br>\n";
                      echo "You are the Names Committee Member on this taxon acccount!<br>\n";
                      //echo "Make this comment as review opinion on this taxon account!<br>\n";
                      echo "<input type=\"checkbox\" name=\"review_check\" value=\"review_check\">Make this comment as review opinion on this taxon account!<br>\n";
                    }
                  }
                }
              }
            }
          }
	    //<label>
        //  <span class="small">Add your msn</span>
        //</label>
        //  <input id="cmsn" name="cmsn" type="text" size="100" value="" />        
        
        
        ?>
        <button  type="submit">Post it!</button><BR><BR>
      </form>
      <br><br>
      <!--<div align="center"><p><a href="index.php">Back to management page</a></p></div>-->
      <!--<div align="center"><a href="../index.php">Return to index</a><br></div>-->
    </div>
    <!--Comment Post Form-->      
	</body>
</html>
<?php
  mysql_close($link);
?>