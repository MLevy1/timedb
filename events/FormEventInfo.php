<?php header("Cache-Control: no-cache, must-revalidate"); ?>

<link rel="stylesheet" href="../css/MobileStyle.css" />

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<!--
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
-->

<?php

include('../function/Functions.php');

linktable();

pconn();

formid();

setQTime();

//get pre selected variables 
/*
$form = $_REQUEST["form"];
$selSDate = $_REQUEST["selSDate"];
$selEDate = $_REQUEST["selEDate"];
$selAct = $_REQUEST["selAct"];
$selCont= $_REQUEST["selCont"];
$selProj = $_REQUEST["selProj"];
$timecode = $_REQUEST["timecode"];
$selUCode = $_REQUEST["selUCode"];
$ctype = $_REQUEST["ctype"];
$dtype = $_REQUEST["dtype"];
*/
?>

<script>
//set selectors to pre selected variables
/*
var val1 = "<?php echo $selSDate ?>";
document.getElementById("selSDate").value=val1;

var val2 = "<?php echo $selEDate ?>";
document.getElementById("selEDate").value=val2;

var val3 = "<?php echo $selAct ?>";
document.getElementById("selAct").value=val3;

var val4 = "<?php echo $selCont ?>";
document.getElementById("selCont").value=val4;

var val5 = "<?php echo $selProj ?>";
document.getElementById("selProj").value=val5;

var val6 = "<?php echo $timecode ?>";
document.getElementById("timecode").value=val6;

var val7 = "<?php echo $selUCode ?>";
document.getElementById("selUCode").value=val7;

var val8 = "<?php echo $ctype ?>";
document.getElementById("ctype").value=val8;

var val9 = "<?php echo $dtype ?>";
document.getElementById("dtype").value=val9;
*/
</script>


<h1>Event Info</h1>

<table width='100%'>

    <tr><td><b>Start Date</b></td><td>

		<p><input type="date" id='selSDate' name='selSDate'></p>

    </td><td><b>End Date</b></td><td>

    	<p><input type="date" id='selEDate' name='selEDate'></p>

    </td></tr>
    
    <tr><td><b>Activity</b></td><td>

<select id='selAct' name='selAct' class='smselect'>

<option value='All'>All</option>

<?php

$sql = "SELECT * FROM tblAct WHERE Status!='Inactive' ORDER BY ActDesc";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
	echo "<option value='" . $row['ActID'] . "'>" .$row['ActDesc'] . "</option>";
}

mysqli_free_result($result);

?>

</select>

    </td><td><b>Project</b></td>
	
	<td>
	
<select id='selProj' name='selProj' class='smselect'>

<option value='All'>All</option>

<?php

$sql = "SELECT * FROM tblProj ORDER BY ProjDesc";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row['ProjID'] . "'>" .$row['ProjDesc'] . "</option>";
}
mysqli_free_result($result);
?>

</select>
	
	</td></tr>

    </td></tr><tr>

<td><b>Use Code</td><td>
	
	<select id='selUCode' class='smselect' name='selUCode'>

<option value='All'>All</option>
<option value='AW'>All Work</option>

<?php

$sql = "SELECT * FROM tblPUCodes ORDER BY PUCodeDesc";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row['PUCode'] . "'>" .$row['PUCode'] . " - " .$row['PUCodeDesc'] . "</option>";
}

mysqli_free_result($result);
?>

</select>
	</td>

<td><b>Sub-Project</b></td><td>

<select id='selCont' class='smselect' name='selCont'>

<option value='All'>All</option>

<?php

$sql = "SELECT * FROM tblCont INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID WHERE Active!='N' AND ProjStatus != 'Closed' ORDER BY ContDesc";

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
    echo "<option value='" . $row['ContID'] . "'>" .$row['ProjDesc'] . " - " .$row['ContDesc'] . "</option>";
}

mysqli_free_result($result);
mysqli_close($conn);
?>

</select>

</td> </tr>

<tr>

	<td><b>Time Code</b></td>
	<td>
	
		<select id='timecode' name='timecode' class='smselect'>
			<option selected>H</option>
			<option>M</option>
			<option>WD</option>
			
		</select>
		
</td><td><b>Chart</td><td>


<select id='ctype' name='ctype' class='smselect'>
			<option value=1 >Time</option>
			<option value=10 >Std Dev</option>
			
		</select>

</td></tr><tr><td></td>

<!-- RADIO BTNS

<td><input type="radio" id="rtype" name="rtype" value="C" style="height:35px; width:35px; vertical-align: middle;">C</td>
	<td><input type="radio" id="rtype" name="rtype" value="M" checked="checked" style="height:35px; width:35px; vertical-align: middle;">M</td>

-->

<td> 

<select id='dtype' name='dtype' class='smselect'>
			<option value=1 >Monthly</option>
			<option value=2 >Weekly</option>
			<option value=3 >Events</option>
</select></td>
	<td> <input type="button" value="Run" onclick="TestF()"/> </td>
	
</tr>

</table>

<div id="tbl"></div>

<script>

function ADP()
{

	$( "#selSDate" ).datepicker({
		changeMonth: true,
		changeYear: true,
		minDate: new Date(2016, 5-1, 23),
		maxDate: "+0d",
		dateFormat: "yy-mm-dd"
	});
	
	
	$( "#selEDate" ).datepicker({
		changeMonth: true,
		changeYear: true,
		minDate: new Date(2016, 5-1, 23),
		maxDate: "+0d",
		dateFormat: "yy-mm-dd"
	});
	
 }
 
 function TestF()
{

var selSDate = $( "#selSDate" ).val();
var selEDate = $( "#selEDate" ).val();
var selAct = $( "#selAct" ).val();
var selProj = $( "#selProj" ).val();
var selCont = $( "#selCont" ).val();
var selUCode = $( "#selUCode" ).val();
var ctype = $( "#ctype" ).val();
var timecode = $( "#timecode" ).val();

var selT = $( "#dtype" ).val();

if(selT == 1){

var link = "../events/ViewSelActContDurMth.php?link=1&selAct="+selAct+"&selProj="+selProj+"&selCont="+ selCont + "&timecode=" + timecode + "&selUCode=" + selUCode;

}else if (selT == 2){

var link = "../events/ViewSelActContDur.php?link=1&selAct="+selAct+"&selProj="+selProj+"&selCont="+ selCont + "&timecode=" + timecode + "&selUCode=" + selUCode + "&selSDate=" + selSDate + "&selEDate=" + selEDate + "&ctype="+ctype;

}else{

var link = "../events/ViewSelActContEvents.php?link=1&selAct="+selAct+"&selProj="+selProj+"&selCont="+ selCont + "&timecode=" + timecode + "&selUCode=" + selUCode + "&selSDate=" + selSDate + "&selEDate=" + selEDate + "&ctype="+ctype;

}

$( "#tbl" ).load(link);

}


setTimeout(function(){
        ADP();
        }, 500);

</script>