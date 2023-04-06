const localEventButtonForm = {

    makeLocalEventBtnGroup: function(){
        const eventBtnListContainer = document.getElementById("localBtnListContainer") 

        for (i in objLocalButtonGroups) {

            let lbgText = objLocalButtonGroups[i].btnGroupName
            
            let localButtonGroupContainer = document.createElement("ul")
            localButtonGroupContainer.id = objLocalButtonGroups[i].btnGroup
            localButtonGroupContainer.classList.add("hidden")
            localButtonGroupContainer.classList.add("btnGroup")
  
            let jqGroupRef = "#"+localButtonGroupContainer.id

            let localButtonGroupHeader = document.createElement("a")
            localButtonGroupHeader.classList.add("groupHeading")
            localButtonGroupHeader.href = "#"
            lbgText = document.createTextNode(lbgText)
            localButtonGroupHeader.addEventListener('click', () => {

                $(jqGroupRef).toggleClass('hidden')

            })
            localButtonGroupHeader.appendChild(lbgText)
            eventBtnListContainer.appendChild(localButtonGroupHeader)
                      
            eventBtnListContainer.appendChild(localButtonGroupContainer)
                        
            this.makeLocalEventBtn(localButtonGroupContainer.id)

        }
    },
    makeLocalEventBtn: function(lbg){
        const eventBtnListContainer = document.getElementById(lbg)

        for (i in objLocalEventButtons) {

            if (objLocalEventButtons[i]["localButtonGroup"]==lbg){

                let eventBtnContainer = document.createElement("li");
                
                let actID = objLocalEventButtons[i]["actID"]
                let contID = objLocalEventButtons[i]["contid"]
                
                let btnID = actID+"_"+contID
                
                let warnSecs, lastUseTime, lastTime, unfmtLastUseTime

                if(objLocalEventButtons[i]["warn"]){
                    warnSecs = objLocalEventButtons[i]["warn"]*24*60*60
                }

                if(objLastUse.hasOwnProperty(btnID)==true){
                    lastTime = objLastUse[btnID]["lastTime"]
                    unfmtLastUseTime = Math.round(luxon.DateTime.now().toSeconds()-lastTime)
                    lastUseTime = ELTime(unfmtLastUseTime)
                    
                } else {

                    lastTime = lastUseTime = "N/A"
                    
                }
                
                let eventBtnText = objLAct[actID]["ActDesc"] + ": " + objLCont[contID]["ContDesc"] + " " + lastUseTime
                                
                eventBtnText = document.createTextNode(eventBtnText)
            
                let eventLink = document.createElement("a")

                eventLink.classList.add("localBtn")

                if(warnSecs){
 
                    if(warnSecs<unfmtLastUseTime){
                        eventLink.classList.add("warn")
                    }
                }

                eventLink.id = btnID
                eventLink.actID = actID
                eventLink.contID = contID
                eventLink.lastTime = lastTime
                eventLink.warnSecs = warnSecs
            
        		eventLink.appendChild(eventBtnText)

                eventLink.href = "#"
                
                eventLink.addEventListener('click', () => { 
                
			        manualEventForm.addEvent(actID, contID)

                    this.resetLocalBtn()
                                        
                })

                eventBtnContainer.appendChild(eventLink)
            
                eventBtnListContainer.appendChild(eventBtnContainer)
            }
    
        }
    },
    resetLocalBtn: function(){

        let newLastUseTime
		
		buttons = document.getElementsByClassName('localBtn');

        for (i = 0; i < buttons.length; i++) {

            if(buttons[i].lastTime!="N/A") {

                newUFLastUseTime = Math.round(luxon.DateTime.now().toSeconds() - buttons[i].lastTime)
                newLastUseTime = ELTime(newUFLastUseTime)

                if(buttons[i].hasOwnProperty("warnSecs")){
                    warnSecs = buttons[i]["warnSecs"]

                    if(warnSecs<newUFLastUseTime){
                        
                        if(buttons[i].classList.contains("warn")!=true){

                            buttons[i].classList.add("warn")

                        }

                    } else {

                        if(buttons[i].classList.contains("warn")==true){

                            buttons[i].classList.remove("warn")

                        } 
                    }
                }

         
            
            } else {
            
                newLastUseTime = "N/A"
            
            }
            
            eventBtnText = objLAct[buttons[i]["actID"]]["ActDesc"] + ": " + objLCont[buttons[i]["contID"]]["ContDesc"] + " " + newLastUseTime

            eventBtnText = document.createTextNode(eventBtnText)
            
            buttons[i].replaceChild(eventBtnText, buttons[i].childNodes[0]);

        }

        //alert("DONE")
	}
}


function ELTime(secs) {
				
	var days = secs / (60*60*24);
					
	if(days>=1){
					
		return Math.round(days) + "d";
					
	} else {
					
		var hrs = secs / (60*60);
						
		if(hrs>=1){
							
			return Math.round(hrs) + "h";
								
		} else {
							
			var mins = secs / 60;
								
			if(mins>=1){
									
				return Math.round(mins) + "m";
								
			} else {
								
				return secs + "s";
				
			}
		}
	}
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