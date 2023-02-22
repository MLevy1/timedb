<?php
header("Cache-Control: no-cache, must-revalidate");

include('../function/Functions.php');

pconn();

date_default_timezone_set('America/New_York');

$TestTime = $_REQUEST["TestTime"];

if($TestTime==null){
$TestTime = "2018-04-28 10:00:00";
}

$sql = "SELECT tblSchedEvents.SESTime, tblAct.ActID, tblCont.ContID FROM tblSchedEvents INNER JOIN tblCont ON (tblSchedEvents.SEContID= tblCont.ContID) INNER JOIN tblAct ON (tblSchedEvents.SEActID = tblAct.ActID) WHERE tblSchedEvents.SESTime <'$TestTime' ORDER BY tblSchedEvents.SESTime DESC LIMIT 1";

$result = mysqli_query($conn, $sql);

$ndata = array();

while ($row = mysqli_fetch_array($result)) {
	$ndata[] = $row['ActID'];
	$ndata[] = $row['ContID'];
}

echo $ndata[0]."|".$ndata[1];

mysqli_close($conn);
?>
