<?php
    //Αυτο το αρχειο περιεχει την φορμα που εμφανιζεται οταν ο χρηστης πατησει το κουμπι edit.

    include('PHP/main_functions.php');  
    include('session.php');
    include('PHP/update_view_functions.php');

    $id= $_GET['id'];
    
    $con = mysqli_connect('localhost','root','1122','jobs');
    $result = mysqli_query($con,"SELECT * FROM tasks WHERE Id='".$id."';");   
    $row = mysqli_fetch_array($result); 
    
    //Μετατρεπει τις ημερομηνιες που τραβηξε απο την Βαση σε format καταλληλο ωστε να το προβαλει
    $timestamp = str_replace('-', '/', $row['date_entry']);
    $new_date_format=date('d/m/Y', strtotime($timestamp));
    $date_entry=$new_date_format;
     //Μετατρεπει τις ημερομηνιες που τραβηξε απο την Βαση σε format καταλληλο ωστε να το προβαλει
    if ($row['deadline'] != null){
    $timestamp2 = str_replace('-', '/', $row['deadline']);
    $new_date_format2=date('d/m/Y', strtotime($timestamp2));
    $row['deadline']=$new_date_format2;
    }
    //Μετατρεπει τις ημερομηνιες που τραβηξε απο την Βαση σε format καταλληλο ωστε να το προβαλει
    if ($row['date_finished'] != null){
    $timestamp3 = str_replace('-', '/', $row['date_finished']);
    $new_date_format3=date('d/m/Y', strtotime($timestamp3));
    $row['date_finished']=$new_date_format3;  
    }   
 ?>

    <form method="post" id="form2" action=""  name="form_service" >
        <table>  
                <tr>
                     <td>Project</td>
                     <td><input type="text" name="project" pattern="[A-ZΑ-Ω]{4}[0-9]{4}|[A-ZΑ-Ω]{3}[0-9]{1,4}" value="<?php echo $row['project'] ?>"  /></td></tr><tr>
                     <td>Task ID</td>
                     <td><input type="text"   disabled value="<?php echo $row['Id'] ?>" required  maxlength="15" /></td>
                </tr><tr>
                    <td>Ημερομηνία Ανάθεσης</td>
                    <td><input type="date"   name="date_entry"  value="<?php echo $date_entry ?>" readonly   maxlength="15" /></td>
                </tr><tr>
                    <td>Deadline</td>
                    <td><input type="date"  name="deadline" id="datepicker7" onmouseover="$('#datepicker7').datepicker({dateFormat: 'dd/mm/yy'});" pattern="(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d"  value="<?php echo $row['deadline'] ?>" maxlength="15" /></td>
                </tr><tr>
                    <?php if ($row['state']=="Finished") {                         
                        echo" <td>Date Finished</td>";
                        echo " <td><input type='date' name='date_finished' id='datepicker5'  pattern='(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d'   value='".$row['date_finished']."'   maxlength='15' /></td>";
                        echo "   </tr><tr> ";
                        echo" <td>Delay</td>";
                        echo " <td><input type='text' name='delay' disabled value='".$row['delay']."' size='2'  maxlength='5' /></td>";
                        echo "   </tr><tr> ";} 
                    ?>
                    <td>Πρακτικό Σύσκεψης</td>
                    <td><input type="number" name="praktiko" value="<?php echo $row['praktiko'] ?>"size="80"  maxlength="80" /></td>
                </tr><tr>
                    <td>Περιγραφή Task</td>
                    <td><textarea  rows="5" cols="60" type="text" name="description" id="description" size="100" required maxlength="300" ><?php echo $row['description'] ?></textarea></td>	
                </tr><tr>
                    <td>Υπεύθυνος</td>
                    <td colspan="2">
                        <select required id="jobkind" name="ipey8inos" required class="box" >
                            <option value="" >---Επιλέξτε---</option>
                            <?php 
                                for ($i=0;$i<count($users);$i++)
                                if ($row['ipey8inos']==$users[$i])
                                   echo "<option value='".$users[$i]."' selected>".$users[$i]."</option>";
                                else
                                   echo "<option value='".$users[$i]."'>".$users[$i]."</option>";
                            ?>
                        </select>	
                    </td>
                </tr><tr>
                    <td>Τμήμα</td>
                    <td colspan="2"><span class="asterisk">*</span>
                         <select  required id="dep_filter2" name="department"  >                          
                            <option value="">All</option>
                            <?php 
                              for ($i=0;$i<count($departments);$i++)
                               if ($row['department']==$departments[$i])
                                    echo "<option value='".$departments[$i]."' selected>".$departments[$i]."</option>";
                               else
                                echo "<option value='".$departments[$i]."'>".$departments[$i]."</option>"
                            ?>                        
                        </select>  
                    </td>
                </tr><tr>
                    <td>Εκδόθηκε Από</td>
                    <td colspan="2"><span class="asterisk">*</span>
                        <select required id="jobkind" name="ekdosh" class="box" >
                           <option value="">---Επιλέξτε---</option>
                           <option value="Άνθιμος" <?php if($row['ekdosh'] == 'Άνθιμος') echo "selected";?>>Άνθιμος</option>
                           <option value="Βασιλική" <?php if($row['ekdosh'] == 'Βασιλική') echo "selected";?>>Βασιλική</option>
                        </select>
                    </td>
                </tr><tr>
                    <td>Σχόλια </td>
                    <td><textarea  rows="2" cols="60" type="text" name="comments"    size="100"  maxlength="300" ><?php echo $row['comments'] ?></textarea></td>					
                </tr><tr>
                    <td colspan="3">
                        <input class="button" type="hidden" value="<?php echo $id; ?>" name="Id" />
                        <input class="button" type="hidden" value="<?php echo $row['G1']; ?>" name="grade" />
                        <input class="button" type="hidden" value="<?php echo $row['state']; ?>" name="state" />
                    
                        <input class="button" type="submit" value="Καταχώρηση" name="edit" />
                        <button onclick="javascript:showhide('edit_form')" value="Ακυρωση">Κλείσιμο</button>
                    </td>
                </tr>			
          </table>
     </form>       
<?php //} 
?>