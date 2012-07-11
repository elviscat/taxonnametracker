<?php
  //Developed by elviscat (elviscat@gmail.com)
  //May 12, 2010 Wednesday:: Using Taxon Tracker
  // ./ current directory
  // ../ up level directory

  include('template0.php');
  
  //customized setup
  //Configuration of POST and GET Variables
  //$id = htmlspecialchars($_GET['id'],ENT_QUOTES);
  //echo "Variable id is :: ".$id."<br>\n";
  //Configuration of POST and GET Variables
    
  $caption = "Using Taxon Tracker";
  
  //customized setup  
  include('template1.php');
?>
<?php echo "<h3>".$caption."</h3><br>\n"; ?>
1.Public announcements:<br>
Public announcements of new evidence-based research and opinions regarding new species and changes in nomenclature and biological classifications provides a transparent arena for scientists to discuss and debate issues, if necessary, and for others with a more limited understanding of the systematic and taxonomic processes foundational to biological classifications to learn more about the process by raising questions and following discussions.<BR>
2.Maintain classification:<br>
Taxon Tracker also maintains a complete classification. Here we take the fishes of the Order Cypriniformes as our example. Users can use the blogging capabilities to post new information on any taxonomic changes relating to Cypriniformes fishes as well as comment on postings, raise questions and provide opinions on taxa. A full history of discussions is archived and all evidenced-based research recommending changes in the taxonomy are open for public.<BR>
<img src="images/arch1.png" width="766" height="550" border="0">

<?php
  include('template2.php'); 
?>

