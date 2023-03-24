const objEventsView = {
  
    minDate: document.getElementById("selMinDate"),
    maxDate: document.getElementById("selMaxDate"),
    tableHeaders: ["Actions", "Start Time", "Activty", "Sub-Project"],
    showEventList: function(){
        
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
    updateEvent: function(){},
    deleteEvent: function(i){

        const objEvent = objLEvents[i]

        const sqlTime = luxon.DateTime.fromMillis(objEvent.startTime).toSQL({ includeOffset: false })

        const q = "Delete "+sqlTime+": "+objEvent.act+">"+objEvent.subProj+"?";

        const c = confirm(q);
        
        if (c == true){

            delete objLEvents[i]

            const rowElement = document.getElementById('row'+i)
            rowElement.remove()

            JQDel(sqlTime, 'tblEvents', 'StartTime');
            
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
        
            var at = svgboxstartxcoord(Date.parse(LEvents[i-1][0]));
            
            
        }else{
        
            var at = svgboxstartxcoord(Date.parse(LEvents[i][0]));

        }
        
        var ac0 = "svgEventChart";
        var ac1 = svgboxstartxcoord(Date.parse(LEvents[i][0]));
        var ac2 = (eventLength / (24*60*60*1000))*svgWidthNum;
        
        var ac3 = findActivityColor(LEvents[i][1]);

        if(ac1<0){
        
            if(at>0){
            
                drawbox(ac0, 0, at, ac3);
            
            }
        
        }
        
        if(ac1>0){
        
            drawbox(ac0, ac1, ac2, ac3);

        }
    }
    
    document.getElementById("eventListContainer").appendChild(objEventsView.showEventList());

    svgtext('svgEventChart');

    displayActDurs();
}
