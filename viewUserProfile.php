<?php
	//Developed by elviscat (elviscat@gmail.com)
	//July 15, 2009 Wednesday:: View the user profile
	//Mar 14, 2010 Sunday:: add two column information
	//Mar 17, 2010 Wednesday:: modification on updating new template part code
	//February 26, 2011 Saturday::Layout modification
	//July 06, 2012 Friday:: Add "other expertise or interest on taxonomy" TABLE::`user_questionnaire`::COLUMN::att8
	
	// ./ current directory
	// ../ up level directory
	
	
	include('template0.php');
    
	//customized setup
	//Configuration of POST and GET Variables
	//$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
	//echo "Variable id is :: ".$id."<br>\n";
	$uid = htmlspecialchars($_GET['uid'],ENT_QUOTES);
	
	//Configuration of POST and GET Variables  
	
	
	
	$loginname;
	$password;
	$real_name;
	$org;
	$tel;
	$fax;
	$eml;
	$is_asih;
	$is_afs;
	
	
	$data_check = "No";
	$data_check_sql = "SELECT * FROM user WHERE uid ='".$uid."'";
	//echo "data_check_sql is ".$data_check_sql."/n<br>";
	$result_data_check = mysql_query($data_check_sql);
	if(mysql_num_rows($result_data_check) > 0){
		while ( $nb_data_check = mysql_fetch_array($result_data_check) ) {
			$data_check = "Yes";
			$loginname = $nb_data_check[1];
			$password = $nb_data_check[2];
			$real_name = $nb_data_check[3];
			$org = $nb_data_check[4];
			$tel = $nb_data_check[5];
			$fax = $nb_data_check[6];
			$eml = $nb_data_check[7];
			$is_asih = $nb_data_check[15];
			$is_afs = $nb_data_check[16];
		}
	}
	
	$other_expertise;
    
    
	$sql_questionnaire = "SELECT * FROM user_questionnaire WHERE ref_uid ='".$uid."'";
	//echo "\$sql_questionnaire is ".$sql_questionnaire."/n<br>";
	$result_questionnaire = mysql_query($sql_questionnaire);
	if(mysql_num_rows($result_questionnaire) > 0){
		while ( $nb_questionnaire = mysql_fetch_array($result_questionnaire) ) {
			$other_expertise = $nb_questionnaire['att8'];
		}
	}
	
	
	
	$caption = "View User Profile";
	
	//customized setup  
	include('template1.php');
	
?>
<!--
		<style type="text/css" title="currentStyle">
			@import "media/css/demos.css";
		</style>
-->
        <?php echo "<h3>".$caption."</h3><br>\n"; ?>
        <form id="updateForm" action="" method="post">
          <fieldset>
            <legend><strong>User Information</strong></legend>
          <table>
            <tr>
              <td ><label>Login Name</label></td>
              <td ><input name="loginname" type="text" value="<?php echo $loginname; ?>" readonly /></td>
            </tr>
            <tr>
              <td ><label>Name</label></td>
              <td ><input name="real_name" type="text" value="<?php echo $real_name; ?>" readonly /><br></td>
            </tr>
            <tr>
              <td ><label>Organization</label></td>
              <td ><input name="org" type="text" value="<?php echo $org; ?>" readonly /><br></td>
            </tr>
            <tr>
              <td ><label>Telephone Number</label></td>
              <td ><input name="tel" type="text" value="<?php echo $tel; ?>" readonly /><br></td>
            </tr>
            <tr>
              <td ><label>Fax Number</label></td>
              <td ><input name="fax" type="text" value="<?php echo $fax; ?>" readonly /><br></td>
            </tr>                                                
            <tr>
              <td ><label>E-mail Address</label></td>
              <td ><input name="eml" type="text" value="<?php echo $eml; ?>" readonly /><br></td>
            </tr>            
            <tr>
              <td ><label>Is American Society of Ichthyology and Herpetology Member?</label></td>
              <td ><input name="is_asih" type="checkbox" value="1" <?php if($is_asih == "1"){ echo "checked"; }?>/><br></td>
            </tr>
            <tr>
              <td ><label>Is American Fisheries Society Member?</label></td>
              <td ><input name="is_afs" type="checkbox" value="1" <?php if($is_afs == "1"){ echo "checked"; }?>/><br></td>
            </tr>
			
			<tr>
              <td ><label>Other expertise or interest on taxonomy</label></td>
              <td ><textarea name="fax" rows="10" cols="30"><?php echo $other_expertise; ?></textarea><br></td>
            </tr>
            $other_expertise
          </table>
          </fieldset>
        </form>        
<?php
  include('template2.php'); 
?>




