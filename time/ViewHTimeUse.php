<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../styles.css" />
</head>
<body>
<?php
include('../function/Functions.php');

pconn();

//Set variable to today's date
$SDate1 = date('Y-m-d');

//Create date from date variable 
$SDate = date_create($SDate1);

$SDate = date_format($SDate,"Y-m-d");

$dtest = array();

$SDate0 = date( "Y-m-d", strtotime( "$SDate1 -1 day" ) );

//Pull last event from prior day
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
AND DATE(STime) = '$SDate0'";

$lresult = mysqli_query($conn, $LSql);

while ($row = mysqli_fetch_array($lresult)) {

	$a = $row['cDay'];

	$dtest[date( "Y-m-d H:i", strtotime( "$a +1 day" ) )][] = $row['Color'];
	
}

//select all events in current day

$sql = "SELECT STime, Color
FROM tblEvents
INNER JOIN tblCont 
ON (tblEvents.ProID=tblCont.ContID) 
INNER JOIN tblAct 
ON (tblEvents.ActID=tblAct.ActID)
INNER JOIN tblPUCodes ON tblAct.UCode = tblPUCodes.PUCode
WHERE date(STime) = '$SDate' 
ORDER BY STime";

//Run above query

$result = mysqli_query($conn, $sql);

//Reset arrays for results

$data = array();
$dtest = array();

//Populate arrays with results of all events query

while ($row = mysqli_fetch_array($result)) {

	$dtest[$row['STime']][] = $row['Color'];
	
}

//Free $result variable
mysqli_free_result($result);

ksort($dtest);

$arrnew = array();

foreach($dtest as $x => $xval) {
	
	$data[0][]=$x;
	$data[1][]=date_create($x);
	$data[2][]=$xval[0];

}

//Count rows in arrays

if (isset($data[0])) {
    $cnt = count($data[0]);
} else {
    $cnt = 0;
}

$SDate = date_create($SDate1);

$svgwidth = 960;

$start = 0;

//Set Current Date Variables

$NowTime = date("Y-m-d H:i:s");

	//Add row to end of arrays with current date and time

	$data[0][] = $NowTime;
	$data[1][] = date_create($NowTime);

?>

<!-- START EVENT LIST -->

<?php

for($x = 0; $x < ($cnt); $x++) {
	
	//sets width of bar at number of seconds in each event / 90
	
	$data[3][] = getsecs($data[0][$x], $data[0][$x+1])/90;
	
	if($x == 0){

		//for the first event, the start (data5) is set at 0 and the end (data 4) is set to the event duration (data 3).

		$data[4][] = $data[3][0];

		$data[5][] = 0;
	}
	else{
	
	//for all other events, the start (data5) is set at the end of the last event (data4 x-1) and the end (data 4) is set to the event duration (data 3) added to the end of the last event (data4 x-1).
	
	$data[4][] = $data[4][$x-1]+$data[3][$x];
	
	$data[5][] = $data[4][$x-1];
	
	}

}

mysqli_close($conn);
?>

</table>

<!-- START SVG -->

<svg width="<?php echo $svgwidth; ?>" height="50">

<?php

//data 2=color; data 3=duration data 5=start

echo '<rect x=0 y=0 width='.$data[3][0].' height=50 
style= "fill:'.$data[2][0].' ;stroke-width:
0;stroke:rgb(0,0,0)" />';


for($x = 0; $x < ($cnt); $x++) {
	
	echo '<rect x='. $data[5][$x].' y=0 width='.	$data[3][$x].' height=50 
	style="fill:'.$data[2][$x].';stroke-width:
	0;stroke:rgb(0,0,0)" />';
}

?>
	<text x="0" y="25" style="fill:white;" font-weight="bold" font-size=10>12A
	<tspan x="120" y="25">3A</tspan>
	<tspan x="240" y="25">6A</tspan>
	<tspan x="360" y="25">9A</tspan>
	<tspan x="480" y="25">12P</tspan>
	<tspan x="600" y="25">3P</tspan>
	<tspan x="720" y="25">6P</tspan>
	<tspan x="840" y="25">9P</tspan>
	<tspan x="930" y="25">12A</tspan>
  </text>
  
</svg>

</body>
</html>