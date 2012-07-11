<?php
  //Developed by elviscat (elviscat@gmail.com)
  //June 30, 2010 Wednesday::New::Use jQuery AJAX drag and drop function to examine this function:: remove user(s) from names committee member list and email function
  // ./ current directory
  // ../ up level directory

  session_start();
  //Access control by role
  $role = $_SESSION['role'];
  if( $role != "admin"){
    Header("location:authorizedFail.php");
    exit();
  }
  //Access control by role
  include('template0.php');
  
  //customized setup
  
  //Configuration of POST and GET Variables

  $committee_id = htmlspecialchars($_GET['committee_id'],ENT_QUOTES);
  //echo "Variable committee_id is <b>".$committee_id."</b><br>\n";

  //Configuration of POST and GET Variables
  
  $caption = "Remove Committee Member(s)";
  
  //customized setup  

  if( $committee_id == ""){
    Header("location:nullPointer.php");
    exit();    
  }
  
  $pid = get_pid_from_committee_id($committee_id);
  
  $email_title = "You have been informed to be removed from this names committee";    
  $email_content = "Hi,<br>";
  $email_content .= "This email is informing you that your member role has been removed from this names committee(s).<br>";
  $email_content .= "Sincerely,<br>";
  $email_content .= "Administrator, <i>Taxon Tracker</i><br>";  

  include('template1.php');
?>

<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("jquery", "1.3");
google.load("jqueryui", "1.7");
// $(document).ready(function() {
google.setOnLoadCallback(function() {

	$('#dragdroparea').css('-moz-user-select', 'none'); //禁止fx選取文字
	$('#dragdroparea').get(0).onselectstart = function(){return false;}; //禁止IE選取文字

	//你好
	/* Mark this since the effect is strange. */
  //$(".block").draggable({revert:true}); //放開區塊回復原位
	/* Mark this since the effect is strange. */
	$(".block").draggable({helper:'clone'});

  // Unselected User(s)
	$("#unselected_users").droppable({
		accept: ".block",
		activeClass: 'droppable-active',
		hoverClass: 'droppable-hover',
		drop: function(ev, ui) {
			$(this).append($(ui.draggable));
		}
	});
	// Selected user(s) to serve as default names committee member(s)
	$("#selected_users").droppable({
		accept: ".block",
		activeClass: 'droppable-active',
		hoverClass: 'droppable-hover',
		drop: function(ev, ui) {
			$(this).append($(ui.draggable));
		}
	});

});

function compute() {
  var selected_users = $('#selected_users > .block');
  var unselected_users = $('#unselected_users > .block');
  var selected_users_output = "";
  var unselected_users_output = "";
  
  if(selected_users.length == 0){
    alert("You must pick at least one users!");
  }
  for( var i = 0; i < selected_users.length; i++){
    //alert(selected_users[i].id);
    selected_users_output += selected_users[i].id+";";
  }
  for( var i = 0; i < unselected_users.length; i++){
    //alert(unselected_users[i].id);
    unselected_users_output += unselected_users[i].id+";";
  }
  
  selected_users_output = selected_users_output.substring(0,(selected_users_output.length)-1);
  unselected_users_output = unselected_users_output.substring(0,(unselected_users_output.length)-1);
  $('#selected_users_output').val(selected_users_output);
  $('#unselected_users_output').val(unselected_users_output);
  /*
  for (var i = 0; i < element.length; i++) {
    val += element[i].id + "\n";
  }
  alert("您選擇的項目是：\n" + val);
  */
}
</script>

<style type="text/css">
#dragdroparea_title {
	color:#79B933;
	border-bottom:2px solid #f6f6f6;
	margin:5px;
	text-align:center;
}
#dragdroparea{
	margin:0 auto;
	width:550px;
	height:500px;
	text-align:center;
}
#selected_users {
	float:left;
	width:250px;
	min-height:300px;
	height:auto !important; /* fix for IE6 */
	background-color:#dedede;
}
#unselected_users {
	float:right;
	width:250px;
	min-height:300px;
	height:auto !important; /* fix for IE6 */
	background-color:#dedede;
}
.block {
	width:200px;
	/*height:40px;*/
	height:auto !important; /* fix for IE6 */
	background-color:#ff9;
	margin:5px auto;
	border:1px solid #999;
	line-height:40px;
	font-size:13px;
	text-align:center;
	cursor:move;
}
</style>

<?php echo "<h2>".$caption."</h2>"; ?>

  <div id="dragdroparea">	
    <div id="selected_users">
    	<div id="dragdroparea_title">Selected User(s)</div>
    	<?php
        $member_list = "";
        $sql_committee_member_list = "SELECT * FROM committee_member WHERE ref_c_id = '".$committee_id."'"; 
        //echo "Variable sql_committee_member_list is <b>".$sql_committee_member_list."</b><br>\n";
        $result_committee_member_list = mysql_query($sql_committee_member_list);
        if(mysql_num_rows($result_committee_member_list) > 0){
          while ( $nb_committee_member_list = mysql_fetch_array($result_committee_member_list) ) {
            //
            $uid = $nb_committee_member_list[1];
            $user_name = user_name($uid);
            //June 30, 2010 Wednesday::New::Use jQuery AJAX drag and drop function to examine this function:: remove user(s) from names committee member list and email function
            echo "<div class=\"block\" id=\"".$uid."\">".$user_name."</div>";
            //June 30, 2010 Wednesday::New::Use jQuery AJAX drag and drop function to examine this function:: remove user(s) from names committee member list and email function
            $member_list .= $uid.";";
          }
        }
        //$member_list =     
      ?>
      <!--
      <img src="sp1.jpeg" height="150" width="200" />
      -->      
    </div>
    <div id="unselected_users">
    	<div id="dragdroparea_title">Unselected User(s)</div>        
        <!--
        <div class="block" id="Barbatula toni"><i>Barbatula toni</i></div>
        <div class="block" id="Lobocheilos cornutus"><i>Lobocheilos cornutus</i></div>
        <div class="block" id="Varicorhinus robertsi"><i>Varicorhinus robertsi</i></div>
        <div class="block" id="Labeo polli">Labeo polli</div>
        -->
        <!--
        <div class="block" id="sp5">sp5</div>
        <div class="block" id="sp6">sp6</div>
        <div class="block" id="sp7">sp7</div>
        -->
    </div>
  </div>
<form id="set_com_mem_remove_form" action="set_com_mem_remove2.php" method="post">
  <input id="committee_id" name="committee_id" type="hidden" value="<?php echo $committee_id; ?>" />
  <input id="selected_users_output" name="selected_users_output" type="hidden" />
  <input id="unselected_users_output" name="unselected_users_output" type="hidden" />
  <table>
    <tr>
      <td colspan="2">You can edit the title and content if you have additional message for them. Please note that this interface is under plain text. You need to insert html tag if you want to have format on this informing email.</td>
    </tr>
    <tr>
      <td>Email Title</td>
      <td><input id="email_title" name="email_title" type="text" value="<?php echo $email_title; ?>" size="150" /></td>
    </tr>
    <tr>
      <td>Email Content</td>
      <td><textarea id="email_ccontent" name="email_content" rows="20" cols="100"><?php echo $email_content; ?></textarea></td>
    </tr>
    <tr>
      <td colspan=2>
        <button id="submit_button" name="submit_button" type="submit" onclick="compute();">Save</button>
        <!--<input type="button" value="Save" onclick="compute()" />-->
      </td>
    </tr>
  </table>
</form>
<?php
  include('template2.php'); 
?>



