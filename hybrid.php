<!DOCTYPE html>
<html lang='en'>
	<head>
		<title>Hybrid</title>
		<?php 
			include("./function/Functions.php");
			
			function parr($arr){
			
				echo  "<pre>";
				print_r($arr);
				echo "</pre>";
			
			}
			
			pconn();

			//Create a list of all events on the server
			setQTime();
			
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

			$sql_lastuse = "SELECT tblEvents.ActID, tblEvents.ProID, TIMESTAMPDIFF (SECOND, MAX(STime), NOW()) AS LTime 
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
				$arr_act[4][] = $row['WklyHrs'];
				$arr_act[5][] = $row['WklyMins'];
			}

			//Create list of sub-activities

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

			//Create list of projects

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
			}
			
			mysqli_close($conn);

		?>

		<link href='https://fonts.googleapis.com/css?family=Homenaje' rel='stylesheet'>
		<link rel="stylesheet" href="styles.css">
		<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
		<script src="./scripts/newManualEventScripts.js"></script>
		<script src="./scripts/timeScripts.js"></script>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
	</head>
	<body>
		<div id="pageWrapper">
		<header>
			<h1>Events</h1>
			<sub>v_2023-02-27</sub>
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
					<a href="#" onclick="runaddCells()">Manual</a>
				</li>
				<li>
					<a href="#" onclick="PriorEvent()">Prior</a>
				</li>
				<li>
					<a href="../timedbo/goals/FormDailyGoalsJQ.php">Goals</a>
				</li>
				<li>
					<a href="#" onclick="CheckLEvents()">Test</a>
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

			<table id="etbl"></table>
			<ul id="eventBtnListContainer" class="btnGroup"></ul>

			<a href="#" class="groupHeading" onclick="$('#tblRoutine').toggleClass('hidden')">Routine</a>

			<ul class="btnGroup hidden" id="tblRoutine"></ul>

			<a href="#" class="groupHeading" onclick="$('#tblccare').toggleClass('hidden')">Childcare</a>

			<ul class="btnGroup hidden" id="tblccare"></ul>

			<a href="#" class="groupHeading" onclick="$('#tblchores').toggleClass('hidden')">Chores</a>

			<ul id="tblchores" class="btnGroup hidden"></ul>

			<a href="#" class="groupHeading" onclick="$('#tblfam').toggleClass('hidden')">Family</a>

			<ul id="tblfam" class="btnGroup hidden"></ul>

			<a href="#" class="groupHeading" onclick="$('#tblhealth').toggleClass('hidden')">Health</a>

			<ul id="tblhealth" class="btnGroup hidden"></ul>

			<a href="#" class="groupHeading" onclick="$('#tblfood').toggleClass('hidden')">Food & Drink</a>

			<ul id="tblfood" class="btnGroup hidden"></ul>

			<a href="#" class="groupHeading" onclick="$('#tblsocial').toggleClass('hidden')">Social</a>

			<ul id="tblsocial" class="btnGroup hidden"></ul>

			<a href="#" class="groupHeading" onclick="$('#tblwork').toggleClass('hidden')">Work</a>

			<ul id="tblwork" class="btnGroup hidden"></ul>
				
			<a href="#" class="groupHeading" onclick="$('#tbltrans').toggleClass('hidden')">Transport</a>

			<ul id="tbltrans" class="btnGroup hidden"></ul>

			<a href="#" class="groupHeading" onclick="$('#tblpersonal').toggleClass('hidden')">Personal</a>

			<ul id="tblpersonal" class="btnGroup hidden"></ul>

		</div>
		<div id="footer">
			<svg id="svgEventChart" height="30"></svg>

			<svg id="svgMoodChart" height="30"></svg>

			<div id="eventListContainer"></div>

			<div id="moodListContainer"></div>

			<p id="listContainer"></p>

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
			const svgWidth = $( "svg").css("width");
			const svgWidthNum = svgWidth.substring(0, ((svgWidth.length)-2));
			const btnWidthNum = 110;

			let text, ELen, MoodsLen, i, datetimeValue, datetimeText, millisecTime, etmv, etmt, eft, eid;
			
			//set local storage variables **need to add a way to skip this if offline**
			let lastuse = <?php echo json_encode( $arr_lastuse ) ?>;
			
			//Events

			let data_events = <?php echo json_encode( $arr_events ) ?>;

			localStorage.setItem("LSEvents", JSON.stringify(data_events));
			
			let LEvents = JSON.parse(localStorage.getItem("LSEvents"));
			
			//Moods
			
			let data_moods = <?php echo json_encode( $arr_moods ) ?>;
			
			localStorage.setItem("LSMoods", JSON.stringify(data_moods));

			let LMoods = JSON.parse(localStorage.getItem("LSMoods"));
			
			//Activities

			let data_acts = <?php echo json_encode( $arr_act ) ?>;
			
			localStorage.setItem("LSActs", JSON.stringify(data_acts));
			
			let LActs = JSON.parse(localStorage.getItem("LSActs"));
			
			//Sub-Activities
			
			let data_cont = <?php echo json_encode( $arr_cont ) ?>;
			
			localStorage.setItem("LSConts", JSON.stringify(data_cont));

			let LConts = JSON.parse(localStorage.getItem("LSConts"));
			
			//Projects

			let data_proj = <?php echo json_encode( $arr_proj ) ?>;
			
			localStorage.setItem("LSProj", JSON.stringify(data_proj));
			
			let LProj = JSON.parse(localStorage.getItem("LSProj"));
			
			//Use Codes & Colors

			let data_pu = <?php echo json_encode( $arr_pu ) ?>;
				
			localStorage.setItem("LSPU", JSON.stringify(data_pu));
			
			let LPU = JSON.parse(localStorage.getItem("LSPU"));
			

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

			localEventButton('N04', 'NA', 'Bed', "tblRoutine", "n");

			localEventButton('B01', 'PERSONAL.2', 'BR', "tblRoutine", "n");

			localEventButton('B07', 'PERSONAL.2', 'BR-2', "tblRoutine", "n");

			localEventButton('P29', 'PERSONAL.2', 'Shower', "tblRoutine", (2*60*60*24));

			localEventButton('P60', 'PERSONAL.2', 'Floss', "tblRoutine", (2*60*60*24));

			localEventButton('P09', 'PERSONAL.2', 'Brush Teeth', "tblRoutine", (2*60*60*24));
					
			localEventButton('P33', 'PERSONAL.2', 'Shave & Hair', "tblRoutine", (3*60*60*24));

			localEventButton('P20', 'PERSONAL.2', 'Dress', "tblRoutine", "n");

			localEventButton('P32', 'PERSONAL.2', 'Pack', "tblRoutine", "n");

			localEventButton('P16', 'Dog', 'Dog', "tblRoutine", "n");

			localEventButton('P30', 'Dog', 'Walk (D)', "tblRoutine", "n");

			localEventButton('P12', 'PERSONAL.2', 'Fingernails', "tblRoutine", (10*60*60*24));

			localEventButton('P29', 'Dog', 'Shower (D)', "tblRoutine", (30*60*60*24));

			localEventButton('N01', 'NA', 'Untracked', "tblRoutine", "n");

			localEventButton('C03', 'CHC.R', 'Feeding', "tblccare", "n");

			localEventButton('C01', 'CHC.R', 'Diaper 1', "tblccare", "n");

			localEventButton('C02', 'CHC.R', 'Diaper 2', "tblccare", "n");

			localEventButton('C08', 'CHC.R', 'Reading', "tblccare", (4*60*60*24));
				
			localEventButton('C09', 'CHC.R', 'Play', "tblccare", "n");
				
			localEventButton('C04', 'CHC.R', 'Bath', "tblccare", "n");

			localEventButton('S01', 'CW-Group', 'Social (CW)', "tblsocial", "n");

			localEventButton('S13', 'CW-Group', 'Bar (CW)', "tblsocial", "n");

			localEventButton('S01', 'DC', 'Social (DC)', "tblsocial", "n");
					
			localEventButton('S01', 'ME', 'Social (ME)', "tblsocial", "n");

			localEventButton('A02', 'ADMIN', 'Inbox', "tblwork", "n");

			localEventButton('T04', 'TRAINING.2', 'WF Training', "tblwork", "n");

			localEventButton('M10', 'MEET.01', 'Team Mtg', "tblwork", "n");

			localEventButton('A07', 'ADMIN', 'Tech Support', "tblwork", "n");

			localEventButton('W15', 'ISSUE.00', 'Issue Memo', "tblwork", "n");

			localEventButton('W04', 'ISSUE.R', 'Issues Reporting', "tblwork", "n");

			localEventButton('W10', 'ISSUE.00', 'Issues: Email', "tblwork", "n");

			localEventButton('M01', 'ISSUE.00', 'Issues: R&C Mtg', "tblwork", "n");

			localEventButton('M02', 'ISSUE.00', 'Issues: Bus Mtg', "tblwork", "n");

			localEventButton('W01', 'RCSA.00', 'RCSA: Agenda', "tblwork", "n");

			localEventButton('M02', 'RCSA.00', 'RCSA: Bus Mtg', "tblwork", "n");

			localEventButton('M01', 'RCSA.00', 'RCSA: R&C Mtg', "tblwork", "n");

			localEventButton('W33', 'RCSA.A', 'RCSA: Risk Asmt', "tblwork", "n");

			localEventButton('W29', 'RCSA.A', 'RCSA: Controls', "tblwork", "n");

			localEventButton('W37', 'RCSA.A', 'RCSA: QA', "tblwork", "n");

			localEventButton('W10', 'RCSA.00', 'RCSA: Email', "tblwork", "n");

			localEventButton('W38', 'RCSA.R', 'RCSA: Status Rep', "tblwork", "n");

			localEventButton('W04', 'RCSA.R', 'RCSA: Rep', "tblwork", "n");

			localEventButton('W29', 'SHRP.01', 'MR Ctr: Controls', "tblwork", "n");

			localEventButton('W10', 'SHRP.01', 'MR Ctr: Email', "tblwork", "n");

			localEventButton('W37', 'SHRP.01', 'MR Ctr: QA', "tblwork", "n");

			localEventButton('W38', 'SHRP.01', 'MR Ctr: Status Rep', "tblwork", "n");

			localEventButton('M01', 'SHRP.01', 'MR Ctr: R&C Mtg', "tblwork", "n");

			localEventButton('W04', 'SHRP.01', 'MR Ctr: Rep', "tblwork", "n");

			localEventButton('W04', 'REP.01', 'Qtrly Report', "tblwork", "n");

			localEventButton('W04', 'REP.00', 'Reporting: General', "tblwork", "n");

			localEventButton('M01', 'REP.00', 'Rep R&C Mtg', "tblwork", "n");

			localEventButton('W10', 'RC.00', 'Reg Ctr Email', "tblwork", "n");

			localEventButton('M01', 'RC.00', 'Reg Ctr R&C Mtg', "tblwork", "n");

			localEventButton('W50', 'POL.00', 'Procedures: Policy', "tblwork", "n");

			localEventButton('M01', 'POL.00', 'Procedures: R&C Mtg', "tblwork", "n");

			localEventButton('W10', 'POL.00', 'Procedures: Email', "tblwork", "n");

			localEventButton('W38', 'POL.00', 'Procedures: Status Rep', "tblwork", "n");

			localEventButton('N02', 'AD', 'Drive (A)', "tblfam", "n");

			localEventButton('S07', 'AD', 'Meal (A)', "tblfam", "n");

			localEventButton('S01', 'Family.1', 'Social (Mom)', "tblfam", "n");

			localEventButton('P30', 'AD', 'Walk (A)', "tblfam", "n");

			localEventButton('P56', 'AD', 'Hiking (A)', "tblfam", "n");

			localEventButton('S01', 'AD', 'Social (A)', "tblfam", "n");

			localEventButton('S01', 'Family.3', 'Social (F)', "tblfam", "n");

			localEventButton('S10', 'AD', 'Shopping (A)', "tblfam", "n");

			localEventButton('N03', 'AD', 'TV (A)', "tblfam", "n");

			localEventButton('S09', 'AD', 'Events (A)', "tblfam", "n");

			localEventButton('N02', 'Family.6', 'Drive (A&D)', "tblfam", "n");

			localEventButton('P30', 'Family.6', 'Walk (A&D)', "tblfam", "n");

			localEventButton('P56', 'Family.6', 'Hiking (A&D)', "tblfam", "n");

			localEventButton('N02', 'PERSONAL.5', 'Drive', "tbltrans", "n");

			localEventButton('P40', 'PERSONAL.5', 'Gas', "tbltrans", "n");

			localEventButton('N02', 'Dog', 'Drive (D)', "tbltrans", "n");

			localEventButton('P42', 'PERSONAL.4', 'Run', "tblhealth", "n");

			localEventButton('P31', 'PERSONAL.4', 'Gym', "tblhealth", (7*60*60*24));

			localEventButton('P63', 'PERSONAL.4', 'Meditate', "tblhealth", (7*60*60*24));

			localEventButton('P30', 'PERSONAL.4', 'Walk', "tblhealth", "n");

			localEventButton('P15', 'PERSONAL.4', 'Doctor', "tblhealth", "n");

			localEventButton('B02', 'PERSONAL.8', 'Eat', "tblfood", "n");

			localEventButton('B06', 'BREAK', 'Beverage', "tblfood", "n");

			localEventButton('P45', 'PERSONAL.8', 'Pick-up Food', "tblfood", "n");

			localEventButton('P13', 'PERSONAL.8', 'Cook', "tblfood", "n");

			localEventButton('B09', 'PERSONAL.8', 'Eat Slow', "tblfood", "n");
					
			localEventButton('B05', 'PERSONAL.8', 'Order Food', "tblfood", "n");

			localEventButton('P18', 'PERSONAL.4', 'Food Tracking', "tblfood", "n");
					
			localEventButton('P35', 'PERSONAL.3', 'Dishes', "tblchores", (4*60*60*24));

			localEventButton('P34', 'PERSONAL.3', 'Laundry', "tblchores", (14*60*60*24));

			localEventButton('P41', 'PERSONAL.3', 'Trash', "tblchores", (5*60*60*24));

			localEventButton('P59', 'PERSONAL.3', 'Vacuum', "tblchores", "n");

			localEventButton('P36', 'PERSONAL.7', 'Groceries', "tblchores", "n");

			localEventButton('P22', 'PERSONAL.3', 'Haircut', "tblchores", (30*60*60*24));

			localEventButton('P64', 'PERSONAL.3', 'Mail', "tblchores", (21*60*60*24));

			localEventButton('P61', 'PERSONAL.3', 'Sheets & Towels', "tblchores", (30*60*60*24));

			localEventButton('P37', 'PERSONAL.3', 'Lawn', "tblchores", "n");

			localEventButton('P58', 'PERSONAL.3', 'Clean Kitchen', "tblchores", "n");

			localEventButton('P48', 'PERSONAL.3', 'Clean Car', "tblchores", "n");

			localEventButton('P11', 'PERSONAL.3', 'Clean House', "tblchores", (30*60*60*24));

			localEventButton('P39', 'PERSONAL.7', 'Shopping: Home', "tblchores", "n");

			localEventButton('P47', 'PERSONAL.7', 'Shopping: Online', "tblchores", "n");

			localEventButton('P43', 'PERSONAL.3', 'Home Repairs', "tblchores", "n");

			localEventButton('L03', 'PERSONAL.3', 'Car Repairs', "tblchores", "n");

			localEventButton('P05', 'PERSONAL.A', 'Personal Admin', "tblpersonal", "n");

			localEventButton('P01', 'TIMEDB.0', 'Database', "tblpersonal", "n");

			localEventButton('P04', 'PFIN.00', 'Finances', "tblpersonal", "n");

			localEventButton('P26', 'PERSONAL.1', 'JO', "tblpersonal", "n");

			localEventButton('N03', 'PERSONAL.1', 'TV', "tblpersonal", "n");

			localEventButton('L16', 'READ.1', 'Research', "tblpersonal", "n");

			localEventButton('L16', 'PERSONAL.4', 'Read: Health', "tblpersonal", "n");

			localEventButton('L19', 'LEARNING.1', 'Crossword', "tblpersonal", "n");

			localEventButton('L14', 'PROG.3', 'JavaScript', "tblpersonal", "n");

			localEventButton('L14', 'PROG.1', 'Python', "tblpersonal", "n");

			localEventButton('L16', 'NORM.F', 'Read: Fashion', "tblpersonal", "n");

			localEventButton('P24', 'PERSONAL.1', 'Internet', "tblpersonal", "n");

			localEventButton('P53', 'PERSONAL.1', 'Crypto', "tblpersonal", "n");

			localEventButton('L16', 'News', 'News', "tblpersonal", "n");

			function btnclr(){

				$("button").css("background-color", defaultBtnBGColor);
				
				$("button").css("color", defaultBtnColor);

				resetAll();
			}

			$(".sTime").change(function(){

				displayLEvents();
				
			});


			function btnJQL(act, cont, A2){
					
				var U = $("#pu").val();
				
				var selPost = $("#selPost").val();
				
				setETime();
				
				if(U!="U"){
				
					LEvents.push([datetimeValue, act, cont, A2, 'N', datetimeText, millisecTime]);
					
					if(selPost==="Y"){
					
						JQPost(act, cont, datetimeValue);
						
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
				
				LMoods.push([datetimeValue, a, 'N', datetimeText, millisecTime]);
				
				$( "#moodIndicator" ).css("color", moodColor(a));
				
				if(selPost==="Y"){
				
					MPost(a, datetimeValue);
				
				}
				
				resetAll();
			}

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

			function CheckLEvents(){
			
				let missingEvents = [];

				LEvents.sort();
				
				LEvents.reverse();
				
				ELen = LEvents.length;
				
				SLen = srvevents[0].length;
				
				//confirm local events are in server
				
				for (i = 0; i < ELen; i++) {
				
					let varLocal = FixTime(LEvents[i][0]);
					let svrList = srvevents[0];
					
					if(svrList.includes(varLocal[3])!=true){
						
						missingEvents.push(LEvents[i]);
						
					}
				
				}

				let missingEventCount = missingEvents.length;
				
				if(missingEventCount>0){
				
					text = "<table>";
				
					text += "<th></th><th></th><th>Date</th><th>Time</th><th>Act</th><th>Cont</th><th></th>";

					for (i = 0; i < missingEventCount; i++) {
				
						text += "<tr><td>" +
						
						"<input type=button value=+ class=slnk onclick='JQPost(`"+ missingEvents[i][1] + "`,`" + missingEvents[i][2] + "`,`" + missingEvents[i][0] + "`,`" + i+"`)'/>" + 
					
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

					document.getElementById("listContainer").innerHTML = text;
				
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

				resetSVG('svgEventChart')

				var arrchart = [];

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
				
					//end eventDuration calc
					
					let arr_disp_time = FixTime(LEvents[i][0]);
					
					if(Date.parse(LEvents[i][0]) > minDate && Date.parse(LEvents[i][0]) <= maxDate){
					
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
				
				svgtext('svgEventChart')
				
			}

			function delEvent(i){
				
				var q = "Delete "+LEvents[i][0]+": "+LEvents[i][3]+"?";

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

				$.post("./add/AddJQ.php",
				{
					v1: dtime,
					v2: mood,
					selTbl: 'tblMood'
				});
				
				resetAll();
				
			}

			function JQPost(act, cont, dtime, i){

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
								
								$("#"+buttons[i].id).addClass('warn');
					
							} else {

								$("#"+buttons[i].id).removeClass('warn');
							
							}
						
						}
			
					}
			
				}
			}

			function localEventButton(act, cont, btnName, list, warn){
				
				let arrElapsedTime = findLast(act, cont);
				
				let elapsedTime = arrElapsedTime[0];

				let warnTime = arrElapsedTime[1];
				
				var bc = $( "button" ).length;
				
				var btnid = "btn"+bc;
				
				let btn = document.createElement("button");

				btn.id = btnid;

				btn.setAttribute('data-act', act);
				
				btn.setAttribute('data-cont', cont);
				
				btn.setAttribute('data-warn', warn);

				btn.classList.add("ebtn");
				
				let buttonNameTextNode = document.createTextNode(btnName);
				
				let elapsedTimeTextNode = document.createTextNode(elapsedTime);
				
				btn.appendChild(buttonNameTextNode);

				btn.appendChild(document.createElement("br"));
				
				btn.appendChild(elapsedTimeTextNode);
				
				let li = document.createElement("li");

				li.appendChild(btn);
				
				let selectedList = document.getElementById(list);

				selectedList.appendChild(li);
				
				if (warn!="n"){

					if(warn < warnTime){

						$("#"+btnid).addClass('warn');
					
					}
				}

				document.getElementById(btnid). addEventListener("click", function(){
				
					btnJQL(act, cont, btnName);
			
					resetbtn();

				});
			}

			//uses the prior event to create a new event record

			function PriorEvent(){

				const selPost = $("#selPost").val();

				const actValue = LEvents[1][1];
				const contValue = LEvents[1][2];
				const actText = LEvents[1][3];
				
				setETime();
				
				LEvents.push([datetimeValue, actValue, contValue, actText, 'N', datetimeText, millisecTime]);
				
				if(selPost==="Y"){
										
					JQPost(actValue, contValue, datetimeValue);
					
				}

				resetAll();
				
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
				
				resetAll();
			}

			//determines the color of each box on the event chart

			function findActivityColor(ActID){
				
				var arrAct = LActs[0];

				var ans = $.inArray(ActID, arrAct);

				var PU = LActs[3][ans];
				
				var arrLPU = LPU[0];
				
				var an2 = $.inArray(PU, arrLPU);
				
				var clr = LPU[2][an2];
				
				return clr;
			}

			//sets the colors for the boxes in the mood chart

			function moodColor(mood){
			
				switch(Number(mood)){
				
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
				
				var svgboxstartxcoord = ((time-minTime)/(24*60*60*1000))*svgWidthNum;
				
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

				$.post("./update/UpdateJQ.php",
				{
					v1: act,
					v2: cont,
					v3: etime,
					selTbl: 'tblEvents'
				});
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

			//USED IN resetbtn(l#1419)
			function findLast(actid, contid){
				
				LEvents.sort();
				
				LEvents.reverse();
				
				ELen = LEvents.length;

				for (j = 0; j < ELen; j++) {
				
					if(LEvents[j][1]==actid){
					
						if(LEvents[j][2]==contid){
								
							var ESecs = Math.round((Date.now()-Date.parse(LEvents[j][0])) / 1000);
								
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
						
							var ESecs = Number(lastuse[2][j]);
								
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
						
						var eventLength = Date.now()-Date.parse(LEvents[i][0]);
						
					}else{
					
						eventLength = Date.parse(LEvents[i-1][0])-Date.parse(LEvents[i][0]);
					
					}
					
					//formatEventDuration(eventLength);
					
					if(Date.parse(LEvents[i][6]) > minDate){

						arr1.push([LEvents[i][3], eventLength]);
					
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
				
			document.getElementById("listContainer").innerHTML = arr2;

			}

		</script>
	</div>
	</body>
</html>