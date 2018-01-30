    function addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}
  
    //Ekteleite οταν πατηθει το button για το τελος μετρησης του χρονου. Υπολογιζει τα λεπτα IN και μετα τα στελνει στην βαση δεδομενων
    function submit_time_out(){
          
        //Αυτες οι 2 ειναι οι κρυφες μεταβλητες που υπαρχουν στο div - hours_info
        var user = document.getElementById('username2').innerHTML;
        var time_in = document.getElementById('time_in').innerHTML;

        //Εδω παιρνει την τωρινη ωρα. Δηλαδη το time_out της καταχώρησης
        var currentdate = new Date(); 
        var time_out = addZero(currentdate.getHours()) + ":" + addZero(currentdate.getMinutes());
          
        //Εδω στρογγυλοποιουνται τα time_out και time_in με ακριβεια τεταρτου
        var floor_time_in1 = floor_time_in(time_in);        
        var floor_time_out1 = floor_time_out(time_out);
  
        //Εδω υπολογιζονται οι χρονου σε λεπτα ωστε να γινει η αφειρεση τους.
        var time_in_minutes= calculate_time_in_minutes(floor_time_in1);    
        var time_out_minutes=calculate_time_in_minutes(floor_time_out1); 

        //Εδω εχουμε την αφαιρεση των 2 χρονων ωστε να δουμε την διαφορα τους.
        var final_time=time_out_minutes-time_in_minutes;

        if (final_time < 1)
            final_time=0;
        var t=1;
        if (isNaN(final_time)==true){
           alert("NAN Value Try again");
        }else{
        if (window.XMLHttpRequest) {
             xmlhttp = new XMLHttpRequest();
         } else {
             xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
         }
         xmlhttp.onreadystatechange = function() {
             if (this.readyState == 4 && this.status == 200) {
                 document.getElementById("hours_info").innerHTML = this.responseText;
             }
         };   
         
        //Εδω εχουμε Ajax call και καλουμε το αρχειο submit_minutes.php το οποιο καταχωρει στην βαση για τον χρηστη username το time_out και τα λεπτα.
        xmlhttp.open("GET","submit_in_out/submit_minutes.php?username="+user+"&time_out="+time_out+"&minutes="+final_time,true);
        xmlhttp.send();     
        document.getElementById('blur_div').style.webkitFilter = "blur(3px)";
        document.getElementById('loader').style.visibility='visible';
        setTimeout(function(){ window.location.href=window.location.href;}, 1300);  
    }
        }
   
    //Οταν ο χρηστης πατησει το button Start Time καλειτε αυτη η συναρτηση, η οποια με Ajax call καλει το αντιστοιχο php arxeio 
    //και κανει μια καινουργια καταχωρηση στο table user_time της βασης.
    function submit_button_time_in(){
 
        var user = document.getElementById('username2').innerHTML;

        if (window.XMLHttpRequest) {
             xmlhttp = new XMLHttpRequest();
         } else {
             xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
         }
         xmlhttp.onreadystatechange = function() {
             if (this.readyState == 4 && this.status == 200) {
                 document.getElementById("hours_info").innerHTML = this.responseText;
             }
         };   
      
         xmlhttp.open("GET","submit_in_out/submit_button_time_in.php?username="+user,true);
         xmlhttp.send();   
        document.getElementById('blur_div').style.webkitFilter = "blur(3px)";
        document.getElementById('loader').style.visibility='visible';
        setTimeout( function(){ window.location.href=window.location.href;}, 1300);  
        }
   
    //Παιρνει ορισμα Ωρα και την επιστρεφει σε λεπτα
    function calculate_time_in_minutes(time){
        var result = time.split(":");
        
        return parseInt((parseInt(result[0])*60)+parseInt(result[1]));
     }
    //Στρογγυλοποιει τον χρονο εισοδου σε τεταρτα.
    function floor_time_in(time){
          var result = time.split(":");
          var minutes=parseInt(result[1]);
          var hours=parseInt(result[0]);
          
          if (minutes>0 && minutes<=15)
              minutes=15;
          else if (minutes>15 && minutes<=30)
              minutes=30;
          else if (minutes>30 && minutes<=45)
              minutes=45;
          else if (minutes>45 && minutes<=60){
              minutes=0;
              hours=hours+1;
         }
      return (hours+":"+minutes);
     }
    //Στρογγυλοποιει τον χρονο εξόδου σε τεταρτα.
    function floor_time_out(time){
        var result = time.split(":");
        var minutes=parseInt(result[1]);
        var hours=parseInt(result[0]);
        
        if (minutes>=0 && minutes<15)
          minutes=0;
        else if (minutes>=15 && minutes<30)
          minutes=15;
        else if (minutes>=30 && minutes<45)
          minutes=30;
        else if (minutes>=45 && minutes<60)
          minutes=45;
        
        return (hours+":"+minutes);
        
     }
     
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          

            /* $(document).on("click", "#cancel_button", function() {
                    var currentTD = $(this).parents('tr').find('td');
                                         
                              $.each(currentTD, function () {
                                  $(this).prop('contenteditable', false)
                              });        
              });
              $(document).on("click", ".edit_button", function() {

                        var $this = $(this);
                        var tds = $this.closest('tr').find('td').filter(function() {
                                return $(this).find('.editbtn').length === 0;
                        });
                     
                      //        $.each(currentTD, function () {
                       //           $(this).prop('contenteditable', true)
                      //        });
                        
                        if ($this.html() === 'edit') {
                                 var currentTD = $(this).parents('tr').css("background-color","yellow");       
                                $this.html('Save');
                                tds.prop('contenteditable', true);
                                   var id = $(this).parents('tr').find('#edit_Id');  
                                     id.prop('contenteditable', false);
                                   var id = $(this).parents('tr').find('#edit_date_finished');   
                                     id.prop('contenteditable', false);
                                   var id = $(this).parents('tr').find('#edit_delay');  
                                      id.prop('contenteditable', false);
                                    var department = $(this).parents('tr').find('#edit_department');
                                      department.append(  ".department"  );
                                      
                        } else {
                             var currentTD = $(this).parents('tr').css("background-color","blue");       
                                $this.html('edit');
                                tds.prop('contenteditable', false);
                                
                                var currentTD = $(this).parents('tr').find('td');
                                         
                                    $.each(currentTD, function () {
                                       // $(this).prop('contenteditable', true)
                             //           alert($(this).html());
                                    });
                                
                        }
                

               /*     var currentTD = $(this).parents('tr').find('td');
                                         
                              $.each(currentTD, function () {
                                  $(this).prop('contenteditable', true)
                              });
                          
                    var currentbtn = $(this).parents('tr').find('#edit_button');
                             currentbtn.html("<button>OK</button><button id='cancel_button'>Cancel</button>");
                             
                      var ipey8inos = $(this).parents('tr').find('#edit_ipey8inos');
                             ipey8inos.prop('contenteditable', false);
                         
                             
                    alert('Ja2');
                
              });
              */