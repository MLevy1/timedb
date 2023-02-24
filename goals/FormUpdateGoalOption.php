<?php header("Cache-Control: no-cache, must-revalidate"); ?>
<html>
<head>
<title>Update Goal Option</title>
<link rel="stylesheet" href="../../styles.css" />

</head>
<body>
<h1>Update Goal Option</h1>
<?php
include("../view/LinkTable.php");
include("../function/Functions.php");
include("../function/DBConn.php");

$selGO = $_REQUEST["selGO"];

//$sql = "SELECT * FROM tblGoalOptions WHERE GoalID ='$selGO'";

$sql = "SELECT tblGoalOptions.GoalID AS GoalID1, tblGoalOptions.Goal AS Goal1, tblGoalOptions.Category, tblGoals.Goal AS Goal2, tblGoals.GoalID AS GoalID2, tblGoalOptions.Active FROM tblGoalOptions LEFT JOIN tblGoals ON tblGoalOptions.OGoal=tblGoals.GoalID WHERE tblGoalOptions.GoalID ='$selGO'";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
	$defGoalID = $row['GoalID1'];
	$defGoal = $row['Goal1'];
	$defOGoal = $row['GoalID2']; 
	$defActive = $row['Active'];
}
$conn->close();
?>
<form method="post" action="../update/UpdateGoalOption.php">
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
<input name="newGoal" value= '<?php echo $defGoal; ?>' ></input>
		</td>
	</tr><tr>	
		<td>
		Active:
		</td><td>
<select name="newActive" id="newActive">
<option>Y</option>
<option>N</option>
</select>
		</td>
	</tr><tr>	
		<td>
		OGoal:
		</td><td>
		<?php addsel2('newOGoal', 'GoalID', 'Goal', 'tblGoals'); ?>
		</td>
	</tr><tr>
		<td>
<input type="submit">
		</td>
	</tr>
</form>
</table>

<script>
var val = "<?php echo $defActive ?>";
document.getElementById("newActive").value=val;

var val = "<?php echo $defOGoal ?>";
document.getElementById("newOGoal").value=val;
</script>

</body>
</html>