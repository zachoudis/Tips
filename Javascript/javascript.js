    
    function showhide(id) {
        var e = document.getElementById(id);
        e.style.display = (e.style.display == 'block') ? 'none' : 'block';
     }

    function change(string) {        
            $(document).ready(function() {                       
              $("#user_filter2").val(string);                       
            });
       }

    function alert_link(){
             update_view(this.value);     
       } 
   
    function change_color_alert(name,noname){
          document.getElementById(name).style.color = "red";            
          document.getElementById(noname).style.visibility="hidden";
        }
  
    function change_color_alert2(name,noname){
          document.getElementById(name).style.visibility = "hidden";            
          document.getElementById(noname).style.visibility="";
        }

    function edituser(str) {  
        if (str == "") {
            document.getElementById("edit_form").innerHTML = "";
            return;
        }else{
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("edit_form").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET","edit_form.php?id="+str,true);
            xmlhttp.send();
        }
        document.getElementById('edit_form').style.display = "block";
     }
  
    function apply_grade(grade,id){
         if (grade == ""){
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
            xmlhttp.open("GET","apply_grade.php?&grade="+grade+"&id="+id,true);
            xmlhttp.send();  
        }  
    }
    
    function cancel_message(str,id){      
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
            $('#finished_tip').dialog({
                      resizable: false,
                      modal: true,
                      show: {effect: 'fade', duration: 400},
                      hide: {effect: 'fade', duration: 100},
                      width: 600,
                      height: 430,
                      position: {
                          my: "left bottom",
                          at: "left bottom",
                          of: $('#ttt')
                      }, 
                      open: function() { $(function(){$('#submitDate').datepicker({title:'Test Dialog' ,dateFormat: 'yy-mm-dd'}).blur();}); },
                      close : function(){ $(document).unbind('click');  window.location.href=window.location.href; }      
            });
        });
        
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
        if (check_date == true && check_comment == true && check_grade ){
                 change_state(str,id,comment,grade,submitDate);
                 flag=true;
         } 
         if (flag == true)
         {
             document.getElementById('loader').visibility=true;
             document.getElementById("maincontent").blur();
             document.getElementById("panel").blur();
             showhide('links');
             showhide('finished_tip');
             showhide('loader');
             $('#finished_tip').dialog('close');
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
            else if (document.getElementById('submitDate').value != '' && ((now-submitDate2)/86400000)>5){
                document.getElementById('submitDate').style.borderColor = "red";
                document.getElementById('warning').innerHTML =  " Μπορείτε Να Καταχωρήσετε Μέχρι 4 Μέρες Πρίν";
                document.getElementById('warning').style.color="red";
                return false;
            } 
            else{
                document.getElementById('submitDate').style.borderColor = "black";
                document.getElementById('warning').innerHTML =  " "; 
                return true;
            }
        }
        else
            return true;    
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
	//	window.location.reload();
    }
      
    function update_view_excel(str,max_pages,flag,sort_value) { 
            if (flag == 1)
                str=1;
      
            var e = document.getElementById("user_filter2");
            var value_user = e.options[e.selectedIndex].value;
            
            var e2 = document.getElementById("task_filter2");
            var value_filters = e2.options[e2.selectedIndex].value;
                  
            var e3 = document.getElementById("dep_filter2");
            var value_dep = e3.options[e3.selectedIndex].value;
            
            var e4 = document.getElementById("deadline_filter2");
            var value_deadline = e4.options[e4.selectedIndex].value;
            
            var e5 = document.getElementById("entolh_filter2");
            var value_entolh = e5.options[e5.selectedIndex].value;
            
            var e6 = document.getElementById("last_filters2");
            var value_last=e6.checked;
            
            var e7 = document.getElementById("project_filter2");
            var value_project=e7.options[e7.selectedIndex].value;
           
       
         //  var page=0;
         //  if (str != null && str != 'xxx')  {
         //     page=str;
          //    for (i=1;i<=max_pages;i++)
          //     document.getElementById(i).style.color='blue';
          //    document.getElementById(page).style.color='red';
      //  }
         //  else 
         //     page=1;
           // alert (page);
           // alert(page); 
            
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } 
        else {           
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                  
                    document.getElementById("txtHint2").innerHTML = this.responseText;
                }
            };   
             
              
            xmlhttp.open("GET","update_view_excel.php?str="+value_user+"&str2="+value_filters+"&str3="+value_dep+"&str4="+value_deadline+"&str5="+value_entolh+"&str6="+value_last+"&page="+str+"&str7="+value_project+"&str8="+sort_value,true);

            xmlhttp.send();          
        }
    }
  
    function update_view(str,max_pages,flag,sort_value) { 
        update_view_excel(str,max_pages,flag,sort_value)

        var page=0;
        if (flag == 1) str=1;
        if (str != null && str != 'xxx') page=str; else page=1;

        var e = document.getElementById("user_filter2");
        var value_user = e.options[e.selectedIndex].value;

        var e2 = document.getElementById("task_filter2");
        var value_filters = e2.options[e2.selectedIndex].value;

        var e3 = document.getElementById("dep_filter2");
        var value_dep = e3.options[e3.selectedIndex].value;

        var e4 = document.getElementById("deadline_filter2");
        var value_deadline = e4.options[e4.selectedIndex].value;

        var e5 = document.getElementById("entolh_filter2");
        var value_entolh = e5.options[e5.selectedIndex].value;

        var e6 = document.getElementById("last_filters2");
        var value_last=e6.checked;

        var e7 = document.getElementById("project_filter2");
        var value_project=e7.options[e7.selectedIndex].value;
           
  
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } 
        else {           
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
              
            xmlhttp.open("GET","update_view.php?str="+value_user+"&str2="+value_filters+"&str3="+value_dep+"&str4="+value_deadline+"&str5="+value_entolh+"&str6="+value_last+"&page="+page+"&str7="+value_project+"&str8="+sort_value,true);
            xmlhttp.send();          
        }
    }
       
    function checkbox_view(bool) {       
        if (bool == '1'){
            if (document.getElementById("check1"))
                document.getElementById("check2").checked=false;}
        else if (bool == '2'){
            if (document.getElementById("check2"))
                document.getElementById("check1").checked=false;}
        if (   document.getElementById("check2").checked==false &  document.getElementById("check1").checked==false)    
            window.location.href = window.location.href;
               
        if (bool == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } 
        else {           
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
         if (bool == 1)
            xmlhttp.open("GET","delay_view.php?str="+bool+"&state="+document.getElementById("check1").checked,true);
         else if (bool == 2)
            xmlhttp.open("GET","delay_view.php?str="+bool+"&state="+document.getElementById("check2").checked,true);
         xmlhttp.send();              
    }}
     
    function validateForm() {
        var x = document.forms["form_service"]["date_entry"].value;
        var y = document.forms["form_service"]["deadline"].value;
        if (y != ''){
            if (y < x){
               alert("Εχετε Δωσει Λαθος Ημερομηνια για Deadline");
                 document.getElementById('datepicker').style.color="red";
               document.getElementById('datepicker').style.borderColor = "red";
               return false;
               }
            else
                alert("Επιτυχής Καταχώρηση")
        }
        else
            alert("Επιτυχής Καταχώρηση")
            
            
    }
 
    function test2(sort_value,str,max_pages,flag){
           update_view('','6','1',sort_value);
        }
 
    function PDFFromHTML(name,startDate,endDate,state,name2){ 
        //Table to export in PDF
        var table = document.getElementById("projects2");
        //Current Date TODAY
        var now = new Date();
        var date=dateFormat(now, "d/m/yyyy");   
        //Metatroph tou startDate kai endDate se Date() format
        if (startDate != '')
            startDate = new Date(startDate.substring(6),parseInt(startDate.substring(3,5))-1,startDate.substring(0,2));
        if (endDate != '')
            endDate   = new Date(  endDate.substring(6),parseInt(  endDate.substring(3,5))-1,  endDate.substring(0,2));
        //Edw dhmiourgeite to string Pou emfanizei tiw hmeromhnies
        var dates;       
        if (startDate != '' && endDate != '')
            dates=' Από '+dateFormat(startDate, "d/m/yyyy") +' Έως '+dateFormat(endDate, "d/m/yyyy")+''
        else if (startDate !='' && endDate =='')
            dates=' Από '+dateFormat(startDate, "d/m/yyyy");
        else if (startDate == '' && endDate != '')
            dates=' Έως '+dateFormat(endDate, "d/m/yyyy");
        else if (startDate == '' && endDate == '')
            dates=' ';
        //Edw ftiaxnetai o pinakaa pou krataei to Table
        var numcells= table.rows[0].cells.length-1;
        var bdy = [];
        for(var x = 0; x <  table.rows.length; x++){
            bdy[x] = [];    
            for(var y = 0; y <numcells; y++){ 
                bdy[x][y] = x*y;    
            }
        }
        
   
        for (var y = 0; y < table.rows.length; y++){
            for (var x = 0; x <numcells; x++){
                //Edw einai h prwth grammh pou briskontai oi titloi tou Table
                if (y == 0)
                    if (x == 2 || x == 4 || x == 6 || x == 8 )
                        bdy[y][x] ={ text: table.rows[y].cells[x].innerHTML, bold: true,fontSize : 8 , fillColor: '#b3b3b3' }
                     else
                        bdy[y][x] ={ text: table.rows[y].cells[x].innerHTML, bold: true,fontSize : 10, fillColor: '#b3b3b3' }
                //Edw einai to data tou Table
                else{
                    //Default an to export den exei dates
                    if (startDate == '' && endDate == ''){
                        if (x == 7)
                           bdy[y][x] ={ text: table.rows[y].cells[x].innerHTML,fontSize : 7 }
                        else if (x == 11)
                           bdy[y][x] ={ text: table.rows[y].cells[x].innerHTML,fontSize : 6 }
                        else
                           bdy[y][x] ={ text: table.rows[y].cells[x].innerHTML,fontSize : 8 }  
                    }
                    //An yparxei startDate
                    else if (endDate == '' && startDate != ''){
                        var date2_string=table.rows[y].cells[2].innerHTML;
                        var date2=new Date(date2_string.substring(6),parseInt(date2_string.substring(3,5))-1,date2_string.substring(0,2));
                        if (date2 >= startDate ){
                            if (x == 7)
                                bdy[y][x] ={ text: table.rows[y].cells[x].innerHTML,fontSize : 7 }
                            else if (x == 11)
                                bdy[y][x] ={ text: table.rows[y].cells[x].innerHTML,fontSize : 6 }
                            else
                                bdy[y][x] ={ text: table.rows[y].cells[x].innerHTML,fontSize : 8 }  
                        }  
                    }
                    //An yparxei endDATE
                    else if (startDate == '' && endDate != ''){ 
                        var date2_string=table.rows[y].cells[2].innerHTML;
                        var date2=new Date(date2_string.substring(6),parseInt(date2_string.substring(3,5))-1,date2_string.substring(0,2));
                        if (date2 <= endDate ){
                            if (x == 7)
                              // bdy[y][x] ={ text:" String Date"+date2_string+" After String Date"+date2+" After Date 2"+date21,fontSize : 8 }
                                bdy[y][x] ={ text: table.rows[y].cells[x].innerHTML,fontSize : 7 }
                            else if (x == 11)
                                bdy[y][x] ={ text: table.rows[y].cells[x].innerHTML,fontSize : 6 }
                            else
                                bdy[y][x] ={ text: table.rows[y].cells[x].innerHTML,fontSize : 8 }      
                        }
                    }
                    //An yparxei StartDate kai EndDate
                    else if (startDate != '' && endDate != ''){
                        var date2_string=table.rows[y].cells[2].innerHTML;
                        var date2=new Date(date2_string.substring(6),parseInt(date2_string.substring(3,5))-1,date2_string.substring(0,2));
               //         bdy[y][x] ={ text:" String Date"+date2_string+" After String Date"+date2+" StartDate"+startDate+" EndDate "+endDate,fontSize : 8 }
                        if (date2 >= startDate && date2 <= endDate ){
                            if (x == 7)
                                bdy[y][x] ={ text: table.rows[y].cells[x].innerHTML,fontSize : 7 }
                            else if (x == 11)
                                bdy[y][x] ={ text: table.rows[y].cells[x].innerHTML,fontSize : 6 }
                            else
                                bdy[y][x] ={ text: table.rows[y].cells[x].innerHTML,fontSize : 8 }      
                        }
            }}}}
        
        //Diagrafei tis kenes seires sto Array
        var counter=0;
        while (counter<=bdy.length-1){
            if (bdy[counter][0]==''){
                bdy.splice(counter,1);
                counter=1;
            }
            else 
                counter++;
        }
        
        var task_count={ text: 'Σύνολικός Αριθμός Tips : '+(bdy.length-1),fontSize :8 }    ;

        //Morfopoihsh tou pdf
        var docDefinition = { 
        pageSize: 'A4',
        pageOrientation: 'landscape',
        pageMargins: [ 4, 6, 4, 6 ],
        content: [
            'TIP YETOS '  + name2,
            'Date : ' + date,
            state,
            dates,
            task_count,
            { table: {                        
                        headerRows: 1,
                        widths: [21 ,'auto',46,45,50,'auto',38,'auto',25,'auto',35,'auto' ],
                        body: bdy ,  
            }},
            '      ',  '      ',  '      ', 
            { text: '     Υπογραφή                                                                                                                                                                                             Υπογραφή                                                                                                                                                                         Υπογραφή', style: 'header'  },
            '      ','      ',
            { text:'Υπεύθυνος Ενέργειας                                                                                                                                                              Υπευθυνος Τμήματος                                                                                                                                                              Διεύθυνση', style: 'header'  },
        ],
        styles: {
         header: {
          fontSize: 8,
          bold: true
         },}
        };   
    
        //Εξαγωγη του Pdf
     pdfMake.createPdf(docDefinition).download('Jah.pdf');
   
    }

    function stringToDate(_date,_format,_delimiter){
        var formatLowerCase=_format.toLowerCase();
        var formatItems=formatLowerCase.split(_delimiter);
        var dateItems=_date.split(_delimiter);
        var monthIndex=formatItems.indexOf("mm");
        var dayIndex=formatItems.indexOf("dd");
        var yearIndex=formatItems.indexOf("yyyy");
        var month=parseInt(dateItems[monthIndex]);
        month-=1;
        var formatedDate = new Date(dateItems[yearIndex],month,dateItems[dayIndex]);
        return formatedDate;
    }
    
    function test(table_name,name,state,startDate,endDate,name2){ 
       //fnExcelReport(table_name,name,state,startDate,endDate)
       PDFFromHTML(name,startDate,endDate,state,name2);
    }
    
    function close_function(form){ 
        document.getElementById(form).style.visibility='hidden';
        window.location.href = window.location.href;
     }
     
    function change_arrow(element,field){
        if(document.getElementById(element).innerHTML == "↑") field2=field+" ASC"; else field2=field+" DESC";
        update_view('','6','1',field2);
    }
 
    var dateFormat = function () {
            var	token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,
                    timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
                    timezoneClip = /[^-+\dA-Z]/g,
                    pad = function (val, len) {
                            val = String(val);
                            len = len || 2;
                            while (val.length < len) val = "0" + val;
                            return val;
                    };

            // Regexes and supporting functions are cached through closure
            return function (date, mask, utc) {
                    var dF = dateFormat;

                    // You can't provide utc if you skip other args (use the "UTC:" mask prefix)
                    if (arguments.length == 1 && Object.prototype.toString.call(date) == "[object String]" && !/\d/.test(date)) {
                            mask = date;
                            date = undefined;
                    }

                    // Passing date through Date applies Date.parse, if necessary
                    date = date ? new Date(date) : new Date;
                    if (isNaN(date)) throw SyntaxError("invalid date");

                    mask = String(dF.masks[mask] || mask || dF.masks["default"]);

                    // Allow setting the utc argument via the mask
                    if (mask.slice(0, 4) == "UTC:") {
                            mask = mask.slice(4);
                            utc = true;
                    }

                    var	_ = utc ? "getUTC" : "get",
                            d = date[_ + "Date"](),
                            D = date[_ + "Day"](),
                            m = date[_ + "Month"](),
                            y = date[_ + "FullYear"](),
                            H = date[_ + "Hours"](),
                            M = date[_ + "Minutes"](),
                            s = date[_ + "Seconds"](),
                            L = date[_ + "Milliseconds"](),
                            o = utc ? 0 : date.getTimezoneOffset(),
                            flags = {
                                    d:    d,
                                    dd:   pad(d),
                                    ddd:  dF.i18n.dayNames[D],
                                    dddd: dF.i18n.dayNames[D + 7],
                                    m:    m + 1,
                                    mm:   pad(m + 1),
                                    mmm:  dF.i18n.monthNames[m],
                                    mmmm: dF.i18n.monthNames[m + 12],
                                    yy:   String(y).slice(2),
                                    yyyy: y,
                                    h:    H % 12 || 12,
                                    hh:   pad(H % 12 || 12),
                                    H:    H,
                                    HH:   pad(H),
                                    M:    M,
                                    MM:   pad(M),
                                    s:    s,
                                    ss:   pad(s),
                                    l:    pad(L, 3),
                                    L:    pad(L > 99 ? Math.round(L / 10) : L),
                                    t:    H < 12 ? "a"  : "p",
                                    tt:   H < 12 ? "am" : "pm",
                                    T:    H < 12 ? "A"  : "P",
                                    TT:   H < 12 ? "AM" : "PM",
                                    Z:    utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
                                    o:    (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
                                    S:    ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
                            };

                    return mask.replace(token, function ($0) {
                            return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
                    });
            };
    }();
    // Some common format strings
    dateFormat.masks = {
            "default":      "ddd mmm dd yyyy HH:MM:ss",
            shortDate:      "m/d/yy",
            mediumDate:     "mmm d, yyyy",
            longDate:       "mmmm d, yyyy",
            fullDate:       "dddd, mmmm d, yyyy",
            shortTime:      "h:MM TT",
            mediumTime:     "h:MM:ss TT",
            longTime:       "h:MM:ss TT Z",
            isoDate:        "yyyy-mm-dd",
            isoTime:        "HH:MM:ss",
            isoDateTime:    "yyyy-mm-dd'T'HH:MM:ss",
            isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
    };
    // Internationalization strings
    dateFormat.i18n = {
            dayNames: [
                    "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat",
                    "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
            ],
            monthNames: [
                    "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
                    "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
            ]
    };
    // For convenience...
    Date.prototype.format = function (mask, utc) {
            return dateFormat(this, mask, utc);
    };
    
    


 
/*
  function fnExcelReport(table_name,name,state,startDate,endDate,name2){
        
        var tab_text=         " <div id='panel' class='panel'>"
        var tab_text=tab_text+"    <h1>T.i.P. ΥΕΤΟΣ </h1> ";
        var tab_text=tab_text+"    <h1>" + name2 + "</h1> ";
   
        //Prints the Current date to Excel
        var now = new Date();
        var tab_text=tab_text+"    <h1> " +  dateFormat(now, "d/m/yyyy") + "</h1> ";   

        //An exoun dw8ei dateStart kai dateEnd arxikopoiountai
        if (startDate != '')
            startDate = stringToDate(startDate,"dd/MM/yyyy","/");
        if (endDate != '')
            endDate   = stringToDate(endDate,"dd/MM/yyyy","/");


        //Prints the state of the Tasks
        if (state == 'Pending')
            tab_text=tab_text+"<h2  style='color:orange'>"+state+" Tasks</h2>";
        else if (state == 'Finished')
            tab_text=tab_text+"<h2  style='color:green'>"+state+" Tasks</h2>";
        else if (state == 'Cancelled')
            tab_text=tab_text+"<h2  style='color:red'>"+state+" Tasks</h2>";
            
        if (startDate != '' && endDate != '')
            tab_text=tab_text+'<h3> Από '+dateFormat(startDate, "d/m/yyyy") +'<br> Έως '+dateFormat(endDate, "d/m/yyyy")+'</h3>'
        else if (startDate !='' && endDate =='')
            tab_text=tab_text+'<h3> Από '+dateFormat(startDate, "d/m/yyyy");
        else if (startDate == '' && endDate != '')
            tab_text=tab_text+'<h3> Έως '+dateFormat(endDate, "d/m/yyyy");
        
        var tab_text=tab_text+" </div>";
               
        tab_text =tab_text + "<table border='1px' style='font-size:20px' >";
        var j = 0;
        var tab = document.getElementById(table_name); // id of table
        var lines = tab.rows.length;
       
        // the first headline of the table
        if (lines > 0) {
            tab.rows[0].deleteCell(14);
            tab.rows[0].deleteCell(13);
            tab_text = tab_text + "<tr bgcolor='#DFDFDF'>" + tab.rows[0].innerHTML + '</tr>';
        }
        // table data lines, loop starting from 1
        for (j = 1 ; j < lines; j++) {     
           tab.rows[j].deleteCell(14);
           tab.rows[j].deleteCell(13);
           
           
            //Edw emfanizontai ola ta records.Den exei do8ei startDate kai endDate
            if (startDate == '' && endDate == ''){
                    tab.rows[j].cells[1].innerHTML=dateFormat(stringToDate(tab.rows[j].cells[2].innerHTML,"dd/MM/yyyy","/"),"d/m/yyyy");
                    tab_text = tab_text + "<tr bgcolor='#CDE8F6'>" + tab.rows[j].innerHTML + "</tr>";   }
            //Edw yparxei startDatew kai endDate
            else if (startDate != '' && endDate!= ''){
                var date=stringToDate(tab.rows[j].cells[2].innerHTML,"dd/MM/yyyy","/");
              
                 if (date >= startDate && date <= endDate )
                    tab_text = tab_text + "<tr bgcolor='#CDE8F6'>" + tab.rows[j].innerHTML + "</tr>";    
            }
            
            else if (startDate == '' && endDate != ''){
                var date=stringToDate(tab.rows[j].cells[2].innerHTML,"dd/MM/yyyy","/");
                if (date <= endDate )
                    tab_text = tab_text + "<tr bgcolor='#CDE8F6'>" + tab.rows[j].innerHTML + "</tr>";    
            }
            else if (endDate == '' && startDate != ''){
                var date=stringToDate(tab.rows[j].cells[2].innerHTML,"dd/MM/yyyy","/");
                if (date >= startDate )
                    tab_text = tab_text + "<tr bgcolor='#CDE8F6'>" + tab.rows[j].innerHTML + "</tr>";    
            }
        }

        tab_text = tab_text + "</table>";			
        tab_text =tab_text + "<table style='font-size:20px' ><tr ><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></table>";
        tab_text =tab_text + "<table style='font-size:20px' ><tr ><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></table>";
        tab_text =tab_text + "<table style='font-size:20px' ><tr ><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></table>";
        tab_text =tab_text + "<table style='font-size:20px' ><tr ><td></td><td><h3>Υπεύθυνος Ενέργειας</h3></td><td></td><td></td><td></td><td><h3>Υπεύθυνος Τμήματος</h3></td><td></td><td></td><td></td><td> </td><td><h3>Διεύθυνση</h3></td></tr></table>";
        tab_text =tab_text + "<table style='font-size:20px' ><tr ><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></table>";
        tab_text =tab_text + "<table style='font-size:20px' ><tr ><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></table>";
        tab_text =tab_text +"<table style='font-size:20px' ><tr ><td></td><td><h5>Υπογραφή</h5></td><td></td><td></td><td></td><td><h5>Υπογραφή</h5></td><td></td><td></td><td></td><td> </td><td><h5>Υπογραφή</h5></td></tr></table>";
                 
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  
   
        window.location.href = window.location.href;
  
    }   
    */