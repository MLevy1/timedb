<?php 
header("Cache-Control: no-cache, must-revalidate");
include("../function/password_protect.php");
include("../function/sqlSelect.php");
?>
<html>
<head>
    <title>Daily Goals</title>
        <link rel="stylesheet" href="../../styles.css" />
</head>
<body>
<h1>Daily Goals</h1>
<?php include('../view/LinkTable.php'); ?> 
<form method="post" action="../add/AddDailyGoals.php">
<table>
<tr><td>
Date:
</td><td>
<input type="date" name="GDate">
</td></tr><tr><td>
Mood:
</td><td>
<select class='single' id='SMood' name='SMood'>
<option value=1>1</option>
<option value=0>0</option>
<option value=-1>-1</option>
</select>
</td></tr><tr><td>
Immediate:
</td><td>
<textarea rows="5" cols="40" name="iGoal"></textarea>
</td></tr><tr><td>
Linked Goal (Immediate)
</td><td>
<?php
include ('../function/DBConn.php');

$sql="SELECT * FROM tblGoals WHERE Status = 'Open' ORDER BY Goal";
	
$result = $conn->query($sql);
?>

<select class='selgoal' id='seliGoal' name='seliGoal'>

<?php
while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['GoalID'] . "'>" . $row['Goal'] . "</option>";
}
$conn->close();
?>
</select>
</td></tr><tr><td>
Short-Term:
</td><td>
	<textarea rows="5" cols="40" name="stGoal"></textarea>
</td></tr><tr><td>
Linked Goal (Short)
</td><td>
<?php 
include ('../function/DBConn.php');

$sql="SELECT * FROM tblGoals WHERE Status = 'Open' ORDER BY Goal";
	
$result = $conn->query($sql);
?>
<select class='selgoal' id='selsGoal' name='selsGoal'>
<?php
while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['GoalID'] . "'>" . $row['Goal'] . "</option>";
}
$conn->close();
?>
</select>
</td></tr><tr><td>
	Stretch:
	</td><td>
	<textarea rows="5" cols="40" name="ltGoal"></textarea>
</td></tr><tr><td>
Linked Goal (Long)
</td><td>
<?php
include ('../function/DBConn.php');

$sql="SELECT * FROM tblGoals WHERE Status = 'Open' ORDER BY Goal";
	
$result = $conn->query($sql);
?>

<select class='selgoal' id='sellGoal' name='sellGoal'>

<?php
while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['GoalID'] . "'>" . $row['Goal'] . "</option>";
}
$conn->close();
?>
</select>
</td></tr><tr><td>
	<input type="submit" name="submit" />
	</td></tr>
</table>
</form>
<hr />
<h2>Delete Record</h2>
<?php
include("../function/DBConn.php");

$sql = "SELECT * FROM tblDailyGoals ORDER BY GDate DESC";
$result = $conn->query($sql);
?>

<form method='post' action='../del/DelDailyGoals.php'>
<select name='selGDate'>

<?php
while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['GDate'] . "'>" . $row['GDate'] . "</option>";
}
$conn->close();
?>
</select>
<input type="submit" name="submit" />
</form>
<hr />
<?php include("../view/ViewDailyGoals.php"); ?>
</body>
</html>
