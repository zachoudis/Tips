  
function open_dialog_submit(str,id){      
    if (str == 'Cancelled'){

        document.getElementById('rate').disabled='true'
        document.getElementById('text_on_finish').innerHTML="Ημερομηνία Ακύρωσης";
        document.getElementById('text_on_finish').style.fontWeight = 'bold';
        document.getElementById('text_on_comment').innerHTML="";
        document.getElementById('finished_tip').title="Ακύρωση TIP";
    }
     if (str == 'Paused'){

        document.getElementById('rate').disabled='true'

        document.getElementById('text_on_finish').innerHTML="Ημερομηνία Πάυσης";
        document.getElementById('text_on_finish').style.fontWeight = 'bold';
        document.getElementById('text_on_comment').innerHTML="";
        document.getElementById('finished_tip').title="Παύση TIP";
    }
      if (str == 'Pending'){

        document.getElementById('rate').disabled='true'
        document.getElementById('submitDate').disabled='true'
        document.getElementById('text_on_finish').innerHTML="Ημερομηνία Πάυσης";
        document.getElementById('text_on_finish').style.fontWeight = 'bold';
        document.getElementById('text_on_comment').innerHTML="";
        document.getElementById('finished_tip').title="Ενεργοποιηση TIP";
    }


    document.getElementById('state_TIP').innerHTML=str; 
    document.getElementById('Id_TIP').innerHTML=id;
    $(function() {
          var target = $(this);
        $('#finished_tip').dialog({
                  resizable: false,
                  modal: true,
                  show: {effect: 'fade', duration: 400},
                  hide: {effect: 'fade', duration: 100},
                  width: 600,
                  height: 430,
                  position: {
                       my: " bottom",
                       at: " bottom",
                       of: target
                  }, 
                  open: function() { $(function(){$('#submitDate').datepicker({title:'Test Dialog' ,dateFormat: 'dd/mm/yy'}).blur();}); },
                 // close : function(){ $(document).unbind('click');  window.location.href=window.location.href; }   
                  close : function(){}      
        });
    });

 } 
function change_state(str,id,person,grade,submitDate) {   
    if (str == ""){
        document.getElementById("txtHint").innerHTML = "";
        return;
    }else{
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
        xmlhttp.open("GET","change_state.php?q="+str+"&id="+id+"&comment="+person+"&grade="+grade+"&submitDate="+submitDate,true);
        xmlhttp.send();  
    }
}
function open_dialog_box(str,id,grade,comment,submitDate){
    //Elegxos gia comment an exei mpei mono ssthn katastash Cancelled
    var  check_comment=check_comment_empty(str);
    //Elegxos gia hmeromhnia
    var  check_date=check_date2(submitDate,str);
    //Elegxos gia Grade
    var check_grade=check_grade_empty(grade,str);
    //An einai swsta ola ta input oloklhrwnetai h kataxwrhsh


    var flag=false;
    if (check_date==true && check_comment == true && check_grade ){
             change_state(str,id,comment,grade,submitDate);
          
             flag=true;
     } 
     if (flag == true)
     {
        
         
       //  document.getElementById("maincontent").blur();
     //    document.getElementById("panel").blur();
        // showhide('links');
        // showhide('finished_tip');
        // showhide('loader');
         
         $('#finished_tip').dialog('close');
         document.getElementById('loader').style.visibility='visible';
         document.getElementById('blur_div').style.webkitFilter = "blur(3px)";
         setTimeout(function(){ window.location.href=window.location.href;}, 2000);  
     }

 }
function check_grade_empty(grade,str){
    if (document.getElementById('rate').value == '' && str == "Finished"){
        document.getElementById('rate').style.borderColor = "red";
        document.getElementById('warning_grade').innerHTML =  " Πρέπει Να Εισάγετε Βαθμολογία";
        document.getElementById('warning_grade').style.color="red"; 
        return false;
    }
    else 
        return true;

 }
function check_comment_empty(str){
    if (document.getElementById('final_comment').value == '' && str == "Cancelled"){        
        document.getElementById('final_comment').style.borderColor = "red";
        document.getElementById('warning_comment').innerHTML =  " Πρέπει Να Εισάγετε Σχόλιο";
        document.getElementById('warning_comment').style.color="red"; 
        return false;
    }
    else{
        document.getElementById('warning_comment').innerHTML =  "";
        document.getElementById('final_comment').style.borderColor = "black";
        return true;
    }   
}  
function check_date2(submitDate,str){
    var submitDate2=new Date(parseInt(submitDate.substring(0,4)),(parseInt(submitDate.substring(5,7))-1),parseInt(submitDate.substring(8,10)));
    var now = new Date();
    if (str != "Pending"){
        if( document.getElementById('submitDate').value == ''){
            document.getElementById('submitDate').style.borderColor = "red";
            document.getElementById('warning').innerHTML =  " Πρέπει Να Εισάγετε Ημερομηνία";
            document.getElementById('warning').style.color="red";  
            return false;
        }
      //  else if (document.getElementById('submitDate').value != '' && ((now-submitDate2)/86400000)>5){
       //     document.getElementById('submitDate').style.borderColor = "red";
       //     document.getElementById('warning').innerHTML =  " Μπορείτε Να Καταχωρήσετε Μέχρι 4 Μέρες Πρίν";
       //     document.getElementById('warning').style.color="red";
       //     return false;
      //  } 
        else{
            document.getElementById('submitDate').style.borderColor = "black";
            document.getElementById('warning').innerHTML =  " "; 
            return true;
        }
    }
    else
        return true;    
}
  