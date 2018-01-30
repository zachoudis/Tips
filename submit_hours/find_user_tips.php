<?php
  include('../PHP/main_functions.php');
  include('../session.php');
  $con = mysqli_connect('localhost','root','1122','jobs');
  $result = mysqli_query($con,"SELECT Id,description,state,project,closed FROM tasks WHERE ipey8inos='".  get_name_from_username($user_check)."' AND Id LIKE '%.000%' ORDER BY Id DESC;");
?>

<table   id="projects"  cellspacing="1px">                   
    <tr>        
        <th class="title_tips" style="font-size: 16px;" width="40">ID</th>
        <th class="title_tips" style="font-size: 16px;" width="80">Project</th>
        <th class="title_tips" style="font-size: 16px;" width="315">Description</th>
        <th class="title_tips" style="font-size: 16px;" width="62">State</th>
        <th class="title_tips" style="font-size: 16px;" width="62">Minutes</th>
    </tr>
<?php
    while($row = mysqli_fetch_array($result)){ 
        if ($row['closed']!=1){
            echo "<tr style='height:15px' >";
            echo "<td style='height:15px; font-size: 15px' class='lines' align='center'> <span class='tips_id_minutes'>"  .floor($row['Id'])  . "</span></td>";
            echo "<td style='height:15px; font-size: 15px' class='lines' align='center'> <span class='project_minutes'>"  .$row['project']    . "</span></td>";
            echo "<td style='height:15px'                  class='lines' align='center'><div style='height:45px'  id='tttest'>" .$row['description']  . "</div></td>";
            echo "<td style='font-size: 15px; height:15px' class='lines' align='center'>" .$row['state']  . "</td>";
            echo "<td style='font-size: 15px; height:15px' class='lines' align='center'>  <input id='textarea' type='number' class='quantity_minutes' value='' step='15' min='0' pattern='[0-9]{1,4}'/></td>";
            echo "</tr>";
        }
    }
?>
</table>
           
