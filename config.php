<?php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '1122');
   define('DB_DATABASE', 'jobs');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   $con = mysqli_connect('localhost','root','1122','jobs');
?>