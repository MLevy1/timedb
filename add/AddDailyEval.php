<?php

include ("../function/fixstring.php");

if(isset($_POST['grade'])){
	$EvalDate = $_POST['EvalDate'];
	$EMood = $_POST['EMood'];
	$grade = $_POST['grade'];
	$iGoalA = $_POST['iGoalA'];
	$sGoalA = $_POST['sGoalA'];
	$lGoalA = $_POST['lGoalA'];
	$pos1 = fixstr($_POST['pos1']);
	$pos2 = fixstr($_POST['pos2']);
	$pos3 = fixstr($_POST['pos3']);
	$neg1 = fixstr($_POST['neg1']);
	$neg2 = fixstr($_POST['neg2']);
	$neg3 = fixstr($_POST['neg3']);

	include("../function/DBConn.php");

	$sql = "INSERT INTO tblDailyEvals (DEDate, eMood, grade, iGoalAcc, sGoalAcc, lGoalAcc, Pos1, Pos2, Pos3, neg1, neg2, neg3)
	VALUES ('$EvalDate', '$EMood', '$grade', '$iGoalA', '$sGoalA', '$lGoalA', '$pos1', '$pos2', '$pos3', '$neg1', '$neg2', '$neg3')";

	if ($conn->query($sql) === TRUE) {
		$conn->close();
		header ("Location: ../form/FormDailyEval.php");
	} else {
		$conn->close();
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
?>
