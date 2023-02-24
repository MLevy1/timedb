<?php
header("Cache-Control: no-cache, must-revalidate");
include("../function/password_protect.php");
include("../function/Functions.php");
$selDate = $_GET["selDate"];
$selTime = $_GET["selTime"];
?>
<html>
<head>
<title>Schedule</title>
<link rel="stylesheet" href="../../styles.css" />
</head>
<body>
<h1>Schedule</h1>
<?php
include("../view/LinkTable.php");
$form = "FormSchedEventMobile.php";

if($selDate == Null){
$selDate = date('Y-m-d');
$selTime = date('H:i');
}

?>
<form action="../add/AddSchedEvent.php" method="get">
<table>
<tr><td>
<input name="selDate" type="date" value="<?php echo $selDate; ?>">
</td><td>
<input name="selTime" type="time" value="<?php echo $selTime; ?>">
</td><td>
<input type="button" class="link" onclick="location.href='../form/FormSchedEvent.php?selDate=<?php echo $selDate; ?>&selTime=<?php echo $selTime; ?>&form=<?php echo $form; ?>';" value="Manual" />
</td></tr>
</table>
<hr />
<?php 
include ("../view/btnSet.php");
?>
<hr />
<h1>Dynamic</h1>
<?php
include ("../view/btnCntSet.php");
?>
<h1>Manual</h1>
<!--
<form action="../add/AddSchedEvent.php" method="get">
-->
<table>
<!--
<tr><td>
<input name="selDate" type="date" value="<?php echo $selDate; ?>">
</td></tr><tr><td>
<input name="selTime" type="time" value="<?php echo $selTime; ?>">
</tr></td>
-->
<tr><td>
<?php
include("../function/DBConn.php");

$sql = "SELECT * FROM tblAct WHERE Status != 'Inactive' ORDER BY ActDesc";
$result = $conn->query($sql);

echo "<select id='selAct' name='selAct'>";

while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['ActID'] . "'>" . $row['ActDesc'] . "</option>";
}

echo "</select>";

$conn->close();
?>
</td></tr><tr><td>
<?php
include("../function/DBConn.php");

$sql = "SELECT tblCont.ContID, tblCont.ContDesc FROM tblCont, tblProj WHERE tblCont.ProjID = tblProj.ProjID AND tblProj.Projstatus != 'Closed' ORDER BY ContID";
$result = $conn->query($sql);

echo "<select id='selCont' name='selCont'>";

while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['ContID'] . "'>" . $row['ContID'] . " " . $row['ContDesc'] ."</option>";
}

echo "</select>";

$conn->close();
?>
</td></tr><tr><td>
<input type="submit">
<input type="hidden" name="form" value="<?php echo $form; ?>">
</td></tr>
</table>
</form>
<?php include("../view/ViewSchedEvents.php"); ?>
</body>
<script>
var val = "<?php echo $T1 ?>";
document.getElementById("selDT").value=val;

var val2 ="<?php echo $QTime ?>";
document.getElementById("selTime").value=val2;
</script>
</html>