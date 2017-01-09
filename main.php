<?php
 $sort_value="Id ASC";
  //  $_SESSION['sorting'] = " DESC ";
  //   $_SESSION['sorting_field'] = " Id ";
    //results to show in the page
    $max_result_per_page=15;
    //The total pages 
    $total_pages=get_total_records($max_result_per_page);
    //Users in the TIps program
    $users=array("Μπατζογιάννη Θεανώ","Αλεξοπούλου Στέλλα","Ταμτάκου Σοφία","Κοντός Κρυστάλλης","Ζαχούδης Πάρης","Σπυρίδης Ιορδάνης","Σωτηράκου Αναστασία","Κωνσταντίνου Χρήστος","Κωνσταντίνου Δέσποινα",
         "Παυλίδου Ελισάβετ","Σαββαΐδου Ισμήνη-Αναστασία","Κουντουρά Κρυσταλλία","Κεσκιλίδου Κωνσταντία","Κούκα Δούκισσα","Πλούγαρλης Αναστάσιος","Μανάκος Αντώνιος","Αυγέρος Χρήστος","Μενούτη Σαββίνη","Χαλτογιαννίδου Ελισάβετ","Γεωργάκη Δήμητρα","Ευθυμιάδης Στέφανος");
   
    $usernames=array("mpth","alst","taso","kokr","zari","spio","soan","kwch","kode","keko");
    
    $states =array('Pending','Ολες','Finished','Cancelled','Paused');
   
    $users_mis8wtoi= array ('alst','ayxr','dedi','zari','kokr','kode','kwch','mpth','paai','spio','spni','stor','soan','taso','toma');

     $length = count($users);
    //The departments
     $departments=array("T1","T2","T3","T4","T5","T6","T7","T8","T9","T10","Y1","Y2","Y3","Y4","Y5","Y6","Y7","Y8","Y9","Y10","Y11");
     $length_dep= count($departments);
    //Person for ENtolh APO
     $persons_to_give_orders=array("Άνθιμος","Βασιλική");
   
  
    $pending='';  $cancelled=''; $finished=''; $delayed_task=0; $task_ending_today=0;
    
    $ids=get_list_ids();
  
    
    if(isset( $_POST['edit'] )){ 
        $timestamp = strtotime($_POST['date_entry']);
        $new_date_format = date('Y-m-d', $timestamp);
        
        $timestamp2 = strtotime($_POST['deadline']);
        $new_date_format2 = date('Y-m-d', $timestamp2);
        
        $timestamp3 = strtotime($_POST['date_finished']);
        $new_date_format3 = date('Y-m-d', $timestamp3);
        
        $project = mysqli_real_escape_string($db,$_POST['project']);
        $Id = mysqli_real_escape_string($db,$_POST['Id']);
        $date_entry = mysqli_real_escape_string($db,  $new_date_format);
        $deadline = mysqli_real_escape_string($db,  $new_date_format2);
        $date_finished= mysqli_real_escape_string($db,  $new_date_format3);
        if (isset($_POST['delay'])) $delay = mysqli_real_escape_string($db,$_POST['delay']);
        $praktiko = mysqli_real_escape_string($db, $_POST['praktiko']);
        $description = mysqli_real_escape_string($db, $_POST['description']);
        $department = mysqli_real_escape_string($db, $_POST['department']);
        $ipey8ions = mysqli_real_escape_string($db, $_POST['ipey8inos']);
        $ekdosh = mysqli_real_escape_string($db, $_POST['ekdosh']);
        $comments = mysqli_real_escape_string($db, $_POST['comments']); 

        
        //Edw pairnei ena SUM apo ta tasks pou exoun ID pou ksekinaei apo to standar ID
        $result_sum=mysqli_query($db,"SELECT COUNT(Id) AS sum FROM tasks WHERE Id LIKE '".  floor($Id).".%'  ORDER BY Id ASC");
        $row_sum = $result_sum->fetch_assoc();
        
        //Edw pairnei ola ayta ta id
        $result_ids=mysqli_query($db,"SELECT Id FROM tasks WHERE Id LIKE '".  floor($Id).".%'  ORDER BY Id ASC");
        $array_ids=array(1);

        mysqli_query($db,"UPDATE tasks SET Id='".(floor($Id)+($row_sum['sum']/1000))."' WHERE Id='".floor($Id)."';");


        if ($_POST['state'] == 'Finished'){
	     $delay =  (strtotime($date_finished) - strtotime($deadline))/(60 * 60 * 24);
            if ($_POST['deadline'] == null)
                $sql = "INSERT INTO tasks (project,department,Id ,date_entry ,date_finished , delay , praktiko, description  , ipey8inos ,ekdosh, comments,state ) VALUES ('$project','$department','".floor($Id)."','$date_entry' , '".$_POST['date_finished']."','0','$praktiko' , '$description'  , '$ipey8ions' ,'$ekdosh', '$comments' , 'Finished')";
            else 
                $sql = "INSERT INTO tasks (project,department,Id ,date_entry, date_finished , deadline , delay, praktiko, description  , ipey8inos ,ekdosh, comments,state ) VALUES ('$project','$department','".floor($Id)."','$date_entry',  '".$_POST['date_finished']."', '$deadline','$delay' ,'$praktiko' , '$description'  , '$ipey8ions' ,'$ekdosh', '$comments' , 'Finished')";
        }   
        else{
            if ($_POST['deadline'] == null)
                $sql = "INSERT INTO tasks (project,department,Id ,date_entry , praktiko, description  , ipey8inos ,ekdosh, comments,state ) VALUES ('$project','$department','".floor($Id)."','$date_entry' ,'$praktiko' , '$description'  , '$ipey8ions' ,'$ekdosh', '$comments' , 'Pending')";
            else 
                $sql = "INSERT INTO tasks (project,department,Id ,date_entry, deadline , praktiko, description  , ipey8inos ,ekdosh, comments,state ) VALUES ('$project','$department','".floor($Id)."','$date_entry', '$deadline' ,'$praktiko' , '$description'  , '$ipey8ions' ,'$ekdosh', '$comments' , 'Pending')";
        }
        
        
    if (mysqli_query($db, $sql)){
       // echo "Records added successfully.";   
          header("Location:http://localhost/Jobs/MainPage.php"); /* Redirect browser */
		//header("Location:http://192.168.2.84:86/Tips/MainPage.php"); /* Redirect browser */
    exit();}
    else
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);   
   
    }  
    
    if(isset( $_POST['submit'] )){ 
        $timestamp = strtotime($_POST['date_entry']);
        $new_date_format = date('Y-m-d', $timestamp);
      
        $timestamp2 = strtotime($_POST['deadline']);
        $new_date_format2 = date('Y-m-d', $timestamp2);
        
        $project=mysqli_real_escape_string($db,$_POST['project']);
        $date_entry = mysqli_real_escape_string($db,  $new_date_format);
        $deadline = mysqli_real_escape_string($db,  $new_date_format2);
        $praktiko = mysqli_real_escape_string($db, $_POST['praktiko']);
        $description = mysqli_real_escape_string($db, $_POST['description']);
        $department = mysqli_real_escape_string($db, $_POST['department']);
        $ipey8ions = mysqli_real_escape_string($db, $_POST['ipey8inos']);
        $ekdosh = mysqli_real_escape_string($db, $_POST['ekdosh']);
        $comments = mysqli_real_escape_string($db, $_POST['comments']); 
        $Id=floor(get_last_id())+1;
       
        if ($_POST['deadline'] == null)
            $sql = "INSERT INTO tasks (project, Id , date_entry , praktiko, description , department , ipey8inos ,ekdosh, comments,state ) VALUES ('$project' , '$Id' , '$date_entry' ,'$praktiko' , '$description' ,'$department' , '$ipey8ions' ,'$ekdosh', '$comments' , 'Pending')";
        else 
            $sql = "INSERT INTO tasks (project, Id , date_entry, deadline , praktiko, description , department , ipey8inos ,ekdosh, comments,state ) VALUES ('$project' , '$Id' , '$date_entry', '$deadline' ,'$praktiko' , '$description' ,'$department' , '$ipey8ions' ,'$ekdosh', '$comments' , 'Pending')";
       
       if( mysqli_query($db, $sql)){  
        echo $sql;
        header("Location:http://localhost/Jobs/MainPage.php"); /* Redirect browser */
		//header("Location:http://192.168.2.84:86/Tips/MainPage.php"); /* Redirect browser */
        exit();
    }
    else
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);     
    }  
   
    function get_employee_type($user_check,$users_mis8wtoi){
        
       $type='';       
        if (in_array($user_check,$users_mis8wtoi))
                $type='1';
        else
                $type='2';
        return $type;
    }
    
    
    
    //Επιστρεφει το μεγαλυτερο Id που υπαρχει στην βαση ωστε το καινοργιο να ειναι +1
    function get_last_id(){
          $db = mysqli_connect('localhost','root','1122','jobs');
          $sql = "SELECT MAX(Id) AS max FROM tasks ;" ;
          $result = mysqli_query($db,$sql); 
          $row = $result->fetch_assoc();
         
        return $row['max'];
        
     }
   //Επιστρεφει ενα πινακα με ολα τα Ιd της βασης
    function get_list_ids(){
        $temp_array = array();
        $db = mysqli_connect('localhost','root','1122','jobs');
        $sql = "SELECT Id FROM tasks" ;
        $result = mysqli_query($db,$sql); 
        $count=0;
        while($row = mysqli_fetch_array($result))   {
              $temp_array[$count++]=$row['Id'];
        }  
        return $temp_array;
    } 
     
    //Οταν ενα tasks αλλαξει state τοτε εδω αλλαζουν state και τα προηγουμενα.
    function change_previous_tasks($id,$ids,$state){ 
       $db = mysqli_connect('localhost','root','1122','jobs');
       $sql="SELECT COUNT(Id) As sum FROM tasks;";
       $result = mysqli_query($db,$sql);
	    $row = $result->fetch_assoc();
	    $sum=$row['sum'];
        //H 8esh tou prwtou original task
        $index_current= array_search($id,$ids);
        
        $i=$index_current+1;

            if ($i!=$sum){
                while (floor($ids[$i])==floor($id) ){
                    $sql="UPDATE tasks SET state='".$state."' WHERE id = ".$ids[$i];
                    $result = mysqli_query($db,$sql);    
                    $i++;
			if ($i == sizeof($ids)) break;
                } 
            }
    }
      
    function check_for_newer_version($id,$ids){                    
        $subvision=$id-floor($id);
         if ($subvision == 0)
           return 0;
         else
           return 1;
     }
 
    //Παιρνει σαν εισοδο το username του χρηστη και επιστρεφει το ονοματεπωνυμο του στην επικεφαλιδα της σελιδας
    function get_name($user_check){       
         echo  "<h2 class='name' >".get_name_from_username($user_check)."</h2>"; 
    }
  
    //Παιρνει εισοδο τον αριθμο απο tasks που θελουμε να προβαλονται ανα σελιδα και επιστρεφει τον αριθμο σελιδων που θα υπαρχουν
    function calculate_total_records($results_per_page){       
         $db = mysqli_connect('localhost','root','1122','jobs');
         $sql = "SELECT COUNT(Id) AS total FROM tasks" ;
        
         $result = mysqli_query($db,$sql); 
         $row = $result->fetch_assoc();
         $total_pages = ceil($row["total"] / $results_per_page);
        
         return $total_pages;
     }    
  
    //Παιρνει εισοδο το username και αλλαζει το φιλτρο αναζητησης "Filter by User" αυτοματα για τον καθε χρηστη
    function change_auto_filter($user_check){
         echo " <script>change('".  get_name_from_username($user_check)."')</script>";
    }
    
    //Επιστρεφει το τμημα στο οποιο βρισκεται καθε χρηστης
    function get_department($name){
        if ($name == "Μπατζογιάννη Θεανώ" || $name == "Αλεξοπούλου Στέλλα" || $name == "Σωτηράκου Αναστασία" || $name == "Κωνσταντίνου Χρήστος" || $name == "Κωνσταντίνου Δέσποινα")
            return 'Y7';
        else if ($name == "Ταμτάκου Σοφία" || $name == "Κοντός Κρυστάλλης" )
            return 'Y2';
        else if ($name == "Ζαχούδης Πάρης" || $name == "Σπυρίδης Ιορδάνης" )
            return 'Y8'; 
    }
    
    //Παιρνοντας εισοδο το username επιστρεφει το ονοματεπωνυμα του χρηστη
    function get_name_from_username($user_check){
        
    //    $key=  array_search($user_check, $usernames);
      //  $name= $users[$key];
         if ($user_check=="mpth")
          $name='Μπατζογιάννη Θεανώ';
        else if ($user_check=="alst")
          $name='Αλεξοπούλου Στέλλα';
        else if ($user_check=="taso")
          $name='Ταμτάκου Σοφία';
        else if ($user_check=="kokr")
          $name='Κοντός Κρυστάλλης';
        else if ($user_check=="zari")
          $name='Ζαχούδης Πάρης';
        else if ($user_check=="spio")
          $name='Σπυρίδης Ιορδάνης';
        else if ($user_check=="soan")
          $name='Σωτηράκου Αναστασία';
        else if ($user_check=="kwch")
          $name='Κωνσταντίνου Χρήστος';
        else if ($user_check=="kode")
          $name='Κωνσταντίνου Δέσποινα';
        else if ($user_check=="span")
          $name='Σπυρίδης Άνθιμος';
        else if ($user_check == "kova")
           $name='Κουτάλου Βασιλική';
        else if ($user_check == "pael")
           $name='Παυλίδου Ελισάβετ';   
        else if ($user_check == "sais")
           $name='Σαββαΐδου Ισμήνη-Αναστασία';   
        else if ($user_check == "kukr")
           $name='Κουντουρά Κρυσταλλία';   
        else if ($user_check == "keko")
           $name='Κεσκιλίδου Κωνσταντία';   
        else if ($user_check == "kodo")
           $name='Κούκα Δούκισσα';   
        else if ($user_check == "plan")
           $name='Πλούγαρλης Αναστάσιος';   
        else if ($user_check == "maan")
           $name='Μανάκος Αντώνιος';
        else if ($user_check == "ayxr")
           $name='Αυγέρος Χρήστος';
        else if ($user_check == "hael")
           $name='Χαλτογιαννίδου Ελισάβετ';
        else if ($user_check == "mesa")
           $name='Μενούτη Σαββίνη';
        else if ($user_check == "gedi")
           $name='Γεωργάκη Δήμητρα';
       else if ($user_check == "eust")
           $name='Ευθυμιάδης Στέφανος';
        return $name;
    }
    
    function check_for_delays($user_check,$delayed_task,$ids){
        $name=  get_name_from_username($user_check);
       
        $today=date('Y-m-d');
        $db = mysqli_connect('localhost','root','1122','jobs');
        $result=mysqli_query($db, "SELECT deadline,state,Id FROM tasks WHERE ipey8inos='".$name."' ORDER BY Id ASC ;");
        $result_count=mysqli_query($db, "SELECT deadline,state,Id FROM tasks WHERE ipey8inos='".$name."' ORDER BY Id ASC ;");
        
        while($row = mysqli_fetch_array($result)){
            if ($row['deadline']!=null){
                if ($today>$row['deadline'] && $row['state']=='Pending' && check_for_newer_version($row['Id'],$ids)!=1)            
                   $GLOBALS['delayed_task']=1;
                if ($today == $row['deadline']&& $row['state']=='Pending' && check_for_newer_version($row['Id'],$ids)!=1)
                   $GLOBALS['task_ending_today']=1;
            }
        }
        $GLOBALS['delayed_task_count']=0;
        $GLOBALS['task_ending_today_count']=0;
        while($row_count = mysqli_fetch_array($result_count)){
            if ($row_count['deadline']!=null){
               if ($today>$row_count['deadline'] && $row_count['state']=='Pending' && check_for_newer_version($row_count['Id'],$ids)!=1)
                            $GLOBALS['delayed_task_count']++;
               if ($today == $row_count['deadline']&& $row_count['state']=='Pending' && check_for_newer_version($row_count['Id'],$ids)!=1)
                           $GLOBALS['task_ending_today_count']++;  
           } 
        }
    }
    
    function check_if_null($date){
         if ($date == null)
               $finished='';
         else
               $finished=date('d/m/Y',strtotime($date)); 
         return $finished;
    }
    
    function check_id($id){
        if (($id-(int)$id)==0)
                $final_id=number_format($id,0);
            else
                $final_id=$id;
            
            return $final_id;
    }
    
    //Παιρνει εισοδο το καινουργιο comment kai to προσθετει στο παλιο χωριζοντας τα με κενο.
    function get_old_comment($con,$id,$comment){
            $result3 = mysqli_query($con,"SELECT comments FROM tasks WHERE id=".$id);
            $row2 = $result3->fetch_assoc();
            $old_comments=$row2["comments"];      
            $comment=$old_comments."  ".$comment;
            return $comment;   
        }
    
    //Επιστρεφει τον συνολικο αριθμο απο tasks που υπαρχουν στην βαση
    function get_total_records($page_count){
          $con = mysqli_connect('localhost','root','1122','jobs');
          $result = mysqli_query($con,"SELECT count(Id) as sum FROM tasks");
          $row=$result->fetch_assoc();
          return round($row['sum']/$page_count);
    }
?>


<?php
/*
    function put_lines_description($initial_description){
        $len=strlen($initial_description);
        
        if ($len >50 && $len<=100  )
           $newstr = substr_replace($initial_description, " <br> ", 50, 0);
        else if ($len>100 && $len<=150){
              $newstr = substr_replace($initial_description, " <br> ", 50, 0);
              $newstr = substr_replace( $newstr, " <br> ", 100, 0);}
        else if ($len>150 && $len<=200){
            $newstr = substr_replace($initial_description, " <br> ", 50, 0);
            $newstr = substr_replace( $newstr, " <br> ", 100, 0);
            $newstr = substr_replace( $newstr, " <br> ", 150, 0);}
        else
           $newstr=$initial_description;

        return  $newstr;
    }
*/
?>