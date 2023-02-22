<?php 
include("../function/Functions.php");
?>
<html>
<head>
<title>Event</title>
<link rel="stylesheet" href="../css/MobileStyle.css" />
</head>
<body>
<h1>Event</h1>
<?php include("../view/LinkTable.php"); ?>
<form method='get' action='FormNewEvent1.php'>
<table width='100%'>
<?php
pconn();

$sql = "SELECT DISTINCT tblAct.PCode, tblPUCodes.PUCodeDesc FROM tblAct INNER JOIN tblPUCodes ON tblAct.PCode=tblPUCodes.PUCode";

$result = mysqli_query($conn, $sql);

$data = array();
$data2 = array();

while ($row = mysqli_fetch_array($result)) {
	$data[] = $row['PCode'];
	$data2[] = $row['PUCodeDesc'];
}

$btncnt=count($data);

$rowcounter=1;

$btncounter=0;

$rowbtns=4;

$rownum=floor($btncnt/$rowbtns);

$lrowbtns=$btncnt%$rowbtns;

if($btncnt>=$rowbtns){
while ($rowcounter<=$rownum){
	echo "<tr>";
	$rowbtncounter=1;

	while ($rowbtncounter<=$rowbtns){
 		echo "<td>";
 		newbtn('selPU', $data[$btncounter], $data2 [$btncounter]);
 		echo "</td>";
 		$btncounter++;
		$rowbtncounter++;
	}
echo "</tr>";
$rowcounter++;
}
}
if ($lrowbtns!=0){
	echo "<tr>";
	for ($i = 0; $i < $lrowbtns; $i++) {
		echo "<td>";
		newbtn('selPU', $data[$btncounter], $data2 [$btncounter]);
		echo "</td>";
		$btncounter++;
	}
	echo "</tr>";
}
mysqli_close($conn);
?>
</table>
</form>
<?php include("../view/FooterEventQueries.php"); ?>
</body>
</html>