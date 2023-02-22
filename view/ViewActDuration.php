<?php header("Cache-Control: no-cache, must-revalidate"); ?>

<link rel="stylesheet" href="../css/MobileStyle.css" />

<?php
include('../function/Functions.php');

pconn();

setQTime();

$data = array();

//MIDNIGHT FIX

$SDate0 = date( "Y-m-d", strtotime( "$QTime -1 day" ) );

//Pull last events from each selected day
$LSql = "SELECT DATE(STime) AS cDay, tblEvents.StartTime, tblEvents.STime, tblAct.ActDesc
FROM tblEvents 
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


while ($row = mysqli_fetch_array($result)) {
	
	$a = $row['cDay'];
	
	$b = date( "Y-m-d H:i", strtotime( "$a +1 day" ) );
	
	$data[0][] = $b;
	$data[1][] = $row['ActDesc'];
}

//END MIDNIGHT FIX

$sql = "SELECT tblEvents.StartTime, tblEvents.STime, tblAct.ActDesc, tblCont.ContDesc FROM tblEvents
	INNER JOIN tblAct ON tblEvents.ActID = tblAct.ActID
    INNER JOIN tblCont ON tblEvents.ProID = tblCont.ContID WHERE date(tblEvents.STime) ='$QTime' ORDER BY Stime";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
	$data[0][]  = $row['STime'];
	$data[1][]  = $row['ActDesc'];
	
}

$cnt = count ($data[0]);

$data[0][] = date_format(date_create($NowTime), 'Y-m-d h:i A');

for($x = 0; $x < ($cnt); $x++) {
	$data[3][] = getmins($data[0][$x], $data[0][$x+1]);
	$data[4][] = gethours($data[3][$x]);
	$data[5][] = getrmins($data[3][$x], $data[4][$x]);
}

?>
<table>
	<th>Activity</th>
	<th>Time</th>
<?php

$arrTest = array();

$clear = 'TRUNCATE TABLE tblTest';

mysqli_query($conn, $clear);

    $query = "INSERT INTO tblTest (`col1`, `col2`) VALUES ";

 	for($x=0; $x<($cnt); $x++){
 		$arrTest[] = "('" . $data[1][$x] . "', '" . $data[3][$x] . "')";
 }

$sql = $query .= implode(',', $arrTest);

mysqli_query($conn, $sql);

$sumq = 'SELECT col1, SUM(col2) AS scol FROM tblTest WHERE col1!="Untracked Time" GROUP BY col1 ORDER BY scol DESC';

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

mysqli_close($conn);
?>
</table>