<?php
   session_start();
   echo "<script>alert('fdf');</script>";
   if(session_destroy()) {
      header("Location: login.php");
   }
?>