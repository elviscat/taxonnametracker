
  <!-- end #mainContent --></div>
  <!-- This clearing element should immediately follow the #mainContent div in order to force the #container div to contain all child floats --><br class="clearfloat" />
  <div id="footer">
    <div align="center" ><?php include("menu.php"); ?></div>
    <br>
    <div align="center" ><?php include("menu2.php"); ?></div> 
    <br>
    <div align="center" ><?php include("footer.htm"); ?></div>

  <!-- end #footer --></div>
<!-- end #container --></div>
<?php
  mysql_close($link);
?>
</body>
</html>