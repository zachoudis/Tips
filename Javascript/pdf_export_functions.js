    //Καλειτε οταν πατηθει το εικονιδιο για εξαγωγη αρχειο σε Pdf   
    //Παιρνει το DIV με id=pdfExport απο το αρχειο Dialog_boxes.php  
    //Και ανοιγει αυτο το dialog box.
    function export_pdf(){
        $(function() {    
            $('#pdfExport').dialog({
                resizable: false,
                modal: true,
                width: 300,
                show: {effect: 'fade', duration: 400},
                hide: {effect: 'fade', duration: 400},
                position: {
                    my: "right center",
                    at: "right top",
                    of: $('#export_panel')
                },
                open: function() {                                
                    $('#startDate').datepicker({title:'Test Dialog' ,dateFormat: 'dd/mm/yy'}).blur();
                    $('#endDate').datepicker({title:'Test Dialog',dateFormat: 'dd/mm/yy'}).blur();   
                },
                close: function() {
                    $('#startDate').datepicker('destroy');
                    $('#endDate').datepicker('destroy');
                },
            });
       });
     }
    
    //Aυτη η συναρτηση μετατρεπει ενα HTML αντικειμενο. Δηλαδη το Table με τα TIPS σε excel αρχειο
    function PDFFromHTML(name,state,startDate,endDate,name2){ 
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
                        
                        var date4_string=table.rows[y].cells[4].innerHTML;
                        var date4=new Date(date4_string.substring(6),parseInt(date4_string.substring(3,5))-1,date4_string.substring(0,2));
                        var state=check_state(date4_string);
                                
                        if (state == "Finished")
                            date2=date4;
                        
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
                        
                        var date4_string=table.rows[y].cells[4].innerHTML;
                        var date4=new Date(date4_string.substring(6),parseInt(date4_string.substring(3,5))-1,date4_string.substring(0,2));
                        var state=check_state(date4_string);
                                
                        if (state == "Finished")
                            date2=date4;
                        
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
                        
                        var date4_string=table.rows[y].cells[4].innerHTML;
                        var date4=new Date(date4_string.substring(6),parseInt(date4_string.substring(3,5))-1,date4_string.substring(0,2)); 
                        var state=check_state(date4_string);
                                
                                
                       if (state == "Finished")
                            date2=date4;
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

    function check_state(date4_string){
        if (date4_string == '')
            return "Pending";
        else
            return "Finished";
    }
     
    //Συναρτηση που μετατρεπει μια ημερομηνια που ειναι σε μορφη string σε μορφη DATE
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
    
   