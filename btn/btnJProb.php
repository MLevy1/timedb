<?php
header("Cache-Control: no-cache, must-revalidate");
include('../function/Functions.php');
?>
<script src='../function/JSFunctions.js'></script>

<?php
pconn();

formid();

setQTime();

$prob = array();

$NowHr = date("G");
$NowD1 = date("w");
$NowM = date("n");

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
	$ndata[12][] = $ndata[3][$x+1];	
	
	//Store next Cont
	$ndata[13][] = $ndata[4][$x+1];
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

$sql = "SELECT col1, col2, NEAct, NECont, tblAct.ActDesc, tblCont.ContDesc, COUNT(col2) AS CNT
FROM tblNextEvent
INNER JOIN  tblAct ON tblNextEvent.NEAct=tblAct.ActID
INNER JOIN  tblCont ON tblNextEvent.NECont=tblCont.ContID
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
	$arrResults[5][] = $row['ActDesc'];
	$arrResults[6][] = $row['ContDesc'];
}

$cnt=count ($arrResults[0]);

$n = array_sum($arrResults[4]);

for($x = 0; $x < ($cnt); $x++) {
/*
	echo "<tr>";
	echo "<td>".$arrResults[2][$x]."</td>";
	echo "<td>".$arrResults[3][$x]."</td>";
	echo "<td>".$arrResults[4][$x]."</td>";
	echo "<td>".ROUND(($arrResults[4][$x]/$n)*100,2)."%</td>";
	"</tr>";
*/

	$prob[$arrResults[2][$x].$arrResults[3][$x]][0]= ($arrResults[4][$x]/$n);
	
	$prob[$arrResults[2][$x].$arrResults[3][$x]][3]= $arrResults[2][$x];
	
	$prob[$arrResults[2][$x].$arrResults[3][$x]][4]= $arrResults[3][$x];
	
	$prob[$arrResults[2][$x].$arrResults[3][$x]][5]= $arrResults[5][$x];
	
	$prob[$arrResults[2][$x].$arrResults[3][$x]][6]= $arrResults[6][$x];
	
	$p = $p + ($arrResults[4][$x]/$n);
	
}


$clear = 'TRUNCATE TABLE tblNextEvent';


$sql = "SELECT EXTRACT( HOUR FROM tblEvents.STime ) AS EventHr, 
WEEKDAY(tblEvents.STime) AS EventDay,
tblEvents.STime, tblAct.ActID, tblCont.ContID, COUNT(tblEvents.STime) AS Cnt, tblAct.ActDesc, tblCont.ContDesc FROM tblEvents
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
	$data[2][] = $row['ActID'];
	$data[3][] = $row['ContID'];
	$data[4][] = $row['ActDesc'];
	$data[5][] = $row['ContDesc'];

}

$n = array_sum($data[0]);

mysqli_close($conn);

$cnt= count ($data[3]);

$p=0;

for($x = 0; $x < ($cnt); $x++) {
	if(ROUND(($data[0][$x]/$n),2)>0){
	
	$prob[$data[2][$x].$data[3][$x]][1]= $data[0][$x]/$n;
	
	$prob[$data[2][$x].$data[3][$x]][3]= $data[2][$x];
	
	$prob[$data[2][$x].$data[3][$x]][4]= $data[3][$x];
	
	$prob[$data[2][$x].$data[3][$x]][5]= $data[4][$x];
	
	$prob[$data[2][$x].$data[3][$x]][6]= $data[5][$x];
	
	$p = $p + ($data[0][$x]/$n);
	
	}
}

$p2 = 0;

$btncnt = 0;

$wp = array();

$data = array();

foreach($prob as $x => $xval) {
	
	$wp[$x][0] = ($xval[0]*0.6)+($xval[1]*0.4);
	$wp[$x][1] = $xval[3];
	$wp[$x][2] = $xval[4];	
	$wp[$x][3] = $xval[5];	
	$wp[$x][4] = $xval[6];	
}

arsort($wp);

foreach($wp as $x => $xval) {
	
	$data[0][] = $xval[1];
	$data[1][] = $xval[2];
	$data[2][] = $xval[3]." ".$xval[4];
	$btncnt++; 
	
}

//Button Set

$rowcounter=1;

$btncounter=0;

$rowbtns=4;

$rownum=floor($btncnt/$rowbtns);

$lrowbtns=$btncnt%$rowbtns;

include("../sch/ViewCurSchEvent.php");

echo "<table width='100%'>";

if($btncnt>=$rowbtns){
while ($rowcounter<=$rownum){
    echo "<tr>";
    $rowbtncounter=1;

    while ($rowbtncounter<=$rowbtns){
        
        $act = $data[0][$btncounter];
        $cont = $data[1][$btncounter];
        $btnname = $data[2][$btncounter];
        
        echo "<td width='25%'>";
        
        eventbtnjq($act, $cont, $btnname, 'p', $selHrRange);
        
        echo "</td>";
        
        $btncounter++;
        $rowbtncounter++;
    }
    
echo "</tr>";
$rowcounter++;
}
}
if ($lrowbtns!=0){
    echo "<tr>";
    for ($i = 0; $i < $lrowbtns; $i++) {
    
        $act = $data[0][$btncounter];
        $cont = $data[1][$btncounter];
        $btnname = $data[2][$btncounter];
        
        echo "<td width='25%'>";
        
        eventbtnjq($act, $cont, $btnname, 'p', $selHrRange);
        
        echo "</td>";
        
        $btncounter++;
    }
    echo "</tr>";
}
echo "</table>";
mysqli_close($conn);
?>