<?php header("Cache-Control: no-cache, must-revalidate"); ?>
<html>
<head>
<title>Update Goal</title>
<link rel="stylesheet" href="../css/MobileStyle.css" />

</head>
<body>
<h1>Update Goal</h1>
<?php
include("../view/LinkTable.php");
include("../function/Functions.php");
include("../function/DBConn.php");

$selGoal = $_REQUEST["selGoal"];

$sql = "SELECT * FROM tblGoals WHERE GoalID ='$selGoal'";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
	$defGoalID = $row['GoalID'];
	$defGoal = $row['Goal'];
	$defStatus = $row['Status'];
}
$conn->close();
?>
<form method="post" action="../update/UpdateGoal.php">
<table>
	<tr>
		<td>
Goal ID:
		</td><td>
<b><?php echo $defGoalID; ?>
<input type="hidden" name="selGoalID" value='<?php echo $defGoalID; ?>' ></input>
		</td>
	</tr><tr>
		<td>
Goal:
		</td><td>

<textarea rows="2" cols="40" id="newGoal" name="newGoal"><?php echo $defGoal; ?></textarea>


		</td>
	</tr><tr>	
		<td>
		Active:
		</td><td>
<select name="newStatus" id="newStatus">
<option>Open</option>
<option>Closed</option>
</select>
		</td>
	</tr><tr>
		<td>
<input type="submit">
		</td>
	</tr>
</form>
</table>

<script>
var val = "<?php echo $defStatus ?>";
document.getElementById("newStatus").value=val;
</script>

</body>
</html>