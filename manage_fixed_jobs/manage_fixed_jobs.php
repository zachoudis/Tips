<?php
    $con = mysqli_connect('localhost','root','1122','jobs');

    if (isset($_GET['username']))    $username=$_GET['username'];
    if (isset($_GET['description'])) $description=$_GET['description'];
    if (isset($_GET['mode']))        $mode=$_GET['mode'];
    if (isset($_GET['Id']))          $Id=$_GET['Id'];

    if ($mode=='insert'){
        $result_max = mysqli_query($con,"SELECT  MAX(Id) AS max FROM fixed_jobs");
        $row_max = mysqli_fetch_assoc($result_max);
        $max=$row_max['max']+1;
        $result = mysqli_query($con,"INSERT INTO fixed_jobs (Id_fixed,description,username) VALUES('f".$max."','".$description."','".$username."');");
        echo "INSERT INTO fixed_jobs (Id,Id_fixed,description,username) VALUES('".$max."','f".$max."','".$description."','".$username."');";
    }
    else if ($mode == 'delete'){
       $result = mysqli_query ($con,"DELETE  FROM fixed_jobs WHERE Id=".$Id);
    //    $result = mysqli_query($con, "UPDATE fixed_jobs SET isActive=0 WHERE Id=".$Id);
    }
    else if ($mode == 'edit'){
        $result = mysqli_query($con, "UPDATE fixed_jobs SET description = '".$description."' WHERE Id=".$Id);
    }

 //header("Location:http://localhost/Jobs/MainPage.php");