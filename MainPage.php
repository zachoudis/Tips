<script src='Javascript/pdfmake.js'></script>
<script src='Javascript/pdfmake.min.js'></script>
<script src='Javascript/vfs_fonts.js'></script>
<script src="Javascript/javascript.js"></script> 
<script src="Javascript/pdf_export_functions.js"></script> 
<script src="manage_fixed_jobs/manage_fixed_jobs.js"></script> 
<script src="submit_hours/submit_hours_functions.js"></script> 
<script src="submit_in_out/submit_in_out_functions.js"></script> 
<script src="Javascript/submit_tips_functions.js"></script> 
<script src="Javascript/PDFFromHTML_UsersInOut.js"></script> 

<script src="inout_views/inout_views.js"></script> 
<script type="text/javascript" src="Javascript/jQuery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<link  rel="stylesheet" type="text/css" href="SimpleDropDownEffects/css/style4.css"> 
<link  rel="stylesheet" type="text/css" href="Styles/style.css">     
<link  rel="stylesheet" type="text/css" href="Styles/submit_hours_panel.css">  
<link  rel="stylesheet" type="text/css" href="Styles/filters_alerts.css"> 
<link  rel="stylesheet" type="text/css" href="Styles/title_panel.css"> 
<link  rel="stylesheet" type="text/css" href="Styles/main_table_view.css"> 
<link  rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
 
<?php
    include('session.php');
    include('PHP/main_functions.php');
    include('dialog_boxes.php');
    include('submit_in_out/submit_in_out_functions.php');

   //  $db = mysqli_connect('localhost','root','1122','jobs');
    // $result=mysqli_query($db, "SELECT * FROM tasks ;");
    // while($row = mysqli_fetch_array($result)){
       // echo $row['description'];
    //      $db2 = mysqli_connect('localhost','root','1122','jobs');
    //      mysqli_set_charset($db2, "utf8");
    //      mysqli_query($db2, "UPDATE tasks SET ipey8inos='".$row['ipey8inos']."' WHERE Id=".$row['Id']." ");
          
  //  } 
    

?>
<html>
    <head> 
        <meta charset="UTF-8">
 	<title>T.i.P. Yetos </title>
        <script>	
           

$(window).unload( function () { alert("Bye now!"); } );


              $(document).on("change", ".quantity_minutes", function() {
                  if ($(this).val()%15!=0){
                        document.getElementById('alert_messages').innerHTML="Δοσατε Λάθος Τιμή. Δοκιμάστε ξανά";
                        document.getElementById('alert_messages').style.color='red';
                        $(this).val('');
                    }});
              $(document).on("change", ".quantity_minutes", function() {
               
              var sum = 0;
                var completed=false;
                var max_minutes= document.getElementById('submit_hour_minutes').innerHTML;
                max_minutes=parseInt(max_minutes);
                if (completed==false){
                    
                    document.getElementById('submit_hour').disabled=true;}
             
                if ($.isNumeric($(this).val())){
                    $(".quantity_minutes").each(function(){
                        sum += +$(this).val();
                    });

                    if (sum > max_minutes){
                        document.getElementById('alert_messages').innerHTML="Ξεπεράσατε το όριο λεπτών που μπορείτε να δηλώσετε. Δοκιμάστε ξανά";
                        document.getElementById('alert_messages').style.color='red';
                        $(this).val('');
                    }
                    else if (sum == max_minutes){
                        document.getElementById('alert_messages').innerHTML="'Εχετε ολοκληρωσει την συμπλήρωση χρόνου. Δεν μπορείτε να καταχωρήσετε παραπάνω λεπτά.";
                        document.getElementById('alert_messages').style.color='green';
                        $(".total_minutes").val(sum);
                        document.getElementById('minutes_left').value=(max_minutes-sum);
                         document.getElementById('submit_hour').disabled=false;
  
                    }
                    else{
                        $(".total_minutes").val(sum);
                        $(".total_minutes").change();
                        document.getElementById('minutes_left').value=(max_minutes-sum);
                        document.getElementById('alert_messages').innerHTML="";
                    }
                }
                else {
                    document.getElementById('alert_messages').innerHTML="Δώσατε Λάθος Τιμή.Επιτρέπονται μόνο πολλαπλάσια του 15.Προσπαθήστε Ξανά";
                    document.getElementById('alert_messages').style.color='red';
                    }
               });
                $(".total_minutes").change(function(){
                });
              $(document).ready(function() {
                $("#datepicker").datepicker({dateFormat:'dd/mm/yy'});
              });
            
             
            
        </script>
    </head>
 
    <body onload="update_view('xxx',<?php echo $total_pages; ?>,'1','Id ASC')" >
        <div id="blur_div">
         <?php
            if ( $user_check!= "span" AND  $user_check!="kova"){
                change_auto_filter($user_check); 
                check_for_delays($user_check,$delayed_task,$ids);}
        ?>

        <div class="panel" id="panel" >
            <img  src="Styles/Images/logo2.jpg" class="logo" alt="yetos" style="width:379px;height:99px;">
            <div class="container" id="eleni">
                <h1>T.i.P. ΥΕΤΟΣ </h1> <?php get_name($user_check);?>
                <h6 id="version">v1.00 </h6>    
            </div>  
            <div id="signout" ><form class="signout"   action="logout.php">     <input type="image" src="Styles/Images/images2.png" alt="Submit" width="68" height="68"></form></div>
            <?php if ($user_check == 'zari' or $user_check == 'kode' or $user_check == 'soan' or $user_check == 'kwch' or $user_check == 'mpth' or $user_check == 'taso' or $user_check == 'alst' or $user_check == 'kokr')  { ?>
            <div class="fixed_jobs_manage"><?php display_fixed_jobs_button($user_check);?></div>  
            <?php } ?>
        </div>
       
        <div id="maincontent">   
            
            <div class="filters" id="filters" >    
                <div class="task">
                <h3 class="yolo">Task </h3>
                    <select onchange="update_view('xxx',<?php echo $total_pages; ?>,'1','Id ASC')" id="task_filter2" name="task_filter2" class="filter_select">                    
                        <?php 
                        for ($i=0;$i<5;$i++)
                            if ($states[$i]=="Ολες")
                              echo "<option value='".$states[$i]."'>All</option>";
                            else
                              echo "<option value='".$states[$i]."'>".$states[$i]."</option>";
                        ?>
                    </select> 
                </div>
                <div class="user">
                <h3 class="yolo">User </h3>
                    <select onchange="update_view('xxx',<?php echo $total_pages; ?>,'1','Id ASC')" id="user_filter2" name="user_filter2" class="filter_select">
                      <option value="Ολοι">All</option>
    
                      <?php 
                         for ($i=0;$i<count($users);$i++)
                            echo "<option value='".$users[$i]."'>".$users[$i]."</option>"
                      ?>
                    </select>
                </div>
                <div class="department">
                 <h3 class="yolo">Department </h3>
                    <select onchange="update_view('xxx',<?php echo $total_pages; ?>,'1','Id ASC')" id="dep_filter2" name="user_filter2" class="filter_select">                          
                       <option value="Ολα">All</option>
                        <?php 
                          for ($i=0;$i<count($departments);$i++)
                            echo "<option value='".$departments[$i]."'>".$departments[$i]."</option>"
                        ?>                        
                    </select>
                </div>
                <div class="deadlines_not">
                 <h3 class="yolo">Deadlines </h3>
                    <select onchange="update_view('xxx',<?php echo $total_pages; ?>,'1','Id ASC')" id="deadline_filter2" name="user_filter2" class="filter_select" >                          
                       <option value="All">All</option>
                       <option value="NOT">With Deadline</option>
                       <option value=" ">Without Deadline</option>          
                    </select>
                </div>
                <div class="entolh_apo">                  
                 <h3 class="yolo">Command </h3>
                    <select onchange="update_view('xxx',<?php echo $total_pages; ?>,'1','Id ASC')" id="entolh_filter2" name="user_filter2" class="filter_select" >                          
                       <option value="All">All</option>
                       <option value=' '> </option>
                        <?php 
                           for ($i=0;$i<count($persons_to_give_orders);$i++)
                            echo "<option value='".$persons_to_give_orders[$i]."'>".$persons_to_give_orders[$i]."</option>"
                        ?>                        
                    </select>
                </div>           
                <div class="project">
                <h3 class="yolo">Project </h3>
                    <select onchange="update_view('xxx',<?php echo $total_pages; ?>,'1','Id ASC')" id="project_filter2" name="task_filter2" class="filter_select" >
                        <option value='All'>All</option>
                        <?php   
                            $result_project=mysqli_query($db,"SELECT DISTINCT project FROM tasks WHERE Id LIKE '%.000%' AND project!='' ORDER BY project ASC ");
                            echo "<option value='general_task'>Γενικές Εργασίες</option> "; 
                            while($row = mysqli_fetch_array($result_project)){   
                                if ($row['project'] != ' ' OR $row['project'] != null)
                                   echo "<option value='".$row['project']."'>".$row['project']."</option> "; 
                            } 
                        ?>
                    </select> 
                </div>
                <div class='check_box'>     
                   Show History <input type="checkbox" onchange="update_view('xxx',<?php echo $total_pages; ?>,'1','Id ASC')" value="check" id='last_filters2'><br>
                </div>
            </div>
            
           <?php if ($user_check == 'zari' or $user_check == 'kode' or $user_check == 'soan' or $user_check == 'kwch' or $user_check == 'mpth' or $user_check == 'taso' or $user_check == 'alst' or $user_check == 'kokr')  { ?>
            <div class="submit_hours">
                <text id="title_hours"><b>Καταχώρηση Ωρών</b></text>   
                <div  id="buttons_days_panel">  <?php draw_buttons_days($user_check); ?> </div>
            </div>  
         
            <div class="hours_info">
                <span id="username2" hidden><?php echo $user_check ;          ?>   </span>
                <span id="time_in"   hidden><?php echo return_time_in($user_check);?></span>        
                <?php       
                    submit_time_in($user_check); 
                    print_messages($user_check); 
                ?>
            </div>
           <?php } ?>
            <div class='alerts' >    
                <div class="team1"><div class="noblink" id="noblink">You Have No Delayed Tasks</div></div>
                <div class="team2"><span class="noblink" id="noblink2">You Have No Tasks Ending Today</span></div>    
                <div class="team1"><span class="blink"   id="blink">You Have <?php echo $GLOBALS['delayed_task_count']?> Delayed Tasks</span></div>
                <div class="team2"><span class="blink"   id="blink2" >You Have <?php echo $GLOBALS['task_ending_today_count']?> Tasks Ending Today</span></div>    
                <?php
                    if ($GLOBALS['delayed_task'] == 1) echo '<script type="text/javascript">change_color_alert("blink","noblink");</script>';
                    else  echo '<script type="text/javascript">change_color_alert2("blink","noblink");</script>';
                    if ($GLOBALS['task_ending_today'] == 1) echo '<script type="text/javascript">change_color_alert("blink2","noblink2");</script>';
                    else  echo '<script type="text/javascript">change_color_alert2("blink2","noblink2");</script>';
                ?>
           </div>
           
            
            
            
            
            <div class="main" id="main" >                                        
                <div id="insert_form"  style="display:none;" class="form"> 
                    <form method="post" action=""   name="form_service" onsubmit="return validateInsertTipForm()" >    
                    <table class="insert_task_table">
                        <tr>
                            <td>Project</td>
                            <td><input type="project" name="project" id="project" onchange="test(this.value)" pattern="[A-Z]{4}[0-9]{4}|[A-Z]{3}[0-9]{1,4}|[A-Ω]{3}[0-9]{1,4}" maxlength="15" /></td>        
                        </tr><tr>
                            <td>Ημερομηνία Ανάθεσης</td>
                            <td><span class="asterisk">*</span><input type="date" name="date_entry" id="datepicker2" onmouseover="$('#datepicker2').datepicker({dateFormat: 'dd/mm/yy'});"   required  maxlength="15" /></td>        
                        </tr><tr>
                            <td>Deadline</td>
                            <td><input type="date" name="deadline" id="datepicker" onmouseover="$('#datepicker').datepicker({dateFormat: 'dd/mm/yy'});"  maxlength="15" /></td>
                        </tr><tr>
                            <td>Πρακτικό Σύσκεψης</td>
                            <td><input type="number" name="praktiko" size="80"  maxlength="15" /></td>
                        </tr><tr>
                            <td>Περιγραφή Task</td>
                            <td><span class="asterisk">*</span>
                                <textarea  rows="5" cols="60" type="text" name="description" id="description" size="400" required maxlength="500" ></textarea></td>	    
                        </tr><tr>
                            <td>Υπεύθυνος</td>
                            <td colspan="2"><span class="asterisk">*</span>
                                <select required  id="jobkind" name="ipey8inos"  class="box" >
                                    <option value="">---Επιλέξτε---</option>
                                    <?php 
                                        for ($i=0;$i<count($users);$i++)
                                            if (get_name_from_username ($user_check)== $users[$i])
                                                echo "<option selected  value='".$users[$i]."'>".$users[$i]."</option>"
                                     ?>
                                </select>
                            </td>
                        </tr><tr>
                            <td>Τμήμα</td>
                            <td colspan="2"><span class="asterisk">*</span>
                                <select required id="dep_filter2" name="department"  >                          
                                   <option value="">Επιλέξτε Τμήμα</option>
                                    <?php 
                                      for ($i=0;$i<count($departments);$i++)
                                        echo "<option value='".$departments[$i]."'>".$departments[$i]."</option>"
                                    ?>                        
                                </select>  
                            </td>
                        </tr>    
                         <td>Εντολή Από</td>
                            <td colspan="2"><span class="asterisk">*</span>
                                <select required id="jobkind" name="ekdosh" class="box" >
                                    <option value="">---Επιλέξτε---</option>
                                    <option value="Άνθιμος">Άνθιμος</option>
                                    <option value="Βασιλική">Βασιλική</option>
                                </select>
                            </td>
                        </tr><tr>
                            <td>Σχολια</td>
                             <td><textarea  rows="4" cols="60" type="text" name="comments" size="400"  maxlength="500" ></textarea></td>	 		
                        </tr><tr>
                            <td colspan="3">
                                <input class="button" type="submit" value="Καταχώρηση" name="submit" />
                                <input class="button" type="reset" value="Καθαρισμός" name="cleaner" />
                                <button value="Ακυρωση" id="btnClose">Κλεισιμο</button>
                                
                                <br><span class="asterisk">*required fields</span>
                            </td>
                        </tr>			
                    </table>
                        
                 </form>
                </div>     
          
                
                
                <div  class="edit_form" id="edit_form"  style="display:none;" >  </div>  
                <div  class="txtHint"   id="txtHint"    ><b></b></div>   
                <div  class="txtHint2"  id="txtHint2"   style="visibility:hidden;" ><b></b></div>   
               
            </div>      
           
        </div>  
        </div>
        
            <div  class="loader"    id="loader"     style="visibility:hidden;" ></div>  
    </body> 
</html>
