<!DOCTYPE html>
<html lang='en'>
	<head>
		<title>Events</title>
		<?php 
			
			$conn = mysqli_connect('localhost', 'root', '1234567a', 'tdb');

			date_default_timezone_set('America/New_York');
		
			$QTime = date('Y-m-d');
			$NowTime = date("Y-m-d H:i:s");
			
			$dataStartDate = date( "Y-m-d", strtotime( "$QTime -30 day" ) );
			
			$sql_events = "SELECT tblEvents.StartTime, tblEvents.STime, tblEvents.ActID, tblEvents.ProID, tblAct.ActDesc 
				FROM tblEvents
				INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID
				INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID 
				WHERE date(tblEvents.STime) >='$dataStartDate' 
				ORDER BY Stime DESC";
				

			$result_events = mysqli_query($conn, $sql_events);

			$arr_events1 = array();
			
			while ($row = mysqli_fetch_array($result_events)) {

				$arr_events1[0][] = $row['STime'];
				$arr_events1[1][] = $row['ActID'];
				$arr_events1[2][] = $row['ProID'];
				$arr_events1[3][] = $row['ActDesc'];
				
			}

			$arr_events = array();
			
			$row_cnt = mysqli_num_rows($result_events);
			
			for ($x = 0; $x < $row_cnt; $x++) {
			
				for ($y=0; $y <= 3; $y++) {
				
					$arr_events[$x][$y] = $arr_events1[$y][$x];
				
				}
			}
			
			//Create list of last time each act/cont type was used

			$arr_lastuse = array();

			//pulls every event in db and displays the last time each was used.

			$sql_lastuse = "SELECT tblEvents.ActID, tblEvents.ProID, TIMESTAMPDIFF (SECOND, MAX(STime), NOW()) AS LTime, MAX(STime) AS DBLTime
				FROM tblEvents 
				INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID 
				INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID 
				INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID 
				WHERE tblCont.Active!='N' AND tblProj.ProjStatus!='Closed'  
				GROUP BY tblAct.ActID, tblCont.ContID 
				ORDER BY ActID, ContID";

			$result_lastuse = mysqli_query($conn, $sql_lastuse);

			while ($row = mysqli_fetch_array($result_lastuse)) {
				$arr_lastuse[0][] = $row['ActID'];
				$arr_lastuse[1][] = $row['ProID'];
				$arr_lastuse[2][] = $row['LTime'];
				$arr_lastuse[3][] = $row['DBLTime'];
			}
			
			//list of mood records from server 
			
			$arr_moods1 = array();
			
			$sql_moods = "SELECT MoodDT, Mood 
				FROM tblMood 
				WHERE date(MoodDT) >='$dataStartDate' 
				ORDER BY MoodDT DESC";
				
			$result_moods = mysqli_query($conn, $sql_moods); 
			
			while ($row = mysqli_fetch_array($result_moods)) {

				$arr_moods1[0][] = $row['MoodDT'];
				$arr_moods1[1][] = $row['Mood'];
			
			}
			
			$row_cnt = mysqli_num_rows($result_moods);

			$arr_moods = array();
			
			$row_cnt = mysqli_num_rows($result_moods);
			
			for ($x = 0; $x < $row_cnt; $x++) {
			
				for ($y=0; $y <= 1; $y++) {
				
					$arr_moods[$x][$y] = $arr_moods1[$y][$x];
				
				}
			}

			//Create list of active activities

			$arr_act = array();

			$sql_act = "SELECT *
				FROM tblAct 
				WHERE Status!='Inactive' 
				ORDER BY ActID";

			$result_act = mysqli_query($conn, $sql_act); 

			while ($row = mysqli_fetch_array($result_act)) {

				$arr_act[0][] = $row['ActID'];
				$arr_act[1][] = $row['ActDesc'];
				$arr_act[2][] = $row['PCode'];
				$arr_act[3][] = $row['UCode'];
			}
			
			//Create list of all activities
			$arr_act_all = array();
			
			$sql_act_all = "SELECT *
				FROM tblAct 
				ORDER BY ActID";

			$result_act_all = mysqli_query($conn, $sql_act_all); 
			
			while ($row = mysqli_fetch_array($result_act_all)) {

				$arr_act_all[0][] = $row['ActID'];
				$arr_act_all[1][] = $row['ActDesc'];
				$arr_act_all[2][] = $row['PCode'];
				$arr_act_all[3][] = $row['UCode'];
				$arr_act_all[6][] = $row['Status'];
				
			}
			
			//Create list of active sub-activities

			$arr_cont = array();

			$sql_cont = "SELECT tblCont.ProjID, tblCont.ContID, tblCont.ContDesc, tblCont.Active, tblProj.ProjStatus 
				FROM tblCont 
				INNER JOIN tblProj ON tblCont.ProjID=tblProj.ProjID 
				WHERE tblProj.ProjStatus!='Closed' AND tblCont.Active!='N' 
				ORDER BY ProjID, ContID";

			$result_cont = mysqli_query($conn, $sql_cont);

			while ($row = mysqli_fetch_array($result_cont)) {

				$arr_cont[0][] = $row['ContID'];
				$arr_cont[1][] = $row['ContDesc'];
				$arr_cont[2][] = $row['ProjID'];
			}
			
			//Create list of all sub-activities

			$arr_cont_all = array();

			$sql_cont_all = "SELECT tblCont.ProjID, tblCont.ContID, tblCont.ContDesc, tblCont.Active, tblProj.ProjStatus 
				FROM tblCont 
				INNER JOIN tblProj ON tblCont.ProjID=tblProj.ProjID 
				ORDER BY ProjID, ContID";

			$result_cont_all = mysqli_query($conn, $sql_cont_all);

			while ($row = mysqli_fetch_array($result_cont_all)) {

				$arr_cont_all[0][] = $row['ContID'];
				$arr_cont_all[1][] = $row['ContDesc'];
				$arr_cont_all[2][] = $row['ProjID'];
				$arr_cont_all[3][] = $row['Active'];
			}

			//Create list of active projects

			$arr_proj = array();

			$sql_proj = "SELECT * 
				FROM tblProj 
				WHERE ProjStatus!='Closed' 
				ORDER BY ProjID";

			$result_proj = mysqli_query($conn, $sql_proj);

			while ($row = mysqli_fetch_array($result_proj)) {

				$arr_proj[0][] = $row['ProjID'];
				$arr_proj[1][] = $row['ProjDesc'];
				$arr_proj[2][] = $row['PCode'];
			}
			
			//Create list of all projects

			$arr_proj_all = array();

			$sql_proj_all = "SELECT * 
				FROM tblProj 
				ORDER BY ProjID";

			$result_proj_all = mysqli_query($conn, $sql_proj_all);

			while ($row = mysqli_fetch_array($result_proj_all)) {

				$arr_proj_all[0][] = $row['ProjID'];
				$arr_proj_all[1][] = $row['ProjDesc'];
				$arr_proj_all[2][] = $row['PCode'];
				$arr_proj_all[3][] = $row['ProjStatus'];
			}

			//Create list of PLSU Codes

			$arr_pu = array();

			$sql_pu = "SELECT * 
				FROM tblPUCodes 
				ORDER BY PUCode";

			$result_pu = mysqli_query($conn, $sql_pu);

			while ($row = mysqli_fetch_array($result_pu)) {

				$arr_pu[0][] = $row['PUCode'];
				$arr_pu[1][] = $row['PUCodeDesc'];
				$arr_pu[2][] = $row['Color'];
				$arr_pu[3][] = $row['Active'];
			}
			
			//create list of local button groups

			$arr_lbg = array();

			$sql_lbg = "SELECT *
				FROM tbllocalbtngroups
				ORDER BY btnGroupName";

			$result_lbg = mysqli_query($conn, $sql_lbg);
		
			while ($row = mysqli_fetch_array($result_lbg)) {

				$arr_lbg[0][] = $row['btnGroup'];
				$arr_lbg[1][] = $row['btnGroupName'];

			}			

			//create list of local buttons

			$arr_lb = array();

			$sql_lb = "SELECT *
				FROM tbllocaleventbtns";

			$result_lb = mysqli_query($conn, $sql_lb);
					
			while ($row = mysqli_fetch_array($result_lb)) {

				$arr_lb[0][] = $row['idtbllocaleventbtns'];
				$arr_lb[1][] = $row['actID'];
				$arr_lb[2][] = $row['contID'];
				$arr_lb[3][] = $row['localbtngroup'];
				$arr_lb[4][] = $row['warn'];

			}			

			mysqli_close($conn);

		?>

		<link href='https://fonts.googleapis.com/css?family=Homenaje' rel='stylesheet'>
		<link rel="stylesheet" href="styles.css">
		<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
		<script src="./scripts/manualEventScripts.js"></script>
		<script src="./scripts/timeScripts.js"></script>
		<script src="./scripts/modifyFormScripts.js"></script>
		<script src="./scripts/modifyMenu.js"></script>
		
		<!--
		
		<script src="./scripts/newDisplayEvents.js"></script> 
		<script src="./scripts/displayEvents.js"></script> 
		
		-->
		
		<script src="./scripts/newDisplayEvents.js"></script> > 
		
		<script src="./scripts/localEventButtons.js"></script>
		<script src="./scripts/svgChart.js"></script>
		<script src="./scripts/mood.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/luxon@3.3.0/build/global/luxon.min.js" integrity="sha256-Nn+JGDrq3PuTxcDfJmmI0Srj5LpfOFlKqEiPwQK7y40=" crossorigin="anonymous"></script>
		<script src="./scripts/actDuration.js"></script>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
	</head>
	<body>
		<div id="pageWrapper">
		<header>
			<h1>Events</h1>
			<sub>v_2023-03-31</sub>
		</header>
		<div id="topbar">
			<ul class="controlGrid" id="formControls">
				<li>
					<a href="#" onclick="clearForm()">Reset</a>
				</li>	
				<li id="lblEventTime">
					<p id="DateTime"></p>
				</li>
				<li>
					<a href="#" onclick="manualEventForm.btnLPU()">Manual</a>
				</li>
				<li>
					<a href="#" onclick="PriorEvent()">Prior</a>
				</li>
				<li>
					<a href="#" onclick="postAll()">Sync</a>
				</li>
				<li>
					<a href="#" onclick="displayModifyMenu()">Modify</a>
				</li>
				<li>
					<a href="#" onclick="AddTime(-1)">-1m</a> 
				</li>
				<li>
					<a href="#" onclick="AddTime(-5)">-5m</a>
				</li>
				<li>
					<a href="#" onclick="AddTime(-15)">-15m</a>
				</li>
				<li>
					<a href="#" onclick="AddTime(-60)">-1h</a>
				</li>
				<li>
					<a href="#" onclick="AddTime(-180)">-3h</a>
				</li>
				<li>
					<a href="#" onclick="AddTime(-360)">-6h</a>
				</li>
				<li>
					<a href="#" onclick="AddTime(-1440)">-1d</a>
				</li>
				<li>
					<a href="#" onclick="AddTime(1)">+1m</a>
				</li>
				<li>
					<a href="#" onclick="AddTime(5)">+5m</a>
				</li>
				<li>
					<a href="#" onclick="AddTime(15)">+15m</a>
				</li>
				<li>
					<a href="#" onclick="AddTime(60)">+1h</a>
				</li>
				<li>
					<a href="#" onclick="AddTime(180)">+3h</a>
				</li>
				<li>
					<a href="#" onclick="AddTime(360)">+6h</a>
				</li>
				<li>
					<a href="#" onclick="AddTime(1440)">+1d</a>
				</li>
				<li>
					<a href="#" onclick="btnLMood(-1)">-1</a>
				</li>
				<li>
					<a href="#" onclick="btnLMood(-0.5)">-0.5</a>
				</li>
				<li>
					<a href="#" onclick="btnLMood(0)">0</a>
				</li> 
				<li>
					<a href="#"onclick="btnLMood(0.5)">0.5</a>
				</li>
				<li>
					<a href="#" onclick="btnLMood(1)">1</a>
				</li> 
				<li><p id="moodIndicator">&#10033;</p></li>
				<li>	
					<a href="#"  onclick="$('.pageSettings').toggle()">Settings</a> </li>
				<li id="timeZoneLabel" class="pageSettings">
					<p>Time Zone</p>
				</li>
				<li  class="pageSettings">
					<p>Post?</p>
				</li>
				<li id="detailStartLabel"  class="pageSettings">
					<p>Detail Start (Days Ago)</p>
				</li>
				<li id="detailEndLabel"  class="pageSettings">
					<p>Detail End (Days Ago)</p>
				</li><li id="timeZoneSelectContainer"  class="pageSettings">
					<select id="selTZ" class="ssmselect">
						<option value=0>Eastern</option>
						<option value=1>Central</option>
						<option value=2>Mountain</option>
						<option value=3>Pacific</option>
						<option value=6>Hawaii</option>
					</select>
				</li>
				<li  class="pageSettings">
					<select id="selPost">
						<option>Y</option>
						<option>N</option>
					</select>
				</li>
				<li id="detailStartSelectContainer"  class="pageSettings">
					<select id="selMinDate" class="sTime">
						<option>2</option>
						<option>1</option>
						<option>2</option>
						<option>7</option>
						<option>14</option>
						<option>30</option>
					</select>
				</li>
				<li id="detailEndSelectContainer"  class="pageSettings">
					<select id="selMaxDate" class="sTime">
						<option>0</option>
						<option>1</option>
						<option>2</option>
						<option>7</option>
						<option>14</option>
						<option>30</option>
					</select>
				</li>
			</ul>
		</div>
		<div id="mainSection">
			<!-- displays U when an event is being updated -->
			<b><p id="pu"></p></b>
			
			<!-- shows if events are being posted to the db or not -->
			<p id="selP"></p>
			<p id="selFT"></p>
			<h2 id="pmEvent"></h2>
			
			<div id="modifyFormWrapper">
				<div id="modifyFormContainer"></div>
				<iframe id="modifyFormResult" name="modifyFormResult" class="hidden" scrolling="no"></iframe>
			</div>

			<ul id="eventBtnListContainer" class="btnGroup"></ul>

			<ul id="localBtnListContainer" class="btnGroup"></ul>
			
		</div>
		<div id="footer">
			<svg id="svgEventChart" height="30"></svg>

			<svg id="svgMoodChart" height="30"></svg>

			<div id="eventListContainer"></div>

			<div id="moodListContainer"></div>

			<div id="listContainer"></div>

			<p id="csel"></p>

			<p id="psel"></p>

			<p id="spsel"></p>

			<p id="asel"></p>

		</div>
		<script>
			//get background color from css
			const defaultBGColor = $( "body" ).css( "background-color" );
			const defaultBtnColor = $( "button" ).css( "color" );
			const defaultBtnBGColor = $( "button" ).css( "background-color" );
	
			const svgWidthNum = screen.width;

			const btnWidthNum = 110;

			let text, ELen, MoodsLen, i, datetimeValue, datetimeText, millisecTime, origTime, etmt, eft, eid;
			
			//set local storage variables
			let data_lastuse = <?php echo json_encode( $arr_lastuse ) ?>;
			
			localStorage.setItem("LSlastuse", JSON.stringify(data_lastuse))

			let lastUse = JSON.parse(localStorage.getItem("LSlastuse"))
			
			const objLastUse = {}
			
			for(i=0; i<lastUse[0].length; i++){

				objLastUse[lastUse[0][i]+"_"+lastUse[1][i]] = {actID: lastUse[0][i], contID: lastUse[1][i], elapsedSecs: lastUse[2][i], lastTime: luxon.DateTime.fromSQL(lastUse[3][i]).toSeconds()}

			}

			//Events

			let data_events = <?php echo json_encode( $arr_events ) ?>;

			localStorage.setItem("LSEvents", JSON.stringify(data_events));
			
			let LEvents = JSON.parse(localStorage.getItem("LSEvents"));
			
			const objLEvents = {}
			
			for(i=0; i<LEvents.length; i++) {
				
				objLEvents[LEvents[i][0]] = {startTime: Date.parse(LEvents[i][0]), act: LEvents[i][1], subProj: LEvents[i][2]}
				
			}
			
			//Moods
			
			let data_moods = <?php echo json_encode( $arr_moods ) ?>;
			
			localStorage.setItem("LSMoods", JSON.stringify(data_moods));

			let LMoods = JSON.parse(localStorage.getItem("LSMoods"));
			
			const objLMoods = {}
			
			for(i=0; i<LMoods.length; i++) {
			
				objLMoods[LMoods[i][0]] = { startTime: Date.parse(LMoods[i][0]), mood: LMoods[i][1]}
			
			}
			
			//Activities

			let data_acts = <?php echo json_encode( $arr_act ) ?>;
			
			localStorage.setItem("LSActs", JSON.stringify(data_acts));
			
			let LActs = JSON.parse(localStorage.getItem("LSActs"));
			
			let data_acts_all = <?php echo json_encode( $arr_act_all ) ?>;
			
			localStorage.setItem("LSActsAll", JSON.stringify(data_acts_all));
			
			let LActsAll = JSON.parse(localStorage.getItem("LSActsAll"));
			
			const objLAct = {}
			
			for(i=0; i<LActsAll[0].length; i++){

				objLAct[LActsAll[0][i]]={"ActID": LActsAll[0][i], "ActDesc": LActsAll[1][i], "PCode": LActsAll[2][i], "UCode": LActsAll[3][i], "Status": LActsAll[6][i]}
								
			}

			//Projects

			let data_proj = <?php echo json_encode( $arr_proj ) ?>;
			
			localStorage.setItem("LSProj", JSON.stringify(data_proj));
			
			let LProj = JSON.parse(localStorage.getItem("LSProj"));
			
			let data_proj_all = <?php echo json_encode( $arr_proj_all) ?>;
			
			localStorage.setItem("LSProjAll", JSON.stringify(data_proj_all));
			
			let LProjAll= JSON.parse(localStorage.getItem("LSProjAll"));
			
			const objLProj = {}
			
			for(i=0; i<LProjAll[0].length; i++){

				objLProj[LProjAll[0][i]]={"ProjID": LProjAll[0][i], "ProjDesc": LProjAll[1][i], "ProfileCode": LProjAll[2][i], "ProjStatus": LProjAll[3][i]}
								
			}
			
			//Sub-Projects
			
			let data_cont = <?php echo json_encode( $arr_cont ) ?>;
			
			localStorage.setItem("LSConts", JSON.stringify(data_cont));

			let LConts = JSON.parse(localStorage.getItem("LSConts"));
			
			let data_cont_all = <?php echo json_encode( $arr_cont_all ) ?>;
			
			localStorage.setItem("LSContAll", JSON.stringify(data_cont_all));
			
			let LContAll = JSON.parse(localStorage.getItem("LSContAll"));
			
			const objLCont = {}

			for(i=0; i<LContAll[0].length; i++){

				objLCont[LContAll[0][i]]={"ContID": LContAll[0][i], "ContDesc": LContAll[1][i], "ProjID": LContAll[2][i], "Active": LContAll[3][i]}

			}

			//Use Codes & Colors

			let data_pu = <?php echo json_encode( $arr_pu ) ?>;
				
			localStorage.setItem("LSPU", JSON.stringify(data_pu));
			
			let LPU = JSON.parse(localStorage.getItem("LSPU"));
			
			const objLPU = {}

			for(i=0; i<LPU[0].length; i++){

				objLPU[LPU[0][i]]={"PUCode": LPU[0][i], "PUCodeDesc": LPU[1][i], "Active": LPU[3][i], "Color": LPU[2][i]};
				
			}

			//local event button groups

			let data_lbg = <?php echo json_encode( $arr_lbg ) ?>
				 
			localStorage.setItem("LSlbg", JSON.stringify(data_lbg))

			let Llbg = JSON.parse(localStorage.getItem("LSlbg"))

			const objLocalButtonGroups = {}

			for(i=0; i<Llbg[0].length; i++){

				objLocalButtonGroups[Llbg[0][i]]={btnGroup: Llbg[0][i], btnGroupName: Llbg[1][i]}

			}

			//local event buttons
			
			let data_lb = <?php echo json_encode( $arr_lb ) ?>
				 
			localStorage.setItem("LSlb", JSON.stringify(data_lb))

			let Llb = JSON.parse(localStorage.getItem("LSlb"))

			const objLocalEventButtons = {}

			for(i=0; i<Llb[0].length; i++){

				objLocalEventButtons[Llb[0][i]]={idtbllocaleventbtns: Llb[0][i], actID: Llb[1][i], contid: Llb[2][i], localButtonGroup: Llb[3][i], warn: Llb[4][i]}

			}

			setTime();

			if(LEvents===null){

				LEvents = [];
			
			}else{

				displayLEvents();

			}

			if(LMoods===null){

				LMoods = [];
			
			}else{

				displayLMoods();

			}

			localEventButtonForm.makeLocalEventBtnGroup()

			function btnclr(){

				$("button").css("background-color", defaultBtnBGColor);
				
				$("button").css("color", defaultBtnColor);

				resetAll();
			}

			$(".sTime").change(function(){

				displayLEvents();
				
			});


			function delEvent(i){
				
				const q = "Delete "+LEvents[i][0]+": "+LEvents[i][3]+"?";

				const c = confirm(q);
				
				if (c == true){
				
					const etime = sqTime(LEvents[i][0])
				
					const a = LEvents.splice(i, 1)

					delete objLEvents[etime]
				
					JQDel(etime, 'tblEvents', 'StartTime')
					
					resetAll()
				
				}
			}

			function resetLEvents(){

				if(LEvents === undefined || LEvents.length == 0) {
				
					//do nothing
				
				}else{

					localStorage.setItem("LSEvents", JSON.stringify(LEvents));
					
					displayLEvents();
					
				}
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
				document.getElementById("listContainer").innerHTML = text;
			}

			//uses the prior event to create a new event record

			function PriorEvent(){

				const selPost = $("#selPost").val();

				const actValue = LEvents[1][1];
				const contValue = LEvents[1][2];
				const actText = LEvents[1][3];
				
				setETime();
				
				LEvents.push([sqTime(datetimeValue), actValue, contValue, actText]);
				
				if(selPost==="Y"){
										
					JQPost(actValue, contValue, datetimeValue);
					
				}

				resetAll();
				
			}

			//updates the contents of a record in the events table. 

			/*
			function UpdateEvent(id){

				$( "#pu" ).val( "U" );
				$( "#selP" ) . val( "Y" );
				$( "body" ).css( "background-color", "DarkRed" );
				
				origTime = LEvents[id][0];

				const formattedOrigTime = FixTime(origTime)

				$( "#selFT" ) . val(formattedOrigTime[1]);
				$( "#DateTime" ) . val(formattedOrigTime[0]);
				$( "#DateTime" ) . text(formattedOrigTime[2]);
				
				eid = id;

				console.log("origTime="+origTime+" eid="+eid)
				
				var q = "Update: "+formattedOrigTime[2]+" - "+LEvents[id][3];

				$("#pmEvent").val(id);
				$("#pmEvent").text(q);

				resetAll();

			}
			*/

			function jqUpdateEvent(oTime, nTime, act, cont){

				const postData = $.ajax(
				{	
					type: "POST",
					url: "./update/UpdateEvent.php",
					data: { origTime: oTime, newTime: nTime, newAct: act, newCont: cont },
					success: function() { 
						console.log("Updated: "+oTime);
					}
				}).fail(function(){
					alert("Fail");
				}).always(function(){
					clearForm()
				});
			}

			function clearForm(){

				$("#pmEvent").empty();

				$("#pu"). text("");
				$("#pu"). val("");
				
				manualEventForm.clearDiv();

				setTime();
				
				resetAll();
			}

			function resetAll(){
				
				resetTime();
				
				resetLEvents();
				
				resetLMoods();
				
			}

			//USED IN FUNCTIONS: delEvent(l#1010) and delMood (l#1029)
			function JQDel(etime, tbl, index){

			$.post("./del/DelJQ.php",
				{
					v1: etime,
					c1: index,
					selTbl: tbl
				});
			}
			
			function postAll(){

				ELen = LEvents.length;
				MLen = LMoods.length;

				for (var i=0; i<50; i++) {

					var tvar = LEvents[i][0];
					var act = LEvents[i][1];
					var cont = LEvents[i][2];
	
					JQPost(act, cont, tvar, i);
      
				}

				for (var i=0; i<50; i++) {

					var dtime = LMoods[i][0];
					var mood = LMoods[i][1];
	
					MPost(mood, dtime, i);
				}
				
				alert("Sync Complete")
			}

		</script>
	</div>
	</body>
</html>