<?php
	//Developed by elviscat (elviscat@gmail.com)
	//February 23, 2010 Wednesday:: NEW:: New Test on Specific Nomenclature Changes Proposal
	//May 02, 2012 Wednesday:: Modification:: New Interface for use case 1 and use case 2
	//May 07, 2012 Monday:: Modification:: Debugging, fail to attach files
	
	// ./ current directory
	// ../ up level directory
	
	
	session_start();
	if( (!isset($_SESSION['is_login'])) ){
		Header("location:authorizedFail.php");
		exit();
	}
	if( (!isset($_SESSION['uid'])) ){
		Header("location:authorizedFail.php");
		exit();
	}
	if( $_SESSION['role'] == "admin" ){
		echo "System Administrator can not post proposed change!!";
		exit();
	}
	
	//Access control by login status
	if( !isset($_SESSION['is_login']) ){
		Header("location:authorizedFail.php");
		exit();
	}
	//Access control by login status
	
	include('template0.php');
	
	
	//customized setup
	
	//Configuration of POST and GET Variables
	$taxon_lv = htmlspecialchars($_GET['lv'],ENT_QUOTES);
	//echo "\$lv is <b>".$taxon_lv."</b><br />\n";
	$taxon_id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	//echo "\$id is <b>".$taxon_id."</b><br />\n";
	
	if( !isset($taxon_lv) ){
		$taxon_lv = $_POST['lv'];
	}else{
		if( $taxon_lv == ""){
			$taxon_lv = $_POST['lv'];
		}
	}
	
	if( !isset($taxon_id) ){
		$taxon_id = $_POST['id'];
	}else{
		if( $taxon_id == ""){
			$taxon_id = $_POST['id'];
		}
	}
  	if( $taxon_lv == "" || $taxon_id == ""){
  		echo "Illigal Access!";
  		exit();
  	}
	//echo "\$taxon_id is <b>".$taxon_lv."</b><br />\n";
	//echo "\$taxon_lv is <b>".$taxon_id."</b><br />\n";
	
	//Configuration of POST and GET Variables
	$taxon_name = taxon_name_without_level($taxon_lv, $taxon_id);
	
	$page_title = "Submit Taxonomic Revision :: ".$taxon_name;
	$page_heading = "Submit Taxonomic Revision :: <i>".$taxon_name."</i>";
	
	//$prefsid = $_GET['sid'];
	$prefuid = $_SESSION['uid'];
	
	include('template1.php');
	
?>

    <!-- jQuery library is required, see http://jquery.com/ -->
    <script type="text/javascript" src="jquery/jquery.js"></script>
    <!-- WYMeditor main JS file, minified version -->
    <script type="text/javascript" src="wymeditor/jquery.wymeditor.js"></script>

    <!--
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>
    -->
    
    <!-- Required for jQuery dialog demo-->
    <!--
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js" type="text/javascript"></script>
    -->
    <!--
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-darkness/jquery-ui.css" type="text/css" media="all" />
    -->
    <!-- AJAX Upload script itself doesn't have any dependencies-->
    
    
    <script type="text/javascript" src="jquery/ajaxupload.js"></script>


	<style type="text/css" title="currentStyle">
	  @import "media/css/demos.css";
	</style> 

<script type="text/javascript">
/* Here we replace each element with class 'wymeditor'
 * (typically textareas) by a WYMeditor instance.
 * 
 * We could use the 'html' option, to initialize the editor's content.
 * If this option isn't set, the content is retrieved from
 * the element being replaced.
 */



/*<![CDATA[*/
$(document).ready(function(){
  jQuery(function() {
    jQuery('.wymeditor').wymeditor(
    
    //{
      //skin: 'default',//activate silver skin
      //stylesheet: 'wymeditor/skins/default/skin.css'
    //}
    );
    
  });

	/* Example 1 */
	var attachment = "";
    var button = $('#button1'), interval;
	new AjaxUpload(button, {
		action: 'upload-handler.php', 
		name: 'userfile',
		onSubmit : function(file, ext){
			// change button text, when user selects file			
			button.text('Uploading');
							
			// If you want to allow uploading only 1 file at time,
			// you can disable upload button
			this.disable();
			
			// Uploding -> Uploading. -> Uploading...
			interval = window.setInterval(function(){
				var text = button.text();
				if (text.length < 13){
					button.text(text + '.');					
				} else {
					button.text('Uploading');				
				}
			}, 200);
		},
		onComplete: function(file, response){
			//button.text('Upload');
			button.html('<img src="images/attach.gif"/><u>Attach a file</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Upload file size limitation up to 2MB)');			
			window.clearInterval(interval);
						
			// enable upload button
			this.enable();
			// add file to the list
			//$('<li></li>').appendTo('#example1 .files').text(file);	
      //$('<li></li>').appendTo('#example1 .files').text(response);
      //$('<li></li>').appendTo('#example1 .files').text('<a href=\"tw.yahoo.com\">123</a>');
        
      //var tt=$('<a/>').attr('href','http://tw.yahoo.com').attr('target','_blank').text('yahoo');
      //tt.appendTo($('#message'));
        
      //$('<li></li>').appendTo('#example1 .message').text(tt);
        
      //$('<li></li>').appendTo('#example1 .files').text(response);
      var response_array = response.split(";");        
      attachment += response_array[0]+";";
        
      $('#attachment').val(attachment);
      $('<li></li>').appendTo('#example1 .files').html("<a href=\"download.php?id=" + response_array[0] + "\">" + response_array[1] + "</a>");
      //$('<li></li>').appendTo($('#message').html("<a href=\"download.php?id=" + response + "\">" + response + "</a>"));
        						
		}	
		//
	});
	//attachment = attachment.substring(0,(attachment.length)-1);
});/*]]>*/

</script>


      <h2>Proposed Change of Taxon Name:<BR>
Taxon: <i>Algansea lacustris</i><BR>
</h2><br>
      <div id="demo">
        <form id="postProposedChangesForm" action="postProposedChanges2.php" method="post">
          <table>
            <tr>
              <td colspan=2><p>Please fill out your proposed change information</p></td>
            </tr>
            <tr>
              <td ><label>Proposed change title</label></td>
              <td ><input name="ptitle" id="ptitle" type="text" size="100" value="Your Proposed change title" /></td>
            </tr>
            <tr>
              <td ><label>Proposed change type</label></td>
              <td >
                <select id="ptype" name="ptype">
                  <option value="Proposed Changes" selected>Proposed Changes</option>
                  <option value="Suggested Name Changes">Suggested Name Changes</option>
                </select>
                <input id="prefsid" name="prefsid" type="hidden" value="6" />
                <input id="prefsid" name="preflv" type="hidden" value="species" />
                <input id="prefuid" name="prefuid" type="hidden" value="1" />
              </td>
            </tr>
            <tr>
              <td ><label>Proposed change content</label></td>
              <!--<td ><textarea name="pcontent" rows="15" cols="25"></textarea></td>-->
              <td >
              	<textarea id="pcontent" name="pcontent" class="wymeditor">&lt;p&gt;Please post your proposed change here!&lt;/p&gt;</textarea>
              </td>
            </tr>
            <tr>
              <td colspan=2>
                <!--<ul>-->
	              <li id="example1" class="example">
		            <!--<p>You can style button as you want</p>-->
                    <div class="wrapper">	    
                      <div id="button1" class="button"><img src="images/attach.gif"/><u>Attach a file</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Upload file size limitation up to 2MB)</div>
		            </div>
		            <!--<p>Uploaded files:</p>-->
		            <ol class="files"></ol>
	              </li>
                <!--</ul>-->
                <input id="attachment" name="attachment" type="hidden" />
              </td>
            </tr>
            <tr>
              <td colspan=2>
              	<input type="submit" class="wymupdate" value="Post this proposed change" />
              	<!--<button  name="post" id="post" type="submit" onclick="confirmation(); return false;">Post</button>-->
              </td>
            </tr>            
            <!--
            <tr>
              <td colspan=2>Post your proposed change here!<br>2<img src=uploadedfiles/1247751256/kate1.jpg><br><a href=uploadedfiles/1247751256/339.gif>3</a><br>
</td>
            </tr>            
            -->
            
            <!--
            <tr>
              <td colspan=2>
                <p>
                <a href="indexSpecies.php?sfamily=">Back to Species List</a>
                </p>
              </td>
            </tr>
            -->
          </table>
        </form>
      </div>
      <div id="msg"></div>


<?php
  include('template2.php'); 
?>






