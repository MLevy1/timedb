<?php header("Cache-Control: no-cache, must-revalidate"); ?>

<link rel="stylesheet" href="../../styles.css" />
<?php

include('../function/Functions.php');

pconn();

date_default_timezone_set('America/New_York');
$QTime = date('Y-m-d');
$NowTime = date("Y-m-d H:i:s");

$SDate = date_create('2018-12-02');
$SDate = date_format($SDate,"Y-m-d");

$sql = "SELECT tblEvents.STime, tblAct.ActDesc, tblCont.ContDesc, tblProj.ProjID
FROM tblEvents 
INNER JOIN tblCont 
ON (tblEvents.ProID=tblCont.ContID) 
INNER JOIN tblProj
ON (tblCont.ProjID=tblProj.ProjID)
INNER JOIN tblAct 
ON (tblEvents.ActID=tblAct.ActID) 
AND tblCont.Active!='N' 
AND tblEvents.STime >= '$SDate'
ORDER BY Stime";

$result = mysqli_query($conn, $sql);

$arrSTime = array();
$arrAct = array();
$arrCont = array();
$arrDur = array();
$arrHrs = array();
$arrMins = array();
$arrProjID = array();

while ($row = mysqli_fetch_array($result)) {
	$arrSTime[] = $row['STime'];
	$arrAct[] = $row['ActDesc'];
	$arrCont[] = $row['ContDesc'];
	$arrProjID[] = $row['ProjID'];
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
<table>
	<th>Cont</th>
	<th>Time</th>
<?php

$arrTest = array();

$clear = 'TRUNCATE TABLE tblTest2';

mysqli_query($conn, $clear);

    $query = "INSERT INTO tblTest2 (`col1`, `col2`, `col3`) VALUES ";

 	for($x=0; $x<($cnt); $x++){
 		$arrTest[] = "('" . $arrCont[$x] . "', '" . $arrDur[$x] . "', '" . $arrProjID[$x] ."')";
 }

 $sql = $query .= implode(',', $arrTest);

mysqli_query($conn, $sql);

$sumq = 'SELECT col1, SUM(col2) AS scol FROM tblTest2 WHERE col3 = "CFA" GROUP BY col1 ORDER BY scol DESC';

$col1 = array();
$col2 = array();
$colHr = array();
$colMn = array();

$result = mysqli_query($conn, $sumq);

while ($row = mysqli_fetch_array($result)) {
	$col1[] = $row['col1'];
	$col2[] = $row['scol'];
}

$cnt=count ($col1);

for($x = 0; $x < $cnt; $x++) {
	$colHr[] = gethours($col2[$x]);
	$colMn[] = getrmins($col2[$x], $colHr[$x]);
}


for($x = 0; $x < ($cnt); $x++) {
	echo "<tr><td class='xlcol'>".$col1[$x]."</td><td class='doublecol'>".DZero($colHr[$x]).":".DZero($colMn[$x])."</td></tr>";
}

echo "</table>";

 mysqli_close($conn);
?>
