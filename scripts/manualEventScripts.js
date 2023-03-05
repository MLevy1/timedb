function runaddCells() {

    //set LV ??? to 0
    LV=0;

    //run emptyps ???
    emptyps();

    //run function to add manual buttons to the sheet (argument ???)
    addCells(LPU);	
}

function cncladdCells(){

    LV=null;
    key=null;
    var ckey;
    
    $("#etbl").empty();
    
    emptyps();
}

function addCells(arr){

    //determines if the post functions used later should be active [OUT OF PLACE]
    var selPost = $("#selPost").val();

    //empty div that contains dynamic buttons
    $("#etbl").empty();

    //get value from pu: indicates if the  entry will be past event
    var U = $("#pu").val();

    //get the size of the first col of the array passed as an argument
    var L = arr[0].length;

    //get the number of cols in the array passed as an argument
    var aSize = arr.length;

    //create an empty array to place contents of array passed to formula
    var narr=[];

    //loop from 0 to the number of cols above
    for(j = 0; j < aSize; j++){

        //add empty col to the empty array
        narr.push([]);

    }

    //checks if the value of the LV variable is a value other than 0.  if it is, this block is executed
    if(LV!=0){
        
        //#ROW LOOP: loops from 0 to the size of the first col of the array (value of L)
        for(i = 0; i < L; i++){
    
            //checks if the key variable ??? is included in each element of the 3rd col of the array passed to the function
            if(arr[2][i].includes(key)==true){
        
                //#COL LOOP: loops from 0 to the number of cols in the array
                for(j = 0; j < aSize; j++){

                    //Adds the value in each cell, COL j / ROW i, to the new array
                    var p = arr[j][i];
            
                    narr[j].push(p);
                    
                    //end COL LOOP
                    }

            //end if
            } 

        //end ROW LOOP
        }
    
    //end LV if
    }else{
        
        //if no LV is provided, new array is set to the array passed to the function
        narr=arr;

    //end ELSE
    }

    //selects the event table
    var table = document.getElementById("etbl");

    //gets the length of the new array
    var L = narr[0].length;

    //sets the number of buttons
    var rbtns = 6;

    //determines the number of rows that will be needed 
    var rnum = Math.floor(L/rbtns);

    //determines the numbers of buttons in the last row
    var lrbtns = (L%rbtns);

    //sets button counters to 0
    var bcnt = 0;

    //block executed when more than 1 row is needed
    if(rnum>0){

    //block executed for each row needed [r represents the index of the row]
        for (r = 0; r < rnum; r++) {

    //adds a row to the table [currently hard-coded as "etbl" above]
            var row = table.insertRow(r);

    //block executed for each button in each row
            for (c = 0; c < rbtns; c++){

                //sets a variable to the current button count by multiplying the row index [r] by the number of buttons in each row [rbtns] and adding the position in the current row [c]
                var bcnt = (r*rbtns)+c;

                //sets a variable to the 2nd element in the provided array for the index
                var bt = narr[1][bcnt];

                //sets a variable to the 1st element in the provided array for the index
                var bv = narr[0][bcnt];

                //inserts a cell to the current row
                var cell = row.insertCell(c);

                //sets a variable to the total number of buttons on the page
                var bc = $( "button" ).length;

                //uses the number of buttons to create a new button id
                var btnid = "btn"+bc;

                //creates a new button element
                var btn = document.createElement("BUTTON");

                //assigns the id created above to the new button 
                btn.id = btnid;

                //creates a text node based on the second element in the supplied array
                var t = document.createTextNode(bt);

                //adds the text node to the new button
                btn.appendChild(t);

                //adds a value to the button based on the first element of the array
                btn.value = bv;

                //appends the button to the newly created cell
                cell.appendChild(btn);
                
                //adds a function to the button 
                document.getElementById(btnid). addEventListener("click", function(){

                    var cs = this.value;

                    var cv = this.innerHTML;

                    $("#etbl").empty();

                    switch(LV){

                        case 0:

                            $("#csel").text(cs);

                            key=cs;

                            ckey=cs;

                            LV++;

                            addCells(LProj);

                            break;

                        case 1:

                            $("#psel").text(cs);

                            key=cs;

                            LV++;

                            addCells(LConts);

                            break;

                        case 2:

                            $("#spsel").text(cs)

                            key=ckey;

                            LV++;

                            addCells(LActs);

                            break;

                        case 3:

                            $("#asel").text(cs);

                            var cont = $("#spsel").text();

                            var act = cs;

                            var a2 = cv;

                            LV=0;

                            $("#etbl").empty();

                            setETime();

                            if(U!="U"){

                                LEvents.push([datetimeValue, act, cont, a2, 'N', datetimeText, millisecTime]);
                                
                                if(selPost==="Y"){
                                
                                JQPost(act, cont, datetimeValue);
                                
                                }
                                
                                resetAll();

                            }else{

                                LEvents[eid]=([etmv, act, cont, a2, 'N', etmt, eft]);
                                
                                        if(selPost==="Y"){
            
                                            var etmv1 = sqTime(etmv);
        
                                            JQUpdate(act, cont, etmv1);
            
                                        }
                                
                                resetAll();

                            }

                            $("#pmEvent").empty();
                
                            $("#pu").text("");
                
                            $("#pu").val("");

                            emptyps();

                            resetAll();
                            
                            break;
                    }
                });
            }
        }
    }
    
    //LAST ROW
    
    if(lrbtns>0){
    
        if(rnum==0){
    
            lrbtns--;
    
        }

        var row = table.insertRow();

        for (c = 0; c <= lrbtns; c++){

            var lbcnt = bcnt+c;

            var bt = narr[1][lbcnt];

            var bv = narr[0][lbcnt];

            var cell= row.insertCell(c);

            var bc = $( "button" ).length;

            var btnid = "btn"+bc;

            var btn = document.createElement("BUTTON");

            btn.id = btnid;

            var t = document.createTextNode(bt);

            btn.appendChild(t);

            btn.value = bv;

            cell.appendChild(btn);
            document.getElementById(btnid). addEventListener("click", function(){

                var cs = this.value;

                var cv = this.innerHTML;

                $("#etbl").empty();

                switch(LV){

                    case 0:

                        $("#csel").text(cs);

                        key=cs;

                        ckey=cs;

                        LV++;

                        addCells(LProj);

                        break;

                    case 1:

                        $("#psel").text(cs);

                        key=cs;

                        LV++;

                        addCells(LConts);

                        break;

                    case 2:

                        $("#spsel").text(cs)

                        key=ckey;

                        LV++;

                        addCells(LActs);

                        break;

                    case 3:

                        $("#asel").text(cs);

                        var cont = $("#spsel").text();

                        var act = cs;

                        var a2 = cv;

                        LV=0;

                        $("#etbl").empty();

                        setETime();

                        if(U!="U"){

                            LEvents.push([datetimeValue, act, cont, a2, 'N', datetimeText, millisecTime]);
                            
                            if(selPost==="Y"){
                            
                            JQPost(act, cont, datetimeValue);

                            }

                        }else{

                            LEvents[eid]=([etmv, act, cont, a2, 'N', etmt, eft]);

        if(selPost==="Y"){
            
            var etmv1 = sqTime(etmv);
        
            JQUpdate(act, cont, etmv1);
            
        }

        $("#pmEvent").empty();

        $("#pu").text("");

        $("#pu").val("");

                        }

                        emptyps();
                        
                        resetAll();

                        break;

                }

            });
        }

    }
}

function emptyps(){

    $("#csel").empty();
    $("#psel").empty();
    $("#spsel").empty();
    $("#asel").empty();
}