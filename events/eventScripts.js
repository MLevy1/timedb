var lastuse = <?php echo json_encode( $lastuse ) ?>;

var srvevents = <?php echo json_encode( $events ) ?>;

//alert("time: " + srvevents[0][0] + " act: " + srvevents[1][0] + " cont: " + srvevents[2][0]);

var text, ELen, MLen, i, tmv, tmt, ft, etmv, etmt, eft, eid;

//sets variables to the hold contents of locally stored events, moods, activites, sub-activites, projects and use codes

var LEvents = JSON.parse(localStorage.getItem("LSEvents"));

var LMoods = JSON.parse(localStorage.getItem("LSMoods"));

var LActs = JSON.parse(localStorage.getItem("LSActs"));

var LConts = JSON.parse(localStorage.getItem("LSConts"));

var LProj = JSON.parse(localStorage.getItem("LSProj"));

var LPU = JSON.parse(localStorage.getItem("LSPU"));

setTime();

if(LEvents===null){

	var LEvents = [];
	
}else{

	displayLEvents();

}

if(LMoods===null){

	var LMoods = [];
	
}else{

	displayLMoods();

}

ebtnjql('N04', 'NA', 'Bed', "tblRoutine", "n", "n", "n");

ebtnjql('B01', 'PERSONAL.2', 'BR', "tblRoutine", "n", "n", "n");

ebtnjql('B07', 'PERSONAL.2', 'BR-2', "tblRoutine", "n", "n", "n");

ebtnjql('P29', 'PERSONAL.2', 'Shower', "tblRoutine", "n", "n", (2*60*60*24));

ebtnjql('P60', 'PERSONAL.2', 'Floss', "tblRoutine", "n", "n", (2*60*60*24));

ebtnjql('P09', 'PERSONAL.2', 'Brush Teeth', "tblRoutine", "n", "n", (2*60*60*24));
		
ebtnjql('P33', 'PERSONAL.2', 'Shave & Hair', "tblRoutine", "n", "n", (3*60*60*24));

ebtnjql('P20', 'PERSONAL.2', 'Dress', "tblRoutine", "n", "n", "n");

ebtnjql('P32', 'PERSONAL.2', 'Pack', "tblRoutine", "n", "n", "n");

ebtnjql('P16', 'Dog', 'Dog', "tblRoutine", "n", "n", "n");

ebtnjql('P30', 'Dog', 'Walk (D)', "tblRoutine", "n", "n", "n");

ebtnjql('P12', 'PERSONAL.2', 'Fingernails', "tblRoutine", "n", "n", (10*60*60*24));

ebtnjql('P29', 'Dog', 'Shower (D)', "tblRoutine", "n", "n", (30*60*60*24));

ebtnjql('N01', 'NA', 'Untracked', "tblRoutine", "n", "n", "n");

ebtnjql('C03', 'CHC.R', 'Feeding', "tblccare", "n", "n", "n");

ebtnjql('C01', 'CHC.R', 'Diaper 1', "tblccare", "n", "n", "n");

ebtnjql('C02', 'CHC.R', 'Diaper 2', "tblccare", "n", "n", "n");

ebtnjql('C08', 'CHC.R', 'Reading', "tblccare", "n", "n", (4*60*60*24));
	
ebtnjql('C09', 'CHC.R', 'Play', "tblccare", "n", "n", "n");
	
ebtnjql('C04', 'CHC.R', 'Bath', "tblccare", "n", "n", "n");

ebtnjql('S01', 'CW-Group', 'Social (CW)', "tblsocial", "n", "n", "n");

ebtnjql('S13', 'CW-Group', 'Bar (CW)', "tblsocial", "n", "n", "n");

ebtnjql('S01', 'DC', 'Social (DC)', "tblsocial", "n", "n", "n");
		
ebtnjql('S01', 'ME', 'Social (ME)', "tblsocial", "n", "n", "n");

ebtnjql('S01', 'MH', 'Social (MH)', "tblsocial", "n", "n", "n");

ebtnjql('S01', 'RC', 'Social (RC)', "tblsocial", "n", "n", "n");

ebtnjql('S01', 'ADf', 'Social (A&F)', "tblsocial", "n", "n", "n");

ebtnjql('A02', 'ADMIN', 'Inbox', "tblwork", "n", "n", "n");

ebtnjql('T04', 'TRAINING.2', 'WF Training', "tblwork", "n", "n", "n");

ebtnjql('M10', 'MEET.01', 'Team Mtg', "tblwork", "n", "n", "n");

ebtnjql('A07', 'ADMIN', 'Tech Support', "tblwork", "n", "n", "n");

ebtnjql('W15', 'ISSUE.00', 'Issue Memo', "tblwork", "n", "n", "n");

ebtnjql('W04', 'ISSUE.R', 'Issues Reporting', "tblwork", "n", "n", "n");

ebtnjql('W10', 'ISSUE.00', 'Issues: Email', "tblwork", "n", "n", "n");

ebtnjql('M01', 'ISSUE.00', 'Issues: R&C Mtg', "tblwork", "n", "n", "n");

ebtnjql('M02', 'ISSUE.00', 'Issues: Bus Mtg', "tblwork", "n", "n", "n");

ebtnjql('W01', 'RCSA.00', 'RCSA: Agenda', "tblwork", "n", "n", "n");

ebtnjql('M02', 'RCSA.00', 'RCSA: Bus Mtg', "tblwork", "n", "n", "n");

ebtnjql('M01', 'RCSA.00', 'RCSA: R&C Mtg', "tblwork", "n", "n", "n");

ebtnjql('W33', 'RCSA.A', 'RCSA: Risk Asmt', "tblwork", "n", "n", "n");

ebtnjql('W29', 'RCSA.A', 'RCSA: Controls', "tblwork", "n", "n", "n");

ebtnjql('W37', 'RCSA.A', 'RCSA: QA', "tblwork", "n", "n", "n");

ebtnjql('W10', 'RCSA.00', 'RCSA: Email', "tblwork", "n", "n", "n");

ebtnjql('W38', 'RCSA.R', 'RCSA: Status Rep', "tblwork", "n", "n", "n");

ebtnjql('W04', 'RCSA.R', 'RCSA: Rep', "tblwork", "n", "n", "n");

ebtnjql('W29', 'SHRP.01', 'MR Ctr: Controls', "tblwork", "n", "n", "n");

ebtnjql('W10', 'SHRP.01', 'MR Ctr: Email', "tblwork", "n", "n", "n");

ebtnjql('W37', 'SHRP.01', 'MR Ctr: QA', "tblwork", "n", "n", "n");

ebtnjql('W38', 'SHRP.01', 'MR Ctr: Status Rep', "tblwork", "n", "n", "n");

ebtnjql('M01', 'SHRP.01', 'MR Ctr: R&C Mtg', "tblwork", "n", "n", "n");

ebtnjql('W04', 'SHRP.01', 'MR Ctr: Rep', "tblwork", "n", "n", "n");

ebtnjql('W04', 'REP.01', 'Qtrly Report', "tblwork", "n", "n", "n");

ebtnjql('W04', 'REP.00', 'Reporting: General', "tblwork", "n", "n", "n");

ebtnjql('M01', 'REP.00', 'Rep R&C Mtg', "tblwork", "n", "n", "n");

ebtnjql('W10', 'RC.00', 'Reg Ctr Email', "tblwork", "n", "n", "n");

ebtnjql('M01', 'RC.00', 'Reg Ctr R&C Mtg', "tblwork", "n", "n", "n");

ebtnjql('W50', 'POL.00', 'Procedures: Policy', "tblwork", "n", "n", "n");

ebtnjql('M01', 'POL.00', 'Procedures: R&C Mtg', "tblwork", "n", "n", "n");

ebtnjql('W10', 'POL.00', 'Procedures: Email', "tblwork", "n", "n", "n");

ebtnjql('W38', 'POL.00', 'Procedures: Status Rep', "tblwork", "n", "n", "n");

ebtnjql('N02', 'AD', 'Drive (A)', "tblfam", "n", "n", "n");

ebtnjql('S07', 'AD', 'Meal (A)', "tblfam", "n", "n", "n");

ebtnjql('S01', 'Family.1', 'Social (Mom)', "tblfam", "n", "n", "n");

ebtnjql('P30', 'AD', 'Walk (A)', "tblfam", "n", "n", "n");

ebtnjql('P56', 'AD', 'Hiking (A)', "tblfam", "n", "n", "n");

ebtnjql('S01', 'AD', 'Social (A)', "tblfam", "n", "n", "n");

ebtnjql('S01', 'Family.3', 'Social (F)', "tblfam", "n", "n", "n");

ebtnjql('S10', 'AD', 'Shopping (A)', "tblfam", "n", "n", "n");

ebtnjql('N03', 'AD', 'TV (A)', "tblfam", "n", "n", "n");

ebtnjql('S09', 'AD', 'Events (A)', "tblfam", "n", "n", "n");

ebtnjql('N02', 'Family.6', 'Drive (A&D)', "tblfam", "n", "n", "n");

ebtnjql('P30', 'Family.6', 'Walk (A&D)', "tblfam", "n", "n", "n");

ebtnjql('P56', 'Family.6', 'Hiking (A&D)', "tblfam", "n", "n", "n");

ebtnjql('N02', 'PERSONAL.5', 'Drive', "tbltrans", "n", "n", "n");

ebtnjql('P40', 'PERSONAL.5', 'Gas', "tbltrans", "n", "n", "n");

ebtnjql('N02', 'Dog', 'Drive (D)', "tbltrans", "n", "n", "n");

ebtnjql('P42', 'PERSONAL.4', 'Run', "tblhealth", "n", "n", "n");

ebtnjql('P31', 'PERSONAL.4', 'Gym', "tblhealth", "n", "n", (7*60*60*24));

ebtnjql('P63', 'PERSONAL.4', 'Meditate', "tblhealth", "n", "n", (7*60*60*24));

ebtnjql('P30', 'PERSONAL.4', 'Walk', "tblhealth", "n", "n", "n");

ebtnjql('P15', 'PERSONAL.4', 'Doctor', "tblhealth", "n", "n", "n");

ebtnjql('B02', 'PERSONAL.8', 'Eat', "tblfood", "n", "n", "n");

ebtnjql('B06', 'BREAK', 'Beverage', "tblfood", "n", "n", "n");

ebtnjql('P45', 'PERSONAL.8', 'Pick-up Food', "tblfood", "n", "n", "n");

ebtnjql('P13', 'PERSONAL.8', 'Cook', "tblfood", "n", "n", "n");

ebtnjql('B09', 'PERSONAL.8', 'Eat Slow', "tblfood", "n", "n", "n");
		
ebtnjql('B05', 'PERSONAL.8', 'Order Food', "tblfood", "n", "n", "n");

ebtnjql('P18', 'PERSONAL.4', 'Food Tracking', "tblfood", "n", "n", "n");
		
ebtnjql('P35', 'PERSONAL.3', 'Dishes', "tblchores", "n", "n", (4*60*60*24));

ebtnjql('P34', 'PERSONAL.3', 'Laundry', "tblchores", "n", "n", (14*60*60*24));

ebtnjql('P41', 'PERSONAL.3', 'Trash', "tblchores", "n", "n", (5*60*60*24));

ebtnjql('P59', 'PERSONAL.3', 'Vacuum', "tblchores", "n", "n", "n");

ebtnjql('P36', 'PERSONAL.7', 'Groceries', "tblchores", "n", "n", "n");

ebtnjql('P22', 'PERSONAL.3', 'Haircut', "tblchores", "n", "n", (30*60*60*24));

ebtnjql('P64', 'PERSONAL.3', 'Mail', "tblchores", "n", "n", (21*60*60*24));

ebtnjql('P61', 'PERSONAL.3', 'Sheets & Towels', "tblchores", "n", "n", (30*60*60*24));

ebtnjql('P37', 'PERSONAL.3', 'Lawn', "tblchores", "n", "n", "n");

ebtnjql('P58', 'PERSONAL.3', 'Clean Kitchen', "tblchores", "n", "n", "n");

ebtnjql('P48', 'PERSONAL.3', 'Clean Car', "tblchores", "n", "n", "n");

ebtnjql('P11', 'PERSONAL.3', 'Clean House', "tblchores", "n", "n", (30*60*60*24));

ebtnjql('P39', 'PERSONAL.7', 'Shopping: Home', "tblchores", "n", "n", "n");

ebtnjql('P47', 'PERSONAL.7', 'Shopping: Online', "tblchores", "n", "n", "n");

ebtnjql('P43', 'PERSONAL.3', 'Home Repairs', "tblchores", "n", "n", "n");

ebtnjql('L03', 'PERSONAL.3', 'Car Repairs', "tblchores", "n", "n", "n");

ebtnjql('P05', 'PERSONAL.A', 'Personal Admin', "tblpersonal", "n", "n", "n");

ebtnjql('P01', 'TIMEDB.0', 'Database', "tblpersonal", "n", "n", "n");

ebtnjql('P04', 'PFIN.00', 'Finances', "tblpersonal", "n", "n", "n");

ebtnjql('P26', 'PERSONAL.1', 'JO', "tblpersonal", "n", "n", "n");

ebtnjql('N03', 'PERSONAL.1', 'TV', "tblpersonal", "n", "n", "n");

ebtnjql('L16', 'READ.1', 'Research', "tblpersonal", "n", "n", "n");

ebtnjql('L16', 'PERSONAL.4', 'Read: Health', "tblpersonal", "n", "n", "n");

ebtnjql('L19', 'LEARNING.1', 'Crossword', "tblpersonal", "n", "n", "n");

ebtnjql('L14', 'PROG.3', 'JavaScript', "tblpersonal", "n", "n", "n");

ebtnjql('L14', 'PROG.1', 'Python', "tblpersonal", "n", "n", "n");

ebtnjql('L16', 'NORM.F', 'Read: Fashion', "tblpersonal", "n", "n", "n");

ebtnjql('P24', 'PERSONAL.1', 'Internet', "tblpersonal", "n", "n", "n");

ebtnjql('P53', 'PERSONAL.1', 'Crypto', "tblpersonal", "n", "n", "n");

ebtnjql('L16', 'News', 'News', "tblpersonal", "n", "n", "n");

function emptyps(){

	$("#csel").empty();
	$("#psel").empty();
	$("#spsel").empty();
	$("#asel").empty();
}


function btnClearAll(){

	var c = confirm("Clear all local data?");
	
	if (c == true){
		localStorage.removeItem("LSEvents");

		localStorage.removeItem("LSMoods");

		LEvents = [];

		LMoods = [];
		
		resetSVG('mcht');
		
		resetSVG('echt');
		
		document.getElementById("demo").innerHTML = LEvents;
				
		document.getElementById("moodtbl").innerHTML = LMoods;
		
	}
}

function resetTime(){

	var P = $("#selP").val();
	
	if(P!="Y"){
	
		setTime();
	
	}
}

function btnclr(){

	$("button").css("background-color", "navy");
	
	$("button").css("color", "yellow");

	resetAll();
}


$("button").click(function(){
	
	$(this).css("background-color", "SteelBlue");
    		    		
    	$(this).css("color", "SpringGreen");
    		
    	setTimeout(btnclr, 1000);
    		
});

$(".sTime").change(function(){

	displayLEvents();
	
});


function btnJQL(act, cont, c, A2){
		
	var U = $("#pu").val();
	
	var selPost = $("#selPost").val();
	
	setETime();
	
	if(U!="U"){
	
		LEvents.push([tmv, act, cont, A2, 'N', tmt, ft]);
		
		if(selPost==="Y"){
		
			JQPost(act, cont, tmv);
			
		}
		
	}else{
	
		LEvents[eid]=([etmv, act, cont, A2, 'N', etmt, eft]);
		
		if(selPost==="Y"){
			
			var etmv1 = sqTime(etmv);
		
			JQUpdate(act, cont, etmv1);
			
		}
		
		$("#pmEvent").empty();
		
		$("#pu").text("");
		
		$("#pu").val("");
	
	}
	
	resetAll();
	
}

function btnLMood(a){

	var selPost = $("#selPost").val();

	setETime();
	
	LMoods.push([tmv, a, 'N', tmt, ft]);
	
	$( "#dm" ).html(a);
	
	if(selPost==="Y"){
	
		MPost(a, tmv);
	
	}
	
	resetAll();
}

function fmtime(EL){
		
		ELH = EL/(1000*60*60);
		
		ELHr = Math.floor(ELH);
		
		ELM = (ELH-ELHr)*60;
		
		ELMr = Math.floor(ELM);
		
		ELMr = zerofix(ELMr);
		
		ELSr = Math.floor((ELM-ELMr)*60);
		
		ELSr = zerofix(ELSr);
		
		EDur = ELHr + ":" + ELMr + ":" + ELSr;
		
		return EDur;
		
}


function displayLMoods(){

	resetSVG("mcht");

	LMoods.sort();
	
	LMoods.reverse();

	MLen = LMoods.length;
	
	var minDate = Date.now()-86400000;
	
	text = "<table>";
	
	text += "<th></th><th></th><th>Date</th><th>Time</th><th>Mood</th><th></th><th>Dur</th>";
		
	//start edur calc (should be function)
	
	for (i = 0; i < MLen; i++) {
	
		if(i==0){
			
			var EL = Date.now()-LMoods[i][4];
			
		}else{
	

			EL = LMoods[i-1][4]-LMoods[i][4];
		
		}
		
		fmtime(EL);
		
		if(i>0){
		
			var boxStart = svgboxstartxcoord(LMoods[i-1][4]);
			
		}else{
		
			var boxStart = svgboxstartxcoord(LMoods[i][4]);
			
		}
		
		var boxId = "mcht";
		var boxStartX = svgboxstartxcoord(LMoods[i][4]);
		var boxWidth = (EL / 1000)/90;
		var boxFill = mclr(LMoods[i][1]);
	
		if(boxStartX<0){
		
			if(boxStart>0){
			
				drawbox(boxId, 0, boxStart, boxFill);
			
			}
		
		}
	
		if(boxWidth>0){
		
			drawbox(boxId, boxStartX, boxWidth, boxFill);

		}
		
		//end edur calc
		
		if(LMoods[i][4] > minDate){
		
		text += "<tr><td>" +
		"<input type=button  value=+ class=slnk onclick=MPost('"+ LMoods[i][1] + "','" + LMoods[i][0] + "','" + i+"') + />" 
		+ "</td><td>" 
		+ "<input type=button  value=- class=slnk onclick=delMood("+i+") + />" 
		+ "</td><td>" 
		+ LMoods[i][3].substring(0,5) 
		+ "</td><td>" 
		+ LMoods[i][3].substring(6) 
		+ "</td><td>" 
		+ LMoods[i][1] 
		+"</td><td>" 
		+ LMoods[i][2] 
		+ "</td><td>" 
		+ EDur 
		+ "</td></tr>";
		
		}
		
	}
	
	text += "</table>";

	svgtext('mcht');
	document.getElementById("moodtbl").innerHTML = text;
	
	var a = LMoods[0][1];
	
	$( "#dm" ).html(a);
	
}

function CheckLEvents(){

	//TO BE BUILT TO CHECK EVENTS
	
	let missingEvents = [];

	LEvents.sort();
	
	LEvents.reverse();
	
	ELen = LEvents.length;
	
	SLen = srvevents[0].length;
	
	//confirm local events are in server
	
	for (i = 0; i < ELen; i++) {
	
		let varLocal = FixTime(LEvents[i][0]);
		let svrList = srvevents[0];
		
if(svrList.includes(varLocal[3])==true){
			
		}else{
		
			missingEvents.push(LEvents[i]);
			
		}
	
	}

	let MLen = missingEvents.length;
	
	if(MLen>0){
	
		text = "<table>";
	
		text += "<th></th><th></th><th>Date</th><th>Time</th><th>Act</th><th>Cont</th><th></th>";

		for (i = 0; i < MLen; i++) {
	
			text += "<tr><td>" +
			
			"<input type=button  value=+ class=slnk onclick='JQPost(`"+ missingEvents[i][1] + "`,`" + missingEvents[i][2] + "`,`" + missingEvents[i][0] + "`,`" + i+"`)'/>" + 
		
			"</td><td>" 
			+ missingEvents[i][5].substring(0,5) 
			+ "</td><td>" 
			+ missingEvents[i][5].substring(6) 			
			+ "</td><td>" 
			+ missingEvents[i][3] 
			+ "</td><td>" 
			+ missingEvents[i][2] 
			+ "</td><td>" 
			+ missingEvents[i][4] 
			+ "</td></tr>";
	
	}
	
	text += "</table>";

				document.getElementById("elog").innerHTML = text;
	
	alert("Conflicts Found!");
	
	return;
}

LEvents =[];

for (i = 0; i < SLen; i++) {

	let srvtime = FixTime(srvevents[0][i]);

	LEvents.push([srvtime[0], srvevents[1][i], srvevents[2][i], srvevents[3][i], "N", srvtime[2], srvtime[1]]);
}

displayLEvents();

alert("Sync Done");
}


function displayLEvents(){

	resetSVG('echt');

	var arrchart = [];

	LEvents.sort();
	
	LEvents.reverse();
	
	ELen = LEvents.length;
	
	let selMinDate = $("#selMinDate").val();
	
	var minDate = Date.now()-(selMinDate*24*60*60*1000);
	
	let selMaxDate = $("#selMaxDate").val();
	
	let maxDate = Date.now()-(selMaxDate*24*60*60*1000);
	
	text = "<table>";
	
	text += "<th></th><th></th><th></th><th>Date</th><th>Time</th><th>Act</th><th>Cont</th><th></th><th>Dur</th>";

	for (i = 0; i < ELen; i++) {
	
		if(i==0){
			
			var EL = Date.now()-LEvents[i][6];
			
		}else{
		
			EL = LEvents[i-1][6]-LEvents[i][6];
		
		}
		
		fmtime(EL);
		
		if(i>0){
		
			var at = svgboxstartxcoord(LEvents[i-1][6]);
			
			
		}else{
		
			var at = svgboxstartxcoord(LEvents[i][6]);
			
		}
		
		var ac0 = "echt";
		var ac1 = svgboxstartxcoord(LEvents[i][6]);
		var ac2 = (EL / 1000)/90;
		var ac3 = faclr(LEvents[i][1]);
		
		if(ac1<0){
		
			if(at>0){
			
				drawbox(ac0, 0, at, ac3);
			
			}
		
		}
		
		if(ac1>0){
		
			drawbox(ac0, ac1, ac2, ac3);

		}
	
		//end edur calc
		
		if(LEvents[i][6] > minDate && LEvents[i][6] <= maxDate){
		
		text += "<tr><td>" +
		"<input type=button  value=+ class=slnk onclick='JQPost(`"+ LEvents[i][1] + "`,`" + LEvents[i][2] + "`,`" + LEvents[i][0] + "`,`" + i+"`)'/>" + 
		
		"</td><td>" 
		
		+ 
		
		"<input type=button value=- class=slnk onclick='delEvent("+i+")' />" 
		
		+ 
		
		"</td><td>" 
		
		+ 
		
		"<input type=button class=slnk value=U onclick='UpdateEvent(`"+ i + "`)' />"
		
		+
		
		"</td><td>" 
		
		+ 
		
		LEvents[i][5].substring(0,5) + 
		"</td><td>" + 
		LEvents[i][5].substring(6) + 
		"</td><td>" + 
		LEvents[i][3] +
		"</td><td>" + 
		LEvents[i][2] + 
		"</td><td>" + 
		LEvents[i][4] + 
		"</td><td>" + 
		EDur + 
		"</td></tr>";
	
		}
	
	}
	
	text += "</table>";

	document.getElementById("demo").innerHTML = text;
	
	svgtext('echt')
	
}

function delEvent(i){
	
	var q = "Delete "+LEvents[i][5]+": "+LEvents[i][3]+"?";

	var c = confirm(q);
	
	if (c == true){
	
		var etime = sqTime(LEvents[i][0]);
	
		var a = LEvents.splice(i, 1);
	
		JQDel(etime, 'tblEvents', 'StartTime');
		
		resetAll();
	
	}
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


function MPost(mood, dtime, i){

    $.post("../add/AddJQ.php",
    {
        v1: dtime,
        v2: mood,
        selTbl: 'tblMood'
    });
    
    resetAll();
    
}

function JQPost(act, cont, dtime, i){

    $.post("../add/AddJQ.php",
    {
        v1: act,
        v2: cont,
        v3: dtime,
        SD: 'L',
        selTbl: 'tblEvents'
	});
    
    resetAll();
}

function resetLEvents(){

	if(LEvents === undefined || LEvents.length == 0) {
    
    	//do nothing
    
	}else{

		localStorage.setItem("LSEvents", JSON.stringify(LEvents));
		
		displayLEvents();
		
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

function TimeArr(){
	
	var MTime = new Date();
	
	MTime = MTime.getTime();
	
	var vTZ = $( "#selTZ" ).val();
	
	var AM = parseInt(vTZ)*60*60*1000;
	
	MTime = MTime+AM;
	
	var m =  new Date(MTime);
	
	var FT = m.getTime();
	
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
	
	var NDTime= Y+'-'+M +'-'+ D +'T'+ H +':'+ Mn + ':' + Sec;
	
	var ShTime = M +'-'+ D +' '+ hr +':'+ Mn + ':' + Sec + ' ' + AP;
	
	var arrTime = [NDTime, FT, ShTime];

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
	
	var FT = m.getTime();

	var NDTime = Y+'-'+M +'-'+ D +'T'+ H +':'+ Mn + ':' + S;
	
	var ShTime = M +'-'+ D +' '+ hr +':'+ Mn + ':' + S + ' ' + AP;
	
	var SvrTime = Y+'-'+M +'-'+ D +' '+ H +':'+ Mn + ':' + S;

	var arrTime = [NDTime, FT, ShTime, SvrTime];

	return arrTime;

}

function GPost(){

	ELen = LEvents.length;
	MLen = LMoods.length;

	for (var i=0; i<ELen; i++) {

		var tvar = LEvents[i][0];
		var act = LEvents[i][1];
		var cont = LEvents[i][2];
	
		JQPost(act, cont, tvar, i);
      
	}

	for (var i=0; i<MLen; i++) {

		var dtime = LMoods[i][0];
		var mood = LMoods[i][1];
	
		MPost(mood, dtime, i);
	}
}

function setTime(){
	
	var T = TimeArr();
	
	$( "#selP" ) . val("N");
	
	$( "#pm" ) . text("");
	
	$( "#selDT" ) . val(T[0]);
	
	$( "#selDT" ) . text(T[2]);
	
	bclr("black");	
}

function AddTime(min){
	$( "#selP" ) . val("Y");
	
	$( "#pm" ) . text("P!");
	
	bclr("DarkRed");
	
	var CTime = $( "#selDT" ) . val();
	
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
	
	var FT = m.getTime();

	var NDTime = Y+'-'+M +'-'+ D +'T'+ H +':'+ Mn + ':' + '00';
	
	var ShTime = M +'-'+ D +' '+ hr +':'+ Mn + ':' + '00' + ' ' + AP;
	
	$( "#selFT" ) . val(FT);
	$( "#selDT" ) . val(NDTime);
	$( "#selDT" ) . text(ShTime);	
}

function displayList(arr){

	S = arr. length;
	
	L = arr[0].length;
	
	text = "<table>";
	
	for (i = 0; i < L; i++) {
		
		text += "<tr>";
		
		for (j = 0; j < S; j++){
		
			text += "<td>" + arr[j][i] + "</td>";
			
		}
		
		text += "</tr>";
	
	}
	
	text += "</table>";
	document.getElementById("olist").innerHTML = text;
}

function ebtnjql(act, cont, bname, tbl, vrow, vcol, warn){
	
	let tname = tbl;

	let w = warn;
	
	let arrelpTime = findLast(act, cont);

	let elpTime = arrelpTime[0];

	let wTime = arrelpTime[1];
	
	var bc = $( "button" ).length;
	
	var btnid = "btn"+bc;
	
    var btn = document.createElement("BUTTON");
	
    btn.id = btnid;
	
	btn.setAttribute('data-act', act);
	
	btn.setAttribute('data-cont', cont);
	
	btn.setAttribute('data-warn', warn);
	
    var t = document.createTextNode(bname);
    
    var u = document.createTextNode(elpTime);
    
    btn.appendChild(t);

    btn.appendChild(document.createElement("br"));
    
    btn.appendChild(u);
    
    var tbl = document.getElementById(tbl);
    
    let trlen = tbl.rows.length;
    
    let cprow = 6;
    
    if(vrow == "n"){
    		
    		if(trlen==0){
    
    			vrow = tbl.insertRow();
    		
    		}else{
    		
    			trlen--;
    		
    			vrow = tbl.rows[trlen];
    			
    			let rlen =vrow.cells.length;
    			
    			if(rlen>=cprow){
    			
    				vrow = tbl.insertRow();
    				
    			}
    			
    		}
    		
    		vcol = vrow.insertCell();
    		
    		vcol.appendChild(btn);
    
    }else{
    
    		tbl = tbl.rows[vrow].cells;
    
    		tbl[vcol].appendChild(btn);
    
    }
    

    if (w!="n"){

    	if(w < wTime){

			document.getElementById(btnid).style.backgroundColor="red";    
		
		}
	}

    document.getElementById(btnid). addEventListener("click", function(){
    
    	btnJQL(act, cont, btnid, bname);
  
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
								buttons[i].style.backgroundColor="red";    
		
				}
			}
 
 		}
 
 	}
}

function runaddCells() {

	//set LV ??? to 0
	LV=0;

	//declare key ???
	var key;
	
	//decalre ckey ???
	var ckey;
	
	//run emptyps ???
	emptyps();

	//run function to add manual buttons to the sheet (argument ???)
	addCells(LPU);	
}

function cncladdCells(){

	LV=null;
	key=null;
	var ckey;
	
	$("#etbl").empty();
	
	emptyps();
}

function addCells(arr){

	//determines if the post functions used later should be active [OUT OF PLACE]
	var selPost = $("#selPost").val();

	//empty div that contains dynamic buttons
	$("#etbl").empty();

	//get value from pu: indicates if the  entry will be past event
	var U = $("#pu").val();

	//get the size of the first col of the array passed as an argument
	var L = arr[0].length;

	//get the number of cols in the array passed as an argument
	var aSize = arr.length;
 
 	//create an empty array to place contents of array passed to formula
	var narr=[];

	//loop from 0 to the number of cols above
	for(j = 0; j < aSize; j++){

		//add empty col to the empty array
		narr.push([]);

	}

	//checks if the value of the LV variable is a value other than 0.  if it is, this block is executed
	if(LV!=0){
		
		//#ROW LOOP: loops from 0 to the size of the first col of the array (value of L)
		for(i = 0; i < L; i++){
      
			//checks if the key variable ??? is included in each element of the 3rd col of the array passed to the function
			if(arr[2][i].includes(key)==true){
		
				//#COL LOOP: loops from 0 to the number of cols in the array
				for(j = 0; j < aSize; j++){

					//Adds the value in each cell, COL j / ROW i, to the new array
					var p = arr[j][i];
			
					narr[j].push(p);
					
					//end COL LOOP
        			}

			//end if
			} 

		//end ROW LOOP
		}
  	
	//end LV if
  	}else{
		
		//if no LV is provided, new array is set to the array passed to the function
		narr=arr;

	//end ELSE
	}

	//selects the event table
	var table = document.getElementById("etbl");

	//gets the length of the new array
	var L = narr[0].length;

	//sets the number of buttons
	var rbtns = 6;

	//determines the number of rows that will be needed 
	var rnum = Math.floor(L/rbtns);

	//determines the numbers of buttons in the last row
	var lrbtns = (L%rbtns);

	//sets button counters to 0
	var bcnt = 0;

	//block executed when more than 1 row is needed
	if(rnum>0){

	//block executed for each row needed [r represents the index of the row]
		for (r = 0; r < rnum; r++) {

	//adds a row to the table [currently hard-coded as "etbl" above]
			var row = table.insertRow(r);

	//block executed for each button in each row
			for (c = 0; c < rbtns; c++){

				//sets a variable to the current button count by multiplying the row index [r] by the number of buttons in each row [rbtns] and adding the position in the current row [c]
				var bcnt = (r*rbtns)+c;

				//sets a variable to the 2nd element in the provided array for the index
				var bt = narr[1][bcnt];

				//sets a variable to the 1st element in the provided array for the index
				var bv = narr[0][bcnt];

				//inserts a cell to the current row
				var cell = row.insertCell(c);

				//sets a variable to the total number of buttons on the page
				var bc = $( "button" ).length;

				//uses the number of buttons to create a new button id
				var btnid = "btn"+bc;

				//creates a new button element
				var btn = document.createElement("BUTTON");

				//assigns the id created above to the new button 
				btn.id = btnid;

				//creates a text node based on the second element in the supplied array
				var t = document.createTextNode(bt);

				//adds the text node to the new button
				btn.appendChild(t);

				//adds a value to the button based on the first element of the array
				btn.value = bv;

				//appends the button to the newly created cell
				cell.appendChild(btn);
				
				//adds a function to the button 
				document.getElementById(btnid). addEventListener("click", function(){

					var cs = this.value;

					var cv = this.innerHTML;

					$("#etbl").empty();

					switch(LV){

						case 0:

							$("#csel").text(cs);

							key=cs;

							ckey=cs;

							LV++;

							addCells(LProj);

							break;

						case 1:

							$("#psel").text(cs);

							key=cs;

							LV++;

							addCells(LConts);

							break;

						case 2:

							$("#spsel").text(cs)

							key=ckey;

							LV++;

							addCells(LActs);

							break;

						case 3:

							$("#asel").text(cs);

							var cont = $("#spsel").text();

							var act = cs;

							var a2 = cv;

							LV=0;

							$("#etbl").empty();

							setETime();

							if(U!="U"){

								LEvents.push([tmv, act, cont, a2, 'N', tmt, ft]);
								
								if(selPost==="Y"){
								
								JQPost(act, cont, tmv);
								
								}
								
								resetAll();

							}else{

								LEvents[eid]=([etmv, act, cont, a2, 'N', etmt, eft]);
								
										if(selPost==="Y"){
			
			var etmv1 = sqTime(etmv);
		
			JQUpdate(act, cont, etmv1);
			
		}
								
								resetAll();

							}

							$("#pmEvent").empty();
				
							$("#pu").text("");
				
							$("#pu").val("");

							emptyps();

							resetAll();
							
							break;
	        		}
      			});
   			}
  		}
	}
    
    //LAST ROW
    
    if(lrbtns>0){
    
    	if(rnum==0){
    
    		lrbtns--;
    
    	}

		var row = table.insertRow();

		for (c = 0; c <= lrbtns; c++){

			var lbcnt = bcnt+c;

			var bt = narr[1][lbcnt];

			var bv = narr[0][lbcnt];

			var cell= row.insertCell(c);

			var bc = $( "button" ).length;

			var btnid = "btn"+bc;

			var btn = document.createElement("BUTTON");

			btn.id = btnid;

			var t = document.createTextNode(bt);

			btn.appendChild(t);

			btn.value = bv;

			cell.appendChild(btn);
			document.getElementById(btnid). addEventListener("click", function(){

 				var cs = this.value;

				var cv = this.innerHTML;

				$("#etbl").empty();

				switch(LV){

					case 0:

						$("#csel").text(cs);

						key=cs;

						ckey=cs;

						LV++;

						addCells(LProj);

						break;

					case 1:

						$("#psel").text(cs);

						key=cs;

						LV++;

						addCells(LConts);

						break;

					case 2:

						$("#spsel").text(cs)

						key=ckey;

						LV++;

						addCells(LActs);

						break;

					case 3:

						$("#asel").text(cs);

						var cont = $("#spsel").text();

						var act = cs;

						var a2 = cv;

						LV=0;

						$("#etbl").empty();

						setETime();

						if(U!="U"){

							LEvents.push([tmv, act, cont, a2, 'N', tmt, ft]);
							
							if(selPost==="Y"){
							
							JQPost(act, cont, tmv);

							}

						}else{

							LEvents[eid]=([etmv, act, cont, a2, 'N', etmt, eft]);

		if(selPost==="Y"){
			
			var etmv1 = sqTime(etmv);
		
			JQUpdate(act, cont, etmv1);
			
		}

		$("#pmEvent").empty();

		$("#pu").text("");

		$("#pu").val("");

						}

						emptyps();
						
						resetAll();

						break;

				}

        	});
      	}

    }
}


function setETime(){

	var T = TimeArr();
	
	var PE = $( "#selP" ) . val();
	
	if(PE=="Y"){
	
		tmv = $( "#selDT" ) . val();
		tmt = $( "#selDT" ) . text();
		ft = $( "#selFT" ) . val();
		
	}else{
	
		tmv = T[0];
		ft = T[1];
		tmt = T[2];
	}
}

//uses the prior event to create a new event record

function PriorEvent(){

	var selPost = $("#selPost").val();

	var act = LEvents[1][1];
	var cont = LEvents[1][2];
	var A2 = LEvents[1][3];
	
	setETime();
	
	LEvents.push([tmv, act, cont, A2, 'N', tmt, ft]);
	
	if(selPost==="Y"){
							
		JQPost(act, cont, tmv);
		
	}

	resetAll();
	
	setTimeout(bclr("Orange"), 1000);
	
	bclr("black");
}

//updates the contents of a record in the events table

function UpdateEvent(id){

	var q = "Update: "+LEvents[id][5]+" - "+LEvents[id][3];

	$("#pmEvent").val(id);
	$("#pmEvent").text(q);
	
	$("#pu").val("U");
	
	etmv = LEvents[id][0];
	etmt = LEvents[id][5];
	eft = LEvents[id][6];
	
	eid = id;
	
	resetAll();
}

function clearForm(){

	$("#pmEvent").empty();

	$("#pu"). text("");
	$("#pu"). val("");
	
	cncladdCells();
	
	setTime();
}

//sets the background color

function bclr(clr){

	$("body").css("background-color", clr);
	
}

//determines the color of each box on the event chart

function faclr(act){
	
	var arrAct = LActs[0];
		
	var ans = $.inArray(act, arrAct);
	
	var PU = LActs[3][ans];
	
	var arrLPU = LPU[0];
	
	var an2 = $.inArray(PU, arrLPU);
	
	var clr = LPU[2][an2];
	
	return clr;
}

//sets the colors for the boxes in the mood chart

function mclr(mood){

	switch(mood){
	
		case -1:
			clr = "red";
			break;
		case -0.5:
			clr = "yellow";
			break;
		case 0:
			clr = "gray";
			break;
		case 0.5:
			clr = "yellowgreen";
			break;
		case 1:
			clr = "green";
			break;
	}

	return clr;
}

//determines the starting x coord of each colored box in the svg charts

function svgboxstartxcoord(time){

	let minTime = new Date();
	minTime.setHours(0, 0, 0, 0);
	
	var svgboxstartxcoord = ((time-minTime)/1000)/90;
	
	return svgboxstartxcoord;
}

//Draws colored boxes in svg charts

function drawbox(id, x, w, f){

	var element = document.getElementById(id);

	var svg = document.createElementNS("http://www.w3.org/2000/svg", "rect");

	svg.setAttribute('x', x);
	svg.setAttribute('y', 0);
	svg.setAttribute('width', w);
	svg.setAttribute('height', 50);
	svg.setAttribute('fill', f);
	    
	svg.setAttributeNS("http://www.w3.org/2000/xmlns/", "xmlns:xlink", "http://www.w3.org/1999/xlink");
	    
	element.appendChild(svg);
}

//Adds times to foreground of svg charts

function svgtext(id){

	var element = document.getElementById(id);

	var svg = document.createElementNS("http://www.w3.org/2000/svg", "text");

	svg.setAttribute('x', 0);
	svg.setAttribute('y', 27.5);
	svg.setAttribute('fill', 'white');
	svg.setAttribute('font-weight', 'bold');
	svg.setAttribute('font-size', 10);

	var txt = document.createTextNode("12A");

	svg.appendChild(txt);

	var arrTimes = ["12A", "3A", "6A", "9A", "12P", "3P", "6P", "9P"];

	for (c = 1; c <= 7; c++){

	var xv = c*120;

	var ts = document.createElementNS("http://www.w3.org/2000/svg", "tspan");

	ts.setAttribute('x', xv);
	ts.setAttribute('y', 27.5);

	var txt = document.createTextNode(arrTimes[c]);
	ts.appendChild(txt);
	svg.appendChild(ts);

	}

	svg.setAttributeNS("http://www.w3.org/2000/xmlns/", "xmlns:xlink", "http://www.w3.org/1999/xlink");

	element.appendChild(svg);
}

//expands section of form

function exsec(cls){
	
	cls = "."+cls;

	$(cls).toggle();
}

function resetSVG(id){
	
	id = "#"+id;
	
	$(id).empty();
}

function resetAll(){

	resetTime();
	
	resetLEvents();
	
	resetLMoods();
	
	resetbtn();
}

function JQUpdate(act, cont, etime){

	$.post("../update/UpdateJQ.php",
	{
		v1: act,
		v2: cont,
		v3: etime,
		selTbl: 'tblEvents'
	});
}


//USED IN FUNCTIONS: delEvent(l#1010) and delMood (l#1029)
function JQDel(etime, tbl, index){

 $.post("./timedb/del/DelJQ.php",
    {
        v1: etime,
        c1: index,
        selTbl: tbl
	});
}

//USED IN MULTIPLE TIME FUNCTIONS
function sqTime(etmv){

	var p1 = etmv.substr(0,10);
			
	var p2 = etmv.substr(11);
			
	var etmv1 = (p1 + " " + p2);

	return etmv1;
}

//USED IN ALL TIME FUNCTIONS
function zerofix(timeval){

	if(timeval<10){

		ntimeval = "0"+timeval;
	
	}else{
	
	ntimeval = timeval;
	
	}
	
	return ntimeval;
}

function tfct(){

	alert("test");
}


//USED IN FUNCTIONS: ebtnjql(#1344) & resetbtn(l#1419)
function findLast(actid, contid){
	
	LEvents.sort();
	
	LEvents.reverse();
	
	ELen = LEvents.length;

	for (j = 0; j < ELen; j++) {
	
		if(LEvents[j][1]==actid){
		
			if(LEvents[j][2]==contid){
					
				var ESecs = Math.round((Date.now()-LEvents[j][6]) / 1000);
					
				var STime = ELTime(ESecs);

				let arrFL = [STime, ESecs];

				return(arrFL);
				
			}
		}
	}
	
	LUlen = lastuse[0].length;
	
	for (j = 0; j < LUlen; j++) {

		if(lastuse[0][j]==actid){
		
			if(lastuse[1][j]==contid){
					
				var ESecs = lastuse[2][j];
					
				var STime = ELTime(ESecs);

				let arrFL = [STime, ESecs];

				return(arrFL);
				
			}
		}
	}
	
	let arrFL = ["N/A", 0];

	return(arrFL);
}

//USED IN FUNCTION:  findLast 
function ELTime(secs) {
	
	var days = secs / (60*60*24);
		
	if(days>=1){
		
		return Math.round(days) + "d";
		
	}else{
		
	var hrs = secs / (60*60);
			
	if(hrs>=1){
				
		return Math.round(hrs) + "h";
					
	}else{
				
	var mins = secs / 60;
					
	if(mins>=1){
						
		return Math.round(mins) + "m";
					
	}else{
					
		return secs + "s";
	}
	}
	}
}


//NOT USED
function tbltest(){

	var ele = document.getElementById("tblbtn");
	
	var tlen = ele.rows.length;
	
	alert(tlen+" rows in tblbtn");
	
	alert(ele.rows[2].cells[2].innerHTML);
}


//NOT USED
function testlog(text){

	let objTL = document.createElement("LI");

	let tline = document.createTextNode(text);
	
	objTL.appendChild(tline);

	let e = document.getElementById("elog");
	
	e.appendChild(objTL);
}



function displayActDurs(){

	let arr1 = [];
	
	let arr2 = [];

	LEvents.sort();
	
	LEvents.reverse();
	
	ELen = LEvents.length;
	
	var minDate = Date.now()-(2*24*60*60*1000);
	
	text = "<table>";
	
	text += "<th>Act</th><th>Dur</th>";

	for (i = 0; i < ELen; i++) {
	
		if(i==0){
			
			var EL = Date.now()-LEvents[i][6];
			
		}else{
		
			EL = LEvents[i-1][6]-LEvents[i][6];
		
		}
		
		//fmtime(EL);
		
		if(LEvents[i][6] > minDate){

			arr1.push([LEvents[i][3], EL]);
		
		}
	
	}
	
	arr1.sort();
	
	ELen = arr1.length;
	
	for (i = 0; i < ELen; i++) {
	
		if(i==0){
		
			arr2.push(arr1[i]);
			
		}else if(arr1[i][0]==arr1[i-1][0]){
		
			//arr2[i-1][1]=arr2[i-1][1]+arr2[i][1];
			
		}else{
		
			arr2.push(arr1[i]);
			
		}
	 	 
	}
	
document.getElementById("elog").innerHTML = arr2;

}