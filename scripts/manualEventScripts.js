const manualEventForm = {
  
	selectedPCode: '',
    selectedSubProj: '',
    clearDiv: function () {

        const listDiv = document.getElementById("eventBtnListContainer")

        while(listDiv.firstChild){

            listDiv.removeChild(listDiv.firstChild)

        }

    },
    btnLPU: function() {

        this.clearDiv()

        const eventBtnListContainer = document.getElementById("eventBtnListContainer")

		for (i in objLPU){

            if(objLPU[i].Active=="Y" && objLPU[i].PUCodeDesc!="Admin" && objLPU[i].PUCodeDesc!="Meeting") {
                
                let eventBtnContainer = document.createElement("li")
                
                let eventBtnText = objLPU[i].PUCodeDesc

                let linkTarget = i

                eventBtnText = document.createTextNode(eventBtnText)
                
                let eventLink = document.createElement("a")
                
                eventLink.href = "#"
                
                eventLink.addEventListener('click', () => { 
                
                    this.btnProj(linkTarget)
                    this.selectedPCode = linkTarget
                    
                });
                
                eventLink.appendChild(eventBtnText)
                            
                eventBtnContainer.appendChild(eventLink)
            
                eventBtnListContainer.appendChild(eventBtnContainer)
            }
	
		}

    },
    btnProj: function(selectedPCode) {

        this.clearDiv()

        const eventBtnListContainer = document.getElementById("eventBtnListContainer")

        for (i in objLProj) {

            if(objLProj[i].ProfileCode==selectedPCode && objLProj[i].ProjStatus!="Closed"){

                let eventBtnContainer = document.createElement("li");

                let eventBtnText = objLProj[i].ProjDesc;

                let linkTarget = i
                
                eventBtnText = document.createTextNode(eventBtnText)
            
                let eventLink = document.createElement("a")
            
                eventLink.href = "#"
                
                eventLink.addEventListener('click', () => { 
                
                    this.btnSubProj(linkTarget)
                    
                });
                
                eventLink.appendChild(eventBtnText)
                            
                eventBtnContainer.appendChild(eventLink)
            
                eventBtnListContainer.appendChild(eventBtnContainer)
    

            }

        }

    },
    btnSubProj: function(selectedProj){

        this.clearDiv()

        const eventBtnListContainer = document.getElementById("eventBtnListContainer")

        for (i in objLCont) {

            if(objLCont[i].ProjID==selectedProj && objLCont[i].Active!="N"){

                let eventBtnContainer = document.createElement("li");

                let eventBtnText = objLCont[i].ProjID + ": " + objLCont[i].ContDesc;

                let linkTarget = i
                
                eventBtnText = document.createTextNode(eventBtnText)
            
                let eventLink = document.createElement("a")
            
                eventLink.href = "#"
                
                eventLink.addEventListener('click', () => { 
                
                    this.btnAct(this.selectedPCode)
                    this.selectedSubProj = linkTarget;
                    
                });
                
                eventLink.appendChild(eventBtnText)
                            
                eventBtnContainer.appendChild(eventLink)
            
                eventBtnListContainer.appendChild(eventBtnContainer)
    

            }

        }

    },
    btnAct: function(selectedPCode){

        this.clearDiv()

        const eventBtnListContainer = document.getElementById("eventBtnListContainer")

        for (i in objLAct) {

            if(objLAct[i].PCode.includes(selectedPCode) && objLAct[i].Status!="Inactive"){

                let eventBtnContainer = document.createElement("li");

                let eventBtnText = objLAct[i].ActDesc

                let linkTarget = i
                
                eventBtnText = document.createTextNode(eventBtnText)
            
                let eventLink = document.createElement("a")
            
                eventLink.href = "#"
                
                eventLink.addEventListener('click', () => { 
                
                    this.addEvent(linkTarget, this.selectedSubProj)
                                        
                });
                
                eventLink.appendChild(eventBtnText)
                            
                eventBtnContainer.appendChild(eventLink)
            
                eventBtnListContainer.appendChild(eventBtnContainer)
    

            }

        }

    },
    addEvent: function(act, subproj) {

        this.clearDiv()

        const updateIndicator = document.getElementById("pu").value

        const postsIndicator = document.getElementById("selPost").value 

        //sets the time of the event being entered (determines if event occurs in the past )
        setETime();
            

        if(updateIndicator!="U"){

            const startTime = sqTime(datetimeValue)

            objLEvents[startTime] = {
                "startTime": millisecTime, 
                "act": act, 
                "subProj": subproj
            }
        
            LEvents.push([sqTime(datetimeValue), act, subproj, objLAct[act].ActDesc]);

            if(postsIndicator==="Y"){
                
                JQPost(act, subproj, sqTime(datetimeValue));

            }
                
            resetAll();

        } else {

            //important to remember that ANY event being updated HAS to be a "Past Event"
     
            LEvents[eid]=([sqTime(datetimeValue), act, subproj, objLAct[act].ActDesc]);

            objLEvents[LEvents[eid][0]] = {"startTime": millisecTime, "act": act, "subProj": subproj}

            if(postsIndicator==="Y"){

                jqUpdateEvent(origTime, sqTime(datetimeValue), act, subproj);

            }
            
            resetAll();

        }

        $("#pmEvent").empty();

        $("#pu").text("");

        $("#pu").val("");

        resetAll();

        this.clearDiv()

    }
			
}