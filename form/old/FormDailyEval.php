<?php 
header("Cache-Control: no-cache, must-revalidate");
include("../function/password_protect.php");
  ?>
<html>
<head>
	<title>Daily Eval Form</title>
	<link rel="stylesheet" href="../../styles.css" />
</head>
<body>
<h1>Daily Eval Form</h1>
<?php include('../view/LinkTable.php'); ?>
<form method="post" action="../add/AddDailyEval.php">
<table>
<tr><td>
	Date:
</td><td>
<?php
date_default_timezone_set('America/New_York');
$QDate = date('Y-m-d');

echo '<input type="date" name="EvalDate" value="$QDate">';
?>
</td></tr><tr><td>
	Mood:
</td><td>
	<select class='single' id='EMood' name='EMood'>
		<option value=1>1</option>
		<option value=0>0</option>
		<option value=-1>-1</option>
	</select>
</td></tr><tr><td>
	Grade:
</td><td>
	<select id='grade' class='single' name='grade'>
		<option value=12>A+</option>
		<option value=11>A</option>
		<option value=10>A-</option>
		<option value=9>B+</option>
		<option value=8>B</option>
		<option value=7>B-</option>
		<option value=6>C+</option>
		<option value=5>C</option>
		<option value=4>C-</option>
		<option value=3>D+</option>
		<option value=2>D</option>
		<option value=1>D-</option>
		<option value=0>F</option>
	</select>
</td></tr><tr><td>
	Immediate goal accomplished?
</td><td>
	<select id='iGoalA' class='single' name='iGoalA'>
		<option value=1>Y</option>
		<option value=0>N</option>
	</select>
</td></tr><tr><td>
	Sufficient progress on short-term goal?
</td><td>
	<select id='sGoalA' class='single' name='sGoalA'>
		<option value=1>Y</option>
		<option value=0>N</option>
	</select>
</td></tr><tr><td>
	Progress on stretch goal?
</td><td>
	<select id='lGoalA' class='single' name='lGoalA'>
		<option value=1>Y</option>
		<option value=0>N</option>
	</select>
</td></tr><tr><td>
	Positive 1:
</td><td>
	<textarea rows="5" cols="40" name="pos1"></textarea>
</td></tr><tr><td>
	Positive 2:
</td><td>
	<textarea rows="5" cols="40" name="pos2"></textarea>
</td></tr><tr><td>
	Positive 3:
</td><td>
	<textarea rows="5" cols="40" name="pos3"></textarea>
</td></tr><tr><td>
	Negative 1:
</td><td>
	<textarea rows="5" cols="40" name="neg1"></textarea>
</td></tr><tr><td>
	Negative 2:
</td><td>
	<textarea rows="5" cols="40" name="neg2"></textarea>
</td></tr><tr><td>
	Negative 3:
</td><td>
	<textarea rows="5" cols="40" name="neg3"></textarea>
</td></tr><tr><td>
	<input type="submit" name="submit" />
</td></tr>
</table>
</form>
<h2>Delete Record</h2>
<?php

include("../function/DBConn.php");

$sql = "SELECT * FROM tblDailyEvals ORDER BY DEDate DESC";
$result = $conn->query($sql);

echo "<form method='post' action='../del/DelDailyEval.php'>";
echo "<select name='selDEDate'>";

while($row = $result->fetch_assoc()) {
echo "<option value='" . $row['DEDate'] . "'>" . $row['DEDate'] . "</option>";
}
echo "</select>";

echo '<input type="submit" name="submit" />';

echo "</form>";

$conn->close();
echo "<hr />";
include("../view/ViewDailyGoalsP.php");
echo "<hr />";
include("../view/ViewDailyEvals.php");
?>
</body>
</html>
