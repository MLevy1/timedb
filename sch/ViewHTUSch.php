<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../styles.css" />
</head>
<body>

<?php
include('../function/Functions.php');

pconn();

$selDate = $_REQUEST["selDate"] ?? date('Y-m-d');

$SDate1 = $selDate;
$EDate1 = $selDate;

$SDate = date_create($SDate1);

$SDate = date_format($SDate,"Y-m-d");

$EDate = date_create($EDate1);

$EDate = date_format($EDate,"Y-m-d");

//Create variable to hold the day after the selected end date

$EDate2 = date_create($EDate1);

date_add($EDate2, date_interval_create_from_date_string("1 day"));

//Text fromated day after the end day
$EDate2 = date_format($EDate2,"Y-m-d");

//Create variable to hold the name and path of the current page

$dtest = array();


//MIDNIGHT FIX

$SDate0 = date( "Y-m-d", strtotime( "$SDate1 -1 day" ) );

$EDate0 = date( "Y-m-d", strtotime( "$EDate1 -0 day" ) );

//Pull last events from each selected day
$LSql = "SELECT DATE(SESTime) AS cDay, SESTime, Color
FROM tblSchedEvents 
INNER JOIN tblCont 
ON (tblSchedEvents.SEContID=tblCont.ContID) 
INNER JOIN tblAct 
ON (tblSchedEvents.SEActID=tblAct.ActID) 
INNER JOIN tblPUCodes ON tblAct.UCode = tblPUCodes.PUCode
WHERE SESTime 
	IN (
		SELECT MAX(SESTime) 
		FROM tblSchedEvents 
		GROUP BY DATE(SESTime)
	) 
AND DATE(SESTime) BETWEEN CAST('$SDate0' AS DATE) AND CAST('$EDate0' AS DATE)";

$result = mysqli_query($conn, $LSql);

$ldata = array();

while ($row = mysqli_fetch_array($result)) {
	
	$a = $row['cDay'];
		
	//$dtest[date( "Y-m-d H:i", strtotime( "$a +1 day" ) )][] = $row['WKI'];
	$dtest[date( "Y-m-d H:i", strtotime( "$a +1 day" ) )][] = $row['Color'];
	
}

echo "<pre>";
//print_r($dtest);
echo "</pre>";

//END MIDNIGHT FIX

//Setup query containing all events between selected start and end date

$sql = "SELECT SESTime, Color
FROM tblSchedEvents
INNER JOIN tblCont 
ON (tblSchedEvents.SEContID=tblCont.ContID) 
INNER JOIN tblAct 
ON (tblSchedEvents.SEActID=tblAct.ActID)
INNER JOIN tblPUCodes ON tblAct.UCode = tblPUCodes.PUCode
WHERE date(SESTime) BETWEEN '$SDate' AND '$EDate'  
ORDER BY SESTime";

//Run above queries

$result = mysqli_query($conn, $sql);

//Reset arrays for results

$data = array();

//Populate arrays with results of all events query

while ($row = mysqli_fetch_array($result)) {
       
    	//$dtest[$row['STime']][] = $row['WKI'];
	$dtest[$row['SESTime']][] = $row['Color'];
	
}


//print_r($dtest);

//Free $result variable
mysqli_free_result($result);

ksort($dtest);

$arrnew = array();

foreach($dtest as $x => $xval) {
	
	$data[0][]=$x;
	$data[1][]=date_create($x);
	$data[2][]=$xval[0];
	//$data[3][]=$xval[1];

}

//Count rows in arrays

if (isset($data[0])) {
    $cnt = count($data[0]);
} else {
    $cnt = 0;
}


$SDate = date_create($SDate1);

//fill Dur, Hrs, and Mins arrays
for($x = 0; $x < ($cnt); $x++) {
	$arrDur[] = getmins($data[0][$x], $data[0][$x+1]);
  
	//# of days from start date
	$arrETime[0][] = $data[1][$x] ->diff($SDate)->format("%a");
   
	//#of mins from midnight start date
	$arrETime[1][] = $arrETime[0][$x]*1440;
 
}

//2/23/23: Already defined above
//$cnt= count ($data[0]);

$dcnt = max($arrETime[0])+1;

$svgwidth = 960;

$start = 0;

$pwidth = ($svgwidth - $start) / $dcnt;

if($pwidth<50){
	$width=$pwidth;
}else{
	$width = 50;
}


for($x = 0; $x < ($cnt); $x++) {
	
	$data[5][] = getsecs($data[0][$x], $data[0][$x+1])/90;
	
	if($x == 0){

		$data[6][] = $data[5][0];

		$data[7][] = $data[6][0];

		//Distance from the edge
		$data[8][] = $start;

		$data[9][] = 0;
	}
	else{
	
	$data[6][] = $data[6][$x-1]+$data[5][$x];
	
	$data[7][] = $data[6][$x]-($arrETime[0][$x] * 1400);
	
	$data[8][] = $start + ($width * $arrETime[0][$x]);

	$data[9][] = $data[6][$x-1]-($arrETime[0][$x] * 1440);
	}
}

mysqli_close($conn);
?>

</table>

<!-- START SVG -->

<svg width="<?php echo $svgwidth; ?>" height="50">

<?php

echo '<rect x=0 y=0 width='.$data[5][0].' height=50 
style= "fill:'.$data[2][0].' ;stroke-width:
0;stroke:rgb(0,0,0)" />';


for($x = 0; $x < ($cnt); $x++) {
	
	echo '<rect x='. $data[9][$x].' y=0 width='.	$data[5][$x].' height=50 
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