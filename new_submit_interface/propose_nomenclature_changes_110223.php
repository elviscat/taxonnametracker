<?php
  //Developed by elviscat (elviscat@gmail.com)
  //February 23, 2010 Wednesday:: NEW:: New Test on Specific Nomenclature Changes Proposal 
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
  //echo "Variable lv is <b>".$lv."</b><br>\n";
  $taxon_id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "Variable id is <b>".$id."</b><br>\n";


  //Configuration of POST and GET Variables
  
  $caption = "";
  
  
  //$prefsid = $_GET['sid'];
  $prefuid = $_SESSION['uid'];  
  //$taxon_name = taxon_name_without_level($taxon_lv, $taxon_id); 
  $taxon_name = taxon_name1($taxon_lv, $taxon_id);          
  
  //$taxon_name = substr($taxon_name, 7);
  //echo "taxon_name ".$taxon_name."<br>\n";
  //Configuration of POST and GET Variables
  /*
  //$taxon_name = taxon_name($taxon_lv, $taxon_id);
   
  //$caption .= "Proposed Change of Taxon Name:<BR>\n";
  //$caption .= $taxon_name."<BR>\n";
  */
  
  //$caption .= "Post your Proposed Changes or Suggested Name Changes.";

  //customized setup  

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
  //June 30, 2010 Wednesday
  //alert('Hello Elvis!');
  
<?php
  $family_name = "";
  $genus_name = "";
  $author_name = "";
  $original_infor = "";
  
  if( $taxon_lv =="species"){
    $sql_slist = "SELECT * FROM slist WHERE sid = '".$taxon_id."'"; 
    //echo "Variable sql_slist is <b>".$sql_slist."</b><br>\n";
    $result_slist = mysql_query($sql_slist);
    if(mysql_num_rows($result_slist) > 0){
      while ( $nb_slist = mysql_fetch_array($result_slist) ) {
        //
        $family_name = $nb_slist[1];
        $genus_name = $nb_slist[2];
        $author_name = $nb_slist[4];    
        $original_infor .= $nb_slist[1]." ".$nb_slist[2]." ".$nb_slist[3]." ".$nb_slist[4]." ".$nb_slist[5]." ".$nb_slist[6]." ".$nb_slist[7]." ".$nb_slist[8];
      }
    }    
  }
  $aaa = "";
  $sql_species_list_with_the_same_genus = "SELECT * FROM slist WHERE sgenus = '".$genus_name."'"; 
  //echo "Variable sql_species_list_with_the_same_genus is <b>".$sql_species_list_with_the_same_genus."</b><br>\n";
    $result_species_list_with_the_same_genus = mysql_query($sql_species_list_with_the_same_genus);
    if(mysql_num_rows($result_species_list_with_the_same_genus) > 0){
      while ( $nb_species_list_with_the_same_genus = mysql_fetch_array($result_species_list_with_the_same_genus) ) {
        //
        //echo "<option value=\\\"".$nb_species_list_with_the_same_genus[0]."\\\">".$nb_species_list_with_the_same_genus[2].$nb_species_list_with_the_same_genus[3]."</option>";
        $aaa .= "<option value=\\\"".$nb_species_list_with_the_same_genus[0]."\\\">".$nb_species_list_with_the_same_genus[2]." ".$nb_species_list_with_the_same_genus[3]."</option>";
      }
    }
  
?>
  
  $("#ptype").change(function() {
    //alert("Option changed!");
    //alert('Hello Elvis, this is radio change event!');
    <?php echo "var taxon = '".$taxon_name."';\n"; ?>
    <?php echo "var aaa = '".$aaa."';\n"; ?>
    <?php echo "var family_name = '".$family_name."';\n"; ?>
    <?php echo "var genus_name = '".$genus_name."';\n"; ?>
    
    if ($("#ptype").val() == 'type1'){
      //alert('111');
      $('#title').html('New Species <i>' + genus_name + '</i> <input id=\"sspecies\" name=\"sspecies\" type=/\"text/\" /> is described out of <i>' + taxon + '</i>.<br><br>' + '<input id=\"sgenus\" name=\"sgenus\" type=\"hidden\" value=\"' + genus_name + '\" /><input id=\"ori_species_name\" name=\"ori_species_name\" type=\"hidden\" value=\"' + taxon + '\" />Please also provide the following information:<br><br>Family : <input id=\"sfamily\" name=\"sfamily\" type=\"text\" value=\"' + family_name + '\"/><br><br>Author : <input id=\"sauthor\" name=\"sauthor\" type=\"text\" /> (e.g.: Jone, 2010)<br><br>Common Name(s) : <input id=\"scommon_name\" name=\"scommon_name\" type=\"text\" /> (You can type multiple common names using semicolon, e.g.: common name 1;common name 2)<br><br>');
      //$("#title").append('111');
      
    }
    if ($("#ptype").val() == 'type2'){
      //alert('222');
      $('#title').html('This Species <i>' + taxon + '</i> is synonymized with <select id=\"species_id\" name=\"species_id\">' + aaa + '</select>.' + '<input id="test" name=\"test\" type=\"hidden\" value=\"test222\" />');
      //$("#title").append('222');

    }
             
  });

  

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
	$("#preview").click(function(){
    //alert('Hello, preview!');
    var result = '<?php echo $original_infor; ?>';
    // 參考: JavaScript replace() Method
    // stringObject.replace(findstring,newstring)
    // replace 語法: variable.replace(regex, '要取代成什麼字')
    
    var to = $("#to").val();
    //alert('to is ::'+to);

    var from = $("#from").val();
    //alert('from is ::'+from);
    
    //alert('result is ::'+result);
    /*
    //var regex=/book\d+/gi;  // 不能寫成 regex="/book\d+/gi";
    //alert(str.replace(regex,"test")); // 把 book123 取代成 test
    var regex=/+from+\+/gi;  // 不能寫成 regex="/book\d+/gi";
    str.replace(regex,to));
    $('#result').html(result);
    */
    
    /*
    var OrgStr = 'ABCDR'
    var regStr = 'R'
    var re = new RegExp (regStr, 'gi') ;
    OrgStr = OrgStr.replace(re,"E");
    */
    var author_name = '<?php echo $author_name; ?>';
    var author_name2 = '(<?php echo $author_name; ?>)';
    
    var OrgStr = result
    var regStr = from
    var re = new RegExp (regStr, 'gi') ;
    OrgStr = OrgStr.replace(re,to); 
    
    var regStr = author_name
    var re = new RegExp (regStr, 'gi') ;
    OrgStr = OrgStr.replace(re,author_name2);    
       
    //alert('result2 is ::'+OrgStr);
    $('#result').html(OrgStr);
    
    var sid = '<?php echo $taxon_id; ?>';
    
    var column_name = 'sfamily';
    
    if($("#pcolumn").val() == 'Genus'){
      column_name = 'sgenus';
    }
    
    var hide_script = 'Update slist SET ' + column_name + ' = \'' + to + '\', sauthor = \'' + author_name2 + '\' WHERE sid = ' + sid;
    
    //alert(hide_script);
    
    $('#hide_script').val(hide_script);
    
    return false;
	});

});/*]]>*/

</script>


      <?php echo "<h3>".$caption."</h3><br>\n"; ?>
      <div id="demo">
        <form id="postProposedChangesForm" action="propose_nomenclature_changes2_110223.php" method="post">
          <table>
            <tr>
              <td colspan=2><p>Please fill out your proposed change information</p></td>
            </tr>
            <!--
            <tr>
              <td><label>Proposed change title</label></td>
              <td><input name="ptitle" id="ptitle" type="text" size="100" value="Your Proposed change title" /></td>
            </tr>
            -->
            <tr>
              <td width="100"><label>Please choose your proposed change type:</label></td>
              <td>
                <select id="ptype" name="ptype">
                  <option value="--" selected>--</option>
                  <option value="type1">Type 1: New species is described out of existing species</option>
                  <option value="type2">Type 2: This species is synonymized with existing species</option>
                </select>
                
                <input id="prefsid" name="prefsid" type="hidden" value="<?php echo $taxon_id; ?>" />
                <input id="preflv" name="preflv" type="hidden" value="<?php echo $taxon_lv; ?>" />
                <input id="prefuid" name="prefuid" type="hidden" value="<?php echo $prefuid; ?>" />
                <input id="hide_script" name="hide_script" type="hidden" />
                
              </td>
            </tr>

            <tr>
              <td><label>Title:</label></td>
              <td>
                <div id="title" name="title"></div>
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
                <a href="indexSpecies.php?sfamily=<? //echo $sfamily; ?>">Back to Species List</a>
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






