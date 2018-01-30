
    function showhide(id) {
        var e = document.getElementById(id);
        e.style.display = (e.style.display == 'block') ? 'none' : 'block';
     }
    function change(string) {        
        $(document).ready(function() {                       
            $("#user_filter2").val(string);                       
        });
    }

    //Αυτες οι 2 συναρτησεις κανονιζουν τα χρωματα στα alerts που υπαρχουν και σχετιζονται με την καθυστερηση παραδοσης των TIPS
    function change_color_alert(name,noname){
        document.getElementById(name).style.color = "red";            
        document.getElementById(noname).style.visibility="hidden";
    }
    function change_color_alert2(name,noname){
        document.getElementById(name).style.visibility = "hidden";            
        document.getElementById(noname).style.visibility="";
    }

    //Ειναι η συναρτηση που καλειτε οταν πατηθει το κουμπι Edit. Στην συνεχεια η συναρτηση αυτη τρεχει το αρχειο edit_form.php
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
   //Ειναι η συναρτηση που καλειτε πρεπει να ανανεωθει το βασικο table που περιεχει τα TIPS. Στην συνεχεια η συναρτηση αυτη τρεχει το αρχειο update_view_excel.php
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
   //Ειναι η συναρτηση που καλειτε πρεπει να ανανεωθει το βασικο table που περιεχει τα TIPS. Στην συνεχεια η συναρτηση αυτη τρεχει το αρχειο update_view.php
    function update_view(str,max_pages,flag,sort_value){ 
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
    
    function change_arrow(element,field){
        if(document.getElementById(element).innerHTML == "↑") field2=field+" ASC"; else field2=field+" DESC";
        update_view('','6','1',field2);
    }
    //Στο edit kai insert Tip ελεγχει αν το deadline ειναι σωστα καταχωρημενο. Δηλαδη δεν ειναι μικροτερο απο την ημερομηνια αναθεσης
    function validateInsertTipForm() {
        var x = document.forms["form_service"]["date_entry"].value;
        var y = document.forms["form_service"]["deadline"].value;
       
        var x_date = stringToDate(x,"dd/MM/yyyy","/");
        var y_date = stringToDate(y,"dd/MM/yyyy","/");
            
        if (y != ''){   
            if (y_date<x_date){
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
    //Converts string Time to DateTime format
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