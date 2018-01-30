<?php
$username=$_GET['username'];
$time_out=$_GET['time_out'];
$minutes=$_GET['minutes'];
$today_date=date('Y-m-d');
  
$con = mysqli_connect('localhost','root','1122','jobs');
    if (!$con) { die('Could not connect: ' . mysqli_error($con));}
   // echo "UPDATE user_time SET time_out='$time_out',minutes='$minutes',submited=0,day_closed=1 WHERE username='".$username."' AND day_closed=0 AND date='$today_date'";
if($minutes==0) //submited=1
		mysqli_query($con,"UPDATE user_time SET time_out='$time_out',minutes='$minutes',submited=1,day_closed=1 WHERE username='".$username."' AND day_closed=0 AND date='$today_date' ;");

   else   
		mysqli_query($con,"UPDATE user_time SET time_out='$time_out',minutes='$minutes',submited=0,day_closed=1 WHERE username='".$username."' AND day_closed=0 AND date='$today_date' ;");