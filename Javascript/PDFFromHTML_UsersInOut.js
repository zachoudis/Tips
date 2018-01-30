function PDFFromHTML_UsersInOut(){ 

        //Table to export in PDF
        var table = document.getElementById("tbl_usersInOut");
		
		 //Current Date TODAY
        var now = new Date();
        var date=dateFormat(now, "d/m/yyyy");
        
        //Edw ftiaxnetai o pinakaa pou krataei to Table
        var numcells= table.rows[0].cells.length;
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
					bdy[y][x] ={ text: table.rows[y].cells[x].innerText, bold: true,fontSize : 12 , fillColor: '#b3b3b3' }  
                //Edw einai to data tou Table
                else{
                    bdy[y][x] ={ text: table.rows[y].cells[x].innerText,fontSize : 9 }
             
          
               }}}
        
        
        
     //   var task_count={ text: 'Σύνολικός Αριθμός Tips : '+(bdy.length-1),fontSize :8 }    ;

        //Morfopoihsh tou pdf
        var docDefinition = { 
        pageSize: 'A4',
        pageOrientation: 'portait',
        pageMargins: [ 20, 15, 15, 15 ],
        content: [
            'TIP YETOS - In/Out Users',
			'Date : ' + date,
			'  ',
			{ table: {                        
                        headerRows: 1,
                        widths: ['auto','auto','auto','auto'],
                        body: bdy ,  
            }},
        ],
		
      
        };   
    
        //Εξαγωγη του Pdf
     pdfMake.createPdf(docDefinition).download('testpdf.pdf');

   
    }

    
     
   
 
 
  // ();
   
  
  
    
       
   
    


    
   
  
  
 
  
   