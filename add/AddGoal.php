<?php 
include("../function/DBConn.php");

$GoalID = $_REQUEST["inpGoalID"];
$Goal = $_REQUEST["inpGoal"];

$sql = "INSERT INTO tblGoals (GoalID, Goal)
VALUES ('$GoalID', '$Goal')";

if ($conn->query($sql) === TRUE) {
	$conn->close();
	header ('Location: ../form/FormGoal.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    $conn->close();
}
?>