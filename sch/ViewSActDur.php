<?php header("Cache-Control: no-cache, must-revalidate"); ?>

<link rel="stylesheet" href="../../styles.css" />

<?php
include('../function/Functions.php');

pconn();

setQTime();

if($selDate==null){
$selDate = date('Y-m-d');
}

$data = array();

$sql = "SELECT tblSchedEvents.SESTime, tblAct.ActDesc, tblCont.ContDesc FROM tblSchedEvents
	INNER JOIN tblAct ON tblSchedEvents.SEActID = tblAct.ActID
    INNER JOIN tblCont ON tblSchedEvents.SEContID = tblCont.ContID WHERE date(tblSchedEvents.SESTime) ='$selDate' ORDER BY SEStime";

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
	$data[0][]  = $row['SESTime'];
	$data[1][]  = $row['ActDesc'];
	//$data[2][] = $row['ProID'];
}

$cnt = count ($data[0]);


for($x = 0; $x < ($cnt-1); $x++) {
	
	$data[3][] = getmins($data[0][$x], $data[0][$x+1]);
	
}

for($x = ($cnt-1); $x < $cnt; $x++) {
		
	$data[3][]=plastmins($data[0][$x], $selDate);
	
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