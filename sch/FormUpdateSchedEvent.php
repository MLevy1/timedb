<?php
header("Cache-Control: no-cache, must-revalidate");
?>
<html>
<head>
<title>Update Sched Event</title>
<link rel="stylesheet" href="../../styles.css" />
</head>
<body>
<h1>Update Sched Event</h1>

<?php
include("../view/LinkTable.php");
include("../function/Functions.php");
?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<form action="../sch/UpdateSchedEvent.php" method="get">

<?php 
$selEvent = $_REQUEST["selEvent"];
?>

<div>

<?php
pconn();

$sql = "SELECT tblSchedEvents.SESTime, tblSchedEvents.SEActID, tblSchedEvents.SEContID, tblAct.ActDesc, tblCont.ContDesc FROM tblSchedEvents 
INNER JOIN tblCont ON (tblSchedEvents.SEContID= tblCont.ContID) INNER JOIN tblAct ON (tblSchedEvents.SEActID = tblAct.ActID) 
WHERE tblSchedEvents.SESTime='$selEvent'";

$result = mysqli_query($conn, $sql);

while ($row = $result->fetch_assoc()) {
	
	$defSTime = $row['SESTime'];
	$defActID = $row['SEActID'];
	$defActDesc = $row['ActDesc'];
	$defContID = $row['SEContID'];
}

$defDate = substr($defSTime, 0, 10);
$defTime = substr($defSTime, 11, 5);
$defSecs  = substr($defSTime, 17, 2);

$T1 =$defDate.'T'.$defTime;

mysqli_close($conn);
?>

<table>
<tr><td>
<input type=datetime-local name="newSTime" id="newSTime">
</td> <td>
<input type="submit">
</td> </tr><tr><td>
<?php 
selActiveAct('NselAct');
?>
</td><td>
<?php selActiveCont('NselCont'); ?>
</td></tr>
</table>

<h2>Dynamic</h2>
<?php include ("../view/btnCntSet.php"); ?>
<h2>Mobile</h2>
<?php include ("../view/btnSet.php"); ?>

<input type="hidden" name="TimeStamp" value='<?php echo $selEvent; ?>' ></input>

</form>

<script>
var val = "<?php echo $defActID ?>";
document.getElementById("NselAct").value=val;

var val2 = "<?php echo $defContID ?>";
document.getElementById("NselCont").value=val2;

var val3 = "<?php echo $T1 ?>";
document.getElementById("newSTime").value=val3;

function showSTime(){

	alert($('#newSTime').val()+':'+$('#sec').val());

}
</script>

</div>
</body>
</html>