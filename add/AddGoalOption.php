<?php 
include("../function/DBConn.php");

$Goal = $_REQUEST["inpGoal"];
$selGoal = $_REQUEST["selGoal"];

$sql = "INSERT INTO tblGoalOptions (Goal, OGoal)
VALUES ('$Goal', '$selGoal')";

if ($conn->query($sql) === TRUE) {
	$conn->close();
	header ('Location: ../form/FormDailyGoalsJQ.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    $conn->close();
}
?>