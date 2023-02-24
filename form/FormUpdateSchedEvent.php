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
<form action="../update/UpdateEvent.php" method="get">

<?php 
$selEvent = $_REQUEST["selEvent"];
$form = $_REQUEST["form"];
$selQDate = $_REQUEST["selQDate"];
$selSDate = $_REQUEST["selSDate"];
$selEDate = $_REQUEST["selEDate"];
$selAct = $_REQUEST["selAct"];
$selCont= $_REQUEST["selCont"];

$selProj = $_REQUEST["selProj"];
$timecode = $_REQUEST["timecode"];
$selUCode = $_REQUEST["selUCode"];
?>

<div>

<?php
pconn();

$sql = "SELECT tblEvents.StartTime, tblEvents.STime, tblEvents.ProID, tblEvents.Details, tblAct.ActID, tblAct.ActDesc FROM tblEvents, tblAct WHERE StartTime='$selEvent' AND tblAct.ActID=tblEvents.ActID";

$result = mysqli_query($conn, $sql);

while ($row = $result->fetch_assoc()) {
	
	$defStartTime = $row['StartTime'];
	$defSTime = $row['STime'];
	$defActID = $row['ActID'];
	$defActDesc = $row['ActDesc'];
	$defContID = $row['ProID'];
	$defDetails = $row['Details']; 
}

$defDate = substr($defSTime, 0, 10);
$defTime = substr($defSTime, 11, 5);
$defSecs  = substr($defSTime, 17, 2);

$T1 =$defDate.'T'.$defTime;

mysqli_close($conn);
?>

<table>
<tr><td>
<b>ID
</td><td>
<b><?php echo $defStartTime; ?>
</td></tr><tr><td>
<b>Start Time:
</td><td>
<input type=datetime-local name="newSTime" id="newSTime">
</td><td>
<input id='sec' name='sec' size=4 value= <?php echo $defSecs; ?>>
</td></tr><tr><td>
<b> Activity:
</td><td>
<?php 
selActiveAct('NselAct');
?>
</td></tr><tr><td>
<b> Control:
</td><td>
<?php selActiveCont('NselCont'); ?>
</select>
</td></tr> <tr><td>
<b> Detail:
</td><td>
<input id='newDetails' name='newDetails' value='<?php echo $defDetails; ?>'></input>
</select>
</td></tr> <tr><td>
<input type="submit">
</td></tr>
</table>

<h2>Dynamic</h2>
<?php include ("../view/btnCntSet.php"); ?>
<h2>Mobile</h2>
<?php include ("../view/btnSet.php"); ?>

<input type="hidden" name="TimeStamp" value='<?php echo $selEvent; ?>' ></input>

<input type="hidden" name="selQDate" value="<?php echo $selQDate; ?>">

<input type="hidden" name="selEvent" value="<?php echo $selEvent; ?>">

<input type="hidden" name="form" value="<?php echo $form; ?>">

<input type="hidden" name="selSDate" value="<?php echo $selSDate; ?>">

<input type="hidden" name="selEDate" value="<?php echo $selEDate; ?>">

<input type="hidden" name="selAct" value="<?php echo $selAct; ?>">

<input type="hidden" name="selCont" value="<?php echo $selCont; ?>">

<input type="hidden" name="selAct1" value="<?php echo $selAct; ?>">

<input type="hidden" name="selCont1" value="<?php echo $selCont; ?>">

<input type="hidden" name="selProj" value="<?php echo $selProj; ?>">

<input type="hidden" name="timecode" value="<?php echo $timecode; ?>">

<input type="hidden" name="selUCode" value="<?php echo $selUCode; ?>">


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