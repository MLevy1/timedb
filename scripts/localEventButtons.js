function localEventButton(act, cont, btnName, list, warn){
				
    let arrElapsedTime = findLast(act, cont);
    
    let elapsedTime = arrElapsedTime[0];

    let warnTime = arrElapsedTime[1];
    
    var bc = $( "button" ).length;
    
    var btnid = "btn"+bc;
    
    let btn = document.createElement("button");

    btn.id = btnid;

    btn.setAttribute('data-act', act);
    
    btn.setAttribute('data-cont', cont);
    
    btn.setAttribute('data-warn', warn);

    btn.classList.add("ebtn");
    
    let buttonNameTextNode = document.createTextNode(btnName);
    
    let elapsedTimeTextNode = document.createTextNode(elapsedTime);
    
    btn.appendChild(buttonNameTextNode);

    btn.appendChild(document.createElement("br"));
    
    btn.appendChild(elapsedTimeTextNode);
    
    let li = document.createElement("li");

    li.appendChild(btn);
    
    let selectedList = document.getElementById(list);

    selectedList.appendChild(li);
    
    if (warn!="n"){

        if(warn < warnTime){

            $("#"+btnid).addClass('warn');
        
        }
    }

    document.getElementById(btnid). addEventListener("click", function(){
    
        btnJQL(act, cont, btnName);

        resetbtn();

    });
}


function resetbtn(){
			
    let buttons = document.getElementsByTagName('button');

    if(buttons){

        for (i = 0; i < buttons.length; i++) {

            let bact = buttons[i].getAttribute('data-act');
        
            let bcont = buttons[i].getAttribute('data-cont');

            let bwarn = buttons[i].getAttribute('data-warn');

            let arrelpTime = findLast(bact, bcont);

            let elpTime = arrelpTime[0];
            
            let wTime = arrelpTime[1];
            
            let newnode = document.createTextNode(elpTime);
            
            buttons[i].replaceChild(newnode, buttons[i].childNodes[2]);
            
                
            if (bwarn!="n"){

                if(bwarn < wTime){
                    
                    $("#"+buttons[i].id).addClass('warn');
        
                } else {

                    $("#"+buttons[i].id).removeClass('warn');
                
                }
            
            }

        }

    }
}

function btnJQL(act, cont){
					
    var U = $("#pu").val();
    
    var selPost = $("#selPost").val();
    
    setETime();
    
    if(U!="U"){
        
        const startTime = sqTime(datetimeValue)

    	objLEvents[startTime] = {
            "startTime": millisecTime, 
            "act": act, 
            "subProj": cont
        }
    
        LEvents.push([sqTime(datetimeValue), act, cont, objLAct[act].ActDesc]);

        if(selPost==="Y"){
        
            JQPost(act, cont, sqTime(datetimeValue));
            
        }
        
    }else{
    
        LEvents[eid]=([sqTime(datetimeValue), act, cont, objLAct[act].ActDesc]);

	objLEvents[LEvents[eid][0]] = { "startTime": millisecTime, "act": act, "subProj": cont }
        
        if(selPost==="Y"){
        
            jqUpdateEvent(origTime, sqTime(datetimeValue), act, cont);
            
        }
        
        $("#pmEvent").empty();
        
        $("#pu").text("");
        
        $("#pu").val("");
    
    }
    
    resetAll();
    
}

function JQPost(act, cont, dtime){

    $.post("./add/AddJQ.php",
    {
        v1: act,
        v2: cont,
        v3: dtime,
        SD: 'L',
        selTbl: 'tblEvents'
    });
    
    resetAll();
}