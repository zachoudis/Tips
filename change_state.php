<!DOCTYPE html>
<?php
    include('PHP/main_functions.php');
    //Το αρχειο αυτο καλειτε οταν ο χρηστης αλλαξει κατασταση σε ενα TIP. πχ απο PENDING σε FINISHED. 
    //Και αναλογα με το ποια κατασταση βρισκεται και ποια θελει να παει, τρεχει το καταλληλο query στο database 
    
    
    $state= $_GET['q'];
    $id =  $_GET['id'];
    $comment = $_GET['comment'];
    $grade = $_GET['grade'];
    $timestamp = str_replace('/', '-', $_GET['submitDate']);
    $submitDate = date('Y-m-d', strtotime($timestamp));
    
    change_previous_tasks($id,$ids,$state);

    //If the state was PENDING and Changed to FINISHED OR CANCELLED
    $con = mysqli_connect('localhost','root','1122','jobs');
    if (!$con) { die('Could not connect: ' . mysqli_error($con));}
        
        $curr_date= $submitDate;
        //Gets the Deadline from the database
        $sql2="SELECT deadline FROM tasks WHERE id=".$id;
        $result2 = mysqli_query($con,$sql2);
        $row = $result2->fetch_assoc();
        
        //Gets the already inserted comment  and add the new one       
        $comment=get_old_comment($con,$id,$comment);
        
        
        
        
        
        //If there is a deadline
        if ($row["deadline"]!=null){
            $deadline=$row["deadline"];           
            //If state FINISHED
            if ($state == "Finished"){
                //IF THERE IS NO DELAY
                if ($curr_date<=$deadline){
                    if ($grade == 'null')
                        $sql="UPDATE tasks SET date_finished='".$curr_date."' ,state='".$state."' ,comments='".$comment."'  WHERE id =".$id;
                    else
                        $sql="UPDATE tasks SET date_finished='".$curr_date."' ,state='".$state."' ,comments='".$comment."' ,G1='".$grade."' WHERE id =".$id;           
                }
                //IF THERE IS DELAY
                else if ($curr_date>$deadline){
                    $delay =  (strtotime($curr_date) - strtotime($deadline))/(60 * 60 * 24);
                    if ($grade == 'null')
                        $sql="UPDATE tasks SET date_finished='".$curr_date."',delay='".$delay."' ,state='".$state."'  ,comments='".$comment."'  WHERE id =".$id;   
                    else
                        $sql="UPDATE tasks SET date_finished='".$curr_date."',delay='".$delay."' ,state='".$state."'  ,comments='".$comment."' , G1='".$grade."' WHERE id =".$id;   
                }
            }
            //If state CANCELLED
            else if ($state == "Cancelled" || $state == "Paused")
                $sql="UPDATE tasks SET date_finished='".$curr_date."',state='".$state."',comments='".$comment."' WHERE id =".$id;
            else if ($state == "Pending")
                $sql="UPDATE tasks SET date_finished=NULL,state='".$state."',comments='".$comment."' WHERE id =".$id;
        }
        //If there is not a deadline
        else {
            //If state FINISHED
            if ($state == "Finished"){ 
                if ($grade == 'null')
                    $sql="UPDATE tasks SET date_finished='".$curr_date."' ,state='".$state."'  ,comments='".$comment."' WHERE id =".$id;     
                else
                    $sql="UPDATE tasks SET date_finished='".$curr_date."' ,state='".$state."'  ,comments='".$comment."', G1='".$grade."' WHERE id =".$id;     
            }
            //If state CANCELLED
            else if ($state == "Cancelled" || $state == "Paused" )
                $sql="UPDATE tasks SET date_finished='".$curr_date."',state='".$state."',comments='".$comment."' WHERE id =".$id;
        
            else if ($state == "Pending")
                 $sql="UPDATE tasks SET date_finished= NULL, state='".$state."',comments='".$comment."' WHERE id =".$id;
            }

       
  
          if (!mysqli_query($con,$sql)) {
                 echo("Errormessage: %s\n".mysqli_error($con));
        }           
      //  echo $sql;
    
    
?>

