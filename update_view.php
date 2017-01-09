<!DOCTYPE html>.
<?php
  include('main.php');
  include('session.php');
?>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
       
<?php    

    if (isset($_GET["page"])) { $page  = $_GET["page"];    } else { $page=1; }
    if (isset($_GET['str8'])) { $sort_value= $_GET['str8'];}
    
    $sorting = explode(" ",$sort_value);     
    if ($sorting[1] == "ASC") $sorting[1]="↓"; else $sorting[1]="↑";
     
    $value_user= $_GET['str']; $value_filters =  $_GET['str2']; $value_dep = $_GET['str3'];  $value_deadline = $_GET['str4']; 
    $value_entolh = $_GET['str5']; $value_last = $_GET['str6'];  $value_project= $_GET['str7']; 
    
    if ($value_filters=='Ολες') $task_f='';  else $task_f="AND state='".$value_filters."'" ;  
    if ($value_user=='Ολοι') $task_u=''; else $task_u="AND ipey8inos='".$value_user."'";
    if ($value_dep == 'Ολα') $task_d=''; else $task_d="AND department='".$value_dep."'";
    if ($value_entolh =='All') $task_e=''; else $task_e="AND ekdosh='".$value_entolh."'";
    if ($value_deadline=='All') $task_de=''; else $task_de="AND deadline IS ".$value_deadline."  NULL";
    if ($value_project =='All')$task_pr=''; else if ($value_project == 'general_task') $task_pr="AND project='' ";  else $task_pr="AND project='".$value_project."'";
    if ($value_last == 'true') $task_l=''; else $task_l=" AND Id LIKE '%.000%'";
    
    
    $con = mysqli_connect('localhost','root','1122','jobs');
    if (!$con) {die('Could not connect: ' . mysqli_error($con)); }
   
    if ($value_filters=='Ολες' and $value_user=='Ολοι' and $value_dep=='Ολα' and $value_deadline=='All' and $value_entolh == 'All' and $value_project == 'All') {
        
        if ($value_last == 'true'){    
            $query_final="SELECT * FROM tasks                          ORDER BY ".$sort_value." LIMIT ".$max_result_per_page." offset ".($page-1)*$max_result_per_page;
            $result = mysqli_query($con,$query_final);  

            $row_count = return_count_rows($con,"SELECT count(Id) as sum FROM tasks  ORDER BY Id ASC ");
            echo "<br>".$query_final;
      }
        else {
            $query_final= "SELECT * FROM tasks WHERE Id LIKE '%.000%'  ORDER BY ".$sort_value." LIMIT ".$max_result_per_page." offset ".($page-1)*$max_result_per_page;
            $result = mysqli_query($con,$query_final); 
        
            $row_count = return_count_rows($con,"SELECT count(Id) as sum FROM tasks WHERE Id LIKE '%.000%'  ORDER BY Id ASC");
      }
    }
    else{
        // $test=substr($str, 0, 25)." ".substr($str,30);
        $str="SELECT * FROM tasks WHERE ".$task_f."".$task_u."".$task_d."".$task_e."".$task_de."".$task_pr."".$task_l." ORDER BY ".$sort_value;
        $query_final=substr($str, 0, 25)." ".substr($str,30)." LIMIT ".$max_result_per_page." offset ".($page-1)*$max_result_per_page;
        $result= mysqli_query($con,$query_final);

        $query_count=substr($str, 0, 25)." ".substr($str,30);
        $row_count = return_count_rows($con,substr($query_count, 0, 6)." count(Id) as sum ".substr($query_count, 9));
        }
   
?>
    
    
    
    <div class="pages">                    		
        <span>  <?php  draw_pages($page,$row_count,$max_result_per_page,$sort_value); 
       echo " <br><br> <span style ='font:110% Arial;color:#000099;'>Total Results : ".$row_count['sum']."</span> <br>"; 
        //echo "<br>".$query_final;
        ?>
        </span>  
    </div>
    
    <table  id="projects" class="table" onload="change_sorting_color('project');">                   
           <tr>        
               <th class="title"  <?php if ($sorting[0] == 'Id')         echo "style='background-color:lightsalmon; border-bottom-left-radius: 3px;    border-top-left-radius: 6px;'"?>  width="45"  onclick="javascript:change_arrow('arrow_Id','Id');">A/A                                      <span id="arrow_Id"           ><?php     if ($sorting[0] != 'Id')        echo ''; else echo $sorting[1]; ?></span></th>
               <th class="title"  <?php if ($sorting[0] == 'project')    echo "style='background-color:lightsalmon'"?>              onclick="javascript:change_arrow('arrow_project','project');">Project                      <span id="arrow_project"      ><?php     if ($sorting[0] != 'project')   echo ''; else echo $sorting[1]; ?></span></th>
               <th class="title"  <?php if ($sorting[0] == 'date_entry') echo "style='background-color:lightsalmon'"?>  width="50"  onclick="javascript:change_arrow('arrow_date_entry','date_entry');"  >Hμερομηνία Έναρξης   <span id="arrow_date_entry"   ><?php     if ($sorting[0] != 'date_entry')echo ''; else echo $sorting[1]; ?></span></th>
               <th class="title"  <?php if ($sorting[0] == 'deadline')   echo "style='background-color:lightsalmon'"?>  width="85"  onclick="javascript:change_arrow('arrow_deadline','deadline');" >Deadline                  <span id="arrow_deadline"     ><?php     if ($sorting[0] != 'deadline')  echo ''; else echo $sorting[1]; ?></span></th>
               <th class="title"  <?php if ($sorting[0] == 'date_finished')echo"style='background-color:lightsalmon'"?> width="135" onclick="javascript:change_arrow('arrow_date_finished','date_finished');">Ημερομηνία Ολοκλήρωσης<span id="arrow_date_finished"><?php if ($sorting[0] != 'date_finished')echo '';else echo $sorting[1]; ?></span></th>
               <th class="title"  <?php if ($sorting[0] == 'delay')      echo "style='background-color:lightsalmon'"?>  width="59"  onclick="javascript:change_arrow('arrow_delay','delay');" >Delay                           <span id="arrow_delay"        ><?php      if ($sorting[0] != 'delay')     echo ''; else echo $sorting[1]; ?></span> </th>
               <th class="title"  <?php if ($sorting[0] == 'praktiko')   echo "style='background-color:lightsalmon'"?>              onclick="javascript:change_arrow('arrow_praktiko','praktiko');" >Πρακτικό Σύσκεψης         <span id="arrow_praktiko"     ><?php      if ($sorting[0] != 'praktiko')  echo ''; else echo $sorting[1]; ?></span></th>
               <th class="title" > Περιγραφή Tasks</th>
               <th class="title"  <?php if ($sorting[0] == 'department') echo "style='background-color:lightsalmon'"?>  width="62"  onclick="javascript:change_arrow('arrow_department','department');">Τμήμα                 <span id="arrow_department"    ><?php     if ($sorting[0] != 'department')echo ''; else echo $sorting[1]; ?></span></th>
               <th class="title"  <?php if ($sorting[0] == 'ipey8inos')  echo "style='background-color:lightsalmon'"?>  width="95"  onclick="javascript:change_arrow('arrow_ipey8inos','ipey8inos');">Υπεύθυνος Ενέργειας     <span id="arrow_ipey8inos"     ><?php     if ($sorting[0] != 'ipey8inos') echo ''; else echo $sorting[1]; ?></span> </th>
               <th class="title"  width="70" >Εντολή Από</th>
               <th class="title" >Σχόλιο-Αναφορά Εκτέλεσης</th>
               <th class="title" >Βαθμός</th>
               <th class="title" >Edit</th>
               <th class="title" width="50" style=' border-bottom-right-radius: 4px;    border-top-right-radius: 6px;' >Κατάσταση</th>
           </tr> 
           
        <?php 
        while($row = mysqli_fetch_array($result)){  
            //An exei epilextei to show history
            if ($value_last == 'true')          
                draw_table_lines_subtaks($con,$row,$ids,$user_check);  
            //Aplh emfanish 
            else            
                draw_table_lines($row,$ids,$user_check);  
            }
        ?>  
     </table>

    <div class="pages_down">                    		
        <span>  <?php  draw_pages($page,$row_count,$max_result_per_page,$sort_value);  ?> </span>  
    </div>

</body>

<?php
//////////////////////////////////////////////////////////////////
function return_count_rows($con,$mysql_query){  
            
            $query_count=$mysql_query;
            $result_count_final=mysqli_query($con, $query_count);
            $row_count = mysqli_fetch_array($result_count_final);
            return $row_count;
            
        }
///////////////////////////////////////////////////////////////
function draw_pages($page,$row_count,$max_result_per_page,$sort_value){
    $max_pages=ceil($row_count['sum']/$max_result_per_page);
                       for ($i=1;$i<=$max_pages;$i++)
                            //PEriptwsh pou einai ligoteres apo 10 oi selides. Emfanizontai oles
                            if ($max_pages <= 10)    
                                color_page_number($i,$page,$sort_value);               
                            //Periptwsh pou einai perrisotteres apo 10.
                            else{ 
                                draw_first_pages($page,$i,$sort_value,$max_pages);
                                draw_last_pages($page,$i,$sort_value,$max_pages);
                                draw_middle_pages($page,$i,$sort_value,$max_pages); 
                            }                     

}
function color_page_number($i,$page,$sort_value){
      if ($i == $page)
         echo  "<button class='pages2' id='".$i."' style ='background-color:#808080;'     href='javascript:update_view(".$i.",6,0,\"".$sort_value."\")'><b>".$i." </b></button> ";
     else
         echo "<button class='pages2' id='".$i."'  onclick='javascript:update_view(".$i.",6,0,\"".$sort_value."\")'><b>".$i."</b> </button> ";
}
function draw_first_pages($page,$i,$sort_value,$max_pages){
    
     if ($page <= 4  ){
        if ($i < 6)
            color_page_number($i,$page,$sort_value);
        else if ($i == ($max_pages) )
            color_page_number($i,$page,$sort_value);
        else 
            echo ".";
    }
    
}
function draw_last_pages($page,$i,$sort_value,$max_pages){
    if ($page >= ($max_pages - 3)){
        if ($i == 1 )
            color_page_number($i,$page,$sort_value);
    else if ($i >= ($max_pages - 4) )
        color_page_number($i,$page,$sort_value);
    else 
        echo ".";
    }
}
function draw_middle_pages($page,$i,$sort_value,$max_pages){
    if ($page >4 && $page < ($max_pages-3)){
                                    if ($i == 1 )
                                        color_page_number($i,$page,$sort_value);
                                    else if ($i == $max_pages )
                                        color_page_number($i,$page,$sort_value);
                                    else if ($i > ($page-2) && $i < ($page+2))   
                                        color_page_number($i,$page,$sort_value);
                                    else 
                                        echo ".";
                                }                
}
/////////////////////////////////////////////////////
function draw_table_lines($row,$ids,$user_check){
      //Edw dinetai to xrwma sto line tou table. Anoixto i skouro blue
           if ($row['Id']-floor($row['Id']) == 0) echo "<tr class='normal_line'>"; 
           else if($row['Id']- floor($row['Id']) != 0) echo "<tr class = 'light_line'>";
           if ($row['state']=='Finished') {$color='lightgreen';} 
           else if ($row['state'] == 'Cancelled')$color='lightcoral';
           else if ($row['state']== 'Paused') $color ='purple'; else $color='orange';
          
           //ID
           echo "<td  class='lines'align='center'>" .check_id($row['Id'])  . "</td>";
           //Project
           echo "<td  class='lines' align='center'>" .$row['project']  . "</td>";
           //DATE START
           echo "<td  class='lines' align='center'>" . date('d/m/Y', strtotime($row['date_entry'])) . "</td>";
           //DEADLINE
           echo "<td  class='lines' align='center' style='color : red;'><b>" .check_if_null($row['deadline']). "</td>";
           //DATE FINISHED      
           echo "<td  class='lines' align='center'>" .check_if_null($row['date_finished']) . "</td>"; 
           //DELAY
           draw_delay($row['delay']);
           //PRAKTIKO
           echo "<td  class='lines'>" . $row['praktiko'] . "</td>";
           //DESCRIPTION
           echo "<td  class='lines'>" . $row['description'] . "</td>";
           //DEPARTMENT
           echo "<td  class='lines' align='center'>" . $row['department'] . "</td>";
           //IPEY8INOS
           echo "<td  class='lines' align='center'>" . $row['ipey8inos'] . "</td>";
           //ENTOLH APO
           echo "<td  class='lines' align='center'>" . $row['ekdosh']   .  "</td>";
           //COMMENTS
           echo "<td  class='lines'>" . $row['comments'] . "</td>";  
           //GRADE
           draw_grade($row,$ids,$user_check);
           //EDIT BUTTON
           draw_edit($row,$ids,$user_check);
           //STATE
           draw_state($row,$ids,$user_check,$color);
           echo "</tr>";
}
function draw_table_lines_subtaks($con,$row,$ids,$user_check){
       if ($row['Id']-floor($row['Id']) == 0){         
                        draw_table_lines($row,$ids,$user_check);  
                        
                        $result_check=mysqli_query($con," SELECT count(Id) as sum FROM tasks WHERE  Id LIKE '".floor($row['Id']).".%'");
                        $row_check = mysqli_fetch_array($result_check);    
                        
                        //An yparxoun upo task mpainei edw
                        if ($row_check['sum']>1){
                                $i=$row_check['sum']-1;
                              
                                while ($i>0){              
                                    $number_with_zeros = str_pad($i, 3, '0', STR_PAD_LEFT);
                                    $result_subtasks=mysqli_query($con," SELECT * FROM tasks WHERE Id=".floor($row['Id']).".".$number_with_zeros.";");
                                    $row_subtasks = mysqli_fetch_array($result_subtasks );          
                                    draw_table_lines($row_subtasks,$ids,$user_check);  
                                    $i=$i-1;
                               }
                        }       
                } 
}
///////////////////////////////////////////////////////
function draw_grade($row,$ids,$user_check){
    
     if (get_name_from_username($user_check) == $row['ipey8inos'])
         if ($row['G1'] == null) $g1=' ';else $g1=$row['G1'];
     else
        $g1='****';
     echo "<td  class='lines'>".$g1."</td>";  
}
function draw_delay($delay){

    if ($delay < 0)
        echo "<td  class='lines' align='center' style='color : green;'><b>" . $delay . "</td>";
    else if ($delay == 0)
        echo "<td  class='lines' align='center' style='color : green;'><b> </td>";
    else
        echo "<td  class='lines' align='center' style='color : red;'><b>" . $delay . "</td>";

}
function draw_edit($row,$ids,$user_check){
     $disabled=''; $hidden='';
     if ( $row['state']=='Cancelled' || $row['state']== 'Paused' || check_for_newer_version($row['Id'],$ids)==1 || get_name_from_username($user_check) != $row['ipey8inos'])
        $disabled='disabled';
     if (check_for_newer_version($row['Id'],$ids)==1)
        $hidden=" hidden";     
     echo "<td class='lines' > <button class='edit_button' ". $disabled  ."  onclick='edituser(".$row['Id'].")' >edit</button></td>";      
}
function draw_state($row,$ids,$user_check,$color){
        $pending=''; $cancelled=''; $finished='';$paused='';
          $disabled=' ';
            if ($row['state'] == 'Finished') {
                $finished ='selected';
                $disabled='disabled';
                $onchange='';
            }   
            else if ($row['state'] == 'Cancelled'){
                $cancelled ='selected';
                $disabled='disabled';
                $onchange='';
            }
            else if ($row['state'] == 'Paused'){
                $paused ='selected';
                $disabled='';
                $onchange=" cancel_message(this.value,".$row['Id'].")";
            }
            else if ($row['state'] == 'Pending'){
                $pending ='selected';
                $disabled='';
                if (get_name_from_username($user_check) != $row['ipey8inos'] || check_for_newer_version($row['Id'],$ids)==1){
                    $disabled='disabled';
                    $onchange='';
                    }
                $onchange="cancel_message(this.value,".$row['Id'].")"; 
            }   
           
            echo "<td class='lines'> <select  ". $disabled  ." class='drop_down_state' style='background-color:".$color."'  onchange='".$onchange."'  >"
                . " <option value='Pending'   ". $pending   ." >Pending</option>"
                . " <option value='Finished'  ". $finished  ." >Finished</option>"
                . " <option value='Cancelled' ". $cancelled ." >Cancelled</option>"
                . " <option value='Paused'    ". $paused    ." >Paused</option></select></td>";
}

?>

</html>
