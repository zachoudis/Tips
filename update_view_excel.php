<!DOCTYPE html>.

<?php
  include('PHP/main_functions.php');
  include('session.php');
?>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>

<?php
    if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
    $value_user= $_GET['str'];
    $value_filters =  $_GET['str2'];
    $value_dep = $_GET['str3'];
    $value_deadline = $_GET['str4']; 
    $value_entolh = $_GET['str5'];
    $value_last = $_GET['str6'];
    $value_project= $_GET['str7'];
    $page=$_GET["page"]; 
    
    $con = mysqli_connect('localhost','root','1122','jobs');
    if (!$con) {die('Could not connect: ' . mysqli_error($con)); }
   
    if ($value_filters=='Ολες') $task_f='';  else $task_f="AND state='".$value_filters."'" ;  
    if ($value_user=='Ολοι') $task_u=''; else $task_u="AND ipey8inos='".$value_user."'";
    if ($value_dep == 'Ολα') $task_d=''; else $task_d="AND department='".$value_dep."'";
    if ($value_entolh =='All') $task_e=''; else $task_e="AND ekdosh='".$value_entolh."'";
    if ($value_deadline=='All') $task_de=''; else $task_de="AND deadline IS ".$value_deadline."  NULL";
    if ($value_project =='All')$task_pr=''; else $task_pr="AND project='".$value_project."'";
    if ($value_last == 'true') $task_l=''; else $task_l=" AND Id LIKE '%.000%'";

    $str="SELECT * FROM tasks WHERE ".$task_f."".$task_u."".$task_d."".$task_e."".$task_de."".$task_pr."".$task_l." ORDER BY Id ASC  ";

    
    if ($value_filters=='Ολες' and $value_user=='Ολοι' and $value_dep=='Ολα' and $value_deadline=='All' and $value_entolh == 'All' and $value_project == 'All') {
        
        if ($value_last == 'true'){    
          $query_final="SELECT * FROM tasks  ORDER BY Id ASC ";
          $result = mysqli_query($con,$query_final);  
          
          
          $query_count="SELECT count(Id) as sum FROM tasks  ORDER BY Id ASC ";
          $result_count_final=mysqli_query($con, $query_count);
          $row_count = mysqli_fetch_array($result_count_final);
      }
        else {
          $query_final= "SELECT * FROM tasks WHERE Id LIKE '%.000%'  ORDER BY Id ASC ";
          $result = mysqli_query($con,$query_final); 
          
          $query_count="SELECT count(Id) as sum FROM tasks WHERE Id LIKE '%.000%'  ORDER BY Id ASC";
          $result_count_final=mysqli_query($con, $query_count);
          $row_count = mysqli_fetch_array($result_count_final);
      }
    }
    else{
        // $test=substr($str, 0, 25)." ".substr($str,30);
        $query_final=substr($str, 0, 25)." ".substr($str,30)." ";
        $result= mysqli_query($con,$query_final);

        $query_count=substr($str, 0, 25)." ".substr($str,30);
        $query_count=substr($query_count, 0, 6)." count(Id) as sum ".substr($query_count, 9);
        $result_count_final=mysqli_query($con,$query_count);
        $row_count = mysqli_fetch_array($result_count_final);           
        }
?>
        
    
    <table  id="projects2" class="table">                   
        <tr>        
         
            <th class="title" >A/A</th>
            <th class="title" >Project</th>
            <th class="title" width="50" > Hμερομηνία Έναρξης</th>
            <th class="title" width="50">Deadline</th>
            <th class="title" width="50">Ημερομηνία Ολοκλήρωσης</th>
            <th class="title" >Delay</th>
            <th class="title" >Πρακτικό Σύσκεψης</th>
            <th class="title" >Περιγραφή Tasks</th>
            <th class="title" >Τμήμα</th>
            <th class="title" width="50">Υπεύθυνος Ενέργειας</th>
            <th class="title" width="50">Εντολή Από</th>
            <th class="title" >Σχόλιο-Αναφορά Εκτέλεσης</th>
            <th class="title" >Βαθμός</th>
       
        </tr>       
        <?php
         while($row = mysqli_fetch_array($result)){   
            if ($row['Id']-floor($row['Id']) == 0) echo "<tr class='normal_line'>"; 
            else if($row['Id']- floor($row['Id']) != 0) echo "<tr class = 'light_line'>";
            
                    
                    
                    
            if ($row['state']=='Finished') {$color='lightgreen';} else if ($row['state'] == 'Cancelled')$color='lightcoral'; else $color='orange';
     
            //ID
            echo "<td  class='lines' align='center'>" .check_id($row['Id'])  . "</td>";
            //Project
            echo "<td  class='lines'  align='center'>" .$row['project']  . "</td>";
            //DATE START
            echo "<td  class='lines' align='center'>" . date('d/m/Y', strtotime($row['date_entry'])) . "</td>";
            //DEADLINE
            echo "<td  class='lines' align='center' style='color : red;'>" .check_if_null($row['deadline']). "</td>";
            //DATE FINISHED      
            echo "<td  class='lines' align='center'>" .check_if_null($row['date_finished']) . "</td>"; 
            //DELAY
            if ($row['delay'] < 0)
                echo "<td  class='lines' align='center' style='color : green;'>" . $row['delay'] . "</td>";
			else if ($row['delay'] == 0)
                 echo "<td  class='lines' align='center' style='color : green;'> </td>";
            else
                echo "<td  class='lines' align='center' style='color : red;'>" . $row['delay'] . "</td>";
            //PRAKTIKO
            echo "<td  class='lines'>" . $row['praktiko'] . "</td>";
            //DESCRIPTION
            echo "<td  class='lines'>" . $row['description'] . "</td>";
            //DEPARTMENT
            echo "<td  class='lines' align='center'>" . $row['department'] . "</td>";
            //IPEY8INOS
            echo "<td  class='lines'>" . $row['ipey8inos'] . "</td>";
            //ENTOLH APO
            echo "<td  class='lines' align='center'>" . $row['ekdosh']   .  "</td>";
            //COMMENTS
            echo "<td  class='lines'>" . $row['comments'] . "</td>";  
            //GRADE
            if ($row['G1'] == null) $g1=' ';else $g1=$row['G1'];
          //  if ($row['G2'] == null) $g2=' ';else $g2=$row['G2'];
           
            echo "<td  class='lines'>".$g1." -- </td>";  

            echo "</tr>";
            }
        ?>  
    </table>
  
</body>
</html>
