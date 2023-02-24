<?php header("Cache-Control: no-cache, must-revalidate"); ?>

<link rel="stylesheet" href="../../styles.css" />
<?php

include('../function/Functions.php');

pconn();

date_default_timezone_set('America/New_York');
$QTime = date('Y-m-d');
$NowTime = date("Y-m-d H:i:s");

if($selDate==null){
$selDate = date('Y-m-d');
}

$sql = "SELECT tblSchedEvents.SESTime, tblProj.ProjDesc, tblCont.ContDesc FROM tblSchedEvents 
	INNER JOIN tblCont ON (tblSchedEvents.SEContID=tblCont.ContID) 
	INNER JOIN tblProj ON (tblCont.ProjID=tblProj.ProjID) 
	WHERE date(SEStime) ='$selDate' ORDER BY SEStime";

$result = mysqli_query($conn, $sql);

$arrSTime = array();
$arrProj = array();
$arrDur = array();
$arrHrs = array();
$arrMins = array();


while ($row = mysqli_fetch_array($result)) {
	$arrSTime[] = $row['SESTime'];
	$arrProj[] = $row['ProjDesc'];
}

$cnt=count ($arrSTime);

for($x = 0; $x < ($cnt-1); $x++) {
	$arrDur[] = getmins($arrSTime[$x], $arrSTime[$x+1]);
	
}

for($x = ($cnt-1); $x < $cnt; $x++) {
	$arrDur[]=plastmins($arrSTime[$x], $selDate);
	
}

?>
<table>
	<th>Proj</th>
	<th>Time</th>
<?php

$arrTest = array();

$clear = 'TRUNCATE TABLE tblTest';

mysqli_query($conn, $clear);

    $query = "INSERT INTO tblTest (`col1`, `col2`) VALUES ";

 	for($x=0; $x<($cnt); $x++){
 		$arrTest[] = "('" . $arrProj[$x] . "', '" . $arrDur[$x] . "')";
 }

 $sql = $query .= implode(',', $arrTest);

mysqli_query($conn, $sql);

$sumq = 'SELECT col1, SUM(col2) AS scol FROM tblTest WHERE col1!="Unassigned" GROUP BY col1 ORDER BY scol DESC';

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