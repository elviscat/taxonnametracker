<?php
  //Developed by elviscat (elviscat@gmail.com)
  //May 12, 2010 Wednesday:: What is Systematics?
  // ./ current directory
  // ../ up level directory

  include('template0.php');
    
  //customized setup
  //Configuration of POST and GET Variables
  //$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "Variable id is :: ".$id."<br>\n";
  //Configuration of POST and GET Variables
    
  $caption = "What is Systematics?";
  
  //customized setup  
  include('template1.php');
?>
<?php echo "<h3>".$caption."</h3><br>\n"; ?>
<B>Systematics</B><br>
This scientific and comparative field
involves the reconstruction or inference of historical, evolutionary
or genealogical relationships among taxa (involves comparative
studies of differences and similarities). Methods are used to
decipher the historical patterns of speciation of life, or generate
phylogenetic trees or hypotheses of life.

<?php
  include('template2.php'); 
?>

