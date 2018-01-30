<?php
  include('../PHP/main_functions.php');
  include('../session.php');

  $con = mysqli_connect('localhost','root','1122','jobs'); $con = mysqli_connect('localhost','root','1122','jobs');  
  $result_pagies= mysqli_query($con,"SELECT Id_fixed,description FROM fixed_jobs WHERE username='".$user_check."' ORDER BY Id ASC");
?>

 <table  id="pagies_jobs"  cellspacing="1px">                   
    <tr>        
        <th class="title_tips" style="font-size: 16px;" width="40">ID</th>
        <th class="title_tips" style="font-size: 16px;" width="310">Description</th>
        <th class="title_tips" style="font-size: 16px;" width="80">Minutes</th>
    </tr>
    <?php
    while($row_pagies = mysqli_fetch_array($result_pagies)){   
        echo "<tr style='height:15px' >";     
        echo "<td style='height:15px; font-size: 15px' class='lines' align='center'> <span class='tips_id_minutes'>"  .$row_pagies['Id_fixed']  . "</span></td>";
        echo "<td style='height:15px; font-size: 15px' class='lines' align='center'> <span >"  .$row_pagies['description']    . "</span></td>";
        echo "<td style='font-size: 15px; height:15px' class='lines' align='center'>  <input id='textarea'  type='number' step='15' min='0' class='quantity_minutes' value='' pattern='[0-9]{1,4}'/></td>";
        echo "</tr>";
    }
    ?>          
</table> 
        