<?php
    $username=$_GET['username'];
   
    $date=date('Y-m-d');
    $time=date('H:i',strtotime('+3 hours'));
    $con = mysqli_connect('localhost','root','1122','jobs');
           
    $result = mysqli_query($con,"INSERT INTO user_time (username,date,time_in,day_closed) VALUES('$username','$date','$time','0');");
    //echo "INSERT INTO user_time (username,date,time_in,day_closed) VALUES('$user','$date','$time','0');";
//    echo "<span id='logon_message'>Log On : ".$time." (".floor_time_in($time).")</span>";
         
?>