<?php include("../function/password_protect.php"); ?>
<html>
<head>
<title>Event Form</title>
<link rel="stylesheet" href="../css/MobileStyle.css" />
</head>
<body>
<h1>Event Entry Form</h1>
<?php  include("../view/LinkTable.php"); ?>
<form action="../add/AddEvent.php" method="get">
<table>
<tr><td>
<?php
include("../function/DBConn.php");

$sql = "SELECT * FROM tblAct WHERE Status != 'Inactive' ORDER BY ActDesc";
$result = $conn->query($sql);

echo "<select id='selAct' name='selAct'>";

while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['ActID'] . "'>" . $row['ActID'] . " " . $row['ActDesc'] . "</option>";
}

echo "</select>";

$conn->close();
?>
</td></tr><tr><td>
<?php
include("../function/DBConn.php");

$sql = "SELECT tblCont.ContID, tblCont.ContDesc FROM tblCont, tblProj WHERE tblCont.ProjID = tblProj.ProjID AND tblProj.ProjStatus != 'Closed' ORDER BY ContID";
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
<input type="hidden" name="formcode" value="E">
</td></tr>
</table>
</form>
<?php include("../view/FooterEventQueries.php"); ?>
</body>
</html>
