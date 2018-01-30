<?php
include('../PHP/main_functions.php');
include('../session.php');

$minutes=$_GET['myJSONminutes'];
$tips_id=$_GET['myJSONtips_id'];

$minutes_array=json_decode($minutes);
$tips_id_array=json_decode($tips_id);

$username=$user_check;
$id_time=$_GET['user_time_id'];

$con = mysqli_connect('localhost','root','1122','jobs');
 

 for ($i=0;$i<count($tips_id_array);$i++){
    if ($minutes_array[$i]>0){
        //check gia to an h ergasia einai tip h fixed 
        if($tips_id_array[$i][0]!='f'){
            $result=mysqli_query($con,"SELECT state,closed FROM tasks WHERE Id= ".$tips_id_array[$i].";");
            $row = mysqli_fetch_array($result);
            //If Finished Tip must set Closed=1
            if ($row['state']=="Finished"){
                mysqli_query($con,"INSERT INTO project_time (username,minutes,project,id_Tip,id_Time) VALUES ('".$username."' , '".$minutes_array[$i]."','".find_project_name($tips_id_array[$i])."','".$tips_id_array[$i]."', '".$id_time."' );");
                mysqli_query($con,"UPDATE tasks SET closed=1 WHERE Id=".$tips_id_array[$i].";");
            }
            else
                mysqli_query($con,"INSERT INTO project_time (username,minutes,project,id_Tip,id_Time) VALUES ('".$username."' , '".$minutes_array[$i]."','".find_project_name($tips_id_array[$i])."', '".$tips_id_array[$i]."', '".$id_time."' );");
        }
        else   
            mysqli_query($con,"INSERT INTO project_time (username,minutes,id_Tip,id_Time) VALUES ('".$username."' , '".$minutes_array[$i]."', '".$tips_id_array[$i]."', '".$id_time."' );");
    }
     $id_tip=mysqli_query($con,"SELECT id_Tip FROM project_time ORDER BY Id DESC LIMIT 1;");
     $row_Tip = mysqli_fetch_array($id_tip);
     $id_tip2=mysqli_query($con,"SELECT MAX(Id) as max FROM project_time;");
     $row_Tip2 = mysqli_fetch_array($id_tip2);
     mysqli_query($con,"UPDATE project_time SET project ='".find_project_name($row_Tip['id_Tip'],$con)."'  WHERE Id='".$row_Tip2['max']."' ;");
 }
     mysqli_query($con,"UPDATE user_time SET submited = 1 WHERE Id= ".$id_time.";");
     
     
     
     
  function find_project_name($id,$con){
    $iid=(int)$id;
    $result=mysqli_query($con,"SELECT project FROM tasks WHERE Id= ".$iid.";");
    $row = mysqli_fetch_array($result);
       
    return $row['project']; 
  }   
?>
