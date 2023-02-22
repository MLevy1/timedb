<?php
header("Cache-Control: no-cache, must-revalidate");
include('../function/Functions.php');
?>
<script src='../function/JSFunctions1.js'></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script>
function btnJQDelE(a, b, c)
{

var result = confirm("Delete record?");

if (result == true) {
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

}

</script>

<?php
pconn();

formid();

$tbl="tblEvents";
$varSel="StartTime";

setQTime();

$QT1 = date( "Y-m-d", strtotime( "$QTime -1 day" ) );

//$QT1 = date( "Y-m-d", strtotime( "$QTime" ) );


$sql = "SELECT tblEvents.StartTime, tblEvents.STime, tblEvents.ActID, tblEvents.ProID, tblAct.ActDesc, tblCont.ContDesc FROM tblEvents
	INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID
    INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID WHERE date(tblEvents.STime) >='$QT1' ORDER BY Stime DESC";


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
	$data[5][] = $row['ActID'];
	$data[6][] = $row['ProID'];
}

//MIDNIGHT FIX

$SDate0 = date( "Y-m-d", strtotime( "$QTime +1 day" ) );

//$SDate0 = date( "Y-m-d", strtotime( "$QTime -1 day" ) );

//Pull last events from each selected day
$LSql = "SELECT DATE(STime) AS cDay, tblEvents.StartTime, tblEvents.STime, tblAct.ActDesc, tblCont.ContDesc, tblEvents.ActID, tblEvents.ProID
FROM tblEvents 
INNER JOIN tblCont 
ON (tblEvents.ProID=tblCont.ContID) 
INNER JOIN tblAct 
ON (tblEvents.ActID=tblAct.ActID) 
WHERE STime 
	IN (
		SELECT MAX(STime) 
		FROM tblEvents 
		GROUP BY DATE(STime)
	) 
AND DATE(STime) = CAST('$SDate0' AS DATE)";

$result = mysqli_query($conn, $LSql);

$ldata = array();

while ($row = mysqli_fetch_array($result)) {
	
	$a = $row['cDay'];
	
	$b = date( "Y-m-d H:i", strtotime( "$a +1 day" ) );
	
	$data[0][] = $b;
	$data[1][] = date_create($b);
	$data[2][] = $row['ActDesc'];
	$data[3][] = $row['ContDesc'];
	$data[4][] = $row['StartTime'];
	$data[5][] = $row['ActID'];
	$data[6][] = $row['ProID'];
}

//END MIDNIGHT FIX


mysqli_close($conn);

$cnt= count ($data[4]);

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
	date_format($data[1][$x+1], 'h:i A').
	"</td>";
	for($y = 2; $y <= 3; $y++) {
		echo "<td class='mtblcell2'>".$data[$y][$x]."</td>";
	}
	echo "<td class='mtblcell3'>".
	gethours(getmins($data[0][$x+1], $data[0][$x])).
	":".
	DZero(getrmins(getmins($data[0][$x+1], $data[0][$x]), gethours(getmins($data[0][$x+1], $data[0][$x])))).
	"</td><td class='doublecol'>".
	("<input type=\"button\" class=\"link\" onclick=\"location.href='../form/FormUpdateEvent0.php?form=$form&selEvent={$data[4][$x]}'\" value=\"U\"</input>").
	"</td><td class='doublecol'>".
	("<input type=\"button\" class=\"link\" onclick=\"JDel('{$data[4][$x]}', 'StartTime', 'tblEvents', 'vtest', '../view/FooterEventQueries.php') 
       \" value=\"D\"</input>") .
	"</td></tr>";
}
?>
</table>