<?php
include("../function/Functions.php");

pconn();

$tbl = 'tblSchedEvents';

date_default_timezone_set('America/New_York');


if (!function_exists('eventbtnjqs1')) {
function eventbtnjqs1($act, $cont, $btnname, $tbl){
    
    $btnid0 = $act.$cont;
    
    $btnid = preg_replace("/[^a-zA-Z0-9]/", "", $btnid0);
    
    echo "<button id='$btnid' onclick=\"btnJQs('$act', '$cont', '$btnid', '$tbl')\">$btnname</button>";
}
}

//Queries and Arrays

$data = array();
 
$selDate = $_REQUEST["selDate"] ?? null;
$selTime = $_REQUEST["selTime"] ?? null;

if($selDate==null){
    $SQTime = date_create(date('Y-m-d'));
    $NowHr = date("G");
    $NowD1 = date("N");
}
else{
    $SQTime = date_create($selDate);
    $NowHr = date("G", strtotime($selTime));
    $NowD1 = date("N", strtotime($selDate));
}

date_modify($SQTime, '-21 days');
$SQTime = date_format($SQTime,'Y-m-d');

If($NowD1<6){
	$NowD = 1;
}
else{
	$NowD = 0;
}

if(isset($selHrRange)){
    $MinHr = $NowHr - $selHrRange;
    $MaxHr = $NowHr + $selHrRange;
}else{
    $MinHr = $NowHr - 3;
    $MaxHr = $NowHr + 3;
}

$sql = "SELECT EXTRACT( HOUR FROM tblEvents.STime ) AS EventHr,
    WEEKDAY(tblEvents.STime) AS EventDay,
    IF(WEEKDAY(tblEvents.STime)>4,0,1) AS WKI,
    tblEvents.ActID,
    tblEvents.ProID,
    tblAct.ActDesc,
    tblCont.ContDesc,
    COUNT( * ) AS cnt
    FROM tblEvents
    INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID
    INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID
    INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID
    WHERE tblProj.ProjStatus !=  'Closed'
    AND DATE( tblEvents.STime ) >=  '$SQTime'
    AND tblAct.Status !=  'Inactive'
    AND tblCont.Active != 'N'
    AND EXTRACT( HOUR FROM tblEvents.STime ) BETWEEN $MinHr AND $MaxHr
    AND (IF(WEEKDAY(tblEvents.STime)>4,0,1) = $NowD)
    GROUP BY tblAct.ActID, tblCont.ContID
    ORDER By tblAct.ActDesc,  tblCont.ContID";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
    $data[0][] = $row['ActID'];
    $data[1][] = $row['ProID'];
    $data[2][] = $row['ActDesc'] . "<br>" . $row['ContDesc'];
}

mysqli_close($conn);

$btncnt=count($data[0]);

//Button Set

$rowcounter=1;

$btncounter=0;

$rowbtns=4;

$rownum=floor($btncnt/$rowbtns);

$lrowbtns=$btncnt%$rowbtns;

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
        
        eventbtnjqs1($act, $cont, $btnname, $tbl);
        
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
        
        eventbtnjqs1($act, $cont, $btnname, $tbl);
        
        echo "</td>";
        
        $btncounter++;
    }
    echo "</tr>";
}
echo "</table>";
?>