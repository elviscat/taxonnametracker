<?php
  //Developed by elviscat (elviscat@gmail.com)
  //March 17, 2009 Tuesday:: Logout Page:: Unregister the session!
  //July 13, 2009 Monday:: Logout Page:: Unregister the session!
  //Nov 10, 2009 Tuesday:: add one auto direct page
  // ./ current directory
  // ../ up level directory
  session_start();
  session_destroy();
  Header("location:logout_already.php");
?>
