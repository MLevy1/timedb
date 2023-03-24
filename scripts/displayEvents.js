function displayLEvents(){

    resetSVG('svgEventChart')

    LEvents.sort();
    
    LEvents.reverse();

    ELen = LEvents.length;
    
    let selMinDate = $("#selMinDate").val();

    var minDate = Date.now()-(selMinDate*24*60*60*1000);

    let selMaxDate = $("#selMaxDate").val();

    let maxDate = Date.now()-(selMaxDate*24*60*60*1000);
    
    text = "<table class='eventList' width=100%>"

    text += "<thead>";
    
    text += "<th colspan=3></th><th>Date</th><th>Time</th><th>Act</th><th>Cont</th><th>Dur</th>";

    text += "</thead><tbody>";
    
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
        
            if(boxStartX>0){
            
                drawbox(boxId, 0, boxStart, boxFill);
            
            }
        
        }
        
        if(boxWidth>0){
        
            drawbox(boxId, boxStartX, boxWidth, boxFill);

        }
    
        //end eventDuration calc
        
        let arr_disp_time = FixTime(LEvents[i][0]);
        
        if(Date.parse(LEvents[i][0]) > minDate && Date.parse(LEvents[i][0]) <= maxDate){
        
        text += "<tr><td>" +
        
        "<input type=button  value=+ class=slnk onclick='JQPost(`"+ LEvents[i][1] + "`,`" + LEvents[i][2] + "`,`" + LEvents[i][0] + "`,`" + i+"`)'/>" + 
        
        "</td><td>" 
        
        + 
        
        "<input type=button value=- class=slnk onclick='delEvent("+ i +")' />" 
        
        + 
        
        "</td><td>" 
        
        + 
        
        "<input type=button class=slnk value=U onclick='UpdateEvent(`"+ i + "`)' />"
        
        +
        
        "</td><td>" 
        
        + 
        
            arr_disp_time[4] + 
        "</td><td>" + 
            arr_disp_time[5] + 
        "</td><td>" + 
            LEvents[i][3] +
        "</td><td>" + 
            LEvents[i][2] + 
        "</td><td>" + 
            eventDuration + 
        "</td></tr>";
    
        }
    
    }
    text += "</tbody>";
    text += "</table>";

    document.getElementById("eventListContainer").innerHTML = text;
    
    svgtext('svgEventChart');
    displayActDurs();
    
}