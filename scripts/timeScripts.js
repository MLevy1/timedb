function resetTime(){

	const P = $("#selP").val();
				
	if(P!="Y"){
				
		setTime();
				
	}
}

function TimeArr(){
	
	var MTime = new Date();
	
	MTime = MTime.getTime();
	
	var vTZ = $( "#selTZ" ).val();
	
	var AM = parseInt(vTZ)*60*60*1000;
	
	MTime = MTime+AM;
	
	var m =  new Date(MTime);
	
	var millisecs = m.getTime();
	
	var Y = m.getFullYear();
	
	var M = m.getMonth()+1;
	
	var D = m.getDate();
	
	var H = m.getHours();
	
	var Mn = m.getMinutes();
	
	var Sec = m.getSeconds();
	
	M = zerofix(M);
	
	Mn = zerofix(Mn);

	if(H<0){
	
		H=24+H;
	
		D=(D-1);
	
	}
	
	H = zerofix(H);
	
	if(H>=24){
	
		H=(H-24);

		D=(D+1);
		
	}
	
	if(H<12){
	
		var AP = "AM";
		
	}else{
	
		AP = "PM";
		
	}
	
	if(H==0){
	
		var hr = 12;
		
	}else if(H<13){
	
		hr = H;
		
	}else{
	
		hr = H-12;
		
	}
	
	D = zerofix(D);
	
	Sec = zerofix(Sec);
	
	let timeValue= Y+'-'+M +'-'+ D +'T'+ H +':'+ Mn + ':' + Sec;
	
	let visibleTime = M +'-'+ D +' '+ hr +':'+ Mn + ':' + Sec + ' ' + AP;
	
	let arrTime = [timeValue, millisecs, visibleTime];

	return arrTime;
}

function FixTime(CTime){

	var Y = CTime.substring(0,4);
	var M = CTime.substring(5,7);
	var D = CTime.substring(8,10);
	var H = CTime.substring(11,13);
	var Mn = CTime.substring(14,16);
	let S = CTime.substring(17);
	
	var m = new Date(Y,M-1,D,H,Mn,S);
	
	//M = zerofix(M);
	
	var D = m.getDate();
	
	D = zerofix(D);
	
	var H = m.getHours();

	H = zerofix(H);
	
	var Mn = m.getMinutes();
	
	Mn = zerofix(Mn);

	if(H<12){
	
		var AP = "AM";
		
	}else{
	
		AP = "PM";
		
	}
	
	if(H===0){
	
		var hr = 12;
		
	}else if(H<13){
	
		hr = H;
		
	}else{
	
		hr = H-12;
		
	}
	
	var millisecs = m.getTime();

	var timeValue = Y+'-'+M +'-'+ D +'T'+ H +':'+ Mn + ':' + S;
	
	var visibleTime = M +'-'+ D +' '+ hr +':'+ Mn + ':' + S + ' ' + AP;
	
	var SvrTime = Y+'-'+M +'-'+ D +' '+ H +':'+ Mn + ':' + S;
	
	let dispDate = M+'-'+D;
	
	let dispTime = hr +':'+ Mn + ':' + S + ' ' + AP;

	var arrTime = [timeValue, millisecs, visibleTime, SvrTime, dispDate, dispTime];

	return arrTime;

}

function setTime(){
	
	var T = TimeArr();
	
	$( "#selP" ) . val("N");
	
	$( "#DateTime" ) . val(T[0]);
	
	$( "#DateTime" ) . text(T[2]);
	
	$("body").css("background-color", defaultBGColor);
}

function AddTime(min){
	$( "#selP" ) . val("Y");
	
	$("body").css("background-color", "DarkRed");

	var CTime = $( "#DateTime" ) . val();
	
	var Y = CTime.substring(0,4);
	var M = CTime.substring(5,7);
	var D = CTime.substring(8,10);
	var H = CTime.substring(11,13);
	var Mn = CTime.substring(14,16);
	
	var m = new Date(Y,M-1,D,H,Mn);
	
	var OM = m.getMinutes();
	
	var NM = OM + min;
	
	m.setMinutes(NM);
	
	var Y = m.getFullYear();
	var M = m.getMonth();
	
	M++;
	
	if(M===0){
		
		M=12;
		Y=(Y-1);
		
	}
	
	M = zerofix(M);
	
	var D = m.getDate();
	
	D = zerofix(D);
	
	var H = m.getHours();

	H = zerofix(H);
	
	var Mn = m.getMinutes();
	
	Mn = zerofix(Mn);

	if(H<12){
	
		var AP = "AM";
		
	}else{
	
		AP = "PM";
		
	}
	
	if(H===0){
	
		var hr = 12;
		
	}else if(H<13){
	
		hr = H;
		
	}else{
	
		hr = H-12;
		
	}
	
	var millisecs = m.getTime();

	var timeValue = Y+'-'+M +'-'+ D +'T'+ H +':'+ Mn + ':' + '00';
	
	var visibleTime = M +'-'+ D +' '+ hr +':'+ Mn + ':' + '00' + ' ' + AP;
	
	$( "#selFT" ) . val(millisecs);
	$( "#DateTime" ) . val(timeValue);
	$( "#DateTime" ) . text(visibleTime);	
}

//USED IN MULTIPLE TIME FUNCTIONS
function sqTime(etmv){

	var p1 = etmv.substr(0,10);
			
	var p2 = etmv.substr(11);
			
	var etmv1 = (p1 + " " + p2);

	return etmv1;
}

//adds a zero to the beginning of a number. needed for seconds and mins in all time functions
function zerofix(timeval){

	if(timeval<10){

		ntimeval = "0"+timeval;
	
	}else{
	
	ntimeval = timeval;
	
	}
	
	return ntimeval;
}

function setETime(){

	var T = TimeArr();
	
	var PE = $( "#selP" ) . val();
	
	if(PE=="Y"){
	
		datetimeValue = $( "#DateTime" ) . val();
		datetimeText = $( "#DateTime" ) . text();
		millisecTime = $( "#selFT" ) . val();
		
	}else{
	
		datetimeValue = T[0];
		millisecTime = T[1];
		datetimeText = T[2];
	}
}

function formatEventDuration(eventLength){
					
	eventLengthHours = eventLength/(1000*60*60);
	
	eventLengthHoursRounded = Math.floor(eventLengthHours);
	
	eventLengthMins = (eventLengthHours-eventLengthHoursRounded)*60;
	
	eventLengthMinsRounded = Math.floor(eventLengthMins);
	
	eventLengthMinsRounded = zerofix(eventLengthMinsRounded);
	
	eventLengthSecsRounded = Math.floor((eventLengthMins-eventLengthMinsRounded)*60);
	
	eventLengthSecsRounded = zerofix(eventLengthSecsRounded);
	
	eventDuration = eventLengthHoursRounded + ":" + eventLengthMinsRounded + ":" + eventLengthSecsRounded;

	return eventDuration;
	
}