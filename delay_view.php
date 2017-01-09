<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php
    $check_box= $_GET['str'];
    $state =  $_GET['state'];
   
   
    $con = mysqli_connect('localhost','root','1122','jobs');
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    
    if ($check_box=='2' and $state=='true') {
      //  echo "SELECT * FROM tasks";
        $result = mysqli_query($con,"SELECT * FROM tasks WHERE delay IS NOT NULL");       
    }
    else if ($check_box=='1' and $state=='true') {
        $curr_date=date("Y-m-d");
      
         $result = mysqli_query($con,"SELECT * FROM tasks WHERE state='Pending' AND deadline<'".$curr_date."'");       
    }
    
    else
    {
        $result=null;
        echo '<script>window.location.href = "welcome.php";</script>';
        
    }
   // else if ($value_filters=='Ολες' and $value_user!='Ολοι' and $value_dep=='Ολα' ){    
     //   echo "SELECT * FROM tasks WHERE ipey8inos='".$value_user."'";
    //    $result = mysqli_query($con,"SELECT * FROM tasks WHERE ipey8inos='".$value_user."'");
   // }
/*
    if ($value_filters=='Ολες' and $value_user=='Ολοι' and $value_dep=='Ολα') {
      //  echo "SELECT * FROM tasks";
        $result = mysqli_query($con,"SELECT * FROM tasks");       
    }
    else if ($value_filters=='Ολες' and $value_user!='Ολοι' and $value_dep=='Ολα' ){    
     //   echo "SELECT * FROM tasks WHERE ipey8inos='".$value_user."'";
        $result = mysqli_query($con,"SELECT * FROM tasks WHERE ipey8inos='".$value_user."'");
    }
    else if ($value_filters!='Ολες' and $value_user=='Ολοι' and $value_dep=='Ολα'  ){    
    //    echo "SELECT * FROM tasks WHERE state='".$value_filters."'";
        $result = mysqli_query($con,"SELECT * FROM tasks WHERE state='".$value_filters."'");   
    }
     else if ($value_filters=='Ολες' and $value_user=='Ολοι' and $value_dep!='Ολα'  ){    
      //  echo "SELECT * FROM tasks WHERE department='".$value_dep."'";
        $result = mysqli_query($con,"SELECT * FROM tasks WHERE department='".$value_dep."'");   
    }
    else if ($value_filters!='Ολες' and $value_user!='Ολοι'  and $value_dep=='Ολα' ){    
       // echo "SELECT * FROM tasks WHERE state='".$value_filters."' AND ipey8inos='".$value_user."'";
        $result = mysqli_query($con,"SELECT * FROM tasks WHERE state='".$value_filters."' AND ipey8inos='".$value_user."'");    
     }
    else if ($value_filters!='Ολες' and $value_user=='Ολοι'  and $value_dep!='Ολα' ){    
      //  echo "SELECT * FROM tasks WHERE state='".$value_filters."' AND ipey8inos='".$value_user."'";
        $result = mysqli_query($con,"SELECT * FROM tasks WHERE state='".$value_filters."' AND department='".$value_dep."'");    
     }
    else if ($value_filters=='Ολες' and $value_user!='Ολοι'  and $value_dep!='Ολα' ){    
       // echo "SELECT * FROM tasks WHERE state='".$value_filters."' AND ipey8inos='".$value_user."'";
        $result = mysqli_query($con,"SELECT * FROM tasks WHERE ipey8inos='".$value_user."' AND department='".$value_dep."'");    
     } 
    else if ($value_filters!='Ολες' and $value_user!='Ολοι'  and $value_dep!='Ολα' ){    
      //  echo "SELECT * FROM tasks WHERE state='".$value_filters."' AND ipey8inos='".$value_user."' AND department='".$value_dep."'";
        $result = mysqli_query($con,"SELECT * FROM tasks WHERE state='".$value_filters."' AND ipey8inos='".$value_user."' AND department='".$value_dep."'");       
     }*/
?>
     <table id="projects" class="table">
                      <thead>
                          <tr>
                             
                              <th class="title">ID</th>
                              <th class="title">Hμερομηνια Εναρξης</th>
                              <th class="title">Deadline</th>
                              <th class="title">Ημερομηνια Ολοκληρωσης</th>
                              <th class="title">Delay</th>
                              <th class="title">Πρακτικο Συσκεψης</th>
                              <th class="title">Περιγραφη</th>
                              <th class="title">Τμημα</th>
                              <th class="title">Υπευθυνος</th>
                              <th class="title">Εκδοθηκε Απο</th>
                              <th class="title">Σχόλια</th>
                               <th class="title">Edit</th>
                              <th class="title">Κατασταση</th>
                          </tr>       
                          <?php
                           while($row = mysqli_fetch_array($result))                             
                              {           
                              if ($row['state']=='Finished') {$color='lightgreen';} else if ($row['state'] == 'Cancelled')$color='lightcoral'; else $color='orange';
                              echo "<tr   href='insert.php'>";
                           
                              echo "<td class='lines'>" . $row['Id'] . "</td>";
                              echo "<td class='lines'>" . $row['date_entry'] . "</td>";
                              echo "<td class='lines'>" . $row['deadline'] . "</td>";
                              echo "<td class='lines'>" . $row['date_finished'] . "</td>";
                              echo "<td class='lines'>" . $row['delay'] . "</td>";
                              echo "<td class='lines'>" . $row['praktiko'] . "</td>";
                              echo "<td class='lines'>" . $row['description'] . "</td>";
                              echo "<td class='lines'>" . $row['department'] . "</td>";
                              echo "<td class='lines'>" . $row['ipey8inos'] . "</td>";
                              echo "<td class='lines'>" . $row['ekdosh']   .  "</td>";
                              echo "<td class='lines'>" . $row['comments'] . "</td>";  
                                 echo "<td class='lines'> <button class='edit_button' onclick='edituser(".$row['Id'].")'>edit</button></td>";
                              $pending=''; $cancelled=''; $finished='';
                              if ($row['state'] == 'Finished')$finished =  'selected ';
                              else if ($row['state'] == 'Pending')$pending = 'selected';
                              else if ($row['state'] == 'Cancelled')  $cancelled = 'selected';
                              echo "<td class='lines'> <select class='select_state' style='background-color:".$color."' id='test' onchange='cancel_message(this.value,".$row['Id'].")' > <option class='pending' value='Pending' ". $pending ." >Pending</option> <option value='Finished' ". $finished ." >Finished</option> <option  value='Cancelled' ". $cancelled ." >Cancelled</option> </select> </td>";
                              echo "</tr>";
                              }
                          echo "</table>";
                        //change_state(this.value,".$row['Id'].")
                          ?>
                      </thead>	
                </table>
</body>
</html>