<?php
include("../function/DBConn.php");

$Grade = $_GET["Grade"];
$selGoal = $_GET["selGoal"];

$sql = "UPDATE tblNewDailyGoals SET Result='$Grade' WHERE GoalIndex='$selGoal'";

$result = $conn->query($sql);

if ($conn->query($sql) === TRUE) {
	$conn->close();
	Header ("Location: ../form/FormDailyGoalsJQ.php");
} else {
	echo "Error updating record: " . $conn->error;
	$conn->close();
}
?>