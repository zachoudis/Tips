//Open the dialog BOx "manage_fixed_jobs_dialog"
function manage_fixed_jobs(){
   find_user_fixed_jobs('all');
        $(function() {
             var target = $(this);
            $('#manage_fixed_jobs_dialog').dialog({
                resizable: true,
                modal: true,
                show: {effect: 'fade', duration: 400},
                hide: {effect: 'fade', duration: 100},
                width: 740,
                height: 700,
                position: {
                    my: " bottom",
                    at: " bottom",
                    of: target
                }, 
            //     open: function() { $(function(){$('#submitDate').datepicker({title:'Test Dialog' ,dateFormat: 'yy-mm-dd'}).blur();}); },
                 close : function(){ sum=0; }      
                });
            });
}
//Ajax call to manage_find_user_fixed_jobs.php
function find_user_fixed_jobs(value){
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("fixed_jobs").innerHTML = this.responseText;
            }
        };
       
        xmlhttp.open("GET","manage_fixed_jobs/manage_find_user_fixed_jobs.php?username="+value,true);
        xmlhttp.send();  
    }    
    
//Deletes a fixed Job
function delete_fixed_job(id){    

       if (window.XMLHttpRequest) {
           xmlhttp = new XMLHttpRequest();
       } else {
           xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
       }
       xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               document.getElementById("fixed_jobs").innerHTML = this.responseText;
           }
       };
       xmlhttp.open("GET","manage_fixed_jobs/manage_fixed_jobs.php?Id="+id+"&mode=delete",true);
       xmlhttp.send();  
       find_user_fixed_jobs('all');
        
}

//Edits a Fix Job
function edit_fixed(id){
var description = prompt("Edit the Description for Id:"+id, "");
edit_fixed_job(id,description);
}
function edit_fixed_job(id,description){    
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("fixed_jobs").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET","manage_fixed_jobs/manage_fixed_jobs.php?Id="+id+"&mode=edit&description="+description,true);
    xmlhttp.send();
    find_user_fixed_jobs('all');
    
}

//Inserts fix Job
function insert_fixed_job(){
    $(function() {
        var target = $(this);
        $('#insert_fixed_job_dialog').dialog({
            resizable: true,
            modal: true,
            show: {effect: 'fade', duration: 100},
            hide: {effect: 'fade', duration: 100},
            width: 500,
            height: 300,
            position: {
                my: " bottom",
                at: " bottom",
                of: target
            }, 
            close : function(){ sum=0; }      
        });
    });
}
function submit_fixed_job(){
    
     if (window.XMLHttpRequest) {
           xmlhttp = new XMLHttpRequest();
       } else {
           xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
       }
       xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               document.getElementById("fixed_jobs").innerHTML = this.responseText;
           }
       };
       
      var description = document.getElementById('description2').value;
      var username = document.getElementById('username').value;
       
       if (description == '')
         alert("Adeio description prospathise ksana");
     else{
       xmlhttp.open("GET","manage_fixed_jobs/manage_fixed_jobs.php?username="+username+"&mode=insert&description="+description,true);
       xmlhttp.send();
       document.getElementById('description2').value=' ';
   }
           find_user_fixed_jobs('all');
    
   
}
