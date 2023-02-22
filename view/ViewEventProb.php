<?php
header("Cache-Control: no-cache, must-revalidate");
include('../function/Functions.php');
?>
<script src='../function/JSFunctions.js'></script>

<h1>Day and Time</h1>
<?php
pconn();

formid();

setQTime();

$prob = array();

$NowHr = date("G");
$NowD1 = date("w");
$NowM = date("n");
?>


<h1>Last</h1>

<?php

pconn();

date_default_timezone_set('America/New_York');
$QTime = date('Y-m-d');
$NowTime = date("Y-m-d H:i:s");

$SQTime = date_create(date('Y-m-d'));
date_modify($SQTime, '-21 days');
$SQTime = date_format($SQTime,'Y-m-d');

$lsql = "SELECT STime, ActID, ProID FROM tblEvents ORDER BY STime DESC LIMIT 1";

$lresult = mysqli_query($conn, $lsql);

$ldata = array();

$p=0;

while ($lrow = mysqli_fetch_array($lresult)) {
	$ldata[0][] = $lrow['ActID'];
	$ldata[1][] = $lrow['ProID'];
}

$lact = $ldata[0][0];

$lcont = $ldata[1][0];

$par = $lact.'|'.$lcont;

//AND DATE( tblEvents.STime ) >=  '$SQTime'

//AND EXTRACT( MONTH FROM tblEvents.STime ) = $NowM


$sql = "SELECT tblEvents.STime, tblEvents.ActID, tblEvents.ProID, tblAct.ActDesc, tblCont.ContDesc
FROM tblEvents 
INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID
INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID
INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID
WHERE tblProj.ProjStatus !=  'Closed'
AND EXTRACT( MONTH FROM tblEvents.STime ) = $NowM
AND tblAct.Status !=  'Inactive'
AND tblCont.Active != 'N'
ORDER BY tblEvents.STime";

$result = mysqli_query($conn, $sql);

$ndata = array();

while ($row = mysqli_fetch_array($result)) {
	$ndata[1][] = $row['STime'];
	$ndata[2][] = date_create($row['STime']);
	$ndata[3][] = $row['ActID'];
	$ndata[4][] = $row['ProID'];
	$ndata[5][] = $row['StartTime'];
	$ndata[6][] = $row['ActDesc'];
	$ndata[7][] = $row['ContDesc'];
}

$cnt=count ($ndata[1]);

$ndata[1][] = $NowTime;
$ndata[2][] = date_create($NowTime);

for($x = 0; $x < $cnt; $x++) {
	
	//Store current event Act and Cont combo
	$ndata[9][] = $ndata[3][$x] . "|" . $ndata[4][$x];
	
	//Store next event Act and Cont combo
	$ndata[10][] = $ndata[3][$x+1] . "|" . $ndata[4][$x+1];
	
	//Store combo of current and next event Act and Cont combos
	$ndata[11][] = $ndata[3][$x] . "|" . $ndata[4][$x] . "_" . $ndata[3][$x+1] . "|" . $ndata[4][$x+1];
	
	//Store next Act
	$ndata[12][] = $ndata[6][$x+1];	
	
	//Store next Cont
	$ndata[13][] = $ndata[7][$x+1];
}

//Reset the Test Array, which will be used to setup the query that will insert Activity Descriptions and Durations into the Test table
$arrTest = array();

//Setup clear table query
$clear = 'TRUNCATE TABLE tblNextEvent';

//Execute clear table query
mysqli_query($conn, $clear);

//Setup insert values query
$query = "INSERT INTO tblNextEvent (`col1`, `col2`, `col3`, `NEAct`, `NECont`) VALUES ";

//Use for loop to itterate through each of the events stored in the Act and Dur arrays
for($x=0; $x<($cnt-1); $x++){

	$arrTest[] = "('" . $ndata[9][$x] . "', '" . $ndata[11][$x] . "', '" . $ndata[10][$x] . "', '" . $ndata[12][$x] .  "', '" . $ndata[13][$x]  .  "')";
}

//Create query used to populate Test table with contents of Act and Dur arrays
$pop = $query .= implode(',', $arrTest);

//Execute the populate table query
mysqli_query($conn, $pop);

$sql = "SELECT col1, col2, NEAct, NECont, COUNT(col2) AS CNT
FROM tblNextEvent
WHERE col1 = '$par'
AND col3 != '$par'
GROUP BY col2 
ORDER BY col1, CNT DESC";

//Execute above query
$result = mysqli_query($conn, $sql);

$arrResults = array();

//Store query results in col1 and col2 arrays
while ($row = mysqli_fetch_array($result)) {
	$arrResults[0][] = $row['col1'];
	$arrResults[1][] = $row['col2'];
	$arrResults[2][] = $row['NEAct'];
	$arrResults[3][] = $row['NECont'];
	$arrResults[4][] = $row['CNT'];
}

$cnt=count ($arrResults[0]);

$n = array_sum($arrResults[4]);
?>

<table width='100%'>
	<th><b>Act. Desc.</th>
	<th><b>Cont. ID</th>
	<th><b>Cnt</th>
	<th><b>Prob</th>

<?php
for($x = 0; $x < ($cnt); $x++) {
	echo "<tr>";
	echo "<td>".$arrResults[2][$x]."</td>";
	echo "<td>".$arrResults[3][$x]."</td>";
	echo "<td>".$arrResults[4][$x]."</td>";
	echo "<td>".ROUND(($arrResults[4][$x]/$n)*100,2)."%</td>";
	"</tr>";
	
	$prob[$arrResults[2][$x].$arrResults[3][$x]][0]= ($arrResults[4][$x]/$n);
	
	$prob[$arrResults[2][$x].$arrResults[3][$x]][3]= $arrResults[2][$x];
	
	$prob[$arrResults[2][$x].$arrResults[3][$x]][4]= $arrResults[3][$x];
	
	$p = $p + ($arrResults[4][$x]/$n);
	
}

echo "</table>";

echo "p= ".$p;
echo "n= ".$n;

$clear = 'TRUNCATE TABLE tblNextEvent';

mysqli_query($conn, $clear);

//mysqli_close($conn);
?>





<?php



$sql = "SELECT EXTRACT( HOUR FROM tblEvents.STime ) AS EventHr, 
WEEKDAY(tblEvents.STime) AS EventDay,
tblEvents.STime, tblAct.ActDesc, tblCont.ContDesc, COUNT(tblEvents.STime) AS Cnt FROM tblEvents
	INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID
    INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID 
    INNER JOIN tblProj ON tblProj.ProjID = tblCont.ProjID
    WHERE EXTRACT( HOUR FROM tblEvents.STime ) = $NowHr AND
    WEEKDAY(tblEvents.STime)+1 = $NowD1 
    AND tblProj.ProjStatus <> 'Closed'
    AND tblCont.Active <> 'N'
    AND tblAct.Status !=  'Inactive'
    AND CONCAT(tblAct.ActID, '|', tblCont.ContID) != '$par'
    GROUP BY tblAct.ActID, tblCont.ContID 
    ORDER BY Cnt DESC";


$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {

	$data[0][] = $row['Cnt'];
	$data[1][] = date_create($row['STime']);
	$data[2][] = $row['ActDesc'];
	$data[3][] = $row['ContDesc'];

}

$n = array_sum($data[0]);

mysqli_close($conn);

$cnt= count ($data[3]);

?>
<table width='100%'>
	<th><b>Act. Desc.</th>
	<th><b>Cont. ID</th>
	<th><b>Cnt</th>
	<th><b>Prob</th>
<?php
$p=0;
for($x = 0; $x < ($cnt); $x++) {
	if(ROUND(($data[0][$x]/$n),2)>0){
	echo "<tr>";
	echo "<td>".$data[2][$x]."</td>";
	echo "<td>".$data[3][$x]."</td>";
	echo "<td>".$data[0][$x]."</td>";
	echo "<td>".ROUND(($data[0][$x]/$n),2)."</td></tr>";
	
	$prob[$data[2][$x].$data[3][$x]][1]= $data[0][$x]/$n;
	
	$prob[$data[2][$x].$data[3][$x]][3]= $data[2][$x];
	
	$prob[$data[2][$x].$data[3][$x]][4]= $data[3][$x];
	
	
	$p = $p + ($data[0][$x]/$n);
	
	}
}

echo "</table>";
echo "n=".$n;
echo "p=".$p;
?>












<h1>Weighted</h1>

<?php
$p2 = 0;

$wp = array();

foreach($prob as $x => $xval) {
	
	//$wp[$x] = ($xval[0]*0.6)+($xval[1]*0.4);
	
	$wp[$x][0] = ($xval[0]*0.6)+($xval[1]*0.4);
	$wp[$x][1] = $xval[3];
	$wp[$x][2] = $xval[4];	
}

arsort($wp);

echo "<table>";

foreach($wp as $x => $xval) {
	
	
	echo "<tr><td>";
	echo $xval[1];
	echo "</td><td>";
	echo $xval[2];
	echo "</td><td>";
	echo $xval[0];
	echo "</td></tr>";
	
	//echo ROUND(($xval * 100),2)."%";
	
	//echo "<br>";
	
	$p2 = $p2 + $xval[0];
	
}

echo "p2 = ".$p2;
?>
