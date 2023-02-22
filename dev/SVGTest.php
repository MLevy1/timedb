<!DOCTYPE html>
<html>
<body>

<?php
header("Cache-Control: no-cache, must-revalidate");

include('../function/Functions.php');
?>
<script src='../function/JSFunctions.js'></script>

<?php
pconn();

$QTime = date('Y-m-d');
$NowTime = date("Y-m-d H:i:s");

$sql = "SELECT tblEvents.StartTime, tblEvents.STime, tblAct.ActDesc, tblCont.ContDesc, tblAct.UCode, tblPUCodes.Color FROM tblEvents
	INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID
	INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID
	INNER JOIN tblPUCodes ON tblAct.UCode = tblPUCodes.PUCode
	WHERE date(tblEvents.STime) ='$QTime' ORDER BY STime";

$result = mysqli_query($conn, $sql);

$data = array();

/*
$data[0][] = $NowTime;
$data[1][] = date_create($NowTime);
*/

$data[0][] = $QTime;
$data[1][] = date_create($QTime);
$data[2][] = 'N';
$data[3][] = 'black';
$data[4][] = 'sleep';

while ($row = mysqli_fetch_array($result)) {

	$data[0][] = $row['STime'];
	$data[1][] = date_create($row['STime']);
	$data[2][] = $row['UCode'];
	$data[3][] = $row['Color'];
	$data[4][] = $row['ActDesc'];

}

$data[0][] = $NowTime;
$data[1][] = date_create($NowTime);

/*
$data[0][] = $QTime;
$data[1][] = date_create($QTime);
$data[2][] = 'N';
$data[3][] = 'black';
*/
mysqli_close($conn);

$cnt= count ($data[0])-1;

?>

<table>

<?php
for($x = 0; $x < ($cnt); $x++) {

	$data[5][] = getmins($data[0][$x], $data[0][$x+1]);
	
	if($x == 0){
		$data[6][] = $data[5][0];
	}
	else{
	$data[6][]=$data[6][$x-1]+$data[5][$x];
	}

	echo "<tr><td>".
	date_format($data[1][$x], 'h:i A').
	"</td><td>".
	$data[2][$x].
	"</td><td>".
	$data[5][$x].
	"</td><td>".
	$data[3][$x].
	"</td><td>".
	$data[6][$x].
	"</td><td>".
	$data[4][$x].
	"</td></tr>";
	
}
?>
</table>

<h1>My First SVG</h1>

<?php

$width = 50;

?>

<svg width="400" height="1440">
<?php

echo '<rect x=5 y=0 width='.$width.' 		height='.$data[5][0].' 		
style="fill:'.$data[3][0].' ;stroke-width:
0;stroke:rgb(0,0,0)" />';

for($x = 0; $x < ($cnt); $x++) {

	echo '<rect x=5 y='.$data[6][$x-1].' width='.	$width.' height='.$data[5][$x].' 
	style="fill:'.$data[3][$x].';stroke-width:
	0;stroke:rgb(0,0,0)" />';
}

?>
    
</svg>

</body>
</html>