<?php
header("Cache-Control: no-cache, must-revalidate");
include("../function/password_protect.php");
include("../function/Functions.php");
formid();
?>
<html>
<head>
	<title>Social</title>
	<link rel="stylesheet" href="../css/MobileStyle.css" />
</head>
<h1>Social</h1>
<?php include("../view/LinkTable.php"); ?>
<form action="../add/AddEvent.php" method="get">

<?php
pconn();

$sql="SELECT * FROM tblAct WHERE PCode LIKE  '%S%' ORDER BY ActDesc";

$result = mysqli_query($conn, $sql);
?>

<select name='selAct'>
<option value='S01'>Social</option>

<?php
while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['ActID'] . "'>" . $row['ActDesc'] . "</option>";
}
mysqli_close($conn);
?>
</select>
<hr />

<table width=100%>

<?php
pconn();

$sql = "SELECT * FROM tblCont INNER JOIN tblProj ON tblCont.ProjID = tblProj.ProjID WHERE ProjStatus != 'Closed' 
AND PCode = 'S' 
AND Active != 'N'
ORDER BY tblCont.ContDesc";

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

<input type="hidden" name="form" value="<?php echo $form; ?>">
<?php include("../view/FooterEventQueries.php"); ?>
</body>
</html>