function displayLMoods(){

    resetSVG("svgMoodChart");

    LMoods.sort();
    
    LMoods.reverse();

    MoodsLen = LMoods.length;
    
    const minDate = Date.now()-86400000;
    
    text = "<table class='eventList'>";
    
    text += "<thead>";
    
        text += "<th colspan=2></th>";
        text += "<th>Date</th>";
        text += "<th>Time</th>";
        text += "<th>Mood</th>";
        text += "<th>Dur</th>";
        
    text += "</thead>";
    
    text += "</tbody>";
        
    //start eventDuration calc (should be function)
    
    for (i = 0; i < MoodsLen; i++) {
    
        if(i==0){
            
            var eventLength = Date.now()-Date.parse(LMoods[i][0]);
            
        }else{
    

            eventLength = Date.parse(LMoods[i-1][0])-Date.parse(LMoods[i][0]);
        
        }
        
        formatEventDuration(eventLength);
        
        if(i>0){
        
            var boxStart = svgboxstartxcoord(Date.parse(LMoods[i-1][0]));
            
        }else{
        
            var boxStart = svgboxstartxcoord(Date.parse(LMoods[i][0]));
            
        }
        
        var boxId = "svgMoodChart";
        var boxStartX = svgboxstartxcoord(Date.parse(LMoods[i][0]));
        var boxWidth = (eventLength / (24*60*60*1000))*svgWidthNum;
        var boxFill = moodColor(LMoods[i][1]);
        
        if(boxStartX<0){
        
            if(boxStart>0){
            
                drawbox(boxId, 0, boxStart, boxFill);
            
            }
        
        }
    
        if(boxWidth>0){
        
            drawbox(boxId, boxStartX, boxWidth, boxFill);

        }
        
        //end eventDuration calc
        
        let arr_disp_time = FixTime(LMoods[i][0]);
        
        if(Date.parse(LMoods[i][0]) > minDate){
        
            text += 
                "<tr>" +
                    "<td>" +
                        "<input type=button value=+ class=slnk onclick=MPost('"+ LMoods[i][1] + "','" + LMoods[i][0] + "','" + i+"') + />" +
                    "</td><td>" +
                        "<input type=button  value=- class=slnk onclick=delMood("+i+") + />" +
                    "</td><td>" +
                        arr_disp_time[4] +
                    "</td><td>" +
                        arr_disp_time[5] +
                    "</td><td>" +
                        LMoods[i][1] +
                    "</td><td>" +
                        eventDuration +
                    "</td>" +
                "</tr>";
                
        }
        
    }
    
    text += "</table>";

    svgtext('svgMoodChart');
    
    document.getElementById("moodListContainer").innerHTML = text;
    
    const a = LMoods[0][1];

    $( "#moodIndicator" ).css("color", moodColor(a));
    
}


function btnLMood(a){

    var selPost = $("#selPost").val();

    setETime();
    
    LMoods.push([sqTime(datetimeValue), String(a)]);
    
    $( "#moodIndicator" ).css("color", moodColor(a));
    
    if(selPost==="Y"){
    
        MPost(a, datetimeValue);
    
    }
    
    resetAll();
}



function MPost(mood, dtime, i){

    $.post("./add/AddJQ.php",
    {
        v1: dtime,
        v2: mood,
        selTbl: 'tblMood'
    });
    
    resetAll();
    
}

function delMood(i){
				
    var q = "Delete "+LMoods[i]+"?";
    
    var c = confirm(q);
    
    if (c == true){
    
        var etime = sqTime(LMoods[i][0]); 
    
        var a = LMoods.splice(i, 1);
        
        JQDel(etime, 'tblMood', 'MoodDT');
    
        resetAll();
    
    }
}

function resetLMoods(){

    if(LMoods === undefined || LMoods.length == 0) {
    
        //do nothing
    
    }else{

        localStorage.setItem("LSMoods", JSON.stringify(LMoods));
    
        displayLMoods();
    
    }
}