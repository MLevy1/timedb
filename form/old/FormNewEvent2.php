<?php 
include("../function/password_protect.php");
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
<form method='get' action='FormNewEvent3.php'>
<table width='100%'>
<?php
pconn();

$ProjID = $_GET['selProj'];
$PU = $_GET['selPU'];

$sql = "SELECT * FROM tblCont WHERE ProjID = '$ProjID' AND Active!='N' ORDER BY ContDesc";

$result = mysqli_query($conn, $sql);

$data = array();
$data2 = array();

while ($row = mysqli_fetch_array($result)) {
	$data[] = $row['ContID'];
	$data2[] = $row['ContDesc'];
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
 		newbtn('selCont', $data[$btncounter], $data2 [$btncounter]);
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
		newbtn('selCont', $data[$btncounter], $data2 [$btncounter]);
		echo "</td>";
		$btncounter++;
	}
	echo "</tr>";
}

mysqli_close($conn);
?>
</table>
<input type="hidden" name="selPU" value='<?php echo $PU; ?>'></input>
</form>
</body>
</html>