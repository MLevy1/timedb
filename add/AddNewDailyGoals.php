<?php
include("../function/DBConn.php");


if(isset($_GET['btn_submit'])){
	$btnfull = $_REQUEST['btn_submit'];

	$findme   = ' ';

	$pos = strpos($btnfull, $findme);

	$selGoal = substr($btnfull, 0, $pos);
	$selCont = substr($btnfull, ($pos+1));
}
else{
	$selGoal = $_REQUEST["selGoal"];
	$selCont = $_REQUEST["selCont"];
}

$GDate = $_REQUEST["GDate1"];

$sql = "INSERT INTO tblNewDailyGoals (GDate, Goal, ContID)
VALUES ('$GDate', '$selGoal', '$selCont')";

if ($conn->query($sql) === TRUE) {
	$conn->close();
	header ("Location: ../form/FormNewDailyGoals.php");
} else {
	$conn->close();
	echo "Error: " . $sql . "<br>" . $conn->error;
}

?>
