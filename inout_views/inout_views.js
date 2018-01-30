/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function find_user_day_inouts(){
   
    var  date=document.getElementById('inout_day').value;
    if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("inouts_day").innerHTML = this.responseText;
            }
        };
       
        xmlhttp.open("GET","inout_views/inout_day_view.php?date="+date,true);
        xmlhttp.send();  
       
}

function find_user_day_minutes(){

    var user=document.getElementById('daily_user').value;
    var  date=document.getElementById('inout_day2').value;
    if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("inouts_day2").innerHTML = this.responseText;
            }
        };
       
        xmlhttp.open("GET","inout_views/inout_daily_minutes_view.php?date="+date+"&user="+user,true);
        xmlhttp.send();  
    
    
}

function show_projects_minutes(){
      $(function() {
        var target = $(this);
        $('#user_inout_view_dialog').dialog({
            resizable: true,
            modal: true,
            show: {effect: 'fade', duration: 400},
            hide: {effect: 'fade', duration: 100},
            width: 740,
            height: 300,
            position: {
               my: " bottom",
               at: " bottom",
               of: target
           }, 

        open: function() { $(function(){$('#inout_day').datepicker({title:'Test Dialog' ,dateFormat: 'yy-mm-dd'}).blur();}); },
            close : function(){ sum=0; }      
        });
    });
}


function show_users_inout(){
    $(function() {
        var target = $(this);
        $('#user_inout_view_dialog').dialog({
            resizable: true,
            modal: true,
            show: {effect: 'fade', duration: 400},
            hide: {effect: 'fade', duration: 100},
            width: 470,
            height: 1000,
            position: {
               my: " bottom",
               at: " bottom",
               of: target
           }, 

        open: function() { $(function(){$('#inout_day').datepicker({title:'Test Dialog' ,dateFormat: 'yy-mm-dd'}).blur();}); },
            close : function(){ sum=0; }      
        });
    });
}

function show_users_daily_minutes(){
    $(function() {
        var target = $(this);
        $('#user_daily_minutes_dialog').dialog({
            resizable: true,
            modal: true,
            show: {effect: 'fade', duration: 400},
            hide: {effect: 'fade', duration: 100},
            width: 710,
            height: 400,
            position: {
                my: " bottom",
                at: " bottom",
                of: target
            },        
        open: function() { $(function(){$('#inout_day2').datepicker({title:'Test Dialog' ,dateFormat: 'yy-mm-dd'}).blur();}); },
        close : function(){ sum=0; }      
            });
    });
}

function show_projects_minutes() {
    $(function () {
        var target = $(this);
        $('#project_minutes_dialog').dialog({
            resizable: true,
            modal: true,
            show: {effect: 'fade', duration: 400},
            hide: {effect: 'fade', duration: 100},
            width: 380,
            height: 400,
            position: {
                my: " bottom",
                at: " bottom",
                of: target
            },
            open: function () {},
            close: function () {sum = 0;}
        });
    });
}


function show_insert_task() {
    $(function () {
       
        $('#insert_form').dialog({
            resizable: true,
            modal: true,
            show: {effect: 'fade', duration: 400},
            hide: {effect: 'fade', duration: 100},
            width: 775,
            height: 660,
            position: {
                my: " center",
                at: " center"
            },
            open: function () {},
            close: function () {}
        });
		
    });

	 $('#btnClose').click(function (e) {
        e.preventDefault();
        $('#insert_form').dialog('close');
    });
}