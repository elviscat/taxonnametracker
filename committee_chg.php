<?php
  //Developed by elviscat (elviscat@gmail.com)
  //Nov 17, 2009 Tuesday:: Change or edit content of names committee
  //June 09, 2010 Tuesday:: Testing on UTF-8 insert and apply to new layout
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
  //echo "Variable committee_id is :: ".$committee_id."<br>\n";
  //Configuration of POST and GET Variables
    
  $caption = "Edit Names Committee Information";
  
  //customized setup  
  include('template1.php');




  $sql_committee = "SELECT * FROM committee_grp WHERE id ='".$committee_id."'";
  //echo "Variable sql_committee is <b>".$sql_committee."</b><br>\n";
  $result_committee = mysql_query($sql_committee);
  if(mysql_num_rows($result_committee) > 0){
    while ( $nb_committee = mysql_fetch_array($result_committee) ) {
      $committee_name = $nb_committee[1];
      $committee_note = $nb_committee[2];
    }
  }


?>

  <?php echo "<h2>".$caption."</h2><br>\n"; ?>
  <form id="updateForm" action="committee_chg2.php" method="post">
    <input name="committee_id" type="hidden" value="<?php echo $committee_id; ?>"/>
    <table>
      <tr>
        <td colspan=2><p>Edit Names Committee Information</p></td>
      </tr>
      <tr>
        <td ><label>Names Committee Name</label></td>
        <td ><textarea name="committee_name" id="committee_name" rows="10" cols="60"><?php echo $committee_name; ?></textarea></td>
        <!--<td ><input name="committee_name" type="text" value="<?php echo $committee_name; ?>"/></td>-->
      </tr>
      <tr>
        <td ><label>Notes</label></td>
        <td ><textarea name="committee_note" id="committee_note" rows="10" cols="60"><?php echo $committee_note; ?></textarea></td>
        <!--<td ><input name="committee_note" type="text" value="<?php echo $committee_note; ?>" /><br></td>-->
      </tr>
      <tr>
        <td colspan=2><button  type="submit" onclick="confirmation(); return false;">Update</button></td>
      </tr>
    </table>
  </form>
<?php
  include('template2.php'); 
?>



  



