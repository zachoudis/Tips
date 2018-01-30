<?php
    include('../PHP/main_functions.php');
    include('../session.php');
    $username =  $_GET['username'];
    if ($username == 'all')
        $result = mysqli_query($con,"SELECT Id,description,username FROM fixed_jobs ORDER BY Id ASC;");
    else
        $result = mysqli_query($con,"SELECT Id,description,username FROM fixed_jobs WHERE username='".$username."';");
 
?>
  
 <table  id="fixed_jobs_table"  cellspacing="1px">                   
    <tr>        
        <th class="title_tips" style="font-size: 16px;" width="40">ID</th>
        <th class="title_tips" style="font-size: 16px;" width="615">Description</th>
        <th class="title_tips" style="font-size: 16px;" width="62">Username</th>
        <th class="title_tips" style="font-size: 16px;" width="62"></th>
        <th class="title_tips" style="font-size: 16px;" width="62"></th>
    </tr>

<?php
    while($row = mysqli_fetch_array($result)){ 
     //   if ($row['isActive']=='1'){
        echo "<tr style='height:15px' >";
        echo "<td style='height:15px; font-size: 15px' class='lines' align='center'> <span class='tips_id_minutes'>"  .floor($row['Id'])  . "</span></td>";
        echo "<td style='height:15px'                  class='lines' align='center'><div style='height:45px'  id='tttest'>" .$row['description']  . "</div></td>";
        echo "<td style='height:15px; font-size: 15px' class='lines' align='center'> <span class=''>"  .$row['username']. "</span></td>";
        echo "<td style='height:15px; font-size: 15px' class='lines' align='center'> <span class=''><button onclick='edit_fixed(".$row['Id'].")'>Edit</button></span></td>";
        echo "<td style='height:15px; font-size: 15px' class='lines' align='center'> <span class=''><button onclick='delete_fixed_job(".$row['Id'].")'>Delete</button></span></td>";
        echo "</tr>";
     //   }
    }
    echo "</table>";
?>