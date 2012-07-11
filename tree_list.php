<?php
  //Developed by elviscat (elviscat@gmail.com)
  //Oct 04, 2009 Sunday:: tree table check sample
  //Dec 08, 2009 Tuesday:: modification and integration to main application
  //Jan 26, 2010 Tuesday:: Layout and logic modification, add template
  //Mar 14, 2010 Sunday:: Caption modification
  //February 27, 2011 Sunday:: Code Logic modification
  //Mar 01, 2012 Tuesday:: Logic modification:: Mark family and genus group change
  
  //July 06, 2012 Friday:: Layout Debugging
  // ./ current directory
  // ../ up level directory

  session_start();

  include('template0.php');

  
  //customized setup
  
  //Configuration of POST and GET Variables
  //$pid = htmlspecialchars($_GET['pid'],ENT_QUOTES);
  //echo "Variable pid is <b>".$pid."</b><br>\n";
  //Configuration of POST and GET Variables
  
  
  $page_title = "Submit Multiple Changes";

  $page_heading = "Biological classification Based Interface of Posting Proposed Changes on Multiple Taxa<BR>";
  $page_heading .= "STEP 1: Select Multiple Taxa (Build Change Taxa List)<BR>";
  $page_heading .= "STEP 2: Make Sure and Go to Post Page"; 

  $sql = "SELECT * FROM flist WHERE is_valid ='1'";  
  //echo "Variable sql is :: ".$sql."\n<BR>";
  $result_sql = mysql_query($sql);

  include('template1.php');
?>
	<link href="template/master.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="jquery/jquery.js"></script>
	<script type="text/javascript" src="jquery/jquery.ui.js"></script>
		<title><? echo $title; ?></title>
		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
    
      <!-- BEGIN Plugin Code -->  
      <link href="template/jquery.treeTable.css" rel="stylesheet" type="text/css" />
      <script type="text/javascript" src="jquery/jquery.treeTable.js"></script>
      <script type="text/javascript">
        $(document).ready(function() {

          
          $(".example").treeTable({
            //initialState: "expanded"
          });
    
          // Drag & Drop Example Code
          $("#dnd-example .file, #dnd-example .folder").draggable({
            helper: "clone",
            opacity: .75,
            refreshPositions: true,
            revert: "invalid",
            revertDuration: 300,
            scroll: true
          });
    
          $("#dnd-example .folder").each(function() {
            $($(this).parents("tr")[0]).droppable({
              accept: ".file, .folder",
              drop: function(e, ui) { 
              $($(ui.draggable).parents("tr")[0]).appendBranchTo(this);          
              // Issue a POST call to send the new location (this) of the 
              // node (ui.draggable) to the server.
              $.post("move.php", {id: $(ui.draggable).parents("tr")[0].id, to: this.id});
              },
              hoverClass: "accept",
              over: function(e, ui) {
                if(this.id != $(ui.draggable.parents("tr.parent")[0]).id && !$(this).is(".expanded")) {
                  $(this).expand();
                }
              }
            });
          });
          // Make visible that a row is clicked
          $("table#dnd-example tbody tr").mousedown(function() {
            $("tr.selected").removeClass("selected"); // Deselect currently selected rows
            $(this).addClass("selected");
          });
          // Make sure row is selected when span is clicked
          $("table#dnd-example tbody tr span").mousedown(function() {
            $($(this).parents("tr")[0]).trigger("mousedown");
          });
          
          $("#selected_taxa_submit").click(function(){
            //
            
            if($('#selected_taxa').val() == ""){
          	  alert("You need to click the above button to check your selected taxon or taxon!!");
              //break;
              //exit();
              return false;
            }
            
            //
            //alert("Hello Elvis!");
          });
          
          $("#selectListButton").click(function(){
            var selected_taxa_account_name = "";
            var selected_taxa_account = "";
            
            $("input[name='check_account']").each(function() {
              selected_taxa_account_name += "<i>";
              if(this.checked == true){
                var temp_array1 = ($(this).val()).split(";");
                //selected_committee_id += $(this).val() + ",";
                //selected_committee_text += $(this).text() + ",";
                //selected_taxa_account_name += temp_array1[0]+ ":" + temp_array1[2] + ",";
                selected_taxa_account_name += temp_array1[2] + ", ";
                selected_taxa_account += temp_array1[0] + ";" + temp_array1[1] + ",";
                //selected_taxa_account += $(this).val()+ ",";
              }
              selected_taxa_account_name += "</i>";
            });
            
            selected_taxa_account_name = selected_taxa_account_name.substring(0,(selected_taxa_account_name.length)-1);
            
            selected_taxa_account = selected_taxa_account.substring(0,(selected_taxa_account.length)-1);
            
            //var output_of_selected_taxa = "<B>Taxon List: </B><BR>";
            var output_of_selected_taxa = "<B>You select these taxa to change: </B><BR />";
            $('#selected_taxa').val(selected_taxa_account);
            $('#output_of_selected_taxa').html(output_of_selected_taxa + selected_taxa_account_name);
            //alert("Hello Elvis");
            //alert(output_of_selected_taxa + selected_taxa_account);
          });
        });
      </script>
      <!--<script type="text/javascript" src="jquery/jquery-1.3.2.js"></script>
      <script type="text/javascript" src="jquery/jquery.form.js"></script>
      <script>
        /*
        function submit() {
          alert('Hello elvis!');
          var submitString = $('#submitForm').formSerialize();
          
          $.post("post2.php",{submitString:submitString},function(data){
            //do something
            //alert(data);
            //alert("Hello Elvis!!");
            $('#msg').html(data);
	        });
	        
        }
        $(document).ready(function(e){
          $('#submitForm').ajaxForm(submit);	
        });
        */
      </script>-->
      <!-- END Plugin Code -->

      <?php echo "<h3>".$page_heading."</h3><br>\n"; ?>
      <!--Code is here!-->
      
          <table class="example" id="dnd-example">
            <thead>
              <tr>
                <th>Classification</th>
                <th>Scientific Name</th>
                <th>Author</th>
                <th>English Common Name</th>
                <th>Check it for propose the change!</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $counter = 0;
                $counter_of_family = 0;
                if(mysql_num_rows($result_sql) > 0){
                  while ( $nb_sql = mysql_fetch_array($result_sql) ) {
                    $counter_of_family ++;          
              ?>
              <tr id="node-<?php echo $counter_of_family; ?>">
				<?php
					echo "<td colspan=\"5\">".$nb_sql['ffamily']."</td>\n"
					//echo "<td><input type=\"checkbox\" name=\"check_account\" value=\"family;".$nb_sql[0].";".$nb_sql['ffamily']."\"></input></td>";
				?>
              </tr>
              <?php
                    $sql2 = "SELECT * FROM glist WHERE refid ='".$nb_sql[0]."' AND is_valid ='1'";
                    $result_sql2 = mysql_query($sql2);
                    $counter_of_genus = 0;
                    if(mysql_num_rows($result_sql2) > 0){
                      while ( $nb_sql2 = mysql_fetch_array($result_sql2) ) {
                        $counter_of_genus ++;                     
              ?>
              <tr id="node-<?php echo $counter_of_family; ?>-<?php echo $counter_of_genus; ?>" class="child-of-node-<?php echo $counter_of_family;?>">
				<?php
					echo "<td colspan=\"5\">".$nb_sql2['ggenus']."</td>\n";
					//echo "<td><input type=\"checkbox\" name=\"check_account\" value=\"genus;".$nb_sql2[0].";".$nb_sql2['ggenus']."\"></input></td>\n";
				?>
              </tr>
              <?php
                        $sql3 = "SELECT * FROM slist WHERE sfamily ='".$nb_sql[11]."' and sgenus ='".$nb_sql2[2]."' AND is_valid ='1' AND goes_to = '0'";
                        $result_sql3 = mysql_query($sql3);
                        $counter_of_species = 0;
                        if(mysql_num_rows($result_sql3) > 0){
                          while ( $nb_sql3 = mysql_fetch_array($result_sql3) ) {
                            $counter_of_species ++;                     
              ?>
              <tr id="node-<?php echo $counter_of_family; ?>-<?php echo $counter_of_genus; ?>-<?php echo $counter_of_species; ?>" class="child-of-node-<?php echo $counter_of_family;?>-<?php echo $counter_of_genus;?>">
                <td><?php //echo $nb3[1]; ?></td>
                <td><i><?php echo $nb_sql3['sgenus']." ".$nb_sql3['sspecies']; ?></i></td>
                <td><?php echo $nb_sql3['sauthor']; ?></td>
                <td><?php echo $nb_sql3['scommon_name']; ?></td>
                <td>
                  <?php
                    //echo "<input type=\"checkbox\" name=\"id-".$nb3['sid']."\" value=\"".$nb3['sid']."\" ";
                    //echo "<input type=\"checkbox\" name=\"id\" value=\"".$nb3['sid']."\" ";
                    echo "<input type=\"checkbox\" name=\"check_account\" value=\"species;".$nb_sql3['sid'].";".$nb_sql3['sgenus']." ".$nb_sql3['sspecies']."\"";
                    echo ">";
                  ?>
                </td>
              </tr>
              <?php
                          }
                        }
                      }
                    }
                  }
                }
              ?>
              <tr>
                <td colspan="5">
                  <!--<button id="selectListButton"><font color="Red">Select and check your selected taxon entry/account then click the following button to post your proposed change!</font></button>-->
                  <button id="selectListButton"><font color="Red">STEP1: Build Change List --> List Proposed Taxon</font></button>
                  <div id="output_of_selected_taxa"></div>
                </td>
              </tr>
            </tbody>
          </table>

        <form id="submitForm" action="postProposedChanges_m.php" method="post">
          <table>
            <tr>
              <td>
                <input id="selected_taxa" name="selected_taxa" type="hidden" />
                <!--<input id="selected_taxa_submit" name="selected_taxa_submit" type="submit" value="Post the propose change in these checked taxon entry/account!" />-->
                <input id="selected_taxa_submit" name="selected_taxa_submit" type="submit" value="STEP2: Are you sure you want to change? Click this button." />
              </td>
            </tr>
          </table>
        </form>
        <div id="msg"></div>
      <!--Code is here!-->

<?php
  include('template2.php'); 
?>



















