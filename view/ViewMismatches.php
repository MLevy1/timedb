<?php
header("Cache-Control: no-cache, must-revalidate");
include('../function/Functions.php');
?>
<script src='../function/JSFunctions.js'></script>
<script>
function btnJQDelE(a, b, c)
{
	$.post("../del/DelJQ.php",
	{
		v1: a,
		c1: b,
		selTbl: c
	});
	setTimeout(function(){
        UpdateEvents();
        }, 1000);
}

function adjSecs()
{



}
</script>

<?php
pconn();

formid();

$tbl="tblEvents";
$varSel="StartTime";

setQTime();

$sql = "SELECT tblEvents.StartTime, tblEvents.STime, tblAct.ActDesc, tblCont.ContDesc, TIMEDIFF(tblEvents.STime, tblEvents.StartTime) AS TD, SECOND(tblEvents.StartTime) AS STS FROM tblEvents
	INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID
    INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID WHERE ABS(TIMEDIFF(tblEvents.STime, tblEvents.StartTime))<TIME('0:01:00') AND ABS(TIMEDIFF(tblEvents.STime, tblEvents.StartTime))>TIME('0:00:01') ORDER BY Stime DESC";


$result = mysqli_query($conn, $sql);

$data = array();

$data[0][] = $NowTime;
$data[1][] = date_create($NowTime);

while ($row = mysqli_fetch_array($result)) {

	$data[0][] = $row['STime'];
	$data[1][] = date_create($row['STime']);
	$data[2][] = $row['ActDesc'];
	$data[3][] = $row['ContDesc'];
	$data[4][] = $row['StartTime'];
	$data[5][] = $row['TD'];
	$data[6][] = $row['STS'];
}

mysqli_close($conn);

$cnt= count ($data[4]);

echo $cnt;

if ($form=='../view/FooterEventQueries.php'){
$form='../form/FormDynamicJQ.php';
}
?>
<table width='100%'>
	<th><b>StartTime</th>
	<th><b>STime</th>
	<th><b>Diff</th>
	<th><b>Act. Desc.</th>
	<th><b>Cont. ID</th>
	<th><b>Time</th>
<?php
for($x = 0; $x < ($cnt); $x++) {
	echo "<tr>";
	echo "<td class='mtblcell3'>";
	echo $data[4][$x];
	echo "</td>";
	echo "<td class='mtblcell3'>";
	echo $data[5][$x];
	echo "</td>";
	echo "<td class='mtblcell3'>".
	date_format($data[1][$x+1], 'D Y-n-d G:i:s A').
	"</td>";
	for($y = 2; $y <= 3; $y++) {
		echo "<td class='mtblcell2'>".$data[$y][$x]."</td>";
	}
	echo "<td>".$data[6][$x]."</td>";
	echo "<td class='doublecol'>".
	("<input type=\"button\" class=\"link\" onclick=\"location.href='../form/FormUpdateEvent0.php?form=$form&selEvent={$data[4][$x]}'\" value=\"U\"</input>").
	"</td><td class='doublecol'>".
	("<input type=\"button\" class=\"link\" onclick=\"btnJQDelE('{$data[4][$x]}', 'StartTime', 'tblEvents') 
       \" value=\"D\"</input>") .
	"</td></tr>";
}
?>
</table>