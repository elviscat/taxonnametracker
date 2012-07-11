<?php
  //Developed by elviscat (elviscat@gmail.com)
  //June 23, 2010 Wednesday::New::Use jQuery AJAX drag and drop function to examine this function
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

  //$view_date = htmlspecialchars($_GET['view_date'],ENT_QUOTES);
  //echo "Variable lv is view_date:: ".$view_date."<br>\n";

  //Configuration of POST and GET Variables
  
  $caption = "Set Default Names Committee Member(s)";
  
  //customized setup  

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
	height:40px;
	background-color:#ff9;
	margin:5px auto;
	border:1px solid #999;
	line-height:40px;
	font-size:13px;
	text-align:center;
	cursor:move;
}
</style>

<?php echo "<h2>".$caption."</h2><br>\n"; ?>
<form id="set_default_com_mem_form" action="set_default_com_mem2.php" method="post">
  <input id="selected_users_output" name="selected_users_output" type="hidden" />
  <input id="unselected_users_output" name="unselected_users_output" type="hidden" />
  <button id="submit_button" name="submit_button" type="submit" onclick="compute();">Save</button>
  <!--<input type="button" value="Save" onclick="compute()" />-->
</form>
  <div id="dragdroparea">	
    <div id="selected_users">
    	<div id="dragdroparea_title">Selected User(s)</div>
    	<?php
        $sql_default_committee_member = "SELECT * FROM user WHERE is_def_com_mem = '1'"; 
        //echo "Variable sql_default_committee_member is <b>".$sql_default_committee_member."</b><br>\n";
        $result_default_committee_member = mysql_query($sql_default_committee_member);
        if(mysql_num_rows($result_default_committee_member) > 0){
          while ( $nb_default_committee_member = mysql_fetch_array($result_default_committee_member) ) {
            //
            $uid = $nb_default_committee_member[0];
            $user_name = $nb_default_committee_member[3];
            echo "<div class=\"block\" id=\"".$uid."\">".$user_name."</div>";
          }
        }     
      ?>
      <!--
      <img src="sp1.jpeg" height="150" width="200" />
      -->      
    </div>
    <div id="unselected_users">
    	<div id="dragdroparea_title">Unselected User(s)</div>
    	<?php
        $sql_non_default_committee_member = "SELECT * FROM user WHERE is_def_com_mem = '0'"; 
        //echo "Variable sql_non_default_committee_member is <b>".$sql_non_default_committee_member."</b><br>\n";
        $result_non_default_committee_member = mysql_query($sql_non_default_committee_member);
        if(mysql_num_rows($result_non_default_committee_member) > 0){
          while ( $nb_non_default_committee_member = mysql_fetch_array($result_non_default_committee_member) ) {
            //
            $uid = $nb_non_default_committee_member[0];
            $user_name = $nb_non_default_committee_member[3];
            echo "<div class=\"block\" id=\"".$uid."\">".$user_name."</div>";
          }
        }     
      ?>        
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
  <?php
  		echo "<br /><br /><a href=\"admin.php\">Back to Admin</a><BR>\n";
  ?>
<?php
  include('template2.php'); 
?>



