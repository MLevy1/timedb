<?php
header("Cache-Control: no-cache, must-revalidate");
include('../function/Functions.php');

pconn();

formid();

$tbl="tblEvents";
$varSel="StartTime";

//setQTime();

$sql = "SELECT tblEvents.StartTime, tblEvents.STime, tblAct.ActDesc, tblCont.ContDesc 
FROM tblEvents
INNER JOIN tblAct 
ON tblEvents.ActID = tblAct.ActID
INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID
ORDER BY Stime";

$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_array($result)) {

	$data[0][] = $row['STime'];
	$data[1][] = date_create($row['STime']);
	$data[2][] = $row['ActDesc'];
	$data[3][] = $row['ContDesc'];
	$data[4][] = $row['StartTime'];
}

mysqli_close($conn);

$cnt=((count ($data, COUNT_RECURSIVE))/count($data))-1;

$data[0][] = $NowTime;
$data[1][] = date_create($NowTime);

if ($form=='../view/FooterEventQueries.php'){
$form='../form/FormDynamicJQ.php';
}
?>
<table width='100%'>
	<th><b>Start</th>
	<th><b>Act. Desc.</th>
	<th><b>Cont. ID</th>
	<th><b>Time</th>
<?php
for($x = 0; $x < ($cnt); $x++) {
	echo "<tr>";
	echo "<td class='mtblcell3'>".
	date_format($data[1][$x], 'Y-m-d h:i A').
	"</td>";
	for($y = 2; $y <= 3; $y++) {
		echo "<td class='mtblcell2'>".$data[$y][$x]."</td>";
	}
	echo "<td class='mtblcell3'>".
	gethours(getmins($data[0][$x], $data[0][$x+1])).
	":".
	DZero(getrmins(getmins($data[0][$x], $data[0][$x+1]), gethours(getmins($data[0][$x], $data[0][$x+1])))).
	"</td></tr>";
}
?>
</table>

<?php

$file = "backup.txt";
$f = fopen($file, 'w');

for($x = 0; $x < ($cnt); $x++) {
	$b = $data[0][$x]."|".$data[2][$x]."|".$data[3][$x]."\n";
	fwrite($f, $b);
}


/*
$h = fopen('backup.txt', 'w');
fwrite($h, print_r($data, true));
*/

fclose($f);

echo "<a href=backup.txt>TEST!</a>";
?>