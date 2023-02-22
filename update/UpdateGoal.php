<?php
include("../function/DBConn.php");

$GoalID = $_POST["selGoalID"];
$Goal = $_POST["newGoal"];
$Status = $_POST["newStatus"];

$sql = "UPDATE tblGoals SET GoalID='$GoalID', Goal='$Goal', Status ='$Status' WHERE GoalID='$GoalID'";

$result = $conn->query($sql);

if ($conn->query($sql) === TRUE) {
	$conn->close();
	Header ("Location: ../form/FormAll.php");
} else {
	echo "Error updating record: " . $conn->error;
	$conn->close();
}
?>