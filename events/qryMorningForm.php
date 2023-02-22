<?php
header("Cache-Control: no-cache, must-revalidate");

include('../function/Functions.php');
include('../function/SqlList.php');

pconn();

setQTime();

$qryETimes = "SELECT ActID, ProID, CONCAT(ActID, ProID) as AC, COUNT(*) AS cnt, DATEDIFF (NOW(), MAX(STime)) AS LTime, TIME_FORMAT(TIMEDIFF(NOW(), MAX(STime)), '%k:%i') AS LT2 FROM tblEvents GROUP BY ActID, ProID ORDER BY LTime";

$arrETimes = array();

$resETimes = mysqli_query($conn, $qryETimes);

while ($row = mysqli_fetch_array($resETimes)) {
	$arrETimes[$row['AC']][]=$row['LTime'];
	$arrETimes[$row['AC']][]=$row['LT2'];
}

$result = mysqli_query($conn, $sqlDailyEvents);

$events = array();

while ($row = mysqli_fetch_array($result)) {
	$events[0][] = $row['STime'];
	
	$Act = $row['ActID'];
	
	$Cont = $row['ContID'];
	
	$A = $row['ActID'].$row['ContID'];
	
	$X = preg_replace("/[^a-zA-Z0-9]/", "", $A);

	$events[1][] = $X;

}

$cnt=count ($events[0]);

$events[0][] = $NowTime;

for($x = 0; $x < ($cnt); $x++) {
	$events[2][] = getsecs($events[0][$x], $events[0][$x+1]);
}

$actlist = array();

foreach((array_unique($events[1])) as $v){
	$actlist[]=$v;
}

$cnt1=count ($actlist);

$arrActList = array();

for($y = 0; $y < ($cnt1); $y++) {

$arrSum = array();

	for($x = 0; $x < ($cnt); $x++) {
		if($events[1][$x] == $actlist[$y]){
        		$arrSum[] = $events[2][$x];
        	}
        		
    	}


$arrActList[$actlist[$y]] = array_sum($arrSum);

}

?>