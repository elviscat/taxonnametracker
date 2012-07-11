<?php
  //Developed by elviscat (elviscat@gmail.com)
  //May 12, 2010 Wednesday:: Introduction
  // ./ current directory
  // ../ up level directory

  include('template0.php');
  
  //customized setup
  //Configuration of POST and GET Variables
  //$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "Variable id is :: ".$id."<br>\n";
  //Configuration of POST and GET Variables
    
  $caption = "Introduction";
  
  //customized setup  
  include('template1.php');  
?>
<?php echo "<h3>".$caption."</h3><br>\n"; ?>
Biological classifications are fundamental in comparative biology, as they depict relationships of species.
The factors involved in and processes underlying establishing a taxonomy and nomenclatorial changes are also important process in biology research and education.
This application provides a cyber platform on the classification of North American freshwater fishes to display the current species diversity and taxonomy (along with common names), reasoning behind the taxonomy, and an environment wherein users can discuss and collaborate on proposed changes in the taxonomy.
Anyone is welcome to contribute new information relevant to the classification of these fishes and/or monitor and participate in discussions.
Only registered users can contribute to discussions.
You can easily <a href="signup.php">register/sign up</a> for an account here and begin contributing.

<?php
  include('template2.php'); 
?>

