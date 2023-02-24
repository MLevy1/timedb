<!DOCTYPE html>
<html>
<body>
<h1>Time Use</h1>
<a href="../menu/MenuEventLists.htm">Events Menu</a>
<link rel="stylesheet" href="../../styles.css" />

<!-- For Date Picker -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php
include('../function/Functions.php');
linktable();

pconn();

?>

<form method='get' action='<?php echo $form; ?>' >

<!--Date selectors -->

<table>

    <tr>
    
    <td align='center'><b>Start</td>
    <td align='center'><b>End</td>
	<td align='center'><b>Days<td>    
	<td></td>
    </tr><tr>
 
    <td><p><input type="text" id='selSDate' class='ssmselect' name='selSDate'></p></td>

    <td><p><input type="text" id='selEDate' class='ssmselect' name='selEDate'></p></td>

    <td>
    	<select id='selDT' name='selDT' class='single'>
    		<option>ALL</option>
    		<option>WD</option>
    		<option>WE</option>
    	</select>
    </td>
    <td> <input type="submit" /> </td>
	
</tr>

</table>

<script>
$( function() {
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
 } );
 
 </script>

</form>

//END - START


<?php
//get day type code
$selDT = $_REQUEST["selDT"];

//Get and format previously selected Start Date
$SDate1 = $_REQUEST["selSDate"];

//Create a DateTime object from selected date
$SDate = date_create($SDate1);

//Create a text formatted date from the DateTime Object
$SDate = date_format($SDate,"Y-m-d");

//Get and format previously selected End Date
$EDate1 = $_REQUEST["selEDate"];
$EDate = date_create($EDate1);
$EDate = date_format($EDate,"Y-m-d");

//Create variable to hold the day after the selected end date

$EDate2 = date_create($EDate1);
date_add($EDate2, date_interval_create_from_date_string("1 day"));


//Text fromated day after the end day
$EDate2 = date_format($EDate2,"Y-m-d");

//Create variable to hold the name and path of the current page

//Set pickers to default values if blank

if ($SDate1 == NULL) {
$SDate1 = date('Y-m-d');
$EDate1 = date('Y-m-d');
}

if ($selDT == NULL) {
$selDT ='ALL';
}

$dtest = array();
?>

<script>

var val = "<?php echo $SDate1 ?>";
document.getElementById("selSDate").value=val;

var val1 = "<?php echo $EDate1 ?>";
document.getElementById("selEDate").value=val1;

</script>

<?php

//MIDNIGHT FIX

$SDate0 = date( "Y-m-d", strtotime( "$SDate1 -1 day" ) );


if($EDate1 == date('Y-m-d')){

	$EDate0 = date( "Y-m-d", strtotime( "$EDate1 -1 day" ) );
}else{
	$EDate0 = $EDate1;
}

//Pull last events from each selected day
$LSql = "SELECT DATE(STime) AS cDay, STime, Color, IF(WEEKDAY(DATE_ADD(STime, INTERVAL 1 DAY))>4,0,1) AS WKI
FROM tblEvents 
INNER JOIN tblCont 
ON (tblEvents.ProID=tblCont.ContID) 
INNER JOIN tblAct 
ON (tblEvents.ActID=tblAct.ActID) 
INNER JOIN tblPUCodes ON tblAct.UCode = tblPUCodes.PUCode
WHERE STime 
	IN (
		SELECT MAX(STime) 
		FROM tblEvents 
		GROUP BY DATE(STime)
	) 
AND DATE(STime) BETWEEN CAST('$SDate0' AS DATE) AND CAST('$EDate0' AS DATE)";

$result = mysqli_query($conn, $LSql);

$ldata = array();


while ($row = mysqli_fetch_array($result)) {
	
	$a = $row['cDay'];
		
	$dtest[date( "Y-m-d H:i", strtotime( "$a +1 day" ) )][] = $row['WKI'];
	$dtest[date( "Y-m-d H:i", strtotime( "$a +1 day" ) )][] = $row['Color'];
	
}

//END MIDNIGHT FIX

//Setup query containing all events between selected start and end date

$sql = "SELECT STime, Color, IF(WEEKDAY(tblEvents.STime)>4,0,1) AS WKI
FROM tblEvents
INNER JOIN tblCont 
ON (tblEvents.ProID=tblCont.ContID) 
INNER JOIN tblAct 
ON (tblEvents.ActID=tblAct.ActID)
INNER JOIN tblPUCodes ON tblAct.UCode = tblPUCodes.PUCode
WHERE date(STime) BETWEEN '$SDate' AND '$EDate'  
ORDER BY STime";

//Setup query containing the first event on the day following selected end date

$sql2 = "SELECT *
FROM tblEvents 
WHERE date(STime) ='$EDate2' ORDER BY STime LIMIT 1";

//Run above queries

$result = mysqli_query($conn, $sql);
$result2 = mysqli_query($conn, $sql2);

//Reset arrays for results

$data = array();

//Populate arrays with results of all events query

while ($row = mysqli_fetch_array($result)) {
       
       //1 for weekday 0 for weekend
    	$dtest[$row['STime']][] = $row['WKI'];
    	
    	//color for table
	$dtest[$row['STime']][] = $row['Color'];
	
}

//Free $result variable
mysqli_free_result($result);

ksort($dtest);

foreach($dtest as $x => $xval) {
	
	if($selDT=='ALL'){
	
		$data[0][]=$x;
		$data[1][]=date_create($x);
		$data[2][]=$xval[0];
		$data[3][]=$xval[1];
	
	}elseif(($selDT=='WD') AND ($xval[0]==1)){
	
		$data[0][]=$x;
		$data[1][]=date_create($x);
		$data[2][]=$xval[0];
		$data[3][]=$xval[1];
		
	}elseif(($selDT=='WE') AND ($xval[0]==0)){
	
		$data[0][]=$x;
		$data[1][]=date_create($x);
		$data[2][]=$xval[0];
		$data[3][]=$xval[1];
		
	}
}

//Count rows in arrays
$cnt=count ($data[0]);

$SDate = date_create($SDate1);

//fill Dur, Hrs, and Mins arrays

$ldate = date_format($data[1][0],"Y-m-d");

$DC=0;

for($x = 0; $x < ($cnt); $x++) {

	//# of days from start date
	//$arrETime[1][] = $data[1][$x] ->diff($SDate)->format("%a");
	
	if(date_format($data[1][$x] ,"Y-m-d")!=$ldate){
	
		$DC++;
		$ldate=date_format($data[1][$x], "Y-m-d");
		
	}
	
	$arrETime[0][] = $DC;
}


//print_r($arrETime);

$dcnt = max($arrETime[0])+1;

//create and set variable holding the width of the svg in pts
$svgwidth = 1000;

//create and set variable holding the start point for the svg
$start = 35;

//sets the width of each col in the svg
$pwidth = ($svgwidth - $start) / $dcnt;

//set a max width for day cols
if($pwidth<50){
	$width=$pwidth;
}else{
	$width = 50;
}

//Set Current Date Variables

$EDate3 = date('Y-m-d');
$NowTime = date("Y-m-d H:i:s");

//Determine if the end date selected is the current date

if ($EDate == $EDate3){

	//Add row to end of arrays with current date and time


	$data[0][] = $NowTime;
	$data[1][] = date_create($NowTime);

}


?>

<!-- START EVENT LIST -->

<?php

for($x = 0; $x < ($cnt); $x++) {

	//fills col 5 with the number of seconds in each event
	
	if(((getsecs($data[0][$x], $data[0][$x+1])/60)<8000) AND ((getsecs($data[0][$x], $data[0][$x+1])/60)>4000)){
	
		$data[5][] = (getsecs($data[0][$x], $data[0][$x+1])/60)-7200;
	
	}
	
	elseif((getsecs($data[0][$x], $data[0][$x+1])/60)<2800){
	
		$data[5][] = getsecs($data[0][$x], $data[0][$x+1])/60;
	
	}else{
	
		$data[5][] = (getsecs($data[0][$x], $data[0][$x+1])/60)-2880;
	
	}
	
	//determines if its the first row
	
	if($x == 0){

		//if its the first row col 6 is set to match col 5
		$data[6][] = $data[5][0];

		//Col 8 holds distance from the edge (same for all events in a given day)
		$data[8][] = $start;

		//Col 9 holds the top of each event
		$data[9][] = 0;
	}
	else{
	
	//sets col 6 to the previous rows val + mins in current event
	$data[6][] = $data[6][$x-1]+$data[5][$x];
	
	//sets the starting pixel for the days col
	$data[8][] = $start + ($width * $arrETime[0][$x]);

	//subtracts mins from prior days from the start of the event
	
	$data[9][] = $data[6][$x-1]-($arrETime[0][$x] * 1440);
	
	}
	
	//DST FIX
	$a = ((date_format($data[1][$x], 'G')*60*60)+(date_format($data[1][$x], 'i')*60)+ date_format($data[1][$x], 's'))/60;

	$data[10][] = round($a-$data[9][$x],0);
	
	
	if(abs($data[10][$x])==60){
	
		$data[11][]=$data[9][$x]+$data[10][$x];
	}else{
		$data[11][]=$data[9][$x];
	}
	
	
}

mysqli_close($conn);
?>

<!-- START SVG -->

<svg width="<?php echo $svgwidth; ?>" height="1500">

<?php

echo '<rect x='. $start .' y=0 width='.$width.' height=' . $data[5][0] . ' 		
style="fill:'.$data[3][0].' ;stroke-width:
0;stroke:rgb(0,0,0)" />';

for($x = 0; $x < ($cnt); $x++) {

	echo '<rect x='. $data[8][$x].' y='.$data[11][$x].' width=' . $width . ' height=' . $data[5][$x] . ' 
	style="fill:'.$data[3][$x].';stroke-width:
	0;stroke:rgb(0,0,0)" />';
}

?>
    <text x="0" y="10" style="fill:darkblue;" font-weight="bold" font-size=10>12AM
    <tspan x="0" y="70">1AM</tspan>
    <tspan x="0" y="130">2AM</tspan>
    <tspan x="0" y="190">3AM</tspan>
    <tspan x="0" y="250">4AM</tspan>
    <tspan x="0" y="310">5AM</tspan>
    <tspan x="0" y="370">6AM</tspan>
    <tspan x="0" y="430">7AM</tspan>
    <tspan x="0" y="490">8AM</tspan>
    <tspan x="0" y="550">9AM</tspan>
    <tspan x="0" y="610">10AM</tspan>
    <tspan x="0" y="670">11AM</tspan>
    <tspan x="0" y="730">12PM</tspan>
    <tspan x="0" y="790">1PM</tspan>
    <tspan x="0" y="850">2PM</tspan>
    <tspan x="0" y="910">3PM</tspan>
    <tspan x="0" y="970">4PM</tspan>
    <tspan x="0" y="1030">5PM</tspan>
    <tspan x="0" y="1090">6PM</tspan>
    <tspan x="0" y="1150">7PM</tspan>
    <tspan x="0" y="1210">8PM</tspan>
    <tspan x="0" y="1270">9PM</tspan>
    <tspan x="0" y="1330">10PM</tspan>
    <tspan x="0" y="1390">11PM</tspan>
  </text>
</svg>

<!--
<table>

<tr>
	<th>In</td>
	<th>D1</td>
	<th>D2</td>
	<th>D3 (c)</th>
	<th>D5 (ht)</th>
	<th>D6</th>
	<th>D8 (x)</th>
	<th>D9 (y)</th>
</tr>

<?php
//EVENT LIST

for($x = 0; $x < ($cnt); $x++) {

	echo "<tr><td>".
	$x.
	"</td><td>".
	date_format($data[1][$x], 'D m-d h:i:s A').
	"</td><td>".
	$data[2][$x].
	"</td><td>".
	floor($data[3][$x]).
	"</td><td>".
	floor($data[5][$x]).
	"</td><td>".
	floor($data[6][$x]).
	"</td><td>".
	floor($data[8][$x]).
	"</td><td>".
	floor($data[9][$x]).
	"</td><td>".
	floor($data[11][$x]).
	"</td></tr>";
}

//END EVENT LIST
?>
</table>
-->
</body>
</html>