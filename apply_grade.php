<?php
include 'session.php';
$grade=$_GET['grade'];
$id=$_GET['id'];

if ($user_check == 'span' Or $user_check == 'kova')
    $grade_level="G3";
else 
    $grade_level="G2";

  $con = mysqli_connect('localhost','root','1122','jobs');
  if (!$con) { die('Could not connect: ' . mysqli_error($con));}
  mysqli_query($con,"UPDATE tasks SET ".$grade_level."='".$grade."' WHERE Id='".$id."' ;");

    
?>
