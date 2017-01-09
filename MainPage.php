<script src='pdfmake.js'></script>
<script  src='pdfmake.min.js'></script>
<script  src='vfs_fonts.js'></script>
<script src="javascript.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>


<?php
  include('session.php');
  include('main.php');

//dsdsdsd mpikre kai allh allagh
?>
<html>
   <head> 
        <meta charset="UTF-8">
 	<title>T.i.P. Yetos </title>
        <script type="text/javascript" src="jQuery.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css">     
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        <script>
            
              $(document).ready(function() {
                $("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
              });
              $(document).ready(function() {
                $("#datepicker2").datepicker({dateFormat: 'yy-mm-dd'});
              });
              $(document).ready(function() {
                $("#datepicker3").datepicker({dateFormat: 'yy-mm-dd'});
              });
              $(document).ready(function() {
                $("#datepicker4").datepicker({dateFormat: 'yy-mm-dd'});
              });
              $(document).ready(function() {
                $("#datepicker5").datepicker({dateFormat: 'yy-mm-dd'});
              });
              $(function() {
                $('#export_panel').click(function() {
                        $('#myDialog').dialog({
                              resizable: false,
                                modal: true,
                                width: 300,
                                show: {effect: 'fade', duration: 400},
                                hide: {effect: 'fade', duration: 400},
                                position: {
                                    my: "right center",
                                    at: "right top",
                                    of: $('#export_panel')
                                },
                            open: function() {                                
                                $('#startDate').datepicker({title:'Test Dialog' ,dateFormat: 'dd/mm/yy'}).blur();
                                $('#endDate').datepicker({title:'Test Dialog',dateFormat: 'dd/mm/yy'}).blur();                                 
                            },
                            close: function() {
                                $('#startDate').datepicker('destroy');
                                $('#endDate').datepicker('destroy');
                            },
                        });
                    });
                });
       setTimeout(function(){
   document.getElementById("myDiv").style.display="none";
}, 5000);  
        </script>
 
   </head>

   
   
   <body onload="update_view('xxx',<?php echo $total_pages; ?>,'1','Id ASC')" >
        <?php
       
            if ( $user_check!= "span" AND  $user_check!="kova"){
                change_auto_filter($user_check); 
                check_for_delays($user_check,$delayed_task,$ids);
        }
        ?>

       <div class="panel" id="panel" >
            <img  src="logo2.jpg" class="logo" alt="yetos" style="width:379px;height:99px;">
            <div class="container">
                <h1>T.i.P. ΥΕΤΟΣ </h1> <?php get_name($user_check);?>
                <h6 id="version">v1.00 </h6> 
        </div>
            
            <div id="signout" >          
                <form class="signout" action="logout.php"> <input type="image" src="images.jpg" alt="Submit" width="68" height="68"></form>
            </div>
      </div>
       
       
       <div id="maincontent">             
            <div class="filters" id="filters" >    
               <div class="task">
                <h3>Task </h3>
                    <select onchange="update_view('xxx',<?php echo $total_pages; ?>,'1','Id ASC')" id="task_filter2" name="task_filter2" class="user_filter2">                   
                       
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
                <h3>User </h3>
                    <select onchange="update_view('xxx',<?php echo $total_pages; ?>,'1','Id ASC')" id="user_filter2" name="user_filter2" class="user_filter2">
                      <option value="Ολοι">All</option>
                      <?php 
                         for ($i=0;$i<$length;$i++)
                            echo "<option value='".$users[$i]."'>".$users[$i]."</option>"
                      ?>
                    </select>
                </div>
                <div class="department">
                 <h3>Department </h3>
                    <select onchange="update_view('xxx',<?php echo $total_pages; ?>,'1','Id ASC')" id="dep_filter2" name="user_filter2" class="user_filter2" >                          
                       <option value="Ολα">All</option>
                        <?php 
                          for ($i=0;$i<count($departments);$i++)
                            echo "<option value='".$departments[$i]."'>".$departments[$i]."</option>"
                        ?>                        
                    </select>
                </div>
               <div class="deadlines_not">
                 <h3>Deadlines </h3>
                    <select onchange="update_view('xxx',<?php echo $total_pages; ?>,'1','Id ASC')" id="deadline_filter2" name="user_filter2" class="user_filter2" >                          
                       <option value="All">All</option>
                       <option value="NOT">With Deadline</option>
                       <option value=" ">Without Deadline</option>          
                    </select>
                </div>
               <div class="entolh_apo">                  
                 <h3>Command </h3>
                    <select onchange="update_view('xxx',<?php echo $total_pages; ?>,'1','Id ASC')" id="entolh_filter2" name="user_filter2" class="user_filter2" >                          
                       <option value="All">All</option>
                       <option value=' '> </option>
                        <?php 
                           for ($i=0;$i<count($persons_to_give_orders);$i++)
                            echo "<option value='".$persons_to_give_orders[$i]."'>".$persons_to_give_orders[$i]."</option>"
                        ?>                        
                    </select>
                </div>
               
                <div class="project">
                <h3>Project </h3>
                    <select onchange="update_view('xxx',<?php echo $total_pages; ?>,'1','Id ASC')" id="project_filter2" name="task_filter2" class="user_filter2" >
                        <option value='All'>All</option>
                        <?php   
                            $result_project=mysqli_query($db,"SELECT DISTINCT project FROM tasks WHERE Id LIKE '%.000%' AND project!=''  ");
                            echo "<option value='general_task'>Γενικές Εργασίες</option> "; 
                            while($row = mysqli_fetch_array($result_project)){   
                                if ($row['project'] != ' ' OR $row['project'] != null)
                                   echo "<option value='".$row['project']."'>".$row['project']."</option> "; 
                            } 
                        ?>
                    </select> 
                </div>
               
               <div class='check_box'>
                    <h3>  </h3>
                    <input type="checkbox" onchange="update_view('xxx',<?php echo $total_pages; ?>,'1','Id ASC')" value="check" id='last_filters2'>Show History<br>
               </div>
            </div>
           
             <?php if ( $user_check== "span" OR  $user_check=="kova"){ ?>
             <div class="manager_filters">          
                <div id="delay_pending" class="delay_pending"> 
                    <h3>Delayed Pending</h3><input type="checkbox" class="check_box"  onclick="checkbox_view('1')" id="check1">   
                </div>
                <div id="delay_finished" class="delay_finished"> 
                    <h3>Delayed Finished</h3><input type="checkbox" class="check_box"  onclick="checkbox_view('2')" id="check2"> 
                </div>
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
                <div class="links" id="links">           
                    <div class="insert" id="insert"  ><h5><a style="color:#000099;" href="javascript:showhide('insert_form')">Insert Task</a></h5></div>
                    <div class="export" id="export" > <h5><a style="color:#000099;" id="export_panel"> <img border="0" src="pdf_export.jpg" width="60" height="60"></a></h5>
                   </div>
                </div>
               
                <div id="insert_form"  style="display:none;" class="form"> 
                    <form method="post" action=""   name="form_service" onsubmit="return validateForm()" >    
                    <table class="test_table">
                        <tr>
                            <td>Project</td>
                            <td><input type="project" name="project" pattern="[A-Z]{4}[0-9]{4}|[A-Z]{3}[0-9]{1,4}" maxlength="15" /></td>        
                        </tr><tr>
                            <td>Ημερομηνία Ανάθεσης</td>
                            <td><span class="asterisk">*</span><input type="date" name="date_entry" id="datepicker2"   required  maxlength="15" />e.g. 2000-10-25</td>        
                        </tr><tr>
                            <td>Deadline</td>
                            <td><input type="date" name="deadline" id="datepicker"  maxlength="15" />e.g. 2000-10-25</td>
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
                                        for ($i=0;$i<$length;$i++)
                                            if (get_name_from_username ($user_check)== $users[$i])
                                                echo "<option selected  value='".$users[$i]."'>".$users[$i]."</option>"
                                     ?>
                                </select>
                            </td>
                        </tr><tr>
                            <td>Τμήμα</td>
                            <td colspan="2"><span class="asterisk">*</span>
                                <select required id="dep_filter2" name="department" class="user_filter2" >                          
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
                                <input class="button" type="submit" value="Καταχώριση" name="submit" />
                                <input class="button" type="reset" value="Καθαρισμός" name="cleaner" />
                                <button onclick="javascript:showhide('insert_form')" value="Ακυρωση">Κλεισιμο</button>
                                <br><span class="asterisk">*required fields</span>
                            </td>
                        </tr>			
                    </table>
                 </form>
                </div>   
               
                <div  class="edit_form" id="edit_form"  style="display:none;" >  </div>  
                <div  class="txtHint"   id="txtHint"  ><b></b></div>   
                <div  class="txtHint2"  id="txtHint2" hidden><b></b></div>   
              
                <div id="myDialog"  title="Export Report To PDF">
                    <span id="ttt"> <b>Επιλέξτε Ημερομηνία</span><br>
                       (προαιρετικό)
                        <h6  align="center">Αρχική Ημερομηνία: <input type="text" size="10" id="startDate" /><br>
                                            Τελική Ημερομηνία: <input type="text" size="10" id="endDate" /> </h6> 
                    <h3 align="center"><a style="size:100px; color:#000099;" href="javascript:test('projects2','<?php echo get_name_from_username($user_check); ?> ',document.getElementById('task_filter2').value,document.getElementById('startDate').value,document.getElementById('endDate').value,document.getElementById('user_filter2').value)" >Export PDF</a></h3>
                </div>
                
                <div id="finished_tip" style="display:none;"  title="Ολοκλήρωση TIP">
                    <input hidden id='state_TIP' value=''>
                    <input hidden id='Id_TIP' value=''>
                    <span id="text_on_finish"><b>Ημερομηνία Ολοκλήρωσης:</b></span><br> <input required id="submitDate" type="text" size="10"  /><text id="warning"></text><br>
                    <b>Προσθέστε Σχόλιο<br></b>
                    <span id="text_on_comment">(προαιρετικό)</span><br>           
                        <textarea  rows="3" cols="50" type="text" id="final_comment"  size="400" required maxlength="500" ></textarea>         
                        <text id="warning_comment"></text>
                        <span id="grade"><b> <br>Προτεινόμενη Βαθμολογία TIP<br></b>
                                (προαιρετικό)<br> </span>
                            <select id="rate" required>
                                <option name="gender" value=""> *
                                <option name="gender" value="1"> 1
                                <option name="gender" value="2"> 2
                                <option name="gender" value="3"> 3
                                <option name="gender" value="4"> 4
                                <option name="gender" value="5"> 5
                                <option name="gender" value="6"> 6
                                <option name="gender" value="7"> 7
                                <option name="gender" value="8"> 8
                                
                           </select>   
                         <text id="warning_grade"></text>
                        <h3 align="center"><a id='test_click' style="size:100px; color:#000099;" href="javascript:open_dialog_box(document.getElementById('state_TIP').innerHTML,document.getElementById('Id_TIP').innerHTML,document.getElementById('rate').value,document.getElementById('final_comment').value,document.getElementById('submitDate').value)" >Καταχώρηση</a></h3>
                
             
                </div>
                
            </div>      
       </div>  
  
        <div class="loader" id="loader" style="display:none;" ></div>
   </body> 
</html>
