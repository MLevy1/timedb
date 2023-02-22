<?php
header("Cache-Control: no-cache, must-revalidate");

$QDate = date('Y-m-d');
$QTime = date('H:i');
$T1 = $QDate.'T'.$QTime;

if (!function_exists('eventbtnjql')) {
function eventbtnjql($act, $cont, $btnname){
	
	$btnid0 = $act.$cont;
	
	$btnid = preg_replace("/[^a-zA-Z0-9]/", "", $btnid0);
	
	echo "<button id='$btnid' onclick=\"btnJQL('$act', '$cont', '$btnid', '$btnname')\">$btnname</button>";
}
}


function selActiveContS($selname){

	pconn();
	global $conn;

	$sql = "SELECT tblCont.ContID, tblCont.ContDesc 
	FROM tblCont INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID 
	WHERE tblProj.ProjStatus!='Closed' AND tblCont.Active!='N' ORDER BY ContDesc";

	$result = mysqli_query($conn, $sql);

	echo "<select name=$selname id=$selname>";

	echo "<option></option>";

	while($row = $result->fetch_assoc()) {
		echo "<option value='" . $row['ContID'] . "'>" . $row['ContDesc'] ."</option>";
	}
	mysqli_close($conn);
	echo "</select>";
}


function selActiveActS($selname){

	pconn();
	global $conn;

	$sql = "SELECT ActID, ActDesc, Status FROM tblAct WHERE Status !='Inactive' ORDER BY ActDesc";

	$result = mysqli_query($conn, $sql);

	echo "<select name=$selname id=$selname>";

	echo "<option></option>";

	while($row = $result->fetch_assoc()) {
	echo "<option value='" . $row['ActID'] . "'>" . $row['ActDesc'] ."</option>";
	}
	mysqli_close($conn);
	echo "</select>";
}

?>

<head>
<link href="../css/MobileStyle.css" rel="stylesheet"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<?php
include("../function/Functions.php");

pconn();

formid();

date_default_timezone_set('America/New_York');

?>

</head>

<body>
<h1>Schedule</h1>
<?php include('../view/LinkTable.php'); ?>

<table>
	<tr>
		<td><b>Date:</b></td>

	<td>
	
	<p><input type="date" id='selD' name='selD' onblur='UpdateTvars()' value=<?php echo $QDate; ?> ></p></td>
	
	</tr>
	
</table>
<table>
	
	
	<tr>
	
		<td><b>Wake:</b></td>
		<td><b>Lunch:</td>
		<td><b>Leave:</td>
		<td><b>Bed:</td>
	
	</tr><tr>
	
	<td>

	    	<p><input type="time" id='selWT' name='selWT' onblur='UpdateTvars()' value="06:00"></p></td>

		<td>

	    	<p><input type="time" id='selLT' name='selLT' onblur='UpdateTvars()' value="11:30"></p></td>

		<td>

	    	<p><input type="time" id='selET' name='selET' onblur='UpdateTvars()' value="18:00"></p></td>

		<td>

	    	<p><input type="time" id='selBT' name='selBT' onblur='UpdateTvars()' value = "22:45"></p>

		</td>
		
	</tr>

</table>
<table>
<tr><td colspan=2>
<b>AM Base
</td></tr><tr>
<td> <?php selActiveActS("AMAct"); ?> </td>
<td> <?php selActiveContS("AMCont"); ?> </td>
<tr><td colspan=2>
<b>PM Base
</td></tr><tr>
<td> <?php selActiveActS("PMAct"); ?> </td>
<td> <?php selActiveContS("PMCont"); ?> </td>
<tr><td colspan=2>
<b>Evening Base
</td></tr><tr>
<td> <?php selActiveActS("EAct"); ?> </td>
<td> <?php selActiveContS("PMCont"); ?> </td>
</td></tr>
</table>
<div id="res">

</div>

<script>
var val = "<?php echo $T1 ?>";	
document.getElementById("selDT").value=val;

var val2 ="<?php echo $QTime ?>";
document.getElementById("selTime").value=val2;

</script>

<table>
<tr>
	
	<td><b>Time: </b></td><td>

    	<p><input type="time" id='selT2' name='selT2' value="06:00"></p>

	</td></tr>

<tr>

	<td><b>Act </td>

	<td>
	<?php selActiveActS("NAct1"); ?>
	</td></tr>
<tr><td><b>Sub Proj</b></td><td>
	<?php selActiveContS("NCont1"); ?>
	</td>

</tr><tr>

	<td><b>Special</td>

	<td>
	
		<select name=selSpec id=selSpec>
			<option>No</option>
			<option>AM Base</option>
			<option>PM Base</option>
			<option>Evening Base</option>
		</select>
	
	</td>
	
</tr><tr>

	<td><b>Dur </td>
	
	<td>
	
		<input type="text" name="txtDur" id="txtDur">
	
	</td>
	
</tr><tr>
	
	<td><b>Offset</td>
	<td>
		
		<select id="selOS" name="selOS">
			<option>Prior Event</option>
			<option>Wake</option>
			<option>Lunch</option>
			<option>Leave</option>
			<option>Bed</option>
		</select>

	</td>
	
</tr><tr>

	<td><b>Offset Event
	
	</td><td>
	
		<input type="text" name="txtOE" id="txtOE"></input>
	
	</td>
	
</tr><tr>

	<td><b>Offset Time
	
	</td><td>
	
		<input type="text" name="txtOT" id="txtOT" value=0></input>
		
	</td></tr>

</table>

<?php include('../btn/btnSetJQL.php'); ?>

<table width=30%>
<tr><td>
<input type="button" class="link" onclick="btnClearLS()" value="Reset" />
</td><td>
<input type="button" class="link" onclick="GPost()" value="Post" />
</td><td>
<input type="button" class="link" onclick="MEvent2()" value="Manual" />
</td> </tr>
</table>

<p id="demo"></p>

<p id="demo2"></p>

<p id="demo3"></p>

<script>

var ASch = JSON.parse(localStorage.getItem("LSASch"));

var text, ELen, i;

displayASch();



function AddTime(A, min)
{

	var CTime = A;
	
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

	var NDTime = Y+'-'+M +'-'+ D +'T'+ H +':'+ Mn;
	
	return (NDTime);
	
}

function btnClearLS()
{

	localStorage.removeItem("LSASch");

	ASch = [];
	document.getElementById("demo").innerHTML = ASch;

}

function AddMEvent()
{	
	var act1 = $( "#NAct1" ) . val();
	var cont1 = $( "#NCont1" ) . val();
	var tvar = $( "#selT2") . val();
	
	ASch.push([tvar, act1, ,cont1]);
		
	localStorage.setItem("LSASch", JSON.stringify(ASch));
	
	displayASch();
	
	
}

function MEvent2()
{	
	var S = $( "#selSpec" ) . val();
	
	if(S=='No'){

	var a = $( "#NAct1" ) . val();
	
	var b = $( "#NCont1" ) . val();
	
	var c = a+b;
	
	var d = $( "#NAct1 option:selected" ) . text();
}else{
	
		alert(S);
		
		a=S;
		b=S;
		d=S;
	
	}
	
	var len = ASch.length;

	var tvar = $( "#selT2") . val();

	var dur = $('#txtDur') . val();

	var off = $('#selOS') . val();
	
	var OE = $('#txtOE') . val();
	
	var OT = $('#txtOT') . val();

	switch(off){

		case 'Wake':

			tvar = $('#selD').val() + 'T' + $('#selWT').val();

			break;

		case 'Lunch':

			tvar = $('#selD').val() + 'T' + $('#selLT').val();

			break;

		case 'Leave':

			var tvar = $('#selD').val() + 'T' + $('#selET').val();

			break;

		case 'Bed':

			var tvar = $('#selD').val() + 'T' + $('#selBT').val();

			break;

		case 'Prior Event':

			if(OE.length==0){

				len = ASch.length;
		
			}else if(OE==null){

				len = ASch.length;
						
			}else{
		
				len = OE;
			
			}
				
				var T = AddTime((ASch[(len-1)][0]), parseInt(ASch[(len-1)][4]));

				tvar = T;

			break;

		default:

			alert('Error!');
	}


	if(OE==null){
	
		ASch.push([tvar, a, b, d, dur, off, OT]);
		
	}else{
	
		ASch.splice(OE, 0, [tvar, a, b, d, dur, off, OT]);
		
	}
	
	
	ASch.sort();
	
	UpdateTvars();
	
		
}

function btnJQL(a, b, c, d)
{	

	var len = ASch.length;

	var tvar = $( "#selT2") . val();

	var dur = $('#txtDur') . val();

	var off = $('#selOS') . val();
	
	var OE = $('#txtOE') . val();
	
	var OT = $('#txtOT') . val();

	switch(off){

		case 'Wake':

			tvar = $('#selD').val() + 'T' + $('#selWT').val();

			break;

		case 'Lunch':

			tvar0 = $('#selD').val() + 'T' + $('#selLT').val();
			
			alert(OT);
			
			tvar = AddTime(tvar0, parseInt(OT));

			break;

		case 'Leave':
			
			tvar0 = $('#selD').val() + 'T' + $('#selET').val();
			
			tvar = AddTime(tvar0, parseInt(OT));

			break;

		case 'Bed':

			var tvar = $('#selD').val() + 'T' + $('#selBT').val();
			
			tvar0 = $('#selD').val() + 'T' + $('#selBT').val();
			
			tvar = AddTime(tvar0, parseInt(OT));

			break;

		case 'Prior Event':

			if(OE.length==0){

				len = ASch.length;
		
			}else{
		
				len = OE;
			
			}
				
				var T = AddTime((ASch[(len-1)][0]), parseInt(ASch[(len-1)][4]));
				
				tvar = T;

			break;

		default:

			alert('Error!');
	}
	
		
	if(OE==null){
	
		ASch.push([tvar, a, b, d, dur, off, OT]);
		
	}else{
	
		ASch.splice(OE, 0, [tvar, a, b, d, dur, off, OT]);
		
	}
	
	ASch.sort();
	
	UpdateTvars();
	
	$("button").css("background-color", "lightgray");
	
	$("#"+c).css("background-color", "pink");


}

function displayASch()
{
	ELen = ASch.length;
		
	text = "<table>";
	
	for (i = 0; i < ELen; i++) {
		
		text += "<tr><td></td><td>" + ASch[i][0] + "</td><td>" + ASch[i][1] + "</td><td>" + ASch[i][3] +"</td><td>" + ASch[i][4] +"</td><td>" + ASch[i][5] +"</td><td>" + ASch[i][6] +"</td><td>" + "<input type='button'  class=link onclick=JQDel("+i+") value='-'</input>" + "</td> </tr><tr><td><input type='button' class=link onclick= AddBet("+i+") value='+'></input></td></tr>";
	
	}
	
	text += "</table>";

document.getElementById("demo").innerHTML = text;
}


function JQPost(act, cont, dtime)
{
	
    $.post("../add/AddJQ.php",
    {
        v1: act,
        v2: cont,
        v3: dtime,
        selTbl: 'tblSchedEvents'
    });
	
}

function GPost()
{

	ELen = ASch.length;

	for (var i=0; i<ELen; i++) {

		var tvar = ASch[i][0];
		var act = ASch[i][1];
		var cont = ASch[i][2];
		
		JQPost(act, cont, tvar);
	      
	}

}

function JQDel(i){
	ASch.splice(i, 1);
	
	UpdateTvars();
	
}

function AddBet(i){

	$('#txtOE').val(i);

}

function UpdateTvars(){

	ELen = ASch.length;
	
	for (var i=0; i<ELen; i++) {

		var E = ASch[i][5];

		switch (E){

			case 'Prior Event':
				
				var T = AddTime((ASch[(i-1)][0]), parseInt(ASch[(i-1)][4]));
				
				ASch[i][0] = T;

				break;
			
			case 'Wake':

				var D = $('#selD').val();

				var S = $('#selWT').val();

				var T0 = (D+'T'+S);
				
				var T = AddTime(T0, parseInt(ASch[i][6]));

				ASch[i][0] = T;

				break;

			case 'Lunch':

				var D = $('#selD').val();

				var S = $('#selLT').val();
				
				var T0 = (D+'T'+S);
				
				var T = AddTime(T0, parseInt(ASch[i][6]));

				ASch[i][0] = T;

				break;

			case 'Leave':

				var D = $('#selD').val();

				var S = $('#selET').val();

				var T0 = (D+'T'+S);
				
				var T = AddTime(T0, parseInt(ASch[i][6]));

				ASch[i][0] = T;

				break;

			case 'Bed':

				var D = $('#selD').val();

				var S = $('#selBT').val();

				var T0 = (D+'T'+S);
				
				var T = AddTime(T0, parseInt(ASch[i][6]));

				ASch[i][0] = T;

				break;

			default:

				var D = $('#selD').val();
	
				var S = ASch[i][0].substring(11);
	
				ASch[i][0] = (D+'T'+S);

		}
	
	localStorage.setItem("LSASch", JSON.stringify(ASch));
	
	displayASch();
	
	}
	
}

</script>
</body>
</html>