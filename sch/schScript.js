console.log("loaded!");

function btnJQs(act, cont, btnid, tbl)
{   

//For timed events
var selDurH = $( "#selDurH" ) . val();
var selDurM =$( "#selDurM" ) . val();
	
var min = (parseInt(selDurH)*60)+parseInt(selDurM);
//end timed events

    var dtime = $( "#selDT" ) . val();

    var p1 = './timedb/sch/btnSetJQDSch.php';
    var p2 = '?selDate=';
    var p3 = dtime.substring(0,10);
    var p4 = '&selTime=';
    var p5 = dtime.substring(11,16);

    var p6 = p1+p2+p3+p4+p5; 
    
    $.post("./timedb/add/AddJQ.php",
    {
        v1: act,
        v2: cont,
        v3: dtime,
        selTbl: tbl
    });
    
        $("#"+btnid).css("background-color", "blue");

    setTimeout(function(){
        UpdateSch();
        UpdateButtons(p6);
        $("button").css("background-color", "lightgray");
        }, 1000);

	//For Timed Events
	if(min>0){

	var CTime = $( "#selDT" ) . val();
	
	var Y = CTime.substring(0,4);
	var M = CTime.substring(5,7);
	var D = CTime.substring(8,10);
	var H = CTime.substring(11,13);
	var Mn = CTime.substring(14,16);
	 
	var MTime = new Date(Y,M,D,H,Mn);
	 
	var m =  new Date(MTime.getTime());
	
	var OM = m.getMinutes();
	
	var NM = OM + min;
	
	m.setMinutes(NM);
	
	var Y = m.getFullYear();
	var M = m.getMonth();
	
	if(M<10){
		M="0"+M;
		}
	
	var D = m.getDate();
	
	if(D<10){
		D="0"+D;
		}
	
	var H = m.getHours();
	
	if(H<10){
		H="0"+H;
		}
	
	var Mn = m.getMinutes();
	
	if(Mn<10){
		Mn="0"+Mn;
		}

	var ETime = Y+'-'+M +'-'+ D +'T'+ H +':'+ Mn;
	
	UpdateVar(ETime);
	
		}
	//End Timed Events

}

function btnJQDelE1(a, b, c)
{
	$.post("./timedb/del/DelJQ.php",
	{
		v1: a,
		c1: b,
		selTbl: c
	});
	setTimeout(function(){
        UpdateSch();
        }, 100);

}

function UpdateVar(ETime)
{
	var CTime = $( "#selDT" ) . val();
	
	var a = '../sch/ViewSEvent2.php?TestTime=';
	
	$.ajax({
	url: a+CTime,
	type: 'GET',
	dataType: 'html'
	})
	.done(function(data) {
	
       act1 = data.substring(0,3);
	cont1 = data.substring(4);
	
		$.post("../add/AddJQ.php",
	{
		v1: act1,
		v2: cont1,
		v3: ETime,
		selTbl: 'tblSchedEvents'
	});
	setTimeout(function(){
        UpdateSch();
        }, 1000);
		
	
	
	})
	.fail(function() {
	$('#sched2').prepend('X');
	alert("E!");
	});
	
}


function UpdateButtons(a)
{
    $.ajax({
        url: a,
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
         $('#buttons').html( data )
    })
    .fail(function() {
        $('#buttons').prepend('X');
    });
}

function UpdateSch()
{

var CTime = $( "#selDT" ) . val();
	var D = CTime.substring(0,10);
	
	var a = './timedb/sch/SFooterEventQueries.php?selDate=';
	
    $.ajax({
	url: a+D,
        type: 'GET',
        dataType: 'html'
    })
    .done(function( data ) {
         $('#sched').html( data )
    })
    .fail(function() {
        $('#sched').prepend('No Add');
    });

}

function AddManual()
{

	var selDurH = $( "#selDurH" ) . val();
	var selDurM =$( "#selDurM" ) . val();
	
	var min = (parseInt(selDurH)*60)+parseInt(selDurM);
	
	var act = $( "#selAct" ) . val();
	var cont = $( "#selCont" ) . val();
	var tvar = $( "#selDT" ) . val();
	
	$.post("../add/AddJQ.php",
	{
		v1: act,
		v2: cont,
		v3: tvar,
		selTbl: 'tblSchedEvents'
	});
	
	setTimeout(function(){
        UpdateSch();
        }, 1000);
	
	//For Timed Events
	if(min>0){

	var CTime = $( "#selDT" ) . val();
	
	var Y = CTime.substring(0,4);
	var M = CTime.substring(5,7);
	var D = CTime.substring(8,10);
	var H = CTime.substring(11,13);
	var Mn = CTime.substring(14,16);
	 
	var MTime = new Date(Y,M,D,H,Mn);
	 
	var m =  new Date(MTime.getTime());
	
	var OM = m.getMinutes();
	
	var NM = OM + min;
	
	m.setMinutes(NM);
	
	var Y = m.getFullYear();
	var M = m.getMonth();
	
	if(M<10){
		M="0"+M;
		}
	
	var D = m.getDate();
	
	if(D<10){
		D="0"+D;
		}
	
	var H = m.getHours();
	
	if(H<10){
		H="0"+H;
		}
	
	var Mn = m.getMinutes();
	
	if(Mn<10){
		Mn="0"+Mn;
		}

	var ETime = Y+'-'+M +'-'+ D +'T'+ H +':'+ Mn;
	
	UpdateVar(ETime);
	
		}
	//End Timed Events
	
}


function blurfunct()
{
	var dtime = $( "#selDT" ) . val();

	var p1 = './timedb/sch/btnSetJQDSch.php';
	var p2 = '?selDate=';
	var p3 = dtime.substring(0,10);
	var p4 = '&selTime=';
	var p5 = dtime.substring(11,16);

	var p6 = p1+p2+p3+p4+p5;

	UpdateButtons(p6);

	UpdateSch();
}

function AddTime(min)
{
	var CTime = $( "#selDT" ) . val();
	
	var Y = CTime.substring(0,4);
	var M = CTime.substring(5,7);
	var D = CTime.substring(8,10);
	var H = CTime.substring(11,13);
	var Mn = CTime.substring(14,16);
	 
	var MTime = new Date(Y,M,D,H,Mn);
	 
	var m =  new Date(MTime.getTime());
	
	var OM = m.getMinutes();
	
	var NM = OM + min;
	
	m.setMinutes(NM);
	
	var Y = m.getFullYear();
	var M = m.getMonth();
	
	if(M===0){
		
		M=12;
		Y=(Y-1);
		
	}else if(D==31){
	
		M=(M-1);
		
	}

	if(M<10){

		M="0"+M;
		
	}
	
	if(D==31){
	
		D=31;
		
	}else{
	
	var D = m.getDate();
	
	}
	
	if(D<10){
		D="0"+D;
		}
	
	var H = m.getHours();
	
	if(H<10){
		H="0"+H;
		}
	
	var Mn = m.getMinutes();
	
	if(Mn<10){
		Mn="0"+Mn;
		}

	var NDTime = Y+'-'+M +'-'+ D +'T'+ H +':'+ Mn;
	
	$( "#selDT" ) . val(NDTime);
	
	blurfunct();
}

function AddSEvent(){
	
	var selDurH = $( "#selDurH" ) . val();
	var selDurM =$( "#selDurM" ) . val();
	
	var min = (parseInt(selDurH)*60)+parseInt(selDurM);
	
	if(min==0){
		alert("NO!!!");
		}
		else{
	
	var CTime = $( "#selDT" ) . val();
	
	var Y = CTime.substring(0,4);
	var M = CTime.substring(5,7);
	var D = CTime.substring(8,10);
	var H = CTime.substring(11,13);
	var Mn = CTime.substring(14,16);
	 
	var MTime = new Date(Y,M,D,H,Mn);
	 
	var m =  new Date(MTime.getTime());
	
	var OM = m.getMinutes();
	
	var NM = OM + min;
	
	m.setMinutes(NM);
	
	var Y = m.getFullYear();
	var M = m.getMonth();
	
	if(M<10){
		M="0"+M;
		}
	
	var D = m.getDate();
	
	if(D<10){
		D="0"+D;
		}
	
	var H = m.getHours();
	
	if(H<10){
		H="0"+H;
		}
	
	var Mn = m.getMinutes();
	
	if(Mn<10){
		Mn="0"+Mn;
		}

	var ETime = Y+'-'+M +'-'+ D +'T'+ H +':'+ Mn;
	
	
	UpdateVar(ETime);
	
	
	}
}

console.log("end!");