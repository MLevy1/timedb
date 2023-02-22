<link rel="stylesheet" href="../css/MobileStyle.css" />
<?php

include('../function/Functions.php');

pconn();

date_default_timezone_set('America/New_York');
$EQTime = date('Y-m-d');
$NowTime = date("Y-m-d H:i:s");

$SQTime = date_create(date('Y-m-d'));

date_modify($SQTime, '-7 days');

$SQTime = date_format($SQTime,'Y-m-d');

$sql = "SELECT tblEvents.STime, tblAct.ActDesc, tblEvents.ProID, tblAct.WklyHrs, tblAct.WklyMins, tblAct.ActID
FROM tblEvents
INNER JOIN tblAct 
ON (tblEvents.ActID=tblAct.ActID) WHERE date(STime) <='$EQTime' AND date(STime) >='$SQTime' ORDER BY Stime";

$result = mysqli_query($conn, $sql);

$arrSTime = array();
$arrAct = array();
$arrCont = array();
$arrWklyHrs = array();
$arrWklyMins = array();
$arrDur = array();
$arrHrs = array();
$arrMins = array();
$arrActID = array();

while ($row = mysqli_fetch_array($result)) {
	$arrSTime[] = $row['STime'];
	$arrActID[] = $row['ActID'];
	$arrAct[] = $row['ActDesc'];
	$arrCont[] = $row['ProID'];
	$arrWklyHrs[] = $row['WklyHrs'];
	$arrWklyMins[] = $row['WklyMins'];
}

$cnt=count ($arrSTime);

for($x = 0; $x < ($cnt-1); $x++) {
	$arrDur[] = getmins($arrSTime[$x], $arrSTime[$x+1]);
	$arrHrs[] = gethours($arrDur[$x]);
	$arrMins[] = getrmins($arrDur[$x], $arrHrs[$x]);
}

for($x = ($cnt-1); $x < $cnt; $x++) {
	$arrDur[]=lastmins($arrSTime[$x]);
	$arrHrs[] = gethours($arrDur[$x]);
	$arrMins[] = getrmins($arrDur[$x], $arrHrs[$x]);
}

?>
<h1>Weekly Activity Duration</h1>
<a href="../menu/MenuEventLists.htm">Events Menu</a>
<?php include("../view/LinkTable.php"); ?>
<table>
	<th class='longcol'>Activity</th>
	<th class='doublecol'>Actual</th>
	<th class='doublecol'>Planned</th>
	<th class='doublecol'>Variance</th>
<?php

$arrTest = array();

$clear = 'TRUNCATE TABLE tblTest';

mysqli_query($conn, $clear);

    $query = "INSERT INTO tblTest (`col1`, `col2`) VALUES ";

 	for($x=0; $x<($cnt); $x++){
 		$arrTest[] = "('" . $arrAct[$x] . "', '" . $arrDur[$x] . "')";
 }

 $sql = $query .= implode(',', $arrTest);

mysqli_query($conn, $sql);

$sumq = 'SELECT col1, tblAct.ActID, WklyHrs, WklyMins, SUM(col2) AS scol 
FROM tblTest 
INNER JOIN tblAct 
ON (tblTest.col1=tblAct.ActDesc) 
WHERE col1!="Untracked Time" 
GROUP BY col1 
ORDER BY scol DESC';

$col1 = array();
$col2 = array();
$WHr = array();
$WMn = array();
$WTMn = array();
$WRMn = array();
$WRT = array();
$colHr = array();
$colMn = array();

$result = mysqli_query($conn, $sumq);

while ($row = mysqli_fetch_array($result)) {
	$col1[] = $row['col1'];
	$col2[] = $row['scol'];
	$WHr[] = $row['WklyHrs'];
	$WMn[] = $row['WklyMins'];
	$arrActID2[] = $row['ActID'];
}

$cnt=count ($col1);

for($x = 0; $x < $cnt; $x++) {
	$WTMn[] = TMins($WMn[$x], $WHr[$x]);
	$WRMn[] = ABS($WTMn[$x]-$col2[$x]);
	$WRT[] = NegNum($col2[$x],$WTMn[$x]).
	DZero(gethours($WRMn[$x])).
	':'.
	DZero(getrmins($WRMn[$x], (gethours($WRMn[$x]))));
	$colHr[] = DZero(gethours($col2[$x])).
	':'.
	DZero(getrmins($col2[$x], (gethours($col2[$x]))));
	$colMn[] = DZero(gethours($WTMn[$x])).
	':'.
	DZero(getrmins($WTMn[$x], (gethours($WTMn[$x]))));
}

for($x = 0; $x < ($cnt); $x++) {
	echo "<tr><td class='xlcol'>".
	$col1[$x].
	"</td><td class='doublecol'>".
	$colHr[$x].
	"</td><td class='doublecol'>".
	$colMn[$x].
	"</td><td class='doublecol'>".
	$WRT[$x].
	"</td><td class='doublecol'>".
	("<input type=\"button\" class=\"link\" onclick=\"location.href='../form/FormUpdateAct1.php?selAct=$arrActID2[$x]'\" value=\"U\"</input>").
	"</td></tr>";
}

echo "</table>";

 mysqli_close($conn);
?>