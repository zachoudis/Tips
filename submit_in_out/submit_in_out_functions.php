<?php 
    //Καλειτε στην αρχη με το φορτωσει η σελιδα.
    function submit_time_in($user_check){ 
        //Ο current user
        $user=$user_check;
        //H σημερινη ημερομηνια
        $date=date('Y-m-d');
        $time=date('H:i',strtotime('+3 hours'));
        
        //Τραβαει απο την βαση καταχωρησεις για τον current user την σημερινη μερα
        $con = mysqli_connect('localhost','root','1122','jobs');
        $result = mysqli_query($con,"SELECT COUNT(*) As sum FROM user_time WHERE username='$user' and date='$date';");
        $row=mysqli_fetch_array($result);

        //Αν δεν υπαρχει καμια φτιαχνει μια καινουργια καταχωρηση στο table user_time.
        //Εδω μεσα μπαινει μονο την πρωτη φορα που ανοιγουμε το Tips ωστε να γραψει την πρώτη ωρα που καναμε In στο συστημα
        if ($row['sum']==0)
            $result = mysqli_query($con,"INSERT INTO user_time (username,date,time_in,day_closed) VALUES('$user','$date','$time','0');"); 
    }
    
    //Ειναι υπευθυνη για τα μυνηματα που εμφανιζονται. Τα Log on Log off
    function print_messages($user_check){
        print_logon_message($user_check);
        print_logoff_message($user_check);
        print_stop_button($user_check);
        print_start_time_button($user_check);
    }
       
    //Αυτη η συναρτηση εμφανιζει το Log On time της τελευταιας καταχωρησης ωρας του χρηστη.
    //Μπορει να εχει κανει πολλαπλα in out. Παιρνει μονο το τελευταιο In.
    function print_logon_message($user_check){
        $user=$user_check;
        $date=date('Y-m-d');
        $con = mysqli_connect('localhost','root','1122','jobs');
        $result = mysqli_query($con,"SELECT time_in FROM user_time WHERE username='$user' and date='$date' Order BY Id DESC;");
        $row=mysqli_fetch_array($result);
        echo "<span id='logon_message'>Log On : ".$row['time_in']." (".floor_time_in($row['time_in']).")</span>";    
    }
    //Αυτη η συναρτηση εμφανιζει στο πλαισιο το Log Off μυνημα ωρας.
    //Μονο αν υπαρχει κλειστη ωρα που τρεχει θα εμφανισει κατι. Αλλιως δεν εμφανιζει τιποτα
    //Σε περιπτωση που εχει κλείσει η ωρα θα εμφανισει το LogOff message και το Submit total time message
    function print_logoff_message($user_check){
        $user=$user_check;
        $date=date('Y-m-d');
        $con = mysqli_connect('localhost','root','1122','jobs');
        $isOpen=is_Open($user_check);
        if ($isOpen == 0){
            $result = mysqli_query($con,"SELECT time_out,minutes,Id FROM user_time WHERE username='$user' and date='$date' ORDER BY Id DESC;");
            $row=mysqli_fetch_array($result);
            echo "<br><span id='logon_message'>Log Off : ".$row['time_out']." (".floor_time_out($row['time_out']).")</span>";
            echo "<br><span id='logon_message'>Submit  : ".$row['minutes'] ." '' </span>";
        }    
    }
  
    //Αν και μονο αν τρεχει χρονος τοτε θα εμφανιζεται στην χρηστη το Stop Time Button
    function print_stop_button($user_check){
        $isClosed=is_Open($user_check);
       if($isClosed == 1)
            echo "<button id='stop_time_button' type='button' onclick='submit_time_out()' >Stop Time</button>";
    }
    //Αν ο χρονος δεν τρεχει για τον χρηστη τοτε θα εμφανιζεται το Start Time Buton
    function print_start_time_button($user_check){
        $is_open=is_Open($user_check);
        if ($is_open == 0)
            echo "<button id='stop_time_button' type='button' onclick='submit_button_time_in()' >Start Time</button>";

    }
    
    //Οταν καλειται αυτη η συναρτηση μας επιστρεφει αν υπαρχει χρονος ανοιχτος που τρεχει για καποιον χρηστη.
    function is_Open($user_check){
        
        $user=$user_check;
        $date=date('Y-m-d');
        $con = mysqli_connect('localhost','root','1122','jobs');
        $result = mysqli_query($con,"SELECT COUNT(*) As sum FROM user_time WHERE username='$user' AND date='".$date."' AND day_closed=0;");
        $row=mysqli_fetch_array($result);
         if ($row['sum'] == 1) return 1;   
         else return 0;
    }
    
    //Βοηθητικη συναρτηση που βαζει το time_in του χρηστη σε μια κρυφη μεταβλητη
    function return_time_in($user_check){
        $con = mysqli_connect('localhost','root','1122','jobs');
        $user=$user_check;
        $date=date('Y-m-d');
        $result = mysqli_query($con,"SELECT time_in FROM user_time WHERE username='$user' and date='$date' ORDER BY Id DESC;");
        $row=mysqli_fetch_array($result);
        return $row['time_in'];  
    }
    
    function floor_time_in($time_in){

        $minutes=  $time_in[3].$time_in[4];
        if ($minutes == 0)
           $final_time_in=$time_in[0].$time_in[1].$time_in[2].'00';
        else if ($minutes>=1 and $minutes<=15)
            $final_time_in=$time_in[0].$time_in[1].$time_in[2].'15';
        else if ($minutes>=16 and $minutes<=30)
            $final_time_in=$time_in[0].$time_in[1].$time_in[2].'30';
        else if ($minutes>=31 and $minutes<=45)
            $final_time_in=$time_in[0].$time_in[1].$time_in[2].'45';
        else if ($minutes>=46 and $minutes<=60)
            if ($time_in[1] == 9)
                $final_time_in=($time_in[1]+1).$time_in[2].'00';
            else
                $final_time_in=$time_in[0].($time_in[1]+1).$time_in[2].'00';
        return $final_time_in;
    }
    
    function floor_time_out($time_out){
        $minutes=  $time_out[3].$time_out[4];
       
        if ($minutes>=0 and $minutes<=15)
                $final_time_in=$time_out[0].$time_out[1].$time_out[2].'00';
        else if ($minutes>=16 and $minutes<=30)
                $final_time_in=$time_out[0].$time_out[1].$time_out[2].'15';
        else if ($minutes>=31 and $minutes<=45)
                $final_time_in=$time_out[0].$time_out[1].$time_out[2].'30';
        else if ($minutes>=46 and $minutes<=60)
                $final_time_in=$time_out[0].$time_out[1].$time_out[2].'45';
        //$final_time_in=$time_out;
        return $final_time_in;
    }

    ?>