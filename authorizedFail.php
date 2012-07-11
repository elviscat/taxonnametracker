<?php
  //Developed by elviscat (elviscat@gmail.com)
  //March 17, 2009 Tuesday:: Authorized Fail Report Page:: tell the user that you need to login to access this page!
  //July 15, 2009 Wednesday
  //June 28, 2010 Monday:: Apply to new layout
  // ./ current directory
  // ../ up level directory

  include('template0.php');
  
  //customized setup
  
  //Configuration of POST and GET Variables
  //$committee_id = htmlspecialchars($_GET['committee_id'],ENT_QUOTES);
  //echo "Variable committee_id is <b>".$committee_id."</b><br>\n";

  //Configuration of POST and GET Variables
  
  $caption = "Secured Page Protected";
  $content = "You need to login to access to this page!";
     
  //customized setup  

  include('template1.php');
?>



<?php echo "<h2>".$caption."</h2><br>\n"; ?>
<?php echo $content; ?>

<?php
  include('template2.php'); 
?>


        








