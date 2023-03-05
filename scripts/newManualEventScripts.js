function runaddCells() {

    //this function is needed to start the addCells function at level 0.
    level=0;

    //run function to add manual buttons to the sheet.  The argument is the local storage array containing the Profile / Use Codes (LPU).   the function is then run recursively until the user has created a complete Event record.
    addCells(LPU);
}

function cncladdCells(){

    level = null;
    arraySearchValue = null;
    var ckey;
    
    $("#eventBtnListContainer").empty();
    
}

function addCells(arr){

    //determines if the post functions used later should be active
    const selPost = $("#selPost").val();
    console.log("selPost="+selPost);

    //empty div that contains dynamic buttons
    $("#eventBtnListContainer").empty();

    //get value from pu: indicates if a prior event is being updated
    const updateIndicator = $("#pu").val();
    console.log("updateIndicator="+updateIndicator);

    //get the size of the first col of the array passed as an argument
    const arrayLength = arr[0].length;
    console.log("arrayLength="+arrayLength);

    //get the number of cols in the array passed as an argument
    var arrayColumnCount = arr.length;
    console.log("arrayColumnCount="+arrayColumnCount);

    //create an empty array to place contents of array passed to formula
    var narr=[];

    //loop from 0 to the number of cols above
    for(j = 0; j < arrayColumnCount; j++){

        //add empty col to the empty array
        narr.push([]);

    }

    //checks if the value of the level variable is a value other than 0.  if it is, this block is executed
    if(level!=0){
        
        //#ROW LOOP: loops from 0 to the size of the first col of the array (value of L)
        for(i = 0; i < arrayLength; i++){
    
            //checks if the arraySearchValue variable is included in each element of the 3rd col of the array passed to the function.  The arraySearchValue variable was set when a button was selected during the previous stage of creating the event record.
            if(arr[2][i].includes(arraySearchValue)==true){
        
                //#COL LOOP: loops from 0 to the number of cols in the array
                for(j = 0; j < arrayColumnCount; j++){

                    //Adds the value in each cell, COL j / ROW i, to the new array
                    var p = arr[j][i];
            
                    narr[j].push(p);
		}
            } 
        }
    
    //end level if
    }else{
        
        //if no level is provided, new array is set to the array passed to the function
        narr=arr;

    }

    console.log("narr="+narr);

    //selects the event table
    const eventBtnListContainer = document.getElementById("eventBtnListContainer");

    //gets the length of the new array
    const L = narr[0].length;
    console.log("L="+L);

    //sets button counters to 0
    let bcnt = 0;

    for(i = 0; i < L; i++){
        //create list item element 
        let eventBtnContainer = document.createElement("li");

        //sets a variable to the 2nd element in the provided array for the index
        let eventBtnText = narr[1][i];
        console.log(eventBtnText);

        //sets a variable to the 1st element in the provided array for the index
        let eventBtnValue = narr[0][i];

        //sets a variable to the total number of buttons on the page
        let pageBtnCount = $( "button" ).length;

        //uses the number of buttons to create a new button id
        let eventBtnId = "btn"+pageBtnCount;

        //creates a new button element
        let eventBtn = document.createElement("button");

        //assigns the id created above to the new button 
        eventBtn.id = eventBtnId;

        //creates a text node based on the second element in the supplied array
        let eventBtnTextNode = document.createTextNode(eventBtnText);

        //adds the text node to the new button
        eventBtn.appendChild(eventBtnTextNode);

        //adds a value to the button based on the first element of the array
        eventBtn.value = eventBtnValue;

        //appends the button to the newly created container 
        eventBtnContainer.appendChild(eventBtn);

        //appends the event button container to the event button container list
        eventBtnListContainer.appendChild(eventBtnContainer);
        
        //adds a function to the button 
        document.getElementById(eventBtnId). addEventListener("click", function(){

            //create a variable to hold the value of the active button
            let activeBtnValue = this.value;
            
            //create a variable to hold the text content of the active button
            var activeBtnText = this.innerHTML;

            //clear the current contents of the event button list container
            $("#etbl").empty();

                //determine the current stage of creating the event record
                switch(level){
                
                //if the level is 0, it means that the event button list container currently contains buttons that correspond to use codes (LPU)
                case 0:
                    
                    //sets the arraySearchValue variable to the value of the active button. when the function runs again, this value will be used to filter the items in next stage of creating the event record to only show those that correspond to the value selected during this stage.
                    arraySearchValue = activeBtnValue;

                    //sets the arraySearchValuePUCode variable to the value of the active button.  This value will be needed later on to filter the activities list to show only activities associated with this PU code.
                    arraySearchValuePUCode = activeBtnValue;

                    //increments the level of the form indicating that a PU code has been selected
                    level++;

                    //runs the function again and passes the locally stored list of projects as the argument.  This will fill the button list container with a set of buttons that corresponds to all projects that are associated with the PU code that was selected.
                    addCells(LProj);

                    break;

                case 1:

                    //sets arraySearchValue to the value fo the active button to filter the records at the next level
                    arraySearchValue=activeBtnValue;
                    
                    level++;
                    
                    //runs the function again and passes the locally stored list of subactivities as the argument.
                    addCells(LConts);
                    
                    break;

                case 2:
                    
                    $("#spsel").text(activeBtnValue);
                    
                    //sets the arraySearchValue to the PU Code that was selected previously to filter the activities, since they cannot be filtered by subactivities [yet]
                    arraySearchValue = arraySearchValuePUCode;

                    level++;

                    //runs the function again and passes the locally stored list of activities as the argument.
                    addCells(LActs);
                    
                    break;

                case 3:

                    //$("#asel").text(activeBtnValue);

                    const contValue = $("#spsel").text();

                    //sets the activity to the value selected.
                    const actValue = activeBtnValue;
                    
                    //sets the activity name to the value selected.
                    const activityName = activeBtnText;

                    //sets level back to 0 for the next time the function is called.
                    level=0;

                    //empties the event button list container
                    $("#eventBtnListContainer").empty();

                    //sets the event time based on whether or not the event is currently happening or is a past event.
                    setETime();

                    //if the event is a new event and not updating a previously created event
                    if(updateIndicator!="U"){

                        LEvents.push([datetimeValue, actValue, contValue, activityName, 'N', datetimeText, millisecTime]);
                        
                        if(selPost==="Y"){
                        
                            JQPost(actValue, contValue, datetimeValue);
                        
                        }
                        
                        resetAll();

                    }else{

                        LEvents[eid]=([etmv, actValue, contValue, activityName, 'N', etmt, eft]);
                        
                            if(selPost==="Y"){

                                var etmv1 = sqTime(etmv);

                                JQUpdate(actValue, contValue, etmv1);

                            }
                        
                        resetAll();

                    }

                    $("#pmEvent").empty();
        
                    $("#pu").text("");
        
                    $("#pu").val("");

                    resetAll();
                    
                    break;
            }
        });
    }
}