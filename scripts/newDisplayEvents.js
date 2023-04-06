const objEventsView = {
  
    tableHeaders: [" ", " ", " ", "Start Time", "Activty", "Sub-Project", "Duration"],
    clearDiv: function () {

        const listDiv = document.getElementById("eventListContainer")

        while(listDiv.firstChild){

            listDiv.removeChild(listDiv.firstChild)

        }

    },
    makeEventObj: function(){
	
		const minDate = luxon.DateTime.now()- ((1000*60*60*24)  * document.getElementById("selMinDate").value )
	
		const objLEvents =  {}
			
		for(i=0; i<LEvents.length; i++) {
			
			if(Date.parse(LEvents[i][0]) > minDate) {
				
				objLEvents[LEvents[i][0]] = {startTime: Date.parse(LEvents[i][0]), act: LEvents[i][1], subProj: LEvents[i][2]}
				
				if(i!=0){
				
					objLEvents[LEvents[i][0]]["endTime"] = Date.parse(LEvents[i-1][0])
                    objLEvents[LEvents[i][0]]["dur"] =  Date.parse(LEvents[i-1][0])-Date.parse(LEvents[i][0])

				}else{
				
					objLEvents[LEvents[i][0]]["endTime"] = Date.now()
                    objLEvents[LEvents[i][0]]["dur"] =  Date.now()-Date.parse(LEvents[i][0])
					
				}
                
			}
			
		}
		
		return objLEvents
			
	},
    showEventList: function(){
        
	    const objLEvents = this.makeEventObj()
        
        console.log(objLEvents)

        const eventList = document.createElement("table")

        const thead = document.createElement("thead")
        
        this.tableHeaders.forEach(element => {
        
            let th = document.createElement("th")
            let thtext = document.createTextNode(element)
            th.appendChild(thtext)
            thead.appendChild(th)

        }); 

        eventList.appendChild(thead)

        const tbody = document.createElement("tbody")

        let startTime
        let act
        let subProj
   
        for (i in objLEvents) {
            
            let eventId = i
            sqlTime = luxon.DateTime.fromMillis(objLEvents[i].startTime).toSQL({ includeOffset: false })
            startTime = luxon.DateTime.fromMillis(objLEvents[i].startTime).toFormat("MM-dd hh:mm:ss a")
            act = objLAct[objLEvents[i].act].ActDesc
            subProj = objLCont[objLEvents[i].subProj].ContDesc
            dur = luxon.Duration.fromMillis(objLEvents[i].dur).toFormat("h:mm:ss")
            
            let trow = document.createElement("tr")
            trow.id = 'row'+i
            let tcell = document.createElement("td")
            let aLink = document.createElement("a")
            aLink.href = "#"
            aLink.addEventListener("click", () => {
                this.postEvent(act, subProj, sqlTime)
            })
            aLink.appendChild(document.createTextNode("+"))
            tcell.appendChild(aLink)

            trow.appendChild(tcell)
            
            tcell = document.createElement("td")
            let dLink = document.createElement("a")
            dLink.id = "d"+eventId
            dLink.href = "#"
            dLink.addEventListener("click", () => {
                this.deleteEvent(eventId)
            })
            dLink.appendChild(document.createTextNode("-"))
            tcell.appendChild(dLink)
            
            trow.appendChild(tcell)

            tcell = document.createElement("td")
            let uLink = document.createElement("a")
            uLink.id = "u"+eventId
            uLink.href = "#"
            uLink.addEventListener("click", () => {
                alert(eventId)
                this.updateEvent(eventId)
            })
            uLink.appendChild(document.createTextNode("U"))
            tcell.appendChild(uLink)
        
            trow.appendChild(tcell)


            tcell = document.createElement("td")
            let tcelltext = document.createTextNode(startTime)
            tcell.appendChild(tcelltext)
            trow.appendChild(tcell)
            
            tcell = document.createElement("td")
            tcelltext = document.createTextNode(act)
            tcell.appendChild(tcelltext)
            trow.appendChild(tcell)

            tcell = document.createElement("td")
            tcelltext = document.createTextNode(subProj)
            tcell.appendChild(tcelltext)
            trow.appendChild(tcell)

            tcell = document.createElement("td")
            tcelltext = document.createTextNode(dur)
            tcell.appendChild(tcelltext)
            trow.appendChild(tcell)

            tbody.appendChild(trow)
        }
        
        eventList.appendChild(tbody)

	    eventList.classList.add("eventList");

        return eventList

    },
    postEvent: function(act, subProj, sqlTime){

        $.post("./add/AddJQ.php",
        {
            v1: act,
            v2: subProj,
            v3: sqlTime,
            SD: 'L',
            selTbl: 'tblEvents'
        })
    },
    updateEvent: function(eventId){

        $( "#pu" ).val( "U" );
		$( "#selP" ) . val( "Y" );
		$( "body" ).css( "background-color", "DarkRed" );
				
		origTime = eventId;

		const formattedOrigTime = FixTime(origTime)

		$( "#selFT" ) . val(formattedOrigTime[1]);
		$( "#DateTime" ) . val(formattedOrigTime[0]);
		$( "#DateTime" ) . text(formattedOrigTime[2]);
				
        eid = LEvents.findIndex(element => element.includes(eventId))

		var q = "Update: "+formattedOrigTime[2]+" - "+ objLAct[objLEvents[eventId].act].ActDesc + " " + objLCont[objLEvents[eventId].subProj].ContDesc

		$("#pmEvent").val(eventId);
		$("#pmEvent").text(q);

		resetAll();

    },
    deleteEvent: function(i){

        const objEvent = objLEvents[i]

        const sqlTime = luxon.DateTime.fromMillis(objEvent.startTime).toSQL({ includeOffset: false })

        const q = "Delete "+sqlTime+": "+objEvent.act+">"+objEvent.subProj+"?";

        const c = confirm(q);
        
        if (c == true){

            delete objLEvents[i]

            const a = LEvents.splice(i, 1)

            const rowElement = document.getElementById('row'+i)
            
            rowElement.remove()

            JQDel(sqlTime, 'tblEvents', 'StartTime');

            this.showEventList()

		localEventButtonForm.resetLocalBtn()
            
            resetAll();
        
        }

    },

}


function displayLEvents(){

    resetSVG('svgEventChart')

    LEvents.sort();
    
    LEvents.reverse();

    ELen = LEvents.length;

    for (i = 0; i < ELen; i++) {

        if(i==0){
            
            var eventLength = Date.now()-Date.parse(LEvents[i][0]);
            
        }else{
        
            eventLength = Date.parse(LEvents[i-1][0])-Date.parse(LEvents[i][0]);

        }
        
        formatEventDuration(eventLength);
    
        if(i>0){
        
            var boxStart = svgboxstartxcoord(Date.parse(LEvents[i-1][0]));
            
            
        }else{
        
            var boxStart = svgboxstartxcoord(Date.parse(LEvents[i][0]));

        }
        
        var boxId = "svgEventChart";
        var boxStartX = svgboxstartxcoord(Date.parse(LEvents[i][0]));
        var boxWidth = (eventLength / (24*60*60*1000))*svgWidthNum;
        
        var boxFill = findActivityColor(LEvents[i][1]);

        if(boxStartX<0){
        
            if(boxStart>0){
            
                drawbox(boxId, 0, boxStart, boxFill);
            
            }
        
        }
        
        if(boxStartX>0){
        
            drawbox(boxId, boxStartX, boxWidth, boxFill);

        }
    }
    
    objEventsView.clearDiv()

    document.getElementById("eventListContainer").appendChild(objEventsView.showEventList());

    svgtext('svgEventChart');

    displayActDurs();
}
