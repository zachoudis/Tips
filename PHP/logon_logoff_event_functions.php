<?php
    function apply_sql_query($date,$users_time){
        $db = mysqli_connect('localhost','root','1122','jobs');   
        $count=count($users_time);  
        echo '<br>COUNT:'.$count;
        for ($i=0;$i<$count;$i++)
            {
            echo '<br>DATE:'.$date;
            echo '<br>USER:'.$users_time[$i][0];
            echo '<br>TIME:'.$users_time[$i][1];
                 // $result = mysqli_query($db,"UPDATE user_time SET submited=0,date=".$date.",username=".$users_time[$i][0].",minutes=".$users_time[$i][1]." WHERE Id=10;"); 
                echo mysqli_query($db,"INSERT INTO user_time (submited,date,username,minutes) VALUES(0,2017-01-06,'zari','666');"); 
            }
        
    }
   
    function generate_users_logon_time($logons,$logouts){
       $users_time=array(array(2));

       $index_users_time=0;
       for ($i=0;$i<count($logons);$i++){
            $flag=false;

            for ($j=0;$j<count($logouts);$j++)
                if (strcmp ($logons[$i][0],$logouts[$j][0])==0){
                    $final_test= floor((strtotime($logouts[$j][1])-strtotime($logons[$i][1]))/60);

                    $users_time[$index_users_time][0]=$logons[$i][0];
                    $users_time[$index_users_time][1]=calculate_time($final_test);
                    $index_users_time=$index_users_time+1;
                    $flag=true;
                }   
       }
        return $users_time;
    }

    function calculate_time($final_minutes){
            $hours = floor($final_minutes / 60);
            $minutes = ($final_minutes % 60);

            if ($hours=='' and $minutes=='')
                return '0:00';
            if ($hours<0 or $minutes<0)
                return '';
            if ($minutes>=0 and $minutes<10)
                return $hours.":0".$minutes;
            else
                return $hours.":".$minutes;

    }
    
    function floor_users_time_in($array){  
        $users_time=array(array(2));
        for ($i=0;$i<count($array);$i++)
        {
            echo "<br>".floor_time_in( date('H:i',strtotime($array[$i][1])))."  ";
            $users_time[$i][0]=$array[$i][0];
            $users_time[$i][1]=floor_time_in( date('H:i',strtotime($array[$i][1])));
        }
        return $users_time;
    } 
    
    
    function floor_users_time_out($array){  
        echo "<br>Floor Logoffs";
        $users_time=array(array(2));
        for ($i=0;$i<count($array);$i++)
        {
            echo "<br>".floor_time_out( date('H:i',strtotime($array[$i][1])))."  ";
            $users_time[$i][0]=$array[$i][0];
            $users_time[$i][1]=floor_time_out( date('H:i',strtotime($array[$i][1])));
        } 
        return $users_time;
    }

    function check_pairs($logins,$logouts){
        for ($i=0;$i<count($logins);$i++){
            for ($j=0;$j<count($logouts);$j++){
                if (strcmp($logins[$i][0],$logouts[$j][0])==0)
                    echo "<br>Pair : ".$logins[$i][0];             
            }        
        } 
    }
    
    //Ftiaxnoun pinakes pou periexoun mono ta prwta login kai ta teleytaia logout gia mia mera ana xrhsth
    function find_first_logons($array){
        $array_count=count($array);  
        for ($i=0;$i<$array_count;$i++){
            for ($j=0;$j<$array_count;$j++){
                //Pernaei apo ola ta stoixeia tou pinaka kai sugkrinei kaue item me ola ta alla ektos apo ton eayto tou
                if ($i!=$j){
                    //An einai null simainei oti exei ginei unset pio prin
                    if ($array[$i]!=null && $array[$j]!=null){
                        //an h strcmp epistrepsei 0 brike event me to idio usernamegmai 
                       if (strcmp( $array[$i][0],$array[$j][0])==0){
                            //Sygkrinei ta 2 event gia na krathsei ayto pou einai pio late ston xrono
                            if ( $array[$i][1] <  $array[$j][1]){
                                unset($array[$j][0]);
                                unset($array[$j][1]);}
         }}}}}

        return clear_empty_array_cells($array);
    } 
    function find_last_logouts($array){
        $array_count=count($array);
        for ($i=0;$i<$array_count;$i++){
            for ($j=0;$j<$array_count;$j++){
                //Pernaei apo ola ta stoixeia tou pinaka kai sugkrinei kaue item me ola ta alla ektos apo ton eayto tou
                if ($i!=$j){
                    //An einai null simainei oti exei ginei unset pio prin
                    if ($array[$i]!=null && $array[$j]!=null){
                        //an h strcmp epistrepsei 0 brike event me to idio username
                        if (strcmp( $array[$i][0],$array[$j][0])==0){
                            //Sygkrinei ta 2 event gia na krathsei ayto pou einai pio late ston xrono
                            if ( $array[$i][1] >  $array[$j][1]){
                                unset($array[$j][0]);
                                unset($array[$j][1]);      
        }}}}}}
        return clear_empty_array_cells($array);
    } 

    function clear_empty_array_cells($array){
        $final_login=array();
        $index=0;
        for ($i=0;$i<count($array);$i++){
            if ($array[$i]!=null){
                $final_login[$index][0]=$array[$i][0];
                $final_login[$index][1]=$array[$i][1];
                $index=$index+1;
        }}
        return $final_login;
   }

    //Checks for dublicate event entries
    function search_array($value,$array,$counter_logins){ 
        for ($i=0;$i<$counter_logins;$i++){  
            if ($value===$array[$i][1])                 
                return 0;             
        }
        return 1;  
    }  
    //Format windows event time to Php date format
    function format_time($time){  
        $time5=explode("Z",$time);
        $time6=  explode('.',$time5[0]);
        $date = new DateTime($time6[0]);
        $timestamp = $date->format('Y-m-d H:i:s');
        //echo "*** ".$timestamp." ***";
        return $timestamp;
    }

    function get_date($xml){
        $x=0;
        foreach($xml->children() as $child)
        {
            $date=explode("T",$child->System->TimeCreated['SystemTime']);
            // echo "<br>DATE :".$date[0];
            $date2 = new DateTime($date[0]);
            $x=1;
            if ($x==1)
                return $date2->format('Y-m-d');;
              
        }
      
    }
    function import_logon_events($xml){
        $logins=array(array(2));
        $counter_logins=0;
        foreach($xml->children() as $child)
        {
         //    echo $child->getName() . " -> " . $child ;
            if ($child->System->EventID == '4624'){
            //  echo "LogOn : ".$child->System->EventID ;
            //  echo " : ". $child->EventData->Data[5]." ";
                $ctime=format_time($child->System->TimeCreated['SystemTime'] );
            //  echo "<br>";
                if(search_array($ctime , $logins,$counter_logins)==1){
                    $logins[$counter_logins][0]=$child->EventData->Data[5];
                    $logins[$counter_logins][1]=$ctime;
                    $counter_logins=$counter_logins+1;
        }}}
        return $logins;
    }

    function import_logouts_events($xml){
        $logouts=array(array(2));
        $counter_logouts=0;
        foreach($xml->children() as $child)
        {
            if ($child->System->EventID == '4647'){
             // echo "LogOff : ".$child->System->EventID ;
            //  echo " : ". $child->EventData->Data[1] ." ";
                $ctime=format_time($child->System->TimeCreated['SystemTime'] );
            //  echo "<br>";
                $logouts[$counter_logouts][0]=$child->EventData->Data[1];
                $logouts[$counter_logouts][1]=$ctime;
                $counter_logouts=$counter_logouts+1;
        }}
        return $logouts;
    }
    function process_array($array){
           $array_count=count($array);
           $new_array=array();
           
           for ($i=0;$i<$array_count;$i++){
               $new_array[$i]= array('user' => $array[$i][0], 'time' => $array[$i][1]);   
           }
           
           foreach ($new_array as $key => $row) {
                $user[$key]  = $row['user'];
                $time[$key] = $row['time'];
            }

            // Sort the data with volume descending, edition ascending
            // Add $data as the last parameter, to sort by the common key
            echo "<br>TEST<br>";
            array_multisort($user, SORT_ASC , $new_array);
            
            echo "<br>";
            for ($i=0;$i<3;$i++)
                echo $new_array[$i]['user']." : ".$new_array[$i]['time']."<br>";       
       }
     ?>