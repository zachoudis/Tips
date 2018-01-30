    //Anoigei to Dialog BOx "submit_hours_panel" 
    function submit_hours_dialog(date,minutes,id,time_in,time_out){   
        $(function() {
             var target = $(this);
            $('#submit_hours_panel').dialog({
                class:'JAH',
                resizable: true,
                modal: true,
                show: {effect: 'fade', duration: 400},
                hide: {effect: 'fade', duration: 100},
                width: 1000,
                height: 800,
                position: {
                    my: " bottom",
                    at: " bottom",
                    of: target
                }, 
                open : function(){                
                    //Εδω παιρνουν τις τιμες του τα πεδία που ειναι πανω πανω στο dialog box.
                    document.getElementById('user_time_id').innerHTML=id;
                    document.getElementById('submit_hour_minutes').innerHTML=minutes;
                    document.getElementById('submit_hour_day').innerHTML=date;
                    document.getElementById('from_time').innerHTML=time_in;
                    document.getElementById('to_time').innerHTML=time_out;  
                    //Αυτη η συναρτηση παιρνει και εμφανιζει στο dialog τα Tips που εχει διαθεσιμα ο χρηστης και μπορει να καταχωρησει ωρα
                    find_user_tips();
                    //Αυτη η συναρτηση παιρνει και εμφανιζει στο dialog τα fixed_jobs που έχει ο χρήστης
                    find_user_fixed_jobs2();   
                    document.getElementById('submit_hour').disabled=true;
                  },
                close : function(){
                    sum=0; 
                    document.getElementById('total_minutes').value=null;
                    document.getElementById('alert_messages').innerHTML="";
                 }      
                });
            });
    }   
    //Ajax call find_user_tips.php
    //Ψαχνει και εμφανιζει τα Tips που εχει ο user ενεργα ωστε να καταχωρήσει ώρες
    function find_user_tips(){          
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("tips").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","submit_hours/find_user_tips.php",true);
        xmlhttp.send();  
    }    
    //Ajax call find_user_fixed_jobs.php
    //Ψάχνει και εμφανίζει στο δεξι κομματι του dialog τα fixed_jobs που έχει ο user
    function find_user_fixed_jobs2(){   
       
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("pagies").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","submit_hours/find_user_fixed_jobs.php",true);
        xmlhttp.send();  
    }    

 ///////////////////////////////////////////////////////////////////////////////////////
 //Αυτες ειναι οι 3 συναρτησεις μια για καθε button του dialog box (Submit , Close , Clean)
    //Ajax call to apply_time και καταχωρουνται οι ωρες στα αντιστοιχα tips
    function submit_hours(){
         if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        
        var minutes=document.getElementsByClassName('quantity_minutes');
        var tips_id=document.getElementsByClassName('tips_id_minutes');
        var user_time_id= document.getElementById('user_time_id').innerHTML;     
  
        var arrayNumbers1 = [];
        var arrayNumbers2 = [];

        for (i=0;i<minutes.length;i++){    
            arrayNumbers1.push(minutes[i].value);
            arrayNumbers2.push(tips_id[i].innerHTML);
        }     

        var myJSONminutes  = JSON.stringify(arrayNumbers1);
        var myJSONtips_id  = JSON.stringify(arrayNumbers2);

        xmlhttp.open("GET","submit_hours/apply_time.php?myJSONminutes=" + myJSONminutes+"&myJSONtips_id="+myJSONtips_id+"&user_time_id="+user_time_id,true);
        xmlhttp.send();  
     
        $('#submit_hours_panel').dialog('close');
           document.getElementById('loader').style.visibility='visible';
            document.getElementById('blur_div').style.webkitFilter = "blur(3px)";
        setTimeout( function(){ window.location.href=window.location.href;}, 1500);  
    }
    //Closes dialog box
    function close_dialog_submit_hours(){
        document.getElementById('total_minutes').value='';
        document.getElementById('minutes_left').value='';
        $('#submit_hours_panel').dialog('close'); 
    }
    //Resets (Clean) dialog box
    function clean_dialog_submit_hours(){
        var minutes=document.getElementsByClassName('quantity_minutes');
            for (i=0;i<minutes.length;i++){    
              document.getElementsByClassName('quantity_minutes')[i].value='';
            }
        document.getElementById('total_minutes').value=null;
        document.getElementById('minutes_left').value=null;
        document.getElementById('alert_messages').innerHTML='';
    }