<?php 
include("../function/password_protect.php");
include("../function/Functions.php"); 

$form = '../form/FormNewEvent.php';
?>
<html>
<head>
<title>Event</title>
<link rel="stylesheet" href="../css/MobileStyle.css" />
</head>
<body>
<h1>Event</h1>
<?php include("../view/LinkTable.php"); ?>

<form method='get' action='../add/AddEvent.php'>

<input type="hidden" name="form" value="<?php echo $form; ?>">

<table width=100%>

<?php
pconn();

$ContID = $_GET['selCont'];
$PU = $_GET['selPU'];

$sql = "SELECT * FROM tblAct WHERE PCode LIKE '%$PU%' AND Status != 'Inactive' ORDER BY ActDesc";

$result = mysqli_query($conn, $sql);

$data = array();
$data2 = array();

while ($row = mysqli_fetch_array($result)) {
	$data[] = $row['ActID'];
	$data2[] = $row['ActDesc'];
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
 		newbtn('selAct', $data[$btncounter], $data2 [$btncounter]);
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
		newbtn('selAct', $data[$btncounter], $data2 [$btncounter]);
		echo "</td>";
		$btncounter++;
	}
	echo "</tr>";
}
mysqli_close($conn);
?>

</table>

<input type="hidden" name="selCont" value='<?php echo $ContID; ?>'></input>

</form>
</body>
</html>