<!DOCTYPE html>
<?php
//Σε αυτο το αρχειο γινεται η δημιουργια του βασικου table που περιεχει τα TIPs.
//Λαμβανει υποψιν τις τιμες απο τα φιλτρα και εμφανιζει τα καταλληλα Tips
  include('PHP/main_functions.php');
  include('session.php');
  include('PHP/update_view_functions.php');
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
    $value_user= $_GET['str'];
    $value_filters =  $_GET['str2'];
    $value_dep = $_GET['str3']; 
    $value_deadline = $_GET['str4']; 
    $value_entolh = $_GET['str5'];
    $value_last = $_GET['str6']; 
    $value_project= $_GET['str7']; 
    $counter4=0;
    
    
    $con = mysqli_connect('localhost','root','1122','jobs');
    //mysqli_set_charset($con, "utf8");
    if (!$con) {die('Could not connect: ' . mysqli_error($con)); }
   
    $result=  create_main_query($con,$value_filters, $value_user, $value_dep, $value_deadline, $value_entolh, $value_project,$value_last,$max_result_per_page,$sort_value,$page);
   
?>
    <div class="insert2" id="insert" ><a style="color:#000099;" a href='javascript:show_insert_task()'>Insert Task</a></div>
    <div class="pages">                    		
        <span>  
            <?php  
                draw_pages($page,$row_count,$max_result_per_page,$sort_value,$counter4); 
                echo " <div> <span style ='font:100% Arial;color:#000099;'>Total Results : ". $GLOBALS['row_count']['sum']."</span> </div>"; 
            ?>
        </span>  
    </div>
    <div class="export2" id="export" > <a style="color:#000099;" href="javascript:export_pdf()"id="export_panel"> <img border="0" src="Styles/Images/pdf_export2.png" width="60" height="60"></a></div>

    
    <table  id="projects" class="table" onload="change_sorting_color('project');">                   
        <tr>        
           <th class="title"  <?php if ($sorting[0] == 'Id')           echo "style='background-color:lightsalmon; border-bottom-left-radius: 3px;    border-top-left-radius: 6px;'"?>  width="45"  onclick="javascript:change_arrow('arrow_Id','Id');">A/A                                      <span id="arrow_Id"           ><?php     if ($sorting[0] != 'Id')        echo ''; else echo $sorting[1]; ?></span></th>
           <th class="title"  <?php if ($sorting[0] == 'project')      echo "style='background-color:lightsalmon'"?>              onclick="javascript:change_arrow('arrow_project','project');">Project                      <span id="arrow_project"      ><?php     if ($sorting[0] != 'project')   echo ''; else echo $sorting[1]; ?></span></th>
           <th class="title"  <?php if ($sorting[0] == 'date_entry')   echo "style='background-color:lightsalmon'"?>  width="50"  onclick="javascript:change_arrow('arrow_date_entry','date_entry');"  >Hμερομηνία Έναρξης   <span id="arrow_date_entry"   ><?php     if ($sorting[0] != 'date_entry')echo ''; else echo $sorting[1]; ?></span></th>
           <th class="title"  <?php if ($sorting[0] == 'deadline')     echo "style='background-color:lightsalmon'"?>  width="85"  onclick="javascript:change_arrow('arrow_deadline','deadline');" >Deadline                  <span id="arrow_deadline"     ><?php     if ($sorting[0] != 'deadline')  echo ''; else echo $sorting[1]; ?></span></th>
           <th class="title"  <?php if ($sorting[0] == 'date_finished')echo "style='background-color:lightsalmon'"?>   width="135" onclick="javascript:change_arrow('arrow_date_finished','date_finished');">Ημερομηνία Ολοκλήρωσης<span id="arrow_date_finished"><?php if ($sorting[0] != 'date_finished')echo '';else echo $sorting[1]; ?></span></th>
           <th class="title"  <?php if ($sorting[0] == 'delay')        echo "style='background-color:lightsalmon'"?>  width="59"  onclick="javascript:change_arrow('arrow_delay','delay');" >Delay                           <span id="arrow_delay"        ><?php      if ($sorting[0] != 'delay')     echo ''; else echo $sorting[1]; ?></span> </th>
           <th class="title"  <?php if ($sorting[0] == 'praktiko')     echo "style='background-color:lightsalmon'"?>              onclick="javascript:change_arrow('arrow_praktiko','praktiko');" >Πρακτικό Σύσκεψης         <span id="arrow_praktiko"     ><?php      if ($sorting[0] != 'praktiko')  echo ''; else echo $sorting[1]; ?></span></th>
           <th class="title" > Περιγραφή Tasks</th>
           <th class="title"  <?php if ($sorting[0] == 'department')   echo "style='background-color:lightsalmon'"?>  width="62"  onclick="javascript:change_arrow('arrow_department','department');">Τμήμα                 <span id="arrow_department"    ><?php     if ($sorting[0] != 'department')echo ''; else echo $sorting[1]; ?></span></th>
           <th class="title"  <?php if ($sorting[0] == 'ipey8inos')    echo "style='background-color:lightsalmon'"?>  width="95"  onclick="javascript:change_arrow('arrow_ipey8inos','ipey8inos');">Υπεύθυνος Ενέργειας     <span id="arrow_ipey8inos"     ><?php     if ($sorting[0] != 'ipey8inos') echo ''; else echo $sorting[1]; ?></span> </th>
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
        <span>  <?php  draw_pages($page,$row_count,$max_result_per_page,$sort_value,$counter4);  ?> </span>  
    </div>

</body>



</html>
