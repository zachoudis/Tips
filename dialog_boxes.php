
    <div id="pdfExport" style="display:none;"  title="Export Report To PDF">
        <span id="ttt"> <b>Επιλέξτε Ημερομηνία (προαιρετικό)</span>
            <h6  align="center">Αρχική Ημερομηνία: <input type="text" size="10" id="startDate"  /><br>
                                Τελική Ημερομηνία: <input type="text" size="10" id="endDate" /> </h6> 

        <h3 align="center"><a style="size:100px; color:#000099;" href="javascript:PDFFromHTML('<?php echo get_name_from_username($user_check); ?> ',document.getElementById('task_filter2').value,document.getElementById('startDate').value,document.getElementById('endDate').value,document.getElementById('user_filter2').value)" >Export PDF</a></h3>
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
                    <br> </span>
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

    <div id="submit_hours_panel" title="Καταχώρηση Ωρών" style="display:none;">

        <div id="info_panel">
            <div id="day">Μέρα Καταχώρησης: <span id='submit_hour_day'></span></div>
            <div id="total_hours">Συνολικά Λεπτά: <span id='submit_hour_minutes'></span></div>
            <div id="user_type">Από:<span id='from_time'></span>
                                Έως:<span id='to_time'></span>
            </div>
        </div>
        <div id="tips"></div> 
        <div id="pagies"></div>  
        <div id="messages">
            <div id="user_time_id" hidden ></div>
            <div id ="time_registered">Λεπτά Που Έχουν Καταχωρηθεί:       <input type="text" class="total_minutes" id="total_minutes"  value="" size="6" /></div>
            <div id ="time_remaining">Λεπτά Που Απομένουν για Καταχώρηση: <input type="text" class="minutes_left"  id="minutes_left"   value="" size="6"/></div>
            <div id ="alert_messages"></div>
        </div>  
        <div id="submit_hours_buttons">
            <button class="submit_hours_but" id="clear" onclick="clean_dialog_submit_hours()" >Καθαρισμός</button>
            <button class="submit_hours_but" id="submit_hour" onclick="submit_hours()"  >Καταχώρηση</button>
            <button class="submit_hours_but" id="close_hour" onclick="close_dialog_submit_hours()">Κλείσιμο</button>
        </div>
    </div>

    <div id="manage_fixed_jobs_dialog" title="Διαχείρηση Παγίων Ενεργειών" style="display:none;">
        <div id="forma_fixed"><span >Προσθήκη Νέας Πάγιας Εργασίας</span>                       
            <textarea  rows="1" cols="60" type="text" name="description2" id="description2" size="100" required maxlength="500" ></textarea>	                      
            <select required name="username" id="username">     
                <?php 
                   for ($i=0;$i<count($users);$i++)
                      echo "<option value='".get_username_from_name ($users[$i])."'>".$users[$i]."</option>"
                ?>
            </select>     <br>
            <button onclick="submit_fixed_job()"> Submit</button>

        </div>

        <div  id="select_fixed">
                <span>Όνομα: </span>   
                <select onchange="find_user_fixed_jobs(this.options[this.selectedIndex].value)">
                    <option value="all">All</option>
                    <?php 
                       for ($i=0;$i<count($users);$i++)
                          echo "<option value='".get_username_from_name ($users[$i])."'>".$users[$i]."</option>"
                    ?>
                </select>
        </div>
        <div id="fixed_jobs"> </div>  
    </div>

    <div id='insert_fixed_job_dialog' title="Εισαγωγη Πάγιας Εργασίας" style="display:none;">
        <form method="get"  action="manage_fixed_jobs/manage_fixed_jobs.php" target="">

            <span>Περιγραφή:</span><textarea  rows="5" cols="60" type="text" name="description" id="description" size="400" required maxlength="500" ></textarea>	

            <span>Όνομα:</span><br>
            <select required name="username">     
                <?php 
                   for ($i=0;$i<count($users);$i++)
                      echo "<option value='".get_username_from_name ($users[$i])."'>".$users[$i]."</option>"
                ?>
            </select>

            <br><br>
            <textarea  name="mode" id="mode" hidden maxlength="500" >insert</textarea></td>	
            <input type="submit" value="Submit">
        </form>
    </div>

    <div id='user_inout_view_dialog' title="Users InOut" style="display:none;">
        
        <div>
             <br>
                 <span>Ημερομηνία: </span>        
                 <input type="text" size="10" id="inout_day" />
                 <button onclick="find_user_day_inouts()">OK</button>
                 
                 <a style="color:#000099;" href="javascript:PDFFromHTML_UsersInOut();" id="export_panel_UsersInOut"> <img border="0" src="Styles/Images/pdf_export2.png" width="40" height="40"></a>

        </div>
        <div id="inouts_day"></div>

    </div>

    <div id='user_daily_minutes_dialog' title="Users Daily Minutes" style="display:none;">
        <div>
            <span>Όνομα: </span>   
                <select id='daily_user' onchange="find_user_fixed_jobs(this.options[this.selectedIndex].value)">
                    <option value="all">All</option>
                    <?php 
                       for ($i=0;$i<count($users);$i++)
                          echo "<option value='".get_username_from_name ($users[$i])."'>".$users[$i]."</option>"
                    ?>
                </select>
                 <span>Ημερομηνία: </span>        
                 <input type="text" size="10" id="inout_day2" />
                 <button onclick="find_user_day_minutes()">OK</button>
        </div>
        <div id="inouts_day2"></div>

    </div>

    <div id='project_minutes_dialog' title="Project Minutes" style="display:none;">               
        <table  id="project_minutes"  cellspacing="1px">                   
            <tr>         
                <th class="title_tips" style="font-size: 16px; width: auto;" width="62">Project</th>
                <th class="title_tips" style="font-size: 16px; width: auto;" width="102">Total Minutes</th> 
            </tr>
            <?php show_project_minutes($db); ?>
        </table>
    </div>


 <?php
    function show_project_minutes($db){
        $result_project=mysqli_query($db,"SELECT  id_Tip,SUM(minutes) as total_minutes FROM project_time GROUP BY id_Tip; ");  
        $i=0;
        $array_p=array();
        $array_minutes=array();
        while($row = mysqli_fetch_array($result_project)){           
            if (find_project($row['id_Tip']) != 'null'){
                $array_p[$i]=find_project($row['id_Tip']);
                $array_minutes[$i]=$row['total_minutes'];
                $i= $i+1;
            }
        }
        $arrlength = count($array_p);
        $result = array_unique($array_p);
        foreach ($result as &$value) {
            echo "<tr style='height:15px' >";
            echo "<td style='height:15px; font-size: 15px' class='lines' align='center'> <span class=''>".$value.  "</span></td>"; 
            echo "<td style='height:15px; font-size: 15px' class='lines' align='center'> <span class=''>".sum_minutes($array_p,$array_minutes,$value)."</span></td>"; 
            echo "</tr>";
        } 
    }
    function find_project($id){
       $db1 = mysqli_connect('localhost','root','1122','jobs');
       if ($id[0] == 'f'){

         //  mysqli_set_charset($db1, "utf8");
           $result_test=mysqli_query($db1,"SELECT description FROM fixed_jobs WHERE Id_fixed='".$id."';"); 
           $row = mysqli_fetch_array($result_test);
           return $row['description'];
       }
       else{

           $get_id=mysqli_query($db1,"SELECT project FROM tasks WHERE Id='$id';");
           $row = mysqli_fetch_array($get_id);
           if ($row['project'] == '')
               return 'null';
           return $row['project']; 

       }
    }
    function sum_minutes($array_full,$array_minutes,$value){
        $sum_minutes=0;
        $arrlength = count($array_full);

           for($x = 0; $x < $arrlength; $x++) {

              if ($value == $array_full[$x])
                  $sum_minutes=$sum_minutes+$array_minutes[$x];
          }
        return $sum_minutes;
    }
 ?>
