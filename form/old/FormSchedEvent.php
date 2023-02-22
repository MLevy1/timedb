<?php 
header("Cache-Control: no-cache, must-revalidate");
include("../function/password_protect.php"); 
$selDate = $_GET["selDate"];
$selTime = $_GET["selTime"];
?>
<html>
<head>
<title>Schedule</title>
<link rel="stylesheet" href="../css/MobileStyle.css" />
</head>
<body>
<h1>Schedule</h1>
<?php  include("../view/LinkTable.php"); ?>
<?php $form = "FormSchedEvent.php";?>
<form action="../add/AddSchedEvent.php" method="get">
<table>
<tr><td>
<input name="selDate" type="date" value="<?php echo $selDate; ?>">
</td></tr><tr><td>
<input name="selTime" type="time" value="<?php echo $selTime; ?>">
</tr></td><tr><td>
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
<?php include ("../view/ViewSchedEvents.php"); ?>
</body>
</html>