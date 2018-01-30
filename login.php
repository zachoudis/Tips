<?php
   include("config.php");
   session_start();
   $error='';
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      
      $sql = "SELECT id FROM users WHERE username = '$myusername' and passcode = '$mypassword'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
     // $active = $row['active'];
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
      //   session_register("myusername");
         $_SESSION['login_user'] = $myusername;
         
         header("location: MainPage.php");
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>

<html>
   
   <head>
      <title>Login Page</title>   
      <style type = "text/css">
         body {
            font-family:Arial;
            font-size:14px;
         }
         
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }

         .box {
            border:#666666 solid 1px;
         }
         #login_button{
             border-radius: 10px;
             position: relative;
             width:120px;
             font-size: 17px;
         }
      </style>     
   </head>
   
   <body bgcolor = "#bfbfbf">	
        <div align = "center" style= "top: 31%; position: absolute; left: 40%; ">
             <div  align = "center" style = "width:310px; border: solid 1px #333333; background-color: #e6e6e6; border-radius: 6px;" align = "left">
                <div align = "center" style = "background-color:#333333; color:#FFFFFF; padding:3px; "><b>Tips Login</b></div>			
                <div align = "center" style = "margin:30px">
                        <form action = "" method = "post">
                            <label>UserName  </label><input style="border-radius: 3px;"type = "text" name = "username" class = "box"/><br /><br />
                            <label>Password  </label><input style="left: 2px; position: relative; border-radius: 3px;" type = "password" name = "password" class = "box" /><br/><br />
                            <input id='login_button' type = "submit" value = " Submit "/><br />
                        </form>
                   <div align = "center" style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
                </div>		
            </div>			
        </div>
   </body>
</html>