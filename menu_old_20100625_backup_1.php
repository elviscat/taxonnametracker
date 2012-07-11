<?php 
  //Developed by elviscat (elviscat@gmail.com)
  //April 08, 2010 Thursday::Modification::revision on layout editing
  // ./ current directory
  // ../ up level directory
?>

<!--First Link::Home-->
<a href=index.php>Home</a>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--Second Link::View Classification-->
<a href=name_list.php>View Classification</a>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--Third Link::Post Nomenclature Change(s)-->
<a href=postproposedchangemenu.php>Post Nomenclature Change(s)</a>

<!--Fourth Link::Administration Page-->
<?php
  if( isset($_SESSION['is_login']) ){
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "<a href=\"admin.php\">Admin</a>";
  }
?>

<!--Fifth Link::Login or Logout-->
<?php
  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
  /*
  if( !isset($_SESSION['is_login']) ){
    echo "<a href=\"login.php\">Login/Logout</a>";
  }else{
    echo "<a href=\"logout.php\">Logout/Login</a>";
  }*/
  if( !isset($_SESSION['is_login']) ){
    echo "<a href=\"login.php\">Login</a>";
  }else{
    echo "<a href=\"logout.php\">Logout</a>";
  }  
?>

<!--Third Link::Name List-->
<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
<!--<a href=name_list.php>Name List</a>-->
<!--Fourth Link::Login or Logout-->
<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
<!--<a href=tree_list.php>Tree View Based List</a>-->
