<!DOCTYPE html>
<html>
<body>
<?php header("Cache-Control: no-cache, must-revalidate");?>
<h1>Time Use</h1>
<a href="../menu/MenuEventLists.htm">Events Menu</a>
<link rel="stylesheet" href="../../styles.css" />

<!-- For Date Picker -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php
include('../function/Functions.php');
include("../view/LinkTable.php");

pconn();

?>

<form method='get' action='<?php echo $form; ?>' >

<!--Date selectors -->

<table witdth=100%>

    <tr>
    
    <td align='center'><b>Start</td>
    <td align='center'><b>End</td>
    
    </tr><tr>
 
    <td><p><input type="text" id='selSDate' name='selSDate'></p></td>

    <td><p><input type="text" id='selEDate' name='selEDate'></p></td>
    	
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

<?php
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
$LSql = "SELECT DATE(STime) AS cDay, STime, Color
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
		
	$dtest[date( "Y-m-d H:i", strtotime( "$a +1 day" ) )][] = $row['UCode'];
	$dtest[date( "Y-m-d H:i", strtotime( "$a +1 day" ) )][] = $row['Color'];
	
}

//END MIDNIGHT FIX

//Setup query containing all events between selected start and end date

$sql = "SELECT STime, Color
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
       
       	$dtest[$row['STime']][] = $row['UCode'];
	$dtest[$row['STime']][] = $row['Color'];
	
}

//Free $result variable
mysqli_free_result($result);

//Populate arrays with results of first next day event query

while ($row = mysqli_fetch_array($result2)) {
	//$data[0][] = $row['STime'];
	//$data[1][] = date_create($row['STime']);
}

ksort($dtest);

$arrnew = array();

foreach($dtest as $x => $xval) {
	
	$data[0][]=$x;
	$data[1][]=date_create($x);
	$data[2][]=$xval[0];
	$data[3][]=$xval[1];

}

//Free $result variable

mysqli_free_result($result2);

//Count rows in arrays

$cnt=count ($data[0]);

$SDate = date_create($SDate1);

//fill Dur, Hrs, and Mins arrays
for($x = 0; $x < ($cnt); $x++) {
	$arrDur[] = getmins($data[0][$x], $data[0][$x+1]);
  
	//# of days from start date
	$arrETime[0][] = $data[1][$x] ->diff($SDate)->format("%a");
   
	//#of mins from midnight start date
	$arrETime[1][] = $arrETime[0][$x]*1440;
 
}

$cnt= count ($data[0]);

$dcnt = max($arrETime[0])+1;

$svgwidth = 1000;

$start = 35;

$pwidth = ($svgwidth - $start) / $dcnt;

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

<!-- START EVENT LIST

<table>

<tr>
	<th>Index</td>
	<th>Data1</td>
	<th>Data2</td>
	<th>Data3</th>
	<th>Data5</th>
	<th>Data6</th>
	<th>Data7</th>
	<th>Data8</th>
	<th>Data9</th>
</tr>

-->

<?php

for($x = 0; $x < ($cnt); $x++) {

	$data[5][] = getsecs($data[0][$x], $data[0][$x+1])/60;
	
	if($x == 0){

		$data[6][] = $data[5][0];

		$data[7][] = $data[6][0];


		//Distance from the edge
		$data[8][] = $start;

		$data[9][] = 0;
	}
	else{
	
	$data[6][]=$data[6][$x-1]+$data[5][$x];
	
	$data[7][]=$data[6][$x]-($arrETime[0][$x] * 1400);
	
	$data[8][] = ($start + ($width * $arrETime[0][$x]));

	$data[9][] = $data[6][$x-1]-($arrETime[0][$x] * 1440);
	}

/*
	echo "<tr><td>".
	$x.
	"</td><td>".
	date_format($data[1][$x], 'm-d h:i:s A').
	"</td><td>".
	$data[2][$x].
	"</td><td>".
	$data[3][$x].
	"</td><td>".
	$data[5][$x].
	"</td><td>".
	$data[6][$x].
	"</td><td>".
	$data[7][$x].
	"</td><td>".
	$data[8][$x].
	"</td><td>".
	$data[9][$x].
	"</td></tr>";
*/

}

echo "<pre>";
//print_r($data[8]);
echo "</pre>";

mysqli_close($conn);
?>

</table>

<!-- START SVG -->

<svg width="<?php echo $svgwidth; ?>" height="1500">

<?php

echo '<rect x='. $start .' y=0 width='.$width.' height='.$data[5][0].' 		
style="fill:'.$data[3][0].' ;stroke-width:
0;stroke:rgb(0,0,0)" />';

for($x = 0; $x < ($cnt); $x++) {

	echo '<rect x='. $data[8][$x].' y='.$data[9][$x].' width='.	$width.' height='.$data[5][$x].' 
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

</body>
</html>