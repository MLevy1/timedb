<?php
include("../function/fixstring.php");

if(isset($_POST['wevaltxt1'])){
	$evaledate = $_POST['evaledate'];
	$wevaltxt1 = fixstr($_POST['wevaltxt1']);
	$wevaltxt2 = fixstr($_POST['wevaltxt2']);
	$wevaltxt3 = fixstr($_POST['wevaltxt3']);
	$wevaltxt4 = fixstr($_POST['wevaltxt4']);
	$wevaltxt5 = fixstr($_POST['wevaltxt5']);
	$wgoal1 = $_POST['wgoal1'];
	$wgoal2 = $_POST['wgoal2'];
	$wgoal3 = $_POST['wgoal3'];
	$wgoal4 = $_POST['wgoal4'];
	$wgoal5 = $_POST['wgoal5'];
	$wgrade1 = $_POST['gsel1'];
	$wgrade2 = $_POST['gsel2'];
	$wgrade3 = $_POST['gsel3'];
	$wgrade4 = $_POST['gsel4'];
	$wgrade5 = $_POST['gsel5'];

	include("../function/DBConn.php");

	$sql = "INSERT INTO tblWEvals (weDate, weGoal1, weGoal1txt, weGoal2, weGoal2txt, weGoal3, weGoal3txt, weGoal4, weGoal4txt, weGoal5, weGoal5txt, weGrade1, weGrade2, weGrade3, weGrade4, weGrade5)
	VALUES ('$evaledate', '$wgoal1', '$wevaltxt1', '$wgoal2', '$wevaltxt2', '$wgoal3', '$wevaltxt3', '$wgoal4', '$wevaltxt4', '$wgoal5', '$wevaltxt5', '$wgrade1', '$wgrade2', '$wgrade3', '$wgrade4', '$wgrade5')";

	if ($conn->query($sql) === TRUE) {
		$conn->close();		
		include("../form/FormWeeklyEval.php");
		echo ("Weekly Eval Completed: ".date("Y-m-d H:i:s"));
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
		$conn->close();
	}
}
?>
