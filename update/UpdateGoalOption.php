<?php
include("../function/DBConn.php");

$GoalID = $_POST["selGoalID"];
$Goal = $_POST["newGoal"];
$Active = $_POST["newActive"];
$OGoal = $_POST["newOGoal"];

$sql = "UPDATE tblGoalOptions SET GoalID='$GoalID', Goal='$Goal', Active ='$Active', OGoal='$OGoal' WHERE GoalID='$GoalID'";

$result = $conn->query($sql);

if ($conn->query($sql) === TRUE) {
	$conn->close();
	Header ("Location: ../form/FormAll.php");
} else {
	echo "Error updating record: " . $conn->error;
	$conn->close();
}
?>