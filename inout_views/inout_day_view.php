<?php
    $date = $_GET['date'];
    $db1 = mysqli_connect('localhost','root','1122','jobs');
    mysqli_set_charset($db1, "utf8");
    $users_test_sql="SELECT fullname,username FROM users ORDER BY fullname asc;";
    $result_test=mysqli_query($db1, $users_test_sql);      
?>


 <table  id="tbl_usersInOut"  cellspacing="1px">                   
    <tr>        
        <th class="title_tips" style="font-size: 16px; width:auto;" width="60">Fullname</th>
        <th class="title_tips" style="font-size: 16px;" width="42">Username</th>
        <th class="title_tips" style="font-size: 16px;" width="62">Time In</th>
        <th class="title_tips" style="font-size: 16px;" width="62">Time Out</th> 
    </tr>
<?php

 while($row_test = mysqli_fetch_array($result_test)){    
    echo "<tr style='height:15px' >";
    echo "<td style='height:15px; font-size: 15px' class='lines' align='center'> <span class='tips_id_minutes'>"  .$row_test['fullname']  . "</span></td>";
    echo "<td style='height:15px; font-size: 15px' class='lines' align='center'> <span class=''>"  .$row_test['username']. "</span></td>"; 
    echo "<td style='height:15px; font-size: 15px' class='lines' align='center'>".find_user_login($row_test['username'],$date)."</td>";
    echo "<td style='height:15px; font-size: 15px' class='lines' align='center'>".find_user_logout($row_test['username'],$date)."</td>";
    echo "</tr>";
    }

function find_user_login($username,$date){
    $db1 = mysqli_connect('localhost','root','1122','jobs');
    $users_test_sql="SELECT time_in,Id FROM user_time WHERE username='$username' AND date='".$date." 'ORDER BY Id ASC;";
    $result_test=mysqli_query($db1, $users_test_sql); 
    $row_test = mysqli_fetch_array($result_test);
    return $row_test['time_in'];  
}
  function find_user_logout($username,$date){  
    $db1 = mysqli_connect('localhost','root','1122','jobs');
    $users_test_sql="SELECT time_out,Id FROM user_time WHERE username='$username' AND date='".$date." 'ORDER BY Id DESC;";
    $result_test=mysqli_query($db1, $users_test_sql); 
    $row_test = mysqli_fetch_array($result_test);
    return $row_test['time_out'];  
}         

?>

    
    
