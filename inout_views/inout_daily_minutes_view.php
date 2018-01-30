<?php
    $date = $_GET['date'];
    $user =  $_GET['user'];
    include('../PHP/main_functions.php');
    include('../session.php');
?>

<br>
 <table  id="fixed_jobs_table"  cellspacing="1px">                   
    <tr>        
        <th class="title_tips" style="font-size: 16px; width: auto;" width="102">Fullname</th>
        <th class="title_tips" style="font-size: 16px;" width="42">Username</th>
        <th class="title_tips" style="font-size: 16px; width: auto;" width="62">Project</th>
        <th class="title_tips" style="font-size: 16px;" width="62">Minutes</th> 
    </tr>
    <?php
    $get_id_time=mysqli_query($con,"SELECT Id FROM user_time WHERE username='".$user."' And date='".$date."';");
 
    while($row = mysqli_fetch_array($get_id_time)){
        $result = mysqli_query($con,"SELECT Id,username,minutes,id_Tip FROM project_time WHERE id_Time='".$row['Id']."'");
        while($row_test = mysqli_fetch_array($result)){          
            echo "<tr style='height:15px' >";
            echo "<td style='height:15px; font-size: 15px' class='lines' align='center'> <span class='tips_id_minutes'>"  .find_user_fullname($row_test['username']). "</span></td>";
            echo "<td style='height:15px; font-size: 15px' class='lines' align='center'> <span class='tips_id_minutes'>"  .$row_test['username']  . "</span></td>";
            echo "<td style='height:15px; font-size: 15px' class='lines' align='center'> <span class=''>"  .find_project($row_test['id_Tip'],$con). "</span></td>"; 
            echo "<td style='height:15px; font-size: 15px' class='lines' align='center'> <span class=''>"  .$row_test['minutes']. "</span></td>"; 
            echo "</tr>";
        }
    }
 
 
 function find_project($id,$con){
    if ($id[0] == 'f'){
        $db1 = mysqli_connect('localhost','root','1122','jobs');
      //  mysqli_set_charset($db1, "utf8");
        $result_test=mysqli_query($db1,"SELECT description FROM fixed_jobs WHERE Id_fixed='".$id."';"); 
        $row = mysqli_fetch_array($result_test);
        return $row['description'];
    }
    else{
        $get_id=mysqli_query($con,"SELECT project FROM tasks WHERE Id='$id';");
        $row = mysqli_fetch_array($get_id);
         return $row['project']; 
    }
 }
 function find_user_fullname($username){
    $db1 = mysqli_connect('localhost','root','1122','jobs');
    mysqli_set_charset($db1, "utf8");
 
    $result_test=mysqli_query($db1,"SELECT fullname FROM users WHERE username='".$username."';"); 
    $row_test = mysqli_fetch_array($result_test);
   
    return $row_test['fullname'];
}
?>
 