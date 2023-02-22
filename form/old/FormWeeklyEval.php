<?php 
header("Cache-Control: no-cache, must-revalidate");
include("password_protect.php"); 
?>
<html>
<head>
    <title>Weekly Eval</title>
    <link rel="stylesheet" href="MobileStyle.css" />
   <?php
function gradesel($selname){
echo "<select class='single' name=$selname>";
echo "<option>1</option>";
echo "<option>2</option>";
echo "<option>3</option>";
echo "</select>";
}

function goalsel($selname, $defgoalid, $defgoal){
include ('DBConn.php');

$sql="SELECT * FROM tblGoals WHERE Status = 'Open' ORDER BY Goal";
	
$result = $conn->query($sql);

echo "<select id=$selname class='selgoal' name=$selname>";

echo "<option value=$defgoalid>$defgoal</option>";

while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['GoalID'] . "'>" . $row['Goal'] . "</option>";
}
echo "</select>";

$conn->close();
}
?> 
</head>
<body>
<h1>Weekly Eval</h1>
<?php include('LinkTable.php'); ?>
<form method="post" action="AddWeeklyEval.php">
<table>
<tr><td>
<b>End Date (Fri): </b>
</td></tr><tr><td>
<input type="date" name="evaledate"><br>
</td></tr><tr><td>
<?php gradesel('gsel1'); ?>
</td></tr><tr><td>
<?php goalsel('wgoal1', 'WO.01', 'Complete Assigned Audit Work Timely and Accurately'); ?>
</td></tr><tr><td>
<textarea rows="5" cols="40" name="wevaltxt1"></textarea>
</td></tr><tr><td>
<?php gradesel('gsel2'); ?>
</td></tr><tr><td>
<?php goalsel('wgoal2', 'WO.05', 'Become more involved with management-level issues'); ?>
</td></tr><tr><td>
<textarea rows="5" cols="40" name="wevaltxt2"></textarea>
</td></tr><tr><td>
<?php gradesel('gsel3'); ?>
</td></tr><tr><td>
<?php goalsel('wgoal3', 'WO.07', 'Improve public presence and performance in meetings'); ?>
</td></tr><tr><td>
<textarea rows="5" cols="40" name="wevaltxt3"></textarea>
</td></tr><tr><td>
<?php gradesel('gsel4'); ?>
</td></tr><tr><td>
<?php goalsel('wgoal4', 'SO.03', 'Improve relationship with Alyssa'); ?>
</td></tr><tr><td>
<textarea rows="5" cols="40" name="wevaltxt4"></textarea>
</td></tr><tr><td>
<?php gradesel('gsel5'); ?>
</td></tr><tr><td>
<?php goalsel('wgoal5', 'SE.03', 'Diversify skill set away from finance and accounting'); ?>
</td></tr><tr><td>
<textarea rows="5" cols="40" name="wevaltxt5"></textarea>
</td></tr><tr><td>
<input type="submit" name="submit" />
</td></tr>
</table>
</form>
<h2>Delete Record</h2>
<?php
include("DBConn.php");

$sql = "SELECT * FROM tblWEvals ORDER BY weDate DESC";
$result = $conn->query($sql);

echo "<form method='post' action='DelWeeklyEval.php'>";
echo "<select name='selweDate'>";

while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['weDate'] . "'>" . $row['weDate'] . "</option>";
}
echo "</select>";

echo '<input type="submit" name="submit" />';

echo "</form>";

$conn->close();
?>
<hr />
<?php 
include("ViewDailyEvals.php");
include("ViewWeeklyEvals.php"); ?>
</body>
</html>
